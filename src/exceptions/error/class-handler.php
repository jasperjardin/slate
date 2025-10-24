<?php
/**
 * Custom error exceptions class
 *
 * @package     Slate
 * @subpackage	Slate/Src/Exceptions
 * @category	Slate/Src/Exceptions/Error
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Exceptions\Error;

use \Exception;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Custom error exceptions class
 */
final class Handler extends Exception {
	/**
	 * The details of the error.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		protected
	 * @var			string		$details		The details of the error.
	 */
	protected $error_details;

	public function __construct( $details ) {

		$this->error_details = $details;

		parent::__construct();
	}
  
	/**
	 * Overwrite the "Exception" class "__toString" method.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		string		$error_details		The details of the error.
	 */
	public function __toString() {
		return '<strong>Notice Error:</strong> ' . $this->error_details;
	}
}