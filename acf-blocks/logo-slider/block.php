<?php
/**
 * Logo Slider Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

// InnerBlocks templating.
$allowed_blocks = get_allowed_content_blocks();
$template       = array(
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Lorem Ipsum Dolor',
			'fontSize'    => 'supertext',
			'align'       => 'center',
		),
	),
);

$logos = get_field( 'logos' );

// Set block classes.
$block_classes  = 'acf-block block-logo-slider';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<div class="container">
		<div class="block-logo-slider__content cms">
			<InnerBlocks
				template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
				allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
			/>
		</div>
		<div class="logo-slider">
			<button
				class="logo-slider__button logo-slider__button--prev"
				aria-label="Previous slide"
			></button>
			<div class="logo-slider__wrapper swiper">
				<div class="logo-slider__slides swiper-wrapper">
					<?php foreach ( $logos as $logo ) : ?>
						<div class="logo-slide swiper-slide">
							<?php
							echo wp_get_attachment_image(
								$logo,
								'3x2-md',
								false,
								array( 'class' => 'logo-slide__img' )
							);
							?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<button
				class="logo-slider__button logo-slider__button--next"
				aria-label="Next slide"
			></button>
		</div>
	</div>
</section>
