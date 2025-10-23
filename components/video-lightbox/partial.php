<?php
/**
 * Video Lightbox partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'video_url' => '',
		'id'        => uniqid(),
	)
);

$modal_id = $args['id'];
$embed    = get_autoplay_ready_embed( $args['video_url'] );

if ( ! empty( $embed ) ) {
	add_action(
		'wp_footer',
		function () use ( $modal_id, $embed ) {
			?>
			<div class="modal micromodal-slide" id="<?= esc_attr( $modal_id ); ?>" aria-hidden="true">
				<div class="modal__overlay" tabindex="-1" data-micromodal-close>
					<div class="container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
						<button class="modal__close" aria-label="<?= esc_attr__( 'Close modal', 'impulse' ); ?>" data-micromodal-close></button>
						<?= $embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			</div>
			<?php
		}
	);
}
