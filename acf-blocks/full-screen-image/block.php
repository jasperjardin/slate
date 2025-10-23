<?php
/**
 * Full Screen Image Block
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
$allowed_blocks = get_allowed_content_blocks();
$template       = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Lorem Ipsum Dolor',
			'fontSize'    => 'supertext',
		),
	),
	array(
		'core/heading',
		array(
			'placeholder' => 'Nisi ut mauris mauris erat.',
			'level'       => 2,
			'fontSize'    => 't1',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam egestas turpis at lacus sollicitudin lobortis. Vivamus in risus non quam cursus vehicula. Suspendisse maximus maximus efficitur.',
		),
	),
);

$background_image = get_field( 'background_image' );

// Set block classes.
$block_classes  = 'block-full-screen-image';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="dark">
	<div class="container">
		<div class="block-full-screen-image__wrapper">
			<div class="block-full-screen-image__content cms">
				<InnerBlocks
					template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
					allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
				/>
			</div>
		</div>
	</div>
	<?php if ( ! empty( $background_image ) ) : ?>
		<div class="block-full-screen-image__background">
			<?= wp_get_attachment_image( $background_image, 'full-width' ); ?>
		</div>
	<?php endif; ?>
</section>
