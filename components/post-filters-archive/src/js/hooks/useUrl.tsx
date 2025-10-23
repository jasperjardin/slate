import * as React from 'react';
import { useSettingsContext } from '../contexts/settings';
import { usePostsContext } from '../contexts/posts';
import { useFiltersContext } from '../contexts/filters';
import { ISelectedTax } from '../types';

const useURL = () => {
	const settings = useSettingsContext();
	const { page } = usePostsContext();
	const { searchQuery, selectedTax, tax } = useFiltersContext();

	/**
	 * Determines if the current page is a search page.
	 *
	 * @return {string | null} 'params' if the search query is in the URL params, 'path' if it's in the URL path, or null if it's not a search page.
	 */
	const isSearchPage = () => {
		const url = new URL(window.location.href);

		if (url.searchParams.has('s')) {
			return 'params';
		}

		const pathParts = url.pathname.split('/').filter((part) => part !== '');
		if (pathParts.length && pathParts[0] === 'search') {
			return 'path';
		}

		return null;
	};

	React.useEffect(() => {
		if (settings.paginationType === 'load_more') return;

		const url = new URL(window.location.href);
		const searchPage = isSearchPage();

		/**
		 * Adds a search term to the URL.
		 *
		 * Depending on the `searchPage` value, the search term is added either as a query parameter or as part of the URL path.
		 *
		 * @param {string} searchTerm - The search term to be added to the URL.
		 *
		 * @return {void}
		 */
		const addSearch = (searchTerm: string) => {
			if (!searchTerm) return;

			if (searchPage) {
				if (searchPage === 'params') {
					url.searchParams.set('s', searchTerm);
				}

				if (searchPage === 'path') {
					const pathParts = url.pathname.split('/').filter((part) => part !== '');
					const searchIndex = pathParts.indexOf('search');

					if (searchIndex !== -1) {
						pathParts[searchIndex + 1] = searchTerm;
					} else {
						pathParts.push('search', searchTerm);
					}
					url.pathname = '/' + pathParts.join('/');
				}
			} else {
				url.searchParams.set('pfa-s', searchTerm);
			}
		};

		/**
		 * Adds a page number to the URL.
		 *
		 * Depending on the `searchPage` value, the page number is added either as a query parameter or as part of the URL path.
		 *
		 * @param {number} pageNumber - The page number to be added to the URL.
		 *
		 * @return {void}
		 */
		const addPage = (pageNumber: number) => {
			if (!pageNumber || pageNumber <= 1) return;

			if (searchPage) {
				if (searchPage === 'params') {
					url.searchParams.set('page', pageNumber.toString());
				}

				if (searchPage === 'path') {
					const pathParts = url.pathname.split('/').filter((part) => part !== '');
					const pageIndex = pathParts.indexOf('page');

					if (pageIndex !== -1) {
						pathParts[pageIndex + 1] = pageNumber.toString();
					} else {
						pathParts.push('page', pageNumber.toString());
					}
					url.pathname = '/' + pathParts.join('/');
				}
			} else {
				const pathParts = url.pathname.split('/').filter((part) => part !== '');
				const pageIndex = pathParts.indexOf('page');

				if (pageIndex !== -1) {
					pathParts[pageIndex + 1] = pageNumber.toString();
				} else {
					pathParts.push('page', pageNumber.toString());
				}
				url.pathname = '/' + pathParts.join('/');
			}
		};

		const addTax = (taxonomy: ISelectedTax) => {
			const taxKeys = Object.keys(taxonomy);

			taxKeys.forEach((taxKey) => {
				if (searchPage) return;

				const termIds = taxonomy[taxKey];
				let value;

				if (Array.isArray(termIds) && termIds.length === 0) {
					value = termIds.join(',');
				} else {
					value = termIds.toString();
				}

				url.searchParams.set(`tax[${taxKey}]`, value);
			});
		};

		const removeSearch = () => {
			if (searchPage) {
				if (searchPage === 'params') {
					url.searchParams.set('s', '');
				}

				if (searchPage === 'path') {
					const pathParts = url.pathname.split('/').filter((part) => part !== '');
					const searchIndex = pathParts.indexOf('search');
					if (searchIndex !== -1) {
						pathParts.splice(searchIndex, 2);
					}
					url.pathname = '/' + pathParts.join('/');
				}
			} else {
				url.searchParams.delete('pfa-s');
			}
		};

		const removePage = () => {
			if (searchPage) {
				if (searchPage === 'params') {
					url.searchParams.delete('page');
				}

				if (searchPage === 'path') {
					const pathParts = url.pathname.split('/').filter((part) => part !== '');
					const pageIndex = pathParts.indexOf('page');
					if (pageIndex !== -1) {
						pathParts.splice(pageIndex, 2);
					}
					url.pathname = '/' + pathParts.join('/');
				}
			} else {
				const pathParts = url.pathname.split('/').filter((part) => part !== '');
				const pageIndex = pathParts.indexOf('page');
				if (pageIndex !== -1) {
					pathParts.splice(pageIndex, 2);
				}
				url.pathname = '/' + pathParts.join('/');
			}
		};

		const removeTax = () => {
			if (searchPage) return;

			const taxKeys = Object.keys(tax);

			taxKeys.forEach((taxKey) => {
				url.searchParams.delete(`tax[${taxKey}]`);
			});
		};

		removeSearch();
		removePage();
		removeTax();

		if (searchQuery && settings.addSearchToUrl) {
			addSearch(searchQuery);
		}

		if (page > 1 && settings.addPageToUrl) {
			addPage(page);
		}

		if (selectedTax && settings.addFiltersToUrl) {
			addTax(selectedTax);
		}

		// Ensure trailing slash
		if (!url.pathname.endsWith('/')) {
			url.pathname = url.pathname + '/';
		}

		const newUrl = decodeURIComponent(url.toString());
		if (newUrl !== window.location.href) {
			window.history.pushState({ path: newUrl }, '', newUrl);
		}
	}, [searchQuery, page, selectedTax]); // eslint-disable-line react-hooks/exhaustive-deps
};

export default useURL;
