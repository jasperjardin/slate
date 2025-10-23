<?php
/**
 * Theme scripts can be registered here.
 *
 * @package imp
 */

/**
 * Enqueue/dequeue scripts on wp_enqueue_scripts hook
 */
function imp_theme_scripts() {
	wp_enqueue_style(
		'googlefonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		array(),
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		null
	);

	wp_register_script(
		'wistia-api',
		'https://fast.wistia.com/assets/external/E-v1.js',
		array(),
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		null,
		true
	);

	// You may need to remove this if a plugin depends on it.
	wp_dequeue_script( 'jquery' );

	wp_enqueue_style(
		'impulse',
		get_stylesheet_directory_uri() . '/dist/css/main/style.css',
		array(),
		filemtime( get_stylesheet_directory() . '/dist/css/main/style.css' )
	);

	wp_enqueue_script(
		'impulse',
		get_stylesheet_directory_uri() . '/dist/js/main/script.js',
		array( 'jquery' ),
		filemtime( get_stylesheet_directory() . '/dist/js/main/script.js' ),
		true
	);

	wp_localize_script(
		'impulse',
		'impBreakpoints',
		imp_get_grid_breakpoints(),
	);

	wp_enqueue_style(
		'imp-icons',
		get_stylesheet_directory_uri() . '/dist/css/iconfont/style.css',
		array(),
		filemtime( get_stylesheet_directory() . '/dist/css/iconfont/style.css' )
	);

	if ( is_post_type_archive( 'module' ) ) {
		wp_enqueue_script(
			'dib-module-library',
			get_stylesheet_directory_uri() . '/dist/js/module-library/script.js',
			array( 'impulse' ),
			filemtime( get_stylesheet_directory() . '/dist/js/module-library/script.js' ),
			true
		);

		wp_enqueue_style(
			'dib-module-library',
			get_stylesheet_directory_uri() . '/dist/css/module-library/style.css',
			array( 'impulse' ),
			filemtime( get_stylesheet_directory() . '/dist/css/module-library/style.css' )
		);
	}

	wp_register_script(
		'swiperjs',
		get_stylesheet_directory_uri() . '/assets/vendor/swiperjs/swiper-bundle.min.js',
		array(),
		'8.0',
		true
	);

	wp_register_style(
		'swiperjs',
		get_stylesheet_directory_uri() . '/assets/vendor/swiperjs/swiper-bundle.min.css',
		array(),
		'8.0',
	);

	wp_register_style(
		'imp-forms',
		get_stylesheet_directory_uri() . '/dist/css/forms/style.css',
		array(),
		filemtime( get_stylesheet_directory() . '/dist/css/forms/style.css' )
	);

	wp_register_script(
		'vimeo-player-js',
		get_stylesheet_directory_uri() . '/assets/vendor/vimeo/player.min.js',
		array(),
		'2.25.0',
		true
	);

	wp_register_script(
		'micromodal',
		get_stylesheet_directory_uri() . '/assets/vendor/micromodal/micromodal.min.js',
		array(),
		'0.4.10',
		true
	);

	// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	wp_register_script(
		'hubspot-forms',
		'//js.hsforms.net/forms/v2.js?pre=1',
		array(),
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		null,
		true
	);

	// Remove CSS for core block styles and global styles.
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );

	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
}

add_action( 'wp_enqueue_scripts', 'imp_theme_scripts' );

/**
 * Enqueue/dequeue admin scripts.
 */
function imp_admin_scripts() {
	// Remove global styles CSS like font-size so we can use it only as a class.
	wp_dequeue_style( 'global-styles-css-custom-properties' );
}

add_action( 'admin_enqueue_scripts', 'imp_admin_scripts' );

/**
 * Enqueue block editor assets
 */
function imp_block_editor_assets() {
	wp_enqueue_style(
		'googlefonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		array(),
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		null
	);

	wp_enqueue_style( 'acf-input' );
	wp_enqueue_style( 'acf-pro-input' );

	wp_enqueue_style(
		'impulse',
		get_stylesheet_directory_uri() . '/dist/css/block-editor/style.css',
		array( 'wp-edit-blocks' ),
		filemtime( get_stylesheet_directory() . '/dist/css/block-editor/style.css' )
	);

	wp_enqueue_style(
		'imp-icons',
		get_stylesheet_directory_uri() . '/dist/css/iconfont/style.css',
		array( 'wp-edit-blocks' ),
		filemtime( get_stylesheet_directory() . '/dist/css/iconfont/style.css' )
	);

	wp_enqueue_script(
		'imp-block-editor',
		get_stylesheet_directory_uri() . '/dist/js/block-editor/script.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post', 'jquery' ),
		filemtime( get_stylesheet_directory() . '/dist/js/block-editor/script.js' ),
		true
	);

	wp_enqueue_script(
		'imp-acf-js',
		get_stylesheet_directory_uri() . '/dist/js/acf/script.js',
		array( 'wp-blocks', 'acf-input' ),
		filemtime( get_stylesheet_directory() . '/dist/js/acf/script.js' ),
		true
	);

	wp_dequeue_style( 'global-styles-css-custom-properties' );

	wp_register_script(
		'swiperjs',
		get_stylesheet_directory_uri() . '/assets/vendor/swiperjs/swiper-bundle.min.js',
		array(),
		'8.0',
		true
	);

	wp_register_style(
		'imp-forms',
		get_stylesheet_directory_uri() . '/dist/css/forms/style.css',
		array(),
		filemtime( get_stylesheet_directory() . '/dist/css/forms/style.css' )
	);

	wp_register_style(
		'swiperjs',
		get_stylesheet_directory_uri() . '/assets/vendor/swiperjs/swiper-bundle.min.css',
		array(),
		'8.0',
	);

	$pattern_cats_registry = WP_Block_Pattern_Categories_Registry::get_instance();
	$registered_cats       = $pattern_cats_registry->get_all_registered();

	wp_localize_script(
		'imp-block-editor',
		'moduleCatSidebar',
		array(
			'registeredCats' => $registered_cats,
		)
	);

	wp_localize_script(
		'wp-blocks',
		'impBreakpoints',
		imp_get_grid_breakpoints(),
	);

	wp_localize_script(
		'wp-blocks',
		'impThemes',
		imp_get_themes(),
	);
}

if ( is_admin() ) {
	add_action( 'enqueue_block_assets', 'imp_block_editor_assets' );
} else {
	add_action( 'enqueue_block_editor_assets', 'imp_block_editor_assets' );
}
