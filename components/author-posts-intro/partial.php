<?php
/**
 * Author Posts Intro partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'subtitle' => '',
		'title'    => '',
		'theme'    => 'white',
	)
);
?>

<section class="author-posts-intro acf-block" data-theme="<?= esc_attr( $args['theme'] ); ?>">
	<div class="container cms">
		<?php if ( ! empty( $args['subtitle'] ) ) : ?>
			<p class="author-posts-intro__subtitle supertext"><?= esc_html( $args['subtitle'] ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $args['title'] ) ) : ?>
			<h2 class="author-posts-intro__title t2"><?= esc_html( $args['title'] ); ?></h2>
		<?php endif; ?>
	</div>
</section>
