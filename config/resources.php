<?php
/**
 * Configuration array for the resources for the Slate theme.
 *
 * This array is used to store the resources for the Slate theme.
 * It is loaded by the Config class.
 *
 * @package     Slate
 * @category    Slate/Config
 * @subpackage  Slate/Config/Resources
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	/**
	 * The resources configuration array.
	 */
	'resources' => array(
		/**
		 * Controls whether to use minified files of theme JS & CSS.
		 */
		'use_minified_files' => false,
		/**
		 * The configuration to dequeue styles and scripts.
		 */
		'dequeue'            => array(
			'styles'  => array(
				/**
				 * The styles to dequeue.
				 */
				'slate-theme'          => false,
				'googlefonts'          => false,
				'wistia-api'           => false,
				'slate-icons'          => false,
				'slate-module-library' => false,
				'swiperjs'             => false,
				'slate-forms'          => false,
				'vimeo-player-js'      => false,
				'micromodal'           => false,
				'hubspot-forms'        => false,
			),
			'scripts' => array(
				/**
				 * The scripts to dequeue.
				 */
				'jquery'                 => false,
				'wp-hooks'               => false,
				'wp-block-library'       => false,
				'wp-block-library-theme' => false,
				'global-styles'          => false,
				'wp-edit-blocks'         => false,
				'wp-edit-post'           => false,
				'wp-edit-comments'       => false,
				'wp-edit-widgets'        => false,
				'wp-embed'               => false,
				'wp-json'                => false,
				'wp-media-utils'         => false,
				'wp-media-editor'        => false,
				'wp-media-grid'          => false,
				'wp-media-gallery'       => false,
				'wp-media-library'       => false,
			),
		),
		/**
		 * The configuration to enqueue styles and scripts.
		 */
		'enqueue'            => array(
			'styles'  => array(),
			'scripts' => array(),
		),
		/**
		 * The backend (WordPress Admin) resources configuration array.
		 */
		'backend'            => array(
			/**
			 * The required backend resources configuration array.
			 */
			'required' => array(
				/**
				 * Setup the required CSS files for the wp-admin main CSS file.
				 */
				'css' => array(),
				/**
				 * Setup the required JavaScript files for the wp-admin main JS file.
				 */
				'js'  => array( 'jquery', 'wp-hooks' ),
			),
		),
		/**
		 * The frontend (WordPress Frontend) resources configuration array.
		 */
		'frontend'           => array(
			/**
			 * The required frontend resources configuration array.
			 */
			'required' => array(
				/**
				 * Setup the required CSS files for the main CSS file.
				 */
				'css' => array(),
				/**
				 * Setup the required JavaScript files for the main JS file.
				 */
				'js'  => array( 'jquery', 'wp-hooks' ),
			),
		),
	),
);
