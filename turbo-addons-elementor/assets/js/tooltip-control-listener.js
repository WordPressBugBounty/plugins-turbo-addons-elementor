(function($){
  $(window).on('elementor:init', function(){

    // Listen to any control value change
    elementor.channels.editor.on('change', function(view){
      try {
        var controlName = view.model.get('name');
        var value = view.getControlValue ? view.getControlValue() : null;

        // 🔹 Controls that should trigger re-render
        var tooltipControls = [
          'trad_enable_tooltip',
          'trad_tooltip_trigger',
          'trad_tooltip_text',
          'trad_tooltip_position'
        ];

        // If current control is one of the tooltip controls
        if (tooltipControls.includes(controlName)) {

          // Get the widget model from panel
          var panelView = elementor.panel.currentView;
          if (!panelView || !panelView.content || !panelView.content.currentView) {
            console.warn('[Turbo Tooltip] No active panel view found');
            return;
          }

          var model = panelView.content.currentView.getOption('model');
          if (!model) {
            console.warn('[Turbo Tooltip] No widget model found');
            return;
          }

          // ✅ Elementor 3.20+ re-render method
          if (model && model.renderRemoteServer) {
            model.renderRemoteServer();
          } 
          // ✅ Fallback older Elementor (local re-render)
          else if (model && model.render) {
            model.render();
          } 
          // ✅ Oldest fallback (Elementor <3.10)
          else {
            elementor.channels.data.trigger('element:rerender', { model: model });
          }
        }

      } catch (e) {
        console.warn('[Turbo Tooltip] Listener error:', e);
      }
    });
  });
})(jQuery);
