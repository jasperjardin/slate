<?php
/**
 * Form CTA Block
 *
 * @param array      $block      The block settings and attributes.
 * @param string     $content    The block inner HTML (empty).
 * @param bool       $is_preview True during AJAX preview.
 * @param int|string $post_id    The post ID this block is saved to.
 *
 * @package imp
 */

$acf_block = new ACF_Block( $block, $wp_block );

// InnerBlocks templating.
$allowed_blocks = get_allowed_content_blocks();
$template       = array(
	array(
		'core/heading',
		array(
			'placeholder' => 'Nisi ut mauris mauris erat massa vel sapien.',
			'fontSize'    => 't2',
			'level'       => 2,
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Massa vel sapien pellentesque vulputate lectus. Ut semper sit morbi tempus porta elementum. Elementum sed sed mauris semper faucibus pretium leo justo. Viverra sed proin odio elementum aliquet urna neque ultrices.',
		),
	),
);

$form          = get_field( 'form' ) ?? 1;
$form_provider = get_field( 'form_provider' ) ?? '';
$portal_id     = get_field( 'portal_id' ) ?? '';
$form_id       = get_field( 'form_id' ) ?? '';
$headline      = get_field( 'headline' );

// Set block classes.
$block_classes  = 'acf-block block-form-cta';
$block_classes .= $acf_block->get_settings_classes( true );
?>

<section class="<?= esc_attr( $block_classes ); ?>" id="<?= esc_attr( $acf_block->get_id() ); ?>" data-theme="<?= esc_attr( $acf_block->get_theme() ); ?>">
	<div class="container">
		<div class="block-form-cta__wrapper">
			<div class="block-form-cta__subtitle">
				<?php if ( ! empty( $headline ) ) : ?>
					<p class="block-form-cta__supertext">
						<?= esc_html( $headline ); ?>
					</p>
				<?php endif; ?>
			</div>
			<div class="block-form-cta__form-wrapper">
				<div class="block-form-cta__content cms">
					<InnerBlocks
						template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
						allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
					/>
				</div>
				<div class="block-form-cta__form">
					<?php
					if ( ! is_admin() ) {
						if ( 'formidable' === $form_provider && ! empty( $form ) && class_exists( 'FrmFormsController' ) ) {
							echo FrmFormsController::get_form_shortcode( array( 'id' => $form ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						} elseif ( 'hubspot' === $form_provider && ! empty( $portal_id ) && ! empty( $form_id ) ) {
							?>
							<div id="hbspt-form-<?= esc_attr( $acf_block->get_id() ); ?>" class="hbspt-form" data-hubspot-portal-id="<?= esc_attr( $portal_id ); ?>" data-hubspot-form="<?= esc_attr( $form_id ); ?>"></div>
							<?php
						} else {
							echo '<strong>Form not found.</strong>';
						}
					} else {
						$message = 'Form not found';
						if ( 'hubspot' === $form_provider && ! empty( $portal_id ) && ! empty( $form_id ) ) {
							$message = 'Hubspot form will be displayed here';
						} elseif ( 'formidable' === $form_provider && ! empty( $form ) ) {
							$message = 'Formidable form will be displayed here';
						}
						?>
						<strong class="edit-acf-block"><?= esc_html( $message ); ?></strong>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
