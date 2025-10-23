<?php
/**
 * WordPress index file.
 *
 * @package imp
 */

get_header();
?>

<div class="page-content">
	<?php
	if ( ! post_password_required( $post ) ) {
		the_content();
	} else {
		get_component( 'password-form' );
	}
	?>
</div>

<?php
get_footer();
