<?php
/**
 * Image Slider partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'images'           => array(),
		'image_size'       => '16x9-md',
		'display_captions' => false,
		'display_count'    => true,
	)
);

if ( is_array( $args['images'] ) && ! empty( $args['images'] ) ) :
	?>

	<div class="image-slider swiper">
		<div class="image-slider__slides swiper-wrapper">
			<?php if ( is_array( $args['images'] ) ) : ?>
				<?php foreach ( $args['images'] as $image ) : ?>
					<div class="image-slider__slide swiper-slide">
						<?php
						echo wp_get_attachment_image(
							$image,
							$args['image_size'],
							false,
							array( 'class' => 'image-slider__image' ),
						);
						?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php if ( true === $args['display_captions'] && is_array( $args['images'] ) ) : ?>
			<?php if ( is_array( $args['images'] ) ) : ?>
				<div class="image-slider__captions">
					<?php
					foreach ( $args['images'] as $key => $image ) :
						$caption = wp_get_attachment_caption( $image );
						if ( ! empty( $caption ) ) :
							?>
							<span class="image-slider__caption image-slider__caption--<?= esc_attr( $key ); ?> <?= 0 === $key ? 'image-slider__caption--active' : null; ?> cms">
								<?= esc_html( $caption ); ?>
							</span>
							<?php
						endif;
					endforeach;
					?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
		get_component(
			'slider-pagination',
			array(
				'total_slides'  => count( $args['images'] ),
				'display_count' => $args['display_count'],
			)
		);
		?>
	</div>
	<?php
endif;
