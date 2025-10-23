<?php
/**
 * Define the helper functionalities.
 *
 * @package     Slate
 * @subpackage  Slate/Src
 * @category    Slate/Src/Helper
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

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
  * Define the helper functionalities.
 *
 * This class defines all code necessary template tags or helpers for the program.
 */
final class Helper {
	/**
	 * Fetch global $wp_post_types variable.
	 *
	 * @link   		https://developer.wordpress.org/reference/classes/wp_post_type/
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function wp_post_types() {
		global $wp_post_types;

		return $wp_post_types;
	}

	/**
	 * This method verify if nonce is valid.
	 *
	 * @param mixed $nonce the name of a metabox nonce.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		boolean		true Returns true if nonce is valid.
	 */
	public function is_nonce_valid( $nonce, $nonce_name = '', $ajax = false ) {
		if ( ! $ajax ) {
			if ( empty( $nonce_name ) ) {
				$nonce_name = basename(__FILE__);
			}

			if ( !isset( $nonce ) || !wp_verify_nonce( $nonce, $nonce_name ) ) {
				return;
			}
			return true;
		}
		
	}

	/**
	 * Use to fetch files inside a directory.
	 *
	 * @link   https://codex.wordpress.org/Class_Reference/WP_Query
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		object		$query
	 */
	public function get_wp_query( $args = array() ) {

		$default_args = array(
			'post_type'			=> '',
			'posts_per_page'	=> -1,
			'order'				=> 'ASC',
			'orderby'			=> 'name',
		);

		$merged_args = array_merge( $default_args, $args );

		$query = new \WP_Query( $merged_args );

		return $query;
	}
	
	/**
	 * Use to fetch files inside a directory.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$fieldlist
	 */
	public function get_dir_files( $directory = '' ) {
		 if ( ! empty( $directory ) ) {
			 $filelist = array();

			 if ( is_dir( $directory ) ) {
				 if ( $dh = opendir( $directory ) ) {
					 while ( false !== ( $file = readdir( $dh ) ) ) {
						 if ( !is_dir( $file ) ) {
							 $filelist[] = $file;
						 }
					 }
					 closedir($dh);
				 }
			 }
			 return $filelist;
		 }
		 return;
	}

	/**
	 * Use to track loaded files and categorized them.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function track_loaded_files( $filepath = '', $type = '' ) {
		global $obf_files_loaded;

		if (
			! empty( $filepath ) &&
			! empty( $type ) &&
			Config::get( 'dump.loaded_files' )
		) {
			$total_loaded_files = 0;

			if ( 
				isset( $obf_files_loaded[$type][ 'total_loaded_files' ]  ) && 
				0 !== $obf_files_loaded[$type][ 'total_loaded_files' ]  
			) {
				$total_loaded_files = $obf_files_loaded[$type][ 'total_loaded_files' ] + 1;
			} else {
				$total_loaded_files = 1;
			}

			$obf_files_loaded[$type][ 'files' ][] 		   = $filepath;
			$obf_files_loaded[$type][ 'total_loaded_files' ] = $total_loaded_files;
			$obf_files_loaded[$type][ 'debug_backtrace' ][]  = debug_backtrace();
		}
	}

	/**
	 * User Role Helper Method: Get the user's user-role based on user ID.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		mixed		Returns $user (object), array, $user->role (string).
	 */
	public function get_user_roles_by_user_id( $user_id ) {
		$user = get_userdata( $user_id );
		
		return empty( $user ) ? array() : $user->roles;
	}
	
