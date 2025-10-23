<?php
/**
 * Loads all the Taxonomy classes of the program.
 *
 * @package     Slate
 * @subpackage	Slate/Src/Components/Taxonomies
 * @category	Slate/Src/Components/Taxonomies/Initialize
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 * @link        https://profiles.wordpress.org/wpjasper/
 * @since       0.0.1
 * @license     GPL-2.0+
 * @copyright   2025 | https://github.com/jasperjardin/slate
 * @created_at  2025-10-19
 */

namespace Slate\Src\Components\Taxonomies;

if ( ! defined( 'ABSPATH' ) ) {
    return;
}


/**
 * Initialize the default taxonomies.
 */
use \Slate\Src\Components\Taxonomies\Defaults\Config as Builtin_Taxonomies;
new Builtin_Taxonomies();

/**
 * Initialize the portfolio-types taxonomy.
 */
use \Slate\Src\Components\Taxonomies\Portfolio_Types\Config as Portfolio_Types_Taxonomy;
new Portfolio_Types_Taxonomy();