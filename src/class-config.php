<?php
/**
 * Config class for the Slate theme.
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Config
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src;

/**
 * This class is used to load the configuration array from the dedicated file.
 * It checks if the theme is a plugin, parent theme or child theme and loads the configuration from the appropriate file.
 * The configuration array is stored in the $config property.
 *
 * @example
 * ```php
 * $config = Config::get( 'theme.name' );
 * echo $config;
 * ```
 */
final class Config {
	/**
	 * The configuration array.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		private
	 * @static
	 * @var			array	$config		The configuration array.
	 */
	private static $config = array();

	/**
	 * Allow-list of callable functions for resolver execution.
	 *
	 * @since       0.0.1
	 * @author      Jasper Jardin
	 * @created_at  2025-10-19
	 * @access		private
	 * @static
	 * @var			array	$allowed_functions		The allow-list of callable functions for resolver execution.
	 */
	private static $allowed_functions = array(
		'wp_create_nonce',
	);

	/**
	 * Parse and maybe invoke a whitelisted function encoded as a string.
	 * Example accepted input: 'wp_create_nonce("slate_ajax")'
	 *
	 * @since       0.0.1
	 * @author      Jasper Jardin
	 * @created_at  2025-10-19
	 * @access		private
	 * @static
	 * @param		string			$data		The data to parse and maybe invoke the function from.
	 *
	 * @return		mixed			$data		The data with the function parsed and invoked.
	 */
	private static function maybe_invoke_function_string( $data ) {
		if ( ! is_string( $data ) ) {
			return $data;
		}

		if ( ! preg_match( '/^([A-Za-z_][A-Za-z0-9_]*)\s*\((.*)\)\s*$/', $data, $m ) ) {
			return $data;
		}

		$fn       = $m[1];
		$args_str = trim( $m[2] );

		if ( ! in_array( $fn, self::$allowed_functions, true ) || ! function_exists( $fn ) ) {
			return $data;
		}

		$args = self::parse_function_args( $args_str );

		return call_user_func_array( $fn, $args );
	}

	/**
	 * Normalize the argument string.
	 *
	 * @since       0.0.1
	 * @author      Jasper Jardin
	 * @created_at  2025-10-19
	 * @access		private
	 * @static
	 * @param		string			$text		The string to normalize.
	 *
	 * @return		string			$text		The normalized string.
	 */
	private static function normalize_arg( string $text ): string {
		if (
			( substr( $text, 0, 1 ) === '"' && substr( $text, -1 ) === '"' ) ||
			( substr( $text, 0, 1 ) === "'" && substr( $text, -1 ) === "'" )
		) {
			$text = substr( $text, 1, -1 );
		}
		return $text;
	}

	/**
	 * Split comma-separated args, respecting quotes, and strip surrounding quotes.
	 *
	 * @since       0.0.1
	 * @author      Jasper Jardin
	 * @created_at  2025-10-19
	 * @access		private
	 * @static
	 * @param		string			$parse_text		The string to parse the function arguments from.
	 *
	 * @return		array			$args		The array of function arguments.
	 */
	private static function parse_function_args( string $parse_text ): array {
		$args       = array();
		$buf        = '';
		$in_quote   = false;
		$quote_char = '';
		$len        = strlen( $parse_text );

		for ( $i = 0; $i < $len; $i++ ) {
			$ch = $parse_text[ $i ];

			if ( $in_quote ) {
				if ( $ch === $quote_char && ( $i === 0 || $parse_text[ $i - 1 ] !== '\\' ) ) {
					$in_quote = false;
				}
				$buf .= $ch;
				continue;
			}

			if ( $ch === '"' || $ch === "'" ) {
				$in_quote   = true;
				$quote_char = $ch;
				$buf       .= $ch;
				continue;
			}

			if ( $ch === ',' ) {
				$args[] = self::normalize_arg( trim( $buf ) ); 
				$buf    = '';
				continue;
			}

			$buf .= $ch;
		}

		if ( trim( $buf ) !== '' ) {
			$args[] = self::normalize_arg( trim( $buf ) );
		}

		return $args;
	}

	/**
	 * Recursively replace %dot.path% placeholders with values from the config.
	 *
	 * @since       0.0.1
	 * @author      Jasper Jardin
	 * @created_at  2025-10-19
	 * @access		private
	 * @static
	 * @param		mixed			$data		The data to resolve the placeholders from.
	 *
	 * @return		mixed			$data		The data with the placeholders resolved.
	 */
	private static function resolve_placeholders( $data ) {
		if ( is_array( $data ) ) {
			foreach ( $data as $k => $v ) {
				$data[ $k ] = self::resolve_placeholders( $v );
			}
			return $data;
		}

		if ( is_string( $data ) ) {
			$prev = null;
			$curr = $data;
			$iterations = 0;

			// Allow a few passes to resolve nested placeholders.
			while ( $prev !== $curr && $iterations < 3 ) {
				$prev = $curr;
				$curr = preg_replace_callback(
					'/%([a-zA-Z0-9._-]+)%/',
					function( $m ) {
						$key = $m[1];
						// Use the original token if not found or not scalar.
						$val = self::get( $key, $m[0] );
						return is_scalar( $val ) ? (string) $val : $m[0];
					},
					$curr
				);
				$iterations++;
			}

			// After placeholder replacement, allow whitelisted function strings.
			$curr = self::maybe_invoke_function_string( $curr );

			return $curr;
		}

		return $data;
	}

	public static function load( string $filename ): void {

		// Resolve base path: prefer child theme, fallback to parent.
		$is_child_theme = is_child_theme();
		$base = $is_child_theme ? get_stylesheet_directory() : get_template_directory();
		$path = $base . '/config/' . $filename;

		// If not found in child, try parent.
		if ( ! file_exists( $path ) && $is_child_theme ) {
			$parent = get_template_directory() . '/config/' . $filename;
			if ( file_exists( $parent ) ) {
				$path = $parent;
			}
		}

		// If still not found, skip silently (e.g., when loader lists a missing file).
		if ( ! file_exists( $path ) ) {
			return;
		}

		// Require the config file and deep-merge into the accumulated config.
		$data = require $path;

		if ( is_array( $data ) ) {
			// Deep-merge the data into the config.
			self::$config = array_replace_recursive( self::$config, $data );

			// Resolve the placeholders (also executes whitelisted function strings on strings).
			self::$config = self::resolve_placeholders( self::$config );
		}
	}

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
	public static function get( string $key, $default_key = null ) {
		// Lazy-load config if not yet loaded (fallback in case get() is called early).
		if ( empty( self::$config ) ) {
			$loader_config = @require get_stylesheet_directory() . '/config/loader.php';
			if ( ! is_array( $loader_config ) ) {
				$loader_config = @require get_template_directory() . '/config/loader.php';
			}
			if ( is_array( $loader_config ) ) {
				foreach ( $loader_config as $slug ) {
					self::load( $slug );
				}
			}
		}

		if ( ! is_string( $key ) ) {
			throw new \Exception( 'Key must be a string' );
		}
		
		$config    = self::$config;

		if ( 'all' === $key ) {
			return $config;
		}

		// Split the key (e.g., 'theme.name' becomes ['theme', 'name']).
		$segments = explode( '.', $key );

		foreach ( $segments as $segment ) {
			// Normalize potential hyphens to underscores to match PHP array keys.
			$segment = str_replace( '-', '_', $segment );

			if ( is_array( $config ) && array_key_exists( $segment, $config ) ) {
				$config = $config[ $segment ];
			} else {
				return $default_key; // Key not found.
			}
		}

		return $config;
	}
}
