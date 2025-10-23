import * as React from 'react';
import sanitizeHtml from 'sanitize-html';
import { IPost } from '../../types';

interface IProps {
	post: IPost;
}

const Default = ({ post }: IProps) => {
	return (
		<a href={post.permalink} target="_self" rel="noreferrer" className="pfa-card-default">
			{!!post.featured_image && (
				<figure
					className="pfa-card-default__img-wrapper"
					dangerouslySetInnerHTML={{ __html: post.featured_image }}
				/>
			)}
			<div className="pfa-card-default__text">
				{post.category.name && (
					<div className="pfa-card-default__tag-container">
						<p
							className="pfa-card-default__tag post-tag"
							dangerouslySetInnerHTML={{
								__html: sanitizeHtml(post.category.name),
							}}
						/>
					</div>
				)}
				<div className="pfa-card-default__content">
					{post.post_title && (
						<h3
							className="pfa-card-default__title"
							dangerouslySetInnerHTML={{ __html: sanitizeHtml(post.post_title) }}
						/>
					)}
					{post.post_excerpt && (
						<p
							className="pfa-card-default__excerpt"
							dangerouslySetInnerHTML={{ __html: sanitizeHtml(post.post_excerpt) }}
						/>
					)}
				</div>
				{post.post_date && (
					<p className="pfa-card-default__date">
						{new Date(post.post_date).toLocaleDateString('en-US', {
							month: 'short',
							day: 'numeric',
							year: 'numeric',
						})}
					</p>
				)}
			</div>
		</a>
	);
};

Default.displayName = 'Default';

export default Default;
