<?php
/**
 * Configuration array to control the loading sequence for the config files of the Slate theme.
 *
 * This array is used to store the loader for the Slate theme.
 * It is loaded by the Config class.
 *
 * @package     Slate
 * @category    Slate/Config
 * @subpackage  Slate/Config/Loader
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

return array(
	'theme.php',
	'hooks/actions.php',
	'hooks/filters.php',
	'content/types/post-types.php',
	'content/types/taxonomies.php',
	'content/parts/shortcodes.php',
	'security.php',
	'api.php',
	'resources.php',
	'ajax.php',
	'http-headers.php',
	'paths.php',
	'dump.php',
	'loader.php',
);
