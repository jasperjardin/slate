<?php
/**
 * Block editor functions & hooks
 *
 * @package imp
 */

/**
 * Filter allowed block types.
 *
 * @param  array|bool              $allowed_block_types  Which blocks can be displayed in the editor
 * @param  WP_Block_Editor_Context $editor_context       Block editor context.
 * @return array
 */
add_filter(
	'allowed_block_types_all',
	function ( $allowed_block_types, WP_Block_Editor_Context $editor_context ) {
		$block_types = array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() );
		$acf_blocks  = array_filter( $block_types, fn( $block_name ) => false !== strpos( $block_name, 'acf/' ) );

		if ( ! empty( $editor_context->post ) ) {
			return array(
				'core/block',
				'core/image',
				'core/paragraph',
				'core/heading',
				'core/list',
				'core/list-item',
				'core/quote',
				'core/separator',
				'core/shortcode',
				'core/embed',
				'core/table',
				...$acf_blocks,
			);
		}

		return $allowed_block_types;
	},
	PHP_INT_MAX,
	2
);

/**
 * Remove all editor styles
 *
 * @param array $editor_settings Editor settings.
 * @return array
 */
function imp_remove_editor_styles( array $editor_settings ) {
	unset( $editor_settings['styles'] );
	$editor_settings['styles'] = array();

	return $editor_settings;
}

add_filter( 'block_editor_settings_all', 'imp_remove_editor_styles', PHP_INT_MAX );

/**
 * Init block patterns
 *
 * Remove all core block patterns and add new ones here.
 * Documentation: https://developer.wordpress.org/block-editor/reference-guides/block-api/block-patterns/
 *
 * @return void
 */
function imp_init_block_patterns() {
	remove_theme_support( 'core-block-patterns' );

	$pattern_cats_registry = WP_Block_Pattern_Categories_Registry::get_instance();

	// Remove categories we don't want to display in the backend.
	$pattern_cats_registry->unregister( 'banner' );
	$pattern_cats_registry->unregister( 'buttons' );
	$pattern_cats_registry->unregister( 'columns' );
	$pattern_cats_registry->unregister( 'team' );
	$pattern_cats_registry->unregister( 'services' );
	$pattern_cats_registry->unregister( 'about' );
	$pattern_cats_registry->unregister( 'portfolio' );
	$pattern_cats_registry->unregister( 'testimonials' );
	$pattern_cats_registry->unregister( 'gallery' );
	$pattern_cats_registry->unregister( 'query' );
	$pattern_cats_registry->unregister( 'footer' );
	$pattern_cats_registry->unregister( 'header' );

	// Register new pattern categories.
	$pattern_cats_registry->register(
		'layout',
		array(
			'label'       => esc_html__( 'Layout', 'impulse' ),
			'description' => '',
		)
	);

	$modules = get_posts(
		array(
			'post_type'      => 'module',
			'posts_per_page' => -1,
		)
	);

	foreach ( $modules as $module ) {
		$module_cats = get_post_meta( $module->ID, '_module_cats', true );
		$module_cats = ! empty( $module_cats ) ? $module_cats : array( 'module' );

		$args = array(
			'title'         => $module->post_title,
			'content'       => $module->post_content,
			'viewportWidth' => 1440,
			'categories'    => $module_cats,
		);

		// If post types check off, limit the pattern to the post types specified.
		$post_types = get_post_meta( $module->ID, '_module_types', true );
		if ( ! empty( $post_types ) ) {
			$args['postTypes'] = $post_types;
		}

		register_block_pattern(
			'module/' . $module->post_name,
			$args
		);
	}
}

add_action( 'init', 'imp_init_block_patterns', PHP_INT_MAX );

/**
 * Modify gutenberg filters like colors, font sizes, etc.
 *
 * @return void
 */
add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'disable-custom-colors' );
		add_theme_support( 'disable-custom-font-sizes' );
	}
);

/**
 * Get Allowed Content Blocks
 *
 * @return array
 */
function get_allowed_content_blocks() {
	return array(
		'core/heading',
		'core/paragraph',
		'core/list',
		'acf/buttons',
	);
}

/**
 * Load separate assets for each of the blocks instead of on every page.
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' );

/**
 * Set post type templates
 *
 * @link https://developer.wordpress.org/block-editor/developers/block-api/block-templates/
 */
function post_type_template() {
	$page_type_object           = get_post_type_object( 'page' );
	$page_type_object->template = array(
		array( 'acf/hero' ),
	);
}
add_action( 'init', 'post_type_template' );

/**
 * Disable innerblocks wrapper
 *
 * @return bool
 */
function imp_should_wrap_innerblocks() {
	return false;
}
add_filter( 'acf/blocks/wrap_frontend_innerblocks', 'imp_should_wrap_innerblocks', PHP_INT_MAX );

/**
 * Add UID to blocks
 *
 * This will help ACF's block ID generation to ensure we get unique IDs.
 *
 * @param array $attributes Block attributes.
 * @return array
 */
function imp_add_uid_to_blocks( $attributes ) {
	if ( ! isset( $attributes['data']['uid'] ) || empty( $attributes['data']['uid'] ) ) {
		$attributes['data']['uid'] = uniqid();
	}

	return $attributes;
}
add_filter( 'acf/pre_save_block', 'imp_add_uid_to_blocks' );


if ( class_exists( 'FrmForm' ) ) {
	/**
	 * Populates a field with choices of published Formidable Forms.
	 *
	 * This function retrieves all published Formidable Forms and populates the given field's choices
	 * with the form IDs as keys and form names as values. If no forms are found, a default choice
	 * indicating "No forms found" is added.
	 *
	 * @param array $field The field to be populated with Formidable Forms choices.
	 * @return array The modified field with populated choices.
	 */
	function populate_formidable_forms( $field ) {
		$formidable_forms = FrmForm::get_published_forms();

		$field['choices'] = array();

		if ( ! empty( $formidable_forms ) ) {
			foreach ( $formidable_forms as $form ) {
				$field['choices'][ $form->id ] = $form->name;
			}
		} else {
			$field['choices'][''] = 'No forms found';
		}

		return $field;
	}

	/**
	 * Adds a filter to populate an ACF field with Formidable Forms data.
	 *
	 * This filter hooks into the ACF field with the key 'field_67606b4fa5e45' and
	 * uses the 'populate_formidable_forms' function to populate the field.
	 *
	 * @see https://www.advancedcustomfields.com/resources/acf-load_field/
	 * @see https://formidableforms.com/
	 *
	 * @param array $field The field array containing all settings.
	 * @return array The modified field array.
	 */
	add_filter( 'acf/load_field/key=field_6776ff734b736', 'populate_formidable_forms' );
}
