import MainHeader from './components/MainHeader';

/**
 * Controller class.
 *
 * Standardizes how we hook into event listeners and create components.
 */
class Controller {
	constructor() {
		this.init();

		window.addEventListener('resize', this.resized);
		window.addEventListener('load', this.loaded);
	}

	init() {
		MainHeader.init();
	}

	resized() {
		MainHeader.resized();
	}

	loaded() {
		MainHeader.loaded();
	}
}

// Run controller.
new Controller();
