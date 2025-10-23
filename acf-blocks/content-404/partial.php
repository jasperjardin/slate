<?php
/**
 * Content 404 partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'section_id'    => '',
		'block_classes' => '',
	)
);

$template = array(
	array(
		'core/heading',
		array(
			'content' => '404',
			'level'   => 1,
		),
	),
	array(
		'core/heading',
		array(
			'content'  => 'Page not found',
			'level'    => 2,
			'fontSize' => 't4',
		),
	),
	array(
		'core/paragraph',
		array(
			'content' => 'You can try searching for what you’re looking for below.',
		),
	),
	array(
		'acf/search-bar',
		array(),
	),
);

$allowed_blocks = get_allowed_content_blocks();

$block_classes = 'acf-block block-content-404';
if ( ! empty( $args['block_classes'] ) ) {
	$block_classes .= ' ' . $args['block_classes'];
}
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $args['section_id'] ); ?>">
	<div class="container">
		<InnerBlocks
			template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
			allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
		/>
	</div>
</section>
