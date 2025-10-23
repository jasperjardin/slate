import * as React from 'react';
import { IPost } from '../types';
import { useSettingsContext } from '../contexts/settings';

interface IProps {
	page: number;
	maxNumPages: number;
	posts: Array<IPost>;
	loading: boolean;
	setPage?: (page: number) => void;
}

const LoadMore = ({ page, maxNumPages, posts, loading, setPage }: IProps) => {
	const { paginationType, postsPerPage } = useSettingsContext();

	React.useEffect(() => {
		if (page > 1 && 'load_more' === paginationType) {
			// Get the first new post element.
			const firstNewPostIndex = postsPerPage * (page - 1);
			const firstNewPostElement = document.querySelector<HTMLElement>(
				`.pfa-posts-grid > *:nth-child(${firstNewPostIndex + 1})`
			);

			// Focus on the first newly added post if it's a link, if not, focus on the first inner focusable element.
			if (firstNewPostElement) {
				if ('A' === firstNewPostElement.tagName) {
					firstNewPostElement.focus();
				} else {
					const focusableElement = firstNewPostElement.querySelector<HTMLElement>(
						'a, button, [href], [tabindex]:not([tabindex="-1"])'
					);
					focusableElement?.focus();
				}
			}
		}
	}, [posts.length]);

	if (maxNumPages > page) {
		const handleOnClick = () => {
			if (setPage) {
				setPage(page + 1);
			}
		};

		return (
			<div className="pfa-load-more">
				<button
					className="pfa-load-more__button"
					onClick={handleOnClick}
					disabled={loading}
					aria-live="polite"
					aria-describedby="load-more-description"
				>
					{loading ? 'Loading...' : 'Show More'}
				</button>
				<div id="load-more-description" className="sr-only">
					After clicking Show More, focus will move to the first newly loaded post
				</div>
			</div>
		);
	}

	return <></>;
};

LoadMore.displayName = 'LoadMore';

export default LoadMore;
