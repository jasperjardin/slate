<?php
/**
 * Post Slider Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

global $post;

$acf_block = new ACF_Block( $block, $wp_block );

$post_ids               = get_field( 'posts' );
$fill_most_recent_posts = get_field( 'fill_most_recent_posts' );

$post_object_type = isset( $post ) && is_a( $post, 'WP_Post' )
	? $post->post_type
	: 'post';

$post_objects = array();
if ( ! empty( $post_ids ) ) {
	$post_objects = get_posts(
		array(
			'post_type'      => 'any',
			'post__in'       => $post_ids,
			'orderby'        => 'post__in',
			'posts_per_page' => 16,
		)
	);
}

// Get posts if no posts were manually selected OR fill most recent posts was checked.
if ( ( count( $post_objects ) < 8 && $fill_most_recent_posts ) || empty( $post_objects ) ) {
	// If we're on a single page and can filter by related category, lets do that first.
	if ( isset( $post ) && is_a( $post, 'WP_Post' ) && get_primary_term( $post, 'category' ) ) {
		$category = get_primary_term( $post, 'category' );

		$remaining_count = min( 8 - count( $post_objects ), 0 );
		$remaining_posts = get_posts(
			array(
				'post_type'      => $post_object_type,
				'posts_per_page' => $remaining_count,
				'orderby'        => 'date',
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				'tax_query'      => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $category->term_id,
					),
				),
				'exclude'        => $post->ID,
			)
		);

		$post_objects = array(
			...$post_objects,
			...$remaining_posts,
		);
	}

	// Fill the rest from any category.
	if ( count( $post_objects ) < 8 ) {
		$remaining_count = min( 8 - count( $post_objects ), 0 );
		$remaining_posts = get_posts(
			array(
				'post_type'      => $post_object_type,
				'posts_per_page' => $remaining_count,
				'orderby'        => 'date',
				'exclude'        => is_single() ? $post->ID : array(),
			)
		);

		$post_objects = array(
			...$post_objects,
			...$remaining_posts,
		);
	}
}

// Set block classes.
$block_classes  = 'acf-block block-post-slider';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section
	class="<?= esc_attr( $block_classes ); ?>"
	id="<?= esc_attr( $acf_block->get_id() ); ?>"
	data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>"
>
	<div class="container">
		<div class="post-slider">
			<div class="post-slider__slides swiper-wrapper">
				<?php
				$card_theme = 'light' === $acf_block->get_theme() ? 'gray' : 'light';

				foreach ( $post_objects as $post_object ) :
					?>
					<div class="post-slider__slide swiper-slide">
						<?php
						get_component(
							'post-card',
							array(
								'post'  => $post_object,
								'theme' => $card_theme,
							)
						);
						?>
					</div>
					<?php
				endforeach;
				?>
			</div>
			<?php get_component( 'slider-pagination' ); ?>
		</div>
	</div>
</section>
