<?php
/**
 * The "Slate/Src/Interfaces/Core/Hooks" interface handles the method signatures dedicated for the "Slate/Src/Hooks" class.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Interfaces/Core
 * @category    Slate/Src/Interfaces/Core/Hooks
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
 * The "Slate/Src/Interfaces/Core/Hooks" interface handles the method signatures dedicated for the "Slate/Src/Hooks" class.
 */
interface Hooks {
	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @param string $hook           The name of the WordPress action that is being registered.
	 * @param object $component      A reference to the instance of the object on which the action is defined.
	 * @param string $callback       The name of the function definition on the $component.
	 * @param int    $priority       Optional. The priority at which the function should be fired. Default is 10.
	 * @param int    $accepted_args  Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 * @return void
	 */
	public function add_action( string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1 ): void;

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @param string $hook           The name of the WordPress filter that is being registered.
	 * @param object $component      A reference to the instance of the object on which the filter is defined.
	 * @param string $callback       The name of the function definition on the $component.
	 * @param int    $priority       Optional. The priority at which the function should be fired. Default is 10.
	 * @param int    $accepted_args  Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 * @return void
	 */
	public function add_filter( string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1 ): void;

	/**
	 * The reference to the class that orchestrates the hooks with the program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array 		$hooks	The array of action & filter hooks registered with WordPress.
	 */
	public function get_hooks();

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function run(): void;
}