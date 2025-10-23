import React from 'react';
import { useSettingsContext } from '../contexts/settings';
import { useFiltersContext } from '../contexts/filters';

interface IProps {
	children: React.ReactNode;
}

const SearchBar = ({ children }: IProps) => {
	const settings = useSettingsContext();
	const { searchQuery } = useFiltersContext();
	const hasQuery = searchQuery && searchQuery.trim().length > 0;

	return (
		<div
			className={`pfa-search-bar ${hasQuery ? 'pfa-search-bar--has-query' : ''}`}
			data-theme="light"
		>
			<div className="pfa-search-bar__wrapper">
				<h1 className="pfa-search-bar__title">{settings.searchTitle}</h1>
				<div className="pfa-search-bar__search">{children}</div>
			</div>
		</div>
	);
};

export default SearchBar;
