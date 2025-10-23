<?php
/**
 * Video Control partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'classes'    => '',
		'atts'       => array(),
		'icon'       => 'icon-play',
		'sr_text'    => '',
		'hover_text' => __( 'Play Video', 'impulse' ),
	)
);

$component_classes = 'video-control';
if ( ! empty( $args['classes'] ) ) {
	$component_classes .= ' ' . $args['classes'];
}

$attributes = '';
if ( ! empty( $args['atts'] ) ) {
	unset( $args['atts']['class'] );
	unset( $args['atts']['href'] );
	foreach ( $args['atts'] as $attr => $value ) {
		if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
			$value       = esc_attr( $value );
			$attributes .= ' ' . $attr . '="' . $value . '"';
		}
	}
}

$component_output = '<button class="' . esc_attr( $component_classes ) . '" ' . $attributes . '>';
if ( ! empty( $args['icon'] ) ) {
	$component_output .= '<i class="' . esc_attr( $args['icon'] ) . '"></i>';
}
if ( ! empty( $args['sr_text'] ) ) {
	$component_output .= '<span class="sr-only">' . esc_html( $args['sr_text'] ) . '</span>';
}
if ( ! empty( $args['hover_text'] ) ) {
	$component_output .= '<span>' . esc_html( $args['hover_text'] ) . '</span>';
}
$component_output .= '</button>';

echo wp_kses_post( $component_output );
