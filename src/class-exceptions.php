<?php
/**
 * This class is executes all the program exceptions.
 *
 * This class defines all code necessary to initialize the exceptions of the program.
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Exceptions
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src;

/**
 * Error Branch Exception Classes
 */
use \Slate\Src\Exceptions\Error\Type_Error as Type_Error;
use \Slate\Src\Exceptions\Error\Argument_Count_Error as Argument_Count_Error;
use \Slate\Src\Exceptions\Error\Parse_Error as Parse_Error;
use \Slate\Src\Exceptions\Error\Arithmetic_Error as Arithmetic_Error;
use \Slate\Src\Exceptions\Error\Division_By_Zero_Error as Division_By_Zero_Error;
use \Slate\Src\Exceptions\Error\Assertion_Error as Assertion_Error;

/**
 * Logic Branch Exception Classes
 */
use \Slate\Src\Exceptions\Logic\Invalid_Argument_Exception as Invalid_Argument_Exception;
use \Slate\Src\Exceptions\Logic\Bad_Method_Call_Exception as Bad_Method_Call_Exception;
use \Slate\Src\Exceptions\Logic\Bad_Function_Call_Exception as Bad_Function_Call_Exception;
use \Slate\Src\Exceptions\Logic\Domain_Exception as Domain_Exception;
use \Slate\Src\Exceptions\Logic\Length_Exception as Length_Exception;
use \Slate\Src\Exceptions\Logic\Out_Of_Range_Exception as Out_Of_Range_Exception;

/**
 * Runtime Branch Exception Classes
 */
use \Slate\Src\Exceptions\Runtime\Out_Of_Bounds_Exception as Out_Of_Bounds_Exception;
use \Slate\Src\Exceptions\Runtime\Overflow_Exception as Overflow_Exception;
use \Slate\Src\Exceptions\Runtime\Underflow_Exception as Underflow_Exception;
use \Slate\Src\Exceptions\Runtime\Unexpected_Value_Exception as Unexpected_Value_Exception;
use \Slate\Src\Exceptions\Runtime\Range_Exception as Range_Exception;

/**
 * Other Common Exception Classes
 */
use \Slate\Src\Exceptions\Other\Error_Exception as Error_Exception;
use \Slate\Src\Exceptions\Other\Json_Exception as Json_Exception;
use \Slate\Src\Exceptions\Other\Pdo_Exception as Pdo_Exception;
use \Slate\Src\Exceptions\Other\Reflection_Exception as Reflection_Exception;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * This class is executes all the program exceptions.
 * 
 * This class defines all code necessary to initialize the exceptions of the program.
 */
final class Exceptions {
	/**
	 * Error Branch Exception: Type Error
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Error\Type_Error		$type_error		Type error exception instance.
	 */
	private $type_error;

	/**
	 * Error Branch Exception: Argument Count Error
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Error\Argument_Count_Error		$argument_count_error		Argument count error exception instance.
	 */
	private $argument_count_error;

	/**
	 * Error Branch Exception: Parse Error
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Error\Parse_Error		$parse_error		Parse error exception instance.
	 */
	private $parse_error;

	/**
	 * Error Branch Exception: Arithmetic Error
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Error\Arithmetic_Error		$arithmetic_error		Arithmetic error exception instance.
	 */
	private $arithmetic_error;

	/**
	 * Error Branch Exception: Division By Zero Error
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Error\Division_By_Zero_Error		$division_by_zero_error		Division by zero error exception instance.
	 */
	private $division_by_zero_error;

	/**
	 * Error Branch Exception: Assertion Error
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Error\Assertion_Error		$assertion_error		Assertion error exception instance.
	 */
	private $assertion_error;

	/**
	 * Logic Branch Exception: Invalid Argument Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Logic\Invalid_Argument_Exception		$invalid_argument_exception		Invalid argument exception instance.
	 */
	private $invalid_argument_exception;

	/**
	 * Logic Branch Exception: Bad Method Call Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Logic\Bad_Method_Call_Exception		$bad_method_call_exception		Bad method call exception instance.
	 */
	private $bad_method_call_exception;

	/**
	 * Logic Branch Exception: Bad Function Call Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Logic\Bad_Function_Call_Exception		$bad_function_call_exception		Bad function call exception instance.
	 */
	private $bad_function_call_exception;

	/**
	 * Logic Branch Exception: Domain Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Logic\Domain_Exception		$domain_exception		Domain exception instance.
	 */
	private $domain_exception;

	/**
	 * Logic Branch Exception: Length Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Logic\Length_Exception		$length_exception		Length exception instance.
	 */
	private $length_exception;

	/**
	 * Logic Branch Exception: Out Of Range Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Logic\Out_Of_Range_Exception		$out_of_range_exception		Out of range exception instance.
	 */
	private $out_of_range_exception;

	/**
	 * Runtime Branch Exception: Out Of Bounds Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Runtime\Out_Of_Bounds_Exception		$out_of_bounds_exception		Out of bounds exception instance.
	 */
	private $out_of_bounds_exception;

	/**
	 * Runtime Branch Exception: Overflow Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Runtime\Overflow_Exception		$overflow_exception		Overflow exception instance.
	 */
	private $overflow_exception;

	/**
	 * Runtime Branch Exception: Underflow Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Runtime\Underflow_Exception		$underflow_exception		Underflow exception instance.
	 */
	private $underflow_exception;

	/**
	 * Runtime Branch Exception: Unexpected Value Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Runtime\Unexpected_Value_Exception		$unexpected_value_exception		Unexpected value exception instance.
	 */
	private $unexpected_value_exception;

	/**
	 * Runtime Branch Exception: Range Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Runtime\Range_Exception		$range_exception		Range exception instance.
	 */
	private $range_exception;