	/**
	 * User Role Helper Method: Checks if user has user-role based on user ID.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function user_has_role_by_user_id( $user_id, $role ) {
	
		$user_roles = $this->get_user_roles_by_user_id( $user_id );
	
		if( is_array( $role ) ){
			return array_intersect( $role, $user_roles ) ? true : false;
		}
	
		return in_array( $role, $user_roles );
	}

	/**
	 * User Role Helper Method: Gets the current user user-role.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function current_user_has_role( $role ){
		return $this->user_has_role_by_user_id( get_current_user_id(), $role );
	}
	
	/**
	 * User Role Helper Method: Checks if user is admin.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function is_user_admin() {
		$user = wp_get_current_user();
		$allowed_roles = array(
			'administrator',
		);
		
		if ( array_intersect( $allowed_roles, $user->roles ) ) {
		   return true;
		}
	
		return false;
	}

	/**
	 * User Role Helper Method: Checks if user is editor.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function is_user_editor() {
		$user = wp_get_current_user();
		$allowed_roles = array(
			'editor',
		);
		
		if ( array_intersect( $allowed_roles, $user->roles ) ) {
		   return true;
		}
	
		return false;
	}

	/**
	 * User Role Helper Method: Checks if user is author.
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function is_user_author() {
		$user = wp_get_current_user();
		$allowed_roles = array(
			'author',
		);
		
		if ( array_intersect( $allowed_roles, $user->roles ) ) {
		   return true;
		}
	
		return false;
	}


	/**
	 * This function filters the sub-array of an array. 
	 * Through the sub-arrays key and value.
	 *
	 * @param 		array  			$delimiters		The list of delimiters to match.
	 * @param 		string 			$text      		The text to process.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		void
	 */
	public function multi_explode( $delimiters, $text ) {
		$collection = [];

		if (
			! is_array( $delimiters ) && empty( $delimiters ) &&
			! is_string( $delimiters ) && empty( $text )
		) {
			return $collection;
		}

		if ( isset( $delimiters[ 0 ] ) ) {
			$replaced = str_replace( $delimiters, $delimiters[ 0 ], $text );
	
			$collection = explode( $delimiters[ 0 ], $replaced );
		}

		return $collection;
	}

	/**
	 * Array Helper Method: Checks if an array is multidimentional or not.
	 *
	 * @param	 	array 			$array 		The value to check.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		bool						Returns true if array is multidimentional. Otherwise, returns false.
	 */
	public function is_array_multidimentional( $array = array() ) {
		$filter = array_filter( $array, 'is_array' );
	
		if ( count( $filter ) > 0 ) {
			return true;
		}
	
		return false;
	}

	/**
	 * Array Helper Method: Get array keys by prefix.
	 *
	 * @param	 	array 		$target_array	The array to search.
	 * @param	 	string 		$prefix			The search key.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$filter_array	The filtered array
	 */
	public function get_array_keys_by_prefix( $target_array = array(), $prefix = '' ) {
		$filter_array = array();
	
		if (
			! empty( $target_array ) &&
			! empty( $prefix )
		) {
			$filter_array = array_filter(
				$target_array, 
				function( $key ) use ( $prefix ) {
					return strpos( $key, $prefix ) === 0;
				}, 
				ARRAY_FILTER_USE_KEY
			);
		}
	
		return $filter_array;
	}

	/**
	 * Array Helper Method: This function filters the sub-array of an array. 
	 *						Through the sub-arrays key and value.
	 *
	 * @param	 	array 		$collection		The array to filter.
	 * 
	 * @param	 	string 		$prop_key		The field to search.
	 * 
	 * @param	 	string 		$prop_val		The keyword to search.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		mixed						Returns $filtered_collection parameters did not match the requirements.
	 * 											Returns the filtered array. Otherwise, returns true if prop and key exists. 
	 */
	public function filter_inner_array( $collection = array(), $prop_key = '', $prop_val = '' ) {    
		$filtered_collection = array();
	
		if ( 
			! is_array( $collection ) &&
			! empty( $prop_key ) &&
			! empty( $prop_val )
		) {
			return $filtered_collection;
		}
	
		$args = array(
			'prop_key' => $prop_key,
			'prop_val' => $prop_val
		);
	
		return array_filter( 
			$collection, 
			function( $collection ) use ( $args ) {
				extract( $args );
	
				if ( $collection[ $prop_key ] == $prop_val ) {
					return true;
				}
			}
		);
	
	}
	
