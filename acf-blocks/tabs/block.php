<?php
/**
 * Tabs Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package mfw
 */

$acf_block    = new ACF_Block( $block, $wp_block );
$display      = get_field( 'desktop_display' );
$inner_blocks = array();

if ( 'vertical' === $display || 'inline' === $display ) {
	$inner_blocks = $acf_block->get_inner_blocks_acf_fields();
}

// Block classes.
$block_classes  = 'acf-block block-tabs block-tabs--' . $display;
$block_classes .= $acf_block->get_settings_classes( true );

get_block_partial(
	'tabs',
	array(
		'section_id'    => $acf_block->get_id(),
		'block_classes' => $block_classes,
		'theme'         => $acf_block->get_theme(),
		'inner_blocks'  => $inner_blocks,
	)
);
