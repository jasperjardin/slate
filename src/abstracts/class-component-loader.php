<?php
/**
 * Abstract component loader for directory-based initializers.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Abstracts
 * @category    Slate/Src/Abstracts/Component_Loader
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Abstracts;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Provides a common implementation for component loaders that:
 * - store a prefix
 * - point to a directory
 * - optionally load on construct
 * - support a deprecated loader with filter support
 */
abstract class Component_Loader extends Abstract_Core_Context {
	/**
	 * The root directory path to load.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string			$root_directory		Root directory path to load.
	 */
	protected $root_directory;
	
	/**
	 * The component directory name to load.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string			$component_directory_name		Component directory name to load.
	 */
	protected $component_directory_name = '';

	/**
	 * The custom path to load.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			bool			$custom_directory_path		Custom directory path to load.
	 */
	protected $custom_directory_path = false;

	/**
	 * Filter key used in deprecated loader, e.g. 'metaboxes', 'post_type'.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string			$filter_key		Filter key used in deprecated loader, e.g. 'metaboxes', 'post_type'.
	 */
	protected $filter_key = '';

	/**
	 * Ignore files used in deprecated loader, e.g. 'sample.php'.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array			$ignored_files		Ignore files used in deprecated loader, e.g. 'sample.php'.
	 */
	protected $ignored_files = array( 'sample.php' );

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
		parent::__construct();

		if ( $this->should_load() ) {
			$this->root_directory = $this->config->get( 'paths.src.components.path' );

			$this->load_components();
		}
	}

	/**
	 * Gate for conditional loading. Subclasses can override.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @return		bool
	 */
	protected function should_load() {
        return true;
	}

	/**
	 * Use the verified directory path.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @param		string			$directory_path		The directory path to set.
	 * @return		string			$path				The verified directory path if it exists and is valid, an empty string otherwise.
	 */
	protected function use_verified_directory( $directory_path = '' ) {
		$path = '';

		/**
		 * Check if the directory path is valid.
		 */
		if ( ! empty( $directory_path ) && is_string( $directory_path ) ) {
			$dir = realpath( $directory_path );
			
			if ( false !== $dir || is_dir( $dir ) ) {
				$path = $dir;
			}
		}

		return $path;
	}

	/**
	 * Deprecated: scan the directory and include files with a filter.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function deprecated_load_components() {
		$directory 							= null;
		$component_directory_path			= "{$this->root_directory}/{$this->component_directory_name}";
		$verified_custom_directory_path		= $this->use_verified_directory( $this->custom_directory_path );
		$verified_component_directory_path	= ( ! empty( $this->component_directory_name ) && is_string( $this->component_directory_name ) ) ? $this->use_verified_directory( $component_directory_path ) : '';

		/**
		 * Determine the directory to load.
		 */
		if ( ! empty( $verified_custom_directory_path ) ) {
			$directory = $verified_custom_directory_path;
		} else {
			if ( ! empty( $verified_component_directory_path ) ) {
				$directory = $verified_component_directory_path;
			}
		}

		if ( ! empty( $directory ) && is_string( $directory ) ) {
			/**
			 * Apply filters to the files to load.
			 */
			$files = apply_filters(
				sprintf( '%1$s[deprecated_load_components][%2$s][files]', $this->prefix, $this->filter_key ),
				$this->helper->get_dir_files( $directory )
			);
	
			if ( empty( $files ) || ! is_array( $files ) ) {
				return;
			}
	
			foreach ( $files as $file ) {
				if (
					file_exists( "{$directory}{$file}" ) &&
					! in_array( $file, $this->ignored_files, true ) 
				) {
					require_once "{$directory}{$file}";
				}
			}
		}
	}

	/**
	 * Load initialize.php inside the directory if present.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function load_components() {
		$directory 							= null;
		$component_directory_path			= "{$this->root_directory}/{$this->component_directory_name}";
		$verified_custom_directory_path		= $this->use_verified_directory( $this->custom_directory_path );
		$verified_component_directory_path	= ( ! empty( $this->component_directory_name ) && is_string( $this->component_directory_name ) ) ? $this->use_verified_directory( $component_directory_path ) : '';

		/**
		 * Determine the directory to load.
		 */
		if ( ! empty( $verified_custom_directory_path ) ) {
			$directory = $verified_custom_directory_path;
		} else {
			if ( ! empty( $verified_component_directory_path ) ) {
				$directory = $verified_component_directory_path;
			}
		}
		/**
		 * Load the initialize.php file if it exists.
		 */
		if ( ! empty( $directory ) && is_string( $directory ) && file_exists( "{$directory}/initialize.php" ) ) {
			require_once "{$directory}/initialize.php";
		}
	}
}