import { slideDown, slideUp } from '@globals/utils/functions';

/**
 * Class Tabs
 *
 * Handles all accordion and tab functionality as all tabs are accordions on mobile.
 */
class Tabs {
	transition: number;
	accordionTriggers: NodeListOf<HTMLElement>;
	tabTriggers: NodeListOf<HTMLElement>;
	tabsBlock: HTMLElement;
	isAccordion: boolean;
	isDesktop: boolean;
	lastDesktopState: boolean | null;

	constructor(element: HTMLElement) {
		this.tabsBlock = element;
		this.isAccordion = this.tabsBlock.classList.contains('block-tabs--accordion');
		this.accordionTriggers = this.tabsBlock.querySelectorAll('.block-tab__top');
		this.tabTriggers = this.tabsBlock.querySelectorAll('.block-tabs__tab');
		this.transition = 400;
		this.isDesktop = this.checkDesktopState();
		this.lastDesktopState = null;

		this.accordionTriggers.forEach((trigger) => {
			trigger.addEventListener('click', this.handleBellowClick.bind(this));
		});

		this.tabTriggers.forEach((trigger) => {
			trigger.addEventListener('click', this.handleTabClick.bind(this));
			trigger.addEventListener('keydown', this.handleKeyDown.bind(this));
		});

		this.handleResize();
		window.addEventListener('resize', this.handleResize.bind(this), { passive: true });
	}

	checkDesktopState() {
		return window.matchMedia(`(min-width: ${window.impBreakpoints?.md}px)`).matches;
	}

	handleResize() {
		if (this.isAccordion) {
			return;
		}

		const newDesktopState = this.checkDesktopState();

		// Only proceed if the desktop state has changed
		if (newDesktopState === this.lastDesktopState) {
			return;
		}

		this.isDesktop = newDesktopState;
		this.lastDesktopState = newDesktopState;

		if (this.isDesktop) {
			this.setDefaultOpen();

			this.accordionTriggers.forEach((accordionTrigger, index) => {
				const panel =
					accordionTrigger.parentElement?.querySelector('.block-tab__collapsable');

				if (!panel) {
					return;
				}

				// Replace labeledby from accordion-trigger to tab-trigger's id.
				if (this.tabTriggers[index]) {
					panel.setAttribute('aria-labelledby', this.tabTriggers[index].id);
				}

				// Swap roles from accordion to tabpanel.
				panel.setAttribute('role', 'tabpanel');
				panel.setAttribute('tabindex', '0');
			});
		} else {
			this.accordionTriggers.forEach((accordionTrigger) => {
				const panel =
					accordionTrigger.parentElement?.querySelector('.block-tab__collapsable');
				if (panel) {
					// Replace labeledby from tab-trigger to accordion-trigger's id.
					panel.setAttribute('aria-labelledby', accordionTrigger.id);

					// Swap roles from tabpanel to accordion.
					panel.setAttribute('role', 'region');
					panel.removeAttribute('tabindex');
				}
			});
		}
	}

	/**
	 * Setup tabs if one tab is not set to be open by default.
	 */
	setDefaultOpen() {
		if (!this.isDesktop) {
			return;
		}

		let hasExpanded = 0;

		this.accordionTriggers.forEach((trigger, index) => {
			if (trigger.closest('.block-tab')?.classList.contains('block-tab--expanded')) {
				hasExpanded = index;
			}
		});

		if (this.accordionTriggers[hasExpanded] && this.tabTriggers[hasExpanded]) {
			this.expandTab(this.accordionTriggers[hasExpanded], this.tabTriggers[hasExpanded]);
		}
	}

	/**
	 * Scroll into view
	 *
	 * @param {HTMLElement} element    Element to scroll into view
	 * @param {string}      type       Type of element
	 * @param {boolean}     focusClass Focus class
	 */
	scrollIntoView(element: HTMLElement, type: 'tab' | 'accordion', focusClass = false) {
		let targetElement = element;

		targetElement.focus();
		targetElement.scrollIntoView({
			block: 'center',
			behavior: 'smooth',
		});

		if (focusClass) {
			let targetTrigger = element;
			let targetContent = null;

			if (type === 'tab') {
				targetElement = this.tabsBlock;
				const targetTriggerID = element.getAttribute('id');

				if (targetTriggerID) {
					targetTrigger = this.tabsBlock?.querySelector<HTMLElement>(
						`#tab-${targetTriggerID}`
					) as HTMLElement;

					targetContent = this.tabsBlock?.querySelector<HTMLElement>(
						`#panel-${targetTriggerID}`
					) as HTMLElement;
				}
			}

			// remove sibling classes block-tabs__tab--focused.
			this.tabTriggers.forEach((trigger) => {
				if (trigger !== element) {
					let triggerID = trigger.getAttribute('id');

					if (triggerID) {
						triggerID = triggerID?.replace('tab-', '');
						const triggerContent = this.tabsBlock?.querySelector<HTMLElement>(
							`#panel-${triggerID}`
						) as HTMLElement;

						if (triggerContent) {
							triggerContent.classList.remove('block-tab--focused');
							triggerContent.setAttribute('aria-selected', 'false');
						}
						trigger.classList.remove('block-tabs__tab--focused');
						trigger.setAttribute('aria-selected', 'false');
					}
				}
			});

			if (targetContent) {
				targetTrigger.classList.add('block-tabs__tab--focused');
				targetTrigger.setAttribute('aria-selected', 'true');
				targetContent.classList.add('block-tab--focused');
				targetContent.setAttribute('aria-selected', 'true');
			}
		}
	}

