<?php
/**
 * Hubspot Form partial.
 *
 * @param array $args  Args passed to template partial.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'section_id'    => '',
		'block_classes' => '',
		'title'         => '',
		'portal_id'     => 0,
		'form_id'       => 0,
	)
);

if ( ( $args['form_id'] && $args['portal_id'] ) || is_admin() ) :
	$block_classes = 'acf-block block-hubspot-form';
	if ( ! empty( $args['block_classes'] ) ) {
		$block_classes .= ' ' . $args['block_classes'];
	}
	?>

	<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $args['section_id'] ); ?>">
		<div class="container">
			<div class="cms">
				<?php if ( ! empty( $args['title'] ) ) : ?>
					<h2 class="block-hubspot-form__title"><?= esc_html( $args['title'] ); ?></h2>
				<?php endif; ?>

				<div data-hubspot-portal-id="<?= esc_attr( $args['portal_id'] ); ?>" data-hubspot-form="<?= esc_attr( $args['form_id'] ); ?>"></div>

				<?php if ( is_admin() ) : ?>
					<strong class="edit-acf-block">Form will be displayed here</strong>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php
endif;
