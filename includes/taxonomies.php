<?php
/**
 * Register taxonomies
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
function get_tax_args( string $singular, string $plural = '', array $args = array() ): array {
	if ( empty( $plural ) ) {
		$plural = $singular;
	}

	$labels = array(
		'name'              => $plural,
		'singular_name'     => $singular,
		/* translators: %s: Singular post type name (e.g., "Post"). */
		'search_items'      => sprintf( __( 'Search %s', 'impulse' ), $plural ),
		/* translators: %s: Plural post type name (e.g., "Posts"). */
		'all_items'         => sprintf( __( 'All %s', 'impulse' ), $plural ),
		/* translators: %s: Singular post type name (e.g., "Post"). */
		'view_item'         => sprintf( __( 'View %s', 'impulse' ), $singular ),
		/* translators: %s: Singular taxonomy name (e.g., "Category"). */
		'parent_item'       => sprintf( __( 'Parent %s', 'impulse' ), $singular ),
		/* translators: %s: Singular post type name (e.g., "Post"). */
		'parent_item_colon' => sprintf( __( 'Parent %s:', 'impulse' ), $singular ),
		/* translators: %s: Singular post type name (e.g., "Post"). */
		'edit_item'         => sprintf( __( 'Edit %s', 'impulse' ), $singular ),
		/* translators: %s: Singular post type name (e.g., "Post"). */
		'update_item'       => sprintf( __( 'Update %s', 'impulse' ), $singular ),
		/* translators: %s: Singular post type name (e.g., "Post"). */
		'add_new_item'      => sprintf( __( 'Add New %s', 'impulse' ), $singular ),
		/* translators: %s: Singular taxonomy name (e.g., "Category"). */
		'new_item_name'     => sprintf( __( 'New %s Name', 'impulse' ), $singular ),
		/* translators: %s: Plural taxonomy name (e.g., "Categories"). */
		'not_found'         => sprintf( __( 'No %s Found', 'impulse' ), $plural ),
		/* translators: %s: Plural taxonomy name (e.g., "Categories"). */
		'back_to_items'     => sprintf( __( 'Back to %s', 'impulse' ), $plural ),
		'menu_name'         => $singular,
	);

	return wp_parse_args(
		$args,
		array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
		)
	);
}

/**
 * Example on how to register a taxonomy
 */
// phpcs:disable

// function imp_department() {
// 	$args = get_tax_args(
// 		'Department',
// 		'Departments'
// 	);

// 	register_taxonomy( 'department', 'staff', $args );
// }

// add_action( 'init', 'imp_department', 0 );

// phpcs:enable
