<?php
/**
 * Configuration array for the Slate theme. This is the main configuration array for the Slate theme.
 *
 * @package     Slate
 * @category    Slate/Config
 * @subpackage  Slate/Config/Theme
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	/**
	 * The theme configuration array.
	 */
	'theme' => array(
		/**
		 * The name.
		 */
		'name'           => 'Slate',
		/**
		 * The prefix.
		 */
		'prefix'         => 'slate',
		/**
		 * The text-domain.
		 */
		'lang'           => 'slate',
		/**
		 * The version.
		 */
		'version'        => '0.0.1',
		/**
		 * The environment.
		 */
		'env'            => 'development',
		/**
		 * The folder name.
		 */
		'folder_name'    => basename( dirname( __DIR__, 1 ) ),
		/**
		 * The site URL.
		 */
		'site_url'       => get_option( 'siteurl' ),
		/**
		 * The plugins URL.
		 */
		'plugins_url'    => plugins_url(),
		/**
		 * The number of posts to show per page.
		 */
		'posts_per_page' => get_option( 'posts_per_page' ),
	),
);
