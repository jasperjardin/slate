<?php
/**
 * WordPress author file.
 *
 * @package imp
 */

get_header();

$author_id   = get_the_author_meta( 'ID' );
$author_name = get_the_author_meta( 'display_name' );
$author_img  = get_field( 'author_image', 'user_' . $author_id ) ?: 0;
$author_bio  = get_field( 'author_bio', 'user_' . $author_id ) ?: '';

$author_posts_intro_title = sprintf(
	/* translators: %s is the name of the author. */
	__( 'Explore posts by %s', 'impulse' ),
	$author_name
);
?>

<div class="page-content">
	<section class="author-content">
		<div class="container">
			<div class="author-content__wrapper">
				<?php if ( ! empty( $author_img ) ) : ?>
					<figure class="author-content__img-container">
						<?php
						echo wp_get_attachment_image(
							$author_img,
							'1x1-md',
							false,
							array(
								'class' => 'author-content__img',
							)
						);
						?>
					</figure>
				<?php endif; ?>
				<div class="author-content__content">
					<div class="author-content__tag"><?= esc_html__( 'Author', 'impulse' ); ?></div>
					<h1 class="author-content__name">
						<?= esc_html( $author_name ); ?>
					</h1>
					<div class="author-content__bio cms">
						<?= wp_kses_post( $author_bio ); ?>
					</div>
					<?php
					get_component(
						'social-share',
						array(
							'show_label' => false,
						)
					);
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
	get_component(
		'author-posts-intro',
		array(
			'subtitle' => __( 'Recent Posts', 'impulse' ),
			'title'    => $author_posts_intro_title,
			'theme'    => 'light',
		)
	);
	?>
	<section class="block-post-filters-archive acf-block" data-theme="light">
		<div class="container">
			<?php
			get_component(
				'post-filters-archive',
				array(
					'post_author'     => $author_id,
					'pagination_type' => 'numbered_pagination',
					'posts_per_page'  => 9,
				)
			);
			?>
		</div>
	</section>
</div>

<?php

get_footer();
