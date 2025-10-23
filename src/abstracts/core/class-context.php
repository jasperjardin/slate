<?php
/**
 * Abstract "Core Context" for the program.
 * 
 * Jump starts the program by loading the config and helper instances and other necessary components.
 * This class provides a common implementation for core context of the program that:
 * - Store a prefix
 * - Store a language text-domain
 * - Initialize a Config instance and load it's methods to the context
 * - Initialize a Helper instance and load it's methods to the context
 *
 * @package     Slate
 * @subpackage  Slate/Src/Abstracts/Core
 * @category    Slate/Src/Abstracts/Core/Context
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Abstracts\Core;

/**
 * The class responsible for loading the configuration array from the dedicated file.
 */
use \Slate\Src\Config as Config;

/**
 * The class responsible for loading the helper array from the dedicated file.
 */
use \Slate\Src\Helper as Helper;

/**
 * The class responsible for loading the hooks.
 */
use \Slate\Src\Hooks as Hooks;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Jump starts the program by loading the config and helper instances and other necessary components.
 * This class provides a common implementation for base context of the program that:
 * - Store a prefix
 * - Store a language text-domain
 * - Initialize a Config instance and load it's methods to the context
 * - Initialize a Helper instance and load it's methods to the context
 */
abstract class Context {
	/**
	 * The prefix.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @static
	 * @var			string		$prefix		The prefix.
	 */
	protected $prefix;

	/**
	 * The language text-domain.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @static
	 * @var			string		$lang		The language text-domain.
	 */
	protected $lang;
	
	/**
	 * The config instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			\Slate\Src\Config			$config		The config instance.
	 */
	protected $config;

	/**
	 * The helper instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			\Slate\Src\Helper			$helper		The helper instance.
	 */
	protected $helper;

	/**
	 * The hooks instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			\Slate\Src\Hooks			$hooks		The hooks instance.
	 */
	protected $hooks;

	/**
	 * Initialize and load components when allowed.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function __construct() {
		$this->config = new Config();
		$this->helper = new Helper();
		$this->hooks = new Hooks();

		$this->prefix = Config::get( 'theme.prefix' );
		$this->lang = Config::get( 'theme.lang' );
	}
}