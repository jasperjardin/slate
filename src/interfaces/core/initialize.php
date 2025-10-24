<?php
/**
 * The "Slate/Src/Interfaces/Core/Initialize" interface handles the method signatures dedicated for the "Slate/Src/Initialize" class.
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Config
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Interfaces\Core;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * The "Slate/Src/Interfaces/Core/Initialize" interface handles the method signatures dedicated for the "Slate/Src/Initialize" class.
 */
interface Initialize {	
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
	public function __construct();

	/**
	 * The code that runs during program activation.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function program_activate() : void;

	/**
	 * The code that runs during program deactivation.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function program_deactivate() : void;

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function run() : void;

	/**
	 * The name of the program used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		string		$program_name	The string used to uniquely identify this program.
	 */
	public function get_program_name() : string;

	/**
	 * Get the array of action & filter hooks registered with WordPress.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$hooks			The array of action & filter hooks registered with WordPress.
	 */
	public function get_hooks() : array;

	/**
	 * Retrieve the version number of the program.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access	  	public
	 * @return		string    $version			The version number of the program.
	 */
	public function get_version() : string;
}