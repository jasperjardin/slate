<?php
/**
 * The file that defines the Init program class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Init
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src;

/**
 * The class responsible for loading the configuration array from the dedicated file.
 */
use \Slate\Src\Config as Config;

/**
 * This class defines all code necessary to execute during the program's activation.
 */
use \Slate\Src\Activator as Activator;

/**
 * This class defines all code necessary to execute during the program's deactivation.
 */
use \Slate\Src\Deactivator as Deactivator;

/**
 * The class responsible for orchestrating the actions and filters of the program.
 */
use \Slate\Src\Hooks as Hooks;

/**
 * The class responsible for defining helper methods of the program.
 */
// use \Slate\Src\Helper as Helper; // Not used in the theme.

/**
 * The class responsible for loading extender files that extends to Classes of other plugins, themes or WordPress itself.
 */
use \Slate\Src\Extender as Extender;

/**
 * The class responsible for defining internationalization functionality of the program.
 */
use \Slate\Src\Localization as Localization;

/**
 * The class responsible for defining Custom Post Types and Taxonomies of the program.
 */
use \Slate\Src\Post_Types as Post_Types;
/**
 * The class responsible for defining Custom Post Types and Taxonomies of the program.
 */
use \Slate\Src\Taxonomies as Taxonomies;

/**
 * The class responsible for defining WP Menu Manager: Metaboxes of the program.
 */
use \Slate\Src\Menu_Metaboxes as Menu_Metaboxes;

/**
 * The class responsible for defining metaboxes of the program.
 */
use \Slate\Src\Metaboxes as Metaboxes;

/**
 * The class responsible for defining ACF custom fields of the program.
 */
use \Slate\Src\Custom_Fields as Custom_Fields;

/**
 * The class responsible for defining shortcodes of the program.
 */
use \Slate\Src\Shortcodes as Shortcodes;

/**
 * The class responsible for defining WP Rest API of the program.
 */
use \Slate\Src\Rest_API as Rest_API;

/**
 * The class responsible for defining all PHP and AJAX actions that occur in the admin area.
 */
// use \Slate\Src\Admin\Init as Admin_Init;

/**
 * The class responsible for defining all PHP and AJAX actions that occur in the public-facing side of the program.
 */
// use \Slate\Src\Publics\Init as Public_Init;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * The program main initializer class.
 *
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 * Also maintains the unique identifier of this program as well as the current version of the program.
 */
final class Init {
	/**
	 * The responsible for maintaining and registering all hooks that power the program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			\Slate\Src\Hooks		$hooks		Maintains and registers all hooks for the program.
	 */
	protected $hooks;

	/**
	 * The unique identifier of this program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string			$program_name	The string used to uniquely identify this program.
	 */
	protected $program_name;

	/**
	 * The current version of the program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string			$version	The current version of the program.
	 */
	protected $version;

	/**
	 * Define the sequence of method executions of the program.
	 *
	 * Set the program name and the program version that can be used throughout the program.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function __construct() {

		$this->load_config();

		// Set the program name.
		$this->program_name = Config::get( 'theme.name' );

		// Set the program version.
		$this->version = Config::get( 'theme.version' );

		// Execute load_dependencies method.
		$this->load_dependencies();
	}

	/**
	 * Load the configuration array from the dedicated file.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	private function load_config() {
		// Load the Config class (assuming you have an autoloader or 'require' it).
		$loader_config = require_once get_stylesheet_directory() . '/config/loader.php';

		if ( is_array( $loader_config ) && ! empty( $loader_config ) ) {
			// Initialize the Config class.
			$config = new Config();

			foreach ( $loader_config as $config_file ) {
				$config->load( $config_file );
			}
		}
	}

	/**
	 * The code that runs during program activation.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function program_activate() {
		// Initialize the Activator class
		$proccess = new Activator();

		// Execute all processes during program activation.
		$proccess::activate();
	}

	/**
	 * The code that runs during program deactivation.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function program_deactivate() {
		// Initialize the Deactivator class
		$proccess = new Deactivator();

		// Execute all processes during program deactivation.
		$proccess::deactivate();
	}

	/**
	 * Load the required dependencies for this program.
	 *
	 * Include the following files that make up the program:
	 *
	 * - /Slate/Src/Hooks. Orchestrates the hooks of the program.
	 * - /Slate/Src/Localization. Defines internationalization functionality.
	 * - /Slate/Src/Admin. Defines all hooks for the admin area.
	 * - /Slate/Src/Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the hooks which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		private
	 * @return		void
	 */
	private function load_dependencies() {

		// Initialize the Hooks class
		$this->hooks = new Hooks();

		// Initialize the Post_Types class
		new Post_Types();

		// Initialize the Taxonomies class
		new Taxonomies();

		// Initialize the Extender class
		new Extender();

		// Initialize the Menu_Metaboxes class
		new Menu_Metaboxes();

		// Initialize the Metaboxes class
		new Metaboxes();

		// Initialize the Custom_Fields class
		new Custom_Fields();

		// Initialize the Shortcodes class
		new Shortcodes();

		// Initialize the Rest_API class
		new Rest_API();

		// Execute set_locale method.
		$this->set_locale();

		// // Execute define_admin_hooks method.
		// $this->define_admin_hooks();

		// // Execute define_public_hooks method.
		// $this->define_public_hooks();
	}

	/**
	 * Define the locale for this program for internationalization.
	 *
	 * Uses the Localization class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		private
	 * @return		void
	 */
	private function set_locale() {

		// Initialize the Localization class
		$lang = new Localization();

		// Hook the program text-domain to the after_setup_theme action hook.
		$this->hooks->add_action( 'after_setup_theme', $lang, 'load_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		private
	 * @return		void
	 */
	private function define_admin_hooks() {

		// Initialize the Admin_Init class
		$admin    = new Admin_Init( $this->get_program_name(), $this->get_version() );

		// Initialize the enqueue methods for CSS and JS
		$this->hooks->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
		$this->hooks->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );

		// Initialize the enqueue methods for AJAX
		$this->hooks->add_action(
			'init',
			$admin,
			'init_admin_ajax',
			1
		);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		private
	 * @return		void
	 */
	private function define_public_hooks() {

		// Initialize the Public_Init class
		$public = new Public_Init( $this->get_program_name(), $this->get_version() );

		// Initialize the enqueue methods for CSS and JS
		$this->hooks->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles' );
		$this->hooks->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts' );

		// Initialize the enqueue methods for AJAX
		$this->hooks->add_action(
			'init',
			$public,
			'init_ajax',
			1
		);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function run() {

		// Execute all process after theme was activated.
		$this->hooks->add_action( 'after_setup_theme', $this, 'program_activate' );

		// Execute all process after theme has switched.
		$this->hooks->add_action( 'after_switch_theme', $this, 'program_deactivate' );

		// Execute all the hooks registered to the Hooks class run() method.
		$this->hooks->run();
	}

	/**
	 * The name of the program used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		string    The name of the program.
	 */
	public function get_program_name() {
		// Returns the program name property.
		return $this->program_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		\Slate\Src\Hooks    Orchestrates the hooks of the program.
	 */
	public function get_hooks() {
		// Returns the hooks property.
		return $this->hooks;
	}

	/**
	 * Retrieve the version number of the program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access	  	public
	 * @return		string    The version number of the program.
	 */
	public function get_version() {
		// Returns the program version property.
		return $this->version;
	}
}
