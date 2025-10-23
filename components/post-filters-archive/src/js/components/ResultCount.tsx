import * as React from 'react';
import { useSettingsContext } from '../contexts/settings';
import { useFiltersContext } from '../contexts/filters';

interface IProps {
	foundPosts: number;
}

const ResultCount = ({ foundPosts }: IProps) => {
	const settings = useSettingsContext();
	const { searchQuery } = useFiltersContext();

	const singleResultText =
		'search' === settings.layout ? `result for "${searchQuery}"` : 'result';
	const multipleResultText =
		'search' === settings.layout ? `results for "${searchQuery}"` : 'results';

	if (foundPosts) {
		return (
			<div
				className={`pfa-result-count pfa-result-count--${settings.layout}`}
				role="status"
				aria-live="polite"
				aria-atomic="true"
			>
				Showing {foundPosts} {1 === foundPosts ? singleResultText : multipleResultText}
			</div>
		);
	}

	return <></>;
};

ResultCount.displayName = 'ResultCount';

export default ResultCount;
