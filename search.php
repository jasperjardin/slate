<?php
/**
 * Search Page Template
 *
 * @package imp
 */

get_header();
?>

<main class="page-content">
	<?php
	get_component(
		'post-filters-archive',
		array(
			'pagination_type'   => 'numbered_pagination',
			'post_type'         => 'any',
			'layout'            => 'search',
			'posts_per_page'    => 9,
			'search_title'      => __( 'Search', 'impulse' ),
			'add_search_to_url' => true,
			'add_page_to_url'   => true,
		)
	)
	?>
</main>


<?php
get_footer();
