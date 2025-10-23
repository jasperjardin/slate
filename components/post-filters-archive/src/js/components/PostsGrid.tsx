import * as React from 'react';
import { useSettingsContext } from '../contexts/settings';
import { IPost } from '../types';
import Default from './cards/Default';
import Wide from './cards/Wide';

interface IProps {
	posts: Array<IPost>;
	setLoadingHeight?: (height: number | null) => void;
}

const PostsGrid = ({ posts, setLoadingHeight }: IProps) => {
	const tableRef = React.useRef<HTMLDivElement | null>(null);
	const settings = useSettingsContext();

	React.useEffect(() => {
		if (setLoadingHeight) {
			if (null !== tableRef.current && tableRef.current.offsetHeight) {
				setLoadingHeight(tableRef.current.offsetHeight);
			} else {
				setLoadingHeight(null);
			}
		}
	}, [posts]); // eslint-disable-line react-hooks/exhaustive-deps

	if (posts.length) {
		return (
			<div ref={tableRef} className={`pfa-posts-grid pfa-posts-grid--${settings.layout}`}>
				{posts.map((post) => {
					switch (settings.layout) {
						case 'search': {
							return <Wide post={post} key={post.ID} />;
						}

						default: {
							return <Default post={post} key={post.ID} />;
						}
					}
				})}
			</div>
		);
	}

	return <></>;
};

PostsGrid.displayName = 'PostsGrid';

export default PostsGrid;
