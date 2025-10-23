import * as React from 'react';
import { useFiltersContext } from '../contexts/filters';
import { useSettingsContext } from '../contexts/settings';

interface IProps {
	children: React.ReactNode;
}

const FiltersBar = ({ children }: IProps) => {
	const { tax, clearFilters, selectedTax, initSelectedTax, searchQuery } = useFiltersContext();
	const settings = useSettingsContext();

	const taxEntries = Object.entries(tax);

	const isActive =
		Object.values(selectedTax).length > 0 ||
		selectedTax !== initSelectedTax ||
		searchQuery !== '';

	const handleOnClick = () => {
		if (clearFilters) {
			clearFilters();
		}
	};

	if (taxEntries.length || settings.showSearch) {
		return (
			<div className="pfa-filters-bar">
				<div className="pfa-filters-bar__heading">
					Filters
					<button
						className={`pfa-filters-bar__clear--mobile pfa-filters-bar__clear ${isActive ? 'pfa-filters-bar__clear--active' : ''}`}
						onClick={handleOnClick}
					>
						Clear Filters
					</button>
				</div>
				{children}
				<button
					className={`pfa-filters-bar__clear--desktop pfa-filters-bar__clear ${isActive ? 'pfa-filters-bar__clear--active' : ''}`}
					onClick={handleOnClick}
				>
					Clear Filters
				</button>
			</div>
		);
	}

	return <></>;
};

FiltersBar.displayName = 'FiltersBar';

export default FiltersBar;
