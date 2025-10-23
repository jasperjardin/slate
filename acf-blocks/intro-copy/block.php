<?php
/**
 * Intro Copy Block
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
		),
	),
);

// Set block classes.
$block_classes  = 'acf-block block-intro-copy';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="container">
		<div class="block-intro-copy__content cms">
			<InnerBlocks
				template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
				allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
			/>
		</div>
	</div>
</section>
