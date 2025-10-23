export interface IAppSettings {
	apiBase: string;
	postType: string;
	postsPerPage: number;
	filtersToShow: Array<string>;
	showSearch: boolean;
	layout: string;
	searchTitle: string;
	initSelectedTax: ISelectedTax;
	addFiltersToUrl: boolean;
	addPageToUrl: boolean;
	addSearchToUrl: boolean;
	paginationType: string;
	postAuthor: string;
	element: HTMLElement | null;
}

export interface ITaxonomy {
	labels: ITaxonomyLabels;
	name: string;
	terms: Array<ITerm>;
}

export interface ITaxonomyLabels {
	name: string;
	singular: string;
}

export interface ITerm {
	name: string;
	count: number;
	description: string;
	filter?: string;
	parent: number;
	slug: string;
	taxonomy: string;
	term_group: number;
	term_id: number;
	term_taxonomy_id: number;
}

export interface ITaxData {
	[key: string]: ITaxonomy;
}

export interface ISelectedTax {
	[key: string]: Array<number>;
}

export interface IDocumentationItem {
	file: string;
	text: string;
	url: string;
	use_url: boolean;
}

export interface IPost {
	ID: number;
	post_title: string;
	featured_image?: string;
	permalink: string;
	post_date: string;
	post_excerpt: string;
	post_name: string;
	post_type: string;
	post_type_label: string;
	category: ITerm;
}
