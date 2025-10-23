<?php

/**
 * This class is executes the "Logos: Supported Payment Methods" shortcode.
 *
 * This class defines all code necessary to initialize the "Logos: Supported Payment Methods" shortcode.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Components/Shortcodes/Logos
 * @category    Slate/Src/Components/Shortcodes/Logos/Supported_Payment_Methods
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Shortcodes\Logos;

/**
 * The class responsible for loading the abstract core shortcodes class.
 */
use \Slate\Src\Abstracts\Core\Content\Parts\Shortcodes as Abstract_Core_Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * This class is executes the "Logos: Supported Payment Methods" shortcode.
 *
 * The shortcode displays the "Logos: Supported Payment Methods" shortcode.
 */
final class Supported_Payment_Methods extends Abstract_Core_Shortcodes {
	/**
	 * The property that holds the URI to the payment logo
	 * 
	 * @since    1.0.0
	 * 
	 * @access   private
	 * 
	 * @var 	 string 	$payment_logos
	 */
	private $payment_logos;	
	
	/**
	 * The property that holds the filepath to the payment logo
	 * 
	 * @since    1.0.0
	 * 
	 * @access   private
	 * 
	 * @var 	 string 	$payment_logos_filepath
	 */
	private $payment_logos_filepath;

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
		
		$this->shortcode_tag 	= "{$this->prefix}_supported_payment_method_logos";
		$this->shortcode_class	= "{$this->prefix}-supported-payment-method-logos";

		$this->shortcode_atts = array(
			'show_title'	=> false,
			'set_title'		=> 'We Accept',
			'set_alt_text'	=> 'We Support These Payment Methods',
		);
		
		/**
		 * Initialize the shortcode.
		 */
		$this->initialize_shortcode();
	}

	/**
	 * Structure for the shortcode markup.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @return		string		$output		Returns the HTML markup
	 */
	public function display( $atts, $content = null ) {
		$output 		= '';
		$content_markup	= '';
		extract( $atts );


		// Check if {$show_title} value exists in the allowed values. If yes, then set as (bool) true.
		$show_title = ( 
			in_array( 
				$show_title, 
				[ 'on', 'yes', 'true' ] 
			) || 
			( 
				is_string( $show_title ) && empty( $show_title ) 
			) 
		) ? true : false;

		
		// Check if {$set_alt_text} is empty and set the default value.
		$set_alt_text = ( is_string( $set_alt_text ) && ! empty( $set_alt_text ) ) ? $set_alt_text : __( 'We Support These Payment Methods', $this->lang );


		/**
		 * START: Setup the Title markup
		 */
			if ( $show_title ) {
				$content_markup .= '<h4 class="title">';
					$content_markup .= esc_html( $set_title );
				$content_markup .= '</h4>';
			}
		/**
		 * END: Setup the Title markup
		 */



		/**
		 * START: Setup the Payment Logo markup
		 */
			if ( 
				file_exists( $this->payment_logos_filepath ) &&
				is_string( $this->payment_logos ) && 
				! empty( $this->payment_logos ) 
			) {
				$content_markup .= '<div class="logos">';
					$content_markup .= '<img class="payment_logos" src="' . esc_url( $this->payment_logos ) . '" alt="' . esc_attr( $set_alt_text ) . '"/>';
				$content_markup .= '</div>';
			}
		/**
		 * END: Setup the Payment Logo markup
		 */



		 // Terminate: If {$content_markup} is not string or is empty.
		if ( empty( $content_markup ) || ! is_string( $content_markup ) ) return $output;



		/**
		 * START: Setup Element Attribute
		 */
			/********************** START: Wrapper Attributes **********************/
			$wrapper_attr_args	= [
				'id'				=> ( ! empty( $this->wrapper_id ) && is_string( $this->wrapper_id ) ) ? esc_attr( $this->wrapper_id ) : $this->wrapper_id,
				'data-uniqueID'		=> $this->wrapper_id,
				'class'				=> sprintf( 
					'%1$s%2$s',
					( ! empty( $this->wrapper_class ) ) ? esc_attr( $this->wrapper_class ) : '',
					'',
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
			$output .= '<div ' . obf_sanity_check( $wrapper_attr ) . '>';
				$output .= '<div class="inner-wrap">';
					$output .= '<div class="inner-row">';
						$output .= obf_sanity_check( $content_markup );
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		/**
		 * END: Setup the shortcode structure
		 */
			
		return $output;
	}
}