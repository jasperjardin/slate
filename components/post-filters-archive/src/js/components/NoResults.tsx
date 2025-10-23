import * as React from 'react';
import { useFiltersContext } from '../contexts/filters';
import { IPost } from '../types';

interface IProps {
	posts: Array<IPost>;
}

const NoResults = ({ posts }: IProps) => {
	const { clearFilters } = useFiltersContext();

	if (!posts.length) {
		const handleOnClick = () => {
			if (clearFilters) {
				clearFilters();
			}
		};

		return (
			<div className="pfa-no-results">
				<h2 className="pfa-no-results__title">No Results Found</h2>
				<p className="pfa-no-results__description">
					There are no results for the filters you&apos;ve selected.
				</p>
				<button className="btn-primary pfa-no-results__clear" onClick={handleOnClick}>
					Clear Filters
				</button>
			</div>
		);
	}

	return <></>;
};

NoResults.displayName = 'NoResults';

export default NoResults;
