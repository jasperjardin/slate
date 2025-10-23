import * as React from 'react';
import { createRoot } from 'react-dom/client';
import App from './App';
import { IAppSettings } from './types';

const elements = document.querySelectorAll<HTMLElement>('.post-filters-archive');

elements.forEach((element) => {
	const root = createRoot(element);

	const apiBase = element.getAttribute('data-api-base');
	const postType = element.getAttribute('data-post-type');
	const postsPerPage = element.getAttribute('data-posts-per-page');
	const filtersToShow = element.getAttribute('data-filters-to-show');
	const showSearch = element.getAttribute('data-show-search');
	const layout = element.getAttribute('data-layout');
	const searchTitle = element.getAttribute('data-search-title');
	const selectedTax = element.getAttribute('data-selected-tax');
	const addFiltersToUrl = element.getAttribute('data-add-filters-to-url');
	const addPageToUrl = element.getAttribute('data-add-page-to-url');
	const addSearchToUrl = element.getAttribute('data-add-search-to-url');
	const paginationType = element.getAttribute('data-pagination-type');
	const postAuthor = element.getAttribute('data-post-author');

	const settings: IAppSettings = {
		apiBase: apiBase ?? '',
		postType: postType ?? 'post',
		postsPerPage: null !== postsPerPage ? +postsPerPage : 12,
		filtersToShow: filtersToShow?.length ? filtersToShow.split(',') : [],
		showSearch: !!showSearch,
		layout: layout ?? 'default',
		searchTitle: searchTitle ?? 'Search by keyword',
		initSelectedTax: null !== selectedTax ? JSON.parse(selectedTax) : {},
		addFiltersToUrl: !!addFiltersToUrl,
		addPageToUrl: !!addPageToUrl,
		addSearchToUrl: !!addSearchToUrl,
		paginationType: paginationType ?? 'numbered_pagination',
		postAuthor: postAuthor ?? '',
		element,
	};

	if (settings.apiBase.length) {
		root.render(
			<React.StrictMode>
				<App settings={settings} />
			</React.StrictMode>
		);
	}
});
