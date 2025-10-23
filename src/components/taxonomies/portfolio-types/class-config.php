<?php
/**
 * The class that handles the configuration for the "Portfolio Type" taxonomy.
 *
 * This class defines all code necessary to initialize the "Taxonomy: Portfolio Type."
 *
 * @package     Slate
 * @subpackage  Slate/Src/Components/Taxonomies/Portfolio
 * @category    Slate/Src/Components/Taxonomies/Portfolio/Portfolio_Types
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Taxonomies\Portfolio_Types;

/**
 * Abstract "Taxonomies" content-type base.
 * Provides common properties and methods for registering custom taxonomies.
 */
use \Slate\Src\Abstracts\Core\Content\Types\Taxonomies as Abstract_Core_Content_Types_Taxonomies;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * The class that handles the configuration for the "Portfolio Type" taxonomy.
 *
 * This class defines all code necessary to initialize the "Taxonomy: Portfolio Type."
 */
final class Config extends Abstract_Core_Content_Types_Taxonomies {
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
		/*
		 * Set the post type.
		 */
		$this->taxonomy	= 'portfolio_type';

		/*
		 * Initialize the parent class.
		 */
		parent::__construct();
	}
}