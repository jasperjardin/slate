import * as React from 'react';
import NoResults from '../NoResults';
import { FiltersProvider } from '../../contexts/filters';
import { PostsProvider } from '../../contexts/posts';
import PostsGrid from '../PostsGrid';
import Posts from '../Posts';
import Pagination from '../PaginationNumbers';
import LoadMore from '../LoadMore';
import { useSettingsContext } from '../../contexts/settings';
import SearchBar from '../SearchBar';
import Search from '../filters/Search';
import ResultCount from '../ResultCount';

const LayoutSearch = () => {
	const settings = useSettingsContext();

	return (
		<>
			<FiltersProvider>
				<SearchBar>
					<Search />
				</SearchBar>
				<PostsProvider>
					<Posts>
						<ResultCount foundPosts={0} />
						<PostsGrid posts={[]} />
						{settings.paginationType === 'load_more' ? (
							<LoadMore page={0} maxNumPages={0} posts={[]} loading={false} />
						) : (
							<Pagination page={0} maxNumPages={0} />
						)}
						<NoResults posts={[]} />
					</Posts>
				</PostsProvider>
			</FiltersProvider>
		</>
	);
};

LayoutSearch.displayName = 'LayoutSearch';

export default LayoutSearch;
