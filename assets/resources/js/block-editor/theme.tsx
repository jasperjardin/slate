/* eslint-disable @typescript-eslint/no-explicit-any */
const { blockEditor, components, hooks, element, compose, blocks } = wp;
const { BlockControls } = blockEditor;
const { Toolbar, ToolbarDropdownMenu } = components;
const { addFilter } = hooks;
const { Fragment } = element;
const { createHigherOrderComponent } = compose;
const { hasBlockSupport, getBlockSupport } = blocks;

class Theme {
	ThemeToolbar = (props: any) => {
		const { name, attributes, setAttributes } = props;
		const { theme } = attributes;

		const themes: ITheme[] = 'undefined' !== typeof window.impThemes ? window.impThemes : [];

		let controls = themes.map((themeItem) => ({
			title: themeItem.name,
			isActive: themeItem.slug === theme,
			onClick: () => setAttributes({ theme: themeItem.slug }),
			style: { backgroundColor: themeItem.color },
			slug: themeItem.slug,
		}));

		const blockSupport = getBlockSupport(name, 'theme');
		if (Array.isArray(blockSupport)) {
			controls = controls.filter((control) => blockSupport.includes(control.slug));
		}

		const selectedTheme = themes.find((themeItem) => themeItem.slug === theme) ?? themes[0];

		return (
			<BlockControls group="block">
				<Toolbar>
					<ToolbarDropdownMenu
						icon={
							<span className="imp-theme-selector">
								<span
									className="imp-theme-selector__swatch"
									style={{
										backgroundColor: selectedTheme?.color,
									}}
								/>
								{selectedTheme?.name}
							</span>
						}
						label="Select Theme"
						controls={controls}
					/>
				</Toolbar>
			</BlockControls>
		);
	};

	addThemeAttribute = (settings: { attributes: { theme: string }; name: string }) => {
		if (hasBlockSupport(settings.name, 'theme') && typeof settings.attributes !== 'undefined') {
			if (!settings.attributes.theme) {
				settings.attributes = Object.assign(settings.attributes, {
					theme: {
						type: 'string',
						default: 'default',
					},
				});
			}
		}

		return settings;
	};

	addThemeToolbar = createHigherOrderComponent((BlockEdit: any) => {
		return (props: any) => {
			const { name, isSelected } = props;

			if (!hasBlockSupport(name, 'theme')) {
				return <BlockEdit {...props} />;
			}

			const ThemeToolbar: any = this.ThemeToolbar;

			return (
				<Fragment>
					<BlockEdit {...props} />
					{isSelected && <ThemeToolbar {...props} />}
				</Fragment>
			);
		};
	}, 'addThemeToolbar');

	addThemeClass = createHigherOrderComponent((BlockListBlock: any) => {
		return (props: any) => {
			const { attributes } = props;
			const { theme } = attributes;
			const customClass = theme ? 'has-theme-' + theme : '';

			return <BlockListBlock {...props} className={customClass} />;
		};
	}, 'addThemeClass');

	addTheme = () => {
		addFilter('blocks.registerBlockType', 'impulse/custom-attribute', this.addThemeAttribute);
		addFilter('editor.BlockEdit', 'impulse/custom-toolbar-control', this.addThemeToolbar);
		addFilter('editor.BlockListBlock', 'impulse/custom-block-editor-class', this.addThemeClass);
	};
}

export default new Theme();
