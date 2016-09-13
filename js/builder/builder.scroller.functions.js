
/*********************************
 *
 * = UI - SCROLLER =
 *
 ***********************************/

/**
 * SCROLLER - Document Ready
 */
jQuery(document).ready(function($){

	var scrollerPlugin = function(container){

		/**
		 * Scroll list of modules with a mouse wheel.
		 */
		var deltaKoef = .75;
		var increment = 500;
		var scrollinc = 100;
		var scroller = jQuery('.dslca-section-scroller', container);
		var scrollInner = jQuery('.dslca-section-scroller-inner', container)[0];

		scroller.on( 'wheel', function(event) {

			scroll_to( event.originalEvent.deltaY || event.originalEvent.deltaX );

			return false;
		});

		/**
		 * Scroll to delta
		 *
		 * @param  {int} delta
		 */
		function scroll_to(delta) {

			if (delta < 0 ) {

				delta = -scrollinc;
			} else {

				delta = scrollinc;
			}

			delta = delta * deltaKoef;

			var listWidth = scroller.find('.dslca-section-scroller-content').width();
			var contentWidth = scroller.width();

			if ( listWidth <= contentWidth ) return false;

			var scrollMax = listWidth - contentWidth + 10;

			delta = parseInt(scrollInner.style.left || 0) - delta;
			delta = delta >= 0 ? 0 : delta;
			delta = delta <= -scrollMax ? -scrollMax : delta;

			scrollInner.style.left = delta + 'px';
		}

		/**
		 * Hook - Scroller Prev
		 */
		jQuery('.dslca-section-scroller-prev', container).click(function(e){

			e.preventDefault();
			scroll_to( -increment );
		});

		/**
		 * Hook - Scroller Next
		 */
		jQuery('.dslca-section-scroller-next', container).click(function(e){

			e.preventDefault();
			scroll_to( increment );
		});

		jQuery(window).load(function(){

			// Initiate scroller on window resize
			jQuery(window).resize(function(){

				scroll_to( 0 );
			});
		});
	}

	scrollerPlugin(jQuery('.dslca-section.dslca-modules'));
	scrollerPlugin(jQuery('.dslca-section.dslca-templates-load'));
});

/** Window Y-scroller */
jQuery(document).ready(function($){

	/** Scroll preview area when mouse are on some distant of edge */
	LiveComposer.Builder.UI.initPreviewAreaScroller = function() {

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