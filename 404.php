<?php
/**
 * WordPress 404 file.
 *
 * @package imp
 */

get_header();
$content_404 = get_field( 'content_404', 'option' );
?>

<main class="page-content">
	<div class="container">
		<?php
		if ( is_a( $content_404, 'WP_Post' ) ) {
			echo apply_filters( 'the_content', $content_404->post_content ); // phpcs:ignore
		} else {
			echo apply_filters( // phpcs:ignore
				'the_content',
				'<!-- wp:acf/content-404 {"name":"acf/content-404","data":{"uid":"65490e916e617"},"mode":"preview"} -->
				<!-- wp:heading {"level":1} -->
				<h1 class="wp-block-heading">404</h1>
				<!-- /wp:heading -->

				<!-- wp:heading {"fontSize":"t5"} -->
				<h2 class="wp-block-heading has-t-5-font-size">Page not found</h2>
				<!-- /wp:heading -->

				<!-- wp:paragraph -->
				<p>You can try searching for what you’re looking for below.</p>
				<!-- /wp:paragraph -->

				<!-- wp:acf/search-bar -->
				<!-- /wp:acf/search-bar -->
				<!-- /wp:acf/content-404 -->'
			);
		}
		?>
	</div>
</main>

<?php
get_footer();
