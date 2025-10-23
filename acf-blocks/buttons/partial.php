<?php
/**
 * Image & Content partial.
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
		'buttons'       => array(),
	)
);

if ( ! empty( $args['buttons'] ) ) :
	$block_classes = 'block-buttons';
	if ( ! empty( $args['block_classes'] ) ) {
		$block_classes .= ' ' . $args['block_classes'];
	}
	?>

	<div class="<?= esc_attr( $block_classes ); ?>" id="<?php echo esc_attr( $args['section_id'] ); ?>">
		<?php
		foreach ( $args['buttons'] as $button ) {
			echo array_to_link( $button['link'], $button['style'] );
		}
		?>
	</div>

	<?php
endif;