	/**
	 * Handle bellow click
	 *
	 * @param {Event} event
	 */
	handleBellowClick(event: Event) {
		const target = event.currentTarget as HTMLElement;

		const isExpanded = target.closest('.block-tab')?.classList.contains('block-tab--expanded');

		if (isExpanded) {
			this.collapseBellow(target);
		} else {
			this.expandBellow(target);
		}
	}

	/**
	 * Collapse Bellow
	 *
	 * @param {HTMLElement} element Bellow to collapse
	 */
	collapseBellow(element: HTMLElement) {
		const bellowTrigger = element as HTMLElement;

		bellowTrigger.setAttribute('aria-expanded', 'false');
		const bellowElement = bellowTrigger.closest('.block-tab');
		if (bellowElement) {
			bellowElement.classList.remove('block-tab--expanded');
			const collapsable = bellowElement.querySelector<HTMLElement>('.block-tab__collapsable');
			if (collapsable) {
				slideUp(collapsable);
			}
		}
	}

	/**
	 * Expand Bellow
	 *
	 * @param {HTMLElement} element Bellow to expand
	 */
	expandBellow(element: HTMLElement) {
		// Expand bellow.
		const bellowTrigger = element as HTMLElement;
		bellowTrigger.setAttribute('aria-expanded', 'true');
		const bellowElement = bellowTrigger.closest('.block-tab');
		if (bellowElement) {
			bellowElement.classList.add('block-tab--expanded');
			const collapsable = bellowElement.querySelector<HTMLElement>('.block-tab__collapsable');
			if (collapsable) {
				this.scrollIntoView(collapsable, 'accordion');
				slideDown(collapsable);
			}
		}
	}

	/**
	 * Handle tab click
	 *
	 * @param {Event} event
	 */
	handleTabClick(event: Event) {
		const tab = event.currentTarget as HTMLElement;
		const targetID = tab.getAttribute('aria-controls');
		if (targetID) {
			const target = document.getElementById(targetID);

			if (target) {
				const isExpanded = target
					.closest('.block-tab')
					?.classList.contains('block-tab--expanded');

				if (!isExpanded) {
					this.expandTab(target, tab);
				}
			}
		}
	}

	/**
	 * Expand Tab
	 *
	 * @param {HTMLElement} accordionTrigger
	 * @param {HTMLElement} tabTrigger
	 */
	expandTab(accordionTrigger: HTMLElement, tabTrigger: HTMLElement) {
		// Collapse other tabs.
		this.tabTriggers.forEach((trigger) => {
			trigger.classList.remove('block-tabs__tab--expanded');
			trigger.setAttribute('aria-selected', 'false');
			trigger.setAttribute('tabindex', '-1');
		});
		tabTrigger.classList.add('block-tabs__tab--expanded');
		tabTrigger.setAttribute('aria-selected', 'true');
		tabTrigger.removeAttribute('tabindex');

		// Collapse other tabs.
		const expandedTabs = this.tabsBlock.querySelectorAll<HTMLElement>(
			'.block-tab--expanded .block-tab__top'
		);
		expandedTabs.forEach((expandedTab) => {
			this.collapseTab(expandedTab);
		});

		// Expand tab.
		const tabElement = accordionTrigger?.closest<HTMLElement>('.block-tab');
		if (tabElement) {
			tabElement.classList.add('block-tab--expanded');
			this.scrollIntoView(tabElement, 'tab');
			const collapsable = tabElement.querySelector<HTMLElement>('.block-tab__collapsable');
			if (collapsable) {
				collapsable.style.display = 'block';
			}

			// Set aria-expanded to false for the other accordion triggers.
			this.accordionTriggers.forEach((trigger) => {
				trigger.setAttribute('aria-expanded', 'false');
			});
			accordionTrigger.setAttribute('aria-expanded', 'true');
		}
	}

	/**
	 * Collapse Tab
	 *
	 * @param {HTMLElement} tabTrigger Tab trigger to collapse
	 */
	collapseTab(tabTrigger: HTMLElement) {
		tabTrigger.setAttribute('aria-expanded', 'false');
		const tabElement = tabTrigger.closest('.block-tab');
		if (tabElement) {
			tabElement.classList.remove('block-tab--expanded');
			const collapsable = tabElement.querySelector<HTMLElement>('.block-tab__collapsable');
			if (collapsable) {
				collapsable.style.display = 'none';
			}
		}
	}

	/**
	 * Handle keyboard navigation
	 *
	 * @param {KeyboardEvent} event Keyboard event
	 */
	handleKeyDown(event: KeyboardEvent) {
		if (!event.key.startsWith('Arrow')) return;

		const currentTab = event.target as HTMLElement;
		const tabArray = Array.from(this.tabTriggers);
		const currentIndex = tabArray.indexOf(currentTab);
		let newIndex: number;

		switch (event.key) {
			case 'ArrowLeft':
			case 'ArrowUp':
				event.preventDefault();
				newIndex = currentIndex - 1;
				if (newIndex < 0) newIndex = tabArray.length - 1;
				break;
			case 'ArrowRight':
			case 'ArrowDown':
				event.preventDefault();
				newIndex = currentIndex + 1;
				if (newIndex >= tabArray.length) newIndex = 0;
				break;
			default:
				return;
		}

		const targetTab = tabArray[newIndex];
		const targetID = targetTab.getAttribute('aria-controls');
		if (targetID) {
			const target = document.getElementById(targetID.replace(/^panel-/, 'control-'));
			if (target) {
				this.expandTab(target, targetTab);
				targetTab.focus();
			}
		}
	}
}

// Initialize the tabs on all elements with class 'block-tabs'
document.querySelectorAll('.block-tabs').forEach((tabs) => {
	new Tabs(tabs as HTMLElement);
});
