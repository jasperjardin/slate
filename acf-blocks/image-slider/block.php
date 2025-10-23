<?php
/**
 * Image Slider Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

$images     = get_field( 'images' );
$style      = get_field( 'style' );
$image_size = 'carousel' === $style ? '16x9-md' : '16x9-lg';

$block_classes  = 'acf-block block-image-slider';
$block_classes .= $acf_block->get_settings_classes( true );

if ( ! empty( $style ) ) {
	$block_classes .= ' block-image-slider--' . $style;
}

if ( is_array( $images ) && ! empty( $images ) ) :
	?>
	<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="light">
		<div class="container">
			<?php
			get_component(
				'image-slider',
				array(
					'images'        => $images,
					'image_size'    => $image_size,
					'display_count' => 'carousel' !== $style,
				)
			);
			?>
		</div>
	</section>
	<?php
elseif ( is_admin() ) :
	get_component(
		'edit-acf-block',
		array( 'title' => __( 'Image Slider', 'impulse' ) )
	);
endif;
