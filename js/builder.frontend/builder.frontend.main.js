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

/**
 * Scroll editing page to the content page area (skipping header section).
 *
 * Don't user document.ready
 * as we need all styles/images loaded before scrolling.
 */
jQuery(window).load(function($) {
	var mainContentBlock = jQuery('#dslc-main');
	// Condition fixes issues/756.
	if ( mainContentBlock.length ) {
		var scrollTo = mainContentBlock.offset().top;
		if ( scrollTo ) {
			jQuery('html, body').animate({
				scrollTop: scrollTo
			}, 1000);
		}
	}
});
