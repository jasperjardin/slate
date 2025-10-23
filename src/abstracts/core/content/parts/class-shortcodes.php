<?php
/**
 * Abstract "Shortcodes" content-type base.
 *
 * Provides common properties and methods for registering custom Shortcodes.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Abstracts/Core/Content/Parts
 * @category    Slate/Src/Abstracts/Core/Content/Parts/Shortcodes
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Abstracts\Core\Content\Parts;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Base class for Shortcodes.
 */
abstract class Shortcodes extends Abstract_Core_Context {
	/**
	 * The unique ID.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$uniqid				The The unique ID.
	 */
	protected $uniqid;
	/**
	 * The property that holds the shortcode tag
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$shortcode_tag		The property that holde the shortcode label.
	 */
	protected $shortcode_tag;

	/**
	 * The property that holds the shortcode attributes
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array		$shortcode_atts		The property that holds the shortcode attributes.
	 */
	protected $shortcode_atts = array();

	/**
	 * The property that holds the program shortcode universal class
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19	
	 * @access		protected
	 * 
	 * @var			string		$shortcode_class	The property that holds the program shortcode universal class.
	 */
	protected $shortcode_class;

	/**
	 * The property that holds the shortcode wrapper class
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$wrapper_class		The property that holds the shortcode wrapper class.
	 */
	protected $wrapper_class;

	/**
	 * The property that holds the shortcode indentifier class
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$identifier_class		The property that holds the shortcode indentifier class.
	 */
	protected $identifier_class;


