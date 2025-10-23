<?php
/**
 * Content Cards Block
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
$allowed_blocks = array( 'acf/content-card' );
$template       = array(
	array( 'acf/content-card' ),
	array( 'acf/content-card' ),
	array( 'acf/content-card' ),
);

// Set block classes.
$block_classes  = 'acf-block block-content-cards';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="container">
		<div class="block-content-cards__wrapper">
			<InnerBlocks
				template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
				allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
			/>
		</div>
	</div>
</section>
