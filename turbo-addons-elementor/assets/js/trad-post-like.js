(function ($) {
    'use strict';

    /**
     * Get or create voter ID (cookie-based)
     * Used only for identifying user (guest-safe)
     */
    function getVoterId() {
        const match = document.cookie.match(/trad_voter_id=([^;]+)/);
        if (match) {
            return match[1];
        }

        const id = 'v_' + Math.random().toString(36).slice(2) + Date.now();
        document.cookie = "trad_voter_id=" + id + "; path=/; max-age=31536000";
        return id;
    }

    /**
     * Load ONLY active vote state
     * ❌ Do NOT update counts here (HTML already correct & cache-safe)
     */
    function loadVoteState(wrapper) {

        $.post(tradPostLike.ajaxurl, {
            action: 'trad_get_vote_counts',
            nonce: tradPostLike.nonce,
            post_id: wrapper.data('post-id'),
            voter_id: getVoterId()
        }, function (res) {

            if (!res || !res.success) return;

            wrapper.find('.trad-post-like-btn').removeClass('active');

            if (res.data.active === 'like') {
                wrapper.find('.trad-like-btn').addClass('active');
            }

            if (res.data.active === 'unlike') {
                wrapper.find('.trad-unlike-btn').addClass('active');
            }
        });
    }

    /**
     * Handle Like / Unlike click
     * ✅ Update count + active state (live)
     */
    $(document).on('click', '.trad-post-like-btn', function () {

        const wrapper = $(this).closest('.trad-post-like-wrapper');
        const vote = $(this).hasClass('trad-like-btn') ? 'like' : 'unlike';

        // UX loading state
        wrapper.find('.count').css('opacity', 0.6);

        $.post(tradPostLike.ajaxurl, {
            action: 'trad_post_vote',
            nonce: tradPostLike.nonce,
            post_id: wrapper.data('post-id'),
            vote: vote,
            voter_id: getVoterId()
        }, function (res) {

            if (!res || !res.success) return;

            // ✅ Update counts (only after click)
            wrapper.find('.trad-like-btn .count').text(res.data.like);
            wrapper.find('.trad-unlike-btn .count').text(res.data.unlike);

            // ✅ Update active state
            wrapper.find('.trad-post-like-btn').removeClass('active');

            if (res.data.active === 'like') {
                wrapper.find('.trad-like-btn').addClass('active');
            }

            if (res.data.active === 'unlike') {
                wrapper.find('.trad-unlike-btn').addClass('active');
            }

            // UX restore
            wrapper.find('.count').css('opacity', 1);
        });
    });

    /**
     * On page load:
     * 👉 Only sync active state (NOT counts)
     */
    $(document).ready(function () {
        $('.trad-post-like-wrapper').each(function () {
            loadVoteState($(this));
        });
    });

})(jQuery);