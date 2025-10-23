<?php
/**
 * Post Filters Archive Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

$args           = array(
	'search_title'          => get_field( 'search_title' ) ?? '',
	'post_type'             => get_field( 'post_type' ) ?? '',
	'show_search'           => get_field( 'show_search' ) ?? false,
	'selected_category'     => get_field( 'selected_category' ) ?? false,
	'filterable_taxonomies' => get_field( 'filterable_taxonomies' ) ?? array(),
	'posts_per_page'        => get_field( 'posts_per_page' ) ?? 12, // phpcs:ignore WordPress.WP.PostsPerPage.posts_per_page_posts_per_page
	'add_search_to_url'     => get_field( 'add_search_to_url' ) ?? false,
	'add_page_to_url'       => get_field( 'add_page_to_url' ) ?? false,
	'add_filters_to_url'    => get_field( 'add_filters_to_url' ) ?? false,
	'pagination_type'       => get_field( 'pagination_type' ) ?? 'load_more',
	'post_author'           => get_field( 'post_author' ) ?? false,
);
$block_classes  = 'acf-block block-post-filters-archive';
$block_classes .= $acf_block->get_settings_classes( true );

$args['selected_tax'] = array();
if ( $args['selected_category'] ) {
	$args['selected_tax']['category'] = $args['selected_category'];
}

if ( ! is_admin() ) :
	?>

	<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
		<div class="container">
			<?php get_component( 'post-filters-archive', $args ); ?>
		</div>
	</section>

	<?php
elseif ( is_admin() ) :
	get_component(
		'edit-acf-block',
		array(
			'title' => __( 'Post Filters Archive', 'impulse' ),
		)
	);
endif;
