jQuery(document).ready(function($){
    // Handle click trigger tooltips
    $(document).on('click', '.elementor-widget', function(e){
        var $widget = $(this);
        var $tooltip = $widget.find('.trad-tooltip[data-trigger="click"]');

        if ($tooltip.length) {
            e.stopPropagation();

            if ($tooltip.hasClass('tooltip-active')) {
                $tooltip.removeClass('tooltip-active');
            } else {
                // Close all others
                $('.trad-tooltip[data-trigger="click"]').removeClass('tooltip-active');
                $tooltip.addClass('tooltip-active');
            }
        }
    });

    // Hide when clicking outside
    $(document).on('click', function(e){
        if (!$(e.target).closest('.elementor-widget').length) {
            $('.trad-tooltip[data-trigger="click"]').removeClass('tooltip-active');
        }
    });
});
