/**
 * Animates slide up.
 *
 * Replacement for jQuery slideUp animation.
 *
 * @param element           The element to slide up.
 * @param [duration=400]    The duration of the animation in milliseconds.
 * @param [display="block"] The elements initial display property.
 */
const slideUp = (element: HTMLElement, duration = 400, display = 'block'): void => {
	// Make the element visible and reset its height
	element.style.display = display;
	const height = element.scrollHeight;

	// Set the element's height to its current pixel height, overflow hidden, and transition properties
	if (element.style.height !== 'auto') {
		element.style.height = 'auto';
	}

	element.style.height = height + 'px';
	element.style.transition = `height ${duration}ms ease-out`;
	element.style.overflow = 'hidden';

	void element.offsetHeight;

	// Trigger reflow to apply the height style before changing it
	requestAnimationFrame(() => {
		element.style.height = '0';
	});

	// Listen for transition end to reset styles and hide the element
	element.addEventListener('transitionend', function handler() {
		element.style.display = 'none';
		element.style.removeProperty('height');
		element.style.removeProperty('overflow');
		element.style.removeProperty('transition');
		element.removeEventListener('transitionend', handler);
		window.dispatchEvent(new Event('slideAnimationEnd'));
	});
};

/**
 * Animate slide down
 *
 * Replacement for jQuery slideDown animation.
 *
 * @param element           The element to slide down.
 * @param [duration=400]    The duration of the animation in milliseconds.
 * @param [display="block"] The elements initial display property.
 */
const slideDown = (element: HTMLElement, duration = 400, display = 'block'): void => {
	element.style.removeProperty('display');
	const computedDisplay = window.getComputedStyle(element).display;
	if (computedDisplay === 'none') {
		element.style.display = display;
	}

	// Get the full height of the element's content
	const height = element.scrollHeight;

	// Set the height to 0 initially and then animate to the full height
	element.style.height = '0';
	element.style.overflow = 'hidden';
	element.style.transition = `height ${duration}ms ease-out`;

	void element.offsetHeight;

	// Trigger reflow to apply the initial height style
	requestAnimationFrame(() => {
		element.style.height = height + 'px';
	});

	// Listen for transition end to reset styles
	element.addEventListener('transitionend', function handler() {
		element.style.display = display;
		element.style.height = 'auto';
		element.style.removeProperty('overflow');
		element.style.removeProperty('transition');
		element.removeEventListener('transitionend', handler);
		window.dispatchEvent(new Event('slideAnimationEnd'));
	});
};

const getOffsetTop = (element: HTMLElement | null) => {
	let offsetTop = 0;
	while (element) {
		offsetTop += element.offsetTop;
		element = element.offsetParent as HTMLElement;
	}
	return offsetTop;
};

const isTouchDevice = () => {
	return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
};

const isMobileViewport = (breakpoints: IBreakpoints) => {
	const mediaQuery = breakpoints
		? `(max-width: ${parseInt(breakpoints.lg) - 1}px)`
		: '(max-width: 991px)';
	return window.matchMedia(mediaQuery).matches;
};

const isElementVisible = (element: HTMLElement): boolean => {
	if (!(element instanceof Element)) return false;

	// Direct hidden cases
	if (element.matches('input[type="hidden"]')) return false;
	if (element.hasAttribute('hidden')) return false;

	// Computed style on self
	const style = getComputedStyle(element);
	if (style.display === 'none' || style.visibility === 'hidden') return false;

	// No box / zero rects (covers width/height 0, collapsed content, closed <details>, etc.)
	if (element.getClientRects().length === 0) return false;

	// Ancestor checks
	let parent = element.parentElement;
	while (parent) {
		const parentStyle = getComputedStyle(parent);
		if (
			parentStyle.display === 'none' ||
			parentStyle.visibility === 'hidden' ||
			parent.hasAttribute('hidden')
		) {
			return false;
		}
		parent = parent.parentElement;
	}

	return true;
};

export { slideUp, slideDown, getOffsetTop, isTouchDevice, isMobileViewport, isElementVisible };
