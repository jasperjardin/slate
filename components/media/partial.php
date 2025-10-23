<?php
/**
 * Media partial.
 *
 * @param array $args Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'image'      => 0,
		'image_size' => '3x2-md',
		'media_type' => 'image',
		'video'      => '',
		'video_type' => '',
		'slider'     => array(),
		'caption'    => '',
	)
);

if ( is_single() && '3x2-md' === $args['image_size'] ) {
	$args['image_size'] = '3x2-blog';
}

$unique_id = wp_unique_id();

$component_classes  = 'component-media';
$component_classes .= ' component-media--' . esc_attr( $args['media_type'] );
$component_classes .= ! empty( $args['video_type'] ) ? ' component-media--video-' . esc_attr( $args['video_type'] ) : '';
?>
<figure class="<?= esc_attr( $component_classes ); ?>">
	<?php
	if ( 'slider' === $args['media_type'] ) {
		get_component(
			'image-slider',
			array(
				'images'           => $args['slider'],
				'image_size'       => '16x9-md',
				'display_captions' => true,
				'display_count'    => false,
			)
		);
	} else {
		if ( 'inline-auto' !== $args['video_type'] ) :
			?>
			<div class="component-media__image">
				<?php
				if ( 'inline-auto' !== $args['video_type'] ) {
					echo wp_get_attachment_image( $args['image'], $args['image_size'] );
				}

				if ( 'lightbox' === $args['video_type'] ) {
					get_component(
						'video-control',
						array(
							'hover_text' => false,
							'sr_text'    => __( 'Play Video', 'impulse' ),
							'atts'       => array(
								'data-micromodal-trigger' => 'modal-' . $unique_id,
							),
						)
					);
				}
				?>
			</div>

			<?php if ( ! empty( $args['caption'] ) ) : ?>
				<figcaption class="component-media__caption"><?= esc_html( $args['caption'] ); ?></figcaption>
			<?php endif; ?>
			<?php
		elseif ( is_admin() ) :
			get_component(
				'edit-acf-block',
				array( 'title' => __( 'Media', 'impulse' ) )
			);
		endif;

		if ( 'video' === $args['media_type'] && ! empty( $args['video'] ) ) {
			if ( 'lightbox' === $args['video_type'] ) {
				get_component(
					'video-lightbox',
					array(
						'video_url' => $args['video'],
						'id'        => 'modal-' . $unique_id,
					)
				);
			}

			if ( 'inline' === $args['video_type'] ) {
				$video_id = 'wistia_' . md5( random_bytes( 10 ) );

				get_component(
					'video-inline',
					array(
						'video_url' => $args['video'],
						'autoplay'  => false,
						'id'        => $video_id,
					)
				);

				get_component(
					'video-control',
					array(
						'classes'    => 'video-inline__play',
						'sr_text'    => __( 'Play Video', 'impulse' ),
						'hover_text' => false,
						'atts'       => array(
							'data-video-id' => $video_id,
						),
					)
				);
			}

			if ( 'inline-auto' === $args['video_type'] && ! is_admin() ) {
				get_component(
					'video-inline',
					array(
						'video_url' => $args['video'],
						'autoplay'  => true,
					)
				);
			}
		}
	}
	?>
</figure>
