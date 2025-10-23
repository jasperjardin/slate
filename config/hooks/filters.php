<?php
/**
 * Contains all the configuration array related to setting up the "Slate Theme - Filter Hooks."
 * It is loaded by the Config class.
 *
 * This file defines constants that are specifically used to manage and register
 * filter hooks within the "Slate" system. These constants typically represent
 * the names of the filter hooks themselves, or prefixes/suffixes used in their
 * naming conventions. They provide a centralized and organized way to define
 * and reference filter hooks throughout the framework.
 *
 * Using constants for filter hook names improves code readability, maintainability,
 * and reduces the risk of typos when referencing these hooks in different parts
 * of the codebase.
 *
 * @package     Slate
 * @category    Slate/Config
 * @subpackage  Slate/Config/Hooks/Filters
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	/**
	 * The WordPress Filter hooks configuration array.
	 * Defines the Slate Theme filter hooks and their associated callbacks.
	 *
	 * Defines an array containing various filter hooks used within the Slate Theme.
	 * Each filter hook definition includes:
	 *
	 * - `accepted_args`    :   The number of arguments accepted by the filter hook's callback functions.
	 * - `callbacks`        :   An associative array where keys represent the priority of the callback
	 *                          and values represent the names of the callback functions.
	 */
	'filter_hooks' => array(
		/**
		 * Demo REST API filter pre get posts before.
		 *
		 * @example
		 * 'slate_rest_api_filter_pre_get_posts:before' => [
		 *  'accepted_args' => 3,
		 *  'callbacks'     => [
		 *      10  => 'slate_rest_api_filter_pre_get_posts_posts',
		 *      11  => 'slate_rest_api_filter_pre_get_posts_products',
		 *  ]
		 * ]
		 */
	),
);
