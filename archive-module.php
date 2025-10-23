<?php
/**
 * WordPress index file.
 *
 * @package imp
 */

get_header();

$modules = get_posts(
	array(
		'post_type'      => 'module',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

/**
 * Is Module Visible
 *
 * @param string $module_id  Module post ID.
 * @return boolean
 */
function is_module_visible( $module_id ) {
	// phpcs:ignore
	if ( ! isset( $_GET['modules'] ) ) {
		return true;
	}

	// phpcs:ignore
	$modules = explode( '-', $_GET['modules'] );
	return in_array( '' . $module_id, $modules, true );
}
?>

<div class="module-library">

	<div class="module-library-menu">
		<ul class="module-library-menu__list">
			<?php
			foreach ( $modules as $module ) :
				$is_checked = is_module_visible( $module->ID );
				?>

				<li class="module-library-menu__list-item">
					<input
						class="module-library-menu__input"
						id="module-<?= esc_attr( $module->ID ); ?>"
						type="checkbox"
						value="<?= esc_attr( $module->ID ); ?>"
						<?= $is_checked ? 'checked' : ''; ?>
					/>

					<label class="module-library-menu__label" for="module-<?= esc_attr( $module->ID ); ?>">
						<?= esc_html( $module->post_title ); ?>
					</label>
				</li>

				<?php
			endforeach;
			?>
		</ul>

		<button class="module-library-menu__edit-module-link">Edit Module</button>
	</div>

	<div class="page-content">
		<?php
		foreach ( $modules as $module ) {
			$blocks     = parse_blocks( $module->post_content );
			$is_visible = is_module_visible( $module->ID );

			foreach ( $blocks as $block ) {
				$html = trim( render_block( $block ) );
				$html = preg_replace( '/^(<[a-zA-Z0-9]+)/m', '$1 data-module-id="' . $module->ID . '"', $html );
				if ( ! $is_visible ) {
					$html = preg_replace( '/^(<[a-zA-Z0-9]+)/m', '$1 data-visible="false"', $html );
				} else {
					$html = preg_replace( '/^(<[a-zA-Z0-9]+)/m', '$1 data-visible="true"', $html );
				}

				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $html;
			}
		}
		?>
	</div>
</div>

<?php
get_footer();
