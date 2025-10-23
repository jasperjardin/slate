<?php
/**
 * ACF Hooks
 *
 * @package imp
 */

/**
 * Conditionally hide ACF admin UI on WPEngine, but allow updates page.
 *
 * @param bool $show_admin Whether to show the ACF admin UI.
 * @return bool
 */
function imp_acf_maybe_hide_admin_ui( $show_admin ) {
	if ( function_exists( 'is_wpe' ) && is_wpe() && $show_admin && is_admin() ) {
		$page      = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$post_type = isset( $_GET['post_type'] ) ? sanitize_key( wp_unslash( $_GET['post_type'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( 'acf-settings-updates' === $page && 'acf-field-group' === $post_type ) {
			return true;
		}

		return false;
	}

	return $show_admin;
}
add_filter( 'acf/settings/show_admin', 'imp_acf_maybe_hide_admin_ui' );

/**
 * Provide ACF Pro license key via wp-config.php constant.
 *
 * @return string|false
 */
function imp_acf_pro_license_key() {
	return defined( 'ACF_PRO_LICENSE' ) ? ACF_PRO_LICENSE : false;
}
add_filter( 'acf/settings/license', 'imp_acf_pro_license_key' );
