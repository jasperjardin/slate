<?php
/**
 * The "Slate/Src/Interfaces/Core/Deactivator" interface handles the method signatures dedicated for the "Slate/Src/Deactivator" class.
 * 
 * @package     Slate
 * @subpackage  Slate/Src/Interfaces/Core
 * @category    Slate/Src/Interfaces/Core/Deactivator
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Interfaces\Core;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * The "Slate/Src/Interfaces/Core/Deactivator" interface handles the method signatures dedicated for the "Slate/Src/Deactivator" class.
 */
interface Deactivator {
	/**
	 * Executes all the scripts during program deactivation
	 *
	 * Executes all the options, settings and scripts during program deactivation.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @static
	 * @return		void
	 */
	public static function deactivate() : void;

	/**
	 * This method is an automatic flushing of the WordPress permalink rewrite rules.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @static
	 * @return		void
	 */
	public static function flush_rewrite_rules() : void;
}