import { DataRegistry } from '@wordpress/data';
import Vimeo from '@vimeo/player';
import MicroModal from 'micromodal';

interface RegisteredPatternCat {
	name: string;
	label: string;
	description?: string;
}

interface RegisteredPatternPostType {
	value: string;
	label: string;
}

declare global {
	interface Window {
		Vimeo: {
			Player: typeof Vimeo
		}
		MicroModal: typeof MicroModal
		impThemes: undefined|ITheme[]
		impBreakpoints: undefined|IBreakpoints
		hbspt?: any;
	}

	const wp: {
		data: DataRegistry;
		domReady: any;
		blocks: any;
		plugins: any;
		i18n: any;
		compose: any;
		data: any;
		url: any;
		editor: any;
		components: any;
		blockEditor: any;
		hooks: any;
		element: any;
		notices: any;
	};

	const moduleCatSidebar : {
		registeredCats: Array<RegisteredPatternCat>;
		registeredPostTypes: Array<RegisteredPatternPostType>;
	}

	interface ITheme {
		name: string;
		slug: string;
		color: string;
	}

	interface IBreakpoints {
		xs: string;
		sm: string;
		md: string;
		lg: string;
		xl: string;
		xxl: string;
		[key: string]: number;
	}
}

declare module 'ModulePatternSidebar';
