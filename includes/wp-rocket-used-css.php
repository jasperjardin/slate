<?php
/**
 * Modify used CSS function to ignore compontent inline style tags
 *
 * @package imp
 */

namespace WP_Rocket\Helpers\rucss\rucss_modify_used_css;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) || die();

/**
 * Get WP Rocket configs
 *
 * @return array
 */
function get_configs() {
	$configs = array(
		'rocket_rucss_external_exclusions'       => array(),
		'rocket_rucss_inline_content_exclusions' => array(),
		'rocket_rucss_inline_atts_exclusions'    => array(
			'data-component-style',
		),
		'rocket_rucss_skip_styles_with_attr'     => array(),
		'prepend_css'                            => array(),
		'append_css'                             => array(),
		'filter_css'                             => array(),
	);

	return $configs;
}


// DO NOT MAKE EDITS BELOW THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING.

/**
 * Add exclusions for removing inline css.
 *
 * @param array $exclusions Configs to exclude.
 * @return array
 */
function add_rucss_exclusions( $exclusions = array() ) {
	$configs        = get_configs();
	$current_filter = current_filter();

	if ( empty( $configs[ $current_filter ] ) ) {
		return $exclusions;
	}

	foreach ( $configs[ $current_filter ] as $exclusion ) {
		$exclusions[] = $exclusion;
	}

	return $exclusions;
}

// Exclude external stylesheets from being removed by WP Rocket's Remove Unused CSS optimization.
add_filter( 'rocket_rucss_external_exclusions', __NAMESPACE__ . '\add_rucss_exclusions' );

// Exclude inline styles from being removed by WP Rocket's Remove Unused CSS optimization.
add_filter( 'rocket_rucss_inline_content_exclusions', __NAMESPACE__ . '\add_rucss_exclusions' );

// Exclude inline styles from being removed by WP Rocket's Remove Unused CSS optimization.
add_filter( 'rocket_rucss_inline_atts_exclusions', __NAMESPACE__ . '\add_rucss_exclusions' );

// Completely remove styles with target attributes from page.
// Styles will not be in RUCSS and also removed from their original location.
add_filter( 'rocket_rucss_skip_styles_with_attr', __NAMESPACE__ . '\add_rucss_exclusions' );

/**
 * Modify Used CSS by prepending, appending, or filtering values, depending on configs
 *
 * @param string $css CSS string.
 * @return string
 */
function filter_css( $css ) {
	$configs = get_configs();

	if ( ! empty( $configs['prepend_css'] ) ) {
		foreach ( $configs['prepend_css'] as $prepend_css ) {
			$css = $prepend_css . $css;
		}
	}

	if ( ! empty( $configs['append_css'] ) ) {
		foreach ( $configs['append_css'] as $append_css ) {
			$css = $css . $append_css;
		}
	}

	if ( ! empty( $configs['filter_css'] ) ) {
		foreach ( $configs['filter_css'] as $to_be_removed => $to_be_inserted ) {
			$css = str_replace( $to_be_removed, $to_be_inserted, $css );
		}
	}

	return $css;
}
add_filter( 'rocket_usedcss_content', __NAMESPACE__ . '\filter_css' );
