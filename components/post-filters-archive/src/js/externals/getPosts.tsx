import { IAppSettings, ISelectedTax } from '../types';
import fetchAPI from '../utils/fetchAPI';

interface IArgs {
	selectedTax: ISelectedTax;
	searchQuery?: string;
}

const getPosts = async (settings: IAppSettings, args: IArgs, page = 1) => {
	let url = `${settings.apiBase}/get-posts?post_type=${settings.postType}&posts_per_page=${settings.postsPerPage}&paged=${page}`;
	Object.entries(args.selectedTax).forEach(([tax, term]) => {
		url += `&tax[${tax}]=${term}`;
	});

	if (args.searchQuery) {
		url += `&s=${args.searchQuery}`;
	}

	if (settings.postAuthor) {
		url += `&author=${settings.postAuthor}`;
	}

	return await fetchAPI(url);
};

export default getPosts;
