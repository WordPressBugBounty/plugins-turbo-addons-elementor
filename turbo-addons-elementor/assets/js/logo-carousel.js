(function ($) {
    'use strict';
    const initLogoCarousel = function ($scope) {
        const $wrap = $scope.find('.trad-carousel-logo');
        if (!$wrap.length) return;

        $wrap.each(function () {
            const $this = $(this);
            const cfg = $this.data('config') || {};
            const $swiper = $this.find('.trad-main-swiper');

            // ✅ Base config
            const opts = {
                slidesPerView: cfg.slidesPerView || 4,
                slidesPerGroup: cfg.slidesPerGroup || 1,
                spaceBetween: 20,
                speed: cfg.speed || 1000,
                loop: !!cfg.loop,
                rtl: !!cfg.rtl,
                breakpoints: cfg.breakpoints || {},
            };

            if (cfg.grid && cfg.grid.rows && cfg.grid.rows > 1) {
                opts.grid = {
                    rows: cfg.grid.rows,
                    fill: cfg.grid.fill || 'row',
                };
                $this.addClass('has-multi-row'); // ✅ add this line
            }

            // ✅ Autoplay
            if (cfg.autoplay) {
                opts.autoplay = {
                    delay: cfg.speed || 2000,
                    disableOnInteraction: false,
                };
            }

            // ✅ Navigation
            if (cfg.arrows) {
                opts.navigation = {
                    prevEl: $this.find('.swiper-button-prev')[0],
                    nextEl: $this.find('.swiper-button-next')[0],
                };
            }

            // ✅ Pagination
            if (cfg.dots) {
                opts.pagination = {
                    el: $this.find('.swiper-pagination')[0],
                    clickable: true,
                };
            }

            // ✅ Initialize Swiper
            const swiper = new Swiper($swiper[0], opts);

            // ✅ Pause on hover
            if (cfg.autoplay && cfg.pauseOnHover) {
                $this.on('mouseenter', () => swiper.autoplay?.stop());
                $this.on('mouseleave', () => swiper.autoplay?.start());
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/trad-logo-carousel.default',
            initLogoCarousel
        );
    });
})(jQuery);
