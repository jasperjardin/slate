<?php
/**
 * The "Slate/Src/Interfaces/Core/Config" interface handles the method signatures dedicated for the "Slate/Src/Config" class.
 * 
 * @package     Slate
 * @subpackage  Slate/Src/Interfaces/Core
 * @category    Slate/Src/Interfaces/Core/Config
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
 * The "Slate/Src/Interfaces/Core/Config" interface handles the method signatures dedicated for the "Slate/Src/Config" class.
 */
interface Config {
	/**
	 * Load the configuration array from the dedicated file.
	 *
	 * @since       0.0.1
	 * @author      Jasper Jardin
	 * @created_at  2025-10-19
	 * @access		public
	 * @static
	 * @param		string			$filename		The filename to load the configuration from.
	 *
	 * @return		void
	 */
	public static function load( string $filename ): void;

	/**
	 * Get the configuration value for a given key.
	 *
	 * @since       0.0.1
	 * @author      Jasper Jardin
	 * @created_at  2025-10-19
	 * @access		public
	 * @static
	 * @throws		\Exception		When the key is not a valid string.
	 *
	 * @param		string			$key           The configuration key (e.g., 'theme.name', 'paths.assets.uri').
	 * @param		mixed			$default_key   The default value to return if the key does not exist.
	 *
	 * @return		mixed			$value			The configuration value for the given key.
	 */
	public static function get( string $key, $default_key = null ) : mixed;
}