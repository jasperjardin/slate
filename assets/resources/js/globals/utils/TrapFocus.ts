import { isElementVisible } from './functions';

/**
 * TrapFocus class for managing focus trapping within a container element
 */
class TrapFocus {
	private container: HTMLElement;
	private focusableElements: HTMLElement[];
	private onEscape: () => void;
	private returnFocusElement?: HTMLElement;
	private trapFocusHandler: ((e: KeyboardEvent) => void) | null = null;
	private isActive = false;

	/**
	 * Creates a new TrapFocus instance
	 *
	 * @param container          The container element to trap focus within
	 * @param focusableElements  Array of focusable elements within the container
	 * @param onEscape           Callback function to execute when Escape key is pressed
	 * @param returnFocusElement Optional element to return focus to when trap is removed
	 */
	constructor(
		container: HTMLElement,
		focusableElements: HTMLElement[],
		onEscape: () => void,
		returnFocusElement?: HTMLElement
	) {
		this.container = container;
		this.focusableElements = focusableElements;
		this.onEscape = onEscape;
		this.returnFocusElement = returnFocusElement;
		this.init();
	}

	/**
	 * Activates the focus trap
	 */
	init(): void {
		if (this.isActive) return;

		const focusableElementsFiltered = this.focusableElements.filter((element) =>
			isElementVisible(element)
		);

		if (focusableElementsFiltered.length === 0) return;

		// Set first/last elements
		const firstElement = focusableElementsFiltered[0];
		const lastElement = focusableElementsFiltered[focusableElementsFiltered.length - 1];

		// Focus the first element
		firstElement.focus();

		this.trapFocusHandler = (e: KeyboardEvent) => {
			if (e.key === 'Escape') {
				this.onEscape();
				this.deactivate();
				if (this.returnFocusElement) {
					this.returnFocusElement.focus();
				}
				return;
			}

			if (e.key === 'Tab') {
				if (e.shiftKey && firstElement.ownerDocument.activeElement === firstElement) {
					e.preventDefault();
					lastElement.focus();
				}
				if (!e.shiftKey && lastElement.ownerDocument.activeElement === lastElement) {
					e.preventDefault();
					firstElement.focus();
				}
			}
		};

		this.container.addEventListener('keydown', this.trapFocusHandler);
		this.isActive = true;
	}

	/**
	 * Deactivates the focus trap and cleans up event listeners
	 */
	deactivate(): void {
		if (!this.isActive || !this.trapFocusHandler) return;

		this.container.removeEventListener('keydown', this.trapFocusHandler);
		this.trapFocusHandler = null;
		this.isActive = false;
	}
}

export default TrapFocus;
