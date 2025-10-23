<?php
/**
 * This class is executes all the program configuration for WordPress Rest API.
 *
 * This class defines all code necessary to initialize the WP Rest API of the program.
 *
 * @package     Slate
 * @subpackage  Slate/Src 
 * @category    Slate/Src/Rest_API
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * This class is executes all the program configuration for WordPress Rest API.
 *
 * This class defines all code necessary to initialize the WP Rest API of the program.
 */
final class Rest_API extends Abstract_Core_Context {
	/**
	 * Define the core functionality of the program.
	 *
	 * Set the program name and the program version that can be used throughout the program.
	 * Set the hooks for the Custom Post Types.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		parent::__construct();

		$this->hooks->add_action( 'init', $this, 'rest_support_custom_post_type', 25 );
		$this->hooks->add_action( 'register_post_type_args', $this, 'rest_register_post_types', 10, 2 );
		$this->hooks->add_action( 'rest_api_init', $this, 'rest_display_custom_post_type_fields' );
		$this->hooks->run();
	}

	/**
	 * Contains all Custom Post Type allowed for Rest API.
	 *
	 * @since    1.0.0
	 * @return   array $post_types
	 */
	public function get_post_types() {
		$post_types = array(
			'posts'
		);
		return $post_types;
	}

	/**
	 * Get custom fields of post.
	 *
	 * @since    1.0.0
	 * @return   mixed $post_meta
	 */
	public function get_post_meta( $object, $field_name, $request ) {
		$post_meta = get_post_meta( $object['id'] );
		return $post_meta;
	}

	/**
	 * Add WP Rest API support to Post Types.
	 *
	 * @since    1.0.0
	 * 
	 * @access   public
	 * 
	 * @return   void
	 */
	public function rest_support_custom_post_type() {
		$post_types = $this->helper->wp_post_types();
		$post_type_names = $this->get_post_types();

		foreach ( $post_type_names as $post_type_name ) {
			if( isset( $post_types[ $post_type_name ] ) ) {
				$post_types[$post_type_name]->show_in_rest = true;
				// Optionally customize the rest_base or controller class
				$post_types[$post_type_name]->rest_base = $post_type_name;
				$post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
			}
		}
	}

	/**
	 * Display Custom Post Type on WP Rest API.
	 *
	 * @since    1.0.0
	 * 
	 * @access   public
	 * 
	 * @return   array $args
	 */
	public function rest_register_post_types( $args, $post_type ) {
		$post_type_names = $this->get_post_types();

		foreach ( $post_type_names as $post_type_name ) {
			if ( $post_type_name === $post_type ) {
				$args['show_in_rest'] = true;
			}
		}
		return $args;
	}

	/**
	 * Display Custom Post Types
	 * Custom fields on WP Rest API.
	 *
	 * @since    1.0.0
	 * 
	 * @access   public
	 * 
	 * @return   void
	 */
	public function rest_display_custom_post_type_fields() {
		$post_type_names = $this->get_post_types();

		register_rest_field(
			$post_type_names,
			'custom_fields', //New Field Name in JSON RESPONSEs
			array(
				'get_callback'    => array( $this, 'get_post_meta' ), // custom function name
				'update_callback' => null,
				'schema'          => null,
			)
		);
	}
}
