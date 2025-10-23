<?php
/**
 * Content Card Block
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
		'core/heading',
		array(
			'placeholder' => 'Nisi ut mauris mauris',
			'level'       => 2,
			'fontSize'    => 't5',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Massa vel sapien pellentesque vulputate lectus. Ut semper sit morbi tempus porta elementum. Ut semper sit morbi tempus porta elementum.',
		),
	),
);

$icon               = get_field( 'icon' ) ?? '';
$image              = get_field( 'image' ) ?? 0;
$show_icon_bg_color = get_field( 'show_icon_bg_color' ) ?? false;
$display            = get_field( 'display' ) ?? 'default';

// Set block classes.
$block_classes  = 'block-content-card';
$block_classes .= $acf_block->get_settings_classes( true );

if ( $show_icon_bg_color ) {
	$block_classes .= ' block-content-card--show-icon-bg-color';
}
$block_classes .= ' block-content-card--display-' . $display;
?>

<div class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<?php if ( ! empty( $image ) ) : ?>
		<figure class="block-content-card__img-container">
			<?php
				echo wp_get_attachment_image(
					$image,
					'3x2-md',
					false,
					array(
						'class' => 'block-content-card__img',
					)
				);
			?>
		</figure>
	<?php endif; ?>
	<div class="block-content-card__content cms">
		<?php if ( ! empty( $icon ) ) : ?>
			<div class="block-content-card__icon" data-theme="dark">
				<span class="icon-<?= esc_attr( $icon ); ?>"></span>
			</div>
		<?php endif; ?>
		<InnerBlocks
			template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
			allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
		/>
	</div>
</div>
