/* global jQuery */
(function ($) {
  'use strict';

  function initModal(cfg) {
    var id      = cfg.id;
    var overlay = document.getElementById(id + '-overlay');
    var modal   = document.getElementById(id + '-modal');
    if (!overlay || !modal) return;

    if (cfg.preview) {
      overlay.classList.add('trad-mp--preview', 'trad-mp--open');
      return;
    }

    function open() {
      if (cfg.cookies && getCookie('trad_mp_' + id)) return;
      overlay.classList.add('trad-mp--open');
      overlay.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      overlay.querySelectorAll('.trad-mp__video-iframe').forEach(function (iframe) {
        var dataSrc = iframe.getAttribute('data-src');
        if (dataSrc && iframe.getAttribute('src') !== dataSrc) {
          iframe.setAttribute('src', dataSrc);
        }
      });
    }

    function close() {
      overlay.classList.remove('trad-mp--open');
      overlay.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      overlay.querySelectorAll('.trad-mp__video-iframe').forEach(function (iframe) {
        iframe.removeAttribute('src');
      });
      if (cfg.cookies) setCookie('trad_mp_' + id, '1', cfg.cookieDays);
    }

    var trigger = cfg.trigger;

    if (trigger === 'on_load' || trigger === 'after_time') {
      setTimeout(open, (cfg.delay || 0) * 1000);
    } else if (trigger === 'exit_intent') {
      document.addEventListener('mouseleave', function handler(e) {
        if (e.clientY <= 0) { open(); document.removeEventListener('mouseleave', handler); }
      });
    }

    document.querySelectorAll('[data-modal="' + id + '"]').forEach(function (el) {
      if (!el.classList.contains('trad-mp__close')) {
        el.addEventListener('click', function (e) { e.preventDefault(); open(); });
      }
    });

    overlay.querySelectorAll('.trad-mp__close').forEach(function (btn) {
      btn.addEventListener('click', close);
    });

    if (cfg.closeOnOver) {
      overlay.addEventListener('click', function (e) {
        if (e.target === overlay) close();
      });
    }

    if (cfg.closeOnEsc) {
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('trad-mp--open')) close();
      });
    }
  }

  function setCookie(name, value, days) {
    var d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = name + '=' + value + ';expires=' + d.toUTCString() + ';path=/';
  }
  function getCookie(name) {
    var v = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return v ? v.pop() : '';
  }

  function initAll() {
    (window.tradModalQueue || []).forEach(initModal);
    window.tradModalQueue = { push: initModal };
  }

  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/trad-modal-popup.default', function () {
      initAll();
    });
  });

  document.addEventListener('DOMContentLoaded', initAll);

})(jQuery);
