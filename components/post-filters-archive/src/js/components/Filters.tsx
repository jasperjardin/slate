import * as React from 'react';
import { useFiltersContext } from '../contexts/filters';
import sanitizeHtml from 'sanitize-html';
import Select from './filters/Select';
import Search from './filters/Search';
import { useSettingsContext } from '../contexts/settings';

const Filters = () => {
	const { tax } = useFiltersContext();
	const settings = useSettingsContext();

	const taxEntries = Object.entries(tax);
	return (
		<div className="pfa-filters">
			{taxEntries.map(([key, taxonomy]) => {
				return (
					<div className="pfa-filters__filter" key={key}>
						<label
							htmlFor={`pfa-filter-${taxonomy.name}`}
							className="pfa-filters__title"
						>
							{taxonomy.labels.singular}
						</label>
						<Select taxonomy={taxonomy} />
					</div>
				);
			})}
			{settings.showSearch && (
				<div className="pfa-filters__filter">
					{/* eslint-disable-next-line jsx-a11y/label-has-associated-control */}
					<label
						htmlFor="pfa-filter-search"
						className="pfa-filters__title"
						dangerouslySetInnerHTML={{ __html: sanitizeHtml(settings.searchTitle) }}
					/>
					<Search />
				</div>
			)}
		</div>
	);
};

Filters.displayName = 'Filters';

export default Filters;
