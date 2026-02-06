<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
add_action('wp_ajax_trad_post_vote', 'trad_handle_post_vote');
add_action('wp_ajax_nopriv_trad_post_vote', 'trad_handle_post_vote');

function trad_handle_post_vote() {

    check_ajax_referer('trad_post_like_nonce', 'nonce');

    // Validate post ID
    if ( empty( $_POST['post_id'] ) ) {
        wp_send_json_error([ 'message' => 'Post ID missing' ], 400);
    }

    $post_id = absint( wp_unslash( $_POST['post_id'] ) );

    // Validate vote
    if ( empty( $_POST['vote'] ) ) {
        wp_send_json_error([ 'message' => 'Vote missing' ], 400);
    }

    $new_vote = sanitize_text_field( wp_unslash( $_POST['vote'] ) );

    /**
     * Identify voter
     */
    if ( is_user_logged_in() ) {

        $voter_id = 'user_' . get_current_user_id();

    } elseif ( ! empty( $_POST['voter_id'] ) ) {

        $voter_id = sanitize_text_field( wp_unslash( $_POST['voter_id'] ) );

    } else {

        wp_send_json_error([ 'message' => 'Voter ID missing' ], 403);
    }

    $vote_key = 'trad_vote_' . md5( $voter_id );
    $old_vote = get_post_meta( $post_id, $vote_key, true );

    /**
     * Remove old vote
     */
    if ( $old_vote === 'like' ) {
        update_post_meta(
            $post_id,
            '_post_like_count',
            max( 0, (int) get_post_meta( $post_id, '_post_like_count', true ) - 1 )
        );
    }

    if ( $old_vote === 'unlike' ) {
        update_post_meta(
            $post_id,
            '_post_unlike_count',
            max( 0, (int) get_post_meta( $post_id, '_post_unlike_count', true ) - 1 )
        );
    }

    /**
     * Toggle off
     */
    if ( $old_vote === $new_vote ) {

        delete_post_meta( $post_id, $vote_key );

        wp_send_json_success([
            'like'   => (int) get_post_meta( $post_id, '_post_like_count', true ),
            'unlike' => (int) get_post_meta( $post_id, '_post_unlike_count', true ),
            'active' => 'none',
        ]);
    }

    /**
     * Add new vote
     */
    if ( $new_vote === 'like' ) {
        update_post_meta(
            $post_id,
            '_post_like_count',
            (int) get_post_meta( $post_id, '_post_like_count', true ) + 1
        );
    }

    if ( $new_vote === 'unlike' ) {
        update_post_meta(
            $post_id,
            '_post_unlike_count',
            (int) get_post_meta( $post_id, '_post_unlike_count', true ) + 1
        );
    }

    update_post_meta( $post_id, $vote_key, $new_vote );

    wp_send_json_success([
        'like'   => (int) get_post_meta( $post_id, '_post_like_count', true ),
        'unlike' => (int) get_post_meta( $post_id, '_post_unlike_count', true ),
        'active' => $new_vote,
    ]);
}

