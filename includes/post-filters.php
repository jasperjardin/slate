<?php
/**
 * Post filters hooks
 *
 * @package imp
 */

add_filter( 'post_filters_archive/post_data', 'imp_pf_post_data' );

/**
 * Modify post data
 *
 * @param array $post_data PF Post data.
 * @return array
 */
function imp_pf_post_data( $post_data ) {
	$post_data['category'] = get_primary_term( $post_data['ID'] );
	return $post_data;
}
