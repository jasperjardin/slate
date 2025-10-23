<?php
/**
 * Sticky Media Content Split Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

if ( $wp_block instanceof WP_Block && isset( $wp_block->inner_blocks ) && $wp_block->inner_blocks instanceof WP_Block_List ) {
	$child_blocks = iterator_to_array( $wp_block->inner_blocks );

	$slider_blocks = array();
	foreach ( $child_blocks as $child_block ) {
		if ( $child_block instanceof WP_Block && isset( $child_block->inner_blocks ) && $child_block->inner_blocks instanceof WP_Block_List ) {
			$fields = imp_get_inner_blocks_acf_fields(
				$child_block,
				function ( $block ) {
					return isset( $block->name ) && 'acf/media' === $block->name;
				}
			);
			if ( is_array( $fields ) && ! empty( $fields ) ) {
				$slider_blocks[] = $fields;
			}
		}
	}

	if ( ! empty( $slider_blocks ) ) {
		$slider_blocks = array_merge( ...$slider_blocks );
	} else {
		$slider_blocks = array();
	}
}

// InnerBlocks templating.
$allowed_blocks = array( 'acf/content-media-split' );
$template       = array(
	array( 'acf/content-media-split' ),
	array( 'acf/content-media-split' ),
);

// Set block classes.
$block_classes  = 'acf-block block-sticky-media-content-split';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<?php if ( ! is_admin() ) : ?>
		<div class="block-sticky-media-content-split__sticky-content">
			<div class="block-sticky-media-content-split__images-container">
				<?php if ( ! empty( $slider_blocks ) ) : ?>
					<div class="sticky-media-content-split-slider swiper">
						<div class="sticky-media-content-split-slider__slides swiper-wrapper">
							<?php foreach ( $slider_blocks as $slider_block ) : ?>
								<div class="sticky-media-content-split-slider__slide swiper-slide" data-block-id="block_<?php echo esc_attr( $slider_block['block_id'] ); ?>">
									<?php
									get_component(
										'media',
										array(
											'media_type' => isset( $slider_block['media_type'] ) ? $slider_block['media_type'] : '',
											'image'      => isset( $slider_block['image'] ) ? $slider_block['image'] : '',
											'caption'    => isset( $slider_block['caption'] ) ? $slider_block['caption'] : '',
											'video_type' => isset( $slider_block['video_type'] ) ? $slider_block['video_type'] : '',
											'video'      => isset( $slider_block['video'] ) ? $slider_block['video'] : '',
											'slider'     => isset( $slider_block['slider'] ) ? $slider_block['slider'] : array(),
										)
									);
									?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
	<div class="block-sticky-media-content-split__content">
		<InnerBlocks
			template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
			allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
		/>
	</div>
</section>
