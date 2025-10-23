<?php
/**
 * ACF Block Manager
 *
 * Auto register blocks in the theme.
 *
 * @package imp
 */

/**
 * Class ACF Block Manager
 */
class ACF_Block_Manager {

	/**
	 * Instance of self
	 *
	 * @var self
	 */
	protected static $instance;

	/**
	 * Blocks Directory
	 *
	 * @var string
	 */
	protected string $blocks_dir = '';
	/**
	 * Constructor
	 */
	protected function __construct() {
		$this->blocks_dir   = get_stylesheet_directory() . '/acf-blocks/';
		$block_config_files = $this->get_block_config_files();
		$this->register_blocks( $block_config_files );

		add_action( 'wp_enqueue_scripts', array( $this, 'load_acf_block_css_in_head' ) );
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
	 * Register Blocks
	 *
	 * @param array $block_config_files block.json config files to register.
	 * @return void
	 */
	public function register_blocks( $block_config_files ) {
		add_action(
			'init',
			function () use ( $block_config_files ) {
				foreach ( $block_config_files as $config_file ) {
					register_block_type( $config_file );
				}
			}
		);
	}

	/**
	 * Get blocks and assets to register
	 *
	 * Also, gets all scripts to register so we can enqueue them on the fly easily.
	 *
	 * @return array
	 */
	public function get_block_config_files() {
		$block_config_files = glob( $this->blocks_dir . '*/dist/block.json' );

		return $block_config_files;
	}

	/**
	 * Load ACF block CSS in the Head.
	 *
	 * Parse the page content to load block CSS in the head of the page instead of the footer.
	 */
	public function load_acf_block_css_in_head() {
		$block_names = $this->get_block_list();

		foreach ( $block_names as $name ) {
			if ( str_contains( $name, 'acf/' ) ) {
				$block_name      = str_replace( 'acf/', '', $name );
				$block_json_file = $this->blocks_dir . $block_name . '/dist/block.json';

				// Get the Block JSON file to check for any files that need to be enqueued and it's dependencies.
				if ( is_readable( $block_json_file ) ) {
					$block_json = wp_json_file_decode( $block_json_file, array( 'associative' => true ) );
					if ( isset( $block_json['style'] ) ) {
						$relative_css_path = false;
						$deps              = array();
						if ( is_array( $block_json['style'] ) ) {
							foreach ( $block_json['style'] as $style ) {
								if ( str_contains( $style, 'file:./' ) ) {
									$relative_css_path = str_replace( 'file:./', '', $style );
								} else {
									$deps[] = $style;
								}
							}
						} elseif ( str_contains( $block_json['style'], 'file:./' ) ) {
							$relative_css_path = str_replace( 'file:./', '', $block_json['style'] );
						}

						if ( false !== $relative_css_path ) {
							$css_file_path = $this->blocks_dir . $block_name . '/dist/' . $relative_css_path;

							// Dequeue the standard style enqueue for acf blocks and replace it with our own early.
							if ( is_readable( $css_file_path ) ) {
								wp_deregister_style( 'acf-' . $block_name . '-style' );

								wp_enqueue_style(
									'acf-' . $block_name . '-style',
									get_stylesheet_directory_uri() . '/acf-blocks/' . $block_name . '/dist/' . $relative_css_path,
									$deps,
									filemtime( $css_file_path )
								);
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Get Block list
	 *
	 * Get a list of block names include in the post content.
	 *
	 * @return array List of block names
	 */
	protected function get_block_list() {
		$block_list = array();

		if ( is_singular() ) {
			global $post;

			if ( ! empty( $post->post_content ) ) {
				$blocks = parse_blocks( $post->post_content );

				if ( ! empty( $blocks ) ) {
					foreach ( $blocks as $block ) {
						$inner_blocks = array();
						if ( 'core/block' === $block['blockName'] && ! empty( $block['attrs']['ref'] ) ) {
							$content = get_post_field( 'post_content', $block['attrs']['ref'] );

							if ( ! empty( $content ) ) {
								$reusable_blocks = parse_blocks( $content );

								if ( ! empty( $reusable_blocks ) ) {
									$inner_blocks = $this->get_inner_blocks_list( $reusable_blocks );
								}
							}
						} else {
							if ( ! empty( $block['blockName'] ) ) {
								$block_list[] = $block['blockName'];
							}

							$inner_blocks = $this->get_inner_blocks_list( $blocks );
						}

						$block_list = array_merge( $inner_blocks, $block_list );
					}
				}
			}
		} elseif ( is_post_type_archive( 'module' ) ) {
			return array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() );
		}

		return array_unique( $block_list );
	}

	/**
	 * Get inner block list
	 *
	 * @param array $blocks Array of WordPress parsed blocks blocks.
	 * @return array List of inner block names.
	 */
	public function get_inner_blocks_list( $blocks ) {
		$inner_blocks = array();
		foreach ( $blocks as $block ) {
			if ( ! empty( $block['blockName'] ) ) {
				$inner_blocks[] = $block['blockName'];
			}

			if ( ! empty( $block['innerBlocks'] ) ) {
				$inner_blocks = array_merge( $inner_blocks, $this->get_inner_blocks_list( $block['innerBlocks'] ) );
			}
		}

		return $inner_blocks;
	}
}
