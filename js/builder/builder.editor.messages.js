/**
 * Editor messages
 */

var massagesTicker = jQuery('#editor_messages').newsTicker({
    row_height: 40,
    max_rows: 2,
    speed: 900,
    direction: 'up',
    duration: 12000,
    autostart: 1,
    pauseOnHover: 1,
    start: function() {
        jQuery('#editor_messages').css('opacity', '1');
    },
});