<?php
/**
 * Social Share partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'permalink'  => get_the_permalink(),
		'title'      => get_the_title(),
		'source'     => get_bloginfo( 'name' ),
		'show_label' => true,
	)
);

$url        = rawurlencode( $args['permalink'] );
$post_title = rawurlencode( $args['title'] );
$site_name  = rawurlencode( $args['source'] );

$facebook_url = "https://www.facebook.com/sharer/sharer.php?u=$url";
$x_url        = "https://twitter.com/intent/tweet?text=$post_title&url=$url&via=$site_name";
$linkedin_url = "https://www.linkedin.com/shareArticle?mini=true&url=$url&title=$post_title&source=$site_name";
$email_url    = "mailto:?subject=$post_title&body=$url";
?>

<div class="social-share">
	<?php if ( $args['show_label'] ) : ?>
		<span>Share</span>
	<?php endif; ?>
	<div class="social-share__icons">
		<a href="<?= esc_url( $facebook_url ); ?>" class="icon-social icon-social--facebook" target="_blank" rel="noopener noreferrer">
			<span class="sr-only"><?= esc_html__( 'Facebook', 'impulse' ); ?></span>
		</a>
		<a href="<?= esc_url( $x_url ); ?>" class="icon-social icon-social--x" target="_blank" rel="noopener noreferrer">
			<span class="sr-only">
				<?php
				/* translators: Social media platform "X". */
				esc_html_e( 'X', 'impulse' );
				?>
			</span>
		</a>
		<a href="<?= esc_url( $linkedin_url ); ?>" class="icon-social icon-social--linkedin" target="_blank" rel="noopener noreferrer">
			<span class="sr-only"><?= esc_html__( 'LinkedIn', 'impulse' ); ?></span>
		</a>
		<a href="<?= esc_url( $email_url ); ?>" class="icon-social icon-social--email" target="_blank" rel="noopener noreferrer">
			<span class="sr-only"><?= esc_html__( 'Email', 'impulse' ); ?></span>
		</a>
	</div>
</div>
