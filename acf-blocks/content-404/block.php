<?php
/**
 * Content 404 Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

get_block_partial(
	'content-404',
	array(
		'section_id'    => $acf_block->get_id(),
		'block_classes' => $acf_block->get_settings_classes(),
	)
);
