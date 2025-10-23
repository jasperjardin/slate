import * as React from 'react';
import { useReducer, useEffect, useRef } from 'react';
import { useFiltersContext } from './filters';
import { useSettingsContext } from './settings';
import getPosts from '../externals/getPosts';
import { IPost } from '../types';

const actions = {
	SET_POSTS: 'SET_POSTS',
	SET_FIRST_RUN: 'SET_FIRST_RUN',
	ADD_POSTS: 'ADD_POSTS',
	SET_PAGE: 'SET_PAGE',
	SET_LOADING: 'SET_LOADING',
	SET_LOADING_HEIGHT: 'SET_LOADING_HEIGHT',
};

interface IPostsState {
	posts: Array<IPost>;
	page: number;
	maxNumPages: number;
	foundPosts: number;
	loading: boolean;
	loadingHeight: number | null;
	paginationType: string;
	firstRun: boolean;
}

interface IReducerAction {
	type: string;
	// eslint-disable-next-line @typescript-eslint/no-explicit-any
	payload?: any;
}

const reducer = (state: IPostsState, action: IReducerAction) => {
	switch (action.type) {
		case actions.SET_POSTS: {
			return {
				...state,
				posts: action.payload.posts,
				page: action.payload.page ? action.payload.page : state.page,
				maxNumPages: action.payload.max_num_pages,
				foundPosts: action.payload.found_posts,
				loading: false,
				firstRun: false,
			};
		}

		case actions.SET_FIRST_RUN: {
			return {
				...state,
				firstRun: action.payload.firstRun,
			};
		}

		case actions.ADD_POSTS: {
			return {
				...state,
				posts: [...state.posts, ...action.payload.posts],
				loading: false,
				firstRun: false,
			};
		}

		case actions.SET_PAGE: {
			return {
				...state,
				page: action.payload.page,
			};
		}

		case actions.SET_LOADING: {
			return {
				...state,
				loading: action.payload.isLoading,
			};
		}

		case actions.SET_LOADING_HEIGHT: {
			return {
				...state,
				loadingHeight: action.payload.loadingHeight,
			};
		}

		default: {
			return state;
		}
	}
};

interface IPostsContext {
	posts: Array<IPost>;
	page: number;
	maxNumPages: number;
	foundPosts: number;
	loading: boolean;
	loadingHeight: number | null;
	firstRun: boolean;
	setPage: (page: number) => void;
	setLoading: (isLoading: boolean) => void;
	setLoadingHeight: (loadingHeight: number | null) => void;
}

const PostsContext = React.createContext<IPostsContext>({} as IPostsContext);

interface IProps {
	children: React.ReactNode;
}

const PostsProvider = ({ children }: IProps) => {
	const settings = useSettingsContext();
	let currentPage = 1;

	if ('load_more' !== settings.paginationType) {
		const url = new URLSearchParams(window.location.search);
		const pageMatches = window.location.href.match(/page\/([0-9]+)/i);
		const pageParam = url.get('page');

		if (pageParam) {
			currentPage = +pageParam;
		} else if (pageMatches) {
			currentPage = +pageMatches[1];
		} else {
			currentPage = 1;
		}
	}

	const initialState = {
		posts: [],
		page: currentPage ? currentPage : 1,
		maxNumPages: 1,
		foundPosts: 1,
		loadingHeight: null,
		loading: false,
		paginationType: settings.paginationType,
		firstRun: true,
	};

	const [state, dispatch] = useReducer(reducer, initialState);
	const { selectedTax, searchQuery } = useFiltersContext();

	// On page change, add posts. Prevent adding on remounts by storing a ref of prev page.
	const prevPage = useRef([state.page, selectedTax, searchQuery]);

	// Fetch posts on page change
	useEffect(() => {
		if (prevPage.current[0] !== state.page) {
			if (settings.paginationType !== 'load_more') {
				dispatch({ type: actions.SET_LOADING, payload: { isLoading: true } });
			}

			const fetchData = async () => {
				const response = await getPosts(
					settings,
					{
						selectedTax,
						searchQuery,
					},
					state.page
				);
				switch (settings.paginationType) {
					case 'numbered_pagination':
						if (prevPage.current === state.page) {
							return;
						}

						// Scroll to the top after paginating.
						if (!state.firstRun && settings.element) {
							const headerHeight = getComputedStyle(document.documentElement)
								.getPropertyValue('--headerHeightFull')
								.replace('px', '');

							const rect = settings.element.getBoundingClientRect();
							const scrollTop =
								window.pageYOffset || document.documentElement.scrollTop;
							const offsetTop = rect.top + scrollTop - +headerHeight;

							window.scroll({ top: offsetTop, left: 0, behavior: 'smooth' });
						}

						dispatch({
							type: actions.SET_POSTS,
							payload: response,
						});

						break;
					default:
						if (1 === state.page || prevPage.current === state.page) {
							return;
						}
						dispatch({ type: actions.ADD_POSTS, payload: response });
				}
				prevPage.current = [state.page, selectedTax, searchQuery];
			};

			// eslint-disable-next-line no-console
			fetchData().catch(console.error);
		}
	}, [state.page]);

	// Fetch posts on taxonomy change or search query change
	useEffect(() => {
		if (
			prevPage.current[1] !== selectedTax ||
			prevPage.current[2] !== searchQuery ||
			'' === prevPage.current[2] ||
			state.firstRun
		) {
			dispatch({ type: actions.SET_LOADING, payload: { isLoading: true } });

			const fetchData = async () => {
				const response = await getPosts(
					settings,
					{
						selectedTax,
						searchQuery,
					},
					state.page
				);

				if (state.firstRun) {
					dispatch({ type: actions.SET_POSTS, payload: response });
				} else {
					dispatch({ type: actions.SET_POSTS, payload: { ...response, page: 1 } });
				}
			};

			// eslint-disable-next-line no-console
			fetchData().catch(console.error);
		}
	}, [selectedTax, searchQuery]);

	const value = {
		posts: state.posts,
		page: state.page,
		maxNumPages: state.maxNumPages,
		loading: state.loading,
		loadingHeight: state.loadingHeight,
		foundPosts: state.foundPosts,
		firstRun: state.firstRun,
		setPage: (page: number) => {
			dispatch({ type: actions.SET_PAGE, payload: { page } });
		},
		setLoading: (isLoading: boolean) => {
			dispatch({ type: actions.SET_LOADING, payload: { isLoading } });
		},
		setLoadingHeight: (loadingHeight: number | null) => {
			dispatch({ type: actions.SET_LOADING_HEIGHT, payload: { loadingHeight } });
		},
	};

	return <PostsContext.Provider value={value}>{children}</PostsContext.Provider>;
};

const usePostsContext = () => React.useContext(PostsContext);

export { PostsProvider, usePostsContext };
