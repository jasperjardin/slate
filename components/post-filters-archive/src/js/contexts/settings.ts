import * as React from 'react';
import { IAppSettings } from '../types';

const defaultSettings: IAppSettings = {
	apiBase: '',
	postType: 'post',
	postsPerPage: 12,
	filtersToShow: [],
	showSearch: true,
	layout: 'default',
	searchTitle: 'Search by keyword',
	initSelectedTax: {},
	addFiltersToUrl: true,
	addPageToUrl: false,
	addSearchToUrl: false,
	paginationType: 'numbered_pagination',
	postAuthor: '',
	element: null,
};

const SettingsContext = React.createContext<IAppSettings>(defaultSettings);

const useSettingsContext = () => React.useContext(SettingsContext);

export { SettingsContext, useSettingsContext };
