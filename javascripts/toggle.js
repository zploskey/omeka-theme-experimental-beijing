jQuery(document).ready(function() {
    jQuery('.section-toggle').click(function() {
        var collapse_selector = jQuery(this).attr('href');
        var toggle_switch = jQuery(this);

        jQuery(collapse_selector).toggle(0, function() {
            if (jQuery(this).css('display') == 'none') {
                jQuery('#expand-symbol', toggle_switch).html('+');
            } else {
                jQuery('#expand-symbol', toggle_switch).html('-');
            }
        });
    });
});