	/**
	 * The property that holds the shortcode wrapper unique id
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * 
	 * @var			string		$wrapper_id				The property that holds the shortcode wrapper ID.
	 */
	protected $wrapper_id;

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
		/**
		 * Initialize the parent class.
		 */
		parent::__construct();
	}	

	/**
	 * Structure for the shortcode markup.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @abstract
	 * @access		protected
	 * @param		array		$atts			The shortcode attributes.
	 * @param		string		$content		The shortcode content.
	 * @return		string		$output			Shortcode HTML output.
	 */
	abstract protected function display( $atts, $content = null );

	/**
	 * Before register shortcode.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @return		void
	 */	
	protected function before_register_shortcode() {
		return;
	}

	/**
	 * After register shortcode.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @return		void
	 */
	protected function after_register_shortcode() {
		return;
	}

	/**
	 * Registers the shortcode.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @param		array		$atts			The shortcode attributes.
	 * @param		string		$content		The shortcode content.
	 * @param		string		$tag			The shortcode tag.
	 * @return		string		$output			Shortcode HTML output.
	 */	
	public function register_shortcode( $atts, $content = null, $tag = '' ) {
		/**
		 * Filter the shortcode attributes before processing.
		 * 
		 * @hook		Filter hook name: theme_prefix[shortcode][shortcode_tag_name][attributes::before]
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @param		array		$atts			The shortcode attributes.
		 */
		$atts = apply_filters(
			sprintf( 
				'%1$s[shortcode][%2$s][attributes::before]',
				$this->prefix,
				$this->shortcode_tag
			),
		$atts, $content, $tag );

		/**
		 * Shortcode attributes.
		 * 
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @param		array		$pairs			(Required) Entire list of supported attributes and their defaults.
		 * @param		string		$atts			(Required) User defined attributes in shortcode tag.
		 * @param		string		$shortcode		(Optional) The name of the shortcode, provided for context to enable filtering
		 * @return		array		$atts			Combined and filtered attribute list.
		 */
		$atts = shortcode_atts(
			$this->shortcode_atts,
			$atts,
			$this->shortcode_tag
		);

		/**
		 * Filter the shortcode attributes after processing.
		 * 
		 * @hook		Filter hook name: theme_prefix[shortcode][shortcode_tag_name][attributes::after]
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @param		array		$atts			The shortcode attributes.
		 */
		$atts = apply_filters(
			sprintf( 
				'%1$s[shortcode][%2$s][attributes::after]',
				$this->prefix,
				$this->shortcode_tag
			),
		$atts, $content, $tag );

		/**
		 * Filter the shortcode content before processing.
		 * 
		 * @hook		Filter hook name: theme_prefix[shortcode][shortcode_tag_name][content::before]
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @param		string		$content		The shortcode content.
		 * @param		array		$atts			The shortcode attributes.
		 * @param		string		$tag			The shortcode tag.	
		 */
		$content	= apply_filters(
			sprintf( 
				'%1$s[shortcode][%2$s][content::before]',
				$this->prefix,
				$this->shortcode_tag
			),
		$content, $atts, $tag );
		
		// Ensure nested shortcodes within the content are processed.
		$content 	= ( ! empty( $content ) && is_string( $content ) ) ? apply_filters( 'the_content', $content ) : $content;
		$tag		= ( ! empty( $tag ) && is_string( $tag ) ) ? $tag : '';
		
		/**
		 * Filter the shortcode content after processing.
		 * 
		 * @hook		Filter hook name: theme_prefix[shortcode][shortcode_tag_name][content::after]
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @param		string		$content		The shortcode content.
		 * @param		array		$atts			The shortcode attributes.
		 * @param		string		$tag			The shortcode tag.	
		 */
		$content	= apply_filters(
			sprintf( 
				'%1$s[shortcode][%2$s][content::after]',
				$this->prefix,
				$this->shortcode_tag
			),
		$content, $atts, $tag );

			
		// Display the shortcode.
		$output = $this->display( $atts, $content );

		/**
		 * Filter the shortcode output.
		 * 
		 * @hook		Filter hook name: theme_prefix[shortcode][shortcode_tag_name][output]
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @param		string		$output			The shortcode output.
		 * @param		array		$atts			The shortcode attributes.
		 * @param		string		$content		The shortcode content.
		 * @param		string		$tag			The shortcode tag.
		 */
		$output = apply_filters(
			sprintf( 
				'%1$s[shortcode][%2$s][output]',
				$this->prefix,
				$this->shortcode_tag
			),
		$output, $atts, $content, $tag );

		return $output;
	}

	/**
	 * Initializes the shortcode properties.
	 * Sets the shortcode wrapper ID and class.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @return 		void
	 */
	protected function initialize_shortcode_properties() {
		$this->wrapper_id		= ( ! empty( $this->shortcode_tag ) ) ? esc_attr( "{$this->shortcode_tag}--shortcode-wrapper--{$this->uniqid}" ) : '';
		$this->wrapper_class	= sprintf( 
			'%1$s%2$s%3$s%4$s',
			( ! empty( $this->shortcode_tag ) ) 	? ' ' . esc_attr( "{$this->shortcode_tag}--shortcode-wrapper" ) : '',
			( ! empty( $this->shortcode_class ) ) 	? ' ' . esc_attr( $this->shortcode_class ) : '',
			( ! empty( $this->identifier_class ) ) 	? ' ' . esc_attr( $this->identifier_class ) : '',
			"{$this->prefix}-shortcode",
		);
	}

	/**
	 * Initializes the shortcode registration.
	 * Adds the action to register the shortcode.
	 * Runs the hooks.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @return 		void
	 */
	protected function initialize_shortcode_registration() {

		/**
		 * Before register shortcode.
		 * 
		 * @hook		Action hook name: theme_prefix[shortcode][shortcode_tag_name][register_shortcode::before]
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @param		string		$wrapper_id		The shortcode wrapper ID.
		 * @param		string		$uniqid			The shortcode unique ID.
		 */
		do_action(
			sprintf( 
				'%1$s[shortcode][%2$s][register_shortcode::before]',
				$this->prefix,
				$this->shortcode_tag
			),
			$this->wrapper_id,
			$this->uniqid
		);
		$this->before_register_shortcode();

		/**
		 * Register the shortcode.
		 */
		add_shortcode( $this->shortcode_tag, [$this, 'register_shortcode'] );

		/**
		 * Add the action to register the shortcode.
		 */
		$this->hooks->add_action( 'init', $this, 'register_shortcode' );

		/**
		 * After register shortcode.
		 */
		$this->after_register_shortcode();

		/**
		 * After register shortcode.
		 * 
		 * @hook		Action hook name: theme_prefix[shortcode][shortcode_tag_name][register_shortcode::after]
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @param		string		$wrapper_id		The shortcode wrapper ID.
		 * @param		string		$uniqid			The shortcode unique ID.
		 */
		do_action(
			sprintf( 
				'%1$s[shortcode][%2$s][register_shortcode::after]',
				$this->prefix,
				$this->shortcode_tag
			),
			$this->wrapper_id,
			$this->uniqid
		);

		/**
		 * Run the hooks.
		 */
		$this->hooks->run();
	}

	/**
	 * Initializes the shortcode.
	 * Registers the shortcode.
	 * Adds the action to register the shortcode.
	 * Runs the hooks.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @return 		void
	 */
	protected function initialize_shortcode() {

		/**
		 * If the shortcode tag is empty, throw an exception.
		 */
		if ( empty( $this->shortcode_tag ) ) {
			throw new \Exception( 'Class Shortcodes: Requires "shortcode_tag" property is required' );
		}

		/**
		 * If the shortcode attributes are empty, throw an exception.
		 */
		if ( empty( $this->shortcode_atts ) ) {
			throw new \Exception( 'Class Shortcodes: Requires "shortcode_atts" property is required' );
		}

		/**
		 * Filter the shortcode whether it is enabled or not.
		 * 
		 * @hook		Filter hook name: theme_prefix[shortcode][shortcode_tag_name][enabled]
		 * @since		0.0.1
		 * @author		Jasper Jardin
		 * @created_at	2025-10-19
		 * @param		boolean		$is_enabled		Whether the shortcode is enabled or not.
		 */
		$is_enabled = apply_filters(
			sprintf( 
				'%1$s[shortcode][%2$s][enabled]',
				$this->prefix,
				$this->shortcode_tag
			),
			$this->config::get( "shortcodes.{$this->shortcode_tag}.enabled", true ) 
		);

		/**
		 * If the shortcode is not enabled, return.
		 */
		if ( true !== $is_enabled ) {
			return;
		}

		/**
		 * Set the shortcode unique ID.
		 */
		$this->uniqid = uniqid();
		
		/**
		 * Initialize the shortcode properties.
		 */
		$this->initialize_shortcode_properties();

		/**
		 * Initialize the shortcode registration.
		 */
		$this->initialize_shortcode_registration();
		
		return;
	}

	
	/**
	 * Test the shortcode. By default, it will echo the shortcode output.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return 		void
	 */
	public function test_shortcode() {
		echo do_shortcode( "[{$this->shortcode_tag}]" );

		return;
	}
}