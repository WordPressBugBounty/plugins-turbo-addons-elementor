(function(factory){
  if (typeof jQuery !== 'undefined') {
    factory(jQuery);
  } else {
    document.addEventListener('DOMContentLoaded', function(){ factory(window.jQuery); });
  }
})(function($){

  // --- Helper: safely read widget settings ---
function getWidgetSettings($widget){
  var s = $widget.data('settings') || {};
  var id = $widget.data('id');

  // ✅ 1st fallback — elementor.elements.models (older)
  if (!s || $.isEmptyObject(s)) {
    try {
      if (id && window.elementor && elementor.elements && elementor.elements.models) {
        var model = elementor.elements.models.find(function(m){ return m && m.id === id; });
        if (model && model.attributes && model.attributes.settings) {
          s = model.attributes.settings.attributes || {};
        }
      }
    } catch(e) {
      console.warn('[Tooltip DEBUG] old model lookup failed:', e);
    }
  }

  // ✅ 2nd fallback — elementor.documents.getCurrent()
  if ((!s || $.isEmptyObject(s)) && window.elementor && elementor.documents) {
    try {
      var containers = elementor.documents.getCurrent().containers;
      if (containers) {
        containers.forEach(function(c){
          if (c.id === id && c.settings) {
            s = c.settings.attributes || {};
          }
        });
      }
    } catch(e){
      console.warn('[Tooltip DEBUG] document container lookup failed:', e);
    }
  }

  // ✅ 3rd fallback — elementorFrontend.config.elements.data (very new)
  if ((!s || $.isEmptyObject(s)) && elementorFrontend && elementorFrontend.config && elementorFrontend.config.elements) {
    try {
      var data = elementorFrontend.config.elements.data;
      if (data[id] && data[id].attributes && data[id].attributes.settings) {
        s = data[id].attributes.settings || {};
      }
    } catch(e){
      console.warn('[Tooltip DEBUG] frontend config lookup failed:', e);
    }
  }

  return s || {};
}


  // --- Create tooltip if missing ---
  function ensureTooltip($widget){
    var s = getWidgetSettings($widget);

    if (!s || s.trad_enable_tooltip !== 'yes') {
      return;
    }

    var $container = $widget.find('> .elementor-widget-container').first();
    if (!$container.length) $container = $widget;

    var $existing = $container.find('> .trad-tooltip');
    if (!$existing.length) {
      var $span = $('<span/>', {
        'class': 'trad-tooltip',
        'data-position': s.trad_tooltip_position || 'top',
        'data-trigger': s.trad_tooltip_trigger || 'hover',
        'text': s.trad_tooltip_text || 'This is a tooltip!'
      });
      $container.append($span);
    } else {
    }

    bindTooltip($widget);
  }

  // --- Bind hover/click logic ---
  function bindTooltip($widget){
    var $tips = $widget.find('> .elementor-widget-container > .trad-tooltip, > .trad-tooltip');
    if (!$tips.length) {
      return;
    }

    $widget.off('.taTip'); // prevent duplicates

    $tips.each(function(){
      var $t = $(this);
      var trigger = $t.data('trigger') || 'hover';

      if (trigger === 'hover') {
        $widget.on('mouseenter.taTip', function(){ $t.addClass('tooltip-active'); })
               .on('mouseleave.taTip', function(){ $t.removeClass('tooltip-active'); });
      } else {
        $widget.on('click.taTip', function(e){
          e.stopPropagation();
          $('.trad-tooltip[data-trigger="click"]').not($t).removeClass('tooltip-active');
          $t.toggleClass('tooltip-active');
        });
      }
    });

    // Hide on outside click (click trigger only)
    $(document).off('click.taTipHide').on('click.taTipHide', function(e){
      if (!$(e.target).closest('.elementor-widget').length) {
        $('.trad-tooltip[data-trigger="click"]').removeClass('tooltip-active');
      }
    });
  }

  // --- Initialize all widgets in a given scope ---
  function initScope($scope){
    var $widgets = $scope.find('.elementor-widget').addBack('.elementor-widget');
    $widgets.each(function(){ ensureTooltip($(this)); });
  }

  // Elementor lifecycle
  $(window).on('elementor/frontend/init', function(){
    elementorFrontend.hooks.addAction('frontend/element_ready/global', initScope);
    elementorFrontend.hooks.addAction('frontend/element_ready/section', initScope);
    elementorFrontend.hooks.addAction('frontend/element_ready/column', initScope);

    // Force run after initial render
    setTimeout(function(){ 
      initScope($(document)); 
    }, 500);
  });

  // Watch DOM changes (safety)
  try {
    var mo = new MutationObserver(function(muts){
      for (var i=0;i<muts.length;i++){
        if (muts[i].addedNodes && muts[i].addedNodes.length){
          initScope($(document));
          break;
        }
      }
    });
    mo.observe(document.documentElement, { childList: true, subtree: true });
  } catch(e) {
    console.warn('[Tooltip DEBUG] MutationObserver failed:', e);
  }
});
