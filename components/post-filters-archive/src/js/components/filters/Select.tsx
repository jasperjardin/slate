import * as React from 'react';
import ReactSelect, {
	DropdownIndicatorProps,
	MultiValue,
	SingleValue,
	components,
} from 'react-select';
import { useFiltersContext } from '../../contexts/filters';
import { ITaxonomy } from '../../types';

interface IProps {
	taxonomy: ITaxonomy;
}

interface ISelectOption {
	label: string;
	value: string;
}

const Select = ({ taxonomy }: IProps) => {
	let options = taxonomy.terms.map((term) => {
		// decode htmlentities.
		const label = document.createElement('textarea');
		label.innerHTML = term.name;

		return {
			label: label.value,
			value: '' + term.term_id,
		};
	});

	options = [{ label: `All ${taxonomy.labels.name}`, value: '' }, ...options];

	const { selectedTax, selectTaxTerm } = useFiltersContext();

	let selectedTermId: number | null = null;
	if (selectedTax[taxonomy.name]) {
		selectedTermId = Array.isArray(selectedTax[taxonomy.name])
			? Number(selectedTax[taxonomy.name][0])
			: Number(selectedTax[taxonomy.name]);
	}

	const initialValue = selectedTermId
		? options.find((opt) => opt.value === String(selectedTermId)) || options[0]
		: options[0];

	const [value, setValue] = React.useState(initialValue);

	const prevValue = React.useRef(options[0].value);
	const handleOnChange = (newValue: SingleValue<ISelectOption> | MultiValue<ISelectOption>) => {
		const option = newValue as SingleValue<ISelectOption>;
		if (option && prevValue.current !== option.value && selectTaxTerm) {
			setValue(option);
			selectTaxTerm(taxonomy.name, +option.value);

			if (window.dataLayer) {
				window.dataLayer.push({
					event: 'post_filter',
					filter: taxonomy.name,
					filter_selection: option.label, // eslint-disable-line camelcase
				});
			}

			prevValue.current = option.value;
		}
	};

	// When filters are reset, set our value back to the first option.
	React.useEffect(() => {
		if ('undefined' === typeof selectedTax[taxonomy.name]) {
			setValue(options[0]);
			prevValue.current = options[0].value;
		}
	}, [selectedTax]);

	const DropdownIndicator = (props: DropdownIndicatorProps<ISelectOption>) => {
		return (
			<components.DropdownIndicator {...props}>
				<svg
					width="20"
					height="20"
					viewBox="0 0 24 24"
					fill="none"
					xmlns="http://www.w3.org/2000/svg"
				>
					<path
						fillRule="evenodd"
						clipRule="evenodd"
						d="M12.0001 14.95L3.81862 6.63867L2.39331 8.04171L12.0001 17.801L21.6068 8.04171L20.1815 6.63867L12.0001 14.95Z"
					/>
				</svg>
			</components.DropdownIndicator>
		);
	};

	return (
		<ReactSelect
			className="pfa-filter-select"
			classNamePrefix="pfa-filter-select"
			options={options}
			components={{ DropdownIndicator }}
			onChange={handleOnChange}
			inputId={`pfa-filter-${taxonomy.name}`}
			value={value}
			key={taxonomy.name}
		/>
	);
};

Select.displayName = 'Select';

export default Select;
