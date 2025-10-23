<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this program so that it is ready for translation.
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Localization
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this program so that it is ready for translation.
 */
final class Localization extends Abstract_Core_Context {
	/**
	 * The language directory path.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		private
	 * @var			string	$lang_path		The language directory path.
	 */
	private $lang_path;

	/**
	 * Initialize the Localization class.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function __construct() {
		parent::__construct();

		// Set the language directory path.
		$this->lang_path = $this->config->get( 'paths.languages.path' );
	}

	/**
	 * Load the program text domain for translation.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function load_textdomain() {
		load_theme_textdomain( $this->lang, "{$this->lang_path}/slate.php" );
	}
}
