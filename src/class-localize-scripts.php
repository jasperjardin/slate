<?php
/**
 * Holds all the JS localization scripts
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Localize_Scripts
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
 * Holds all the JS localization scripts
 *
 * This class defines all code necessary for JS localization scripts.
 */
final class Localize_Scripts extends Abstract_Core_Context {
	/**
	 * Controler property that decides whether an "AJAX Result" can be display in the browser DevTools console tab.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$ajax_console_result	Decides whether an "AJAX Result" can be display in the browser DevTools console tab.
	 */
	protected $ajax_console_result;

	/**
	 * The WP Localized Script Args.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array		$localized_args		The WP Localized Script Args
	 */
	protected $localized_args = [];

	/**
	 * Initialize the localization script methods
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function __construct() {
		parent::__construct();

		$this->ajax_console_result	= $this->config->get( 'ajax.console_result' );

		$this->localized_args	= array(
			'site_url'            => $this->config->get( 'theme.site_url' ),
			'ajax_url'            => admin_url( 'admin-ajax.php' ),
			'theme_url'           => $this->config->get( 'paths.templates.directory.uri' ),
			'ajax_console_result' => $this->can_ajax_console_result(),
			'loading'             => $this->get_loading_template(),
			'cookies' 			  => array(
				'sample_cookie' => array(
					'name'   => null,
					'value'  => null,
					'expire' => null,
				)
			),
			'user_info' => array(
				'is_user_logged_in' => array()
			),
			'nonces' => array(
				'ajax' => $this->config->get( 'security.nonces.ajax.value' ),
			),
			'theme_resources'	=> array(
				/**
				 * The abspath directory path to Assets folder.
				 */
				'assets_folder'			=> $this->config->get( 'paths.assets.uri' ),
				/**
				 * The abspath directory path for "Distributable Assets."
				 */
				'dist_folder'			=> $this->config->get( 'paths.dist.uri' ),
				/**
				 * The abspath directory path for "Distributable Library Assets."
				 */
				'dist_library_folder'	=> $this->config->get( 'paths.dist.library.uri' ),
				/**
				 * The abspath directory path for "Distributable WordPress Backend Assets."
				 */
				'backend_folder'		=> $this->config->get( 'paths.dist.backend.uri' ),
				/**
				 * The abspath directory path for "Distributable WordPress Frontend Assets."
				 */
				'frontend_folder'		=> $this->config->get( 'paths.dist.frontend.uri' ),
				/**
				 * The abspath directory path for "Image Assets."
				 */
				'images_folder'			=> $this->config->get( 'paths.assets.images.uri' ),
				/**
				 * The abspath directory path for "Raw 3rd-party Libraries Assets."
				 */
				'vendor_folder'			=> $this->config->get( 'paths.assets.vendor.uri' ),
			),
		);

		if ( is_user_logged_in() ) {
			$this->localized_args[ 'user_info' ][ 'is_user_logged_in' ][ 'id' ]	= get_current_user_id();

			if ( is_super_admin() ) {
				$this->localized_args[ 'user_info' ][ 'is_user_logged_in' ][ 'is_admin' ] = true;
			}
		}
	}

	/**
	 * Decides whether an "AJAX Result" can be display in the browser DevTools console tab.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		bool		$result		Retuns true, if the "$ajax_console_result" property is boolean and not empty. Otherwise, return false.
	 */
	public function can_ajax_console_result() {
		$result = false;

		if ( is_bool( $this->ajax_console_result ) && ! empty( $this->ajax_console_result ) ) {
			$result = true;
		}

		return $result;
	}

	/**
	 * Fetch the value of the "$localized_args" property.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$localized_args		Retuns the value of the "$localized_args" property.
	 */
	public function get_localized_scripts() {
		$prefix = $this->prefix;
		$localized_args = $this->localized_args;

		if ( ! is_array( $localized_args ) ) {
			$localized_args = [];
		}

		$localized_args = apply_filters( 
			sprintf( '%1$s[localized_scripts]', $prefix),
			$localized_args
		);

		return $localized_args;
	}

	/**
	 * Contains the loading markup.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		string		$output		Returns the loading markup.
	 */
	public function get_loading_template() {
		$prefix = $this->prefix;
		$output = '';

		$output .= '<div class=' . "{$prefix}-loading-overlay" . '>';
			$output .= '<div class="loading-table">';
				$output .= '<div class="loading-wrapper">';
					$output .= '<span class="loading"></span>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}