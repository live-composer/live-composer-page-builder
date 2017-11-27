/**
 * Editor messages
 */

var massagesTicker = jQuery('#editor-messages').newsTicker({
    row_height: 40,
    max_rows: 2,
    speed: 900,
    direction: 'up',
    duration: 12000,
    autostart: 1,
    pauseOnHover: 1,
    start: function() {
        jQuery('#editor-messages').css('opacity', '1');
    },
});

jQuery(document).ready(function($){

    $(document).on( 'click', '.dslc-editor-messages-hide', function(e){

        var hide_panel = $('.dslc-editor-messages-hide').data('can-hide');

        if ( hide_panel == '1' ) {
            jQuery.post(

                DSLCAjax.ajaxurl,
                {
                    action : 'dslc-ajax-hidden-panel',
                }
            );

            $('.dslc-editor-messages-section').css('display', 'none');
            $('.dslca-container').removeClass( "active-message-panel" );
        } else {
            $('#editor-messages').html('<div class="dslc-notice"><a href="https://livecomposerplugin.com/downloads/extensions/?utm_source=editing-sreen&utm_medium=editor-messages&utm_campaign=add-ons" target="_blank">You can hide this panel once you have any of our premium extensions installed.</a></div>');
        }
    });

    /**
     * Hide Panel
     */

    if ( $('div.dslc-editor-messages-section').length ) {
        $('.dslc-editor-messages-section').css('display', 'block');
        $('.dslca-container').addClass( "active-message-panel" );
    }

});