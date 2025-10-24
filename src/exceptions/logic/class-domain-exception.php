<?php
/**
 * Custom domain exceptions class
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

use \DomainException;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Custom domain exceptions class
 *
 * Indicates a value is outside the legal domain of values defined by a method.
 */
final class Domain_Exception extends DomainException {
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
	 * Constructor for domain exception.
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
	 * Overwrite the "DomainException" class "__toString" method.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @return		string		$error_details		The details of the error.
	 */
	public function __toString() {
		return '<strong>Domain Exception:</strong> ' . $this->error_details;
	}
}

