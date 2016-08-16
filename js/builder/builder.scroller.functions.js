
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

	function msieversion() {

	    var ua = window.navigator.userAgent;
	    var msie = ua.indexOf("MSIE ");

	    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
	    {
	        return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));
	    }
	    else  // If another browser, return 0
	    {
	        return false;
	    }
	}

	var direction = '';

	/** Scroll preview area when mouse are on some distant of edge */
	LiveComposer.Builder.UI.initPreviewAreaScroller = function() {

		if ( msieversion() !== false ) return false;

		var pxInTik = 5;
		var timerTik = 6;
		var topArea = 80;
		var bottomArea = 140; // Including module panel
		var clientY = false;
		LiveComposer.Builder.Flags.windowScroller = false;

		jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragover dragenter', function(e) {

			clientY = e.clientY;
		});

		jQuery(LiveComposer.Builder.PreviewAreaDocument).on('drag', 'body', function(e) {

			if ( ! clientY ) return false;

			/** If mouse is dragging within the scroll area */
			if ( clientY > topArea &&
				clientY < window.innerHeight - bottomArea
			) {

				LiveComposer.Builder.Flags.windowScroller != false && LiveComposer.Builder.UI.stopScroller();
				return false;
			}

			/** Don't need scroll reinit when moving mouse in scroll area */
			if ( clientY < topArea && direction == 'up') return false;
			if ( clientY > window.innerHeight - bottomArea && direction == 'down') return false;


			//console.log('not scrolling now');
			LiveComposer.Builder.Flags.windowScroller != false && LiveComposer.Builder.UI.stopScroller();

			var curPxInTik = '';

			if ( clientY < topArea ) {

				direction = 'up';
				curPxInTik = -pxInTik;
			}

			if ( clientY > window.innerHeight - bottomArea ) {

				direction = 'down';
				curPxInTik = pxInTik;
			}

			LiveComposer.Utils.publish('LC.sortableOff', {});

			LiveComposer.Builder.Flags.windowScroller = setInterval(function(){

				LiveComposer.Builder.PreviewAreaWindow.scrollBy(0 ,curPxInTik);
			}, timerTik);
		});

		jQuery(LiveComposer.Builder.PreviewAreaDocument).on('dragend mouseup', 'body', function(e) {

			LiveComposer.Builder.Flags.windowScroller && LiveComposer.Builder.UI.stopScroller();
		});
	};

	LiveComposer.Builder.UI.stopScroller = function() {

		clientY = false;
		LiveComposer.Utils.publish('LC.sortableOn', {});
		direction = '';
		clearInterval(LiveComposer.Builder.Flags.windowScroller);
		LiveComposer.Builder.Flags.windowScroller = false;
	}
});