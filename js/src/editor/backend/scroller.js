
/*********************************
 *
 * = UI - SCROLLER =
 *
 ***********************************/

/** Scroll preview area when mouse are on some distant of edge */
export const initPreviewAreaScroller = () => {

	var pxInTik = 5;
	var timerTik = 6;
	LiveComposer.Builder.Flags.windowScroller = false;

	/** Stop scroll if within areas */
	jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragleave','.lc-scroll-top-area, .lc-scroll-bottom-area', function(e) {

		LiveComposer.Builder.UI.stopScroller();
	});

	/** Scroll bottom */
	jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragenter dragover','.lc-scroll-bottom-area', function(e) {

		if( LiveComposer.Builder.Flags.windowScroller !== false ) return false;

		LiveComposer.Utils.publish('LC.sortableOff', {});

		LiveComposer.Builder.Flags.windowScroller = setInterval(function(){

			LiveComposer.Builder.PreviewAreaWindow.scrollBy(0 , pxInTik);
		}, timerTik);
	});

	/** Scroll top */
	jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragenter','.lc-scroll-top-area', function(e) {

		if( LiveComposer.Builder.Flags.windowScroller !== false ) return false;

		LiveComposer.Utils.publish('LC.sortableOff', {});

		LiveComposer.Builder.Flags.windowScroller = setInterval(function(){

			LiveComposer.Builder.PreviewAreaWindow.scrollBy(0 , -pxInTik);
		}, timerTik);
	});

	/** Stop scroll if click or drag ended */
	jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragend mouseup', 'body', function(e) {

		LiveComposer.Builder.Flags.windowScroller && LiveComposer.Builder.UI.stopScroller();
	});
};

/** Window Y-scroller */
jQuery(document).ready(function($){

	initPreviewAreaScroller();
	/**
	 * Stops scroller function
	 */
	LiveComposer.Builder.UI.stopScroller = function() {

		LiveComposer.Utils.publish('LC.sortableOn', {});

		clearInterval(LiveComposer.Builder.Flags.windowScroller);
		LiveComposer.Builder.Flags.windowScroller = false;
	}

	jQuery("#scroller-stopper").on('dragover', function(){

		LiveComposer.Builder.UI.stopScroller();
	});
});