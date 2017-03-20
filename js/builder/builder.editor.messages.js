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

    /**
     * If any our add-ons are not installed.
     */

    $(document).on( 'click', '.dslc-editor-messages-hide', function(e){


        var hide_panel = $('.dslc-editor-messages-hide').data('can-hide');

        if ( hide_panel == '1' ) {
            $('.dslc-editor-messages-section').css('display', 'none');
            $('.dslca-container').removeClass( "active-message-panel" );
        } else {
            /*$('.dslc-editor-messages-section').css('display', 'block');
            $('.dslca-container').addClass( "active-message-panel" );*/

            $('#editor-messages').html('<div class="dslc-notice"><a href="https://livecomposerplugin.com/add-ons/?utm_source=editing-sreen&utm_medium=editor-messages&utm_campaign=add-ons" target="_blank">You can hide this panel once you have any of our premium add-ons installed.</a></div>');
        }
    });

    $('.dslc-editor-messages-section').css('display', 'block');
    $('.dslca-container').addClass( "active-message-panel" );

    /**
     * Hide Panel
     */

/*    var hide_panel = $('.dslc-editor-messages-hide').data('can-hide');

    if ( hide_panel == '1' ) {
        $('.dslc-editor-messages-section').css('display', 'none');
        $('.dslca-container').removeClass( "active-message-panel" );
    } else {
        $('.dslc-editor-messages-section').css('display', 'block');
        $('.dslca-container').addClass( "active-message-panel" );
    }*/
});