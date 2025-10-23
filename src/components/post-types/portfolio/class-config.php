<?php
/**
 * The class that handles the configuration for the "Portfolio" post-type.
 *
 * This class defines all code necessary to initialize the "Post-Type: Portfolio."
 *
 * @package     Slate
 * @subpackage  Slate/Src/Components/Post_Types/Portfolio
 * @category    Slate/Src/Components/Post_Types/Portfolio/Config
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Post_Types\Portfolio;

/**
 * Abstract "Post Types" content-type base.
 * Provides common properties and methods for registering custom post types.
 */
use \Slate\Src\Abstracts\Core\Content\Types\Post_Types as Abstract_Core_Content_Types_Post_Types;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * The class that handles the configuration for the "Portfolio" post-type.
 *
 * This class defines all code necessary to initialize the "Post-Type: Portfolio."
 */
final class Config extends Abstract_Core_Content_Types_Post_Types {
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
		$this->post_type	= 'portfolio';

		/*
		 * Initialize the parent class.
		 */
		parent::__construct();
	}
}