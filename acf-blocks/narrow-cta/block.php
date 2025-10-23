<?php
/**
 * Narrow CTA Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

$image = get_field( 'image' );

// InnerBlocks templating.
$allowed_blocks = get_allowed_content_blocks();
$template       = array(
	array(
		'core/heading',
		array(
			'placeholder' => 'Lorem ipsum dolor sit amet',
			'level'       => 3,
			'fontSize'    => 't5',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Lacus nunc tristique et purus aliquet nullam arcu platea at tellus duis eu volutpat senectus elit',
		),
	),
);

// Set block classes.
$block_classes  = 'block-narrow-cta';
$block_classes .= $acf_block->get_settings_classes( true );
if ( ! empty( $image ) ) {
	$block_classes .= ' block-narrow-cta--has-image';
}
?>

<div class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="block-narrow-cta__wrapper">
		<div class="block-narrow-cta__content">
			<InnerBlocks
				template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
				allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
			/>
		</div>
		<figure class="block-narrow-cta__img-container">
			<?php
			echo wp_get_attachment_image(
				$image,
				'3x2-md',
				false,
				array(
					'class' => 'block-narrow-cta__img',
				)
			);
			?>
		</figure>
	</div>
</div>
