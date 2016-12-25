
/*********************************
 *
 * = UI - SCROLLER =
 *
 ***********************************/


/** Window Y-scroller */
jQuery(document).ready(function($){

	/** Scroll preview area when mouse are on some distant of edge */
	/*
	LiveComposer.Builder.UI.initPreviewAreaScroller = function() {

		var pxInTik = 5;
		var timerTik = 6;
		LiveComposer.Builder.State.windowScroller = false;

		/** Stop scroll if within areas */
		// jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragleave','.lc-scroll-top-area, .lc-scroll-bottom-area', function(e) {

		// 	// LiveComposer.Builder.UI.stopScroller();
		// });

		/** Scroll bottom */
		// jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragenter dragover','.lc-scroll-bottom-area', function(e) {

		// 	if( LiveComposer.Builder.State.windowScroller !== false ) return false;

		// 	LiveComposer.Utils.publish('LC.sortableOff', {});

		// 	LiveComposer.Builder.State.windowScroller = setInterval(function(){

		// 		LiveComposer.Builder.PreviewAreaWindow.scrollBy(0 , pxInTik);
		// 	}, timerTik);
		// });

		/** Scroll top */
		// jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragenter','.lc-scroll-top-area', function(e) {

		// 	if( LiveComposer.Builder.State.windowScroller !== false ) return false;

		// 	LiveComposer.Utils.publish('LC.sortableOff', {});

		// 	LiveComposer.Builder.State.windowScroller = setInterval(function(){

		// 		LiveComposer.Builder.PreviewAreaWindow.scrollBy(0 , -pxInTik);
		// 	}, timerTik);
		// });

		/** Stop scroll if click or drag ended *//*
		jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragend mouseup', 'body', function(e) {

			// LiveComposer.Builder.State.windowScroller && LiveComposer.Builder.UI.stopScroller();
		});
	};
	*/

});