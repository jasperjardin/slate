<?php
/**
 * Case study card small
 *
 * @var array $args  Passed args, expects post_id
 *
 * @package imp
 */

$args = wp_parse_args(
	$args,
	array(
		'title' => '',
	)
);
?>

<div class="edit-acf-block">
	<h3 class="edit-acf-block__title"><?= esc_html( $args['title'] ); ?></h3>
	<button class="components-button is-primary">Edit Block</button>
</div>
