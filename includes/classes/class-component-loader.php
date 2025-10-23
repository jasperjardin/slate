<?php
/**
 * Class used for loading scripts for components
 *
 * @package imp
 */

/**
 * Class Component Loader
 */
class Component_Loader {
	/**
	 * Instance of self
	 *
	 * @var self
	 */
	protected static $instance;

	/**
	 * All component names
	 *
	 * @var array
	 */
	protected $components;

	/**
	 * Constructor
	 */
	protected function __construct() {
		$theme_dir        = get_stylesheet_directory();
		$part_folders     = glob( $theme_dir . '/components/*', GLOB_ONLYDIR );
		$this->components = array_map( fn( $path ) => str_replace( "$theme_dir/", '', $path ) . '/partial', $part_folders );

		$this->add_hooks();
	}

	/**
	 * Get Singleton Instance.
	 *
	 * @param mixed ...$args Args assigned to instance in constructor.
	 * @return self
	 */
	public static function get_instance( ...$args ) {
		if ( is_null( self::$instance ) ) {
			static::$instance = new static( ...$args );
		}

		return static::$instance;
	}

	/**
	 * Add WP Hooks
	 *
	 * @return void
	 */
	protected function add_hooks() {
		if ( is_admin() ) {
			add_action( 'enqueue_block_assets', array( $this, 'enqueue_assets_for_gutenberg' ) );
		} else {
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_assets_for_gutenberg' ) );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'register_component_scripts' ) );

		foreach ( $this->components as $component ) {
			add_action( "get_template_part_$component", array( $this, 'enqueue_component_assets' ), 10, 1 );
		}
	}

	/**
	 * Register component scripts
	 */
	public function register_component_scripts() {
		foreach ( $this->components as $component ) {
			$theme_dir     = get_stylesheet_directory();
			$component_dir = str_replace( '/partial', '', $component );
			$json_file     = $theme_dir . '/' . $component_dir . '/src/manifest.json';

			if ( file_exists( $json_file ) ) {
				$assets = wp_json_file_decode( $json_file ); //phpcs:ignore
				$assets = $this->get_assets_from_json_file( $json_file, $component_dir );

				$component_name = str_replace( 'components/', '', $component );
				$component_name = str_replace( '/partial', '', $component_name );

				if ( isset( $assets['script'] ) ) {
					wp_register_script(
						"component-$component_name-js",
						$assets['script']['file'],
						$assets['script']['deps'],
						$assets['script']['version'],
						true
					);
				}

				if ( isset( $assets['style'] ) && ! is_admin() ) {
					wp_register_style(
						"component-$component_name-style",
						$assets['style']['file'],
						$assets['style']['deps'],
						$assets['style']['version'],
					);
				}
			}
		}
	}

	/**
	 * Get inline CSS
	 *
	 * @param  string $handle  Registered wp style handle.
	 * @return string
	 */
	public function get_inline_css( $handle ) {
		$output    = '';
		$wp_styles = wp_styles();

		if ( isset( $wp_styles->registered[ $handle ] ) && ! in_array( $handle, $wp_styles->done, true ) ) {
			$path = preg_replace( '/(http[s]?:\/\/[^\/]+)\//', '/', $wp_styles->registered[ $handle ]->src );
			$path = ABSPATH . $path;

			$after = $wp_styles->get_data( $handle, 'after' );
			if ( is_array( $after ) ) {
				$after = implode( '', $after );
			}

			// Get CSS and add any css that should be inlined after.
			$css  = file_exists( $path ) ? file_get_contents( $path ) : ''; // phpcs:ignore
			$css .= $after;

			// Add dependencies inline CSS above.
			foreach ( $wp_styles->registered[ $handle ]->deps as $dep ) {
				$output .= $this->get_inline_css( $dep );
			}

			// Remove comments.
			$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );

			$output .= '<style id="' . esc_attr( $handle ) . '-inline-css" data-component-style>' . wp_strip_all_tags( $css ) . '</style>';

			$wp_styles->done[] = $handle;
		}

		return $output;
	}

	/**
	 * Enqueue component assets
	 *
	 * @param string $component Partial folder path.
	 * @return void
	 */
	public function enqueue_component_assets( $component ) {
		$component_name = str_replace( 'components/', '', $component );
		$component_name = str_replace( '/partial', '', $component_name );

		// Enqueue javascript in the footer.
		wp_enqueue_script( "component-$component_name-js" );

		$css = $this->get_inline_css( "component-$component_name-style" );

		// Escaped in the get_inline_css method.
		echo $css; // phpcs:ignore
	}

	/**
	 * Enqueue assets for gutenberg
	 *
	 * @return void
	 */
	public function enqueue_assets_for_gutenberg() {
		foreach ( $this->components as $component ) {
			$theme_dir     = get_stylesheet_directory();
			$component_dir = str_replace( '/partial', '', $component );
			$json_file     = $theme_dir . '/' . $component_dir . '/src/manifest.json';
			if ( file_exists( $json_file ) ) {
				$assets = json_decode( file_get_contents( $json_file ), true ); //phpcs:ignore
				$assets = $this->get_assets_from_json_file( $json_file, $component_dir );

				$component_name = str_replace( 'components/', '', $component );
				$component_name = str_replace( '/partial', '', $component_name );

				if ( isset( $assets['editorStyle'] ) && is_admin() ) {
					if ( null !== $assets['editorStyle']['file'] ) {
						wp_enqueue_style(
							"component-$component_name-editor",
							$assets['editorStyle']['file'],
							$assets['editorStyle']['deps'],
							$assets['editorStyle']['version'],
						);
					} elseif ( ! empty( $assets['editorStyle']['deps'] ) ) {
						foreach ( $assets['editorStyle']['deps'] as $handle ) {
							wp_enqueue_style( $handle );
						}
					}
				}
			}
		}
	}

	/**
	 * Get assets from json file
	 *
	 * @param string $json_file   Path to component json file.
	 * @param string $component_dir Relative component directory to the theme.
	 * @return array
	 */
	protected function get_assets_from_json_file( string $json_file, string $component_dir ) {
		$component_dir_uri  = get_stylesheet_directory_uri() . "/$component_dir";
		$component_dir_path = get_stylesheet_directory() . "/$component_dir";
		$data               = wp_json_file_decode( $json_file, array( 'associative' => true ) );

		return array_map(
			function ( $entry ) use ( $component_dir_path, $component_dir_uri ) {
				$file    = null;
				$version = null;
				$deps    = array();
				if ( is_array( $entry ) ) {
					foreach ( $entry as $item ) {
						if ( str_contains( $item, 'file:.' ) ) {
							$relative_file = str_replace( 'file:.', '/dist', $item );
							$relative_file = str_replace( '.tsx', '.js', $relative_file );
							$relative_file = str_replace( '.ts', '.js', $relative_file );

							$file     = $component_dir_uri . $relative_file;
							$filepath = $component_dir_path . $relative_file;

							if ( file_exists( $filepath ) ) {
								$version = filemtime( $filepath );
							}
						} else {
							$deps[] = $item;
						}
					}
				} elseif ( str_contains( $entry, 'file:.' ) ) {
					$relative_file = str_replace( 'file:.', '/dist', $entry );

					$file     = $component_dir_uri . $relative_file;
					$filepath = $component_dir_path . $relative_file;

					if ( file_exists( $filepath ) ) {
						$version = filemtime( $filepath );
					}
				} else {
					$deps[] = $entry;
				}

				return array(
					'file'    => $file,
					'deps'    => $deps,
					'version' => $version,
				);
			},
			$data
		);
	}
}
