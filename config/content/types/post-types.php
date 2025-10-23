<?php
/**
 * Configuration array for the Post Types for the Slate theme.
 *
 * This array is used to store the Post Types for the Slate theme.
 * It is loaded by the Config class.
 *
 * @package     Slate
 * @subpackage  Slate/Config/Content-Types
 * @category    Slate/Config/Content-Types/Post_Types
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	/**
	 * The post type configuration array.
	 */
	'post_types' => array(
		/**
		 * The built-in post types. Use this to disable the built-in post types.
		 * 
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @access		public
		 * @type		array
		 * @key			string		"builtin" is the key of the post type.
		 * @value		array		The configuration array for the built-in post types.
		 */
		'builtin' => array(
			// Posts (post): Typically used for blog entries or news, displayed in reverse chronological order.
			'post'					=> array(
				'enabled'			=> true,
			),
			// Pages (page): Used for static, non-chronological content like "About Us" or "Contact." They are hierarchical.
			'page'					=> array(
				'enabled'			=> true,
			),
			// Attachments (attachment): Used for uploaded media files and their metadata.
			'attachment'			=> array(
				'enabled'			=> true,
			),
			// Revisions (revision): Stores the history of changes for posts and pages.
			'revision'				=> array(
				'enabled'			=> true,
			),
			// Navigation Menus (nav_menu_item): Used to store the items within your custom navigation menus.
			'nav_menu_item'			=> array(
				'enabled'			=> true,
			),
			// Custom CSS (custom_css): Stores the CSS added through the Customizer's Additional CSS panel.
			'custom_css'			=> array(
				'enabled'			=> true,
			),
			// Changesets (customize_changeset): Temporarily stores changes made in the Customizer.
			'customize_changeset'	=> array(
				'enabled'			=> true,
			)
		),
		
		/**
		 * Configuration array for the Portfolio post type.
		 * 
		 * 
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @access		public
		 * @type		array
		 * @key			string		"portfolio" is the key of the post type.
		 * @value		array		The configuration array for the Portfolio post type.
		 */
		'portfolio' => array(
			// The flag to check if this post type is enabled.
			'enabled'			=> true, 

			// The slug for this post type.
			'post_slug'			=> 'portfolios',
			// The singular slug for this post type.
			'post_slug_singlar'	=> 'portfolio',
			// The singular name for this post type.
			'singular'			=> 'Portfolio',
			// The plural name for this post type.
			'plural'			=> 'Portfolios',
			// The taxonomies for this post type.
			'taxonomies'		=> [ 'portfolio-type' ],
			// The primary taxonomy for this post type.
			'primary_taxonomy'	=> 'portfolio-type',
			// The supports for this post type.
			'supports'			=> [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields', 'revisions' ],
			// The menu icon for this post type.
			'menu_icon'			=> 'dashicons-location',
			// The menu position for this post type.
			'menu_position'		=> 6,

			// The rewrite rules for this post type.
			'rewrites'			=> array(
				// The flag to check if the rewrite rules for this post type are enabled.
				'enabled'						=> true, 
				// The flag to check if the rewrite rule for the slug to the primary term is enabled.
				'rewrite_slug_to_primary_term'	=> true, 
				// The flag to check if the rewrite rule for a single post is enabled.
				'rewrite_rule_single_post'		=> true, 
			),

			// The arguments for this post type.
			'args'				=> array(
				// The flag to check if this post type is public.
				'public'				=> true,
				// The flag to check if this post type is excluded from search.
				'exclude_from_search'	=> false,
				// The flag to check if this post type is publicly queryable.
				'publicly_queryable' 	=> true,
				// The flag to check if this post type is shown in the admin UI.
				'show_ui'				=> true,
				// The flag to check if this post type is shown in the navigation menus.
				'show_in_nav_menus'		=> true,
				// The flag to check if this post type is shown in the admin menu.
				'show_in_menu'			=> true,
				// The flag to check if this post type is shown in the admin bar.
				'show_in_admin_bar'		=> true,
				// The flag to check if this post type is hierarchical.
				'hierarchical'			=> true,
				// The capability type for this post type.
				'capability_type'		=> 'post',
				// The callback function for the register meta box.
				'register_meta_box_cb'	=> '',
				// The flag to check if this post type has an archive.
				'has_archive'			=> true,
				// The permalink epmask for this post type.
				'permalink_epmask'		=> '',
				// The flag to check if this post type is queryable.
				'query_var'				=> true,
				// The flag to check if this post type is exportable.
				'can_export'			=> true,
				// The flag to check if this post type is deleted with the user.
				'delete_with_user'		=> null,
				// The flag to check if this post type is shown in the REST API.
				'show_in_rest'			=> true,
				// The flag to check if this post type is a built-in post type.
				'builtin'				=> false,
			),
		),
	),
);