	/**
	 * Array Helper Method: Merge and sorts multi-dimentional array.
	 * 
	 * @param 		array			$args          The array values to merge.
	 * 
	 * @param 		array			$defaults      The default array values.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * 
	 * @return 		array 			$default       The merged arrays. 
	 * 
	 * @link 		https://stackoverflow.com/questions/16203804/how-to-merge-two-multidimensional-arrays-without-overwriting-existing-keys-in-ph#answer-16203992
	 * 
	 * WORKING ARRAY MERGE FOR MULTI_DIMENTIONAL ARRAY
	 * 
	 * A recursive function is definitely the way to go here. I just whipped up the following. 
	 * Note the use of & in the function declaration of $this->multi_dimentional_array_merge_recursive. 
	 * This causes the second argument (called $default) to be passed by reference, instead of by value. 
	 * It is wrapped in fill_in so that the real "default" array is not modified.
	 * 
	 * This assumes that anything that is set in the $default array should be overwritten by anything 
	 * that exists in the $args array, even if a key in the $user array is set to null. 
	 * To change this behavior, add another if statement in the else clause in 
	 * $this->multi_dimentional_array_merge_recursive.
	 * 
	 * @BREAKDOWN
	 * 
	 * Normally, when calling a function in PHP, parameters are passed by "value": the function 
	 * gets a "copy" of the passed in variable. This means that the function can do whatever it 
	 * wants to the parameters but when the function returns, the original variable that was 
	 * passed is unaffected.
	 * 
	 * When an parameter is prefaced by an "&" symbol, the parameter is passed by "reference", 
	 * instead of being copied. When the function makes modifications to the parameter, it 
	 * is actually making changes directly to the variable that was passed in.
	 * 
	 * For more information, check out: http://php.net/manual/en/language.references.pass.php
	 */ 
	public function multi_dimentional_array_merge( $args, $default ) {
		
		$this->multi_dimentional_array_merge_recursive( $args, $default );
	
		return $default;
	}

	/**
	 * Array Helper Method: Recurcive merging and sorting of multi-dimentional array.
	 * 
	 * @param 		array			$args          The array values to merge.
	 * 
	 * @param 		array			$defaults      The default array values.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array			$default		The merged arrays. 
	 */
	public function multi_dimentional_array_merge_recursive( $args, &$default ) {
		foreach ( $args as $key => $value ) {
	
			if ( is_array( $value ) ) {
				$this->multi_dimentional_array_merge_recursive( $args[ $key ], $default[ $key ] );
			} else {
				$default[ $key ] = $value;
			}
		}
	}

	
	/***************************************************
	 * Array: Helper Methods
	 **************************************************/

