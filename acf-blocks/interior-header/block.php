<?php
/**
 * Interior Header Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block       = new ACF_Block( $block, $wp_block );
$show_breadcrumb = get_field( 'show_breadcrumb' );
$media_type      = get_field( 'media_type' );
$image           = get_field( 'image' );
$video_type      = get_field( 'video_type' );
$video           = get_field( 'video' );
$has_media       = false;

$template = array(
	array(
		'core/heading',
		array(
			'content' => 'Nisi ut mauris mauris erat',
			'level'   => 1,
		),
	),
	array(
		'core/paragraph',
		array(
			'content' => 'Massa vel sapien pellentesque vulputate lectus. Ut semper sit morbi tempus porta elementum. Elementum sed sed mauris semper faucibus pretium leo.',
		),
	),
	array(
		'acf/buttons',
		array(
			'data' => array(
				'buttons' => array(
					array(
						'link'  => array(
							'title'  => 'Learn More',
							'url'    => '#',
							'target' => '',
						),
						'style' => 'btn-primary',
					),
					array(
						'link'  => array(
							'title'  => 'Learn More',
							'url'    => '#',
							'target' => '',
						),
						'style' => 'btn-secondary',
					),
				),
			),
		),
	),
);

$allowed_blocks = array(
	...get_allowed_content_blocks(),
	'acf/breadcrumbs',
);

$block_classes  = 'acf-block block-interior-header';
$block_classes .= $acf_block->get_settings_classes( true );

if (
	( 'image' === $media_type && ! empty( $image ) ) ||
	( 'video' === $media_type && ! empty( $video ) )
) {
	$has_media      = true;
	$block_classes .= ' block-interior-header--has-media';
} else {
	$block_classes .= ' block-interior-header--no-media';
}
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="block-interior-header__wrapper container">
		<div class="block-interior-header__content">
			<?php if ( 'enabled' === $show_breadcrumb ) : ?>
				<div class="block-interior-header__breadcrumb">
					<?php get_component( 'breadcrumbs' ); ?>
				</div>
			<?php endif; ?>
			<div class="block-interior-header__content-inner cms">
				<InnerBlocks
					template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
					allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
				/>
			</div>
		</div>
		<?php if ( $has_media ) : ?>
			<div class="block-interior-header__media">
				<?php
				get_component(
					'media',
					array(
						'image_size' => '16x9-lg',
						'media_type' => $media_type,
						'image'      => $image,
						'video_type' => $video_type,
						'video'      => $video,
					)
				);
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
