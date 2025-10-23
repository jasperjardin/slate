<?php
/**
 * CTA Box Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

// InnerBlocks templating.
$allowed_blocks = array_diff(
	get_allowed_content_blocks(),
	array( 'acf/buttons' )
);
$template       = array(
	array(
		'core/heading',
		array(
			'placeholder' => 'Elementum sed sed mauris semper',
			'level'       => 2,
			'fontSize'    => 't4',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Massa vel sapien pellentesque vulputate lectus. Ut semper sit morbi tempus porta.',
		),
	),
);

$style       = get_field( 'style' ) ?: 'is-style-default';
$cta_buttons = get_field( 'cta_buttons' );
$image       = get_field( 'image' ) ?: 0;

// Set block classes.
$block_classes  = 'acf-block block-cta-box';
$block_classes .= $acf_block->get_settings_classes( true );
if ( ! empty( $style ) ) {
	$block_classes .= ' ' . esc_attr( $style );
}
if ( ! empty( $image ) ) {
	$block_classes .= ' has-image';
}
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="container">
		<div class="block-cta-box__wrapper">
			<div class="block-cta-box__inner">
				<div class="block-cta-box__content cms">
					<InnerBlocks
						template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
						allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
					/>
				</div>
				<?php if ( ! empty( $cta_buttons ) && is_array( $cta_buttons ) ) : ?>
					<div class="block-cta-box__buttons">
						<?php
						foreach ( $cta_buttons as $button ) {
							echo array_to_link( $button['link'], $button['style'] );
						}
						?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $image ) ) : ?>
				<figure class="block-cta-box__image">
					<?= wp_get_attachment_image( $image, '3x2-md' ); ?>
				</figure>
			<?php endif; ?>
		</div>
	</div>
</section>
