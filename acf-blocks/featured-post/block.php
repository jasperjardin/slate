<?php
/**
 * Featured Post Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block              = new ACF_Block( $block, $wp_block );
$object_id              = get_field( 'post' );
$mobile_image_alignment = get_field( 'mobile_image_alignment' );

// Get post, if not found, exit early.
$featured_post = get_post( $object_id );
if ( ! $featured_post instanceof WP_Post || 'draft' === $post->post_status ) {
	return;
}

// Get featured image, if not found, exit early.
$featured_image = get_post_thumbnail_id( $featured_post->ID );
if ( ! $featured_image ) {
	return;
}

$object_post_type = get_post_type_object( $featured_post->post_type );
$post_type_label  = $object_post_type ? $object_post_type->labels->singular_name : '';

$block_classes  = 'acf-block block-featured-post';
$block_classes .= $acf_block->get_settings_classes( true );
if ( ! empty( $mobile_image_alignment ) ) {
	$block_classes .= ' block-featured-post__mobile-image-pos--' . $mobile_image_alignment;
}
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="container">
		<div class="block-featured-post__content">
			<div class="block-featured-post__image">
				<?= wp_get_attachment_image( $featured_image, '16x9-blog' ); ?>
			</div>

			<div class="block-featured-post__context">
				<div class="block-featured-post__meta">
					<span class="block-featured-post__meta-post-type">
						<?php
						// translators: %s is the post type label.
						esc_html_e( sprintf( __( 'Featured %s', 'impulse' ), $post_type_label ) );
						?>
					</span>
				</div>

				<h2 class="block-featured-post__title">
					<?= esc_html( $featured_post->post_title ); ?>
				</h2>

				<div class="block-featured-post__date"><?= esc_html( get_the_date( 'n/j/y', $featured_post ) ); ?></div>

				<?php if ( ! empty( $featured_post->post_excerpt ) ) : ?>
					<p class="block-featured-post__excerpt">
						<?= wp_kses_post( $featured_post->post_excerpt ); ?>
					</p>
				<?php endif; ?>

				<a href="<?= esc_url( get_permalink( $featured_post->ID ) ); ?>" class="block-featured-post__link">
					<?php
					// translators: % is the post type label.
					esc_html_e( sprintf( __( 'View %s', 'impulse' ), $post_type_label ) );
					?>
				</a>
			</div>
		</div>
	</div>
</section>
