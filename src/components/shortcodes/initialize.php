<?php
/**
 * Loads all the shortcodes classes of this program.
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

namespace Slate\Src\Components\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * This class is executes the Sample shortcode.
 *
 * The shortcode displays the Sample shortcode.
 *
 * @usage      [slate_sample]
 *
 * @since       0.0.1
 * @package     Slate
 * @subpackage	Slate/Src/Components/Shortcodes/Header
 * @category	Slate/Src/Components/Shortcodes/Header/Sample
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 */
use \Slate\Src\Components\Shortcodes\Header\Sample as Header_Sample_Shortcode;
new Header_Sample_Shortcode();

/**
 * This class is executes the "Logos: Supported Payment Methods" shortcode.
 *
 * This class defines all code necessary to initialize the "Logos: Supported Payment Methods" shortcode.
 *
 * @usage      [slate_supported_payment_method_logos]
 *
 * @since       0.0.1
 * @package     Slate
 * @subpackage	Slate/Src/Components/Shortcodes/Social_Accounts
 * @category	Slate/Src/Components/Shortcodes/Social_Accounts/Platform_Icons
 * @author      Jasper B. Jardin <jasper.jardin1994@gmail.com>
 */
use \Slate\Src\Components\Shortcodes\Logos\Supported_Payment_Methods as Logos_Supported_Payment_Methods_Shortcode;
new Logos_Supported_Payment_Methods_Shortcode();

/**
 * This class is generate the "Lightbox: Trigger" shortcode.
 *
 * This class defines all code necessary to generate the "Lightbox: Trigger" shortcode.
 *
 * @usage      [obf_lightbox_trigger]
 *
 * @since      1.0.0
 * @package    Ocean Blue Fishing
 * @subpackage Ocean Blue Fishing/Src/Shortcodes/Lightbox/Trigger
 * @author     Jasper B. Jardin <jasper.jardin1994@gmail.com>
 */
use \Slate\Src\Components\Shortcodes\Lightbox\Trigger as Lightbox_Trigger_Shortcode;
new Lightbox_Trigger_Shortcode();
