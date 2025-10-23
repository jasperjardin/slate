<?php
/**
 * Register post types.
 *
 * @package imp
 */

/**
 * Get post type args
 *
 * Helper function to set defaults and create all labels for a post type.
 *
 * @param string $singular  Singlar title for the post type.
 * @param string $plural    Plural or "general" name for the post type.
 * @param array  $args      Additional args to override the defaults.
 * @return array
 */
function get_post_type_args( string $singular, string $plural = '', array $args = array() ): array {
	if ( empty( $plural ) ) {
		$plural = $singular;
	}

	$plural_lower   = strtolower( $plural );
	$singular_lower = strtolower( $singular );

	return wp_parse_args(
		$args,
		array(
			'label'              => $singular,
			/* translators: %s: Singular post type name (e.g., "Post"). */
			'description'        => sprintf( __( '%s post type', 'impulse' ), $singular ),
			'labels'             => array(
				'name'                  => $plural,
				'singular_name'         => $singular,
				'menu_name'             => $plural,
				'name_admin_bar'        => $singular,
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'archives'              => sprintf( __( '%s Archives', 'impulse' ), $singular ),
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'attributes'            => sprintf( __( '%s Attributes', 'impulse' ), $singular ),
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'parent_item_colon'     => sprintf( __( 'Parent %s:', 'impulse' ), $singular ),
				/* translators: %s: Plural post type name (e.g., "Posts"). */
				'all_items'             => sprintf( __( 'All %s', 'impulse' ), $plural ),
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'add_new_item'          => sprintf( __( 'Add New %s', 'impulse' ), $singular ),
				'add_new'               => __( 'Add New', 'impulse' ),
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'new_item'              => sprintf( __( 'New %s', 'impulse' ), $singular ),
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'edit_item'             => sprintf( __( 'Edit %s', 'impulse' ), $singular ),
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'update_item'           => sprintf( __( 'Update %s', 'impulse' ), $singular ),
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'view_item'             => sprintf( __( 'View %s', 'impulse' ), $singular ),
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'view_items'            => sprintf( __( 'View %s', 'impulse' ), $plural ),
				/* translators: %s: Singular post type name (e.g., "Post"). */
				'search_items'          => sprintf( __( 'Search %s', 'impulse' ), $singular ),
				'not_found'             => __( 'Not found', 'impulse' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'impulse' ),
				'featured_image'        => __( 'Featured Image', 'impulse' ),
				'set_featured_image'    => __( 'Set featured image', 'impulse' ),
				'remove_featured_image' => __( 'Remove featured image', 'impulse' ),
				'use_featured_image'    => __( 'Use as featured image', 'impulse' ),
				/* translators: %s: Lowercase singular post type name (e.g., "post"). */
				'insert_into_item'      => sprintf( __( 'Insert into %s', 'impulse' ), $singular_lower ),
				/* translators: %s: Lowercase singular post type name (e.g., "post"). */
				'uploaded_to_this_item' => sprintf( __( 'Uploaded to this %s', 'impulse' ), $singular_lower ),
				/* translators: %s: Plural post type name (e.g., "Posts"). */
				'items_list'            => sprintf( __( '%s list', 'impulse' ), $plural ),
				/* translators: %s: Plural post type name (e.g., "Posts"). */
				'items_list_navigation' => sprintf( __( '%s list navigation', 'impulse' ), $plural ),
				/* translators: %s: Lowercase plural post type name (e.g., "posts"). */
				'filter_items_list'     => sprintf( __( 'Filter %s list', 'impulse' ), $plural_lower ),
			),
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
			'taxonomies'         => array(),
			'menu_icon'          => '',
			'hierarchical'       => false,
			'public'             => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_position'      => 19,
			'show_in_admin_bar'  => true,
			'show_in_nav_menus'  => true,
			'can_export'         => true,
			'has_archive'        => false,
			'publicly_queryable' => true,
			'capability_type'    => 'page',
			'show_in_rest'       => true,
			'rewrite'            => array( 'with_front' => false ),
		)
	);
}

/**
 * Register module post type.
 *
 * @return void
 */
function imp_module() {
	$args = get_post_type_args(
		'Module',
		'Module Library',
		array(
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'supports'            => array( 'title', 'thumbnail', 'editor', 'page-attributes', 'custom-fields' ),
			'exclude_from_search' => true,
			'has_archive'         => 'module-library',
		)
	);

	register_post_type( 'module', $args );
}

add_action( 'init', 'imp_module', 0 );

/**
 * Disable block editor for certain post types
 *
 * @param boolean $use_block_editor  Whether or not to use the block editor.
 * @param string  $post_type         Post type slug.
 * @return bool
 */
function imp_disable_gutenberg_by_post_type( bool $use_block_editor, string $post_type ) {
	// Add post types here.
	$disabled_post_types = array();

	return in_array( $post_type, $disabled_post_types, true ) ? false : $use_block_editor;
}

add_filter( 'use_block_editor_for_post_type', 'imp_disable_gutenberg_by_post_type', 100, 2 );

/**
 * Register mega menu post type.
 *
 * @return void
 */
function imp_mega_menu() {
	$args = get_post_type_args(
		__( 'Mega Menu Item', 'impulse' ),
		__( 'Mega Menu', 'impulse' ),
		array(
			'menu_icon'           => 'dashicons-welcome-widgets-menus',
			'supports'            => array( 'title' ),
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
		)
	);

	register_post_type( 'mega_menu', $args );
}

add_action( 'init', 'imp_mega_menu', 0 );
