<?php
/**
 * The class that handles the configuration for the default post-types.
 *
 * This class defines all code necessary to initialize the default post-types.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Components/Post_Types/Defaults
 * @category    Slate/Src/Components/Post_Types/Defaults/Config
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Post_Types\Defaults;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

final class Config extends Abstract_Core_Context {

	/**
	 *	Constructor to register all necessary hooks.
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
		 * Filter to disable access and hide UI for the 'post-type.'
		 */
		$this->hooks->add_filter( 'register_post_type_args', $this, 'disable_post_type_ui_and_access', 10, 2 );

		$this->hooks->run();
	}

	/**
	 *	Disables the default post type by making it non-public and hiding all UI.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @hook		register_post_type_args
	 * @see 		https://developer.wordpress.org/reference/hooks/register_post_type_args/
	 * @param 		array 		$args			The arguments for the post type.
	 * @param 		string 		$post_type		The post type slug.
	 * @return 		array 		$args			The modified arguments.
	 */
	public function disable_post_type_ui_and_access( $args, $post_type ) {
		$builtin_post_types = $this->config::get( 'post_types.builtin' );

		if ( ! is_array( $builtin_post_types ) || empty( $builtin_post_types ) ) return $args;

		foreach ( $builtin_post_types as $builtin_post_type ) {

			/**
			 * If the post type is enabled, skip it.
			 */
			if ( true !== $builtin_post_type['enabled'] ) {
				$args	=	array(
					'public'				=>	false,
					'show_ui'				=>	false,
					'show_in_menu'			=>	false,
					'show_in_admin_bar'		=>	false,
					'show_in_nav_menus'		=>	false,
					'can_export'			=>	false,
					'has_archive'			=>	false,
					'exclude_from_search'	=>	true,
					'publicly_queryable'	=>	false,
					'show_in_rest'			=>	false, // For Gutenberg/REST API
				);
			}
		}

		return $args;
	}
}