<?php
/**
 * Tab Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package mfw
 */

$acf_block = new ACF_Block( $block, $wp_block );

// ACF fields.
$bellow_title    = get_field( 'title' );
$open_by_default = get_field( 'open_by_default' );
$tabs_fields     = isset( $context['tabs_fields']['desktop_display'] ) ? $context['tabs_fields']['desktop_display'] : 'accordion';

$control_id = 'control-' . $block['id'];
$panel_id   = 'panel-' . $block['id'];

// InnerBlocks templating.
$allowed_blocks = array(
	...get_allowed_content_blocks(),
	'acf/content-media-split',
);

$template = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nulla ac bibendum volutpat, felis nisl consequat mi, eget gravida ipsum elit non sapien. ',
		),
	),
);

// Block classes.
$block_classes  = 'block-tab';
$block_classes .= $open_by_default ? ' block-tab--open-default block-tab--expanded' : '';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<div class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<button class="block-tab__top"
		aria-expanded="<?= $open_by_default ? 'true' : 'false'; ?>"
		aria-controls="<?= esc_attr( $panel_id ); ?>"
		id="<?= esc_attr( $control_id ); ?>"
	>
		<span class="block-tab__title"><?= esc_html( $bellow_title ); ?></span>

		<span class="block-tab__control"></span>
	</button>

	<div
		class="block-tab__collapsable"
		id="<?= esc_attr( $panel_id ); ?>"
		aria-labelledby="<?= esc_attr( $control_id ); ?>"
		<?php if ( 'accordion' === $tabs_fields ) : ?>
			role="region"
		<?php else : ?>
			role="tabpanel"
			tabindex="0"
		<?php endif; ?>
	>
		<div class="block-tab__content cms">
			<InnerBlocks
				template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
				allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
			/>
		</div>
	</div>
</div>
