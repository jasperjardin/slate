<?php
/**
 * Icon List Item Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );
$icon      = get_field( 'icon' );

// InnerBlocks templating.
$allowed_blocks = array(
	'core/paragraph',
);
$template       = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
		),
	),
);

// Set block classes.
$block_classes  = 'block-icon-list-item';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<div class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<?php if ( ! empty( $icon ) ) : ?>
		<span class="icon-<?= esc_attr( $icon ); ?>"></span>
	<?php endif; ?>
	<div class="cms">
		<InnerBlocks
			template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
			allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
			templateLock="insert"
		/>
	</div>
</div>
