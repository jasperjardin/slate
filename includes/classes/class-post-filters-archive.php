<?php
/**
 * Class Post Filters Archive
 *
 * @package mfw
 */

declare( strict_types = 1 );

/**
 * Post Filters Archive class
 */
class Post_Filters_Archive {
	/**
	 * Instance of self
	 *
	 * @var self
	 */
	protected static $instance;

	/**
	 * Constructor
	 */
	protected function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_api_endpoints' ) );
	}

	/**
	 * Get Singleton Instance.
	 *
	 * @param mixed ...$args Args assigned to instance in constructor.
	 * @return self
	 */
	public static function get_instance( ...$args ) {
		if ( is_null( self::$instance ) ) {
			static::$instance = new static( ...$args );
		}

		return static::$instance;
	}

	/**
	 * Register API Endpoints
	 *
	 * @return void
	 */
	public function register_api_endpoints() {
		register_rest_route(
			'post-filters-archive',
			'/get-posts',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'rest_get_posts' ),
				'permission_callback' => '__return_true',
			)
		);

		register_rest_route(
			'post-filters-archive',
			'/get-taxonomies',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'rest_get_taxonomies' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * REST Get Posts
	 *
	 * @param  WP_REST_Request $request WP REST request.
	 * @return WP_REST_Response
	 */
	public function rest_get_posts( WP_REST_Request $request ): WP_REST_Response {
		$params = $request->get_query_params();

		$posts = $this->get_formatted_posts( $params );

		return new WP_REST_Response( $posts, 200 );
	}

	/**
	 * REST Get Taxonomies
	 *
	 * @param  WP_REST_Request $request WP REST request.
	 * @return WP_REST_Response
	 */
	public function rest_get_taxonomies( WP_REST_Request $request ): WP_REST_Response {
		$params = $request->get_query_params();

		$taxonomies = $this->get_taxonomies( $params );

		return new WP_REST_Response( $taxonomies, 200 );
	}

	/**
	 * Get Formatted Posts
	 *
	 * @param  array $params Params to filter posts to display.
	 * @return array
	 */
	protected function get_formatted_posts( array $params ): array {
		$args = wp_parse_args(
			$params,
			array(
				's'              => '',
				'paged'          => 1,
				'posts_per_page' => 12,
				'orderby'        => 'date',
				'author'         => 0,
			)
		);

		if ( ! empty( $args['s'] ) ) {
			unset( $args['orderby'] );
		}

		// Create tax query from terms.
		if ( isset( $params['tax'] ) && is_array( $params['tax'] ) && ! empty( $params['tax'] ) ) {
			foreach ( $params['tax'] as $tax => $terms ) {
				$args['tax_query'][] = array(
					'taxonomy' => $tax,
					'terms'    => explode( ',', $terms ),
				);
			}
		}

		// Set post type param.
		if ( isset( $params['post_type'] ) && is_string( $params['post_type'] ) ) {
			$args['post_type'] = explode( ',', $params['post_type'] );
		}

		// Send single type as string. Fixes relevanssi 'post_type' => array( 'any' ) issue.
		if ( is_array( $args['post_type'] ) && 1 === count( $args['post_type'] ) ) {
			$args['post_type'] = $args['post_type'][0];
		}

		// Set author param if provided.
		if ( isset( $params['author'] ) && is_numeric( $params['author'] ) ) {
			$args['author'] = intval( $params['author'] );
		}

		$args = apply_filters( 'post_filters_archive/query_args', $args, $params );

		$query = new WP_Query( $args );

		if ( function_exists( 'relevanssi_do_query' ) ) {
			relevanssi_do_query( $query );
		}

		$posts = array(
			'posts'         => array_map( fn( $post ) => $this->format_post( $post ), $query->posts ),
			'max_num_pages' => $query->max_num_pages,
			'found_posts'   => $query->found_posts,
			'args'          => $args,
		);

		return apply_filters( 'post_filters_archive/get_posts', $posts, $args );
	}

	/**
	 * Format Post
	 *
	 * @param  WP_Post|stdClass $post  WP Post object or Relevanssi object.
	 * @return array
	 */
	protected function format_post( WP_Post|stdClass $post ): array {
		$image_size    = apply_filters( 'post_filters_archive/post_image_size', 'post-card-thumb', $post );
		$post_type_obj = get_post_type_object( $post->post_type );

		$post_data = array(
			'ID'              => $post->ID,
			'post_type'       => $post->post_type,
			'post_type_label' => $post_type_obj->labels->singular_name,
			'post_date'       => $post->post_date,
			'post_title'      => $post->post_title,
			'post_excerpt'    => $post->post_excerpt,
			'post_name'       => $post->post_name,
			'permalink'       => get_permalink( $post->ID ),
			'featured_image'  => wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), $image_size ),
		);

		return apply_filters( 'post_filters_archive/post_data', $post_data );
	}

	/**
	 * Get Taxonomies
	 *
	 * @param  array $params Params to filter which taxonomies to get.
	 * @return array
	 */
	public function get_taxonomies( array $params ): array {
		$args = wp_parse_args(
			$params,
			array(
				'tax'        => '', // Comma separated taxonomy names, leave blank to get taxonomies by post type.
				'post_type'  => 'post', // Comma separated for multiple.
				'hide_empty' => true,
			)
		);

		$taxonomies = array();
		if ( ! empty( $args['tax'] ) ) {
			$taxonomies = explode( ',', $args['tax'] );
		} elseif ( ! empty( $args['post_type'] ) ) {
			$post_types = explode( ',', $args['post_type'] );
			foreach ( $post_types as $post_type ) {
				$taxonomies = array_merge( $taxonomies, get_object_taxonomies( $post_type ) );
			}
		}

		$tax_data = array();
		foreach ( $taxonomies as $tax ) {
			$terms = get_terms(
				array(
					'hide_empty' => $args['hide_empty'],
					'taxonomy'   => $tax,
				)
			);

			// If the taxonomy is not found, skip it.
			if ( is_wp_error( $terms ) ) {
				continue;
			}

			$terms = array_values( $terms );

			if ( 'category' === $tax ) {
				$terms = array_filter(
					$terms,
					function ( $term ) {
						return 'uncategorized' !== $term->slug;
					}
				);
			}

			$tax_object = get_taxonomy( $tax );

			if ( ! empty( $terms ) ) {
				$terms_array = array_values( $terms );

				$tax_data[ $tax ] = array(
					'labels' => array(
						'name'     => $tax_object->labels->name,
						'singular' => $tax_object->labels->singular_name,
					),
					'name'   => $tax,
					'terms'  => $terms_array,
				);
			}
		}

		return apply_filters( 'post_filters_archive/tax_data', $tax_data );
	}
}
