<?php
/**
 * Tabs Partial
 *
 * @param array $args The block arguments.
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'section_id'    => '',
		'block_classes' => 'acf-block block-tabs',
		'theme'         => 'light',
		'inner_blocks'  => array(),
	)
);

// InnerBlocks templating.
$allowed_blocks = array( 'acf/tab' );
$template       = array(
	array(
		'acf/tab',
		array(
			'data' => array(
				'title'           => 'Bellow title goes here',
				'open_by_default' => false,
			),
		),
	),
);

$theme = $args['theme'] ? 'data-theme="' . esc_attr( $args['theme'] ) . '"' : '';
?>

<section
	class="<?= esc_attr( $args['block_classes'] ); ?>"
	id="<?= esc_attr( $args['section_id'] ); ?>"
	<?= $theme; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?>
>
	<div class="container">
		<div class="block-tabs__inner">
			<?php if ( ! empty( $args['inner_blocks'] ) ) : ?>
				<div class="block-tabs__tabs" role="tablist" aria-label="Content tabs">
					<?php
					foreach ( $args['inner_blocks'] as $key => $bellow ) :
						$tab_id      = 'tab-block_' . esc_attr( $bellow['block_id'] );
						$panel_id    = 'panel-block_' . esc_attr( $bellow['block_id'] );
						$is_expanded = ! empty( $bellow['open_by_default'] );
						?>
						<button
							class="<?= $is_expanded ? 'block-tabs__tab block-tabs__tab--expanded' : 'block-tabs__tab'; ?>"
							role="tab"
							id="<?= esc_attr( $tab_id ); ?>"
							aria-controls="<?= esc_attr( $panel_id ); ?>"
							aria-selected="<?= $is_expanded ? 'true' : 'false'; ?>"
							<?= ! $is_expanded ? 'tabindex="-1"' : ''; ?>
						>
							<?= esc_html( $bellow['title'] ); ?>
						</button>
						<?php
					endforeach;
					?>
				</div>
			<?php endif; ?>
			<div class="block-tabs__content">
				<InnerBlocks
					template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
					allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
				/>
			</div>
		</div>
	</div>
</section>
