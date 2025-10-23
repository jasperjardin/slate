<?php
/**
 * Theme header file
 *
 * Scripts/styles should be enqueued via includes/scripts.php
 *
 * @package imp
 */

$header_phone   = get_field( 'phone_number', 'options' );
$header_logo    = get_field( 'header_logo', 'options' );
$header_buttons = get_field( 'header_buttons', 'options' ) ?: array();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'site-wrapper' ); ?>>
	<?php wp_body_open(); ?>

	<a href="#main-content" class="skip-link">Skip to main content</a>

	<header class="main-header">
		<div class="utility-nav" data-theme="light">
			<div class="container">
				<div class="utility-nav__wrapper">
					<?php
					if ( has_nav_menu( 'header_utility' ) ) {
						wp_nav_menu(
							array(
								'container'      => '',
								'menu_class'     => 'utility-nav-menu',
								'theme_location' => 'header_utility',
								'depth'          => 1,
							)
						);
					}
					?>
					<?php if ( ! empty( $header_phone ) ) : ?>
						<a class="utility-nav__contact" href="tel:<?= esc_attr( $header_phone ); ?>"><span class="icon-phone"></span><?= esc_html( $header_phone ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="main-header__row">
			<div class="container">
				<div class="main-header__wrapper">
					<div class="main-header__logo-container">
						<button class="main-header__back-btn" data-mega-menu-back tabindex="-1">
							<span><?= esc_html__( 'Back to Main Menu', 'impulse' ); ?></span>
						</button>
						<?php if ( ! empty( $header_logo ) ) : ?>
							<a href="<?= esc_url( home_url() ); ?>" class="main-header__logo" aria-label="<?= esc_attr__( 'Home', 'impulse' ); ?>">
								<?= wp_get_attachment_image( $header_logo, 'medium' ); ?>
							</a>
						<?php endif; ?>
					</div>
					<div class="main-header__mobile-nav-buttons">
						<a
							href="<?= esc_url( home_url( '/?s=' ) ); ?>"
							class="mobile-menu-search"
						>
							<span class="icon-search"></span>
							<span class="sr-only"><?= esc_html__( 'Search', 'impulse' ); ?></span>
						</a>
						<button class="mobile-menu-trigger" aria-label="<?= esc_attr__( 'Menu', 'impulse' ); ?>">
							<span class="sr-only"><?= esc_html__( 'Menu', 'impulse' ); ?></span>
							<span class="mobile-menu-icon">
								<span class="mobile-menu-icon__line"></span>
								<span class="mobile-menu-icon__line"></span>
								<span class="mobile-menu-icon__line"></span>
							</span>
						</button>
					</div>
					<div class="main-header__menu">
						<nav class="main-header__nav" aria-label="<?= esc_attr__( 'Menu', 'impulse' ); ?>">
							<div class="main-header__nav-wrapper">
								<?php
								wp_nav_menu(
									array(
										'walker'         => new Main_Nav_Walker_Menu(),
										'container'      => '',
										'menu_class'     => 'header-nav-menu',
										'theme_location' => 'header_nav',
										'depth'          => 2,
									)
								);
								?>
								<a
									href="<?= esc_url( home_url( '/?s=' ) ); ?>"
									class="main-header__desktop-search"
								>
									<span class="icon-search"></span>
									<span class="sr-only">Search</span>
								</a>
								<?php foreach ( $header_buttons as $button ) : ?>
									<div class="main-header__additional-links">
										<?= array_to_link( $button['link'], $button['style'] ); ?>
									</div>
								<?php endforeach; ?>
								<div class="main-header__mobile-utility">
									<?php
									if ( has_nav_menu( 'header_utility' ) ) {
										wp_nav_menu(
											array(
												'container' => '',
												'menu_class' => 'utility-nav-menu',
												'theme_location' => 'header_utility',
												'depth' => 1,
											)
										);
									}
									?>
									<?php if ( ! empty( $header_phone ) ) : ?>
										<a class="utility-nav__contact" href="tel:<?= esc_attr( $header_phone ); ?>"><span class="icon-phone"></span><?= esc_html( $header_phone ); ?></a>
									<?php endif; ?>
								</div>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>
	<main id="main-content">
