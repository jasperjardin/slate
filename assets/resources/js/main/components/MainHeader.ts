import { isMobileViewport, isTouchDevice } from '@globals/utils/functions';
import TrapFocus from '@globals/utils/TrapFocus';

class MainHeader {
	header: HTMLDivElement | null;
	headerNav: HTMLDivElement | null;
	megaMenuItems: NodeListOf<Element> | null;
	megaMenuBackBtns: NodeListOf<HTMLButtonElement>;
	mobileMenuTrigger: HTMLButtonElement | null;
	adminBar: HTMLElement | null;
	isMobile: boolean;
	isTouch: boolean;
	breakpoints: IBreakpoints | undefined;
	focusableSelectors: string[];
	openMenuTimers: Map<HTMLElement, number> = new Map();
	closeMenuTimers: Map<HTMLElement, number> = new Map();
	trapFocusInstance: TrapFocus | null = null;

	constructor() {
		this.header = document.querySelector<HTMLDivElement>('.main-header');
		this.headerNav = this.header?.querySelector<HTMLDivElement>('.main-header__nav') || null;
		this.adminBar = document.getElementById('wpadminbar');
		this.megaMenuItems =
			this.headerNav?.querySelectorAll(
				'.header-nav-menu__nav-item--has-mm-dropdown, .header-nav-menu__nav-item--has-dropdown'
			) || null;
		this.megaMenuBackBtns = document.querySelectorAll<HTMLButtonElement>(
			'button[data-mega-menu-back]'
		);
		this.mobileMenuTrigger = document.querySelector<HTMLButtonElement>('.mobile-menu-trigger');
		this.breakpoints = window.impBreakpoints;
		this.isMobile = false;
		this.isTouch = false;
		this.focusableSelectors = [
			'a[href]:not([tabindex="-1"])',
			'button:not([disabled]):not([tabindex="-1"])',
			'input:not([disabled]):not([tabindex="-1"])',
			'select:not([disabled]):not([tabindex="-1"])',
			'textarea:not([disabled]):not([tabindex="-1"])',
			'[tabindex]:not([tabindex="-1"])',
		];
	}

	init() {
		this.setHeaderHeight();

		if (this.megaMenuItems) {
			this.megaMenuItems.forEach((item) => {
				item.addEventListener(
					'mouseenter',
					this.handleMouseEnter.bind(this) as EventListener
				);
				item.addEventListener(
					'mouseleave',
					this.handleMouseLeave.bind(this) as EventListener
				);
				item.querySelector('a')?.addEventListener(
					'click',
					this.handleMegaMenuClick.bind(this)
				);
			});
		}

		// Add focus handling for keyboard navigation
		const megaMenuLinks =
			this.headerNav?.querySelectorAll(
				'.header-nav-menu__nav-item > a, .mm-dropdown-items__item > a, .mm-dropdown-items__nav-link'
			) || null;
		if (megaMenuLinks) {
			megaMenuLinks.forEach((item) => {
				item.addEventListener('focusin', this.handleMouseEnter.bind(this) as EventListener);
				item.addEventListener('focusout', (e: Event) => {
					const focusEvent = e as FocusEvent;
					const parentItem = item.closest(
						'.header-nav-menu__nav-item--has-dropdown, .header-nav-menu__nav-item--has-mm-dropdown'
					);

					if (parentItem) {
						if (!parentItem.contains(focusEvent.relatedTarget as HTMLElement)) {
							this.handleMouseLeave(e as unknown as MouseEvent);
						}
					}
				});
			});
		}

		if (this.mobileMenuTrigger) {
			this.mobileMenuTrigger.addEventListener('click', this.handleMobileMenuClick.bind(this));
		}

		this.megaMenuBackBtns.forEach((item) => {
			item.addEventListener('click', this.handleBackBtnClick.bind(this));
		});

		if (this.breakpoints) {
			this.isMobile = isMobileViewport(this.breakpoints);
		}
		this.isTouch = isTouchDevice();
	}

	resized() {
		this.setHeaderHeight();
		if (this.breakpoints) {
			this.isMobile = isMobileViewport(this.breakpoints);
		}
		this.isTouch = isTouchDevice();
	}

	loaded() {
		this.setHeaderHeight();
		if (this.breakpoints) {
			this.isMobile = isMobileViewport(this.breakpoints);
		}
		this.isTouch = isTouchDevice();
	}

	handleMobileMenuClick() {
		if (this.isMobile) {
			if (!document.body.classList.contains('mobile-menu-open')) {
				document.body.classList.add('mobile-menu-open');
				document.body.classList.remove('mobile-mm-open');
				this.handleBackBtnClick();
				this.trapMobileMenu();
			} else {
				document.body.classList.remove('mobile-menu-open');
				document.body.classList.remove('mobile-mm-open');
				this.megaMenuBackBtns.forEach((btn) => {
					btn.classList.remove('is-open');
				});

				// Restore tabindex for the top level items.
				this.megaMenuItems?.forEach((item) => {
					const link = item.querySelector('a');
					if (link) {
						const prevTabindex = link.getAttribute('data-prev-tabindex');
						if (prevTabindex) {
							link.setAttribute('tabindex', prevTabindex);
						} else {
							link.removeAttribute('tabindex');
						}
					}
				});
			}
		}
	}

