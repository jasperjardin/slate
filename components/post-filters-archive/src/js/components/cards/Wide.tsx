import * as React from 'react';
import sanitizeHtml from 'sanitize-html';
import { IPost } from '../../types';

interface IProps {
	post: IPost;
}

const Wide = ({ post }: IProps) => {
	const linkText = `Learn More`;

	return (
		<a href={post.permalink} target="_self" rel="noreferrer" className="pfa-card-wide">
			<div className="pfa-card-wide__text">
				{post.post_type_label && (
					<div className="pfa-card-wide__post-type-container">
						<p
							className="pfa-card-wide__post-type"
							dangerouslySetInnerHTML={{
								__html: sanitizeHtml(post.post_type_label),
							}}
						/>
					</div>
				)}
				<div className="pfa-card-wide__content">
					{post.post_title && (
						<h3
							className="pfa-card-wide__title"
							dangerouslySetInnerHTML={{ __html: sanitizeHtml(post.post_title) }}
						/>
					)}
				</div>
				<span className="pfa-card-wide__link btn-tertiary">{linkText}</span>
			</div>
		</a>
	);
};

Wide.displayName = 'Wide';

export default Wide;
