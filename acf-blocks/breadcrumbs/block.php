<?php
/**
 * Breadcrumbs Block
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
$block_classes  = 'block-breadcrumbs';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<div class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<div class="container">
		<?php get_component( 'breadcrumbs' ); ?>
	</div>
</div>
