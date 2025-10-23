<?php
/**
 * Theme footer file
 *
 * Scripts/styles should be enqueued via includes/scripts.php
 *
 * @package imp
 */

$footer_logo       = get_field( 'footer_logo', 'options' );
$footer_address    = get_field( 'address', 'options' );
$footer_phone      = get_field( 'phone_number', 'options' );
$footer_email      = get_field( 'email_address', 'options' );
$footer_socials    = get_field( 'socials', 'options' ) ?: array();
$footer_newsletter = get_field( 'newsletter', 'options' );
$footer_copyright  = get_field( 'copyright', 'options' );
$footer_copyright  = str_replace( '{year}', gmdate( 'Y' ), $footer_copyright );
?>
	</main>
	<footer class="main-footer" data-theme="dark">
		<div class="main-footer__top">
			<div class="container">
				<div class="main-footer__nav">
					<div class="main-footer__logo-box">
						<div class="main-footer__logo-container">
							<?php if ( ! empty( $footer_logo ) ) : ?>
								<a
									href="<?= esc_url( home_url() ); ?>"
									class="main-footer__logo"
									aria-label="<?= esc_attr__( 'Return to homepage', 'impulse' ); ?>"
								>
									<?php
									echo wp_get_attachment_image(
										$footer_logo,
										'medium',
										false,
										array()
									)
									?>
								</a>
							<?php endif; ?>
							<?php if ( ! empty( $footer_address ) ) : ?>
								<div class="main-footer__address">
									<?= wp_kses_post( $footer_address ); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="main-footer__contacts">
							<?php if ( ! empty( $footer_phone ) ) : ?>
								<a class="main-footer__contact" href="tel:<?= esc_attr( $footer_phone ); ?>"><span class="icon-phone"></span><?= esc_html( $footer_phone ); ?></a>
							<?php endif; ?>
							<?php if ( ! empty( $footer_email ) ) : ?>
								<a class="main-footer__contact" href="mailto:<?= esc_attr( $footer_email ); ?>"><span class="icon-email"></span><?= esc_html( $footer_email ); ?></a>
							<?php endif; ?>
						</div>
						<div class="main-footer__socials">
							<?php foreach ( $footer_socials as $social ) : ?>
								<a href="<?= esc_url( $social['url'] ); ?>" class="main-footer__social" target="_blank" rel="noopener"  aria-label="<?= esc_attr( $social['title'] ); ?>">
									<span class='icon-<?= esc_attr( $social['icon'] ); ?>'></span>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="main-footer__nav-box">
						<?php
						if ( has_nav_menu( 'footer_nav_1' ) ) {
							wp_nav_menu(
								array(
									'container'      => '',
									'menu_class'     => 'footer-nav',
									'theme_location' => 'footer_nav_1',
									'depth'          => 2,
								)
							);
						}
						?>
					</div>
					<div class="main-footer__nav-box">
						<?php
						if ( has_nav_menu( 'footer_nav_2' ) ) {
							wp_nav_menu(
								array(
									'container'      => '',
									'menu_class'     => 'footer-nav',
									'theme_location' => 'footer_nav_2',
									'depth'          => 2,
								)
							);
						}
						?>
					</div>
					<div class="main-footer__nav-box">
						<?php
						if ( has_nav_menu( 'footer_nav_3' ) ) {
							wp_nav_menu(
								array(
									'container'      => '',
									'menu_class'     => 'footer-nav',
									'theme_location' => 'footer_nav_3',
									'depth'          => 2,
								)
							);
						}
						?>
					</div>
					<div class="newsletter-box">
						<div class="newsletter-box__content">
							<?php if ( ! empty( $footer_newsletter['heading'] ) ) : ?>
								<h2 class="newsletter-box__heading"><?= esc_html( $footer_newsletter['heading'] ); ?></h2>
							<?php endif; ?>
							<?php if ( ! empty( $footer_newsletter['description'] ) ) : ?>
								<p class="newsletter-box__description"><?= esc_html( $footer_newsletter['description'] ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="main-footer__bottom">
			<div class="container">
				<div class="main-footer__utility">
					<div class="main-footer__utility-col">
						<p class="main-footer__copyright">
							<?= esc_html( $footer_copyright ); ?>
						</p>
					</div>
					<div class="main-footer__utility-col">
						<?php
						if ( has_nav_menu( 'footer_utility' ) ) {
							wp_nav_menu(
								array(
									'container'      => '',
									'menu_class'     => 'footer-utility',
									'theme_location' => 'footer_utility',
								)
							);
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
