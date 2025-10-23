import Sortable from 'sortablejs';

class ModuleLibrary {
	content: HTMLElement | null;
	sortable: Sortable | undefined;
	checkboxes: NodeListOf<Node>;
	editModuleLink: HTMLElement | null;
	moduleCount: number;
	modulesShown: Array<string>;

	constructor() {
		this.content = document.querySelector('.page-content');
		if (null !== this.content) {
			this.sortable = Sortable.create(this.content);
		}

		this.checkboxes = document.querySelectorAll('.module-library-menu__input');
		this.editModuleLink = document.querySelector('.module-library-menu__edit-module-link');
		this.moduleCount = Array.from(this.checkboxes).length;
		this.modulesShown = [];

		this.init();
	}

	init() {
		this.updateModulesShown();
		this.setEditLinkDisplay();

		this.checkboxes.forEach((checkbox) => {
			checkbox.addEventListener('change', this.handleCheckboxChange.bind(this));
		});

		if (null !== this.editModuleLink) {
			this.editModuleLink.addEventListener('click', this.handleEditModuleLink.bind(this));
		}
	}

	handleCheckboxChange(e: Event) {
		if (null === e.currentTarget) {
			return false;
		}

		const { value, checked } = e.currentTarget as HTMLInputElement;
		const blocks = document.querySelectorAll(`[data-module-id="${value}"]`);

		if (checked) {
			blocks.forEach((block) => {
				block.setAttribute('data-visible', 'true');
			});
		} else {
			blocks.forEach((block) => {
				block.setAttribute('data-visible', 'false');
			});
		}

		this.updateModulesShown();
		this.updateURL();
		this.setEditLinkDisplay();
	}

	updateModulesShown() {
		if (null === this.content) {
			return false;
		}

		const modulesShown: Array<string> = [];
		const blocks = Array.from(this.content.children);
		blocks.forEach((block) => {
			const moduleId = block.getAttribute('data-module-id');
			if ('false' !== block.getAttribute('data-visible') && null !== moduleId) {
				modulesShown.push(moduleId);
			}
		});

		this.modulesShown = modulesShown.filter((v, i, a) => a.indexOf(v) === i);
	}

	updateURL() {
		const url = new URL(window.location.href);

		if (this.modulesShown.length === this.moduleCount) {
			url.searchParams.delete('modules');
		} else {
			url.searchParams.set('modules', this.modulesShown.join('-'));
		}

		if (url.search.length) {
			window.history.replaceState(null, '', url.search);
		} else {
			window.history.replaceState(null, '', url.href);
		}
	}

	setEditLinkDisplay() {
		if (null === this.editModuleLink) {
			return false;
		}

		this.editModuleLink.classList.toggle('active', this.modulesShown.length === 1);
	}

	handleEditModuleLink() {
		const moduleID = this.modulesShown[0];
		const url = new URL(window.location.href);

		window.location.href = `${url.origin}/wp-admin/post.php?post=${moduleID}&action=edit`;
	}
}

new ModuleLibrary();
