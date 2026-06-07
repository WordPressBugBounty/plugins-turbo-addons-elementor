(function($){ 
  "use strict";

  function setAccordionHeight($item, open) {
      var $content = $item.find('.trad-advanceaccordion-content');
      if (!$content.length) return;
      var contentEl = $content[0];

      if (open) {
          // Clear previous inline height to measure full content
          contentEl.style.maxHeight = 'none';
          var fullHeight = contentEl.scrollHeight + "px";

          // Reset and force reflow before animation
          contentEl.style.maxHeight = '0px';
          contentEl.offsetHeight;

          // Animate to full height
          contentEl.style.maxHeight = fullHeight;

          // Add open classes
          $item.addClass('trad-advance-accordion-open');
          $content.addClass('advanced-accordion-dynamic-open');

      } else {
          // Collapse smoothly
          // Fix: set explicit pixel height BEFORE removing open class,
          // so the closed-state transition (not the open-state one) runs.
          var currentHeight = contentEl.scrollHeight + "px";
          contentEl.style.maxHeight = currentHeight;
          contentEl.offsetHeight; // force reflow

          // Remove open class NOW so the correct CSS transition kicks in
          $item.removeClass('trad-advance-accordion-open');
          $content.removeClass('advanced-accordion-dynamic-open');

          // Force another reflow so the transition fires from currentHeight → 0
          contentEl.offsetHeight;
          contentEl.style.maxHeight = '0px';
      }
  }

  // Click event toggle
  $(document).on('click', '.trad-advance-accordion-title', function(){
      var $item = $(this).closest('.trad-advance-accordion-item');
      var $title = $(this);

      // If already open → close it
      if ($item.hasClass('trad-advance-accordion-open')) {
          setAccordionHeight($item, false);
          $title.removeClass('trad-advance-accordion-title-active');
      } else {
          // Close others
          $item.siblings('.trad-advance-accordion-item.trad-advance-accordion-open').each(function(){
              setAccordionHeight($(this), false);
              $(this).find('.trad-advance-accordion-title').removeClass('trad-advance-accordion-title-active');
          });

          // Open clicked
          setAccordionHeight($item, true);
          $title.addClass('trad-advance-accordion-title-active');
      }
  });

  // ✅ Utility to open default active items
  function openDefaultAccordionItems($scope) {
      $scope.find('.trad-advance-accordion-item.trad-advance-accordion-open').each(function(){
          var $content = $(this).find('.trad-advanceaccordion-content')[0];
          if ($content) {
              $content.style.maxHeight = $content.scrollHeight + "px";
          }
          $(this).find('.trad-advance-accordion-title').addClass('trad-advance-accordion-title-active');
          $(this).find('.trad-advanceaccordion-content').addClass('advanced-accordion-dynamic-open');
      });
  }

  // ✅ Run on frontend load (normal site)
  $(window).on('load', function(){
      openDefaultAccordionItems($(document));
  });

  // ✅ Run on Elementor Editor when widget is ready
  $(window).on('elementor/frontend/init', function(){
      elementorFrontend.hooks.addAction('frontend/element_ready/advanced-accordion.default', function($scope){
          openDefaultAccordionItems($scope);
      });
  });

  // ✅ Maintain height on resize
  $(window).on('resize', function(){
      $('.trad-advance-accordion-item.trad-advance-accordion-open .trad-advanceaccordion-content').each(function(){
          this.style.maxHeight = this.scrollHeight + "px";
      });
  });

})(jQuery);
