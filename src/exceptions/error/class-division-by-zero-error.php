<?php
/**
 * Custom division by zero error exceptions class
 *
 * @package     Slate
 * @subpackage	Slate/Src/Exceptions
 * @category	Slate/Src/Exceptions/Error
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-24
 */

namespace Slate\Src\Exceptions\Error;

use \DivisionByZeroError;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Custom division by zero error exceptions class
 *
 * Indicates attempting to divide a number by zero.
 */
final class Division_By_Zero_Error extends DivisionByZeroError {
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
	 * Constructor for division by zero error exception.
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
	 * Overwrite the "DivisionByZeroError" class "__toString" method.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @return		string		$error_details		The details of the error.
	 */
	public function __toString() {
		return '<strong>Division By Zero Error:</strong> ' . $this->error_details;
	}
}