	trapMobileMenu() {
		if (!this.headerNav || !this.mobileMenuTrigger || !this.header) return;

		// Get focusable elements, add the mobile menu trigger to the top.
		const focusableElements = Array.from(
			this.headerNav.querySelectorAll(this.focusableSelectors.join(','))
		) as HTMLElement[];
		focusableElements.unshift(this.mobileMenuTrigger);

		// Remove any existing trap focus
		this.removeTrapFocus();

		// Activate trap focus for top level menu.
		this.trapFocusInstance = new TrapFocus(
			this.header,
			focusableElements,
			() => this.handleMobileMenuClick(),
			this.mobileMenuTrigger
		);
	}

	trapMegaMenu(megaMenuContainer: HTMLElement, triggerElement: HTMLElement) {
		if (!this.header || !this.mobileMenuTrigger) return;

		// Get focusable elements.
		const focusableElements = Array.from(
			megaMenuContainer.querySelectorAll(this.focusableSelectors.join(','))
		) as HTMLElement[];

		// Add the mobile menu trigger to the top.
		focusableElements.unshift(this.mobileMenuTrigger);

		// Disable focus for the mega menu triggers
		this.megaMenuItems?.forEach((item) => {
			const link = item.querySelector('a');
			if (link) {
				const prevTabindex = link.getAttribute('data-prev-tabindex');
				if (prevTabindex) {
					link.setAttribute('data-prev-tabindex', prevTabindex);
				} else {
					link.setAttribute('tabindex', '-1');
				}
			}
		});

		// Remove any existing trap focus
		this.removeTrapFocus();

		// Activate trap focus for mega menu.
		this.trapFocusInstance = new TrapFocus(
			this.header,
			focusableElements,
			() => {
				// Close the entire mobile menu on escape, not just the mega menu
				this.handleMobileMenuClick();
			},
			this.mobileMenuTrigger
		);
	}

	removeTrapFocus() {
		if (this.trapFocusInstance) {
			this.trapFocusInstance.deactivate();
			this.trapFocusInstance = null;
		}
	}

	handleBackBtnClick() {
		const activeMegaMenu = document.querySelector<HTMLDivElement>(
			'.header-nav-menu__nav-item.active'
		);

		if (null !== activeMegaMenu) {
			activeMegaMenu.classList.remove('active');
			this.closeMobileMegaMenu(activeMegaMenu);
		}
	}

	handleMouseEnter(event: MouseEvent) {
		if (this.isMobile) return;

		let target = event.currentTarget as HTMLElement;

		if (
			(event.type === 'focusin' &&
				target.tagName === 'A' &&
				target.parentElement?.classList.contains(
					'header-nav-menu__nav-item--has-dropdown'
				)) ||
			target.parentElement?.classList.contains('header-nav-menu__nav-item--has-mm-dropdown')
		) {
			target = target.parentElement;
		}

		if (target.classList.contains('header-nav-menu__nav-item')) {
			// If there's a close timer set, user is coming back in – clear that so it won't close.
			const existingCloseTimer = this.closeMenuTimers.get(target);
			if (existingCloseTimer) {
				clearTimeout(existingCloseTimer);
				this.closeMenuTimers.delete(target);
			}

			// If the menu is already open, do nothing.
			const isAlreadyOpen = !!target.querySelector<HTMLElement>(
				'.header-nav-menu__nav-link.is-open'
			);
			if (isAlreadyOpen) return;

			// Start an open timer to ensure enter intent.
			const openTimerId = window.setTimeout(() => {
				document.body.classList.add('dropdown-open');
				this.openMegaMenu(target);
				this.openMenuTimers.delete(target);
			}, 200);

			this.openMenuTimers.set(target, openTimerId);
		}
	}

	handleMouseLeave(event: MouseEvent) {
		if (this.isMobile) return;

		let target = event.currentTarget as HTMLElement;
		if (
			event.type === 'focusout' &&
			target.tagName === 'A' &&
			target.closest(
				'.header-nav-menu__nav-item--has-dropdown, .header-nav-menu__nav-item--has-mm-dropdown'
			)
		) {
			target = target.closest(
				'.header-nav-menu__nav-item--has-dropdown, .header-nav-menu__nav-item--has-mm-dropdown'
			) as HTMLElement;
		}

		if (target.classList.contains('header-nav-menu__nav-item')) {
			// If there's an open timer running, it means the user left before it opened – clear it.
			const openTimerId = this.openMenuTimers.get(target);
			if (openTimerId) {
				clearTimeout(openTimerId);
				this.openMenuTimers.delete(target);
			}

			// Start a close timer to ensure leave intent.
			const closeTimerId = window.setTimeout(() => {
				document.body.classList.remove('dropdown-open');
				this.closeMegaMenu(target);
				this.closeMenuTimers.delete(target);
			}, 200);

			this.closeMenuTimers.set(target, closeTimerId);
		}
	}

