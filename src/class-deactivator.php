<?php
/**
 * Fired during program deactivation
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Deactivator
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src;

/**
 * The "Slate/Src/Interfaces/Core/Deactivator" interface handles the method signatures dedicated for the "Slate/Src/Deactivator" class.
 */
use \Slate\Src\Interfaces\Core\Deactivator as Deactivator_Interface;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Fired during program deactivation.
 *
 * This class defines all code necessary to run during the program's deactivation.
 */
final class Deactivator extends Abstract_Core_Context implements Deactivator_Interface {

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
	public static function deactivate() : void {
		do_action(
			sprintf(
				'%1$s[on][deactivation]',
				$this->prefix,
			)
		);	

		self::flush_rewrite_rules();
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
	public static function flush_rewrite_rules() : void {
		flush_rewrite_rules();
		return;
	}
}