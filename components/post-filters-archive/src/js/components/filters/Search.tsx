import * as React from 'react';
import { useFiltersContext } from '../../contexts/filters';

const Search = () => {
	const { searchQuery, setSearchQuery } = useFiltersContext();
	const [value, setValue] = React.useState(searchQuery);

	React.useEffect(() => {
		const updateSearchQuery = () => {
			if (setSearchQuery) {
				setSearchQuery(value);

				if (window.dataLayer) {
					window.dataLayer.push({
						event: 'post_filter',
						filter: 'search',
						filter_selection: value, // eslint-disable-line camelcase
					});
				}
			}
		};

		const delayDebounceFn = setTimeout(updateSearchQuery, 600);

		return () => clearTimeout(delayDebounceFn);
	}, [value]);

	React.useEffect(() => {
		if (!searchQuery.length) {
			setValue('');
		}
	}, [searchQuery]);

	const searchParentRef = React.useRef<HTMLDivElement | null>(null);
	const handleOnFocus = () => {
		if (null !== searchParentRef.current) {
			searchParentRef.current.classList.add('pfa-filter-search--focus');
		}
	};

	const handleOnBlur = () => {
		if (null !== searchParentRef.current) {
			searchParentRef.current.classList.remove('pfa-filter-search--focus');
		}
	};

	return (
		<div className="pfa-filter-search">
			<div className="pfa-filter-search__wrapper" ref={searchParentRef}>
				<input
					className="pfa-filter-search__input"
					type="text"
					value={value}
					onChange={(e) => setValue(e.target.value)}
					placeholder="Search"
					onFocus={() => handleOnFocus()}
					onBlur={() => handleOnBlur()}
					id="pfa-filter-search"
				/>

				<button
					className="pfa-filter-search__icon"
					onClick={() => setValue('')}
					aria-label={value.length ? 'Clear search' : 'Search'}
				>
					{!!value.length ? (
						<svg
							width="24"
							height="24"
							viewBox="0 0 24 24"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path d="M12 10.5856L4.63602 3.22168L3.2218 4.63589L10.5858 11.9999L3.2218 19.3638L4.63602 20.778L12 13.4141L19.3639 20.778L20.7782 19.3638L13.4142 11.9999L20.7782 4.63589L19.3639 3.22168L12 10.5856Z" />
						</svg>
					) : (
						<svg
							width="24"
							height="24"
							viewBox="0 0 24 24"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path
								fillRule="evenodd"
								clipRule="evenodd"
								d="M4.61594 4.47348C1.44296 7.64646 1.44296 12.7909 4.61594 15.9638C7.50903 18.8569 12.0411 19.1121 15.2233 16.7294L20.5502 22.0564L21.9645 20.6421L16.6663 15.344C19.2668 12.1528 19.0801 7.44728 16.1063 4.47348C12.9333 1.30051 7.78891 1.30051 4.61594 4.47348ZM6.03015 14.5496C3.63822 12.1577 3.63822 8.27962 6.03015 5.8877C8.42208 3.49577 12.3002 3.49577 14.6921 5.8877C17.084 8.27962 17.084 12.1577 14.6921 14.5496C12.3002 16.9416 8.42208 16.9416 6.03015 14.5496Z"
							/>
						</svg>
					)}
				</button>
			</div>
		</div>
	);
};

Search.displayName = 'Search';

export default Search;
