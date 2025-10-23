<?php
/**
 * Theme functions file.
 *
 * All functions should be namespaced with the theme name.
 * This file serves as a central hub for including PHP dependencies.
 * Direct functionality implementations should be placed elsewhere.
 *
 * @package 	Slate
 * @category	Slate/Functions
 * @author		Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link		https://github.com/jasperjardin/slate
 * @since		0.0.1
 * @license		GPL-2.0+
 * @copyright	2025
 * @created_at	2025-10-19
 */

// Load the Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// @TO_REMOVE
// use Slate\Config;

// // Define your theme namespace constants, etc.

// if ( ! function_exists( 'slate_load_config' ) ) {
// 	/**
// 	 * Initialize the custom config manager.
// 	 */
// 	function slate_load_config() {
// 		// Load the Config class (assuming you have an autoloader or 'require' it).
// 		$loader_config = require_once get_stylesheet_directory() . '/config/loader.php';

// 		foreach ( $loader_config as $config_file ) {
// 			Config::load( $config_file );
// 		}

// 		// var_dump( Config::get( 'all' ) );
// 		var_dump( 'functions.php: Line#' . __LINE__ );
// 		// var_dump( Config::get( 'security.nonces.ajax' ) );
// 		// var_dump( Config::get( 'all' ) );
// 	}
// }
// // Use a late hook to ensure all core WordPress functions (like home_url) are ready.
// add_action( 'after_setup_theme', 'slate_load_config', 10 );


use \Slate\Src\Init as Slate_Theme_Initializer;

function slate_theme_initializer() {
	$initializer = new Slate_Theme_Initializer();

	$initializer->run();
}
add_action( 'after_setup_theme', 'slate_theme_initializer' );

/**
 * Load theme textdomain for internationalization.
 */
function imp_load_textdomain() {
	load_theme_textdomain( 'impulse', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'imp_load_textdomain' );

/**
 * Iterate through php files in the includes folder and include them.
 */
try {
	$dir_iterator = new \RecursiveDirectoryIterator( get_stylesheet_directory() . '/includes/' );
	$it           = new \RecursiveIteratorIterator( $dir_iterator );

	while ( $it->valid() ) {
		$it->next();
		if ( ! $it->isDot() && $it->isFile() && $it->isReadable() && $it->getExtension() === 'php' ) {
			require $it->key();
		}
	}
} catch ( \Exception $e ) {
	throw $e;
}

// create an itterator that includes all php files in the includes folder without classes?
