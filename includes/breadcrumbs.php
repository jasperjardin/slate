<?php
/**
 * Breadcrumbs.
 *
 * @package imp
 */

/**
 * Customize Yoast breadcrumb separator.
 *
 * @return string The modified separator.
 */
function imp_yoast_breadcrumb_separator() {
	return '<span class="breadcrumbs__separator"></span>';
}
add_filter( 'wpseo_breadcrumb_separator', 'imp_yoast_breadcrumb_separator', 100 );
