<?php
/**
 * Main nav walker menu
 *
 * @package wex
 */

/**
 * Class Main Nav Walker Menu
 */
class Main_Nav_Walker_Menu extends Walker_Nav_Menu {

	/**
	 * Generate mega menu item HTML.
	 *
	 * @param  string $post_id WP Post ID.
	 * @param  string $title   Menu item title.
	 * @param  string $menu_class Menu class.
	 * @return string
	 */
	public function generate_mega_menu_html( string $post_id, string $title, string $menu_class ): string {
		ob_start();
		get_component(
			'mega-menu-item',
			array(
				'post_id'    => $post_id,
				'title'      => $title,
				'menu_class' => $menu_class,
			)
		);
		$output = ob_get_clean();
		return $output;
	}

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 * @since 5.9.0 Renamed `$item` to `$data_object` and `$id` to `$current_object_id`
	 *              to match parent class for PHP 8 named parameter support.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string         $output            Used to append additional content (passed by reference).
	 * @param WP_Post        $data_object       Menu item data object.
	 * @param int            $depth             Depth of menu item. Used for padding.
	 * @param stdClass|array $args              An object of wp_nav_menu() arguments.
	 * @param int            $current_object_id Optional. ID of the current menu item. Default 0.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		global $current_nav_title;
		// Restores the more descriptive, specific name for use within this method.
		$menu_item = $data_object;
		$args      = (object) $args;

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes = array();

		if ( ! empty( $args->menu_class ) ) {
			$classes[] = $args->menu_class . '__nav-item';
			$classes[] = $args->menu_class . '__nav-item--depth-' . ( $depth + 1 );
		}

		if ( ! empty( $menu_item->classes ) && in_array( 'menu-item-has-children', $menu_item->classes, true ) && 0 === $depth ) {
			$classes[] = $args->menu_class . '__nav-item--has-dropdown';
		}

		if ( ( 'post_type' === $menu_item->type && 'mega_menu' === $menu_item->object ) && 0 === $depth ) {
			$classes[] = $args->menu_class . '__nav-item--has-mm-dropdown';
		}

		if ( ! empty( $menu_item->classes ) && in_array( 'current-menu-item', $menu_item->classes, true ) ) {
			$classes[] = $args->menu_class . '__nav-item--current-page';
		}

		if ( ! empty( $menu_item->classes ) && in_array( 'current-menu-ancestor', $menu_item->classes, true ) ) {
			$classes[] = $args->menu_class . '__nav-item--current-ancestor';
		}

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param WP_Post  $menu_item Menu item data object.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );

		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID attribute applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_item_id The ID attribute applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item    The current menu item.
		 * @param stdClass $args         An object of wp_nav_menu() arguments.
		 * @param int      $depth        Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		// Link attributes.
		$atts           = array();
		$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
		$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
		if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}

		if ( ! empty( $menu_item->url ) ) {
			if ( get_privacy_policy_url() === $menu_item->url ) {
				$atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
			}

			$atts['href'] = $menu_item->url;
		} else {
			$atts['href'] = '';
		}

		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		$link_classes = array();

		if ( ! empty( $args->menu_class ) ) {
			$link_classes[] = $args->menu_class . '__nav-link';
			$link_classes[] = $args->menu_class . '__nav-link--depth-' . ( $depth + 1 );

			if ( $menu_item->current ) {
				$link_classes[] = $args->menu_class . '__nav-link--current-page';
			}
		}

		$atts['class'] = implode( ' ', $link_classes );

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria-current The aria-current attribute.
		 * }
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title     The menu item's title.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

		// Add mega menu HTML or default menu item.
		if ( 'post_type' === $menu_item->type && 'mega_menu' === $menu_item->object ) {
			$item_output = $this->generate_mega_menu_html( $menu_item->object_id, $menu_item->title, $args->menu_class );
		} else {
			$item_output  = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . '<span>' . $title . '</span>' . $args->link_after;
			$item_output .= '</a>';

			$item_output .= $args->after;
		}

		$args->parent_title = $title;
		$args->parent_link  = $atts['href'];

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $menu_item   Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		global $current_nav_title;

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default classes array.
		$classes = array( "{$args->menu_class}__sub-menu" );

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );

		$atts          = array();
		$atts['class'] = ! empty( $class_names ) ? $class_names : '';

		/**
		 * Filters the HTML attributes applied to a menu list element.
		 *
		 * @since 6.3.0
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the `<ul>` element, empty strings are ignored.
		 *
		 *     @type string $class    HTML CSS class attribute.
		 * }
		 * @param stdClass $args      An object of `wp_nav_menu()` arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$atts       = apply_filters( 'nav_menu_submenu_attributes', $atts, $args, $depth );
		$attributes = $this->build_atts( $atts );

		if ( 0 === $depth ) {
			$output .= "{$n}{$indent}<div class=\"{$args->menu_class}__dropdown\">";
			$output .= "{$n}{$indent}<a href=\"{$args->parent_link}\" class=\"{$args->menu_class}__mobile-link\">{$args->parent_title}</a>{$n}";
			$output .= "<ul{$attributes}>{$n}";
		} else {
			$output .= "{$n}{$indent}<ul{$attributes}>{$n}";
		}
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		if ( 0 === $depth ) {
			$output .= "$indent</ul></div>{$n}";
		} else {
			$output .= "$indent</ul>{$n}";
		}
	}
}
