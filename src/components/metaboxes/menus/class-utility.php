<?php
/**
 * Adds the "Utility Menu Metabox" inside WP Menu Manager.
 *
 * This class defines all code necessary to initialize the "Utility Menu Metabox".
 *
 * @package     Slate
 * @subpackage	Slate/Src/Components/Metaboxes/Menus
 * @category	Slate/Src/Components/Metaboxes/Menus/Utility
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-24
 */

namespace Slate\Src\Components\Metaboxes\Menus;

/**
 * The class responsible for loading the base context.
 */
use \Slate\Src\Abstracts\Core\Context as Abstract_Core_Context;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Executes the "Utility Menu Metabox".
 *
 * This class defines all code necessary to initialize the "Utility Menu Metabox".
 */
final class Utility extends Abstract_Core_Context {
	/**
	 * Executes the methods on initialization.
	 *
	 * Executes the menu metaboxes hooked in 'admin_head-nav-menus.php'.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @return		void
	 */
	public function __construct() {
		// Initialize the parent constructor.
		parent::__construct();

		// Initialize the hooks.
		$this->initialize_hooks();
	}

	/**
	 * Initializes the hooks.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @return		void
	 */
	private function initialize_hooks() {
		// Add the action to add the menu metaboxes.
		$this->hooks->add_action( 'admin_head-nav-menus.php', $this, 'add_nav_menu_meta_boxes' );

		// Add the filter to add the logout nonce to the menu items.
		$this->hooks->add_filter( 'wp_nav_menu_objects', $this, 'logout_nonce' );

		// Run the hooks.
		$this->hooks->run();
	}

	/**
	 * Registers the menu metaboxes.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @return		void
	 */
	public function add_nav_menu_meta_boxes() {
		add_meta_box(
			$this->prefix . '_actions_link',
			__( 'Utility Links', $this->lang ),
			[ $this, 'nav_menu_links' ],
			'nav-menus',
			'side',
			'low'
		);
	}

	/**
	 * Generate new nonce for logout menu items.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		array	$items		The menu items.
	 * @return		array				The modified menu items.
	 */
	public function logout_nonce( $items ) {
        if ( empty( $items ) ) {
			return $items;
		}

		// Loop through the menu items and add the logout nonce to the menu items.
		foreach ( $items as $item ) {
			if ( strpos( $item->url, 'wp-login.php?action=logout' ) !== false ) {
				$item->url = wp_logout_url() . '&_' . $this->prefix . '_action=logout';
			}
		}

		return $items;
	}

	/**
	 * Output menu links.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @return		void
	 */
	public function nav_menu_links() {
		$output = '';
		$prefix = $this->prefix;
		$lang 	= $this->lang;

		$wrapper_id			= $prefix . '-utility-links';
		$tabs_id			= $prefix . '-tabs-panel';
		$checklist_id		= $prefix . '-checklist';
		$submit_id			= 'submit-' . $wrapper_id;
		
		$select_all_enabled = false;
		$select_all_id  	= '';
		$select_all_url 	= '';

		if ( $select_all_enabled ) {
			$select_all_id  = $checklist_id . '-select-all';
			$select_all_url = admin_url( 'nav-menus.php?page-tab=all&selectall=1#' . $wrapper_id );
		}

		$actions = [
			[
				'title'   => 'Login',
				'url'     => wp_login_url(),
				'classes' => $prefix . '-login',
				'target'  => $prefix . '_login',
			],
			[
				'title'   => 'Logout',
				'url'     => wp_logout_url(),
				'classes' => $prefix . '-logout',
				'target'  => $prefix . '_logout',
			],
			[
				'title'   => 'Register',
				'url'     => wp_registration_url(),
				'classes' => $prefix . '-registration',
				'target'  => $prefix . '_registration',
			],
			[
				'title'   => 'Lost Password',
				'url'     => wp_lostpassword_url(),
				'classes' => $prefix . '-lost-password',
				'target'  => $prefix . '_lost_password',
			],
		];

		// Start output buffering.
		ob_start();

		$output .= '<div id="' . esc_attr( $wrapper_id ) . '" class="posttypediv">';
			$output .= '<div id="' . esc_attr( $tabs_id ) . '-" class="tabs-panel tabs-panel-active">';
				$output .= '<ul id="' . esc_attr( $checklist_id ) . '" class="categorychecklist form-no-clear">';

					$counter = -1;

					foreach ( $actions as $value ) :
						$title   = isset( $value['title'] ) ? $value['title'] : '';
						$desc    = isset( $value['desc'] ) ? $value['desc'] : '';
						$classes = isset( $value['classes'] ) ? $value['classes'] : '';
						$url 	 = isset( $value['url'] ) ? $value['url'] : '#';
						$target  = isset( $value['target'] ) ? $value['target'] : 'none';

						$output .= '<li>';

							$output .= '<label class="menu-item-title">';
								$output .= '<input type="checkbox" class="menu-item-checkbox" name="menu-item[' . esc_attr( $counter ) . '][menu-item-object-id]" value="' . esc_attr( $counter ) . '" /> ';
								$output .= esc_html( $title );

								if ( ! empty( $desc ) ) :
									$output .= '<span class="desc">(' . esc_html( $desc ) . ')</span>';
								endif;

							$output .= '</label>';

							$output .= '<input type="hidden" class="menu-item-type" name="menu-item[' . esc_attr( $counter ) . '][menu-item-type]" value="custom" />';

							$output .= '<input type="hidden" class="menu-item-title" name="menu-item[' . esc_attr( $counter ) . '][menu-item-title]" value="' . esc_html( $title ) . '" />';

							$output .= '<input type="hidden" class="menu-item-url" name="menu-item[' . esc_attr( $counter ) . '][menu-item-url]" value="' . esc_url( $url ) . '" />';

							$output .= '<input type="hidden" class="menu-item-target" name="menu-item[' . esc_attr( $counter ) . '][menu-item-target]" value="' . esc_attr( $target ) . '" />';

							$output .= '<input type="hidden" class="menu-item-classes" name="menu-item[' . esc_attr( $counter ) . '][menu-item-classes]" value="' . esc_html( $classes ) . '" />';
						$output .= '</li>';

						$counter--;

					endforeach;

				$output .= '</ul>';
			$output .= '</div>';

			$output .= '<p class="button-controls">';
				$output .= '<span class="list-controls">';

					if ( $select_all_enabled ) {
						$output .= '<a href="' . esc_url( $select_all_url ) . '" class="select-all">';
							$output .= esc_html__( 'Select all', $lang );
						$output .= '</a>';

						$output .= '<span class="list-controls hide-if-no-js">';
							$output .= '<input type="checkbox" id="' . esc_attr( $select_all_id ) . '" class="select-all">';
							$output .= '<label for="' . esc_attr( $select_all_id ) . '">' . esc_html__( 'Select All', $lang ) . '</label>';
						$output .= '</span>';
					}

				$output .= '</span>';

				$output .= '<span class="add-to-menu">';

					$output .= '<button type="submit" id="' . esc_attr( $submit_id ) . '" class="button-secondary submit-add-to-menu right" value="' . esc_attr__( 'Add to menu', $lang ) . '" name="add-post-type-menu-item">';
						$output .= esc_html__( 'Add to menu', $lang );
					$output .= '</button>';

					$output .= '<span class="spinner"></span>';

				$output .= '</span>';
			$output .= '</p>';
		$output .= '</div>';

		$output .= ob_get_clean();

		echo $output;
	}
}