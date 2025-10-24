<?php
/**
 * Fired during program activation
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Activator
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

 namespace Slate\Src;

/**
 * The "Slate/Src/Interfaces/Core/Activator" interface handles the method signatures dedicated for the "Slate/Src/Activator" class.
 */
use \Slate\Src\Interfaces\Core\Activator as Activator_Interface;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Fired during program activation.
 *
 * This class defines all code necessary to execute during the program's activation.
 */
final class Activator extends Abstract_Core_Context implements Activator_Interface {

	/**
	 * Initialize the class.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function __construct() {
		parent::__construct();
	}
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
	public static function activate() {
		do_action(
			sprintf(
				'%1$s[on][activation]',
				$this->prefix,
			)
		);

		self::flush_rewrite_rules();
		self::wp_loaded();
		self::theme_loaded();
	}

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
	public static function flush_rewrite_rules() {
		flush_rewrite_rules();
		return;
	}

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
	public static function theme_loaded() {
		self::update_options();
		self::register_nav_menus();
	}

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
	public static function wp_loaded() {
		self::register_user_roles();
	}

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
	public static function update_options() {
		$options = array(
			// 'setting_name' => 'setting_default_value', // for example: 'setting_name' => 'setting_default_value',
		);

		if ( ! empty( $options ) ) {
			foreach ( $options as $key => $value ) {
				if ( get_option( $key ) == false ) {
					update_option( $key, $value );
				}
			}
			flush_rewrite_rules();
		}
	}

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
	public static function register_user_roles() {
		/**
		 * Example:
		 *
		 * add_role(
		 *	'sample_user_role',
		 *	'Sample User Role',
		 *	array(
		 *		'read' => true, 'level_0' => true
		 *	)
		 * );
		 */
	}

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
	public static function register_nav_menus() {
		/**
		 * Example:
		 *
		 * register_nav_menus([
		 *	'menu_id_here' => __( 'Menu Title Here', self::$lang ),
		 * ]);
		 */
	}

}
