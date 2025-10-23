<?php
/**
 * Configuration array for the Taxonomies for the Slate theme.
 *
 * This array is used to store the Taxonomies for the Slate theme.
 * It is loaded by the Config class.
 *
 * @package     Slate
 * @subpackage  Slate/Config/Content-Types
 * @category    Slate/Config/Content-Types/Taxonomies
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	/**
	 * The taxonomy configuration array. Use this to disable the built-in taxonomies.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @type		array
	 * @key			string		"builtin" is the key of the taxonomy.
	 * @value		array		The configuration array for the built-in taxonomies.
	 */
	'taxonomies' => array(
		/**
		 * The built-in taxonomies.
		 * 
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @access		public
		 * @type		array
		 * @key			string		"builtin" is the key of the taxonomy.
		 * @value		array		The configuration array for the built-in taxonomies.
		 */
		'builtin' => array(
			// Category (category): Used for grouping posts in a broad sense. It is hierarchical (like folders).
			'category'		=> array(
				'enabled'	=> true,
			),
			// Tag (post_tag): Used for micro-grouping posts. It is non-hierarchical (like tags on a social media post).
			'post_tag'		=> array(
				'enabled'	=> true,
			),
			// Navigation Menus (nav_menu): Used to register and manage menu items. It is an internal hierarchical taxonomy.
			'nav_menu'		=> array(
				'enabled'	=> true,
			),
			// Link Categories (link_category): Used to categorize links (although the Links feature is hidden by default in newer WordPress versions). It is hierarchical.
			'link_category'	=> array(
				'enabled'	=> true,
			),
			// Post Formats (post_format): Used to classify posts based on how they should be formatted or presented by the theme (e.g., aside, gallery, video). It is an internal hierarchical taxonomy.
			'post_format'	=> array(
				'enabled'	=> true,
			),
		),
		
		/**
		 * Configuration array for the Portfolio Types taxonomy.
		 * 
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @access		public
		 * @type		array
		 * @key			string		"portfolio-types" is the key of the taxonomy.
		 * @value		array		The configuration array for the Portfolio Types taxonomy.
		 */
		'portfolio-types' => array(
			// The flag to check if this taxonomy is enabled.
			'enabled'			=> true,

			// The slug for this taxonomy.
			'tax_slug'			=> 'portfolio-types',
			// The post types for this taxonomy.
			'post_types'		=> [ 'portfolio' ],
			// The singular name for this taxonomy.
			'singular'			=> 'Portfolio Type',
			// The plural name for this taxonomy.
			'plural'			=> 'Portfolio Types',

			// The arguments for this taxonomy.
			'args'				=> array(
				// The flag to check if this taxonomy is a built-in taxonomy.
				'builtin'				=> false,
				// The flag to check if this taxonomy is public.
				'public'				=> false,
				// The flag to check if this taxonomy is publicly queryable.
				'publicly_queryable'	=> false,
				// The flag to check if this taxonomy is shown in the admin UI.
				'show_ui'				=> true,
				// The flag to check if this taxonomy is shown in the admin menu.
				'show_in_menu'			=> true,
				// The flag to check if this taxonomy is shown in the navigation menus.
				'show_in_nav_menus'		=> true,
		
				// The flag to check if this taxonomy is hierarchical.
				'hierarchical'			=> true,
				// The flag to check if this taxonomy is a query variable.
				'query_var'				=> true,
				// The flag to check if this taxonomy is sorted.
				'sort'					=> null,
				// The rewrite rules for this taxonomy.
				'rewrite'				=> array( 'slug' => 'portfolio-types' ),
				// The flag to check if this taxonomy is shown in the REST API.
				'show_in_rest'			=> true,
				// The REST base for this taxonomy.
				'rest_base'				=> 'portfolio-types',
				// The REST namespace for this taxonomy.
				'rest_namespace'		=> 'wp/v2',
				// The REST controller class for this taxonomy.
				'rest_controller_class'	=> 'WP_REST_Terms_Controller',
				
				// The flag to check if this taxonomy is shown in the tag cloud.
				'show_tagcloud'			=> true,
				// The flag to check if this taxonomy is shown in the quick edit.
				'show_in_quick_edit'	=> true,
				// The flag to check if this taxonomy is shown in the admin column.
				'show_admin_column'		=> true,
		
				// The callback function for the meta box.
				'meta_box_cb'			=> null,
				// The callback function for the meta box sanitization.
				'meta_box_sanitize_cb'	=> null,

				// The arguments for this taxonomy.
				'args'					=> array(),

				// The capabilities for this taxonomy.
				'capabilities'			=> array(
					// The capability to manage the terms.
					'manage_terms' 	=> 'manage_categories',
					// The capability to edit the terms.
					'edit_terms' 	=> 'manage_categories',
					// The capability to delete the terms.
					'delete_terms'	=> 'manage_categories',
					// The capability to assign the terms.
					'assign_terms'	=> 'manage_categories'
				),

				// The default term for this taxonomy.
				'default_term'			=> array(
					// The name of the default term.
					'name'			=> '',
					// The slug of the default term.
					'slug'			=> '',
					// The description of the default term.
					'description'	=> '',
				)
			),
		),
	),
);
