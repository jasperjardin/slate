<?php
/**
 * Abstract "Post Types" content-type base.
 *
 * Provides common properties and methods for registering custom post types.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Abstracts/Core/Content/Types
 * @category    Slate/Src/Abstracts/Core/Content/Types/Post_Types
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
 * Base class for Post Types.
 */
abstract class Post_Types extends Abstract_Core_Context {
	/**
	 * The name for the post-type.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string			$post_type		The name for the post-type.
	 */
	protected $post_type;

	/**
	 * The list of taxonomies for the post-type.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array			$taxonomies		The list of taxonomies for the post-type.
	 */
	protected $taxonomies;

	/**
	 * The primary taxonomy for the post-type.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$primary_taxonomy		The primary taxonomy for the post-type.
	 */
	protected $primary_taxonomy;

	/**
	 * The slug for the post-type.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$post_slug		The slug for the post-type.
	 */
	protected $post_slug;

	/**
	 * The singular slug for the post-type.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$post_slug_singlar		The singular slug for the post-type.
	 */
	protected $post_slug_singlar;

	/**
	 * The singular post-type label.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$singular		The singular post-type label.
	 */
	protected $singular;

	/**
	 * The plural post-type label.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$plural		The plural post-type label.
	 */
	protected $plural;

	/**
	 * The singular post-type label lower-case.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$singular_lower		The singular post-type label lower-case.
	 */
	protected $singular_lower;

	/**
	 * The plural post-type label lower-case.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$plural_lower		The plural post-type label lower-case.
	 */
	protected $plural_lower;

	/**
	 * The post-type menu-icon.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$menu_icon		The post-type menu-icon.
	 */
	protected $menu_icon;

	/**
	 * The post-type menu position in wp-admin sidebar.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$menu_position		The post-type menu position in wp-admin sidebar.
	 */
	protected $menu_position;

	/**
	 * The post-type supported features to use.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array		$supports		The post-type supported features to use.
	 */
	protected $supports;

	/**
	 * The flag to check if the post-type has a rewrite rule.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			bool		$has_rewrite_rule		The flag to check if the post-type has a rewrite rule.
	 */
	protected $rewrite_rule_enabled;

	/**
	 * The flag to check if the rewrite rule for the slug to the primary term is enabled.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			bool		$rewrite_slug_to_primary_term_enabled		The flag to check if the rewrite rule for the slug to the primary term is enabled.
	 */
	protected $rewrite_slug_to_primary_term_enabled;

	/**
	 * The flag to check if the rewrite rule for a single post is enabled.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			bool		$rewrite_rule_single_post_enabled		The flag to check if the rewrite rule for a single post is enabled.
	 */
	protected $rewrite_rule_single_post_enabled;

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
		if ( empty( $this->post_type ) ) {
			return;
		}

		/**
		 * Initialize the parent class.
		 */
		parent::__construct();

		if ( true !== $this->config::get( "post_types.{$this->post_type}.enabled" ) ) {
			return;
		}

		/**
		 * Set the post type configuration from the config.
		 */
		$this->post_slug			= $this->config::get( "post_types.{$this->post_type}.post_slug" );
		$this->post_slug_singlar	= $this->config::get( "post_types.{$this->post_type}.post_slug_singlar" );
		$this->singular				= $this->config::get( "post_types.{$this->post_type}.singular" );
		$this->plural				= $this->config::get( "post_types.{$this->post_type}.plural" );
		$this->singular_lower		= strtolower( $this->singular );
		$this->plural_lower			= strtolower( $this->plural );
		$this->taxonomies			= $this->config::get( "post_types.{$this->post_type}.taxonomies" );
		$this->primary_taxonomy		= $this->config::get( "post_types.{$this->post_type}.primary_taxonomy" );
		$this->supports				= $this->config::get( "post_types.{$this->post_type}.supports" );
		$this->menu_icon			= $this->config::get( "post_types.{$this->post_type}.menu_icon" );
		$this->menu_position		= $this->config::get( "post_types.{$this->post_type}.menu_position" );
		$this->rewrite_rule_enabled	= $this->config::get( "post_types.{$this->post_type}.rewrites.enabled" );

		/**
		 * Set the rewrite rule enabled flags.
		 */
		$this->rewrite_slug_to_primary_term_enabled	= $this->config::get( "post_types.{$this->post_type}.rewrites.rewrite_slug_to_primary_term", false );
		$this->rewrite_rule_single_post_enabled		= $this->config::get( "post_types.{$this->post_type}.rewrites.rewrite_rule_single_post", false );

