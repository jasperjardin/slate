<?php
/**
 * Loads all the Post Type classes of the program.
 *
 * @package     Slate
 * @subpackage	Slate/Src/Components/Post_Types
 * @category	Slate/Src/Components/Post_Types/Initialize
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Post_Types;

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * Initialize the default post types.
 */
use \Slate\Src\Components\Post_Types\Defaults\Config as Builtin_Post_Types;
new Builtin_Post_Types();

/**
 * Initialize the portfolio post type.
 */
use \Slate\Src\Components\Post_Types\Portfolio\Config as Portfolio_CPT;
new Portfolio_CPT();
