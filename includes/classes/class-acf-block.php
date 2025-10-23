<?php
/**
 * Class used for ACF Blocks
 *
 * @package imp
 */

/**
 * Class ACF Block
 */
class ACF_Block {

	/**
	 * Block settings.
	 *
	 * @var array
	 */
	public array $settings = array();

	/**
	 * WP Block
	 *
	 * @var ?WP_Block
	 */
	public ?WP_Block $wp_block;

	/**
	 * Constructor
	 *
	 * @param array $settings Block settings and attributes.
	 * @param mixed $wp_block WP_Block object if exists.
	 */
	public function __construct( array $settings, mixed $wp_block ) {
		$this->settings = $settings;
		$this->wp_block = $wp_block;

		$this->generate_styles();
	}

	/**
	 * Get block ID
	 *
	 * @return string
	 */
	public function get_id(): string {
		$block_id = $this->settings['id'];

		if ( isset( $this->settings['anchor'] ) && ! empty( $this->settings['anchor'] ) ) {
			$block_id = $this->settings['anchor'];
		}

		/**
		 * Filter for block ID.
		 *
		 * @hook imp_acf_block_get_id
		 * @param string  $block_id Block ID used typically for the section class.
		 * @param array   $settings Block settings
		 * @return string
		 */
		return apply_filters( 'imp_acf_block_get_id', $block_id, $this->settings );
	}

	/**
	 * Get block settings classes
	 *
	 * @param boolean $space_before Add a space before the return string if true.
	 * @return string
	 */
	public function get_settings_classes( $space_before = false ) {
		$classes = array();

		if ( ! empty( $this->settings['backgroundColor'] ) ) {
			$classes[] = 'has-background has-' . $this->settings['backgroundColor'] . '-background-color';
		}

		if ( ! empty( $this->settings['textColor'] ) ) {
			$classes[] = 'has-text-color has-' . $this->settings['textColor'] . '-text-color';
		}

		if ( ! empty( $this->settings['align'] ) ) {
			$classes[] = 'align' . $this->settings['align'];
		}

		if ( ! empty( $this->settings['alignText'] ) ) {
			$classes[] = 'has-text-align-' . $this->settings['alignText'];
		}

		if ( ! empty( $this->settings['alignContent'] ) ) {
			$classes[] = 'is-vertically-aligned-' . $this->settings['alignContent'];
		}

		if ( ! empty( $this->settings['contentWidth'] ) ) {
			$classes[] = 'has-content-width-' . $this->settings['contentWidth'];
		}

		if ( ! empty( $this->settings['className'] ) ) {
			$classes[] = $this->settings['className'];
		}

		$classes_string = implode( ' ', $classes );
		if ( $space_before && ! empty( $classes ) ) {
			$classes_string = ' ' . $classes_string;
		}

		return $classes_string;
	}

	/**
	 * Retrieves the theme settings slug.
	 *
	 * This method checks if the theme is supported and set in the current
	 * settings. If not, it returns `false`. If the theme is set and supported,
	 * it returns the theme value.
	 *
	 * @return string|false The theme if set, otherwise false.
	 */
	public function get_theme() {
		if ( ! isset( $this->settings['supports']['theme'] ) || ! $this->settings['supports']['theme'] ) {
			return false;
		}

		if ( isset( $this->settings['theme'] ) ) {
			return $this->settings['theme'];
		}

		// If theme is true, but no theme is selected, grab the first one.
		if ( true === $this->settings['supports']['theme'] ) {
			$themes = imp_get_themes();
			if ( empty( $themes ) ) {
				return false;
			}

			return $themes[0]['slug'];
		}

		// If theme supports is an array, return the first item.
		if ( is_array( $this->settings['supports']['theme'] ) && ! empty( $this->settings['supports']['theme'] ) ) {
			return $this->settings['supports']['theme'][0];
		}

		return false;
	}

	/**
	 * Get inner blocks acf fields.
	 *
	 * @return array
	 */
	public function get_inner_blocks_acf_fields(): array {
		return imp_get_inner_blocks_acf_fields( $this->wp_block );
	}

	/**
	 * Generate Styles
	 */
	public function generate_styles() {
		$css = '';

		if ( isset( $this->settings['style']['spacing']['margin'] ) && ! is_admin() ) {
			$css .= $this->get_spacing_css( $this->settings['style']['spacing']['margin'], 'margin' );
		}

		if ( isset( $this->settings['style']['spacing']['padding'] ) && ! is_admin() ) {
			$css .= $this->get_spacing_css( $this->settings['style']['spacing']['padding'], 'padding' );
		}

		if ( ! empty( $css ) ) {
			$css          = '#' . $this->get_id() . '{' . $css . '}';
			$style_handle = sanitize_title( $this->settings['name'] ) . '-style-extras';
			add_action(
				'wp_footer',
				function () use ( $style_handle, $css ) {
					echo '<style id="' . esc_attr( $style_handle ) . '">' . esc_html( $css ) . '</style>';
				}
			);
		}
	}

	/**
	 * Get spacing CSS
	 *
	 * Generate spacing CSS for margin/padding depending on the type passed.
	 *
	 * @param array  $spacing Array from Gutenberg for spacing.
	 * @param string $type    margin or padding.
	 * @return string
	 */
	public function get_spacing_css( $spacing, $type ) {
		$css = '';

		foreach ( $spacing as $direction => $value ) {
			// Convert custom CSS properties.
			$prefix     = 'var:';
			$prefix_len = strlen( $prefix );
			$token_in   = '|';
			$token_out  = '--';

			if ( 0 === strncmp( $value, $prefix, $prefix_len ) ) {
				$unwrapped_name = str_replace(
					$token_in,
					$token_out,
					substr( $value, $prefix_len )
				);

				$value = "var(--wp--$unwrapped_name)";
			}

			if ( ! str_contains( $value, 'default' ) ) {
				$css .= "{$type}-{$direction}: {$value} !important;";
			}
		}

		return $css;
	}
}
