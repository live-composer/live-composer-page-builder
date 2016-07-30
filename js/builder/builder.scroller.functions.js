
/*********************************
 *
 * = UI - SCROLLER =
 *
 * - dslc_scroller_init ( Initiate )
 * - dslc_scroller_go_to ( Scroll To Specific Item )
 * - dslc_scroller_prev ( Scroll Back )
 * - dslc_scroller_next ( Scroll Forward )
 *
 ***********************************/

	/**
	 * SCROLLER - Initiate
	 */

	function dslc_scroller_init() {

		if ( dslcDebug ) console.log( 'dslc_scroller_init' );

		// Vars
		var scrollers = jQuery('.dslca-section-scroller');

		// If scroller exists
		if ( scrollers.length ) {

			// For each scroller
			scrollers.each(function(){

				// Vars
				var scrollerItem,
				scroller = jQuery(this),
				scrollerInner = jQuery('.dslca-section-scroller-inner', scroller),
				scrollerInnerOffset = scrollerInner.position(),
				scrollerContent = jQuery('.dslca-section-scroller-content', scroller),
				scrollerItems = jQuery('.dslca-scroller-item:visible', scroller),
				startingWidth = 0,
				scrollerWidth = scroller.width() + scrollerInnerOffset.left * -1,
				scrollerContentWidth = scrollerContent.width();

				// Remove last item class
				jQuery('.dslca-section-scroller-item-last', scroller).removeClass('dslca-section-scroller-item-last');

				// Each scroller item
				scrollerItems.each(function(){

					// The item
					scrollerItem = jQuery(this);

					// Increment width ( for complete width of all )
					startingWidth += scrollerItem.outerWidth();

					// If current item makes the width count over the max visible
					if ( startingWidth > scrollerWidth ) {

						// If no last item set yet
						if ( jQuery('.dslca-section-scroller-item-last', scroller).length < 1 ) {

							// Set current item as last item
							scrollerItem.addClass('dslca-section-scroller-item-last');

							// Set previous item as the currently fully visible one
							scroller.data( 'current', scrollerItem.prev('.dslca-scroller-item:visible').index() );

						}

					}

				});

			});

		}

	}

	/**
	 * SCROLLER - Scroll To Specific Item
	 */

	function dslc_scroller_go_to( scrollerItemIndex, scroller ) {

		if ( dslcDebug ) console.log( 'dslc_scroller_go_to' );

		// Vars
		var scrollerInner = jQuery('.dslca-section-scroller-inner', scroller),
		scrollerContent = jQuery('.dslca-section-scroller-content', scroller),
		scrollerItems = jQuery('.dslca-scroller-item', scroller),
		scrollerItem = jQuery('.dslca-scroller-item:eq(' + scrollerItemIndex + ')', scroller);

		// If the item exists
		if ( scrollerItem.length ) {

			// Vars
			var scrollerWidth = scroller.width(),
			scrollerContentWidth = scrollerContent.width(),
			scrollerItemOffset = scrollerItem.position();

			// Needed offset to item
			var scrollerNewOffset = ( scrollerWidth - ( scrollerItemOffset.left + scrollerItem.outerWidth() ) );

			// If offset not less than 0
			if ( scrollerNewOffset < 0 ) {

				// Update the current item
				scroller.data( 'current', scrollerItemIndex );

				// Animate to the offset
				scrollerInner.css({ left : scrollerNewOffset });

			// If offset less than 0
			} else {

				// Animate to beggining
				scrollerInner.css({ left : 0 });

			}

		}

	}

	/**
	 * SCROLLER - Scroll Back
	 */

	function dslc_scroller_prev( scroller ) {

		if ( dslcDebug ) console.log( 'dslc_scroller_prev' );

		// Vars
		var scrollerCurr = scroller.data('current');

		// Two places before current
		var scrollerNew = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').prevAll('.dslca-scroller-item:visible').eq(3).index();

		// One place before current
		var scrollerNewAlt = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').prevAll('.dslca-scroller-item:visible').eq(0).index();

		// If two before current exists scroll to it
		if ( scrollerNew !== -1 ) {
			dslc_scroller_go_to( scrollerNew, scroller );
		// Otherwise if one before current exists scroll to it
		} else if ( scrollerNewAlt !== -1 ) {
			dslc_scroller_go_to( scrollerNewAlt, scroller );
		}

	}

	/**
	 * SCROLLER - Scroll Forward
	 */

	function dslc_scroller_next( scroller ) {

		if ( dslcDebug ) console.log( 'dslc_scroller_next' );

		// Vars
		var scrollerCurr = scroller.data('current');

		// Two places after current
		var scrollerNew = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').nextAll('.dslca-scroller-item:visible').eq(3).index();

		// One place after current
		var scrollerNewAlt = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').nextAll('.dslca-scroller-item:visible').eq(0).index();

		// If two places after current exists scroll to it
		if ( scrollerNew !== -1 )
			dslc_scroller_go_to( scrollerNew, scroller );
		// Otherwise if one place after current exists scroll to it
		else if ( scrollerNewAlt !== -1 )
			dslc_scroller_go_to( scrollerNewAlt, scroller );

	}

	/**
	 * Listen for users actions on the scroller element.
	 * @return void
	 */
	function dslc_scroller_inputevents() {

		/**
		 * Scroll list of modules with a mouse wheel.
		 */

		var scrolling_completed = true;
		var scrolling_direction = ''; // 'X' or 'Y'

		jQuery('.dslca-section-scroller').on( 'wheel', function(event) {

			/* Detect scroll to the right (vertical or horizontal) */
			if (event.originalEvent.deltaY >= 10 || event.originalEvent.deltaX >= 10) {
				event.preventDefault();

				if ( scrolling_completed ) {
					// Scrolling function
					dslc_scroller_next( jQuery(this).closest('.dslca-section').find('.dslca-section-scroller') );
					/*
						event.originalEvent.delta is changing like this on every scroll:
						0 .. 5 .. 16 .. 57 .. 104 .. 57 .. 16 .. 5 .. 0

						We don't want the scrolling function to run on every delta number change.
						Instead we just determine direction, run function once
						and wait will delta value goes back to 0.
					 */
					scrolling_completed = false;
				}

			/* Detect scroll to the left (vertical or horizontal) */
			} else if (event.originalEvent.deltaY <= -10 || event.originalEvent.deltaX <= -10) {
				event.preventDefault();

				if ( scrolling_completed ) {
					// Scrolling function
					dslc_scroller_prev( jQuery(this).closest('.dslca-section').find('.dslca-section-scroller') );
					scrolling_completed = false;
				}
			}

			/* Set the scrolling direction (vertical or horizontal) */
			if (event.originalEvent.deltaY >= 10 || event.originalEvent.deltaY <= -10) {
				scrolling_direction = 'Y';
			} else if (event.originalEvent.deltaX >= 10 || event.originalEvent.deltaX <= -10) {
				scrolling_direction = 'X';
			}

			/* Scrolling delta reached 0 – we can run scrolling functions again */
			if ( scrolling_completed === false && scrolling_direction === 'Y' && event.originalEvent.deltaY === 0 ) {
				scrolling_completed = true;
			} else if ( scrolling_completed === false && scrolling_direction === 'X' && event.originalEvent.deltaX === 0 ) {
				scrolling_completed = true;
			}

		} );

		/**
		 * Hook - Scroller Prev
		 */

		jQuery(document).on( 'click', '.dslca-section-scroller-prev', function(e){

			e.preventDefault();
			dslc_scroller_prev( jQuery(this).closest('.dslca-section').find('.dslca-section-scroller') );

		});

		/**
		 * Hook - Scroller Next
		 */

		jQuery(document).on( 'click', '.dslca-section-scroller-next', function(e){

			e.preventDefault();
			dslc_scroller_next( jQuery(this).closest('.dslca-section').find('.dslca-section-scroller') );

		});
	}

	/**
	 * SCROLLER - Document Ready
	 */

	jQuery(document).ready(function($){

		// Listen for users actions on the scroller element.
		dslc_scroller_inputevents();

	});

	/**
	 * SCROLLER - Window Load
	 */

	jQuery(window).load(function(){

		// Initiate scroller
		dslc_scroller_init();

		// Initiate scroller on window resize
		jQuery(window).resize(function(){
			dslc_scroller_init();
		});

	});