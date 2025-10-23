<?php
/**
 * Video Inline partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'video_url' => '',
		'autoplay'  => false,
		'id'        => md5( random_bytes( 10 ) ),
	)
);

$component_classes = 'video-inline';

if ( $args['autoplay'] ) {
	$component_classes .= ' video-inline--autoplay';
}
?>

<div class="<?= esc_attr( $component_classes ); ?>" id="<?= esc_attr( $args['id'] ); ?>">
	<?php
	if ( ! $args['autoplay'] ) {
		echo get_autoplay_ready_embed( $args['video_url'] );
	} elseif ( str_contains( $args['video_url'], 'wistia' ) ) {
		wp_enqueue_script( 'wistia-api' );
		// TODO: Add wistia play/pause controls.
		$video_id = imp_get_wistia_video_id( $args['video_url'] );
		?>
		<div
			class="video-inline__embed wistia_embed wistia_async_<?= esc_attr( $video_id ); ?> autoplay=true muted=true endVideoBehavior=loop fitStrategy=cover playbar=false volumeControl=false settingsControl=false fullscreenButton=false playButton=false smallPlayButton=false"
		></div>
		<?php
	} elseif ( str_contains( $args['video_url'], 'vimeo' ) ) {
		// wp_enqueue_script( 'vimeo-player' );
		// TODO: Add wistia play/pause controls.
		echo imp_get_autoplay_embed( $args['video_url'], true );
	}
	?>
</div>
