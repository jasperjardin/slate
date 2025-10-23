<?php
/**
 * Search Bar Block
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
$block_classes  = 'acf-block block-search-bar';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<div class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<form action="/" class="block-search-bar__search" role="search">
		<label for="search-input" class="block-search-bar__label"><?= esc_html__( 'Search', 'impulse' ); ?></label>
		<input type="text" id="search-input" class="block-search-bar__search-input" name="s" placeholder="<?= esc_attr__( 'Enter search terms...', 'impulse' ); ?>" required aria-label="<?= esc_attr__( 'Search', 'impulse' ); ?>"/>
		<button class="block-search-bar__search-submit" type="submit" aria-label="<?= esc_attr__( 'Submit search', 'impulse' ); ?>"><span class="icon-search"></span></button>
	</form>
</div>
