<?php
/**
 * Post Filters Archive partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'post_type'             => '',
		'show_search'           => false,
		'filterable_taxonomies' => array(),
		'selected_tax'          => array(),
		'search_title'          => '',
		'posts_per_page'        => 12,
		'layout'                => 'default',
		'add_search_to_url'     => false,
		'add_page_to_url'       => false,
		'add_filters_to_url'    => false,
		'pagination_type'       => 'load_more',
		'post_author'           => false,
	)
);

if ( empty( $args['filterable_taxonomies'] ) ) {
	$args['filterable_taxonomies'] = '';
} else {
	$args['filterable_taxonomies'] = implode( ',', $args['filterable_taxonomies'] );
}
?>

<div class="post-filters-archive"
	data-api-base="<?= esc_url( home_url() . '/wp-json/post-filters-archive' ); ?>"
	data-post-type="<?= esc_attr( $args['post_type'] ); ?>"
	data-posts-per-page="<?= esc_attr( $args['posts_per_page'] ); ?>"
	data-filters-to-show="<?= esc_attr( $args['filterable_taxonomies'] ); ?>"
	data-show-search="<?= esc_attr( $args['show_search'] ); ?>"
	data-selected-tax="<?= esc_attr( wp_json_encode( $args['selected_tax'] ) ); ?>"
	data-search-title="<?= esc_attr( $args['search_title'] ); ?>"
	data-layout="<?= esc_attr( $args['layout'] ); ?>"
	data-add-search-to-url="<?= esc_attr( $args['add_search_to_url'] ); ?>"
	data-add-filters-to-url="<?= esc_attr( $args['add_filters_to_url'] ); ?>"
	data-add-page-to-url="<?= esc_attr( $args['add_page_to_url'] ); ?>"
	data-pagination-type="<?= esc_attr( $args['pagination_type'] ); ?>"
	data-post-author="<?= esc_attr( $args['post_author'] ); ?>"
></div>
