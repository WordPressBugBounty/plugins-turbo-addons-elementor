/* global jQuery */
(function ($) {
  'use strict';

  function initInstance(root) {
    if (!root) return;

    var track   = root.querySelector('.track');
    var wrap    = track ? track.parentElement : null;
    var cards   = track ? Array.prototype.slice.call(track.children) : [];
    var prevBtn = root.querySelector('[data-trad-prev]');
    var nextBtn = root.querySelector('[data-trad-next]');
    var dotsBox = root.querySelector('.dots');

    if (!wrap || !cards.length) return;

    var showDots      = root.getAttribute('data-show-dots') === 'yes';
    var showArrows    = root.getAttribute('data-show-arrows') === 'yes';
    var autoplay      = root.getAttribute('data-autoplay') === 'yes';
    var autoplaySpeed = parseInt(root.getAttribute('data-autoplay-speed'), 10) || 3000;
    var pauseOnHover  = root.getAttribute('data-pause-on-hover') === 'yes';
    var loop          = root.getAttribute('data-loop') === 'yes';

    if (!showArrows) {
      if (prevBtn) prevBtn.style.display = 'none';
      if (nextBtn) nextBtn.style.display = 'none';
    }

    var isMobile      = function () { return window.matchMedia('(max-width:767px)').matches; };
    var supportsHover = function () { return window.matchMedia('(hover:hover)').matches; };

    // Build dots
    if (showDots && dotsBox) {
      dotsBox.innerHTML = '';
      cards.forEach(function (_, i) {
        var dot = document.createElement('span');
        dot.className = 'dot';
        dot.addEventListener('click', function () { activate(i, true); });
        dotsBox.appendChild(dot);
      });
    }
    var dots = dotsBox ? Array.prototype.slice.call(dotsBox.children) : [];

    var current = 0;
    var autoplayTimer = null;

    function slideMobile(i) {
      var sliderW = wrap.clientWidth;
      track.style.transform = 'translateX(-' + (i * sliderW) + 'px)';
    }

    function slideDesktop(i) {
      var card = cards[i];
      if (!card) return;
      var start = card.offsetLeft;
      wrap.scrollTo({ left: start - (wrap.clientWidth / 2 - card.clientWidth / 2), behavior: 'smooth' });
    }

    function center(i) {
      if (isMobile()) {
        slideMobile(i);
      } else {
        track.style.transform = '';
        slideDesktop(i);
      }
    }

    function toggleUI(i) {
      cards.forEach(function (c, k) { c.toggleAttribute('active', k === i); });
      if (dots.length) dots.forEach(function (d, k) { d.classList.toggle('active', k === i); });
      if (!loop) {
        if (prevBtn) prevBtn.disabled = (i === 0);
        if (nextBtn) nextBtn.disabled = (i === cards.length - 1);
      } else {
        if (prevBtn) prevBtn.disabled = false;
        if (nextBtn) nextBtn.disabled = false;
      }
    }

    function activate(i, scroll) {
      if (i < 0 || i > cards.length - 1) return;
      current = i;
      toggleUI(i);
      if (scroll) center(i);
    }

    function go(step) {
      var next = current + step;
      if (loop) {
        next = ((next % cards.length) + cards.length) % cards.length;
      } else {
        next = Math.min(Math.max(next, 0), cards.length - 1);
      }
      if (next === current) return;
      activate(next, true);
    }

    function startAutoplay() {
      if (!autoplay) return;
      stopAutoplay();
      autoplayTimer = setInterval(function () { go(1); }, autoplaySpeed);
    }
    function stopAutoplay() {
      if (autoplayTimer) { clearInterval(autoplayTimer); autoplayTimer = null; }
    }

    if (autoplay) {
      startAutoplay();
      if (pauseOnHover) {
        root.addEventListener('mouseenter', stopAutoplay, { passive: true });
        root.addEventListener('mouseleave', startAutoplay, { passive: true });
      }
    }

    if (prevBtn) prevBtn.addEventListener('click', function () { go(-1); });
    if (nextBtn) nextBtn.addEventListener('click', function () { go(1); });

    var hot = false;
    root.addEventListener('mouseenter', function () { hot = true; }, { passive: true });
    root.addEventListener('mouseleave', function () { hot = false; }, { passive: true });
    root.addEventListener('focusin',  function () { hot = true; });
    root.addEventListener('focusout', function () { hot = false; });
    document.addEventListener('keydown', function (e) {
      if (!hot) return;
      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') go(1);
      if (e.key === 'ArrowLeft'  || e.key === 'ArrowUp')   go(-1);
    }, { passive: true });

    cards.forEach(function (card, i) {
      card.addEventListener('mouseenter', function () {
        if (!isMobile() && supportsHover()) activate(i, true);
      }, { passive: true });
      card.addEventListener('click', function () {
        if (!isMobile()) activate(i, true);
      });
    });

    var sx = 0, sy = 0;
    track.addEventListener('touchstart', function (e) {
      sx = e.touches[0].clientX;
      sy = e.touches[0].clientY;
    }, { passive: true });
    track.addEventListener('touchend', function (e) {
      var dx = e.changedTouches[0].clientX - sx;
      var dy = e.changedTouches[0].clientY - sy;
      if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy)) {
        go(dx > 0 ? -1 : 1);
      }
    }, { passive: true });

    window.addEventListener('resize', function () { center(current); });

    toggleUI(0);
    center(0);
  }

  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/trad-accordion-slider.default', function ($scope) {
      var root = $scope[0].querySelector('.trad-accordion-slider');
      initInstance(root);
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.trad-accordion-slider').forEach(initInstance);
  });

})(jQuery);
