import { DataRegistry } from '@wordpress/data';

declare global {
	interface Window {
		acf: any;
		Swiper: any;
		dataLayer: undefined|any[];
	}
}
