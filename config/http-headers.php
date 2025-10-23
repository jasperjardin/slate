<?php
/**
 * Configuration array for the HTTP Headers for the Slate theme.
 *
 * This array is used to store the HTTP Headers for the Slate theme.
 * It is loaded by the Config class.
 *
 * @package     Slate
 * @category    Slate/Config
 * @subpackage  Slate/Config/HttpHeaders
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	/**
	 * The HTTP Headers configuration array.
	 */
	'http_headers' => array(
		/**
		 * Setup the allowed HTTP Origins for the HTTP Headers.
		 * This, allows specified HTTP origins to access the site.
		 */
		'allowed_http_origins' => array(
			get_site_url(),
		),
	),
);
