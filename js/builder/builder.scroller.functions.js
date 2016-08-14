
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