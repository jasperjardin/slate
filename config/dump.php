<?php
/**
 * Configuration array for the dump for the Slate theme.
 *
 * This array is used to store the dump for the Slate theme.
 * It is loaded by the Config class.
 *
 * @package     Slate
 * @category    Slate/Config
 * @subpackage  Slate/Config/Dump
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	/**
	 * The Dump configuration array.
	 */
	'dump' => array(
		/**
		 * Set true to enable the dump feature for dumping debug information.
		 */
		'enabled'           => false,
		/**
		 * Set true to display of number of queries on console.log.
		 * Enable this on development and debugging only.
		 */
		'number_of_queries' => false,
		/**
		 * Set true to display the loaded files on console.log.
		 * Enable this on development and debugging only.
		 */
		'loaded_files'      => false,
	),
);
