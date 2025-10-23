// Typing isn't strong enough in Gutenberg
/* eslint-disable @typescript-eslint/no-explicit-any */
import { stretchWide, alignNone, positionCenter } from '@wordpress/icons';

const { BlockControls } = wp.blockEditor;
const { Icon, Toolbar, ToolbarDropdownMenu } = wp.components;
const { addFilter } = wp.hooks;
const { Fragment } = wp.element;
const { createHigherOrderComponent } = wp.compose;
const { hasBlockSupport, getBlockSupport } = wp.blocks;

class ContentWidth {
	ContentWidthToolbar = (props: any) => {
		const { name, attributes, setAttributes } = props;
		const { contentWidth } = attributes;

		const iconStretchWide = <Icon icon={stretchWide} width="24" height="24" />;
		const iconStretchFull = <Icon icon={alignNone} width="24" height="24" />;
		const iconStretchSlim = <Icon icon={positionCenter} width="24" height="24" />;

		const icons = {
			default: alignNone,
			full: stretchWide,
			10: positionCenter,
			8: positionCenter,
			6: positionCenter,
		};

		let controls = [
			{
				title: 'Default',
				icon: iconStretchFull,
				role: 'menuitemradio',
				name: 'default',
				isActive: contentWidth === 'default' ? true : false,
				onClick: () => {
					setAttributes({
						contentWidth: 'default',
					});
				},
			},
			{
				title: 'Full Width',
				icon: iconStretchWide,
				role: 'menuitemradio',
				name: 'full-width',
				isActive: contentWidth === 'full' ? true : false,
				onClick: () => {
					setAttributes({
						contentWidth: 'full',
					});
				},
			},
			{
				title: '10 Columns',
				icon: iconStretchSlim,
				role: 'menuitemradio',
				name: '10',
				isActive: contentWidth === '10' ? true : false,
				onClick: () => {
					setAttributes({
						contentWidth: '10',
					});
				},
			},
			{
				title: '8 Columns',
				icon: iconStretchSlim,
				role: 'menuitemradio',
				name: '8',
				isActive: contentWidth === '8' ? true : false,
				onClick: () => {
					setAttributes({
						contentWidth: '8',
					});
				},
			},
			{
				title: '6 Columns',
				icon: iconStretchSlim,
				role: 'menuitemradio',
				name: '6',
				isActive: contentWidth === '6' ? true : false,
				onClick: () => {
					setAttributes({
						contentWidth: '6',
					});
				},
			},
		];

		const blockSupport = getBlockSupport(name, 'contentWidth');
		if (Array.isArray(blockSupport)) {
			controls = controls.filter((control) => blockSupport.includes(control.name));
		}

		return (
			<BlockControls group="block">
				<Toolbar>
					<ToolbarDropdownMenu
						icon={contentWidth ? icons[contentWidth as keyof object] : alignNone}
						label="Content Width"
						controls={controls}
					/>
				</Toolbar>
			</BlockControls>
		);
	};

	/**
	 * Create attribute for Content Width on all ACF blocks.
	 *
	 * @param settings
	 * @param settings.attributes
	 * @param settings.attributes.contentWidth
	 * @param settings.name
	 */
	addContentWidthAttribute = (settings: {
		attributes: { contentWidth: string };
		name: string;
	}) => {
		// check if object exists for old Gutenberg version compatibility
		if (
			hasBlockSupport(settings.name, 'contentWidth') &&
			typeof settings.attributes !== 'undefined'
		) {
			if (!settings.attributes.contentWidth) {
				settings.attributes = Object.assign(settings.attributes, {
					contentWidth: {
						type: 'string',
						default: '',
					},
				});
			}
		}

		return settings;
	};

	/**
	 * Create Content Width toolbar item.
	 */
	addContentWidthToolbar = createHigherOrderComponent((BlockEdit: any) => {
		return (props: any) => {
			const { name, isSelected } = props;

			if (!hasBlockSupport(name, 'contentWidth')) {
				return <BlockEdit {...props} />;
			}

			const ContentWidthToolbar: any = this.ContentWidthToolbar;

			return (
				<Fragment>
					<BlockEdit {...props} />
					{isSelected && <ContentWidthToolbar {...props} />}
				</Fragment>
			);
		};
	}, 'addContentWidthToolbar');

	/**
	 * Apply has-content-width-* class to block in editor.
	 */
	addContentWidthClass = createHigherOrderComponent((BlockListBlock: any) => {
		return (props: any) => {
			const { attributes } = props;

			const { contentWidth } = attributes;
			const customClass = contentWidth ? 'has-content-width-' + contentWidth : '';

			return <BlockListBlock {...props} className={customClass} />;
		};
	}, 'addContentWidthClass');

	addContentWidth = () => {
		addFilter(
			'blocks.registerBlockType',
			'impulse/custom-attribute',
			this.addContentWidthAttribute
		);
		addFilter(
			'editor.BlockEdit',
			'impulse/custom-toolbar-control',
			this.addContentWidthToolbar
		);
		addFilter(
			'editor.BlockListBlock',
			'impulse/custom-block-editor-class',
			this.addContentWidthClass
		);
	};
}

export default new ContentWidth();
