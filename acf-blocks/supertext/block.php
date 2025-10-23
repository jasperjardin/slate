<?php
/**
 * Supertext Block
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
$allowed_blocks = array(
	'core/paragraph',
	'core/heading',
);

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Lorem Ipsum Dolor',
			'fontSize'    => 'supertext',
		),
	),
);

// Set block classes.
$block_classes  = 'block-supertext';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<div class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<InnerBlocks
		template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
		allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
	/>
</div>
