<?php
/**
 * Register all actions and filters hooks for the program
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Hooks
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src;

/**
 * The "Slate/Src/Interfaces/Core/Hooks" interface handles the method signatures dedicated for the "Slate/Src/Hooks" class.
 */
use \Slate\Src\Interfaces\Core\Hooks as Hooks_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Register all actions and filters hooks for the program.
 *
 * Maintain a list of all hooks that are registered throughout
 * the program, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 */
final class Hooks implements Hooks_Interface {
	/**
	 * The array of action & filter hooks registered with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array			$hooks	The action & filter hooks registered with WordPress to fire when the program loads.
	 */
	protected $hooks;

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array			$actions	The actions registered with WordPress to fire when the program loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array			$filters	The filters registered with WordPress to fire when the program loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function __construct() {
		$this->hooks	= array();
		$this->actions	= array();
		$this->filters	= array();
	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @param 		string		$hook				The name of the WordPress action that is being registered.
	 * @param 		object		$component			A reference to the instance of the object on which the action is defined.
	 * @param 		string		$callback			The name of the function definition on the $component.
	 * @param 		int			$priority			Optional. The priority at which the function should be fired. Default is 10.
	 * @param 		int			$accepted_args		Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 * @return		void
	 */
	public function add_action( string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1 ) : void {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args, 'action' );
		return;
	}	
	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @param 		string		$hook				The name of the WordPress filter that is being registered.
	 * @param 		object		$component			A reference to the instance of the object on which the filter is defined.
	 * @param 		string		$callback			The name of the function definition on the $component.
	 * @param 		int			$priority			Optional. The priority at which the function should be fired. Default is 10.
	 * @param 		int			$accepted_args		Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 * @return		void
	 */
	public function add_filter( string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1 ) : void {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args, 'filter' );
		return;
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single collection.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		private
	 * @param		array		$hooks				The collection of hooks that is being registered (that is, actions or filters).
	 * @param		string		$hook				The name of the WordPress filter that is being registered.
	 * @param		object		$component			A reference to the instance of the object on which the filter is defined.
	 * @param		string		$callback			The name of the function definition on the $component.
	 * @param		int			$priority			The priority at which the function should be fired.
	 * @param		int			$accepted_args		The number of arguments that should be passed to the $callback.
	 * @param		string		$type				The type of hook being registered (action or filter).
	 * @return		array		$hooks				The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args, $type ) {
		$register_hook = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		if ( 'action' === $type || 'filter' === $type ) {
			$this->hooks[$type] = $register_hook;
			$hooks[] = $register_hook;
		}

		return $hooks;
	}

	/**
	 * Get the array of action & filter hooks registered with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$hooks	The array of action & filter hooks registered with WordPress.
	 */
	public function get_hooks() {
		// Returns the hooks property.
		return $this->hooks;
	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function run() : void {
		// Execute all the filters registered to the Loader class run() method.
		if ( is_array( $this->filters ) && isset( $this->filters ) && ! empty( $this->filters ) ) {
			foreach ( $this->filters as $filter ) {
				add_filter( $filter['hook'], array( $filter['component'], $filter['callback'] ), $filter['priority'], $filter['accepted_args'] );
			}
		}

		// Execute all the actions registered to the Loader class run() method.
		if ( is_array( $this->actions ) && isset( $this->actions ) && ! empty( $this->actions ) ) {
			foreach ( $this->actions as $action ) {
				add_action( $action['hook'], array( $action['component'], $action['callback'] ), $action['priority'], $action['accepted_args'] );
			}
		}
	}
}