<?php
/**
 * This class loads all the WP Menu Metaboxes.
 *
 * This class loads all WP Menu Metaboxes of the program.
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Menu_Metaboxes
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src;

/**
 * The class responsible for loading the component loader class.
 */
use \Slate\Src\Abstracts\Component_Loader as Component_Loader;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * This class loads all the WP Menu Metaboxes.
 *
 * This class loads all WP Menu Metaboxes of the program.
 */
final class Menu_Metaboxes extends Component_Loader {
	/**
	 * The component directory name to load.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string			$component_directory_name		Component directory name to load.
	 */
	protected $component_directory_name = 'menu-metaboxes';

	/**
	 * The filter key used in deprecated loader, e.g. 'custom_fields'.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string			$filter_key		The filter key used in deprecated loader, e.g. 'custom_fields'.
	 */
	protected $filter_key = 'menu_metaboxes';

	/**
	 * The ignored files used in deprecated loader, e.g. 'sample.php'.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			array			$ignored_files		The ignored files used in deprecated loader, e.g. 'sample.php'.
	 */
	protected $ignored_files = array( 'sample.php' );

	/**
	 * Gate for conditional loading. Subclasses can override.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @return		bool
	 */
	protected function should_load() {
		return true;
	}
}