	/**
	 * Fetches the value of a property from a multidimentional array.
	 * By defining the array property pathing to the target multidimentional array property
	 * Checks if the array property exists. If not, return the default value provided.
	 *
	 * @param		array		$args				An array of configs used fetch data.
	 * @var			array		$collection			The collection to be map
	 * @var			array		$collection_map		The array item pathing from which to get the value.
	 * @var			mixed		$default			The defualt value if the array item does not exists.
	 * 
	 * @example
	 * 		$this->map_array_item([
	 * 			'collection'		=> [ 'root_prop' => [ 'sub_prop' => [ 'target_prop' => 'The target Value' ] ] ],
	 * 			'collection_map'	=> [
	 * 				'root_prop',
	 * 				'sub_prop',
	 * 				'target_prop'
	 * 			],
	 * 			'default'			=> ''
	 * 		]);
	 *
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		mixed		$result		Returns the set value if exists. Otherwise, returns the provided default value.
	 */
	public function map_array_item( $args = [] ) {
				
		// Initialize variables
		$result			= '';
		$collections 	= [];
		$map_val		= null;
		$total_items 	= 0;

		// Set the "$default_args" value.
		$default_args	= [
			'collection'		=> [],
			'collection_map'	=> [],
			'default'			=> '',
		];

		// Merge the $default_args and provided $args
		$args 			= array_merge( $default_args, $args );

		// Converts each array item as a variable.
		extract( $args );

		$result = $default;

		// Terminate process if "$collection" & "$collection_map" are not arrays.
		if ( 
			! is_array( $collection ) &&
			! is_array( $collection_map )
		) return $result;

		foreach ( $collection_map as $map_index => $map_key ) {

			if ( 
				isset( $collection[ $map_key ] )
			) {

				// Set $map_val value to the current looped item value.
				$map_val = $collection[ $map_key ];

				// Set the total items by counting the items in "$collection_map" array.
				$total_items = count( $collection_map );

				/**
				 * Then check if "total_items" is greather than 1.
				 * 
				 * If yes, execute this function again to track the last item 
				 * in the "$collection_map" array.
				 */
				if ( $total_items > 1 ) {

					// Set the current $map_val in the $collections array.
					$collections = $map_val;
					
					// Remove the current $map_index in the $collection_map array.
					unset( $collection_map[ $map_index ] );
					
					// Execute the same function again to track to the last item of the $collection_map.
					$result = $this->map_array_item([
						'collection'		=> $collections,
						'collection_map'	=> $collection_map,
						'default'			=> $default,
					]);
				} else {
					/**
					 * If "$total_items" is NOT greather than 1.
					 * 
					 * This concludes, that the array tracking was successful.
					 */
					$result = $map_val;
				}

			}
		}

		return $result;
	}

	
	/***************************************************
	 * cURL Informations: Helper Methods
	 **************************************************/

