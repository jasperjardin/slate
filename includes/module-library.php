<?php
/**
 * Module Library
 *
 * @package imp
 */

/**
 * Module post type redirect
 *
 * @return void
 */
function imp_module_redirect() {
	global $wp_query, $post;

	if ( is_single() && 'module' === $post->post_type ) {
		wp_safe_redirect( home_url() . '/module-library/?modules=' . $post->ID );
	}
}

add_action( 'template_redirect', 'imp_module_redirect', PHP_INT_MAX );

/**
 * Register module category meta
 *
 * @return void
 */
function imp_register_module_category_meta() {
	register_post_meta(
		'module',
		'_module_cats',
		array(
			'single'        => true,
			'type'          => 'array',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
			'show_in_rest'  => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'string',
					),
				),
			),
		)
	);

	register_post_meta(
		'module',
		'_module_types',
		array(
			'single'        => true,
			'type'          => 'array',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
			'show_in_rest'  => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'string',
					),
				),
			),
		)
	);
}

add_action( 'init', 'imp_register_module_category_meta', 0 );

/**
 * Add noindex, nofollow to module post type archive
 *
 * @param array $robots Robots meta tag values.
 * @return array Modified robots meta tag values.
 */
function imp_module_archive_noindex( $robots ) {
	if ( is_post_type_archive( 'module' ) ) {
		$robots = array(
			'noindex'  => true,
			'nofollow' => true,
		);
	}

	return $robots;
}
add_filter( 'wp_robots', 'imp_module_archive_noindex', PHP_INT_MAX );
