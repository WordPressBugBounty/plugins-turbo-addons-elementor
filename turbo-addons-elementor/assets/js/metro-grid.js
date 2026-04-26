/**
 * Turbo Addons - Metro Grid Widget
 */

(function ($) {
    'use strict';

    class TradMetroGrid {
        constructor(scope) {
            this.$scope = scope;
            this.$wrapper = scope.find('.trad-metro-grid-wrapper');
            this.$container = scope.find('.trad-metro-grid-container');
            this.onClickAction = this.$wrapper.data('on-click');
            this.enableHover = this.$wrapper.data('enable-hover');
            this.enableHoverTablet = this.$wrapper.data('enable-hover-tablet');
            this.enableHoverMobile = this.$wrapper.data('enable-hover-mobile');
            this.items = [];
            this.currentIndex = 0;

            this.init();
        }

        init() {
            this.collectItems();
            this.bindEvents();
            this.handleResponsiveHover();
        }

        collectItems() {
            const self = this;
            this.$container.find('.trad-metro-grid-item').each(function (index) {
                const $item = $(this);
                self.items.push({
                    index: index,
                    element: $item,
                    mediaType: $item.data('media-type'),
                    imageSrc: $item.data('image-src'),
                    videoSrc: $item.data('video-src'),
                    videoType: $item.data('video-type'),
                    title: $item.data('title'),
                    description: $item.data('description'),
                });
            });
        }

        bindEvents() {
            const self = this;

            // Click events
            this.$container.find('.trad-metro-grid-item').on('click', function (e) {
                if ($(e.target).hasClass('trad-metro-grid-link')) return;

                const $item = $(this);
                const index = parseInt($item.data('index'));

                if (self.onClickAction === 'lightbox') {
                    self.openLightbox(index);
                }
            });

            // Video icon click
            this.$container.find('.trad-metro-grid-video-icon').on('click', function (e) {
                e.stopPropagation();
                const $item = $(this).closest('.trad-metro-grid-item');
                const index = parseInt($item.data('index'));
                self.openLightbox(index);
            });
        }

        handleResponsiveHover() {
            const self = this;
            const $items = this.$container.find('.trad-metro-grid-item');

            const checkHover = () => {
                const width = window.innerWidth;
                let enableHover = self.enableHover;

                if (width <= 480) {
                    enableHover = self.enableHoverMobile;
                } else if (width <= 1024) {
                    enableHover = self.enableHoverTablet;
                }

                if (enableHover === 'yes' || enableHover === true) {
                    $items.addClass('trad-hover-enabled');
                } else {
                    $items.removeClass('trad-hover-enabled');
                    // Show overlay always on mobile if hover disabled
                    $items.find('.trad-metro-grid-overlay').css({
                        'transform': 'none',
                        'opacity': '1',
                        'visibility': 'visible',
                    });
                }
            };

            checkHover();
            $(window).on('resize', checkHover);
        }

        openLightbox(index) {
            const item = this.items[index];
            if (!item) return;

            this.currentIndex = index;

            // Remove existing lightbox
            $('.trad-metro-lightbox-overlay').remove();

            let mediaHTML = '';

            if (item.mediaType === 'video') {
                if (item.videoType === 'youtube') {
                    const videoId = this.getYouTubeId(item.videoSrc);
                    mediaHTML = `<iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allowfullscreen style="width:80vw;height:45vw;max-height:80vh;"></iframe>`;
                } else if (item.videoType === 'vimeo') {
                    const videoId = this.getVimeoId(item.videoSrc);
                    mediaHTML = `<iframe src="https://player.vimeo.com/video/${videoId}?autoplay=1" frameborder="0" allowfullscreen style="width:80vw;height:45vw;max-height:80vh;"></iframe>`;
                } else {
                    mediaHTML = `<video src="${item.videoSrc}" controls autoplay style="max-width:90vw;max-height:80vh;"></video>`;
                }
            } else {
                mediaHTML = `<img src="${item.imageSrc}" alt="${item.title || ''}">`;
            }

            const lightboxHTML = `
                <div class="trad-metro-lightbox-overlay">
                    <div class="trad-metro-lightbox-inner">
                        <button class="trad-metro-lightbox-close">&times;</button>
                        ${mediaHTML}
                    </div>
                    <button class="trad-metro-lightbox-prev"><i class="fas fa-chevron-left"></i></button>
                    <button class="trad-metro-lightbox-next"><i class="fas fa-chevron-right"></i></button>
                </div>
            `;

            $('body').append(lightboxHTML);

            setTimeout(() => {
                $('.trad-metro-lightbox-overlay').addClass('active');
            }, 10);

            this.bindLightboxEvents();
        }

        bindLightboxEvents() {
            const self = this;

            // Close
            $(document).on('click.trad-lightbox', '.trad-metro-lightbox-close', function () {
                self.closeLightbox();
            });

            // Close on overlay click
            $(document).on('click.trad-lightbox', '.trad-metro-lightbox-overlay', function (e) {
                if ($(e.target).hasClass('trad-metro-lightbox-overlay')) {
                    self.closeLightbox();
                }
            });

            // Prev
            $(document).on('click.trad-lightbox', '.trad-metro-lightbox-prev', function () {
                self.navigateLightbox(-1);
            });

            // Next
            $(document).on('click.trad-lightbox', '.trad-metro-lightbox-next', function () {
                self.navigateLightbox(1);
            });

            // Keyboard
            $(document).on('keydown.trad-lightbox', function (e) {
                if (e.key === 'Escape') self.closeLightbox();
                if (e.key === 'ArrowLeft') self.navigateLightbox(-1);
                if (e.key === 'ArrowRight') self.navigateLightbox(1);
            });
        }

        navigateLightbox(direction) {
            let newIndex = this.currentIndex + direction;
            if (newIndex < 0) newIndex = this.items.length - 1;
            if (newIndex >= this.items.length) newIndex = 0;
            this.closeLightbox();
            setTimeout(() => this.openLightbox(newIndex), 300);
        }

        closeLightbox() {
            const $overlay = $('.trad-metro-lightbox-overlay');
            $overlay.removeClass('active');
            setTimeout(() => {
                $overlay.remove();
                // Stop video
                $overlay.find('video').each(function () {
                    this.pause();
                });
                $overlay.find('iframe').attr('src', '');
            }, 300);
            $(document).off('.trad-lightbox');
        }

        getYouTubeId(url) {
            const match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
            return match ? match[1] : '';
        }

        getVimeoId(url) {
            const match = url.match(/vimeo\.com\/(\d+)/);
            return match ? match[1] : '';
        }
    }

    // Initialize on Elementor frontend
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/turbo-metro-grid.default', function ($scope) {
            new TradMetroGrid($scope);
        });
    });

    // Initialize on regular page load
    $(document).ready(function () {
        $('.trad-metro-grid-wrapper').each(function () {
            const $scope = $(this).closest('.elementor-widget');
            if ($scope.length) {
                new TradMetroGrid($scope);
            }
        });
    });

})(jQuery);
