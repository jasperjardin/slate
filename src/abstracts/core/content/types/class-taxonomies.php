<?php
/**
 * Abstract "Taxonomies" content-type base.
 *
 * Provides common properties and methods for registering custom taxonomies.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Abstracts/Core/Content/Types
 * @category    Slate/Src/Abstracts/Core/Content/Types/Taxonomies
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Abstracts\Core\Content\Types;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Base class for Taxonomies.
 */
abstract class Taxonomies extends Abstract_Core_Context {
	/**
	 * The list of post-types for the taxonomy.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array			$post_types		The list of post-types for the taxonomy.
	 */
	protected $post_types;

	/**
	 * The name for the taxonomy.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string			$taxonomy		The name for the taxonomy.
	 */
	protected $taxonomy;

	/**
	 * The slug for the taxonomy.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$tax_slug		The slug for the taxonomy.
	 */
	protected $tax_slug;

	/**
	 * The singular taxonomy label.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$singular		The singular taxonomy label.
	 */
	protected $singular;

	/**
	 * The plural taxonomy label.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$plural		The plural taxonomy label.
	 */
	protected $plural;

	/**
	 * The singular taxonomy label lower-case.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$singular_lower		The singular taxonomy label lower-case.
	 */
	protected $singular_lower;

	/**
	 * The plural taxonomy label lower-case.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$plural_lower		The plural taxonomy label lower-case.
	 */
	protected $plural_lower;

	/**
	 * Class initializations of properties, methods and hooks.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function __construct() {
		if ( empty( $this->taxonomy ) ) {
			return;
		}

		/**
		 * Initialize the parent class.
		 */
		parent::__construct();
		
		if ( true !== $this->config::get( "taxonomies.{$this->taxonomy}.enabled" ) ) {
			return;
		}

		/**
		 * Set the taxonomy configuration from the config.
		 */
		$this->tax_slug 		= $this->config::get( "taxonomies.{$this->taxonomy}.tax_slug" );
		$this->post_types 		= $this->config::get( "taxonomies.{$this->taxonomy}.post_types" );
		$this->singular			= $this->config::get( "taxonomies.{$this->taxonomy}.singular" );
		$this->plural			= $this->config::get( "taxonomies.{$this->taxonomy}.plural" );
		$this->singular_lower 	= strtolower( $this->singular );
		$this->plural_lower		= strtolower( $this->plural );

