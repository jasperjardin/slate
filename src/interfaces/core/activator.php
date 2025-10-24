<?php
/**
 * The "Slate/Src/Interfaces/Core/Activator" interface handles the method signatures dedicated for the "Slate/Src/Activator" class.
 * 
 * @package     Slate
 * @subpackage  Slate/Src/Interfaces/Core
 * @category    Slate/Src/Interfaces/Core/Activator
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
 * The "Slate/Src/Interfaces/Core/Activator" interface handles the method signatures dedicated for the "Slate/Src/Activator" class.
 */
interface Activator {
	/**
	 * Initialize the class.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function __construct();

	/**
	 * Executes all the scripts during program activation
	 *
	 * Executes all the options, settings and scripts during program activation.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @static
	 * @return		void
	 */
	public static function activate() : void;

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

	/**
	 * This method loads methods for theme_loaded.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @static
	 * @return		void
	 */
	public static function theme_loaded() : void;

	/**
	 * This method loads methods for wp_loaded.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @static
	 * @return		void
	 */
	public static function wp_loaded() : void;

	/**
	 * This method updates and initialize the options for this program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @static
	 * @return		void
	 */
	public static function update_options() : void;

	/**
	 * This method registers program user roles.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @static
	 * @return		void
	 */
	public static function register_user_roles() : void;

	/**
	 * This method registers the menus for this program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @static
	 * @return		void
	 */
	public static function register_nav_menus() : void;
}