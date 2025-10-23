<?php
/**
 * Configuration array for the AJAX for the Slate theme.
 *
 * This array is used to store the AJAX for the Slate theme.
 * It is loaded by the Config class.
 *
 * @package     Slate
 * @category    Slate/Config
 * @subpackage  Slate/Config/Ajax
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	/**
	 * The AJAX configuration array.
	 */
	'ajax' => array(
		/**
		 * Set true to display of AJAX result display on console.log.
		 * Enable this on development and debugging only.
		 */
		'console_result'    => false,
		/**
		 * Set true to display AJAX PHP Handler info on console.log.
		 * Enable this on development and debugging only.
		 */
		'show_handler_info' => true,
	),
);
