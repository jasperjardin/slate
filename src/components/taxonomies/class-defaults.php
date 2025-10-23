<?php
/**
 * The class that handles the configuration for the default taxonomies.
 *
 * This class defines all code necessary to initialize the default taxonomies.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Components/Taxonomies/Defaults
 * @category    Slate/Src/Components/Taxonomies/Defaults/Config
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Taxonomies\Defaults;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

final class Config extends Abstract_Core_Context {

	/**
	 * Constructor to register all necessary hooks.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function __construct() {
		parent::__construct();

		/**
		 * Filter to disable access and hide UI for the 'taxonomy'.
		 */
		$this->hooks->add_action( 'init', $this, 'unregister_taxonomies' );

		$this->hooks->run();
	}

	/**
	 * Unregisters the specified built-in taxonomies.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @hook		init
	 * @see 		https://developer.wordpress.org/reference/hooks/init/
	 * @return void
	 */
	public function unregister_taxonomies() {
		$builtin_taxonomies = $this->config::get( 'taxonomies.builtin' );

		if ( ! is_array( $builtin_taxonomies ) || empty( $builtin_taxonomies ) ) return;

		foreach ( $builtin_taxonomies as $taxonomy_slug => $builtin_taxonomy ) {

			/**
			 * If the taxonomy is enabled, skip it.
			 */
			if ( true !== $builtin_taxonomy['enabled'] ) {
				if ( taxonomy_exists( $taxonomy_slug ) ) {
					unregister_taxonomy( $taxonomy_slug );
				}
			}
		}

		return;
	}
}