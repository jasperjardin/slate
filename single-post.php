<?php
/**
 * WordPress single post file.
 *
 * @package imp
 */

get_header();

$primary_term        = get_primary_term( $post, 'category' );
$author_name         = get_the_author_meta( 'display_name', $post->post_author );
$author_link         = get_author_posts_url( $post->post_author );
$featured_img_id     = get_post_thumbnail_id();
$enable_author_pages = get_field( 'enable_author_pages', 'option' );
?>

<article class="page-content">
	<div class="single-content">
		<header class="single-content__header">
			<?php if ( ! empty( $primary_term ) ) : ?>
				<div class="single-content__tag">
					<span>
						<?= esc_html( $primary_term->name ); ?>
					</span>
				</div>
			<?php endif; ?>
			<h1 class="single-content__title t3">
				<?php the_title(); ?>
			</h1>
			<div class="single-content__meta">
				<time datetime="<?php echo get_the_date( 'c' ); ?>">
					<?php echo get_the_date(); ?>
				</time>
				<span> <span class="single-content__meta-divider">|</span> by
				<?php
				if ( $enable_author_pages ) :
					?>
					<a class="single-content__meta-author" href="<?= esc_url( $author_link ); ?>" target="_self"><?= esc_html( $author_name ); ?></a>
				<?php else : ?>
					<span class="single-content__meta-author"><?= esc_html( $author_name ); ?></span>
					<?php
				endif;
				?>
				</span>
			</div>
			<hr class="wp-block-separator single-content__divider">
		</header>


		<?php if ( $featured_img_id ) : ?>
			<div class="single-content__img">
				<?= wp_get_attachment_image( $featured_img_id, '16x9-blog' ); ?>
			</div>
		<?php endif; ?>

		<div class="single-content__body cms">
			<?php
			the_content();
			get_component( 'social-share' );
			?>
		</div>
	</div>
	<aside class="single-content__additional-content">
		<?php
		$additional_content = get_field( 'single_additional_content', 'option' );
		if ( ! empty( $additional_content ) ) {
			$additional_content_post = get_post( $additional_content );
			if ( is_a( $additional_content_post, 'WP_Post' ) ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo apply_filters( 'the_content', $additional_content_post->post_content );
			}
		}
		?>
	</aside>
</article>

<?php
get_footer();
