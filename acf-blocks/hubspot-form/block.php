<?php
/**
 * Hubspot Form Block
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
	'hubspot-form',
	array(
		'section_id'    => $acf_block->get_id(),
		'block_classes' => $acf_block->get_settings_classes(),
		'title'         => get_field( 'title' ),
		'portal_id'     => get_field( 'portal_id' ),
		'form_id'       => get_field( 'form_id' ),
	)
);
