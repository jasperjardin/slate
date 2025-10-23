<?php
/**
 * Helper functions
 *
 * @package imp
 */

/**
 * Array To Link
 *
 * Convert ACF link array to HTML.
 *
 * @param  false|array $link        Array for link. Matches ACF links.
 * @param  string      $class_name  Class attribute for the link.
 * @param  string      $icon        Icon to display from the icon library.
 * @return string|false
 */
function array_to_link( $link, string $class_name = '', $icon = '' ) {
	if ( ! is_array( $link ) ) {
		return false;
	}

	$output  = '<a href="' . esc_url( $link['url'] ) . '"';
	$output .= ! empty( $class_name ) ? ' class="' . esc_attr( $class_name ) . '"' : '';
	$output .= ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '';
	$output .= '>';
	$output .= esc_html( $link['title'] );
	$output .= ! empty( $icon ) ? '<span class="' . esc_attr( $icon ) . '"></span>' : '';
	$output .= '</a>';

	return $output;
}

/**
 * Get SVG contents
 *
 * @param  int|string $source  Either attachment ID or URL.
 * @return mixed
 */
function get_svg( $source ) {
	if ( is_int( $source ) ) {
		$source = wp_get_attachment_url( $source );
	}

	$file_path = str_replace(
		WP_CONTENT_URL,
		WP_CONTENT_DIR,
		$source
	);

	$file_ext = pathinfo( $file_path, PATHINFO_EXTENSION );

	if ( empty( $source ) || ! file_exists( $file_path ) ) {
		return false;
	}

	if ( 'svg' !== $file_ext ) {
		return $file_path;
	}

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	return file_get_contents( $file_path );
}

/**
 * Get Primary Term
 *
 * Gets the primary term if set by Yoast, or get the first term selected.
 *
 * @param WP_Post|integer $post  Post object or ID.
 * @param string          $tax   Taxonomy slug.
 * @return WP_Term|false
 */
function get_primary_term( WP_Post|int $post, string $tax = 'category' ) {
	if ( ! is_object( $post ) ) {
		$post = get_post( $post );
	}

	if ( function_exists( 'yoast_get_primary_term' ) ) {
		$primary_id = yoast_get_primary_term_id( $tax, $post );

		if ( $primary_id ) {
			return get_term( $primary_id );
		}
	}

	$terms = get_the_terms( $post, $tax );

	if ( ! empty( $terms ) ) {
		return $terms[0];
	}

	return false;
}

/**
 * Get component
 *
 * Shorthand for get_template_part for.
 *
 * @param string $slug Partial slug.
 * @param array  $args get_template_part args.
 * @return void
 */
function get_component( string $slug, array $args = array() ) {
	get_template_part(
		"components/$slug/partial",
		null,
		$args
	);
}

/**
 * Get block partial
 *
 * Shorthand for get_template_part for.
 *
 * @param string $slug Partial slug.
 * @param array  $args get_template_part args.
 * @return void
 */
function get_block_partial( string $slug, array $args = array() ) {
	get_template_part(
		"acf-blocks/$slug/partial",
		null,
		$args
	);
}

/**
 * Get field and always return an array
 *
 * @param string              $field           ACF Field.
 * @param integer|string|null $id              ACF ID.
 * @return array
 */
function get_field_array( string $field, int|string|null $id = null ): array {
	$data = get_field( $field, $id );

	return $data ? $data : array();
}

/**
 * Get grid breakpoints from SCSS variables.
 *
 * @return array
 */