		$this->hooks->add_action( 'init', $this, 'register' );
		$this->hooks->run();
	}

	/**
	 * Contains the labels for the taxonomy.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$labels		The taxonomy labels.
	 */
	public function labels() {
		$prefix 		= $this->prefix;
		$lang 			= $this->lang;
		$taxonomy 		= $this->taxonomy;

		$singular 		= $this->singular;
		$plural 		= $this->plural;
		$singular_lower = $this->singular_lower;
		$plural_lower 	= $this->plural_lower;

		/**
		 * The register_taxonomy() labels parameter values.
		 *
		 * @since	1.0.0
		 * 
		 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/
		 */

		$labels 	= array(
			'name'							=> sprintf( _x( 
				'%s', 'Taxonomy general name', $lang
			), $plural ),

			'singular_name'					=> sprintf( _x( 
				'%s', 'Taxonomy singular name', $lang
			), $singular ),

			'search_items'					=> sprintf( __( 
				'Search %s', $lang
			), $plural ),

			'all_items'						=> sprintf( __( 
				'All %s', $lang
			), $plural ),

			'parent_item'					=> sprintf( __( 
				'Parent %s', $lang
			), $plural ),

			'parent_item_colon'				=> sprintf( __( 
				'Parent %s:', $lang
			), $plural ),

			'name_field_description' 		=> sprintf( __( 
				'The "name field" is how the "%s Taxonomy" label appears on your site.', $lang
			), $plural ),

			'slug_field_description' 		=> sprintf( __( 
				'The "slug field" is how the "%s Taxonomy" renders a URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', $lang
			), $plural ),

			'parent_field_description' 		=> sprintf( __( 
				'Assign a "Parent %s Taxonomy Term" to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.', $lang
			), $plural ),

			'desc_field_description' 		=> sprintf( __( 
				'The description is not prominent to display by default; however, some themes may show it.', $lang
			), $plural ),

			'edit_item'						=> sprintf( __( 
				'Edit %s', $lang
			), $singular ),

			'view_item'						=> sprintf( __( 
				'View %s', $lang
			), $singular ),

			'update_item'            		=> sprintf( __( 
				'Update %s', $lang
			), $singular ),

			'add_new_item'					=> sprintf( __( 
				'Add New %s', $lang
			), $singular ),

			'new_item_name'					=> sprintf( __( 
				'New %s Name', $lang
			), $singular ),

			'separate_items_with_commas'	=> sprintf( __( 
				'Separate each "%s" term with commas', $lang
			), $singular ),

			'add_or_remove_items'			=> sprintf( __( 
				'Add or remove "%s" term', $lang
			), $singular ),

			'choose_from_most_used'			=> sprintf( __( 
				'Choose from the most used "%s" term', $lang
			), $singular ),
			
			'not_found'						=> sprintf( __( 
				'No "%s" term found', $lang
			), $plural_lower ),

			'no_terms'						=> sprintf( __( 
				'No "%s" terms', $lang
			), $plural_lower ),

			'filter_by_item'				=> sprintf( __( 
				'Filter by "%s" terms', $lang
			), $singular_lower ),

			'items_list_navigation'			=> sprintf( __( 
				'"%s" list navigation', $lang
			), $plural ),

			'items_list'					=> sprintf( __( 
				'"%s" list', $lang
			), $plural ),

			'most_used'						=> sprintf( _x( 
				'Most Used', '%s', $lang
			), $plural_lower ),

			'back_to_items'					=> sprintf( __( 
				'&larr; Go to %s', $lang
			), $plural ),

			'item_link'    					=> sprintf( _x( 
				'%s Link', 'navigation link block title', $lang
			), $singular ),

			'item_link_description'			=> sprintf( _x( 
				'A link to a %s', 'navigation link block description', $lang
			), $singular_lower )
			
		);

		$labels = apply_filters(
			sprintf( 
				'%1$s[taxonomy][%2$s][labels]',
				$prefix,
				$taxonomy
			),
		$labels, $lang );

		return $labels;
	}
	
	/**
	 * Contains the structure for the taxonomy arguements.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$taxonomy_args		The taxonomy arguements.
	 */
	public function args() {
		$prefix 		= $this->prefix;
		$lang 			= $this->lang;
		$taxonomy 		= $this->taxonomy;
		$tax_slug 		= $this->tax_slug;
		$post_types 	= $this->post_types;

		$singular 		= $this->singular;
		$singular_lower = $this->singular_lower;

		$post_types_str = ( is_array( $post_types ) && ! empty( $post_types ) ) ? implode( ', ', $post_types ) : '';


		/**
		 * The taxonomy arguements.
		 */
		$builtin				= $this->config::get( "taxonomies.{$this->taxonomy}.args.builtin", false);
		$public					= $this->config::get( "taxonomies.{$this->taxonomy}.args.public", false);
		$publicly_queryable		= $this->config::get( "taxonomies.{$this->taxonomy}.args.publicly_queryable", false);
		$show_ui				= $this->config::get( "taxonomies.{$this->taxonomy}.args.show_ui", true);
		$show_in_menu			= $this->config::get( "taxonomies.{$this->taxonomy}.args.show_in_menu", true);
		$show_in_nav_menus		= $this->config::get( "taxonomies.{$this->taxonomy}.args.show_in_nav_menus", true);

		$hierarchical			= $this->config::get( "taxonomies.{$this->taxonomy}.args.hierarchical", true);
		$query_var				= $this->config::get( "taxonomies.{$this->taxonomy}.args.query_var", true);
		$sort					= $this->config::get( "taxonomies.{$this->taxonomy}.args.sort", null);
		$rewrite				= $this->config::get( "taxonomies.{$this->taxonomy}.args.rewrite", array( 'slug' => $tax_slug ));
		$show_in_rest			= $this->config::get( "taxonomies.{$this->taxonomy}.args.show_in_rest", true);
		$rest_base				= $this->config::get( "taxonomies.{$this->taxonomy}.args.rest_base", $tax_slug);
		$rest_namespace			= $this->config::get( "taxonomies.{$this->taxonomy}.args.rest_namespace", 'wp/v2');
		$rest_controller_class	= $this->config::get( "taxonomies.{$this->taxonomy}.args.rest_controller_class", 'WP_REST_Terms_Controller');
		
		$show_tagcloud			= $this->config::get( "taxonomies.{$this->taxonomy}.args.show_tagcloud", true);
		$show_in_quick_edit		= $this->config::get( "taxonomies.{$this->taxonomy}.args.show_in_quick_edit", true);
		$show_admin_column		= $this->config::get( "taxonomies.{$this->taxonomy}.args.show_admin_column", true);

		$meta_box_cb			= $this->config::get( "taxonomies.{$this->taxonomy}.args.meta_box_cb", null);
		$meta_box_sanitize_cb	= $this->config::get( "taxonomies.{$this->taxonomy}.args.meta_box_sanitize_cb", null);

		$args					= $this->config::get( "taxonomies.{$this->taxonomy}.args.args", array());
		$capabilities			= $this->config::get( "taxonomies.{$this->taxonomy}.args.capabilities", array(
			'manage_terms' 	=> 'manage_categories',
			'edit_terms' 	=> 'manage_categories',
			'delete_terms'	=> 'manage_categories',
			'assign_terms'	=> 'manage_categories'
		));
		$default_term			= $this->config::get( "taxonomies.{$this->taxonomy}.args.default_term", array(
			'name'			=> '',
			'slug'			=> '',
			'description'	=> '',
		));

		/**
		 * The register_taxonomy() args parameter values.
		 *
		 * @since	1.0.0
		 * 
		 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/
		 */
		$taxonomy_args 		= array(
			'labels'				=> $this->labels(),
			'description'			=> sprintf( __( 
				'The "%1$s Taxonomy" is used for assigning %2$s for the following post-types: %3$s.', $lang
			), $singular, $singular_lower, $post_types_str ),

			'_builtin'				=> $builtin,
			'public'				=> $public,
			'publicly_queryable'	=> $publicly_queryable,
			'show_ui'				=> $show_ui,
			'show_in_menu'			=> $show_in_menu,
			'show_in_nav_menus'		=> $show_in_nav_menus,

			'hierarchical'			=> $hierarchical,
			'query_var'				=> $query_var,
			'sort'					=> $sort,
			'rewrite'				=> $rewrite,
			
			'show_in_rest'			=> $show_in_rest,
			'rest_base'				=> $rest_base,
			'rest_namespace'		=> $rest_namespace,
			'rest_controller_class'	=> $rest_controller_class,
			
			'show_tagcloud'			=> $show_tagcloud,
			'show_in_quick_edit'	=> $show_in_quick_edit,
			'show_admin_column'		=> $show_admin_column,

			'meta_box_cb'			=> $meta_box_cb,
			'meta_box_sanitize_cb'	=> $meta_box_sanitize_cb,

			'args'					=> $args,
			'capabilities'			=> $capabilities,
			'default_term'			=> $default_term,
		);

		$taxonomy_args = apply_filters(
			sprintf( 
				'%1$s[taxonomy][%2$s][args]',
				$prefix,
				$taxonomy
			),
		$taxonomy_args, $lang );

		return $taxonomy_args;
	}

	/**
	 * Registers a taxonomy and its configurations.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @see 		https://developer.wordpress.org/reference/functions/register_taxonomy/
	 * @return		void
	 */
	public function register() {
		register_taxonomy( 
			$this->taxonomy, 
			$this->post_types, 
			$this->args()
		);

		return;
	}
}