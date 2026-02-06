<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// action for post read/view counter///
if ( ! function_exists( 'trad_set_post_views' ) ) {
	function trad_set_post_views( $postID ) {
		$count = (int) get_post_meta( $postID, 'trad_post_views_count', true );
		$count++;
		update_post_meta( $postID, 'trad_post_views_count', $count );
	}
	function trad_track_post_views() {
		if ( is_single() ) {
			global $post;
			if ( $post ) {
				trad_set_post_views( $post->ID );
			}
		}
	}
	add_action( 'wp_head', 'trad_track_post_views' );
}