function imp_get_grid_breakpoints() {
	$variables_file = get_template_directory() . '/assets/resources/css/helpers/_variables.scss';
	if ( is_readable( $variables_file ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$file_contents = file_get_contents( $variables_file );

		$pattern = '/\$grid-breakpoints[: \(]+([^\)]+)/m';
		if ( preg_match( $pattern, $file_contents, $matches ) ) {
			// Remove whitespace and new lines, then split into pairs.
			$pairs = array_map( 'trim', explode( ',', trim( $matches[1] ) ) );

			$breakpoints = array();
			foreach ( $pairs as $pair ) {
				if ( str_contains( $pair, ':' ) ) {
					list( $key, $value ) = array_map( 'trim', explode( ':', $pair ) );
					$value               = (int) str_replace( 'px', '', $value );
					$breakpoints[ $key ] = $value;
				}
			}

			return $breakpoints;
		}
	}

	return array();
}


/**
 * Get themes from SCSS variables.
 *
 * @return array
 */
function imp_get_themes() {
	$variables_file = get_template_directory() . '/assets/resources/css/helpers/_variables.scss';
	if ( is_readable( $variables_file ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$file_contents = file_get_contents( $variables_file );

		// Regular expression to match the $themes variable in SCSS.
		$regex = '/\$themes:\s*\(\s*((\([^\)]+\),?\s*)+)\);/m';
		if ( preg_match( $regex, $file_contents, $matches ) ) {
			$themes_string = $matches[1];

			// Regular expression to match individual theme maps with "name", "slug", and "color".
			$theme_regex = '/\(\s*"name":\s*"([^"]+)",\s*"slug":\s*"([^"]+)",\s*"color":\s*"([^"]+)"\s*\)/';

			// Find each theme in the matched string.
			$themes_array = array();
			if ( preg_match_all( $theme_regex, $themes_string, $theme_matches, PREG_SET_ORDER ) ) {
				foreach ( $theme_matches as $theme_match ) {
					$name  = sanitize_text_field( $theme_match[1] );
					$slug  = sanitize_title( $theme_match[2] ); // Slug should be sanitized like a post slug.
					$color = sanitize_hex_color( $theme_match[3] );

					// Add the theme to the PHP array.
					$themes_array[] = array(
						'name'  => $name,
						'slug'  => $slug,
						'color' => $color,
					);
				}
			}

			return $themes_array;
		}
	}

	return array();
}

/**
 * Get Autoplay Ready Embed
 *
 * This will get an embed and replace src with data-src and a URL that will autoplay.
 *
 * @param string $url URL of video to embed.
 * @return string|false
 */
function get_autoplay_ready_embed( $url ) {
	$embed = wp_oembed_get( $url );
	if ( preg_match( '/src="([^"]+)"/', $embed, $matches ) ) {
		$embed_url = $matches[1];

		// Add autoplay=1 to the embed URL.
		$autoplay_url = add_query_arg( 'autoplay', '1', $embed_url );

		if ( str_contains( $autoplay_url, 'wistia' ) ) {
			$autoplay_url = add_query_arg( 'fitStrategy', 'cover', $autoplay_url );
			$embed        = preg_replace( '/\s+sandbox="[^"]*"/', '', $embed );
		}

		// Replace the src attribute with data-src with our autoplay URL.
		$embed = str_replace(
			'src="' . $embed_url . '"',
			'data-src="' . esc_url( $autoplay_url ) . '"',
			$embed
		);

		return $embed;
	}

	return false;
}

/**
 * Get Wistia video ID from URL
 *
 * @param string $url Wistia video URL.
 * @return null|string
 */
function imp_get_wistia_video_id( $url ) {
	$pattern = '/(?:medias|iframe)\/([a-zA-Z0-9]+)/';
	preg_match( $pattern, $url, $matches );

	return $matches[1] ?? null;
}

/**
 * Get Autoplay Embed
 *
 * @param string $url URL of video to embed.
 * @return string|false
 */
function imp_get_autoplay_embed( $url ) {
	$embed = wp_oembed_get( $url );
	if ( preg_match( '/src="([^"]+)"/', $embed, $matches ) ) {
		$embed_url = $matches[1];

		$autoplay_url = add_query_arg( 'autoplay', '1', $embed_url );
		$autoplay_url = add_query_arg( 'muted', '1', $autoplay_url );
		$autoplay_url = add_query_arg( 'background', '1', $autoplay_url );
		$autoplay_url = add_query_arg( 'loop', '1', $autoplay_url );

		// Replace the src attribute with data-src with our autoplay URL.
		$embed = str_replace(
			'src="' . $embed_url . '"',
			'src="' . esc_url( $autoplay_url ) . '"',
			$embed
		);

		return $embed;
	}

	return $embed;
}

/**
 * Get inner blocks ACF fields
 *
 * @param WP_Block|null $wp_block The WP_Block object to fetch inner blocks from.
 * @param callable|null $callback Optional callback function to process each inner block's data.
 * @return array
 */
function imp_get_inner_blocks_acf_fields( ?WP_Block $wp_block = null, ?callable $callback = null ): array {
	if ( null === $wp_block || ! is_a( $wp_block->inner_blocks, 'WP_Block_List' ) ) {
		return array();
	}

	$data   = array();
	$blocks = iterator_to_array( $wp_block->inner_blocks );

	if ( ! empty( $blocks ) ) {
		foreach ( $blocks as $key => $inner_block ) {
			if ( $callback && ! call_user_func( $callback, $inner_block ) ) {
				continue;
			}
			if ( isset( $inner_block->attributes['data'] ) && ! empty( $inner_block->attributes['data'] ) ) {
				$data[ $key ] = $inner_block->attributes['data'];
			}
			$data[ $key ]['block_id'] = acf_get_block_id( $inner_block->attributes, $inner_block->context );
		}
	}

	return $data;
}
