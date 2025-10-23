<?php
/**
 * Testimonial Slider Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

$testimonials = get_field( 'testimonials' );

// Set block classes.
$block_classes  = 'acf-block block-testimonial-slider';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>">
	<div class="container">
		<div class="testimonial-slider">
			<div class="testimonial-slider__wrapper swiper">
				<div class="testimonial-slider__slides swiper-wrapper">
					<?php foreach ( $testimonials as $testimonial ) : ?>
						<div class="testimonial-slide swiper-slide">
							<p class="testimonial-slide__quote"><?= esc_html( $testimonial['quote'] ); ?></p>
							<div class="testimonial-slide__bottom">
								<?php
								echo wp_get_attachment_image(
									$testimonial['image'],
									'1x1-xs',
									false,
									array( 'class' => 'testimonial-slide__img' )
								);
								?>
								<div class="testimonial-slide__meta">
									<p class="testimonial-slide__name"><?= esc_html( $testimonial['name'] ); ?></p>
									<p class="testimonial-slide__title"><?= esc_html( $testimonial['title'] ); ?></p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="testimonial-pagination">
				<button
					class="testimonial-pagination__button testimonial-pagination__button--prev"
					aria-label="Previous slide"
				></button>
				<button
					class="testimonial-pagination__button testimonial-pagination__button--next"
					aria-label="Next slide"
				></button>
			</div>
		</div>
	</div>
</section>
