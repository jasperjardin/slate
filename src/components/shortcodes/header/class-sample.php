<?php

/**
 * This class is executes the Sample "Header" shortcode.
 *
 * This class defines all code necessary to initialize the Sample Header shortcode.
 *
 * @package     Slate
 * @subpackage  Slate/Src/Components/Shortcodes/Header
 * @category    Slate/Src/Components/Shortcodes/Header/Sample
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Shortcodes\Header;

/**
 * The class responsible for loading the abstract core shortcodes class.
 */
use \Slate\Src\Abstracts\Core\Content\Parts\Shortcodes as Abstract_Core_Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * This class is executes the Sample "Header" shortcode.
 *
 * This class defines all code necessary to initialize the Sample Header shortcode.
 */
final class Sample extends Abstract_Core_Shortcodes {
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
		
		$this->shortcode_tag 	= "{$this->prefix}_sample";
		$this->shortcode_class	= "{$this->prefix}-sample";
		$this->identifier_class = "{$this->prefix}-sample";

		$this->shortcode_atts = array(
			'show_title'		=> false,
			'show_on_mobile'	=> false,
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
		$output = '';
		extract( $atts );

		ob_start();

			$output .= '<div class="' . esc_attr( $this->wrapper_class ) .'">';
				$output .= '<div class="inner-wrap">';
					$output .= '<div class="inner-row">';

					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

		$output .= ob_get_clean();
			
		return $output;
	}

}