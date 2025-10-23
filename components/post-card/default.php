<?php
/**
 * Default post card layout
 *
 * @var WP_Post     $post_object WP_Post object to use for the card.
 * @var string|null $theme       Theme style to use for the card.
 *
 * @package imp
 */

$permalink = get_permalink( $post_object );
$thumb     = get_post_thumbnail_id( $post_object );
$category  = get_primary_term( $post_object );
$excerpt   = $post_object->post_excerpt;

// Get the view "link" text.
$post_type_obj = get_post_type_object( $post_object->post_type );
$view_text     = 'post' === $post_object->post_type ? 'View Article' : "View {$post_type_obj->labels->singular_name}";

// Set the theme if one provided.
$data_theme = $theme ? ' data-theme="' . esc_html( $theme ) . '"' : '';
?>

<a class="post-card" href="<?= esc_url( $permalink ); ?>"<?= $data_theme; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<figure class="post-card__figure">
		<?= wp_get_attachment_image( $thumb, '16x9-md' ); ?>
	</figure>

	<div class="post-card__content cms">
		<?php if ( ! empty( $category ) ) : ?>
			<p class="post-card__tag"><?= esc_html( $category->name ); ?></p>
		<?php endif; ?>

		<h3 class="post-card__title"><?= esc_html( $post_object->post_title ); ?></h3>

		<?php if ( ! empty( $excerpt ) ) : ?>
			<p class="post-card__excerpt">
				<?= esc_html( $excerpt ); ?>
			</p>
		<?php endif; ?>

		<div class="post-card__spacer"></div>

		<p class="post-card__btn"><?= esc_html( $view_text ); ?></p>
	</div>
</a>
