(function ($) {
    "use strict";
    var tradAudioPlayer = function ( $scope, $ ){
        var container_elem = $scope.find('.trad-audio-player-wrapper').eq(0);
        if ( container_elem.length > 0 ) {
            container_elem[0].style.display='flex';
            var settings = container_elem.data('audio-settings');
            var icons = container_elem.data('player-icons');
            var activeUniqClass = container_elem.find('.trad-audio-player');
            activeUniqClass.mediaelementplayer({
                 shimScriptAccess: "always",
                 alwaysShowControls: true,
                features: settings['features'],
                 hideVolumeOnTouchDevices: settings['hideVolumeOnTouchDevices'] === 'true',
                 startVolume: parseFloat( settings['startVolume'] ),
                 audioVolume: settings['audioVolume'],
                 autoRewind: true,
                 enableAutosize: true,
                 stretching: 'auto',
                 classPrefix: 'mejs-',
                 enableKeyboard: true,
                 pauseOtherPlayers: true,
                 duration: -1,
                 success: function (mediaElement, originalNode, instance) {
                     mediaElement.setCurrentTime( parseFloat( settings['restrictTime'] ) );
         
                     mediaElement.addEventListener('progress', function() {
                         const duration = mediaElement.duration;
                         const durationContainer = $(mediaElement).siblings('.mejs__time-total').find('.mejs__duration');
                         if (durationContainer.length > 0) {
                             durationContainer.text(mediaElement.formatTime(duration));
                         }
                     });
         
                     if (mediaElement) {
                        mediaElement.load();
                    }

                    // Initialize volume slider after player is ready
                    setTimeout(function() {
                        if (settings['audioVolume'] === 'vertical') {
                            container_elem.find('.mejs-volume-button').addClass('vertical-volume');
                        } else {
                            container_elem.find('.mejs-volume-button').addClass('horizontal-volume');
                        }
                    }, 100);
                 }
             });

             if( icons ){
                let playPauseButton = container_elem.find(".mejs-playpause-button button"),
                volumeButtion = container_elem.find(".mejs-volume-button button");
                playPauseButton.html(`
                    <i aria-hidden="true" class="trad-audio-play ${icons.play}"></i>
                    <i aria-hidden="true" class="trad-audio-pause ${icons.pause}"></i>
                    <i aria-hidden="true" class="trad-audio-replay ${icons.replay}"></i>
                `),
                volumeButtion.html(`
                    <i aria-hidden="true" class="trad-audio-unmute ${icons.unmute}"></i>
                    <i aria-hidden="true" class="trad-audio-mute ${icons.mute}"></i>
                `);
             }

             // Apply volume layout classes
             if (settings['audioVolume'] === 'vertical') {
                 container_elem.find('.mejs-volume-button').addClass('vertical-volume');
             } else {
                 container_elem.find('.mejs-volume-button').addClass('horizontal-volume');
             }

             // Handle vertical volume slider functionality
             if (settings['audioVolume'] === 'vertical') {
                 container_elem.find('.mejs-volume-button').on('mouseenter', function() {
                     $(this).find('.mejs-horizontal-volume-slider').show();
                 }).on('mouseleave', function() {
                     $(this).find('.mejs-horizontal-volume-slider').hide();
                 });
             }
       }
 
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/trad-audio-player.default', tradAudioPlayer);
    });      


})(jQuery);