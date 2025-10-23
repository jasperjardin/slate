<?php
/**
 * Post Card partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'post'  => 0,
		'theme' => null,
	)
);

$post_object = $args['post'] ?: get_post( $args['post'] );

if ( is_a( $post_object, 'WP_Post' ) ) {
	$partial = match ( $post_object->post_type ) {
		// phpcs:ignore Squiz.PHP.CommentedOutCode.Found -- Example for building new cards based on post type.,
		// 'resource' => './resource.php'
		default => 'default.php',
	};

	$theme = $args['theme'];

	include $partial;
}