	openMegaMenu(target: HTMLElement) {
		if (this.isMobile) return;

		const megaMenu = target.querySelector<HTMLDivElement>(
			'.mm-dropdown, .header-nav-menu__dropdown'
		);
		const navLink = target.querySelector<HTMLAnchorElement>('.header-nav-menu__nav-link');
		if (megaMenu) {
			if (megaMenu && navLink) {
				navLink.classList.add('is-open');
				megaMenu.classList.add('is-open');
			}
		}
	}

	closeMegaMenu(target: HTMLElement) {
		if (this.isMobile) return;

		const megaMenu = target.querySelector<HTMLDivElement>(
			'.mm-dropdown, .header-nav-menu__dropdown'
		);
		const navLink = target.querySelector<HTMLAnchorElement>('.header-nav-menu__nav-link');
		if (megaMenu && navLink) {
			navLink.classList.remove('is-open');
			megaMenu.classList.remove('is-open');
		}
	}

	handleMegaMenuClick(event: MouseEvent) {
		const target = event.currentTarget as HTMLAnchorElement;
		const parent = target.parentElement as HTMLDivElement;
		if (!parent) return;

		if (this.isMobile) {
			// Mobile behavior - prevent default for dropdown items
			event.preventDefault();
			if (parent.classList.contains('active')) {
				parent.classList.remove('active');
				this.closeMobileMegaMenu(target, true);
			} else {
				parent.classList.add('active');
				this.openMobileMegaMenu(target, true);

				const dropdown = parent.querySelector<HTMLElement>(
					'.mm-dropdown, .header-nav-menu__dropdown'
				);

				if (dropdown) {
					this.trapMegaMenu(dropdown, target);
				}
			}
		} else if (this.isTouch) {
			// Touch device on desktop/tablet
			if (target.classList.contains('is-open')) {
				// Close menu
				event.preventDefault();
				this.closeMegaMenu(parent);
			} else {
				// Close all other open menus
				const openMenuItems = document.querySelectorAll<HTMLAnchorElement>(
					'.header-nav-menu__nav-link.is-open'
				);

				openMenuItems.forEach((openMenuItem) => {
					if (openMenuItem.parentElement && openMenuItem.parentElement !== parent) {
						this.closeMegaMenu(openMenuItem.parentElement);
					}
				});

				// Open Menu
				event.preventDefault();
				this.openMegaMenu(parent);
			}
		}
	}

	openMobileMegaMenu(item: HTMLAnchorElement | HTMLDivElement, isLink = false) {
		const li = isLink ? item.parentElement : item;
		if (!li) return;
		const megaMenu = li.querySelector<HTMLDivElement>(
			'.mm-dropdown, .header-nav-menu__dropdown'
		);
		if (megaMenu) {
			megaMenu.classList.add('active');
			document.body.classList.add('mobile-mm-open');
			this.megaMenuBackBtns.forEach((btn) => {
				btn.classList.add('is-open');
			});
		}
	}

	closeMobileMegaMenu(item: HTMLAnchorElement | HTMLDivElement, isLink = false) {
		const li = isLink ? item.parentElement : item;
		if (!li) return;
		const megaMenu = li.querySelector<HTMLDivElement>(
			'.mm-dropdown, .header-nav-menu__dropdown'
		);
		if (megaMenu) {
			document.body.classList.add('mm-closing');
			megaMenu.classList.add('is-closing');
			megaMenu.classList.remove('active');
			this.megaMenuBackBtns.forEach((btn) => {
				btn.classList.remove('is-open');
			});
			document.body.classList.remove('mobile-mm-open');

			setTimeout(() => {
				document.body.classList.remove('mm-closing');
				megaMenu.classList.remove('is-closing');
			}, 300);
		}
	}

	setHeaderHeight() {
		if (!this.header) return;

		const headerHeight = this.header.offsetHeight;
		let headerHeightFull = this.header.offsetHeight;

		if (null !== this.adminBar) {
			headerHeightFull += this.adminBar.offsetHeight;
		}

		document.documentElement.style.setProperty('--vh', `${window.innerHeight * 0.01}px`);
		document.documentElement.style.setProperty('--headerHeight', headerHeight + 'px');
		document.documentElement.style.setProperty('--headerHeightFull', headerHeightFull + 'px');
	}
}

export default new MainHeader();
