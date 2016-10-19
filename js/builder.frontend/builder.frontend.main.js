/**
 * Action - Disable links from going anywhere in editing mode.
 */
jQuery(document).on( 'click', 'a:not(.dslca-link)', function(e){

	e.preventDefault();
});


/**
 * Echoes in the iframe triggered in the parent page events.
 * The triggerend events can be used by 3-rd party developers.
 */
function dslca_publish_event( eventName, eventData ) {

	eventData = eventData ? eventData : {};

	jQuery(document).trigger( {
		type: eventName,
		message: {details: eventData}
	} );
}