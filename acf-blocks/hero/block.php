<?php
/**
 * Hero Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

$template = array(
	array( 'acf/breadcrumbs' ),
	array(
		'core/paragraph',
		array(
			'content'  => 'Pre-Heading',
			'fontSize' => 'supertext',
		),
	),
	array(
		'core/heading',
		array(
			'content' => 'Longer description title',
			'level'   => 1,
		),
	),
);

$allowed_blocks = array(
	...get_allowed_content_blocks(),
	'acf/breadcrumbs',
);

$block_classes  = 'acf-block block-hero';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="container cms">
		<InnerBlocks
			template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
			allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
		/>
	</div>
</section>
