<?php
/**
 * Breadcrumbs partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

if ( function_exists( 'yoast_breadcrumb' ) ) {
	yoast_breadcrumb( '<div class="breadcrumbs" id="breadcrumbs">', '</div>' );
} elseif ( is_admin() ) {
	echo '<p>This block uses Yoast SEO\'s "yoast_breadcrumb" function. Make sure the plugin is active to display breadcrumbs.';
}
