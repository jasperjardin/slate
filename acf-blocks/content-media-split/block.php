<?php
/**
 * Content & Media Split
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
		'acf/content',
		array(
			'lock' => array(
				'move'   => true,
				'remove' => true,
			),
		),
		array(
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Optional preheading',
					'fontSize'    => 'supertext',
				),
			),
			array(
				'core/heading',
				array(
					'level'       => 2,
					'placeholder' => 'This is where the title goes.',
				),
			),
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				),
			),
		),
	),
	array(
		'acf/media',
		array(
			'lock' => array(
				'move'   => true,
				'remove' => true,
			),
		),
	),
);

// Block classes.
$block_classes  = 'acf-block block-content-media-split';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="container">
		<InnerBlocks
			template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
			allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
		/>
	</div>
</section>
