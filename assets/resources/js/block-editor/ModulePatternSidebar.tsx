const { __ } = wp.i18n;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;

const { PluginDocumentSettingPanel } = wp.editor;
const { BaseControl, CheckboxControl, PanelRow } = wp.components;

interface IPostMeta {
	[key: string]: Array<string>;
}

interface IProps {
	postMeta: IPostMeta;
	postType: string;
	setPostMeta: React.Dispatch<React.SetStateAction<IPostMeta>>;
	postTypes: Array<{ [key: string]: any }>; // eslint-disable-line @typescript-eslint/no-explicit-any
}

const ModulePatternSidebar = ({ postMeta, postType, setPostMeta, postTypes }: IProps) => {
	if ('module' !== postType) {
		return <></>;
	}

	const moduleCats: Array<string> =
		'undefined' !== typeof postMeta && 'undefined' !== typeof postMeta._module_cats
			? postMeta._module_cats
			: [];

	const cats = moduleCatSidebar.registeredCats.map((option) => {
		return {
			value: option.name,
			label: option.label,
			disabled: false,
		};
	});

	const modulePostTypes =
		'undefined' !== typeof postMeta && 'undefined' !== typeof postMeta._module_types
			? postMeta._module_types
			: [];

	const types = (moduleCatSidebar.registeredPostTypes = postTypes
		.filter(
			(type) =>
				type.viewable !== false &&
				type.visibility.show_in_nav_menus !== false &&
				type.slug !== 'module'
		)
		.map((type) => {
			return {
				value: type.slug,
				label: type.labels.singular_name,
			};
		}));

	return (
		<>
			<PluginDocumentSettingPanel
				title={__('Pattern Category', 'imp')}
				name="module-pattern-cat-panel"
			>
				<div className="module-pattern-sidebar">
					<PanelRow>
						<BaseControl>
							{cats.map((item, index) => {
								const handleOnChange = (value: boolean) => {
									let newMeta = [...moduleCats];
									if (!newMeta.includes(item.value) && value) {
										newMeta.push(item.value);
									} else if (moduleCats.includes(item.value) && !value) {
										newMeta = newMeta.filter((cat) => cat !== item.value);
									}

									setPostMeta({
										// eslint-disable-next-line camelcase
										_module_cats: newMeta,
									});
								};

								return (
									<CheckboxControl
										key={index}
										label={item.label}
										checked={moduleCats.includes(item.value) ? true : false}
										onChange={handleOnChange}
									/>
								);
							})}
						</BaseControl>
					</PanelRow>
				</div>
			</PluginDocumentSettingPanel>
			<PluginDocumentSettingPanel
				title={__('Pattern Post Type', 'imp')}
				name="module-pattern-postType-panel"
			>
				<div className="module-pattern-sidebar">
					<PanelRow>
						<BaseControl>
							{types.map((item, index) => {
								const handleOnChange = (value: boolean) => {
									let newMeta = [...modulePostTypes];
									if (!newMeta.includes(item.value) && value) {
										newMeta.push(item.value);
									} else if (modulePostTypes.includes(item.value) && !value) {
										newMeta = newMeta.filter((type) => type !== item.value);
									}

									setPostMeta({
										// eslint-disable-next-line camelcase
										_module_types: newMeta,
									});
								};

								return (
									<CheckboxControl
										key={index}
										label={item.label}
										checked={
											modulePostTypes.includes(item.value) ? true : false
										}
										onChange={handleOnChange}
									/>
								);
							})}
						</BaseControl>
					</PanelRow>
				</div>
			</PluginDocumentSettingPanel>
		</>
	);
};

export default compose([
	// eslint-disable-next-line @typescript-eslint/no-explicit-any
	withSelect((select: any) => {
		return {
			postMeta: select('core/editor').getEditedPostAttribute('meta'),
			postType: select('core/editor').getCurrentPostType(),
			// eslint-disable-next-line camelcase
			postTypes: select('core').getPostTypes({ per_page: -1 }) || [],
		};
	}),
	// eslint-disable-next-line @typescript-eslint/no-explicit-any
	withDispatch((dispatch: any) => {
		return {
			setPostMeta(newMeta: IPostMeta) {
				dispatch('core/editor').editPost({ meta: newMeta });
			},
		};
	}),
])(ModulePatternSidebar);
