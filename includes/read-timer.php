<?php
/**
 * Read timer hooks and functions.
 *
 * @package imp
 */

/**
 * Function to calculate the estimated reading time of the given text.
 *
 * @param string $text The text to calculate the reading time for.
 * @param string $wpm The rate of words per minute to use.
 * @return array
 */
function estimate_read_time( $text, $wpm = 200 ) {
	$total_words = str_word_count( wp_strip_all_tags( $text ) );
	$minutes     = floor( $total_words / $wpm );

	return $minutes + 1 . ' Min';
}

/**
 * Set post read time
 *
 * @param integer $post_id WP_Post ID.
 * @return void
 */
function set_post_read_time( int $post_id ) {
	$read_time = get_post_read_time( $post_id, true );
	update_post_meta( $post_id, 'read_time', $read_time );
}
add_action( 'save_post', 'set_post_read_time' );

/**
 * Get Post Read Time
 *
 * @param integer $post_id  WP_Post ID.
 * @param boolean $refresh  Should get new read time.
 * @return string|false
 */
function get_post_read_time( int $post_id, $refresh = false ): string|false {
	$post = get_post( $post_id );

	if ( ! is_a( $post, 'WP_Post' ) ) {
		return false;
	}

	$read_time = get_post_meta( $post_id, 'read_time', true );

	if ( $refresh || ! $read_time ) {
		$content   = apply_filters( 'the_content', $post->post_content );
		$read_time = estimate_read_time( $content );

		if ( ! $refresh ) {
			update_post_meta( $post_id, 'read_time', $read_time );
		}
	}

	return $read_time;
}
