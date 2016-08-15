
/*********************************
 *
 * = UI - SCROLLER =
 *
 ***********************************/

/**
 * SCROLLER - Document Ready
 */
jQuery(document).ready(function($){

	/**
	 * Scroll list of modules with a mouse wheel.
	 */
	var deltaKoef = .75;
	var increment = 500;
	var scroller = jQuery('.dslca-section-scroller');
	var scrollInner = jQuery('.dslca-section-scroller-inner', this)[0];

	jQuery('.dslca-section-scroller').on( 'wheel', function(event) {

		scroll_to( event.originalEvent.deltaY || event.originalEvent.deltaX );

		return false;
	});

	/**
	 * Scroll to delta
	 *
	 * @param  {int} delta
	 */
	function scroll_to(delta) {

		delta = delta * deltaKoef;

		var lisdtWidth = parseInt(scroller.find('.dslca-section-scroller-content').width() || 0);

		if ( lisdtWidth <= window.innerWidth - 260 ) return false;

		var scrollMax = lisdtWidth - window.innerWidth + 240;
		delta = parseInt(scrollInner.style.left || 0) - delta;
		delta = delta >= 0 ? 0 : delta;
		delta = delta <= -scrollMax ? -scrollMax : delta;

		scrollInner.style.left = delta + 'px';
	}

	/**
	 * Hook - Scroller Prev
	 */
	jQuery(document).on( 'click', '.dslca-section-scroller-prev', function(e){

		e.preventDefault();
		scroll_to( -increment );
	});

	/**
	 * Hook - Scroller Next
	 */
	jQuery(document).on( 'click', '.dslca-section-scroller-next', function(e){

		e.preventDefault();
		scroll_to( increment );
	});

	jQuery(window).load(function(){

		// Initiate scroller on window resize
		jQuery(window).resize(function(){

			scroll_to( 0 );
		});
	});
});

/** Window Y-scroller */
jQuery(document).ready(function($){

	/** Scroll preview area when mouse are on some distant of edge */
	LiveComposer.Builder.UI.initPreviewAreaScroller = function() {

		var pxInTik = 3;
		var timerTik = 5;

		LiveComposer.Builder.Flags.windowScroller = false;
		jQuery(LiveComposer.Builder.PreviewAreaDocument).on('drag', 'body', function(e) {

			if (LiveComposer.Builder.Flags.windowScroller != false) clearInterval(LiveComposer.Builder.Flags.windowScroller);

			LiveComposer.Builder.Flags.windowScroller = setInterval(function(){

				if ( e.clientY < 180 ) {

					LiveComposer.Builder.PreviewAreaWindow.scrollBy(0, -pxInTik);
				}

				if ( e.clientY > window.innerHeight - 260 ) {

					LiveComposer.Builder.PreviewAreaWindow.scrollBy(0 ,pxInTik);
				}
			}, timerTik);
		});

		jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragend mouseup', 'body', function(e) {

			if( LiveComposer.Builder.Flags.windowScroller ) clearInterval(LiveComposer.Builder.Flags.windowScroller);
		});
	};
});