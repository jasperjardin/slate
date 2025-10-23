<?php
/**
 * Media Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

// Set block classes.
$block_classes  = 'block-media';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<div class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<?php
	get_component(
		'media',
		array(
			'media_type' => get_field( 'media_type' ),
			'image'      => get_field( 'image' ),
			'caption'    => get_field( 'caption' ),
			'video_type' => get_field( 'video_type' ),
			'video'      => get_field( 'video' ),
			'slider'     => get_field( 'slider' ),
		)
	);
	?>
</div>
