<?php

/**
 * This class is generate the "Lightbox: Trigger" shortcode.
 *
 * This class defines all code necessary to generate the "Lightbox: Trigger" shortcode.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Components/Shortcodes/Lightbox
 * @category    Slate/Src/Components/Shortcodes/Lightbox/Trigger
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Shortcodes\Lightbox;

/**
 * The class responsible for loading the abstract core shortcodes class.
 */
use \Slate\Src\Abstracts\Core\Content\Parts\Shortcodes as Abstract_Core_Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * This class is generate the "Lightbox: Trigger" shortcode.
 *
 * The shortcode displays the "Lightbox: Trigger" shortcode.
 */
final class Trigger extends Abstract_Core_Shortcodes {
	/**
	 * The property that holds the list of supported lightbox trigger value
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array 		$target_types		The property that holds the list of supported lightbox trigger values.
	 */
	protected $target_types;	

	/**
	 * Define the core functionality of the shortcode.
	 *
	 * Registers the shortcode and hooks the Class methods for this shortcode.
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

		$this->shortcode_tag 	= "{$this->prefix}-lightbox-trigger";
		$this->shortcode_class	= "{$this->prefix}-lightbox-trigger";

		$this->target_types = array(
			'booking_trips'		=> 'product_booking_lightbox',
			'booking_enquiry'	=> 'product_enquiry_lightbox',
		);

		$this->shortcode_atts = array(
			'type'			=> '', // primary, secondary, tertiary
			'text'			=> '',
			'class_attr'	=> '',
		);


		/**
		 * Initialize the shortcode.
		 */
		$this->initialize_shortcode();
	}

	/**
	 * Displays the shortcode.
	 *
	 * @since    1.0.0
	 * 
	 * @access   public
	 * 
	 * @return   string		$output		Returns the HTML markup
	 */
	public function display( $atts, $content = null ) {
		$output 		= '';
		$data_target	= '';

		extract( $atts );

		// Return if the $type value is not valid.
		if ( empty( $type ) || ! is_string( $type ) ) return $output;

		// Return if the $text value is not valid.
		if ( empty( $text ) || ! is_string( $text ) ) return $output;
		

		$data_target	= ( isset( $this->target_types[ $type ] ) ) ? '#' . $this->target_types[ $type ] : '';


		/**
		 * START: Setup Element Attribute
		 */
			/********************** START: Wrapper Attributes **********************/
			$wrapper_attr_args	= [
				'id'				=> ( ! empty( $this->wrapper_id ) && is_string( $this->wrapper_id ) ) ? esc_attr( $this->wrapper_id ) : $this->wrapper_id,
				'data-uniqueID'		=> $this->wrapper_id,
				'data-target'		=> $data_target,
				'class'				=> sprintf( 
					'obf__lightbox--open %1$s%2$s%3$s',
					( ! empty( $this->wrapper_class ) ) ? esc_attr( $this->wrapper_class ) : '',
					( ! empty( $type ) && is_string( $type ) ) ? ' ' . $type : '',
					( ! empty( $class_attr ) && is_string( $class_attr ) ) ? ' ' . $class_attr : '',
				),
			];
			$wrapper_attr		= obf_attributes_renderer( $wrapper_attr_args, true, true );
			/********************** END: Wrapper Attributes **********************/
		/**
		 * END: Setup Wrapper Attribute
		 */



		/**
		 * START: Setup the shortcode structure
		 */
			$output .= '<span ' . obf_sanity_check( $wrapper_attr ) . '>';
				$output .= esc_html( $text );
			$output .= '</span>';
		/**
		 * END: Setup the shortcode structure
		 */
			
		return $output;
	}
}