	/**
	 * Checks if cURL PHP extension is available.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		bool		Returns true if cURL extension is installed. Otherwise, return false.
	 */
	public function is_curl_installed() {
		if ( in_array ('curl', get_loaded_extensions() ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Pulls the content of a file using cURL.
	 * 
	 * @param 	string	$url	The url path for file.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		mixed		Returns true on success or false on failure. However, if the CURLOPT_RETURNTRANSFER option is set, 
	 * 							it will return the result on success, false on failure.
	 */
	public function curl_get_file_contents( $url ) {
		if ( ! $this->is_curl_installed() ) {
			return false;
		}

        $c = curl_init();
		
        curl_setopt( $c, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $c, CURLOPT_URL, $url );

        $contents = curl_exec( $c );

        curl_close( $c );

        if ( $contents ) {
			return $contents;
		} else {
			return false;
		}
    }

	/**
	 * Executes a cURL request.
	 *
	 * @param 	array	$args       Handles the configuration of the cURL request.
	 * 
	 *      @var string $url               Required: Set the HTTP URL. Acceptable values a URL or API URL.
	 *                                     Default: Empty string
	 * 
	 *      @var string $method            Required: Set the HTTP Method. Acceptable values are GET, POST, PUT, DELETE.
	 *                                     Default: Empty string
	 * 
	 *      @var array  $headers           Optional: Sets the HTTP Header configurations.
	 *                                     Default: Empty array
	 * 
	 *      @var array  $data              Optional: Sets the CURLOPT_POSTFIELDS configurations.
	 *                                     Default: Empty array
	 * 
	 *      @var bool   $verify_ssl        Optional: Sets the CURLOPT_SSL_VERIFYHOST & CURLOPT_SSL_VERIFYPEER to true or false.
	 *                                     If false, disables libcurl to verify the server cert from the server and authenticity of the peer's certificate.
	 *                                     Useful usecase is when using CURL in localhost or debugging.
	 *                                     Default: True
	 * 
	 *      @var bool   $return_transfer   Optional: Sets the CURLOPT_RETURNTRANSFER to true or false.
	 *                                     Return the transfer as a string of the return value of curl_exec() instead of outputting it directly.
	 *                                     Default: True
	 * 
	 *      @var bool   $return_http_code  If true, includes the http_code & status message result in the returned array.
	 *                                     Default: True
	 * 
	 *      @var bool   $dump              If true, console logs the $http_status & $results.
	 *                                     Default: True
	 * 
	 * @see 		https://reqbin.com/req/c-1dw4uds4/curl-delete-request-example
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		array		$results		The JSON response to the CURL request converted to array.
	 */
	public function curl( $args = [] ) {

		if (
			! is_array( $args ) &&
			! $this->is_curl_installed()
		) {
			return;
		}

		$default_args = array(
			// Required: (String) Set the HTTP URL. Acceptable values a URL or API URL.
			'url'              => '',
			// Required: (String) Set the HTTP Method. Acceptable values are GET, POST, PUT, DELETE.
			'method'           => '',
			// Optional: (Array)  Sets the HTTP Header configurations
			'headers'          => array(),
			// Optional: (Array)  Sets the CURLOPT_POSTFIELDS configurations.
			'data'             => array(),
			// Optional: (Bool)   Sets the CURLOPT_SSL_VERIFYHOST & CURLOPT_SSL_VERIFYPEER to true or false.
			// If false, disables libcurl to verify the server cert from the server and authenticity of the peer's certificate.
			// Useful usecase is when using CURL in localhost or debugging.
			'verify_ssl'       => true,
			// Optional: (Bool)   Sets the CURLOPT_RETURNTRANSFER to true or false.
			// Return the transfer as a string of the return value of curl_exec() instead of outputting it directly
			'return_transfer'  => true,
			// Optional: (Bool)   If true, includes the http_code & status message result in the returned array.
			'return_http_code' => true,
			// Optional: (Bool)   If true, console logs the $http_status & $results.
			'dump'             => true
		);

		$args = array_merge( $default_args, $args );
		extract( $args );

		if ( ! is_string( $url ) ) { $url = ''; }
		if ( ! is_string( $method ) ) { $method = ''; }
		if ( ! is_array( $headers ) ) { $headers = array(); }
		if ( ! is_array( $data ) ) { $data = array(); }
		if ( ! is_bool( $verify_ssl ) ) { $verify_ssl = true; }
		if ( ! is_bool( $return_transfer ) ) { $return_transfer = true; }
		if ( ! is_bool( $return_http_code ) ) { $return_http_code = true; }
		if ( ! is_bool( $dump ) ) { $dump = true; }

		if ( ! empty( $url ) && ! empty( $method ) ) {

			$curl_opt_ssl_verify = $verify_ssl;
			
			$curl = curl_init( $url );
			curl_setopt( $curl, CURLOPT_URL, $url );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, $return_transfer );

			switch ($method) {
				case "GET":
					curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "GET" );
					break;
				case "POST":
					curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "POST" );
					break;
				case "PUT":
					curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PUT" );
					break;
				case "DELETE":
					curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "DELETE" ); 
					break;
			}

			if ( ! empty( $data ) ) {
				curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( $data ) );
			}
			
			curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );

			// For debug only!
			curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, $curl_opt_ssl_verify );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, $curl_opt_ssl_verify );

			$response = curl_exec( $curl );
			$results = json_decode( $response );

			/* Check for 404 (file not found). */
			$http_code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );


			// Check the HTTP Status code
			switch ($http_code) {
				case 200:
					$http_status = "200: Success";
					break;
				case 404:
					$http_status = "404: API Not found";
					break;
				case 500:
					$http_status = "500: servers replied with an error.";
					break;
				case 502:
					$http_status = "502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
					break;
				case 503:
					$http_status = "503: service unavailable. Hopefully they'll be OK soon!";
					break;
				default:
					$http_status = "Undocumented error: " . $http_code . " : " . curl_error($curl);
					break;
			}
			curl_close($curl);

			if ( is_array( $results ) && $return_http_code ) {
				$results[ 'http_code' ] 	= $http_code;
				$results[ 'http_status' ]	= $http_status;
			}

			if ( $dump && function_exists( 'obf_dump_js' ) ) {
				obf_dump_js( $results );
			}

			return ( $results );
		}
	}
	
	/***************************************************
	 * Class Informations: Helper Methods 
	 **************************************************/

	/**
	 * Wrapper function for the PHP ReflectionClass.
	 * ReflectionClass class reports information about a class.
	 * 
	 * @param		object|string	$objectOrClass	Either a string containing the name of the class to reflect, or an object.
	 * 
	 * @link 		https://www.php.net/manual/en/class.reflectionclass.php
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * 
	 * @return		object|boolean	$class_info		The ReflectionClass class reports information about a class. Otherwise, return false.
	 */
	public function get_class_info( $objectOrClass ) {
		$class_info = false;

		if ( 
			! class_exists( 'ReflectionClass' ) && 
			( ! is_object( $objectOrClass ) || ! is_string( $objectOrClass ) )
		) {
			return $class_info;
		}

		$class_info = new \ReflectionClass( $objectOrClass );

		return $class_info;
	}

	/***************************************************
	 * String Regex Searches: Helper Methods 
	 **************************************************/

	/**
	 * Fetch all the text in the content which is encapsulated by the %$start% and %$end% parameter.
	 * 
	 * @param		string		$content		The string to search.
	 * @param		string		$start			The opening character of the search encapsulation.
	 * @param		string		$end			The closing character of the search encapsulation.
	 * @param		bool		$encapsulate	The closing character of the search encapsulation.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * 
	 * @return		array		$results		Returns the collections of found results in array format.
	 */
	public function get_text_between( $content = '', $start='', $end='', $encapsulate = false ) {
		$results = [];
		
		if ( empty( $content ) && ! is_string( $content ) ) return $results;
		if ( empty( $start ) && ! is_string( $start ) ) return $results;
		if ( empty( $end ) && ! is_string( $end ) ) return $results;
		if ( empty( $encapsulate ) && ! is_bool( $encapsulate ) ) return $results;

		$last_pos = 0;

		// finds the position of the first occurrence of $start inside $content.
		$last_pos = strpos( $content, $start, $last_pos );

		// Execute while loop to until $last_post value is false.
		while ( $last_pos !== false ) {

			// finds the position of the first occurrence of $end inside $content.
			$text = strpos( $content, $end, $last_pos );

			// Append the text which is between the %$start% and %$end% as a new array item of $results.
			// If %$encapsulate% is true, include the character value of %$start% and %$end% to encapsulate the text result.
			$results[] = ( $encapsulate ? $start : '' ).substr( $content, $last_pos + 1, $text - $last_pos - 1 ).( $encapsulate ? $end : '' );
			
			// Update the value of the %$last_pos% if there was a text that matches.
			$last_pos = strpos( $content, $start, $last_pos + 1 );
		}

		return $results; 
	}

	/**
	 * Checks if the "Current Screen" in wp-admin assigned to the passed {$post_type} parameter.
	 * 
	 * @param		int			$post_type		The Post-type.
	 * @param		object		$post			The Post Object.
	 * 
	 * @since		0.0.1
	 * @author		Jasper Jardin
	 * @created_at	2025-10-19
	 * @access		public
	 * @return		bool		$status			Returns, true if "Current Screen" is assigned to the set post-type. Otherwise, false.
	 */
	public function is_current_admin_screen_post_type( $post_type = '', $post = null ) {
		
		$status	= false;
		
		// Terminate: If not in wp-admin.
		if ( ! is_admin() ) return $status;

		// Terminate: If {$post_type} is not valid terminate the process.
		if ( ! is_string( $post_type ) || empty( $post_type ) ) return $status;


		// Check the URL for the "post" parameter, sanitize and validate its value as an int.
		$post_id = filter_input( INPUT_GET, 'post', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT );

		// Terminate: If {$post_id} is not valid.
		if ( $post_id === false ) return $status;


		// Get the post object
		$post = get_post( $post_id );

		// Terminate: If {$post} is null.
		if ( is_null( $post ) ) return $status;

		if ( 
			isset( $post->post_type ) &&
			$post->post_type === $post_type
		) {
			$status = true;
		}
		
		return $status;
	}
}
