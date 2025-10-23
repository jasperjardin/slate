import * as React from 'react';
import FiltersBar from '../FiltersBar';
import LoadMore from '../LoadMore';
import NoResults from '../NoResults';
import { FiltersProvider } from '../../contexts/filters';
import { PostsProvider } from '../../contexts/posts';
import Filters from '../Filters';
import PostsGrid from '../PostsGrid';
import Posts from '../Posts';
import Pagination from '../PaginationNumbers';
import { useSettingsContext } from '../../contexts/settings';
import ResultCount from '../ResultCount';

const LayoutDefault = () => {
	const settings = useSettingsContext();

	return (
		<>
			<FiltersProvider>
				<FiltersBar>
					<Filters />
				</FiltersBar>
				<PostsProvider>
					<Posts>
						{<ResultCount foundPosts={0} />}
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

LayoutDefault.displayName = 'LayoutDefault';

export default LayoutDefault;
