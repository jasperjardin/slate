<?php
/**
 * Contains all the configuration array related to setting up the "Slate Theme - Action Hooks."
 * It is loaded by the Config class.
 *
 * This file defines constants that are specifically used to manage and register
 * action hooks within the "Slate" system. These constants typically represent
 * the names of the action hooks themselves, or prefixes/suffixes used in their
 * naming conventions. They provide a centralized and organized way to define
 * and reference action hooks throughout the Slate Theme.
 *
 * Using constants for action hook names improves code readability, maintainability,
 * and reduces the risk of typos when referencing these hooks in different parts
 * of the codebase.
 *
 * @package     Slate
 * @category    Slate/Config
 * @subpackage  Slate/Config/Hooks/Actions
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	/**
	 * The WordPress Action hooks configuration array.
	 * Defines the Slate Theme action hooks and their associated callbacks.
	 *
	 * Defines an array containing various action hooks used within the Slate Theme.
	 * Each action hook definition includes:
	 *
	 * - `accepted_args`    :   The number of arguments accepted by the action hook's callback functions.
	 * - `callbacks`        :   An associative array where keys represent the priority of the callback
	 *                          and values represent the names of the callback functions.
	 *
	 * Action hooks are used to execute code at specific points in the execution flow.
	 */
	'action_hooks' => array(
		/**
		 * Demo REST API filter pre get posts before.
		 *
		 * @example
		 * 'slate_send_headers:after' => [
		 *  'accepted_args' => 2,
		 *  'callbacks'     => [
		 *      10  => 'slate_send_headers_cpt_products',
		 *      20  => 'slate_send_headers_cpt_posts',
		 *      30  => 'slate_send_headers_cpt_events',
		 *  ]
		 * ]
		 */
	),
);
