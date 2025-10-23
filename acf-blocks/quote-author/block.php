<?php
/**
 * Quote & Author Block
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
			'placeholder' => '“Lacus nunc tristique et purus aliquet nullam arcu platea at tellus duis eu volutpat senectus elit”',
			'fontSize'    => 't5',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'John Smith',
			'fontSize'    => 't6',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'CEO, ABC Company',
			'fontSize'    => 'body-small',
		),
	),
);

// Set block classes.
$block_classes  = 'block-quote-author';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<div class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<div class="block-quote-author__content cms">
		<InnerBlocks
			template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
			allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
		/>
	</div>
</div>
