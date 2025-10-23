<?php
/**
 * Configuration array for the the paths for the Slate theme.
 *
 * This array is used to store the paths for the Slate theme.
 * It is loaded by the Config class.
 *
 * @package     Slate
 * @category    Slate/Config
 * @subpackage  Slate/Config/Paths
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

$theme_path = get_stylesheet_directory();
$theme_uri  = get_stylesheet_directory_uri();

return array(
	/**
	 * The paths configuration array.
	 */
	'paths' => array(
		/**
		 * The directory URI and abspath directory to Config folder.
		 */
		'config'    => array(
			/**
			 * The abspath directory path to Config folder.
			 */
			'path' => $theme_path . '/config/',
			/**
			 * The directory URI and abspath directory to Config folder.
			 */
			'uri'  => $theme_uri . '/config/',
		),

		/**
		 * The abspath directory path to Languages folder for "text-domain" files.
		 */
		'languages' => array(
			/**
			 * The abspath directory path to Languages folder.
			 */
			'path' => $theme_path . '/languages/',
			/**
			 * The directory URI to Languages folder.
			 */
			'uri'  => $theme_uri . '/languages/',
		),

		/**
		 * The abspath directory path to Templates folder.
		 */
		'theme'     => array(
			/**
			 * Retrieves stylesheet directory path for current theme.
			 */
			'path' => $theme_path . '/',
			/**
			 * Retrieves stylesheet directory URI for current theme.
			 */
			'uri'  => $theme_uri . '/',
		),

		/**
		 * The abspath directory path to Source folder for all OOP classes.
		 */
		'src'  => array(
			/**
			 * The abspath directory path to Source folder for all OOP classes.
			 */
			'path' => $theme_path . '/src/',
			/**
			 * The directory URI to Source folder for all OOP classes.
			 */
			'uri'  => $theme_uri . '/src/',

			/**
			 * The abspath directory path to Source folder for all OOP classes.
			 */
			'components'  => array(
				/**
				 * The abspath directory path to Components folder for all OOP classes.
				 */
				'path' => $theme_path . '/src/components/',
				/**
				 * The directory URI to Components folder for all OOP classes.
				 */
				'uri'  => $theme_uri . '/src/components/',
			),
		),
		

		/**
		 * The abspath directory path to Includes folder.
		 */
		'includes'  => array(
			/**
			 * The abspath directory path to Includes folder.
			 */
			'path' => $theme_path . '/includes/',
			/**
			 * The directory URI to Includes folder.
			 */
			'uri'  => $theme_uri . '/includes/',
		),

		/**
		 * The abspath directory path to Templates folder.
		 */
		'templates' => array(
			/**
			 * The abspath directory path to Templates folder.
			 */
			'path' => $theme_path . '/templates/',
			/**
			 * Retrieves stylesheet directory URI for current theme.
			 */
			'uri'  => $theme_uri . '/templates/',
		),

		/**
		 * The abspath directory path to Hooks and Template Tags folders.
		 */
		'template'  => array(
			/**
			 * The abspath directory path to Hooks folder.
			 */
			'hooks'	=> array(
				/**
				 * The abspath directory path to Hooks folder.
				 */
				'path' => $theme_path . '/template/hooks/',
				/**
				 * The directory URI to Hooks folder.
				 */
				'uri'  => $theme_uri . '/template/hoo',
			),
			/**
			 * The abspath directory path to Template Tags folder.
			 */
			'tags'	=> array(
				/**
				 * The abspath directory path to Template Tags folder.
				 */
				'path' => $theme_path . '/template/tags/',
				/**
				 * The directory URI to Template Tags folder.
				 */
				'uri'  => $theme_uri . '/template/tags/',
			),
			/**
			 * The abspath directory path to Template directory.
			 */
			'directory'	=> array(
				/**
				 * Retrieves template directory path for current theme.
				 */
				'path' => get_template_directory() . '/',
				/**
				 * Retrieves template directory URI for current theme.
				 */
				'uri'  =>  get_template_directory_uri() . '/',
			),
		),

		/**
		 * The abspath directory path to Assets folder.
		 */
		'assets'    => array(
			/**
			 * The abspath directory path to Assets folder.
			 */
			'path'      => $theme_path . '/assets/',
			/**
			 * The directory URI to Assets folder.
			 */
			'uri'       => $theme_uri . '/assets/',

			/**
			 * The abspath directory path to Vendor folder.
			 */
			'vendor'    => array(
				/**
				 * The abspath directory path to Vendor folder.
				 */
				'path' => $theme_path . '/assets/vendor/',
				/**
				 * The directory URI to Vendor folder.
				 */
				'uri'  => $theme_uri . '/assets/vendor/',
			),

			/**
			 * The abspath directory path to Images folder.
			 */
			'images'    => array(
				/**
				 * The abspath directory path to Images folder.
				 */
				'path' => $theme_path . '/assets/images/',
				/**
				 * The directory URI to Images folder.
				 */
				'uri'  => $theme_uri . '/assets/images/',
			),

			/**
			 * The abspath directory path to Resources folder.
			 */
			'resources' => array(
				/**
				 * The abspath directory path to Resources folder.
				 */
				'path' => $theme_path . '/assets/resources/',
				/**
				 * The directory URI to Resources folder.
				 */
				'uri'  => $theme_uri . '/assets/resources/',
			),

		),

		/**
		 * The abspath directory path to Distributable Assets folder.
		 */
		'dist'      => array(
			/**
			 * The abspath directory path to Distributable Assets folder.
			*/
			'path'     => $theme_path . '/dist/',
			/**
			 * The directory URI for "Distributable Assets."
			 */
			'uri'      => $theme_uri . '/dist/',

			/**
			 * The abspath directory path to Distributable WordPress Backend Assets folder.
			 */
			'backend'  => array(
				/**
				 * The abspath directory path to Distributable WordPress Backend Assets folder.
				 */
				'path' => $theme_path . '/dist/backend/',
				/**
				 * The directory URI for "Distributable WordPress Backend Assets."
				 */
				'uri'  => $theme_uri . '/dist/backend/',
			),

			/**
			 * The abspath directory path to Distributable WordPress Frontend Assets folder.
			 */
			'frontend' => array(
				/**
				 * The abspath directory path to Distributable WordPress Frontend Assets folder.
				 */
				'path' => $theme_path . '/dist/frontend/',
				/**
				 * The directory URI for "Distributable WordPress Frontend Assets."
				 */
				'uri'  => $theme_uri . '/dist/frontend/',
			),
		),
	),
);
