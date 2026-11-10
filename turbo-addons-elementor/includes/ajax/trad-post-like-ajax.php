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

    // Only published posts of a public post type can be voted on.
    $post = $post_id ? get_post( $post_id ) : null;
    if ( ! $post || 'publish' !== $post->post_status || ! is_post_type_viewable( $post->post_type ) || post_password_required( $post ) ) {
        wp_send_json_error( [ 'message' => 'Invalid post' ], 400 );
    }

    // Validate vote
    if ( empty( $_POST['vote'] ) ) {
        wp_send_json_error([ 'message' => 'Vote missing' ], 400);
    }

    $new_vote = sanitize_key( wp_unslash( $_POST['vote'] ) );
    if ( ! in_array( $new_vote, [ 'like', 'unlike' ], true ) ) {
        wp_send_json_error( [ 'message' => 'Invalid vote' ], 400 );
    }

    /**
     * Identify voter
     */
    if ( is_user_logged_in() ) {

        $voter_id = 'user_' . get_current_user_id();

    } elseif ( ! empty( $_POST['voter_id'] ) ) {

        $voter_id = sanitize_text_field( wp_unslash( $_POST['voter_id'] ) );

        // Must look like the ID created by trad-post-like.js ("v_" + base36 + timestamp).
        if ( ! preg_match( '/^v_[a-z0-9]{6,40}$/', $voter_id ) ) {
            wp_send_json_error( [ 'message' => 'Invalid voter ID' ], 403 );
        }

        // Light flood protection for guests: max 30 votes per IP per 10 minutes.
        $ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
        $rate_key = 'trad_vote_rate_' . md5( $ip . wp_salt( 'nonce' ) );
        $hits     = (int) get_transient( $rate_key );
        if ( $hits >= 30 ) {
            wp_send_json_error( [ 'message' => 'Too many votes, please try again later.' ], 429 );
        }
        set_transient( $rate_key, $hits + 1, 10 * MINUTE_IN_SECONDS );

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

