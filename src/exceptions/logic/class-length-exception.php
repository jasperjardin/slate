<?php
/**
 * Custom length exceptions class
 *
 * @package     Slate
 * @subpackage	Slate/Src/Exceptions
 * @category	Slate/Src/Exceptions/Logic
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-24
 */

namespace Slate\Src\Exceptions\Logic;

use \LengthException;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Custom length exceptions class
 *
 * Indicates length (e.g., of a string or array) is invalid.
 */
final class Length_Exception extends LengthException {
	/**
	 * The details of the error.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		protected
	 * @var			string		$error_details		The details of the error.
	 */
	protected $error_details;

	/**
	 * Constructor for length exception.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 */
	public function __construct( $details ) {

		$this->error_details = $details;

		parent::__construct();
	}
  
	/**
	 * Overwrite the "LengthException" class "__toString" method.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @return		string		$error_details		The details of the error.
	 */
	public function __toString() {
		return '<strong>Length Exception:</strong> ' . $this->error_details;
	}
}

