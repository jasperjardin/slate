<?php
/**
 * Content Split Block
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
$allowed_blocks = array(
	'acf/supertext',
	'acf/content',
);
$template       = array(
	array(
		'acf/supertext',
		array(),
		array(
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Lorem Ipsum Dolor',
					'fontSize'    => 'supertext',
				),
			),
		),
	),
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/heading',
				array(
					'placeholder' => 'Elementum sed sed mauris semper faucibus pretium leo justo',
					'level'       => 3,
				),
			),
		),
	),
	array(
		'acf/content',
		array(),
		array(
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Massa vel sapien pellentesque vulputate lectus. Ut semper sit morbi tempus porta elementum. Elementum sed sed mauris semper faucibus pretium leo justo. Viverra sed proin odio elementum aliquet urna neque ultrices. Massa vel sapien pellentesque vulputate lectus.',
				),
			),
		),
	),
);

// Set block classes.
$block_classes  = 'acf-block block-content-split';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="container">
		<div class="block-content-split__wrapper cms">
			<InnerBlocks
				template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
				allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
			/>
		</div>
	</div>
</section>
