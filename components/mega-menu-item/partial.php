<?php
/**
 * Mega Menu Item partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'post_id'    => '',
		'title'      => '',
		'menu_class' => '',
	)
);

$menu_item   = get_fields( $args['post_id'] );
$current_url = home_url( add_query_arg( array(), $wp->request ) );

$link_classes = '';

if ( isset( $menu_item['overview']['link']['url'] ) ) {
	if ( ! empty( $args['menu_class'] ) ) {
		$link_classes .= "{$args['menu_class']}__nav-link {$args['menu_class']}__nav-link--depth-1";
	}

	if ( untrailingslashit( $menu_item['overview']['link']['url'] ) === untrailingslashit( $current_url ) ) {
		$link_classes .= " {$args['menu_class']}__nav-link--current-page";
	}
	?>

	<a class="<?= esc_attr( $link_classes ); ?>" href="<?= esc_url( $menu_item['overview']['link']['url'] ); ?>">
		<span><?= esc_html( $args['title'] ); ?></span>
	</a>
	<section class="mm-dropdown">
		<button class="sr-only" data-mega-menu-back tabindex="-1">Back to menu</button>
		<div class="mm-dropdown__wrapper">
			<div class="mm-dropdown__overview">
				<?php if ( ! empty( $menu_item['overview']['link'] || ! empty( $menu_item['overview']['title'] ) ) ) : ?>
					<h1 class="mm-dropdown__title">
						<?= $menu_item['overview']['link'] ? '<a href="' . esc_url( $menu_item['overview']['link']['url'] ) . '"' . ( $menu_item['overview']['link']['target'] ? ' target="_blank"' : '' ) . '>' : ''; ?>
							<?= esc_html( $menu_item['overview']['title'] ); ?>
						<?= $menu_item['overview']['link'] ? '</a>' : ''; ?>
					</h1>
				<?php endif; ?>
				<?php if ( ! empty( $menu_item['overview']['description'] ) ) : ?>
					<p class="mm-dropdown__description"><?= esc_html( $menu_item['overview']['description'] ); ?></p>
				<?php endif; ?>
				<div class="mm-dropdown__button-container">
					<?php if ( ! empty( $menu_item['overview']['link'] ) ) : ?>
						<?= array_to_link( $menu_item['overview']['link'], 'mm-dropdown__button btn-secondary btn-small' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="mm-dropdown__items-wrapper">
				<ul class="mm-dropdown-items" style="--cols: <?= esc_attr( $menu_item['columns'] ? $menu_item['columns'] : '' ); ?>">
					<?php foreach ( $menu_item['sub_menus'] as $sub_menu ) : ?>
						<li class="mm-dropdown-items__item">
							<a class="mm-dropdown-items__item-link" href="<?= esc_url( $sub_menu['sub_menu_link']['url'] ); ?>" target="<?= esc_attr( $sub_menu['sub_menu_link']['target'] ); ?>"><span><?= esc_html( $sub_menu['sub_menu_link']['title'] ); ?></span></a>
							<div class="mm-dropdown-items__wrapper">
								<ul class="mm-dropdown-items__links">
									<?php
									foreach ( $sub_menu['links'] as $link_item ) :
										$nav_link    = $link_item['link'];
										$description = $link_item['description'];
										?>
										<li class="mm-dropdown-items__link">
											<a class="mm-dropdown-items__nav-link" href="<?= esc_url( $nav_link['url'] ); ?>" target="<?= esc_attr( $nav_link['target'] ); ?>">
												<span>
													<h3 class="mm-dropdown-items__title"><?= esc_html( $nav_link['title'] ); ?></h3>
													<p class="mm-dropdown-items__description"><?= esc_html( $description ); ?></p>
												</span>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>
	<?php
}
