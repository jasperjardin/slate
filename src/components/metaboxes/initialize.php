<?php
/**
 * Loads all the Metabox Classes of the program.
 *
 * @package     Slate
 * @subpackage	Slate/Src/Components/Metaboxes
 * @category	Slate/Src/Components/Metaboxes/Initialize
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Metaboxes;

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * Initialize the Utility Metabox.
 */
use \Slate\Src\Components\Metaboxes\Menus\Utility as Utility_Metabox;
new Utility_Metabox();