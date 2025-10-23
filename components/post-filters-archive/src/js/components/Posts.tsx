import * as React from 'react';
import { usePostsContext } from '../contexts/posts';
import Loading from '../widgets/Loading';
import { useSettingsContext } from '../contexts/settings';
import { useFiltersContext } from '../contexts/filters';
import useURL from '../hooks/useUrl';

interface IProps {
	children: React.ReactNode;
}

const Posts = ({ children }: IProps) => {
	const settings = useSettingsContext();
	const { searchQuery } = useFiltersContext();

	// URL state manager
	useURL();

	const {
		posts,
		maxNumPages,
		foundPosts,
		page,
		setPage,
		loading,
		loadingHeight,
		setLoadingHeight,
		firstRun,
	} = usePostsContext();

	// Not sure why it doesn't like this. We're using it in the the useEffect below.
	// eslint-disable-next-line @wordpress/no-unused-vars-before-return
	const [isLoading, setIsLoading] = React.useState(true);

	// Create a minimum load time to prevent flickering.
	const lastLoading = React.useRef<boolean | Date>(false);
	React.useEffect(() => {
		const minLoader = 500;

		if (loading) {
			lastLoading.current = new Date();
			setIsLoading(true);
		} else if ('boolean' !== typeof lastLoading.current) {
			const now = new Date();
			const diff = now.getTime() - lastLoading.current.getTime();

			if (diff > minLoader) {
				setIsLoading(false);
			} else {
				setTimeout(() => {
					setIsLoading(false);
				}, minLoader - diff);
			}
		}
	}, [loading]);

	// If the layout is search and there is no search query, don't show the posts.
	const isSearchLayout = settings.layout === 'search';
	const hasSearchQuery = searchQuery && searchQuery.trim().length > 0;
	const shouldShowPosts = !isSearchLayout || (isSearchLayout && hasSearchQuery);
	if (!shouldShowPosts) {
		return null;
	}

	const childrenWithProps = React.Children.map(children, (child) => {
		if (React.isValidElement(child)) {
			return React.cloneElement(child as React.ReactElement, {
				posts,
				maxNumPages,
				foundPosts,
				page,
				setPage,
				loading,
				loadingHeight,
				setLoadingHeight,
				isLoading,
				setIsLoading,
			});
		}
		return child;
	});

	return (
		<Loading isLoading={isLoading} height={loadingHeight} firstRun={firstRun}>
			<div className={`pfa-posts pfa-posts--${settings.layout}`}>{childrenWithProps}</div>
		</Loading>
	);
};

Posts.displayName = 'Posts';

export default Posts;
