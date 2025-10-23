<?php
/**
 * Slider Pagination partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'total_slides'  => null,
		'display_count' => true,
	)
);
?>

<div class="slider-pagination">
	<div class="slider-pagination__arrows">
		<button class="slider-pagination__button slider-pagination__button--prev" aria-label="<?= esc_attr__( 'Previous slide', 'impulse' ); ?>"></button>
		<button class="slider-pagination__button slider-pagination__button--next" aria-label="<?= esc_attr__( 'Next slide', 'impulse' ); ?>"></button>
	</div>
	<?php if ( is_numeric( $args['total_slides'] ) && true === $args['display_count'] ) : ?>
		<div class="slider-pagination__numbers">
			<span class="slider-pagination__current">1</span>
			<span class="slider-pagination__divider">/</span>
			<span class="slider-pagination__total"><?= esc_html( $args['total_slides'] ); ?></span>
		</div>
	<?php endif; ?>
</div>
