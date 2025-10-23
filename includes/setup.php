<?php
/**
 * Theme setup
 *
 * @package imp
 */

/**
 * Set up theme defaults to run on the after_setup_theme hook.
 *
 * @return void
 */
function imp_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'title-tag' );

	// Add image sizes here. Remove unused sizes.
	add_image_size( 'full-width', 1920, 1080, false );
	add_image_size( '16x9-lg', 1784, 1004, true );
	add_image_size( '16x9-blog', 1280, 720, true );
	add_image_size( '16x9-md', 892, 502, true );
	add_image_size( '3x2-lg', 1784, 1189, true );
	add_image_size( '3x2-md', 892, 595, true );
	add_image_size( '3x2-blog', 1280, 853, true );
	add_image_size( '1x1-md', 892, 892, true );
	add_image_size( '1x1-xs', 80, 80, true );

	// Register navigation menus.
	register_nav_menus(
		array(
			'header_nav'     => __( 'Header Nav Menu', 'impulse' ),
			'header_utility' => __( 'Header Utility Menu', 'impulse' ),
			'footer_nav_1'   => __( 'Footer Nav Menu 1', 'impulse' ),
			'footer_nav_2'   => __( 'Footer Nav Menu 2', 'impulse' ),
			'footer_nav_3'   => __( 'Footer Nav Menu 3', 'impulse' ),
			'footer_utility' => __( 'Footer Utility Menu', 'impulse' ),
		)
	);

	ACF_Block_Manager::get_instance();
	Post_Filters_Archive::get_instance();
	Component_Loader::get_instance();
}

add_action( 'after_setup_theme', 'imp_theme_setup' );

/**
 * Register ACF option pages
 *
 * @return void
 */
function imp_register_acf_option_pages() {
	acf_add_options_page(
		array(
			'page_title' => esc_html__( 'Site Settings', 'impulse' ),
			'menu_title' => esc_html__( 'Site Settings', 'impulse' ),
			'menu_slug'  => 'site-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);

	// Example of a child page.
	// phpcs:disable
	// acf_add_options_page(
	// array(
	// 'page_title'  => __( 'Header Settings' ),
	// 'menu_title'  => __( 'Header' ),
	// 'parent_slug' => 'site-settings',
	// )
	// );
	// phpcs:enable
}
add_filter( 'acf/init', 'imp_register_acf_option_pages' );

/**
 * Move jQuery to Footer
 *
 * @return void
 */
function jquery_to_footer() {
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
}
add_action( 'wp_enqueue_scripts', 'jquery_to_footer' );


/**
 * Add global patterns accessible in backend.
 */
function imp_reusable_blocks_admin_menu() {
	add_menu_page( esc_html__( 'Global Patterns', 'impulse' ), esc_html__( 'Global Patterns', 'impulse' ), 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 10 );
}
add_action( 'admin_menu', 'imp_reusable_blocks_admin_menu' );

/**
 * Add wp_block to acf get post types.
 *
 * @param array $post_types Allowed post types.
 * @return array
 */
function imp_filter_acf_get_post_types( $post_types ) {
	if ( ! in_array( 'wp_block', $post_types, true ) ) {
		$post_types[] = 'wp_block';
	}

	return $post_types;
}
add_filter( 'acf/get_post_types', 'imp_filter_acf_get_post_types', 10, 1 );

/**
 * Disable comments completely
 *
 * @return void
 */
function imp_disable_comments() {
	add_filter( 'comments_open', '__return_false', 20, 2 );
	add_filter( 'pings_open', '__return_false', 20, 2 );

	add_filter( 'comments_array', '__return_empty_array', 10, 2 );

	add_action(
		'admin_menu',
		function () {
			remove_menu_page( 'edit-comments.php' );
		}
	);

	add_action(
		'wp_before_admin_bar_render',
		function () {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu( 'comments' );
		}
	);

	add_action(
		'admin_init',
		function () {
			remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		}
	);

	add_filter(
		'manage_posts_columns',
		function ( $columns ) {
			unset( $columns['comments'] );
			return $columns;
		}
	);

	add_action(
		'init',
		function () {
			$post_types = get_post_types();
			foreach ( $post_types as $post_type ) {
				if ( post_type_supports( $post_type, 'comments' ) ) {
					remove_post_type_support( $post_type, 'comments' );
					remove_post_type_support( $post_type, 'trackbacks' );
				}
			}
		}
	);
}
add_action( 'init', 'imp_disable_comments' );

/**
 * Check if author pages are enabled.
 */
function imp_author_page_check() {
	$enable_author_pages = get_field( 'enable_author_pages', 'option' );

	if ( is_author() && ! $enable_author_pages ) {
		wp_safe_redirect( home_url(), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'imp_author_page_check' );