	/**
	 * Other Common Exception: Error Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Other\Error_Exception		$error_exception		Error exception instance.
	 */
	private $error_exception;

	/**
	 * Other Common Exception: JSON Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Other\Json_Exception		$json_exception		JSON exception instance.
	 */
	private $json_exception;

	/**
	 * Other Common Exception: PDO Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Other\Pdo_Exception		$pdo_exception		PDO exception instance.
	 */
	private $pdo_exception;

	/**
	 * Other Common Exception: Reflection Exception
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @var			\Slate\Src\Exceptions\Other\Reflection_Exception		$reflection_exception		Reflection exception instance.
	 */
	private $reflection_exception;

	/**
	 * Initialize the exception classes.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @return		void
	 */
	public function __construct() {
		$this->initialize_exceptions();
	}

	/**
	 * Initialize all exception class instances.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		private
	 * @return		void
	 */
	private function initialize_exceptions() {
		// Note: Exception classes are not instantiated here as they are meant to be thrown when needed.
		// The private properties will hold instances only when exceptions are caught and stored.
		// This method can be used to set up any exception handling configurations if needed.
	}

	/**
	 * Get Type Error exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Error\Type_Error
	 */
	public function get_type_error( $details ) {
		return new Type_Error( $details );
	}

	/**
	 * Get Argument Count Error exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Error\Argument_Count_Error
	 */
	public function get_argument_count_error( $details ) {
		return new Argument_Count_Error( $details );
	}

	/**
	 * Get Parse Error exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Error\Parse_Error
	 */
	public function get_parse_error( $details ) {
		return new Parse_Error( $details );
	}

	/**
	 * Get Arithmetic Error exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Error\Arithmetic_Error
	 */
	public function get_arithmetic_error( $details ) {
		return new Arithmetic_Error( $details );
	}

	/**
	 * Get Division By Zero Error exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Error\Division_By_Zero_Error
	 */
	public function get_division_by_zero_error( $details ) {
		return new Division_By_Zero_Error( $details );
	}

	/**
	 * Get Assertion Error exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Error\Assertion_Error
	 */
	public function get_assertion_error( $details ) {
		return new Assertion_Error( $details );
	}

	/**
	 * Get Invalid Argument Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Logic\Invalid_Argument_Exception
	 */
	public function get_invalid_argument_exception( $details ) {
		return new Invalid_Argument_Exception( $details );
	}

	/**
	 * Get Bad Method Call Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Logic\Bad_Method_Call_Exception
	 */
	public function get_bad_method_call_exception( $details ) {
		return new Bad_Method_Call_Exception( $details );
	}

	/**
	 * Get Bad Function Call Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Logic\Bad_Function_Call_Exception
	 */
	public function get_bad_function_call_exception( $details ) {
		return new Bad_Function_Call_Exception( $details );
	}

	/**
	 * Get Domain Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Logic\Domain_Exception
	 */
	public function get_domain_exception( $details ) {
		return new Domain_Exception( $details );
	}

	/**
	 * Get Length Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Logic\Length_Exception
	 */
	public function get_length_exception( $details ) {
		return new Length_Exception( $details );
	}

	/**
	 * Get Out Of Range Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Logic\Out_Of_Range_Exception
	 */
	public function get_out_of_range_exception( $details ) {
		return new Out_Of_Range_Exception( $details );
	}

	/**
	 * Get Out Of Bounds Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Runtime\Out_Of_Bounds_Exception
	 */
	public function get_out_of_bounds_exception( $details ) {
		return new Out_Of_Bounds_Exception( $details );
	}

	/**
	 * Get Overflow Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Runtime\Overflow_Exception
	 */
	public function get_overflow_exception( $details ) {
		return new Overflow_Exception( $details );
	}

	/**
	 * Get Underflow Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Runtime\Underflow_Exception
	 */
	public function get_underflow_exception( $details ) {
		return new Underflow_Exception( $details );
	}

	/**
	 * Get Unexpected Value Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Runtime\Unexpected_Value_Exception
	 */
	public function get_unexpected_value_exception( $details ) {
		return new Unexpected_Value_Exception( $details );
	}

	/**
	 * Get Range Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Runtime\Range_Exception
	 */
	public function get_range_exception( $details ) {
		return new Range_Exception( $details );
	}

	/**
	 * Get Error Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Other\Error_Exception
	 */
	public function get_error_exception( $details ) {
		return new Error_Exception( $details );
	}

	/**
	 * Get JSON Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Other\Json_Exception
	 */
	public function get_json_exception( $details ) {
		return new Json_Exception( $details );
	}

	/**
	 * Get PDO Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Other\Pdo_Exception
	 */
	public function get_pdo_exception( $details ) {
		return new Pdo_Exception( $details );
	}

	/**
	 * Get Reflection Exception instance.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$details		The details of the error.
	 * @return		\Slate\Src\Exceptions\Other\Reflection_Exception
	 */
	public function get_reflection_exception( $details ) {
		return new Reflection_Exception( $details );
	}

	/**
	 * Execute and throw an exception.
	 *
	 * This method allows you to call any exception method and throw it immediately.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-24
	 * @access		public
	 * @param		string		$exception_type		The type of exception to throw (e.g., 'type_error', 'invalid_argument_exception').
	 * @param		string		$details			The details of the error.
	 * @return		void
	 * @throws		\Exception						Throws the specified exception type.
	 */
	public function throw_exception( $exception_type, $details ) {
		$method_name = 'get_' . $exception_type;

		if ( method_exists( $this, $method_name ) ) {
			throw $this->$method_name( $details );
		} else {
			throw new \Exception( 'Unknown exception type: ' . $exception_type );
		}
	}
}
