<?php
/**
 * Password Form partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

/* translators: Default title for password protected content form. */
$pp_title = get_field( 'pp_title', 'options' ) ?: __( 'Password Protected', 'impulse' );
/* translators: Default subtitle text explaining password requirement for protected content. */
$pp_subtitle = get_field( 'pp_subtitle', 'options' ) ?: __( 'This content is password protected. To view it please enter your password below:', 'impulse' );
$label       = 'pwbox-' . wp_rand();

$is_incorrect_password = isset( $_COOKIE[ 'wp-postpass_' . COOKIEHASH ] ) && post_password_required();
?>

<section class="acf-block password-form">
	<div class="container">
		<div class="password-form__wrapper">
			<div class="password-form__content">
				<span class="icon-lock"></span>
				<?php if ( ! empty( $pp_title ) ) : ?>
					<h1 class="password-form__title t4"><?= esc_html( $pp_title ); ?></h1>
				<?php endif; ?>
				<?php if ( ! empty( $pp_subtitle ) ) : ?>
					<p class="password-form__subtitle"><?= esc_html( $pp_subtitle ); ?></p>
				<?php endif; ?>
			</div>
			<div class="password-form__form">
				<form action="<?= esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" class="post-password-form" method="post">
					<label class="post-password-form__label" for="<?= esc_attr( $label ); ?>"><?= esc_html__( 'Password', 'impulse' ); ?>*</label>
					<input class="post-password-form__input" name="post_password" id="<?= esc_attr( $label ); ?>" type="password" spellcheck="false" size="20" />
					<button class="post-password-form__submit" role="submit" name="Submit"><?= esc_attr_x( 'Enter', 'post password form', 'impulse' ); ?></button>
				</form>
			</div>
			<?php if ( $is_incorrect_password ) : ?>
				<p class="password-form__error"><?= esc_html__( 'The password you entered is incorrect. Please try again.', 'impulse' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
