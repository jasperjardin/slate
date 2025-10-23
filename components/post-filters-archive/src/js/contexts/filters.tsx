import * as React from 'react';
import { useReducer, useEffect } from 'react';
import { ISelectedTax, ITaxData } from '../types';
import fetchAPI from '../utils/fetchAPI';
import { useSettingsContext } from './settings';

const actions = {
	SET_TAX_OPTIONS: 'SET_TAX_OPTIONS',
	SELECT_TAX_TERM: 'SELECT_TAX_TERM',
	CLEAR_FILTERS: 'CLEAR_FILTERS',
	SET_SEARCH_QUERY: 'SET_SEARCH_QUERY',
};

interface IFiltersState {
	searchQuery: string;
	tax: ISelectedTax;
	selectedTax: ISelectedTax;
	initSelectedTax: ISelectedTax;
}

interface IReducerAction {
	type: string;
	// eslint-disable-next-line @typescript-eslint/no-explicit-any
	payload?: any;
}

const reducer = (state: IFiltersState, action: IReducerAction) => {
	switch (action.type) {
		case actions.SET_TAX_OPTIONS: {
			return {
				...state,
				tax: action.payload,
			};
		}
		case actions.SET_SEARCH_QUERY: {
			return {
				...state,
				searchQuery: action.payload,
			};
		}

		case actions.SELECT_TAX_TERM: {
			const selectedTax = { ...state.selectedTax };
			if (action.payload.term !== '' && action.payload.term !== 0) {
				selectedTax[action.payload.tax] = action.payload.term;
			} else if ('undefined' !== typeof selectedTax[action.payload.tax]) {
				delete selectedTax[action.payload.tax];
			}

			return {
				...state,
				selectedTax,
			};
		}

		case actions.CLEAR_FILTERS: {
			return {
				...state,
				selectedTax: state.initSelectedTax,
				searchQuery: '',
			};
		}

		default: {
			return state;
		}
	}
};

interface IFiltersContext {
	tax: ITaxData;
	selectedTax: ISelectedTax;
	searchQuery: string;
	initSelectedTax: ISelectedTax;
	selectTaxTerm?: (tax: string, term: number) => void;
	setSearchQuery?: (query: string) => void;
	clearFilters?: () => void;
}

const FiltersContext = React.createContext<IFiltersContext>({} as IFiltersContext);

interface IProps {
	children: React.ReactNode;
}

const FiltersProvider = ({ children }: IProps) => {
	const settings = useSettingsContext();
	const url = new URL(window.location.href);

	// Get search query from URL.
	const currentSearchQuery =
		url.searchParams.get('s') || // search page
		url.searchParams.get('pfa-s') || // non-search page
		window.location.pathname.match(/^\/search\/([^\/?]+)[\/]?/i)?.[1] || // search page but using path
		'';

	// Get tax parameters from URL
	const taxParams: { [key: string]: number[] } = {};
	url.searchParams.forEach((value, key) => {
		const match = key.match(/^tax\[(.*?)\]$/);
		if (match) {
			const taxName = match[1];
			taxParams[taxName] = value.split(',').map(Number).filter(Boolean);
		}
	});

	// Merge URL tax params with initial selected tax
	const mergedSelectedTax = {
		...(settings?.initSelectedTax ?? {}),
		...taxParams,
	};

	const initialState = {
		searchQuery: currentSearchQuery ?? '',
		tax: {},
		selectedTax: mergedSelectedTax ?? {},
		initSelectedTax: settings?.initSelectedTax ?? {},
	};

	const [state, dispatch] = useReducer(reducer, initialState);

	useEffect(() => {
		if (settings.filtersToShow.length) {
			const fetchData = async () => {
				const response = await fetchAPI(
					`${settings.apiBase}/get-taxonomies?post_type=${
						settings.postType
					}&tax=${settings.filtersToShow.join(',')}`
				);
				dispatch({ type: actions.SET_TAX_OPTIONS, payload: response });
			};

			// eslint-disable-next-line no-console
			fetchData().catch(console.error);
		}
	}, []);

	const value = {
		tax: state.tax,
		selectedTax: state.selectedTax,
		initSelectedTax: state.initSelectedTax,
		searchQuery: state.searchQuery,
		selectTaxTerm: (tax: string, term: number) => {
			dispatch({ type: actions.SELECT_TAX_TERM, payload: { tax, term } });
		},
		setSearchQuery: (query: string) => {
			dispatch({ type: actions.SET_SEARCH_QUERY, payload: query });
		},
		clearFilters: () => {
			dispatch({ type: actions.CLEAR_FILTERS });
		},
	};

	return <FiltersContext.Provider value={value}>{children}</FiltersContext.Provider>;
};

const useFiltersContext = () => React.useContext(FiltersContext);

export { FiltersProvider, useFiltersContext };