		$this->hooks->add_action( 'init', $this, 'initialize' );
		$this->hooks->add_filter( 'register_post_type_args', $this, 'register_post_type_args', 10, 2 );
		$this->hooks->add_filter( 'post_type_link', $this, 'set_post_type_link_to_primary_term', 1, 4 );
		$this->hooks->run();
	}

	/**
	 * Optional init hook target for children.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return 		void
	 */
	public function initialize() {
		/**
		 * Register the post type.
		 */
		$this->register();

		/**
		 * Add rewrite rule if enabled.
		 */
		if ( true === $this->rewrite_rule_enabled ) {
			/**
			 * Rewrite the rule for a single post.
			*/
			$this->rewrite_rule_single_post();

			/**
			 * Additional rewrite rules to be executed on initialize.
			 */
			$this->rewrite_on_initialize();
		}

		return;
	}

	/**
	 * Get the primary taxonomy term for a post.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @param		int			$post_id			The post ID.
	 * @param		string		$primary_taxonomy	The primary taxonomy.
	 * @return		array		$primary_term		Array of the primary taxonomy term.
	 */
	public function get_post_primary_tax_term( $post_id, $primary_taxonomy ) {
		$primary_id		= false;
		$primary_term	= false;
		if ( function_exists( 'yoast_get_primary_term' ) ) {
			$primary_id = yoast_get_primary_term_id( $primary_taxonomy, $post_id );

			if ( $primary_id ) {
				$primary_term = get_term( $primary_id );
			}
		}

		return $primary_term;
	}

	/**
	 * Additional rewrite rules to be executed on initialize.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function rewrite_on_initialize() {
		return;
	}

	/**
	 * Additional rewrite rules to be executed on registering the post type.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @param		array		$args			The post type arguments.
	 * @param		string		$post_type		The post type.
	 * @return		array		$args			The post type arguments.
	 */
	public function rewrite_on_register_post_type_args( $args, $post_type ) {
		return $args;
	}

	/**
	 * Adds a rewrite rule for a single post.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @see 		https://developer.wordpress.org/reference/functions/add_rewrite_rule/
	 * @return		void
	 */
	public function rewrite_rule_single_post() {
		if ( false === $this->rewrite_rule_enabled ) return;
		
		if ( false === $this->rewrite_rule_single_post_enabled ) return;

		$post_id	= get_the_ID();
		$post_data	= get_post( $post_id );
		
		if ( ! is_object( $post_data ) ) {
			return;
		}

		add_rewrite_rule(
			sprintf( '^%1$s/%2$s', $this->post_type, '([^/]*)' ),
			sprintf( 'index.php?post_type=%1$s&name=$matches[1]', $this->post_type ),
			'top'
		);

		flush_rewrite_rules();

		return;
	}

	/**
	 * Rewrite the slug to the primary term.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @param		array		$args			The post type arguments.
	 * @param		string		$post_type		The post type.
	 * @return		array		$args			The post type arguments.
	 */
	public function rewrite_slug_to_primary_term( $args, $post_type ) {

		if ( false === $this->rewrite_rule_enabled ) return $args;
		
		if ( false === $this->rewrite_slug_to_primary_term_enabled ) return $args;

		$post_id	= get_the_ID();
		$post_type	= $this->post_type;
		$post_data	= get_post( $post_id );
		$post_slug	= $this->post_slug;

		$primary_taxonomy		= $this->primary_taxonomy;
		$primary_placeholder	= "%{$primary_taxonomy}%";

		if ( is_object( $post_data ) ) {
			$primary_portfolio_type_term = $this->get_post_primary_tax_term( $post_id, $primary_taxonomy );
			
			if ( ! empty( $primary_portfolio_type_term ) ) {
				$args['rewrite']['slug'] = sprintf( '%1$s/%2$s', $post_slug, $primary_placeholder );
			} else {
				$args['rewrite']['slug'] = $post_slug;
			}
		}

		return $args;
	}

	/**
	 * Restructure the permalink structure of a post.
	 * Filters the permalink for a post of a custom post type.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @param		string		$post_link		The post link.
	 * @param		object		$post			The post object.
	 * @param		bool		$leavename		Whether to leave the name intact.
	 * @param		bool		$sample			Whether to sample the post link.
	 * @return		string		$post_link		The post link.
	 */
	public function set_post_type_link_to_primary_term( $post_link, $post, $leavename, $sample ) {
		if ( false === $this->rewrite_rule_enabled ) return $post_link;
		
		if ( false === $this->rewrite_slug_to_primary_term_enabled ) return $post_link;

		$prefix			= $this->prefix;
		$lang			= $this->lang;
		$post_id		= $post->ID;
		$post_type		= $this->post_type;
		$post_data		= $post;
		
		$primary_taxonomy		= $this->primary_taxonomy;
		$primary_placeholder	= "%{$primary_taxonomy}%";
		$restructured_link		= $post_link;

		$rewrite_primary_tax_term		= sprintf(
			'%1$s',
			'%' . $primary_taxonomy . '%',
		);
		
		if ( is_object( $post_data ) && get_post_type( $post_data ) == $post_type ) {
			$primary_taxonomy_terms = wp_get_object_terms( $post_id, $primary_taxonomy );

			if ( ! empty( $primary_taxonomy_terms ) && ! is_wp_error( $primary_taxonomy_terms ) ) {
				$restructured_link = str_replace( $rewrite_primary_tax_term, $primary_taxonomy_terms[0]->slug, $restructured_link );
			} else {
				$restructured_link = str_replace( $rewrite_primary_tax_term . '/', '', $restructured_link );
			}

			$post_link = $restructured_link;
		}

		$post_link = apply_filters(
			sprintf( 
				'%1$s[post_type][%2$s][set_post_type_link_to_primary_term]',
				$prefix,
				$post_type
			),
		$post_link, $post, $leavename, $sample );
	
		return $post_link;
	}

	/**
	 * Hook point for altering register_post_type args (default passthrough).
	 * Filters the arguments for registering a post type.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @hook		register_post_type_args
	 * @see 		https://developer.wordpress.org/reference/hooks/register_post_type_args/
	 * @param		array		$args			The post type arguments.
	 * @param		string		$post_type		The post type.
	 * @return		array		$args			The post type arguments.
	 */
	public function register_post_type_args( $args, $post_type ) {

		if ( $post_type !== $this->post_type ) {
			return $args;
		}

		/**
		 * Add rewrite rule if enabled.
		 */
		if ( true === $this->rewrite_rule_enabled ) {
			/**
			 * Rewrite the slug to the primary term.
			 */
			$args = $this->rewrite_slug_to_primary_term( $args, $post_type );

			/**
			 * Additional rewrite rules to be executed on registering the post type.
			 */
			$args = $this->rewrite_on_register_post_type_args( $args, $post_type );
		}
		
		return $args;
	}

	/**
	 * Default labels for post type.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$labels		The default labels for the post type.
	 */
	public function labels() {
		$singular 		= $this->singular;
		$plural 		= $this->plural;
		$singular_lower = $this->singular_lower;
		$plural_lower 	= $this->plural_lower;

		$labels = array(
			'name'					=> sprintf( _x( '%s', 'Post type general name', $this->lang ), $plural ),
			'singular_name'			=> sprintf( _x( '%s', 'Post type singular name', $this->lang ), $singular ),
			'menu_name'				=> sprintf( _x( '%s', 'Admin Menu text', $this->lang ), $plural ),
			'name_admin_bar'		=> sprintf( _x( '%s', 'Add New on admin bar', $this->lang ), $singular ),
			'add_new'				=> sprintf( __( 'Add New %s', $this->lang ), $singular ),
			'add_new_item'			=> sprintf( __( 'Add New %s', $this->lang ), $singular ),
			'edit_item'				=> sprintf( __( 'Edit %s', $this->lang ), $singular ),
			'view_item'				=> sprintf( __( 'View %s', $this->lang ), $singular ),
			'all_items'				=> sprintf( __( 'All %s', $this->lang ), $plural ),
			'search_items'			=> sprintf( __( 'Search %s', $this->lang ), $plural ),
			'parent_item_colon'		=> sprintf( __( 'Parent %s:', $this->lang ), $plural ),
			'not_found'				=> sprintf( __( 'No %s found.', $this->lang ), $plural_lower ),
			'not_found_in_trash'	=> sprintf( __( 'No %s found in Trash.', $this->lang ), $plural_lower ),
			'featured_image'		=> sprintf( _x( '%s Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', $this->lang ), $singular ),
			'set_featured_image'	=> sprintf( _x( 'Set %s Featured Image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', $this->lang ), $singular ),
			'remove_featured_image'	=> sprintf( _x( 'Remove %s Featured Image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', $this->lang ), $singular ),
			'use_featured_image'	=> sprintf( _x( 'Use as %s Featured Image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', $this->lang ), $singular ),
			'archives'				=> sprintf( _x( '%s', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', $this->lang ), $plural ),
			'insert_into_item'		=> sprintf( _x( 'Insert into %s', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', $this->lang ), $singular_lower ),
			'uploaded_to_this_item' => sprintf( _x( 'Uploaded to this %s', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', $this->lang ), $singular_lower ),
			'filter_items_list'		=> sprintf( _x( 'Filter %s list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', $this->lang ), $plural_lower ),
			'items_list_navigation'	=> sprintf( _x( '%s list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', $this->lang ), $plural ),
			'items_list'			=> sprintf( _x( '%s list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', $this->lang ), $plural ),
		);

		$labels = apply_filters(
			sprintf( '%1$s[post_type][%2$s][labels]', $this->prefix, $this->post_type ),
			$labels,
			$this->lang
		);

		return $labels;
	}

	/**
	 * Default supports list (child may override or pass custom).
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @param		array		$supports		The supported features to use.
	 * @return		array		$supports		The supported features to use.
	 */
	public function args_supports( $supports = [] ) {
		if ( empty( $supports ) || ! is_array( $supports ) ) {
			$supports = array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'trackbacks',
				'custom-fields',
				'comments',
				'revisions',
				'page-attributes',
				'post-formats',
			);
		}

		$supports = apply_filters(
			sprintf( '%1$s[post_type][%2$s][args][supports]', $this->prefix, $this->post_type ),
			$supports,
			$this->lang
		);

		return $supports;
	}

	/**
	 * Default post type args.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$args	The default post type arguments.
	 */
	public function args() {
		$public 				= $this->config::get( "post_types.{$this->post_type}.args.public", true );
		$exclude_from_search 	= $this->config::get( "post_types.{$this->post_type}.args.exclude_from_search", false );
		$publicly_queryable 	= $this->config::get( "post_types.{$this->post_type}.args.publicly_queryable", true );
		$show_ui 				= $this->config::get( "post_types.{$this->post_type}.args.show_ui", true );
		$show_in_nav_menus 		= $this->config::get( "post_types.{$this->post_type}.args.show_in_nav_menus", true );
		$show_in_menu 			= $this->config::get( "post_types.{$this->post_type}.args.show_in_menu", true );
		$show_in_admin_bar 		= $this->config::get( "post_types.{$this->post_type}.args.show_in_admin_bar", true );
		$capability_type 		= $this->config::get( "post_types.{$this->post_type}.args.capability_type", true );
		$hierarchical 			= $this->config::get( "post_types.{$this->post_type}.args.hierarchical", 'post' );
		$register_meta_box_cb 	= $this->config::get( "post_types.{$this->post_type}.args.register_meta_box_cb", '' );
		$has_archive 			= $this->config::get( "post_types.{$this->post_type}.args.has_archive", true );
		$permalink_epmask 		= $this->config::get( "post_types.{$this->post_type}.args.permalink_epmask", EP_PERMALINK );
		$query_var 				= $this->config::get( "post_types.{$this->post_type}.args.query_var", true );
		$can_export 			= $this->config::get( "post_types.{$this->post_type}.args.can_export", true );
		$delete_with_user 		= $this->config::get( "post_types.{$this->post_type}.args.delete_with_user", null );
		$show_in_rest 			= $this->config::get( "post_types.{$this->post_type}.args.show_in_rest", true );
		$builtin 				= $this->config::get( "post_types.{$this->post_type}.args.builtin", false );

		$args 					= array(
			'labels'				=> $this->labels(),
			'description'			=> sprintf( esc_html__( 'Handles the %s contents.', $this->lang ), $this->singular_lower ),
			'public'				=> $public,
			'exclude_from_search'	=> $exclude_from_search,
			'publicly_queryable' 	=> $publicly_queryable,
			'show_ui'				=> $show_ui,
			'show_in_nav_menus'		=> $show_in_nav_menus,
			'show_in_menu'			=> $show_in_menu,
			'show_in_admin_bar'		=> $show_in_admin_bar,
			'menu_position'			=> $this->menu_position,
			'menu_icon'				=> $this->menu_icon,
			'capability_type'		=> $capability_type,
			'hierarchical'			=> $hierarchical,
			'supports'				=> $this->args_supports( $this->supports ),
			'register_meta_box_cb'	=> $register_meta_box_cb,
			'taxonomies'			=> $this->taxonomies,
			'has_archive'			=> $has_archive,
			'rewrite'				=> array(
				'with_front'	=> false,
				'slug'			=> $this->post_slug_singlar,
			),
			'permalink_epmask'		=> $permalink_epmask,
			'query_var'				=> $query_var,
			'can_export'			=> $can_export,
			'delete_with_user'		=> $delete_with_user,
			'show_in_rest'			=> $show_in_rest,
			'rest_base'				=> $this->post_type,
			'rest_controller_class'	=> 'WP_REST_Posts_Controller',
			'_builtin'				=> $builtin,
			'_edit_link'			=> 'post.php?post=%d',
			'singular_label'		=> sprintf( __( '%s', $this->lang ), $this->singular ),
		);

		$args = apply_filters(
			sprintf( '%1$s[post_type][%2$s][args]', $this->prefix, $this->post_type ),
			$args,
			$this->lang
		);

		return $args;
	}

	/**
	 * Registers the post type using class properties.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function register() {
		register_post_type( $this->post_type, $this->args() );
		return;
	}
}