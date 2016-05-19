/**
 * Table Of Contents
 *
 * 1) = UI - GENERAL =
 * 2) = UI - SCROLLER =
 * 3) = UI - ANIMATIONS =
 * 4) = UI - MODAL =
 * 5) = UI - PROMPT MODAL =
 * 6) = ROWS/SECTIONS =
 * 7) = AREAS ( MODULE AREAS ) =
 * 8) = MODULES =
 * 9) = TEMPLATES =
 * 10) = CODE GENERATION =
 * 11) = MODULE PRESETS =
 * 12) = OTHER =
 */

"use strict";

var dslcRegularFontsArray = DSLCFonts.regular;
var dslcGoogleFontsArray = DSLCFonts.google;
var dslcAllFontsArray = dslcRegularFontsArray.concat( dslcGoogleFontsArray );

// Set current/default icons set
var dslcIconsCurrentSet = DSLCIcons.fontawesome;

var dslcDebug = false;

/*********************************
 *
 * 1) = UI - GENERAL =
 *
 * - dslc_hide_composer ( Hides the composer elements )
 * - dslc_show_composer ( Shows the composer elements )
 * - dslc_show_publish_button ( Shows the publish button )
 * - dslc_show_section ( Show a specific section )
 * - dslc_generate_filters ( Generate origin filters )
 * - dslc_filter_origin ( Origin filtering for templates/modules listing )
 * - dslc_drag_and_drop ( Initiate drag and drop functionality )
 ***********************************/

 	/**
 	 * UI - GENERAL - Hide Composer
 	 */

	function dslc_hide_composer() {

		if ( dslcDebug ) console.log( 'dslc_hide_composer' );

		// Hide "hide" button and show "show" button
		jQuery('.dslca-hide-composer-hook').hide();
		jQuery('.dslca-show-composer-hook').show();

		// Add class to know it's hidden
		jQuery('body').addClass('dslca-composer-hidden');

		// Hide ( animation ) the main composer area ( at the bottom )
		jQuery('.dslca-container').css({ bottom : jQuery('.dslca-container').outerHeight() * -1 });

		// Hide the header  part of the main composer area ( at the bottom )
		jQuery('.dslca-header').hide();

	}

	/**
	 * UI - GENERAL - Show Composer
	 */

	function dslc_show_composer() {

		if ( dslcDebug ) console.log( 'dslc_show_composer' );

		// Hide the "show" button and show the "hide" button
		jQuery('.dslca-show-composer-hook').hide();
		jQuery('.dslca-hide-composer-hook').show();

		// Remove the class from the body so we know it's not hidden
		jQuery('body').removeClass('dslca-composer-hidden');

		// Show ( animate ) the main composer area ( at the bottom )
		jQuery('.dslca-container').css({ bottom : 0 });

		// Show the header of the main composer area ( at the bottom )
		jQuery('.dslca-header').show();

	}

	/**
	 * UI - GENERAL - Show Publish Button
	 */

	function dslc_show_publish_button() {

		if ( dslcDebug ) console.log( 'dslc_show_publish_button' );

		jQuery('.dslca-save-composer').show().addClass('dslca-init-animation');
		jQuery('.dslca-save-draft-composer').show().addClass('dslca-init-animation');

	}

	/**
	 * UI - GENERAL - Show Section
	 */

	function dslc_show_section( section ) {

		if ( dslcDebug ) console.log( 'dslc_show_section' );

		// Add class to body so we know it's in progress
		jQuery('body').addClass('dslca-anim-in-progress');

		// Get vars
		var sectionTitle = jQuery(section).data('title'),
		newColor = jQuery(section).data('bg');

		// Hide ( animate ) the container
		jQuery('.dslca-container').css({ bottom: -500 });

		// Change the section color
		jQuery('.dslca-sections').animate({ backgroundColor : newColor }, 200);

		// Hide all sections and show specific section
		jQuery('.dslca-section').hide();
		jQuery(section).show();

		// Initiate row scrollbar if editing ar row
		if ( section == '.dslca-modules-section-edit' ) { dslc_row_edit_scrollbar_init(); }

		// Change "currently editing"
		if ( section == '.dslca-module-edit' ) {
			jQuery('.dslca-currently-editing')
				.show()
				.css( 'background-color', newColor )
					.find('strong')
					.text( jQuery('.dslca-module-being-edited').attr('title') + ' module' );
		} else if ( section == '.dslca-modules-section-edit' ) {
			jQuery('.dslca-currently-editing')
				.show()
				.css( 'background-color', '#e5855f' )
					.find('strong')
					.text( 'Row' );
		} else {
			jQuery('.dslca-currently-editing')
				.hide()
					.find('strong')
					.text('');
		}

		// Filter module option tabs
		dslc_module_options_tab_filter();

		// Initiate scroller ( if not module options edit section )
		if ( section != '.dslca-module-edit' ) { dslc_scroller_init(); }

		// Show ( animate ) the container
		setTimeout( function() {
			jQuery('.dslca-container').css({ bottom : 0 });
		}, 300 );

		// Remove class from body so we know it's finished
		jQuery('body').removeClass('dslca-anim-in-progress');

	}

	/**
	 * UI - GENERAL - Generate Origin Filters
	 */

	function dslc_generate_filters() {

		if ( dslcDebug ) console.log( 'dslc_generate_filters' );

		// Vars
		var el, filters = [], filtersHTML = '<span data-origin="">ALL</span>', els = jQuery('.dslca-section:visible .dslca-origin');

		// Go through each and generate the filters
		els.each(function(){
			el = jQuery(this);
			if ( jQuery.inArray( el.data('origin'), filters ) == -1 ) {
				filters.push( el.data('origin') );
				filtersHTML += '<span data-origin="' + el.data('origin') + '">' + el.data('origin').replace( '_', ' ' ) + '</span>';
			}
		});

		jQuery('.dslca-section:visible .dslca-section-title-filter-options').html( filtersHTML ).css( 'background', jQuery('.dslca-section:visible').data('bg') );

	}

	/**
	 * UI - GENERAL - Origin Filter
	 */

	function dslc_filter_origin( origin, section ) {

		if ( dslcDebug ) console.log( 'dslc_filter_origin' );

		jQuery('.dslca-origin', section).hide();
		jQuery('.dslca-origin[data-origin="' + origin + '"]', section).show();

		if ( origin == '' ) {
			jQuery('.dslca-origin', section).show();
		}

		dslc_scroller_init();

	}

	/**
	 * UI - General - Initiate Drag and Drop Functonality
	 */

	function dslc_drag_and_drop() {

		if ( dslcDebug ) console.log( 'dslc_drag_and_drop' );

		var modulesSection, modulesArea, moduleID, moduleOutput;

		// Modules Listing
		jQuery( '.dslca-modules .dslca-module' ).draggable({
			scroll : false,
			appendTo: "body",
			helper: "clone",
			cursor: 'default',
			cursorAt: { top: 50, left: 30 },
			containment: 'body',
			start: function(e, ui){
				jQuery('body').removeClass('dslca-new-module-drag-not-in-progress').addClass('dslca-new-module-drag-in-progress');
				jQuery('#dslc-header').addClass('dslca-header-low-z-index');
			},
			stop: function(e, ui){
				jQuery('body').removeClass('dslca-new-module-drag-in-progress').addClass('dslca-new-module-drag-not-in-progress');
				jQuery('#dslc-header').removeClass('dslca-header-low-z-index');
			}
		});

		// Modules Sections
		jQuery( '.dslc-content' ).sortable({
			items: ".dslc-modules-section",
			handle: '.dslca-move-modules-section-hook:not(".dslca-action-disabled")',
			placeholder: 'dslca-modules-section-placeholder',
			tolerance : 'pointer',
			cursorAt: { bottom: 10 },
			axis: 'y',
			scroll: true,
			scrollSensitivity: 200,
			scrollSpeed : 10,
			sort: function() {
				jQuery( this ).removeClass( "ui-state-default" );
			},
			update: function (e, ui) {
				dslc_generate_code();
				dslc_show_publish_button();
			},
			start: function(e, ui){
				jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');
				ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + DSLCString.str_row_helper_text + '</span></span>');
				jQuery( '.dslc-content' ).sortable( "refreshPositions" );
			},
			stop: function(e, ui){
				jQuery('body').removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
				jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');
				jQuery('.dslc-modules-section').css({ overflow : 'visible', 'max-height' : 'none' });
			}
		});

		// Modules Areas
		jQuery( '.dslc-modules-section-inner' ).sortable({
			connectWith: '.dslc-modules-section-inner',
			items: ".dslc-modules-area",
			handle: '.dslca-move-modules-area-hook:not(".dslca-action-disabled")',
			placeholder: 'dslca-modules-area-placeholder',
			cursorAt: { top: 0, left: 0 },
			tolerance : 'intersect',
			scroll: true,
			scrollSensitivity: 100,
			scrollSpeed : 15,
			sort: function() {
				jQuery( this ).removeClass( "ui-state-default" );
			},
			over: function (e, ui) {

				var dslcSection = ui.placeholder.closest('.dslc-modules-section');

				jQuery(dslcSection).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');

				dslcSection.siblings('.dslc-modules-section').each( function(){
					if ( jQuery('.dslc-modules-area:not(.ui-sortable-helper)', jQuery(this)).length ) {
						jQuery(this).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');
					} else {
						jQuery(this).removeClass('dslc-modules-section-not-empty').addClass('dslc-modules-section-empty');
					}
				});


			},
			update: function (e, ui) {
				dslc_generate_code();
				dslc_show_publish_button();
			},
			start: function(e, ui){

				// Placeholder
				ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + DSLCString.str_area_helper_text + '</span></span>');
				if ( ! jQuery(ui.item).hasClass('dslc-12-col') ) {
					ui.placeholder.width(ui.item.width() - 10)
				} else {
					ui.placeholder.width(ui.item.width()).css({ margin : 0 });
				}

				// Add drag in progress class
				jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress dslca-modules-area-drag-in-progress');

				// Refresh positions
				jQuery( '.dslc-modules-section-inner' ).sortable( "refreshPositions" );

			},
			stop: function(e, ui){

				jQuery('body').removeClass('dslca-drag-in-progress dslca-modules-area-drag-in-progress').addClass('dslca-drag-not-in-progress');
				jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');

			},
			change: function( e, ui ) {

			}
		});

		jQuery( '.dslc-modules-section' ).droppable({
			drop: function( event, ui ) {
				var modulesSection = jQuery(this).find('.dslc-modules-section-inner');
				var moduleID = ui.draggable.data( 'id' );
				if ( moduleID == 'DSLC_M_A' ) {
					dslc_modules_area_add( modulesSection );
				}
			}
		});

		jQuery( '.dslc-modules-area' ).droppable({
			activeClass: "dslca-ui-state-default",
			hoverClass: "dslca-ui-state-hover",
			accept: ":not(.ui-sortable-helper)",
			drop: function( event, ui ) {

				// Vars
				modulesArea = jQuery(this);
				moduleID = ui.draggable.data( 'id' );

				if ( moduleID == 'DSLC_M_A' || jQuery('body').hasClass('dslca-module-drop-in-progress') || modulesArea.closest('#dslc-header').length || modulesArea.closest('#dslc-footer').length ) {

					// nothing

				} else {

					jQuery('body').addClass('dslca-anim-in-progress dslca-module-drop-in-progress');

					// Add padding to modules area
					if ( modulesArea.hasClass('dslc-modules-area-not-empty') )
						modulesArea.animate({ paddingBottom : 50 }, 150);

					// Load Output
					dslc_module_output_default( moduleID, function( response ){

						// Append Content
						moduleOutput = response.output;

						// Finish loading and show
						jQuery('.dslca-module-loading-inner', modulesArea).stop().animate({ width : '100%' }, 300, 'linear', function(){

							// Remove extra padding from area
							modulesArea.css({ paddingBottom : 0 });

							// Hide loader
							jQuery('.dslca-module-loading', modulesArea ).hide();

							// Add output
							var dslcJustAdded = jQuery(moduleOutput).appendTo(modulesArea);
							dslcJustAdded.css({
								'-webkit-animation-name' : 'dslcBounceIn',
								'-moz-animation-name' : 'dslcBounceIn',
								'animation-name' : 'dslcBounceIn',
								'animation-duration' : '0.6s',
								'-webkit-animation-duration' : '0.6s'
							});

							setTimeout( function(){
								dslc_init_square();
								dslc_center();
								dslc_masonry( dslcJustAdded );
								jQuery('body').removeClass('dslca-anim-in-progress dslca-module-drop-in-progress');
							}, 700 );

							// "Show" no content text
							jQuery('.dslca-no-content-primary', modulesArea ).css({ opacity : 1 });

							// "Show" modules area management
							jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'visible' });

							// Show publish
							jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
							jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

							// Generete
							dslc_carousel();
							dslc_tabs();
							dslc_init_accordion();
							dslc_init_square();
							dslc_center();
							dslc_generate_code();
							dslc_show_publish_button();

						});

					});

					/**
					 * Loading animation
					 */

					// Show loader
					jQuery('.dslca-module-loading', modulesArea).show();

					// Hide no content text
					jQuery('.dslca-no-content-primary', modulesArea).css({ opacity : 0 });

					// Hide modules area management
					jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'hidden' });

					// Animate loading
					var randomLoadingTime = Math.floor(Math.random() * (100 - 50 + 1) + 50) * 100;
					jQuery('.dslca-module-loading-inner', modulesArea).css({ width : 0 }).animate({
						width : '100%'
					}, randomLoadingTime, 'linear' );

				}

			}
		}).sortable({
			connectWith: '.dslc-modules-area',
			items: ".dslc-module-front",
			handle: '.dslca-move-module-hook:not(".dslca-action-disabled")',
			placeholder: 'dslca-module-placeholder',
			cursorAt: { top: 50, left : 30 },
			tolerance : 'pointer',
			scroll: true,
			scrollSensitivity: 100,
			scrollSpeed : 15,
			start: function(e, ui) {

				ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + ui.item.find('.dslc-sortable-helper-icon').data('title') + '</span></span>');

				if ( ! jQuery(ui.item).hasClass('dslc-12-col') ) {
					ui.placeholder.width(ui.item.width() - 10)
				} else {
					ui.placeholder.width(ui.item.width()).css({ margin : 0 });
				}

				jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');

				if ( jQuery('.dslc-module-front', this).length < 2 ) {

					jQuery(this).removeClass('dslc-modules-area-not-empty').addClass('dslc-modules-area-empty');

					jQuery('.dslca-no-content:not(:visible)', this).show().css({
						'-webkit-animation-name' : 'dslcBounceIn',
						'-moz-animation-name' : 'dslcBounceIn',
						'animation-name' : 'dslcBounceIn',
						'animation-duration' : '0.6s',
						'-webkit-animation-duration' : '0.6s',
						padding : 0
					}).animate({ padding : '35px 0' }, 300, function(){

					});

				}

				jQuery( '.dslc-modules-area' ).sortable( "refreshPositions" );

			},
			sort: function(e, ui) {

				/* Gets added unintentionally by droppable interacting with sortable */
				jQuery( this ).removeClass( "ui-state-default" );

			},
			update: function (e, ui) {
				dslc_show_publish_button();
			},
			stop: function(e, ui) {

				dslc_generate_code();
				jQuery('body').removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
				jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');
				ui.item.trigger('mouseleave');

			},
			change: function( e, ui ) { }
		});

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	function dslc_option_changed() { dslc_show_publish_button(); }
	function dslc_module_dragdrop_init() { dslc_drag_and_drop(); }

	/**
	 * UI - GENERAL - Document Ready
	 */

	jQuery(document).ready(function($) {

		if ( ! jQuery('body').hasClass('rtl') ) {
			jQuery('.dslca-module-edit-options-inner').jScrollPane();
		}
		$('body').addClass('dslca-enabled dslca-drag-not-in-progress');
		$('.dslca-invisible-overlay').hide();
		$('.dslca-section').eq(0).show();
		dslc_drag_and_drop();
		dslc_generate_code();

		/**
		 * Action - "Currently Editing" scroll on click
		 */

		$(document).on( 'click', '.dslca-currently-editing', function(){

			var activeElement = false,
			newOffset = false,
			outlineColor;

			if ( $('.dslca-module-being-edited').length ) {
				activeElement = $('.dslca-module-being-edited');
				outlineColor = '#5890e5';
			} else if ( $('.dslca-modules-section-being-edited').length ) {
				activeElement = $('.dslca-modules-section-being-edited');
				outlineColor = '#eabba9';
			}

			if ( activeElement ) {
				newOffset = activeElement.offset().top - 100;
				if ( newOffset < 0 ) { newOffset = 0; }
				$( 'html, body' ).animate({ scrollTop: newOffset }, 300, function(){
					activeElement.animate( { 'outline-color' : outlineColor }, 70, function(){
						activeElement.animate({ 'outline-color' : 'transparent' }, 70, function(){
							activeElement.animate( { 'outline-color' : outlineColor }, 70, function(){
								activeElement.animate({ 'outline-color' : 'transparent' }, 70, function(){
									activeElement.removeAttr('style');
								});
							});
						});
					});
				});
			}

		});

		/**
		 * Hook - Hide Composer
		 */

		$(document).on( 'click', '.dslca-hide-composer-hook', function(){

			dslc_hide_composer()

		});

		/**
		 * Hook - Show Composer
		 */

		$(document).on( 'click', '.dslca-show-composer-hook', function(){

			dslc_show_composer();

		});

		/**
		 * Hook - Section Show - Modules Listing
		 */

		$(document).on( 'click', '.dslca-go-to-modules-hook', function(e){

			e.preventDefault();
			dslc_show_section( '.dslca-modules' );

		});

		/**
		 * Hook - Section Show - Dynamic
		 */

		$(document).on( 'click', '.dslca-go-to-section-hook', function(e){

			e.preventDefault();

			var sectionTitle = $(this).data('section');
			dslc_show_section( sectionTitle );

			$(this).addClass('dslca-active').siblings('.dslca-go-to-section-hook').removeClass('dslca-active');

		});

		/**
		 * Hook - Close Composer
		 */

		$(document).on( 'click', '.dslca-close-composer-hook', function(e){

			e.preventDefault();
			if ( ! $('body').hasClass('dslca-saving-in-progress') ) {
				dslc_js_confirm( 'disable_lc', '<span class="dslca-prompt-modal-title">' + DSLCString.str_exit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_exit_descr + '</span>', $(this).attr('href') );
			}

		});

		/**
		 * Submit Form
		 */

		$(document).on( 'click', '.dslca-submit', function(){

			jQuery(this).closest('form').submit();

		});

		/**
		 * Hook - Show Origin Filters
		 */

		$(document).on( 'click', '.dslca-section-title', function(e){

			e.stopPropagation();

			if ( $('.dslca-section-title-filter', this).length ) {
				dslc_generate_filters();
				$('.dslca-section-title-filter-options').slideToggle(300);
			}

		});

		/**
		 * Hook - Apply Filter Origin
		 */

		$(document).on( 'click', '.dslca-section-title-filter-options span', function(e){

			e.stopPropagation();

			var origin = $(this).data('origin');
			var section = $(this).closest('.dslca-section');

			if ( section.hasClass('dslca-templates-load') ) {
				$('.dslca-section-title-filter-curr', section).text( $(this).text() + ' TEMPLATES' );
			} else {
				$('.dslca-section-title-filter-curr', section).text( $(this).text() + ' MODULES' );
			}

			$('.dslca-section-scroller-inner').css({ left : 0 });

			dslc_filter_origin( origin, section );

		});

	});


/*********************************
 *
 * 2) = UI - SCROLLER =
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
		var scrollerNew = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').prevAll('.dslca-scroller-item:visible').eq(1).index();

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
		var scrollerNew = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').nextAll('.dslca-scroller-item:visible').eq(1).index();

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
	 * SCROLLER - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Hook - Scroller Prev
		 */

		$(document).on( 'click', '.dslca-section-scroller-prev', function(e){

			e.preventDefault();
			dslc_scroller_prev( $(this).closest('.dslca-section').find('.dslca-section-scroller') );

		});

		/**
		 * Hook - Scroller Next
		 */

		$(document).on( 'click', '.dslca-section-scroller-next', function(e){

			e.preventDefault();
			dslc_scroller_next( $(this).closest('.dslca-section').find('.dslca-section-scroller') );

		});

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


/*********************************
 *
 * 3) = UI - ANIMATIONS =
 *
 * - dslc_ui_animations ( Animations for the UI )
 *
 ***********************************/

	/**
	 * ANIMATIONS - Initiate
	 */

	function dslc_ui_animations() {

		if ( dslcDebug ) console.log( 'dslc_ui_animations' );

		// Mouse Enter/Leave - Module

		jQuery(document).on( 'mouseenter', '.dslca-modules-area-manage', function(){

			jQuery(this).closest('.dslc-modules-area').addClass('dslca-options-hovered');

			dslca_draggable_calc_center( jQuery(this).closest('.dslc-modules-area') );

		}).on( 'mouseleave', '.dslca-modules-area-manage', function(){

			jQuery(this).closest('.dslc-modules-area').removeClass('dslca-options-hovered');

		});

		// Mouse Enter/Leave - Module

		jQuery(document).on( 'mouseenter', '.dslca-drag-not-in-progress .dslc-module-front', function(e){

			 if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				if ( jQuery(this).height() < 190 )
					jQuery('.dslca-module-manage', this).addClass('dslca-horizontal');
				else
					jQuery('.dslca-module-manage', this).removeClass('dslca-horizontal');

			}

		}).on( 'mouseleave', '.dslca-drag-not-in-progress .dslc-module-front', function(e){

			if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				jQuery(this).find('.dslca-change-width-module-options').hide();

			}

			// Hide "width change opts"
			jQuery(this).find('.dslca-module-manage').removeClass('dslca-module-manage-change-width-active');

		});

		// Mouse Enter/Leave - Modules Area

		jQuery(document).on( 'mouseenter', '.dslca-drag-not-in-progress .dslc-modules-area', function(e){

			var _this = jQuery(this);

			 if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

			 	jQuery('#dslc-header').addClass('dslca-header-low-z-index');

				if ( jQuery(this).height() < 130 )
					jQuery('.dslca-modules-area-manage', this).addClass('dslca-horizontal');
				else
					jQuery('.dslca-modules-area-manage', this).removeClass('dslca-horizontal');

			}

		}).on( 'mouseleave', '.dslca-drag-not-in-progress .dslc-modules-area', function(e){

			var _this = jQuery(this);

			if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				jQuery('#dslc-header').removeClass('dslca-header-low-z-index');

			}

		});

	}

	/**
	 * ANIMATIONS - Document Ready
	 */

	jQuery(document).ready(function(){

		dslc_ui_animations();

	});


/*********************************
 *
 * 4) = UI - MODAL =
 * Note: Used for the templates save/export/import and icons
 *
 * - dslc_show_modal ( Show Modal )
 * - dslc_hide_modal ( Hide Modal )
 *
 ***********************************/

 	/**
 	 * MODAL - Show
 	 *
 	 * @param {Object} hook - Button that was clicked to open modal
 	 * @param {string} modal - CSS address of the modal, like '.modal-icons'
 	 */

 	function dslc_show_modal( hook, modal ) {

		if ( dslcDebug ) console.log( 'dslc_show_modal' );

		// If a modal already visibile hide it
		dslc_hide_modal( '', jQuery('.dslca-modal:visible') );

		// Vars
		var modal = jQuery(modal);

		// Vars ( Calc Offset )
		var position = jQuery(hook).position(),
		diff = modal.outerWidth() / 2 - hook.outerWidth() / 2,
		offset = position.left - diff;

		// Show Modal
		modal.css({ left : offset }).show();
		modal.addClass('dslca-modal-open');

		// Animate Modal
		/*
		modal.css({
			'-webkit-animation-name' : 'dslcBounceIn',
			'-moz-animation-name' : 'dslcBounceIn',
			'animation-name' : 'dslcBounceIn',
			'animation-duration' : '0.6s',
			'-webkit-animation-duration' : '0.6s'
		}).fadeIn(600);
		*/

	}

	/**
	 * MODAL - Hide
	 */

	function dslc_hide_modal( hook, modal ) {

		if ( dslcDebug ) console.log( 'dslc_hide_modal' );

		// Vars
		var modal = jQuery(modal);

		// Hide ( with animation )
		modal.hide();
		modal.removeClass('dslca-modal-open');
		/*
		modal.css({
			'-webkit-animation-name' : 'dslcBounceOut',
			'-moz-animation-name' : 'dslcBounceOut',
			'animation-name' : 'dslcBounceOut',
			'animation-duration' : '0.6s',
			'-webkit-animation-duration' : '0.6s'
		}).fadeOut(600);
		*/

	}

	// Hide if clicked outside of modal
	jQuery(document).mouseup(function (e) {
	    var container = jQuery(".dslca-modal-open");

	    if (!container.is(e.target) // if the target of the click isn't the container...
	      && container.has(e.target).length === 0) // ... nor a descendant of the container
	    {
	      container.hide();
	    }
	});

	/**
	 * MODAL - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Hook - Show Modal
		 */

		$(document).on( 'click', '.dslca-open-modal-hook', function(){

			var modal = $(this).data('modal');
			dslc_show_modal( $(this), modal );

		});

		/**
		 * Hook - Hide Modal
		 */

		$(document).on( 'click', '.dslca-close-modal-hook', function(){

			if ( ! $(this).hasClass('dslca-action-disabled') ) {

				var modal = $(this).data('modal');
				dslc_hide_modal( $(this), modal );

			}

		});

	});


/*********************************
 *
 * 5) = UI - PROMPT MODAL =
 *
 * - dslc_js_confirm
 * - dslc_js_confirm_close
 *
 ***********************************/

 	function dslc_js_confirm( dslcID, dslcContent, dslcTarget ) {

		if ( dslcDebug ) console.log( 'dslc_js_confirm' );

		// Add "active" class
		jQuery('.dslca-prompt-modal').addClass('dslca-prompt-modal-active');

		// Add the ID of current event
		jQuery('.dslca-prompt-modal').data( 'id', dslcID );
		jQuery('.dslca-prompt-modal').data( 'target', dslcTarget );

		// Add modal content
		jQuery('.dslca-prompt-modal-msg').html( dslcContent );

		// Show modal
		jQuery('.dslca-prompt-modal').css({ opacity : 0 }).show().animate({
			opacity : 1,
		}, 400);

		// Animate modal
		jQuery('.dslca-prompt-modal-content').css({ top : '55%' }).animate({
			top : '50%'
		}, 400);

	}

	function dslc_js_confirm_close() {

		if ( dslcDebug ) console.log( 'dslc_js_confirm_close' );

		// Remove "active" class
		jQuery('.dslca-prompt-modal').removeClass('dslca-prompt-modal-active');

		// Hide modal
		jQuery('.dslca-prompt-modal').animate({
			opacity : 0,
		}, 400, function(){
			jQuery(this).hide();
			jQuery('.dslca-prompt-modal-cancel-hook').show();
			jQuery('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>' + DSLCString.str_confirm);
		});

		jQuery('.dslca-prompt-modal-content').animate({
			top : '55%'
		}, 400);

	}

	/**
	 * UI - PROMPT MODAL - Document Ready
	 */

	jQuery(document).ready(function($){

		$(document).on( 'click', '.dslca-prompt-modal-cancel-hook', function(e){

			e.preventDefault();

			var dslcAction = jQuery('.dslca-prompt-modal').data('id');
			var dslcTarget = jQuery('.dslca-prompt-modal').data('target');

			if ( dslcAction == 'edit_in_progress' ) {

				dslc_module_options_cancel_changes( function(){
					dslcTarget.trigger('click');
				});

			} else if ( dslcAction == 'delete_module' ) {



			}

			dslc_js_confirm_close();
			jQuery('.dslca-prompt-modal').data( 'id', '' );

		});

		$(document).on( 'click', '.dslca-prompt-modal-confirm-hook', function(e){

			e.preventDefault();

			var dslcAction = jQuery('.dslca-prompt-modal').data('id');
			var dslcTarget = jQuery('.dslca-prompt-modal').data('target');
			var closeAtEnd = true;

			if (  dslcAction == 'edit_in_progress' ) {

				dslc_module_options_confirm_changes( function(){
					dslcTarget.trigger('click');
				});

			} else if ( dslcAction == 'disable_lc' ) {

				window.location = dslcTarget;

			} else if ( dslcAction == 'delete_module' ) {

				var module = dslcTarget.closest('.dslc-module-front');
				dslc_delete_module( module );

			} else if ( dslcAction == 'delete_modules_area' ) {

				var modulesArea = dslcTarget.closest('.dslc-modules-area');
				dslc_modules_area_delete( modulesArea );

			} else if ( dslcAction == 'delete_modules_section' ) {

				dslc_row_delete( dslcTarget.closest('.dslc-modules-section') );

			} else if ( dslcAction == 'export_modules_section' ) {

			} else if ( dslcAction == 'import_modules_section' ) {

				dslc_row_import( $('.dslca-prompt-modal textarea').val() );
				$('.dslca-prompt-modal-confirm-hook span').css({ opacity : 0 });
				$('.dslca-prompt-modal-confirm-hook .dslca-loading').show();
				closeAtEnd = false;

			}

			if ( closeAtEnd )
				dslc_js_confirm_close();

			jQuery('.dslca-prompt-modal').data( 'id', '' );

		});

		/**
		 * Hook - Confirm on Enter, Cancel on Esc
		 */

		$(window).on( 'keydown', function(e) {

			// Enter ( confirm )
			if( e.which == 13 ) {
				if ( $('.dslca-prompt-modal-active').length ) {
					$('.dslca-prompt-modal-confirm-hook').trigger('click');
				}

			// Escape ( cancel )
			} else if ( e.which == 27 ) {
				if ( $('.dslca-prompt-modal-active').length ) {
					$('.dslca-prompt-modal-cancel-hook').trigger('click');
				}
			}

		});

	});


/*********************************
 *
 * 6) = ROWS/SECTIONS =
 *
 * - dslc_row_add ( Add New )
 * - dslc_row_delete ( Delete )
 * - dslc_row_edit ( Edit )
 * - dslc_row_edit_colorpicker_init ( Edit - Initiate Colorpicker )
 * - dslc_row_edit_slider_init ( Edit - Initiate Slider )
 * - dslc_row_edit_scrollbar_init ( Edit - Initiate Scrollbar )
 * - dslc_row_edit_cancel ( Edit - Cancel Changes )
 * - dslc_row_edit_confirm ( Edit - Confirm Changes )
 * - dslc_row_copy ( Copy )
 * - dslc_row_import ( Import )
 *
 ***********************************/

 	/**
 	 * Row - Add New
 	 */

	function dslc_row_add( callback ) {

		if ( dslcDebug ) console.log( 'dslc_row_add' );

		callback = typeof callback !== 'undefined' ? callback : false;

		// AJAX Request
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-add-modules-section',
				dslc : 'active'
			},
			function( response ) {

				// Append new row
				jQuery( response.output ).appendTo('#dslc-main');

				// Call other functions
				dslc_drag_and_drop();
				dslc_generate_code();
				dslc_show_publish_button();

				if ( callback ) { callback(); }

			}

		);

	}

	/**
	 * Row - Delete
	 */

	function dslc_row_delete( row ) {

		if ( dslcDebug ) console.log( 'dslc_row_delete' );

		// If the row is being edited
		if ( row.find('.dslca-module-being-edited') ) {

			// Hide the filter hooks
			jQuery('.dslca-header .dslca-options-filter-hook').hide();

			// Hide the save/cancel actions
			jQuery('.dslca-module-edit-actions').hide();

			// Show the section hooks
			jQuery('.dslca-header .dslca-go-to-section-hook').show();

			dslc_show_section('.dslca-modules');

		}

		// Remove row
		row.trigger('mouseleave').remove();

		// Call other functions
		dslc_generate_code();
		dslc_show_publish_button();

	}

	/**
	 * Row - Edit
	 */

	function dslc_row_edit( row ) {

		if ( dslcDebug ) console.log( 'dslc_row_edit' );

		// Vars we will use
		var dslcModulesSectionOpts, dslcVal;

		// Set editing class
		jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');
		jQuery('.dslca-modules-section-being-edited').removeClass('dslca-modules-section-being-edited').removeClass('dslca-modules-section-change-made');
		row.addClass('dslca-modules-section-being-edited');

		// Hide the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').hide();

		// Show the styling/responsive tabs
		jQuery('.dslca-row-options-filter-hook[data-section="styling"], .dslca-row-options-filter-hook[data-section="responsive"]').show();
		jQuery('.dslca-row-options-filter-hook[data-section="styling"]').trigger('click');

		// Hide the filter hooks
		jQuery('.dslca-header .dslca-options-filter-hook').hide();

		// Hide the save/cancel actions
		jQuery('.dslca-module-edit-actions').hide();

		// Show the save/cancel actions
		jQuery('.dslca-row-edit-actions').show();

		// Set current values
		jQuery('.dslca-modules-section-edit-field').each(function(){

			if ( jQuery(this).data('id') == 'border-top' ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]').val().indexOf('top') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else if ( jQuery(this).data('id') == 'border-right' ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]').val().indexOf('right') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else if ( jQuery(this).data('id') == 'border-bottom' ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]').val().indexOf('bottom') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else if ( jQuery(this).data('id') == 'border-left' ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]').val().indexOf('left') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else if ( jQuery(this).hasClass('dslca-modules-section-edit-field-checkbox') ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="' + jQuery(this).data('id') + '"]').val().indexOf( jQuery(this).data('val') ) >= 0 ) {
					jQuery( this ).prop('checked', true);
					jQuery( this ).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery( this ).prop('checked', false);
					jQuery( this ).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else {

				jQuery(this).val( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="' + jQuery(this).data('id') + '"]').val() );

				if ( jQuery( this ).hasClass( 'dslca-modules-section-edit-field-colorpicker' ) ) {
					var _this = jQuery( this );
					jQuery( this ).closest( '.dslca-modules-section-edit-option' ).find( '.sp-preview-inner' ).removeClass('sp-clear-display').css({ 'background-color' : _this.val() });
				}

			}

		});

		jQuery('.dslca-modules-section-edit-field-upload').each(function(){

			var dslcParent = jQuery(this).closest('.dslca-modules-section-edit-option');

			if ( jQuery(this).val() && jQuery(this).val() !== 'disabled' ) {

				jQuery('.dslca-modules-section-edit-field-image-add-hook', dslcParent ).hide();
				jQuery('.dslca-modules-section-edit-field-image-remove-hook', dslcParent ).show();

			} else {

				jQuery('.dslca-modules-section-edit-field-image-remove-hook', dslcParent ).hide();
				jQuery('.dslca-modules-section-edit-field-image-add-hook', dslcParent ).show();

			}

		});

		// Initiate numeric option sliders
		dslc_row_edit_slider_init();

		// Show options management
		dslc_show_section('.dslca-modules-section-edit');

		// Hide the publish butotn
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'hidden' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'hidden' });

	}

	/**
	 * Row - Edit - Initiate Colorpicker
	 */

	function dslc_row_edit_colorpicker_init() {

		if ( dslcDebug ) console.log( 'dslc_row_edit_colorpicker_init' );

		var dslcField,
		dslcFieldID,
		dslcEl,
		dslcModulesSection,
		dslcVal,
		dslcRule,
		dslcSetting,
		dslcTargetEl,
		dslcCurrColor;

		/**
		 * Color Pallete
		 */

		var dslcColorPallete = [],
		currStorage,
		index;

		dslcColorPallete[0] = [];
		dslcColorPallete[1] = [];
		dslcColorPallete[2] = [];
		dslcColorPallete[3] = [];

		if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
		} else {
			currStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
			for	( index = 0; index < currStorage.length; index++ ) {
				var key = Math.floor( index / 3 );
				if ( key < 4 ) {
					dslcColorPallete[key].push( currStorage[index] );
				}
			}
		}

		jQuery('.dslca-modules-section-edit-field-colorpicker').each( function(){

			dslcCurrColor = jQuery(this).val();

			jQuery(this).spectrum({
				color: dslcCurrColor,
				showInput: true,
				allowEmpty: true,
				showAlpha: true,
				clickoutFiresChange: true,
				cancelText: '',
				chooseText: '',
				preferredFormat: 'rgb',
				showPalette: true,
				palette: dslcColorPallete,
				move: function( color ) {

					dslcField = jQuery(this);
					dslcFieldID = dslcField.data('id');

					if ( color == null )
						dslcVal = 'transparent';
					else
						dslcVal = color.toRgbString();

					dslcRule = dslcField.data('css-rule');
					dslcEl = jQuery('.dslca-modules-section-being-edited');
					dslcTargetEl = dslcEl;
					dslcSetting = jQuery('.dslca-modules-section-settings input[data-id="' + dslcFieldID + '"]', dslcEl );

					dslcEl.addClass('dslca-modules-section-change-made');

					if ( dslcField.data('css-element') ) {
						dslcTargetEl = jQuery( dslcField.data('css-element'), dslcEl );
					}

					dslcTargetEl.css(dslcRule, dslcVal);
					dslcSetting.val( dslcVal );

				},
				change: function( color ) {

					dslcField = jQuery(this);
					dslcFieldID = dslcField.data('id');

					if ( color == null )
						dslcVal = 'transparent';
					else
						dslcVal = color.toRgbString();

					// Update pallete local storage
					if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
						var newStorage = [ dslcVal ];
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					} else {
						var newStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
						if ( newStorage.indexOf( dslcVal ) == -1 ) {
							newStorage.unshift( dslcVal );
						}
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					}

				},
				show: function( color ) {
					jQuery('body').addClass('dslca-disable-selection');
					jQuery(this).spectrum( 'set', jQuery(this).val() );
				},
				hide: function() {
					jQuery('body').removeClass('dslca-disable-selection');
				}

			});

		});

	}

	/**
	 * Row - Edit - Initiate Slider
	 */

	function dslc_row_edit_slider_init() {

		if ( dslcDebug ) console.log( 'dslc_row_edit_slider_init' );

		jQuery('.dslca-modules-section-edit-field-slider').each(function(){

			var dslcSlider, dslcSliderField, dslcSliderInput, dslcSliderVal, dslcAffectOnChangeRule, dslcAffectOnChangeEl,
			dslcSliderTooltip, dslcSliderTooltipOffset, dslcSliderHandle, dslcSliderTooltipPos, dslcSection, dslcOptionID, dslcSliderExt = '',
			dslcAffectOnChangeRules, dslcSliderMin = 0, dslcSliderMax = 300, dslcSliderIncr = 1;

			dslcSlider = jQuery(this);
			dslcSliderInput = dslcSlider.siblings('.dslca-modules-section-edit-field');
			dslcSliderTooltip = dslcSlider.siblings('.dslca-modules-section-edit-field-slider-tooltip');

			if ( dslcSlider.data('min') ) {
				dslcSliderMin = dslcSlider.data('min');
			}

			if ( dslcSlider.data('max') ) {
				dslcSliderMax = dslcSlider.data('max');
			}

			if ( dslcSlider.data('incr') ) {
				dslcSliderIncr = dslcSlider.data('incr');
			}

			if ( dslcSlider.data('ext') ) {
				dslcSliderExt = dslcSlider.data('ext');
			}

			dslcSlider.slider({
				min : dslcSliderMin,
				max : dslcSliderMax,
				step: dslcSliderIncr,
				value: dslcSliderInput.val(),
				slide: function(event, ui) {

					dslcSliderVal = ui.value + dslcSliderExt;
					dslcSliderInput.val( dslcSliderVal );

					// Live change
					dslcAffectOnChangeEl = jQuery('.dslca-modules-section-being-edited');

					if ( dslcSliderInput.data('css-element') ) {
						dslcAffectOnChangeEl = jQuery( dslcSliderInput.data('css-element'), dslcAffectOnChangeEl );
					}

					dslcAffectOnChangeRule = dslcSliderInput.data('css-rule').replace(/ /g,'');
					dslcAffectOnChangeRules = dslcAffectOnChangeRule.split( ',' );

					// Loop through rules (useful when there are multiple rules)
					for ( var i = 0; i < dslcAffectOnChangeRules.length; i++ ) {
						jQuery( dslcAffectOnChangeEl ).css( dslcAffectOnChangeRules[i] , dslcSliderVal );
					}

					// Update option
					dslcSection = jQuery('.dslca-modules-section-being-edited');
					dslcOptionID = dslcSliderInput.data('id');
					jQuery('.dslca-modules-section-settings input[data-id="' + dslcOptionID + '"]', dslcSection).val( ui.value );

					dslcSection.addClass('dslca-modules-section-change-made');

					// Tooltip
					dslcSliderTooltip.text( dslcSliderVal );
					dslcSliderHandle = dslcSlider.find('.ui-slider-handle');
					dslcSliderTooltipOffset = dslcSliderHandle[0].style.left;
					dslcSliderTooltip.css({ left : dslcSliderTooltipOffset });

				},
				stop: function( event, ui ) {

					dslcSliderTooltip.hide();

					var scrollOffset = jQuery( window ).scrollTop();
					dslc_masonry();
					jQuery( window ).scrollTop( scrollOffset );

				},
				start: function( event, ui ) {

					dslcSliderVal = ui.value;

					dslcSliderTooltip.show();

					// Tooltip
					dslcSliderTooltip.text( dslcSliderVal );
					dslcSliderHandle = dslcSlider.find('.ui-slider-handle');
					dslcSliderTooltipOffset = dslcSliderHandle[0].style.left;
					dslcSliderTooltip.css({ left : dslcSliderTooltipOffset });

				}

			});

		});

	}

	/**
	 * Row - Edit - Initiate Scrollbar
	 */

	function dslc_row_edit_scrollbar_init() {

		if ( dslcDebug ) console.log( 'dslc_row_edit_scrollbar_init' );

		var dslcWidth = 0;

		jQuery('.dslca-modules-section-edit-option').each(function(){
			dslcWidth += jQuery(this).outerWidth(true) + 1;
		});

		if ( dslcWidth > jQuery( '.dslca-modules-section-edit-options' ).width() ) {
			jQuery('.dslca-modules-section-edit-options-wrapper').width( dslcWidth );
		} else {
			jQuery('.dslca-modules-section-edit-options-wrapper').width( 'auto' );
		}

		if ( ! jQuery('body').hasClass('rtl') ) {

			if ( jQuery('.dslca-modules-section-edit-options-inner').data('jsp') ) {
				jQuery('.dslca-modules-section-edit-options-inner').data('jsp').destroy();
			}

			jQuery('.dslca-modules-section-edit-options-inner').jScrollPane();

		}

	}

	/**
	 * Row - Edit - Cancel Changes
	 */

	function dslc_row_edit_cancel( callback ) {

		if ( dslcDebug ) console.log( 'dslc_row_cancel_changes' );

		callback = typeof callback !== 'undefined' ? callback : false;

		jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input').each(function(){

			jQuery(this).val( jQuery(this).data('def') );
			jQuery('.dslca-modules-section-edit-field[data-id="' + jQuery(this).data('id') + '"]').val( jQuery(this).data('def') ).trigger('change');

		});

		dslc_show_section('.dslca-modules');

		// Hide the save/cancel actions
		jQuery('.dslca-row-edit-actions').hide();

		// Hide the styling/responsive tabs
		jQuery('.dslca-row-options-filter-hook').hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

		// Remove being edited class
		jQuery('.dslca-modules-section-being-edited').removeClass('dslca-modules-section-being-edited dslca-modules-section-change-made');

		if ( callback ) { callback(); }

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

	}

	/**
	 * Row - Edit - Confirm Changes
	 */

	function dslc_row_edit_confirm( callback ) {

		if ( dslcDebug ) console.log( 'dslc_confirm_row_changes' );

		callback = typeof callback !== 'undefined' ? callback : false;

		jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input').each(function(){

			jQuery(this).data( 'def', jQuery(this).val() );

		});

		dslc_show_section('.dslca-modules');

		// Hide the save/cancel actions
		jQuery('.dslca-row-edit-actions').hide();

		// Hide the styling/responsive tabs
		jQuery('.dslca-row-options-filter-hook').hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

		// Remove being edited class
		jQuery('.dslca-modules-section-being-edited').removeClass('dslca-modules-section-being-edited dslca-modules-section-change-made');

		dslc_generate_code();
		dslc_show_publish_button();

		if ( callback ) { callback(); }

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

	}

	/**
	 * Row - Copy
	 */

	function dslc_row_copy( row ) {

		if ( dslcDebug ) console.log( 'dslc_row_copy' );

		// Vars that will be used
		var dslcModuleID,
		dslcModulesSectionCloned,
		dslcModule;

		// Clone the row
		dslcModulesSectionCloned = row.clone().appendTo('#dslc-main');

		// Go through each area of the new row and apply correct data-size
		dslcModulesSectionCloned.find('.dslc-modules-area').each(function(){
			var dslcIndex = jQuery(this).index();
			jQuery(this).data('size', row.find('.dslc-modules-area:eq( ' + dslcIndex + ' )').data('size') );
		});

		// Remove animations and temporary hide modules
		dslcModulesSectionCloned.find('.dslc-module-front').css({
			'-webkit-animation-name' : 'none',
			'-moz-animation-name' : 'none',
			'animation-name' : 'none',
			'animation-duration' : '0',
			'-webkit-animation-duration' : '0',
			opacity : 0

		// Go through each module
		}).each(function(){

			// Current module
			dslcModule = jQuery(this);

			// Reguest new ID
			jQuery.ajax({
				type: 'POST',
				method: 'POST',
				url: DSLCAjax.ajaxurl,
				data: { action : 'dslc-ajax-get-new-module-id' },
				async: false
			}).done(function( response ) {

				// Remove "being-edited" class
				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

				// Get new ID
				dslcModuleID = response.output;

				// Apply new ID and append "being-edited" class
				dslcModule.data( 'module-id', dslcModuleID ).attr( 'id', 'dslc-module-' + dslcModuleID ).addClass('dslca-module-being-edited');

				// Reload the module, remove "being-edited" class and show module
				dslc_module_output_altered( function(){
					jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited').animate({
						opacity : 1
					}, 300);
				});

			});

		});

		// Call additional functions
		dslc_drag_and_drop();
		dslc_generate_code();
		dslc_show_publish_button();

	}

	/**
	 * Row - Import
	 */

	function dslc_row_import( rowCode ) {

		if ( dslcDebug ) console.log( 'dslc_row_import' );

		// AJAX Call
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-import-modules-section',
				dslc : 'active',
				dslc_modules_section_code : rowCode
			},
			function( response ) {

				// Close the import popup/modal
				dslc_js_confirm_close();

				// Add the new section
				jQuery('#dslc-main').append( response.output );

				// Call other functions
				dslc_bg_video();
				dslc_carousel();
				dslc_masonry( jQuery('#dslc-main').find('.dslc-modules-section:last-child') );
				dslc_drag_and_drop();
				dslc_show_publish_button();
				dslc_generate_code();

			}

		);

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	function dslc_add_modules_section() { dslc_row_add(); }
	function dslc_delete_modules_section( row  ) { dslc_row_delete( row ); }
	function dslc_edit_modules_section( row ) { dslc_row_edit( row ); }
	function dslc_edit_modules_section_colorpicker() { dslc_row_edit_colorpicker_init(); }
	function dslc_edit_modules_section_slider() { dslc_row_edit_slider_init(); }
	function dslc_edit_modules_section_scroller() { dslc_row_edit_scrollbar_init(); }
	function dslc_copy_modules_section( row ) { dslc_row_copy( row ); }
	function dslc_import_modules_section( rowCode ) { dslc_row_import( rowCode ); }

	/**
	 * Row - Document Ready Actions
	 */

	jQuery(document).ready(function($){

		/**
		 * Initialize
		 */

		dslc_row_edit_colorpicker_init();
		dslc_row_edit_slider_init();

		/**
		 * Action - Automatically Add a Row if Empty
		 */

		if ( ! $( '#dslc-main .dslc-modules-section' ).length && ! $( '#dslca-tut-page' ).length ) {
			dslc_row_add();
		}

		/**
		 * Hook - Add Row
		 */

		$(document).on( 'click', '.dslca-add-modules-section-hook', function(){

			var button = $(this);

			if ( ! $(this).hasClass('dslca-action-disabled') ) {

				// Add a loading animation
				button.find('.dslca-icon').removeClass('dslc-icon-align-justify').addClass('dslc-icon-spinner dslc-icon-spin');

				// Add a row
				dslc_row_add( function(){
					button.find('.dslca-icon').removeClass('dslc-icon-spinner dslc-icon-spin').addClass('dslc-icon-align-justify');
				});

			}

		});

		/**
		 * Hook - Edit Row
		 */

		$(document).on( 'click', '.dslca-edit-modules-section-hook', function(){

			// If not disabled ( disabling used for tutorial )
			if ( ! $(this).hasClass('dslca-action-disabled') ) {

				// If a module is being edited
				if ( jQuery('.dslca-module-being-edited.dslca-module-change-made').length ) {

					// Ask to confirm or cancel
					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_module_curr_edit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_module_curr_edit_descr + '</span>', jQuery(this) );

				// If another section is being edited
				} else if ( jQuery('.dslca-modules-section-being-edited.dslca-modules-section-change-made').length ) {

					// Ask to confirm or cancel
					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_row_curr_edit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_row_curr_edit_descr + '</span>', jQuery(this) );

				// All good to proceed
				} else {

					// Trigger the function to edit
					dslc_row_edit( $(this).closest('.dslc-modules-section') );

				}

			}

		});

		/**
		 * Hook - Confirm Row Changes
		 */

		$(document).on( 'click', '.dslca-row-edit-save', function(){

			dslc_row_edit_confirm();
			$('.dslca-row-options-filter-hook.dslca-active').removeClass('dslca-active');
			dslc_responsive_classes( true );

		});

		/**
		 * Hook - Cancel Row Changes
		 */

		$(document).on( 'click', '.dslca-row-edit-cancel', function(){

			dslc_row_edit_cancel();
			$('.dslca-row-options-filter-hook.dslca-active').removeClass('dslca-active');
			dslc_responsive_classes( true );

		});

		/**
		 * Hook - Copy Row
		 */

		$(document).on( 'click', '.dslca-copy-modules-section-hook', function() {

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_row_copy( $(this).closest('.dslc-modules-section') );
			}

		});

		/**
		 * Hook - Import Row
		 */

		$(document).on( 'click', '.dslca-import-modules-section-hook', function(e) {

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span><span>' + DSLCString.str_import + '</span><div class="dslca-loading followingBallsGWrap"><div class="followingBallsG_1 followingBallsG"></div><div class="followingBallsG_2 followingBallsG"></div><div class="followingBallsG_3 followingBallsG"></div><div class="followingBallsG_4 followingBallsG"></div></div>');
				dslc_js_confirm( 'import_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_import_row_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_import_row_descr + ' <br><br><textarea></textarea></span>', $(this) );
			}

		});


		/**
		 * Hook - Delete Row
		 */

		$(document).on( 'click', '.dslca-delete-modules-section-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_js_confirm( 'delete_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_row_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_row_descr + '</span>', $(this) );
			}

		});

		/**
		 * Hook - Export Row
		 */

		$(document).on( 'click', '.dslca-export-modules-section-hook', function(e) {

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				$('.dslca-prompt-modal-cancel-hook').hide();
				$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>' + DSLCString.str_ok);
				dslc_js_confirm( 'export_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_export_row_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_export_row_descr + ' <br><br><textarea></textarea></span>', $(this) );
				$('.dslca-prompt-modal textarea').val( dslc_generate_section_code( $(this).closest('.dslc-modules-section') ) );
			}

		});

	});


/*********************************
 *
 * 7) = AREAS ( MODULE AREAS ) =
 *
 * - dslc_modules_area_add ( Adds a new modules area )
 * - dslc_modules_area_delete ( Deletes modules area )
 * - dslc_modules_area_width_set ( Sets specific width to the modules area )
 * - dslc_copy_modules_area ( Copies modules area )
 *
 ***********************************/

 	/**
 	 * AREAS - Add New
 	 */

 	function dslc_modules_area_add( row ) {

		if ( dslcDebug ) console.log( 'dslc_add_modules_area' );

		// Add class to body so we know it's in progress
		jQuery('body').addClass('dslca-anim-in-progress');

		// AJAX call to add new area
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-add-modules-area',
				dslc : 'active'
			},
			function( response ) {

				// Loading Animation
				jQuery('.dslca-modules-area-loading .dslca-module-loading-inner', row.closest('.dslc-modules-section') ).stop().animate({
					width : '100%'
				}, 200, 'linear', function(){
					row.css({ paddingBottom : 0 });
					jQuery(this).closest('.dslca-modules-area-loading').hide();
				});

				// Handle adding after animation done
				setTimeout( function(){

					// Append new area and animate
					jQuery( response.output ).appendTo( row ).css({ height : 0 }).animate({
						height : 99
					}, 300, function(){
						jQuery(this).css({ height : 'auto' })
					}).addClass('dslca-init-animation');

					// Call other functions
					dslc_drag_and_drop();
					dslc_generate_code();
					dslc_show_publish_button();

					// Remove class from body so we know it's done
					jQuery('body').removeClass('dslca-anim-in-progress');

				}, 250 );

			}

		);

		// Animate loading
		var randomLoadingTime = Math.floor(Math.random() * (100 - 50 + 1) + 50) * 100;
		row.animate({ paddingBottom : 50 }, 150);
		jQuery('.dslca-modules-area-loading', row.closest('.dslc-modules-section') ).show();
		jQuery('.dslca-modules-area-loading .dslca-module-loading-inner', row.closest('.dslc-modules-section') ).css({ width : 0 }).animate({
			width : '100%'
		}, randomLoadingTime, 'linear' );

	}

	/**
	 * AREAS - Delete
	 */

	function dslc_modules_area_delete( area ) {

		if ( dslcDebug ) console.log( 'dslc_delete_modules_area' );

		// Vars
		var modulesSection = area.closest('.dslc-modules-section').find('.dslc-modules-section-inner'),
		dslcAddNew = false;

		// Add a class to the area so we know it's being deleted
		area.addClass('dslca-modules-area-being-deleted');

		// If it's the last area in the row add a new one after deletion
		if ( modulesSection.find('.dslc-modules-area').length < 2 )
			dslcAddNew = true;

		// If a module in the area is being edited
		if ( area.find('.dslca-module-being-edited').length ) {

			// Hide the filter hooks
			jQuery('.dslca-header .dslca-options-filter-hook').hide();

			// Hide the save/cancel actions
			jQuery('.dslca-module-edit-actions').hide();

			// Show the section hooks
			jQuery('.dslca-header .dslca-go-to-section-hook').show();

			// Show the modules listing
			dslc_show_section('.dslca-modules');

		}

		// Set a timeout so we handle deletion after animation ends
		setTimeout( function(){

			// Remove the area
			area.remove();

			// Call other functions
			dslc_generate_code();
			dslc_show_publish_button();

			// Add new modules are if the row is now empty
			if ( dslcAddNew ) dslc_modules_area_add( modulesSection );

		}, 900 );

		// Animation
		area.css({
			'-webkit-animation-name' : 'dslcBounceOut',
			'-moz-animation-name' : 'dslcBounceOut',
			'animation-name' : 'dslcBounceOut',
			'animation-duration' : '0.6s',
			'-webkit-animation-duration' : '0.6s',
			'overflow' : 'hidden'
		}).animate({
			opacity : 0
		}, 600).animate({
			height : 0,
			marginBottom : 0
		}, 300, function(){
			area.remove();
			dslc_generate_code();
			dslc_show_publish_button();
		});

	}

	/**
	 * AREAS - Copy
	 */

	function dslc_modules_area_copy( area ) {

		if ( dslcDebug ) console.log( 'dslc_copy_modules_area' );

		// Vars
		var dslcModuleID,
		modulesSection = area.closest('.dslc-modules-section').find('.dslc-modules-section-inner');

		// Copy the area and append to the row
		var dslcModulesAreaCloned = area.clone().appendTo(modulesSection);

		// Trigger mouseleave ( so the actions that show on hover go away )
		dslcModulesAreaCloned.find('.dslca-modules-area-manage').trigger('mouseleave');

		// Apply correct data size and get rid of animations
		dslcModulesAreaCloned.data('size', area.data('size') ).find('.dslc-module-front').css({
			'-webkit-animation-name' : 'none',
			'-moz-animation-name' : 'none',
			'animation-name' : 'none',
			'animation-duration' : '0',
			'-webkit-animation-duration' : '0',
			opacity : 0

		// Go through each module in the area
		}).each(function(){

			var dslcModule = jQuery(this);

			// Reguest new ID
			jQuery.ajax({
				type: 'POST',
				method: 'POST',
				url: DSLCAjax.ajaxurl,
				data: { action : 'dslc-ajax-get-new-module-id' },
				async: false
			}).done(function( response ) {

				// Remove being edited class
				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

				// Store the new ID
				dslcModuleID = response.output;

				// Apply the new ID and add being edited class
				dslcModule.data( 'module-id', dslcModuleID ).attr( 'id', 'dslc-module-' + dslcModuleID ).addClass('dslca-module-being-edited');

				// Reload the module
				dslc_module_output_altered( function(){

					// Remove being edited class and show the module
					jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited').animate({
						opacity : 1
					}, 300);

				});

			});

		});

		// Call other functions
		dslc_drag_and_drop();
		dslc_generate_code();
		dslc_show_publish_button();

	}

	/**
	 * AREAS - Set Width
	 */

	function dslc_modules_area_width_set( area, newWidth ) {

		if ( dslcDebug ) console.log( 'dslc_modules_area_width_set' );

		// Generate new class based on width
		var newClass = 'dslc-' + newWidth + '-col';

		// Remove width classes, add new width class and set the data-size attr
		area
			.removeClass('dslc-1-col dslc-2-col dslc-3-col dslc-4-col dslc-5-col dslc-6-col dslc-7-col dslc-8-col dslc-9-col dslc-10-col dslc-11-col dslc-12-col')
			.addClass(newClass)
			.data('size', newWidth);

		// Call other functions
		dslc_init_square();
		dslc_center();
		dslc_generate_code();
		dslc_show_publish_button();
		dslc_masonry();

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	function dslc_add_modules_area( row ) { dslc_modules_area_add( row ); }
	function dslc_delete_modules_area( area ) { dslc_modules_area_delete( area ); }
	function dslc_copy_modules_area( area ) { dslc_modules_area_copy( area ); }

	/**
	 * AREAS - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Hook - Add Area
		 */

		$(document).on( 'click', '.dslca-add-modules-area-hook', function(e){

			e.preventDefault();

			dslc_modules_area_add( jQuery(this).closest('.dslc-modules-section').find('.dslc-modules-section-inner') );

		});

		/**
		 * Hook - Delete Area
		 */

		$(document).on( 'click', '.dslca-delete-modules-area-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_js_confirm( 'delete_modules_area', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_area_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_area_descr + '</span>', $(this) );
			}

		});

		/**
		 * Hook - Copy Area
		 */

		$(document).on( 'click', '.dslca-copy-modules-area-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				var modulesArea = $(this).closest('.dslc-modules-area');
				dslc_copy_modules_area( modulesArea );
			}

		});

		/**
		 * Hook - Set Width
		 */

		$(document).on( 'click', '.dslca-change-width-modules-area-options span', function(){

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_modules_area_width_set( jQuery(this).closest('.dslc-modules-area'), jQuery(this).data('size') );
			}

		});

		/**
		 * Action - Show/Hide Width Options
		 */

		$(document).on( 'click', '.dslca-change-width-modules-area-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {

				// Is visible
				if ( $('.dslca-change-width-modules-area-options:visible', this).length ) {

					// Hide
					$('.dslca-change-width-modules-area-options', this).hide();

				// Is hidden
				} else {

					// Set active
					$('.dslca-change-width-modules-area-options .dslca-active-width').removeClass('dslca-active-width');
					var currSize = $(this).closest('.dslc-modules-area').data('size');
					$('.dslca-change-width-modules-area-options span[data-size="' + currSize + '"]').addClass('dslca-active-width');

					// Show
					$('.dslca-change-width-modules-area-options', this).show();

				}

			}

		});


	});


/*********************************
 *
 * 8) = MODULES =
 *
 * - dslc_module_delete ( Deletes a module )
 * - dslc_module_copy ( Copies a module )
 * - dslc_module_width_set ( Sets a width to module )
 * - dslc_module_options_show ( Show module options )
 * - dslc_module_options_scrollbar ( Scrollbar for options )
 * - dslc_module_options_section_filter ( Filter options section )
 * - dslc_module_options_tab_filter ( Filter options tab )
 * - dslc_module_options_hideshow_tabs ( Hide show tabs based on option choices )
 * - dslc_module_options_confirm_changes ( Confirm changes )
 * - dslc_module_options_cancel_changes ( Cancel changes )
 * - dslc_module_options_tooltip ( Helper tooltips for options )
 * - dslc_module_options_font ( Actions for font option type )
 * - dslc_module_options_icon ( Actions for icon font option type )
 * - dslc_module_options_icon_returnid (Fill icon option type with selected icon ID/name)
 * - dslc_module_options_text_align ( Actions for text align option type )
 * - dslc_module_options_checkbox ( Actions for checkbox option type )
 * - dslc_module_options_box_shadow ( Actions for box shadow option type )
 * - dslc_modules_options_box_shadow_color ( Initiate colorpicker for box shadow)
 * - dslc_module_options_text_shadow ( Actions for text shadow option type )
 * - dslc_modules_options_text_shadow_color ( Initiate colorpicker for text shadow)
 * - dslc_module_options_color ( Actions for color option type )
 * - dslc_module_output_default ( Get module output with default settings )
 * - dslc_module_output_altered ( Get module output when settings altered )

 ***********************************/

 	/**
 	 * MODULES - Delete a Module
 	 */

 	function dslc_module_delete( module ) {

		if ( dslcDebug ) console.log( 'dslc_delete_module' );

		// Add class to module so we know it's being deleted
		module.addClass('dslca-module-being-deleted');

		// If the module is being edited switch to modules listing
		if ( module.hasClass('dslca-module-being-edited') ) {
			dslc_show_section( '.dslca-modules' );
		}

		// Handle deletion with a delay ( for animations to finish )
		setTimeout( function(){

			// Remove module, regenerate code, show publish button
			module.remove();
			dslc_generate_code();
			dslc_show_publish_button();

		}, 1000 );

		// Animations ( bounce out + invisible )
		module.css({
			'-webkit-animation-name' : 'dslcBounceOut2',
			'-moz-animation-name' : 'dslcBounceOut2',
			'animation-name' : 'dslcBounceOut2',
			'animation-duration' : '0.6s',
			'-webkit-animation-duration' : '0.6s'
		}).animate({ opacity : 0 }, 500, function(){

			// Animations ( height to 0 for a slide effect )
			module.css({ marginBottom : 0 }).animate({ height: 0 }, 400, 'easeOutQuart');

		});

	}

	/**
	 * Modules - Copy a Module
	 */

	function dslc_module_copy( module ) {

		if ( dslcDebug ) console.log( 'dslc_copy_module' );

		// Vars
		var dslcModuleID;

		// AJX reguest new ID
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-get-new-module-id',
			},
			function( response ) {

				// Remove being edited class if some module is being edited
				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

				// Store the new ID
				dslcModuleID = response.output;

				// Duplicate the module and append it to the same area
				module.clone().appendTo( module.closest( '.dslc-modules-area' ) ).css({
					'-webkit-animation-name' : 'none',
					'-moz-animation-name' : 'none',
					'animation-name' : 'none',
					'animation-duration' : '0',
					'-webkit-animation-duration' : '0',
					opacity : 0
				}).data( 'module-id', dslcModuleID ).attr( 'id', 'dslc-module-' + dslcModuleID ).addClass('dslca-module-being-edited');

				// Reload module
				dslc_module_output_altered( function(){

					// Fade in the module
					jQuery('.dslca-module-being-edited').css({ opacity : 0 }).removeClass('dslca-module-being-edited').animate({ opacity : 1 }, 300);

				});

			}

		);

	}

	/**
	 * MODULES - Set Width
	 */

	function dslc_module_width_set( module, newWidth ) {

		if ( dslcDebug ) console.log( 'dslc_module_width_set' );

		// Generate new column class
		var newClass = 'dslc-' + newWidth + '-col';

		// Add new column class and change size "data"
		module
			.removeClass('dslc-1-col dslc-2-col dslc-3-col dslc-4-col dslc-5-col dslc-6-col dslc-7-col dslc-8-col dslc-9-col dslc-10-col dslc-11-col dslc-12-col')
			.addClass(newClass)
			.data('dslc-module-size', newWidth)
			.addClass('dslca-module-being-edited');

		// Change the module size field
		jQuery( '.dslca-module-option-front[data-id="dslc_m_size"]', module ).val( newWidth );

		// Preview Change
		dslc_module_output_altered( function(){
			jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');
		});

	}

	/**
	 * MODULES - Show module options
	 */

	function dslc_module_options_show( moduleID ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_show' );

		// Vars
		var dslcModule = jQuery('.dslca-module-being-edited'),
		dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
		dslcDefaultSection = jQuery('.dslca-header').data('default-section');

		// Settings array
		var dslcSettings = {};
		dslcSettings['action'] = 'dslc-ajax-display-module-options';
		dslcSettings['dslc'] = 'active';
		dslcSettings['dslc_module_id'] = moduleID;
		dslcSettings['dslc_post_id'] = jQuery('.dslca-container').data('data-post-id');

		// Go through each option
		dslcModuleOptions.each(function(){

			// Vars
			var dslcOption = jQuery(this),
			dslcOptionID = dslcOption.data('id'),
			dslcOptionValue = dslcOption.val();

			// Add option ID and value to the settings array
			dslcSettings[dslcOptionID] = dslcOptionValue;

		});

		// Hide the save/cancel actions for text editor and show notification
		jQuery('.dslca-wp-editor-actions').hide();
		jQuery('.dslca-wp-editor-notification').show();

		// AJAX call to get options HTML
		jQuery.post(
			DSLCAjax.ajaxurl,
			dslcSettings,
			function( response ) {

				// Hide the publish button
				jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'hidden' });
				jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'hidden' });

				// Show edit section
				dslc_show_section('.dslca-module-edit');

				// Add the options
				if ( ! jQuery('body').hasClass('rtl') ) {
					jQuery('.dslca-module-edit-options-inner .jspPane').html( response.output );
				} else {
					jQuery('.dslca-module-edit-options-inner').html( response.output );
				}
				jQuery('.dslca-module-edit-options-tabs').html( response.output_tabs );

				// Show the filter hooks
				jQuery('.dslca-header .dslca-options-filter-hook').show();

				// Trigger click on first filter hook
				if ( jQuery('.dslca-module-edit-option[data-section="' + dslcDefaultSection + '"]').length ) {
					jQuery('.dslca-header .dslca-options-filter-hook[data-section="' + dslcDefaultSection + '"]').show();
					jQuery('.dslca-header .dslca-options-filter-hook[data-section="' + dslcDefaultSection + '"]').trigger('click');
				} else {
					jQuery('.dslca-header .dslca-options-filter-hook:first').hide();
					jQuery('.dslca-header .dslca-options-filter-hook:first').next('.dslca-options-filter-hook').trigger('click');
				}

				// Show the save/cancel actions
				jQuery('.dslca-module-edit-actions').show();

				// Show the save/cancel actions for text editor and hide notification
				jQuery('.dslca-wp-editor-notification').hide();
				jQuery('.dslca-wp-editor-actions').show();

				// Hide the section hooks
				jQuery('.dslca-header .dslca-go-to-section-hook').hide();

				// Hide the row save/cancel actions
				jQuery('.dslca-row-edit-actions').hide();

				// Initiate Colorpicker
				dslc_module_options_color();
				dslc_modules_options_box_shadow_color();
				dslc_modules_options_text_shadow_color();
				dslc_module_options_numeric();

				// Set up backup
				var moduleBackup = jQuery('.dslca-module-options-front', '.dslca-module-being-edited').children().clone();
				jQuery('.dslca-module-options-front-backup').html('').append(moduleBackup);

			}

		);

	}

	/**
	 * MODULES - Options Scrollbar
	 */

	function dslc_module_options_scrollbar() {

		if ( dslcDebug ) console.log( 'dslc_module_options_scrollbar' );

		var dslcWidth = 0;

		jQuery('.dslca-module-edit-option:visible').each(function(){
			dslcWidth += jQuery(this).outerWidth(true) + 1;
		});

		if ( dslcWidth > jQuery( '.dslca-module-edit-options' ).width() ) {
			jQuery('.dslca-module-edit-options-wrapper').width( dslcWidth );
		} else {
			jQuery('.dslca-module-edit-options-wrapper').width( 'auto' );
		}

		if ( ! jQuery('body').hasClass('rtl') ) {

			if ( jQuery('.dslca-module-edit-options-inner').data('jsp') ) {
				var scroller = jQuery('.dslca-module-edit-options-inner').data('jsp');
				scroller.reinitialise();
			}

		}

	}

	/**
	 * MODULES - Filter Module Options
	 */

	function dslc_module_options_section_filter( sectionID ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_section_filter' );

		// Hide all options
		jQuery('.dslca-module-edit-option').hide();

		// Show options for current section
		jQuery('.dslca-module-edit-option[data-section="' + sectionID + '"]').show();

		// Recall module options tab
		dslc_module_options_tab_filter();

	}

	/**
	 * MODULES - Show module options tab
	 */

	function dslc_module_options_tab_filter( dslcTab ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_tab_filter' );

		// Get currently active section
		var dslcSectionID = jQuery('.dslca-options-filter-hook.dslca-active').data('section');

		// If tab not supplied set to first
		dslcTab = typeof dslcTab !== 'undefined' ? dslcTab : jQuery('.dslca-module-edit-options-tab-hook[data-section="' + dslcSectionID + '"]:first');

		// Get the tab ID
		var dslcTabID = dslcTab.data('id');

		// Set active class on tab
		jQuery('.dslca-module-edit-options-tab-hook').removeClass('dslca-active');
		dslcTab.addClass('dslca-active');

		// Show tabs container
		jQuery('.dslca-module-edit-options-tabs').show();

		// Hide/Show tabs hooks
		jQuery('.dslca-module-edit-options-tab-hook').hide();
		jQuery('.dslca-module-edit-options-tab-hook[data-section="' + dslcSectionID + '"]').show();

		if ( dslcTabID ) {

			// Hide/Show options
			jQuery('.dslca-module-edit-option').hide();
			jQuery('.dslca-module-edit-option[data-tab="' + dslcTabID + '"]').show();

			// Recreate scrollbar
			dslc_module_options_scrollbar();

			// Hide/Show Tabs
			dslc_module_options_hideshow_tabs();

			// If only one tab hide the tabs container
			if ( jQuery('.dslca-module-edit-options-tab-hook:visible').length < 2 ) {
				jQuery('.dslca-module-edit-options-tabs').hide();
			} else {
				jQuery('.dslca-module-edit-options-tabs').show();
			}

			/**
			 * If responsive tab, change the width of the dslc-content div
			 */

			// Tablet
			if ( dslcTabID == DSLCString.str_res_tablet + '_responsive' ) {
				jQuery('body').removeClass('dslc-res-big dslc-res-smaller-monitor dslc-res-phone dslc-res-tablet');
				jQuery('body').addClass('dslc-res-tablet');
			}

			// Phone
			if ( dslcTabID == DSLCString.str_res_phone + '_responsive' ) {
				jQuery('body').removeClass('dslc-res-big dslc-res-smaller-monitor dslc-res-phone dslc-res-tablet');
				jQuery('body').addClass('dslc-res-phone');
			}

			// If responsive reload module
			if ( dslcTabID == DSLCString.str_res_tablet + '_responsive' || dslcTabID == DSLCString.str_res_phone + '_responsive' ) {

				// Show the loader
				jQuery('.dslca-container-loader').show();

				// Reload Module
				dslc_module_output_altered(function(){

					// Hide the loader
					jQuery('.dslca-container-loader').hide();

				});

			}

		}

	}

	/**
	 * MODULES - Hide show tabs based on option choices
	 */

	function dslc_module_options_hideshow_tabs() {

		if ( dslcDebug ) console.log( 'dslc_module_options_hideshow_tabs' );

		var dslcSectionID = jQuery('.dslca-options-filter-hook.dslca-active').data('section');

		if ( dslcSectionID == 'styling' ) {

			// Vars
			var dslcContainer = jQuery('.dslca-module-edit'),
			dslcHeading = true,
			dslcFilters = true,
			dslcCarArrows = true,
			dslcCarCircles = true,
			dslcPagination = true,
			dslcElThumb = true,
			dslcElTitle = true,
			dslcElExcerpt = true,
			dslcElMeta = true,
			dslcElButton = true,
			dslcElCats = true,
			dslcElCount = true,
			dslcElSeparator = true,
			dslcElTags = true,
			dslcElSocial = true,
			dslcElPosition = true,
			dslcElIcon = true,
			dslcElContent = true,
			dslcElPrice = true,
			dslcElPriceSec = true,
			dslcElAddCart = true,
			dslcElDetails = true,
			dslcElQuote = true,
			dslcElAuthorName = true,
			dslcElAuthorPos = true;


			// Is heading selected?
			if ( ! jQuery('.dslca-module-edit-field[value="main_heading"]').is(':checked') )
				dslcHeading = false;

			// Are filters selected?
			if ( ! jQuery('.dslca-module-edit-field[value="filters"]').is(':checked') )
				dslcFilters = false;

			// Are arrows selected?
			if ( ! jQuery('.dslca-module-edit-field[value="arrows"]').is(':checked') )
				dslcCarArrows = false;

			// Are circles selected?
			if ( ! jQuery('.dslca-module-edit-field[value="circles"]').is(':checked') )
				dslcCarCircles = false;

			// Is it a carousel?
			if ( jQuery('.dslca-module-edit-field[data-id="type"]').val() != 'carousel' ) {
				dslcCarArrows = false;
				dslcCarCircles = false;
			}

			// Is pagination enabled?
			if ( jQuery('.dslca-module-edit-field[data-id="pagination_type"]').val() == 'disabled' ) {
				dslcPagination = false;
			}

			// Is thumb enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="thumbnail"]').is(':checked') ) {
				dslcElThumb = false;
			}

			// Is title enabled?
			if ( jQuery('.dslca-module-edit-field[data-id*="elements"][value="content"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="title"]').is(':checked') ) {
				dslcElTitle = false;
			}

			// Is excerpt enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="excerpt"]').is(':checked') ) {
				dslcElExcerpt = false;
			}

			// Is meta enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="meta"]').is(':checked') ) {
				dslcElMeta = false;
			}

			// Is button enabled?
			if ( jQuery('.dslca-module-edit-field[data-id*="elements"][value="button"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="button"]').is(':checked') ) {
				dslcElButton = false;
			}

			// Are cats enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="categories"]').is(':checked') ) {
				dslcElCats = false;
			}

			// Is separator enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="separator"]').is(':checked') ) {
				dslcElSeparator = false;
			}

			// Is count enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="count"]').is(':checked') ) {
				dslcElCount = false;
			}

			// Are tags enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="tags"]').is(':checked') ) {
				dslcElTags = false;
			}

			// Are social link enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="social"]').is(':checked') ) {
				dslcElSocial = false;
			}

			// Is position enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="position"]').is(':checked') ) {
				dslcElPosition = false;
			}

			// Is icon enabled?
			if ( jQuery('.dslca-module-edit-field[data-id*="elements"][value="icon"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="icon"]').is(':checked') ) {
				dslcElIcon = false;
			}

			// Is content enabled?
			if (  jQuery('.dslca-module-edit-field[data-id*="elements"][value="content"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="content"]').is(':checked') ) {
				dslcElContent = false;
			}

			// Is price enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="price"]').is(':checked') ) {
				dslcElPrice = false;
			}

			// Is price secondary enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="price_2"]').is(':checked') ) {
				dslcElPriceSec = false;
			}

			// Is add to cart enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="addtocart"]').is(':checked') ) {
				dslcElAddCart = false;
			}

			// Is add to cart enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="details"]').is(':checked') ) {
				dslcElDetails = false;
			}

			// Is quote enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="quote"]').is(':checked') ) {
				dslcElQuote = false;
			}

			// Is author name enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="author_name"]').is(':checked') ) {
				dslcElAuthorName = false;
			}

			// Is author position enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="author_position"]').is(':checked') ) {
				dslcElAuthorPos = false;
			}


			// Show/Hide Heading
			if ( dslcHeading )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="heading_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="heading_styling"]').hide();

			// Show/Hide Filters
			if ( dslcFilters )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="filters_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="filters_styling"]').hide();

			// Show/Hide Carousel Arrows
			if ( dslcCarArrows )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_arrows_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_arrows_styling"]').hide();

			// Show/Hide Carousel Circles
			if ( dslcCarCircles )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_circles_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_circles_styling"]').hide();

			// Show/Hide Pagination
			if ( dslcPagination )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="pagination_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="pagination_styling"]').hide();

			// Show/Hide Thumb
			if ( dslcElThumb )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="thumbnail_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="thumbnail_styling"]').hide();

			// Show/Hide Title
			if ( dslcElTitle )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="title_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="title_styling"]').hide();

			// Show/Hide Excerpt
			if ( dslcElExcerpt )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="excerpt_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="excerpt_styling"]').hide();

			// Show/Hide Meta
			if ( dslcElMeta )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="meta_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="meta_styling"]').hide();

			// Show/Hide Button
			if ( dslcElButton )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="button_styling"], .dslca-module-edit-options-tab-hook[data-id="primary_button_styling"], .dslca-module-edit-options-tab-hook[data-id="secondary_button_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="button_styling"], .dslca-module-edit-options-tab-hook[data-id="primary_button_styling"], .dslca-module-edit-options-tab-hook[data-id="secondary_button_styling"]').hide();

			// Show/Hide Cats
			if ( dslcElCats )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="categories_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="categories_styling"]').hide();

			// Show/Hide Separator
			if ( dslcElSeparator )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="separator_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="separator_styling"]').hide();

			// Show/Hide Count
			if ( dslcElCount )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="count_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="count_styling"]').hide();

			// Show/Hide Tags
			if ( dslcElTags )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="tags_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="tags_styling"]').hide();

			// Show/Hide Tags
			if ( dslcElPosition )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="position_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="position_styling"]').hide();

			// Show/Hide Tags
			if ( dslcElSocial )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="social_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="social_styling"]').hide();

			// Show/Hide Icon
			if ( dslcElIcon )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="icon_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="icon_styling"]').hide();

			// Show/Hide Content
			if ( dslcElContent )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="content_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="content_styling"]').hide();

			// Show/Hide Price
			if ( dslcElPrice )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="price_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="price_styling"]').hide();

			// Show/Hide Price Sec
			if ( dslcElPriceSec )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="price_secondary_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="price_secondary_styling"]').hide();

			// Show/Hide Add to Cart
			if ( dslcElAddCart || dslcElDetails )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="other_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="other_styling"]').hide();

			// Show/Hide Quote
			if ( dslcElQuote )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="quote_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="quote_styling"]').hide();

			// Show/Hide Author Name
			if ( dslcElAuthorName )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="author_name_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="author_name_styling"]').hide();

			// Show/Hide Author Position
			if ( dslcElAuthorPos )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="author_position_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="author_position_styling"]').hide();

		}

		/**
		 * Text Module
		 */

		if ( jQuery('.dslca-options-filter-hook[data-section="styling"]').hasClass('dslca-active') ) {

			if ( jQuery('.dslca-module-being-edited').data('dslc-module-id') == 'DSLC_Text_Simple' || jQuery('.dslca-module-being-edited').data('dslc-module-id') == 'DSLC_TP_Content' || jQuery('.dslca-module-being-edited').data('dslc-module-id') == 'DSLC_Html' ) {

				var dslcCustomCSS = jQuery('.dslca-module-edit-option[data-id="css_custom"]'),
				dslcCustomCSSVal = dslcCustomCSS.find('select').val();

				if ( dslcCustomCSSVal == 'enabled' ) {
					jQuery('.dslca-module-edit-option[data-section="styling"]').css({ visibility : 'visible' });
					jQuery('.dslca-module-edit-options-tabs').show();
				} else {
					jQuery('.dslca-module-edit-option[data-section="styling"]').css({ visibility : 'hidden' });
					jQuery('.dslca-module-edit-options-tabs').hide();
					dslcCustomCSS.css({ visibility : 'visible' });
				}

			}

		} else {
			jQuery('.dslca-module-edit-options-tabs').show();
		}

		if ( jQuery('select.dslca-module-edit-field[data-id="css_res_t"]').val() == 'disabled' ) {
			jQuery('.dslca-module-edit-option[data-id*="css_res_t"]').css( 'visibility', 'hidden' );
		} else {
			jQuery('.dslca-module-edit-option[data-id*="css_res_t"]').css( 'visibility', 'visible' );
		}

		if ( jQuery('select.dslca-module-edit-field[data-id="css_res_p"]').val() == 'disabled' ) {
			jQuery('.dslca-module-edit-option[data-id*="css_res_p"]').css( 'visibility', 'hidden' );
		} else {
			jQuery('.dslca-module-edit-option[data-id*="css_res_p"]').css( 'visibility', 'visible' );
		}

		jQuery('.dslca-module-edit-option[data-id="css_res_p"], .dslca-module-edit-option[data-id="css_res_t"]').css( 'visibility', 'visible' );

	}

	/**
	 * MODULES - Confirm module options changes
	 */

	function dslc_module_options_confirm_changes( callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_confirm_changes' );

		// Callback
		callback = typeof callback !== 'undefined' ? callback : false;

		// If slider module
		if ( jQuery('.dslca-module-being-edited').hasClass('dslc-module-DSLC_Sliders') ) {

			jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

		// If not slider module
		} else {

			// Add class so we know saving is in progress
			jQuery('body').addClass('dslca-module-saving-in-progress');

			// Reload module with new settings
			dslc_module_output_altered( function(){

				// Update preset
				dslc_update_preset();

				// Remove classes so we know saving finished
				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');
				jQuery('body').removeClass('dslca-module-saving-in-progress');

				// Clean up options container
				if ( ! jQuery('body').hasClass('rtl') ) {
					jQuery('.dslca-module-edit-options-inner .jspPane').html('');
				} else {
					jQuery('.dslca-module-edit-options-inner').html('');
				}
				jQuery('.dslca-module-edit-options-tabs').html('');

				// Callback if there's one
				if ( callback ) { callback(); }

			});

		}

		// Show modules listing
		dslc_show_section('.dslca-modules');

		// Hide the filter hooks
		jQuery('.dslca-header .dslca-options-filter-hook').hide();

		// Hide the save/cancel actions
		jQuery('.dslca-module-edit-actions').hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

	}

	/**
	 * MODULES - Cancel module options changes
	 */

	function dslc_module_options_cancel_changes( callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_cancel_changes' );

		// Callback
		callback = typeof callback !== 'undefined' ? callback : false;

		// Vars
		var editedModule = jQuery('.dslca-module-being-edited'),
		originalOptions = jQuery('.dslca-module-options-front-backup').children().clone();

		// Add backup option values
		jQuery('.dslca-module-options-front', editedModule).html('').append(originalOptions);

		// Reload module
		dslc_module_output_altered( function(){

			jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

			// Clean up options container
			if ( ! jQuery('body').hasClass('rtl') ) {
				jQuery('.dslca-module-edit-options-inner .jspPane').html('');
			} else {
				jQuery('.dslca-module-edit-options-inner').html('');
			}
			jQuery('.dslca-module-edit-options-tabs').html('');

			if ( callback ) { callback(); }

		});

		// Show modules listing
		dslc_show_section('.dslca-modules');

		// Hide the filter hooks
		jQuery('.dslca-header .dslca-options-filter-hook').hide();

		// Hide the save/cancel actions
		jQuery('.dslca-module-edit-actions').hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });


	}

	/**
	 * MODULES - Option Tooltips
	 */

	function dslc_module_options_tooltip() {

		// Close Tooltip

		jQuery(document).on( 'click', '.dslca-module-edit-field-ttip-close', function(){
			jQuery('.dslca-module-edit-field-ttip, .dslca-module-edit-field-icon-ttip').hide();
		});

		// Show Tooltip

		jQuery(document).on( 'click', '.dslca-module-edit-field-ttip-hook', function(){

			var dslcTtip = jQuery('.dslca-module-edit-field-ttip'),
			dslcTtipInner = dslcTtip.find('.dslca-module-edit-field-ttip-inner'),
			dslcHook = jQuery(this),
			dslcTtipContent = dslcHook.closest('.dslca-module-edit-option').find('.dslca-module-edit-field-ttip-content').html();

			if ( dslcTtip.is(':visible') ) {

				jQuery('.dslca-module-edit-field-ttip').hide();

			} else {

				dslcTtipInner.html( dslcTtipContent );

				var dslcOffset = dslcHook.offset();
				var dslcTtipHeight = dslcTtip.outerHeight();
				var dslcTtipWidth = dslcTtip.outerWidth();
				var dslcTtipLeft = dslcOffset.left - ( dslcTtipWidth / 2 ) + 6;
				var dslcTtipArrLeft = '50%';

				if ( dslcTtipLeft < 0 ) {
					dslcTtipArrLeft = ( dslcTtipWidth / 2 ) + dslcTtipLeft + 'px';
					dslcTtipLeft = 0;
				}

				jQuery('.dslca-module-edit-field-ttip').show().css({
					top : dslcOffset.top - dslcTtipHeight - 20,
					left: dslcTtipLeft
				});

				jQuery("head").append(jQuery('<style>.dslca-module-edit-field-ttip:after, .dslca-module-edit-field-ttip:before { left: ' + dslcTtipArrLeft + ' }</style>'));

			}

		});

		// Show Tooltip ( Icon Options )

		jQuery(document).on( 'click', '.dslca-module-edit-field-icon-ttip-hook', function(){

			var dslcTtip = jQuery('.dslca-module-edit-field-icon-ttip');
			var dslcHook = jQuery(this);

			if ( dslcTtip.is(':visible') ) {

				jQuery('.dslca-module-edit-field-icon-ttip').hide();

			} else {

				var dslcOffset = dslcHook.offset();
				var dslcTtipHeight = dslcTtip.outerHeight();
				var dslcTtipWidth = dslcTtip.outerWidth();
				var dslcTtipLeft = dslcOffset.left - ( dslcTtipWidth / 2 ) + 6;
				var dslcTtipArrLeft = '50%';

				if ( dslcTtipLeft < 0 ) {
					dslcTtipArrLeft = ( dslcTtipWidth / 2 ) + dslcTtipLeft + 'px';
					dslcTtipLeft = 0;
				}

				jQuery('.dslca-module-edit-field-icon-ttip').show().css({
					top : dslcOffset.top - dslcTtipHeight - 20,
					left: dslcTtipLeft
				});

				jQuery("head").append(jQuery('<style>.dslca-module-edit-field-icon-ttip:after, .dslca-module-edit-field-icon-ttip:before { left: ' + dslcTtipArrLeft + ' }</style>'));

			}

		});

	}

	/**
	 * MODULES - Font option type
	 */

	function dslc_module_options_font() {

		// Next Font

		jQuery(document).on( 'click', '.dslca-module-edit-field-font-next',  function(e){

			e.preventDefault();

			if ( ! jQuery(this).hasClass('dslca-font-loading') && ! jQuery(this).siblings('.dslca-font-loading').length ) {

				var dslcOption = jQuery(this).closest('.dslca-module-edit-option-font');
				var dslcField = jQuery( '.dslca-module-edit-field-font', dslcOption );
				var dslcCurrIndex = dslcAllFontsArray.indexOf( dslcField.val() );
				var dslcNewIndex = dslcCurrIndex + 1;

				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');

				dslcField.val( dslcAllFontsArray[dslcNewIndex] ).trigger('change');

				jQuery(this).addClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-chevron-right').addClass('dslc-icon-refresh dslc-icon-spin');

			}

		});

		// Previous Font

		jQuery(document).on( 'click', '.dslca-module-edit-field-font-prev',  function(e){

			e.preventDefault();

			if ( ! jQuery(this).hasClass('dslca-font-loading') && ! jQuery(this).siblings('.dslca-font-loading').length ) {

				var dslcOption = jQuery(this).closest('.dslca-module-edit-option-font');
				var dslcField = jQuery( '.dslca-module-edit-field-font', dslcOption );
				var dslcCurrIndex = dslcAllFontsArray.indexOf( dslcField.val() );
				var dslcNewIndex = dslcCurrIndex - 1;

				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');

				if ( dslcNewIndex < 0 ) {
					dslcNewIndex = dslcAllFontsArray.length - 1
				}

				dslcField.val( dslcAllFontsArray[dslcNewIndex] ).trigger('change');

				jQuery(this).addClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-chevron-left').addClass('dslc-icon-refresh dslc-icon-spin');

			}

		});

		// Keyup ( left arrow, right arrow, else )

		jQuery(document).on( 'keyup', '.dslca-module-edit-field-font', function(e) {

			var dslcField, dslcOption, dslcVal, dslcMatchingFont = false, dslcFont;

			dslcField = jQuery(this);
			dslcOption = dslcField.closest('.dslca-module-edit-option');

			if ( e.which == 38 ) {
				jQuery('.dslca-module-edit-field-font-prev', dslcOption).click();
			}

			if ( e.which == 40 ) {
				jQuery('.dslca-module-edit-field-font-next', dslcOption).click();
			}

			if ( e.which != 13 && e.which != 38 && e.which != 40 ) {

				dslcVal = dslcField.val();

				var search = [];
				var re = new RegExp('^' + dslcVal, 'i');
				var dslcFontsAmount = dslcAllFontsArray.length;
				var i = 0;
				do {

					if (re.test(dslcAllFontsArray[i])) {
						if ( ! dslcMatchingFont ) {
							var dslcMatchingFont = dslcAllFontsArray[i];
						}
					}

				i++; } while (i < dslcFontsAmount);

				if ( ! dslcMatchingFont ) {
					dslcFont = dslcVal;
					jQuery('.dslca-module-edit-field-font-suggest', dslcOption).hide();
				} else {
					dslcFont = dslcMatchingFont;
					jQuery('.dslca-module-edit-field-font-suggest', dslcOption).show();
				}

				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text( dslcFont );

				if ( dslcFont.length )
					dslcField.val( dslcFont.substring( 0 , dslcField.val().length ) );

			}

		});

		// Key press ( enter )

		jQuery(document).on( 'keypress', '.dslca-module-edit-field-font', function(e) {

			if ( e.which == 13 ) {

				e.preventDefault();

				var dslcField, dslcOption, dslcVal, dslcMatchingFont, dslcFont;

				dslcField = jQuery(this);
				dslcOption = dslcField.closest('.dslca-module-edit-option');

				jQuery(this).val( jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text() ).trigger('change');

				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');

			}

		});

	}

	/*
	 * Change icon code based on direction (next/previous)
	 */

	function dslc_list_icon( object, direction ) {

		var dslcOption = jQuery(object).closest('.dslca-module-edit-option-icon');
		var dslcField = jQuery( '.dslca-module-edit-field-icon', dslcOption );
		var dslcCurrIndex = dslcIconsCurrentSet.indexOf( dslcField.val() );

		if ( direction == 'previous' ) {
			var dslcNewIndex = dslcCurrIndex - 1;
		} else {
			var dslcNewIndex = dslcCurrIndex + 1;
		}

		jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text('');

		if ( dslcNewIndex < 0 ) {
			dslcNewIndex = dslcIconsCurrentSet.length - 1
		}

		dslcField.val( dslcIconsCurrentSet[dslcNewIndex] ).trigger('change');
	}

	/**
	 * MODULES - Icon option type
	 */

	function dslc_module_options_icon() {

		// Key Up ( arrow up, arrow down, else )

		jQuery(document).on( 'keyup', '.dslca-module-edit-field-icon', function(e) {

			var dslcField, dslcOption, dslcVal, dslcIconsArrayGrep, dslcIcon;

			dslcField = jQuery(this);
			dslcOption = dslcField.closest('.dslca-module-edit-option');

			// Key pressed: arrow up
			if ( e.which == 38 ) {
				dslc_list_icon(dslcField,'previous');
			}

			// Key pressed: arrow down
			if ( e.which == 40 ) {
				dslc_list_icon(dslcField,'next');
			}

			if ( e.which != 13 && e.which != 38 && e.which != 40 ) {

				dslcVal = dslcField.val().toLowerCase();
				dslcField.val( dslcVal );

				dslcIconsArrayGrep = jQuery.grep(dslcIconsCurrentSet, function(value, i) {
					return ( value.indexOf( dslcVal ) == 0 );
				});

				dslcIcon = dslcIconsArrayGrep[0];

				jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text( dslcIcon );

			}

		});

		// Key Press ( Enter )

		jQuery(document).on( 'keypress', '.dslca-module-edit-field-icon', function(e) {

			if ( e.which == 13 ) {

				e.preventDefault();

				var dslcField, dslcOption, dslcVal, dslcIconsArrayGrep, dslcIcon;

				dslcField = jQuery(this);
				dslcOption = dslcField.closest('.dslca-module-edit-option');

				jQuery(this).val( jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text() ).trigger('change');

				jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text('');

			}

		});

	}

	function dslc_module_options_icon_returnid() {

		jQuery(document).on('click', '.dslca-open-modal-hook[data-modal^=".dslc-list-icons"]', function(el) {
			jQuery(this).closest('.dslca-module-edit-option-icon').find('input').addClass('icon-modal-active');
		});

		jQuery(document).on('click', '.dslca-modal-icons .icon-item', function(el) {
			// Get selected item code
			var selectedIconCode = jQuery(this).find('.icon-item_name').text();
			jQuery('input.icon-modal-active').val(selectedIconCode).change();

			// Close modal window
			dslc_hide_modal( '', jQuery('.dslca-modal:visible') );
		});

	}

	/**
	 * MODULES - Text align option type
	 */

	function dslc_module_options_text_align() {

		jQuery(document).on( 'click', '.dslca-module-edit-option-text-align-hook', function(){

			var newOpt = jQuery(this),
			otherOpt = jQuery(this).closest('.dslca-module-edit-option-text-align-wrapper').find('.dslca-module-edit-option-text-align-hook'),
			newVal = newOpt.data('val'),
			realOpt = jQuery(this).closest('.dslca-module-edit-option-text-align-wrapper').siblings('input.dslca-module-edit-field');

			otherOpt.removeClass('dslca-active');
			newOpt.addClass('dslca-active');

			realOpt.val( newVal ).trigger('change');

		});

	}

	/**
	 * MODULES - Checkbox Option Type
	 */

	function dslc_module_options_checkbox() {

		jQuery(document).on( 'click', '.dslca-module-edit-option-checkbox-hook, .dslca-modules-section-edit-option-checkbox-hook', function(){

			var checkFake = jQuery(this);
			var checkReal = checkFake.siblings('input[type="checkbox"]');

			if ( checkReal.prop('checked') ) {
				checkReal.prop('checked', false);
				checkFake.find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			} else {
				checkReal.prop('checked', true);
				checkFake.find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			}

			checkReal.change();

		});

	}

	/**
	 * MODULES - Box Shadow Option Type
	 */

	function dslc_module_options_box_shadow() {

		if ( dslcDebug ) console.log( 'dslc_module_options_box_shadow' );

		/**
		 * Value Change
		 */

		jQuery(document).on( 'change', '.dslca-module-edit-option-box-shadow-hor, .dslca-module-edit-option-box-shadow-ver, .dslca-module-edit-option-box-shadow-blur, .dslca-module-edit-option-box-shadow-spread, .dslca-module-edit-option-box-shadow-color, .dslca-module-edit-option-box-shadow-inset', function(){

			var boxShadowWrapper = jQuery(this).closest('.dslca-module-edit-option'),
			boxShadowInput = boxShadowWrapper.find('.dslca-module-edit-field'),
			boxShadowHor = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-hor').val(),
			boxShadowVer = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-ver').val(),
			boxShadowBlur = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-blur').val(),
			boxShadowSpread = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-spread').val(),
			boxShadowColor = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-color').val(),
			boxShadowInset = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-inset').is(':checked');

			if ( boxShadowInset ) { boxShadowInset = ' inset'; } else { boxShadowInset = ''; }

			var boxShadowVal = boxShadowHor + 'px ' + boxShadowVer + 'px ' + boxShadowBlur + 'px ' + boxShadowSpread + 'px ' + boxShadowColor + boxShadowInset;

			boxShadowInput.val( boxShadowVal ).trigger('change');

		});

	}

	/**
	 * MODULES - Box Shadow Color Picker
	 */

	function dslc_modules_options_box_shadow_color() {

		/**
		 * Color Pallete
		 */

		var dslcColorPallete = [],
		currStorage,
		index;

		dslcColorPallete[0] = [];
		dslcColorPallete[1] = [];
		dslcColorPallete[2] = [];
		dslcColorPallete[3] = [];

		if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
		} else {
			currStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
			for	( index = 0; index < currStorage.length; index++ ) {
				var key = Math.floor( index / 3 );
				if ( key < 4 ) {
					dslcColorPallete[key].push( currStorage[index] );
				}
			}
		}

		jQuery('.dslca-module-edit-option-box-shadow-color').each( function(){

			var inputField = jQuery(this),
			currColor = inputField.val(),
			dslcColorField, dslcColorFieldVal;

			jQuery(this).spectrum({
				color: currColor,
				showInput: true,
				allowEmpty: true,
				showAlpha: true,
				clickoutFiresChange: true,
				cancelText: '',
				chooseText: '',
				preferredFormat: 'rgb',
				showPalette: true,
				palette: dslcColorPallete,
				move: function( color ) {

					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString().replace(/ /g,'');

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal ).trigger('change');

				},
				change: function( color ) {

					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString().replace(/ /g,'');

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal ).trigger('change');

					// Update pallete local storage
					if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
						var newStorage = [ dslcColorFieldVal ];
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					} else {
						var newStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
						if ( newStorage.indexOf( dslcColorFieldVal ) == -1 ) {
							newStorage.unshift( dslcColorFieldVal );
						}
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					}

				},
				show: function( color ) {
					jQuery('body').addClass('dslca-disable-selection');
				},
				hide: function() {
					jQuery('body').removeClass('dslca-disable-selection');
				}
			});

		});

	}

	/**
	 * MODULES - Text Shadow Option Type
	 */

	function dslc_module_options_text_shadow() {

		if ( dslcDebug ) console.log( 'dslc_module_options_text_shadow' );

		/**
		 * Value Change
		 */

		jQuery(document).on( 'change', '.dslca-module-edit-option-text-shadow-hor, .dslca-module-edit-option-text-shadow-ver, .dslca-module-edit-option-text-shadow-blur, .dslca-module-edit-option-text-shadow-color', function(){

			var textShadowWrapper = jQuery(this).closest('.dslca-module-edit-option'),
			textShadowInput = textShadowWrapper.find('.dslca-module-edit-field'),
			textShadowHor = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-hor').val(),
			textShadowVer = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-ver').val(),
			textShadowBlur = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-blur').val(),
			textShadowColor = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-color').val();

			var textShadowVal = textShadowHor + 'px ' + textShadowVer + 'px ' + textShadowBlur + 'px ' + textShadowColor;

			textShadowInput.val( textShadowVal ).trigger('change');

		});

	}

	/**
	 * MODULES - Text Shadow Color Picker
	 */

	function dslc_modules_options_text_shadow_color() {

		jQuery('.dslca-module-edit-option-text-shadow-color').each( function(){

			var inputField = jQuery(this),
			currColor = inputField.val(),
			dslcColorField, dslcColorFieldVal;

			jQuery(this).spectrum({
				color: currColor,
				showInput: true,
				allowEmpty: true,
				showAlpha: true,
				clickoutFiresChange: true,
				cancelText: '',
				chooseText: '',
				preferredFormat: 'rgb',
				move: function( color ) {

					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString().replace(/ /g,'');

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal ).trigger('change');

				},
				change: function( color ) {

					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString().replace(/ /g,'');

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal ).trigger('change');

				},
				show: function( color ) {
					jQuery('body').addClass('dslca-disable-selection');
				},
				hide: function() {
					jQuery('body').removeClass('dslca-disable-selection');
				}
			});

		});

	}

	/**
	 * MODULES - Color Option Type
	 */

	function dslc_module_options_color() {

		if ( dslcDebug ) console.log( 'dslc_module_options_color' );

		var dslcColorField,
		dslcAffectOnChangeEl,
		dslcAffectOnChangeRule,
		dslcColorFieldVal,
		dslcModule,
		dslcOptionID,
		dslcCurrColor;

		/**
		 * Color Pallete
		 */

		var dslcColorPallete = [],
		currStorage,
		index;

		dslcColorPallete[0] = [];
		dslcColorPallete[1] = [];
		dslcColorPallete[2] = [];
		dslcColorPallete[3] = [];

		if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
		} else {
			currStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
			for	( index = 0; index < currStorage.length; index++ ) {
				var key = Math.floor( index / 3 );
				if ( key < 4 ) {
					dslcColorPallete[key].push( currStorage[index] );
				}
			}
		}

		jQuery('.dslca-module-edit-field-colorpicker').each( function(){

			dslcCurrColor = jQuery(this).val();

			jQuery(this).spectrum({
				color: dslcCurrColor,
				showInput: true,
				allowEmpty: true,
				showAlpha: true,
				clickoutFiresChange: true,
				cancelText: '',
				chooseText: '',
				preferredFormat: 'rgb',
				showPalette: true,
				palette: dslcColorPallete,
				move: function( color ) {

					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString();

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal );

					// Live change
					dslcAffectOnChangeEl = dslcColorField.data('affect-on-change-el');
					dslcAffectOnChangeRule = dslcColorField.data('affect-on-change-rule');
					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcColorFieldVal );

					// Update option
					dslcModule = jQuery('.dslca-module-being-edited');
					dslcOptionID = dslcColorField.data('id');
					jQuery('.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule).val( dslcColorFieldVal );

					// Add changed class
					dslcModule.addClass('dslca-module-change-made');

				},
				change: function( color ) {

					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString();

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal );

					// Live change
					dslcAffectOnChangeEl = dslcColorField.data('affect-on-change-el');
					dslcAffectOnChangeRule = dslcColorField.data('affect-on-change-rule');
					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcColorFieldVal );

					// Update option
					dslcModule = jQuery('.dslca-module-being-edited');
					dslcOptionID = dslcColorField.data('id');
					jQuery('.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule).val( dslcColorFieldVal );

					// Add changed class
					dslcModule.addClass('dslca-module-change-made');

					// Update pallete local storage
					if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
						var newStorage = [ dslcColorFieldVal ];
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					} else {
						var newStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
						if ( newStorage.indexOf( dslcColorFieldVal ) == -1 ) {
							newStorage.unshift( dslcColorFieldVal );
						}
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					}

				},
				show: function( color ) {
					jQuery('body').addClass('dslca-disable-selection');
				},
				hide: function() {
					jQuery('body').removeClass('dslca-disable-selection');
				}
			});

		});

		// Revert to default
		jQuery('.dslca-sp-revert').click(function(){

			var defValue = jQuery('.sp-replacer.sp-active').closest('.dslca-module-edit-option').find('.dslca-module-edit-field').data('default');

			jQuery(this).closest('.sp-container').find('.sp-input').val( defValue ).trigger('change');

		});

	}

	/**
	 * MODULES - Numeric Option Type
	 */

	function dslc_module_options_numeric() {

		if ( dslcDebug ) console.log( 'dslc_module_options_numeric' );

		jQuery('.dslca-module-edit-field-slider').each(function(){

			var dslcSlider, dslcSliderField, dslcSliderInput, dslcSliderVal, dslcAffectOnChangeRule, dslcAffectOnChangeEl,
			dslcSliderTooltip, dslcSliderTooltipOffset, dslcSliderTooltipPos, dslcModule, dslcOptionID, dslcSliderExt,
			dslcAffectOnChangeRules;

			dslcSlider = jQuery(this);
			dslcSliderInput = dslcSlider.siblings('.dslca-module-edit-field');

			dslcSliderTooltip = dslcSlider.closest('.dslca-module-edit-option-slider').find('.dslca-module-edit-field-slider-tooltip');

			dslcSlider.slider({
				min : dslcSliderInput.data('min'),
				max : dslcSliderInput.data('max'),
				step: dslcSliderInput.data('increment'),
				value: dslcSliderInput.val(),
				slide: function(event, ui) {

					dslcSliderExt = dslcSliderInput.data('ext');
					dslcSliderVal = ui.value + dslcSliderExt;
					dslcSliderInput.val( dslcSliderVal );

					// Live change
					dslcAffectOnChangeEl = dslcSliderInput.data('affect-on-change-el');
					dslcAffectOnChangeRule = dslcSliderInput.data('affect-on-change-rule').replace(/ /g,'');
					dslcAffectOnChangeRules = dslcAffectOnChangeRule.split( ',' );

					// Loop through rules (useful when there are multiple rules)
					for ( var i = 0; i < dslcAffectOnChangeRules.length; i++ ) {
						jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRules[i] , dslcSliderVal );
					}

					// Update option
					dslcModule = jQuery('.dslca-module-being-edited');
					dslcOptionID = dslcSliderInput.data('id');
					jQuery('.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule).val( ui.value );

					// Add changed class
					dslcModule.addClass('dslca-module-change-made');

					// Tooltip
					dslcSliderTooltip.text( dslcSliderVal );
					var dslcSliderHandle = dslcSlider.find('.ui-slider-handle');
					dslcSliderTooltipOffset = dslcSliderHandle[0].style.left;
					dslcSliderTooltip.css({ left : dslcSliderTooltipOffset });

					dslc_masonry( dslcModule );
					dslc_init_square();
					dslc_center();
					dslc_init_square( dslcModule );

				},
				stop: function( event, ui ) {

					dslcSliderTooltip.hide();

				},
				start: function( event, ui ) {

					dslcSliderTooltip.show();

					// Tooltip
					dslcSliderTooltip.text( dslcSliderVal );
					dslcSliderTooltipOffset = ui.handle.style.left;
					dslcSliderTooltip.css({ left : dslcSliderTooltipOffset });

				}

			});

		});

	}

	/**
	 * MODULES - Module output default settings
	 */

	function dslc_module_output_default( dslcModuleID, callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_output_default' );

		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-add-module',
				dslc : 'active',
				dslc_module_id : dslcModuleID,
				dslc_post_id : jQuery('.dslca-container').data('post-id')
			},
			function( response ) {

				callback(response);

			}

		);

	}

	/**
	 * MODULES - Module output when settings altered
	 */

	function dslc_module_output_altered( callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_output_altered' );

		callback = typeof callback !== 'undefined' ? callback : false;

		var dslcModule = jQuery('.dslca-module-being-edited'),
		dslcModuleID = dslcModule.data('dslc-module-id'),
		dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
		dslcModuleInstanceID = dslcModule.data('module-id');

		/**
		 * Generate code
		 */

		var dslcSettings = {};

		dslcSettings['action'] = 'dslc-ajax-add-module';
		dslcSettings['dslc'] = 'active';
		dslcSettings['dslc_module_id'] = dslcModuleID;
		dslcSettings['dslc_module_instance_id'] = dslcModuleInstanceID;
		dslcSettings['dslc_post_id'] = jQuery('.dslca-container').data('post-id');

		if ( dslcModule.hasClass('dslca-preload-preset') )
			dslcSettings['dslc_preload_preset'] = 'enabled';
		else
			dslcSettings['dslc_preload_preset'] = 'disabled';

		dslcModule.removeClass('dslca-preload-preset');

		dslcModuleOptions.each(function(){

			var dslcOption = jQuery(this);
			var dslcOptionID = dslcOption.data('id');
			var dslcOptionValue = dslcOption.val();

			dslcSettings[dslcOptionID] = dslcOptionValue;

		});

		/**
		 * Call AJAX for preview
		 */
		jQuery.post(

			DSLCAjax.ajaxurl, dslcSettings,
			function( response ) {

				dslcModule.after(response.output).next().addClass('dslca-module-being-edited');
				dslcModule.remove();
				dslc_generate_code();
				dslc_show_publish_button();

				dslc_carousel();
				dslc_masonry( jQuery('.dslca-module-being-edited') );
				jQuery( '.dslca-module-being-edited img' ).load( function(){
					dslc_masonry( jQuery('.dslca-module-being-edited') );
					dslc_center();
				});
				dslc_tabs();
				dslc_init_accordion();
				dslc_init_square();
				dslc_center();

				if ( callback ) {
					callback( response );
				}

			}

		);

	}

	/**
	 * MODULES - Reload a specific module
	 */

	function dslc_module_output_reload( dslcModule, callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_output_reload' );

		callback = typeof callback !== 'undefined' ? callback : false;

		var dslcModuleID = dslcModule.data('dslc-module-id'),
		dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
		dslcModuleInstanceID = dslcModule.data('module-id');

		/**
		 * Generate code
		 */

		var dslcSettings = {};

		dslcSettings['action'] = 'dslc-ajax-add-module';
		dslcSettings['dslc'] = 'active';
		dslcSettings['dslc_module_id'] = dslcModuleID;
		dslcSettings['dslc_module_instance_id'] = dslcModuleInstanceID;
		dslcSettings['dslc_post_id'] = jQuery('.dslca-container').data('post-id');
		dslcSettings['dslc_preload_preset'] = 'enabled';
		dslcModule.removeClass('dslca-preload-preset');

		dslcModuleOptions.each(function(){

			var dslcOption = jQuery(this);
			var dslcOptionID = dslcOption.data('id');
			var dslcOptionValue = dslcOption.val();

			dslcSettings[dslcOptionID] = dslcOptionValue;

		});

		/**
		 * Loader
		 */

		dslcModule.append('<div class="dslca-module-reloading"><span class="dslca-icon dslc-icon-spin dslc-icon-refresh"></span></div>');

		/**
		 * Call AJAX for preview
		 */
		jQuery.post(

			DSLCAjax.ajaxurl, dslcSettings,
			function( response ) {

				dslcModule.after(response.output).next().addClass('dslca-module-being-edited');
				dslcModule.remove();
				dslc_generate_code();
				dslc_show_publish_button();

				dslc_carousel();
				dslc_masonry( jQuery('.dslca-module-being-edited') );
				jQuery( '.dslca-module-being-edited img' ).load( function(){
					dslc_masonry( jQuery('.dslca-module-being-edited') );
					dslc_center();
				});
				dslc_tabs();
				dslc_init_accordion();
				dslc_init_square();
				dslc_center();

				if ( callback ) {
					callback( response );
				}

				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

			}

		);

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	function dslc_delete_module( module ) { dslc_module_delete( module ); }
	function dslc_copy_module( module ) { dslc_module_copy( module ); }
	function dslc_display_module_options( moduleID ) { dslc_module_options_show( moduleID ); }
	function dslc_filter_module_options( sectionID ) { dslc_module_options_section_filter( sectionID ); }
	function dslc_show_module_options_tab( tab ) { dslc_module_options_tab_filter( tab ); }
	function dslc_confirm_changes( callback ) { dslc_module_options_confirm_changes( callback ); }
	function dslc_cancel_changes( callback ) { dslc_module_options_cancel_changes( callback ); }
	function dslc_init_colorpicker() { dslc_module_options_color(); }
	function dslc_init_options_slider() { dslc_module_options_numeric(); }
	function dslc_init_options_scrollbar() { dslc_module_options_scrollbar(); }
	function dslc_module_edit_options_hideshow_tabs() { dslc_module_options_hideshow_tabs(); }
	function dslc_get_module_output( moduleID, callback ) { dslc_module_output_default( moduleID, callback ); }
	function dslc_preview_change( callback ) { dslc_module_output_altered( callback ); }
	function dslc_reload_module( moduleID, callback ) { dslc_module_output_reload( moduleID, callback ); }


	/**
	 * Modules - Document Ready
	 */

	jQuery(document).ready(function($){

		dslc_module_options_tooltip();
		dslc_module_options_font();
		dslc_module_options_icon();
		dslc_module_options_icon_returnid()
		dslc_module_options_text_align();
		dslc_module_options_checkbox();
		dslc_module_options_box_shadow();
		dslc_module_options_text_shadow();

		/**
		 * Hook - Submit
		 */

		$('.dslca-module-edit-form').submit( function(e){

			e.preventDefault();
			dslc_module_output_altered();

		});

		/**
		 * Hook - Copy Module
		 */

		$(document).on( 'click', '.dslca-copy-module-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_module_copy( $(this).closest('.dslc-module-front') );
			}

		});

		/**
		 * Hook - Module Delete
		 */

		 $(document).on( 'click', '.dslca-delete-module-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {

				dslc_js_confirm( 'delete_module', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_module_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_module_descr + '</span>', $(this) );

			}

		});

		/**
		 * Action - Show/Hide Width Options
		 */

		$(document).on( 'click', '.dslca-change-width-module-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				$('.dslca-change-width-module-options', this).toggle();
				$(this).closest('.dslca-module-manage').toggleClass('dslca-module-manage-change-width-active');
			}

		});

		/**
		 * Hook - Set Module Width
		 */

		$(document).on( 'click', '.dslca-change-width-module-options span', function(){

			dslc_module_width_set( jQuery(this).closest('.dslc-module-front'), jQuery(this).data('size') );

		});

		/**
		 * Hook - Module Edit ( Display Options )
		 */

		$(document).on( 'click', '.dslca-module-edit-hook', function(e){

			e.preventDefault();

			// If composer not hidden
			if ( ! $('body').hasClass( 'dslca-composer-hidden' ) ) {

				// If another module being edited and has changes
				if ( $('.dslca-module-being-edited.dslca-module-change-made').length ) {

					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_module_curr_edit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_module_curr_edit_descr + '</span>', $(this) );

				// If a section is being edited and has changes
				} else if ( $('.dslca-modules-section-being-edited.dslca-modules-section-change-made').length ) {

					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_row_curr_edit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_row_curr_edit_descr + '</span>', $(this) );

				// All good, proceed
				} else {

					// If a module section is being edited but has no changes, cancel it
					if ( $('.dslca-modules-section-being-edited').length ) {
						$('.dslca-module-edit-cancel').trigger('click');
					}

					// Vars
					var dslcModule = $(this).closest('.dslc-module-front'),
					dslcModuleID = dslcModule.data('dslc-module-id'),
					dslcModuleCurrCode = dslcModule.find('.dslca-module-code').val();

					// If a module is bening edited remove the "being edited" class from it
					$('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

					// Add the "being edited" class to current module
					dslcModule.addClass('dslca-module-being-edited');

					// Call the function to display options
					dslc_module_options_show( dslcModuleID );

				}

			}

		});

		/**
		 * Hook - Tab Switch
		 */

		$(document).on( 'click', '.dslca-module-edit-options-tab-hook', function(){
			dslc_module_options_tab_filter( $(this) );
		});

		/**
		 * Hook - Option Section Switch
		 */

		$(document).on( 'click', '.dslca-options-filter-hook', function(e){

			var dslcPrev = jQuery('.dslca-options-filter-hook.dslca-active').data('section');

			$('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');
			$(this).addClass('dslca-active');

			dslc_module_options_section_filter( jQuery(this).data('section') );

			// If previous was responsive reload module
			if ( dslcPrev == 'responsive' ) {

				// Show the loader
				jQuery('.dslca-container-loader').show();

				// Reset the responsive classes
				dslc_responsive_classes();

				// Reload Module
				dslc_module_output_altered(function(){

					// Hide the loader
					jQuery('.dslca-container-loader').hide();

				});

			}

		});

		/**
		 * Hook - Confirm Changes
		 */

		$(document).on( 'click', '.dslca-module-edit-save', function(){

			dslc_module_options_confirm_changes();
			$('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');
			dslc_responsive_classes( true );

		});

		/**
		 * Hook - Cancel Changes
		 */

		$(document).on( 'click', '.dslca-module-edit-cancel', function(){

			dslc_module_options_cancel_changes();
			$('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');
			dslc_responsive_classes( true );

		});

		/**
		 * Hook - Show/Hide Icon Set Switch
		 */

		jQuery(document).on( 'click', '.dslca-module-edit-field-icon-switch-set', function(){

			var dslcTtip = jQuery('.dslca-module-edit-field-icon-switch-sets');
			var dslcHook = jQuery(this);

			// Add/Remo active classes
			jQuery('.dslca-module-edit-field-icon-switch-set.dslca-active').removeClass('dslca-active');
			dslcHook.addClass('dslca-active');

			if ( dslcTtip.is(':visible') ) {

				jQuery('.dslca-module-edit-field-icon-switch-sets').hide();

			} else {

				// Icon vars
				var currIconSet = dslcHook.find('.dslca-module-edit-field-icon-curr-set').text();

				jQuery('.dslca-module-edit-field-icon-switch-sets span.dslca-active').removeClass('dslca-active');
				jQuery('.dslca-module-edit-field-icon-switch-sets span[data-set="' + currIconSet + '"]').addClass('dslca-active');

				// Positioning vars
				var dslcOffset = dslcHook.offset(),
				dslcTtipHeight = dslcTtip.outerHeight(),
				dslcTtipWidth = dslcTtip.outerWidth(),
				dslcTtipLeft = dslcOffset.left - ( dslcTtipWidth / 2 ) + 6,
				dslcTtipArrLeft = '50%';

				if ( dslcTtipLeft < 0 ) {
					dslcTtipArrLeft = ( dslcTtipWidth / 2 ) + dslcTtipLeft + 'px';
					dslcTtipLeft = 0;
				}

				jQuery('.dslca-module-edit-field-icon-switch-sets').show().css({
					top : dslcOffset.top - dslcTtipHeight - 20,
					left: dslcTtipLeft
				});

				jQuery("head").append(jQuery('<style>.dslca-module-edit-field-icon-switch-sets:after, .dslca-module-edit-field-icon-switch-sets:before { left: ' + dslcTtipArrLeft + ' }</style>'));

			}

		});

		/**
		 * Hook - Switch Icon Set
		 */

		jQuery(document).on( 'click', '.dslca-module-edit-field-icon-switch-sets span', function(){

			var iconSet = $(this).data('set');

			// Change current icon set
			dslcIconsCurrentSet = DSLCIcons[iconSet];

			// Update 'icons grid' button data-modal attribute with selected set
			$('.dslca-open-modal-hook[data-modal^=".dslc-list-icons"]').data('modal', '.dslc-list-icons-' + iconSet );


			// Change active states
			$(this).addClass('dslca-active').siblings('.dslca-active').removeClass('dslca-active');

			// Change current text
			$('.dslca-module-edit-field-icon-switch-set.dslca-active .dslca-module-edit-field-icon-curr-set').text( iconSet );

			// Go to next icon
			$('.dslca-module-edit-field-icon-switch-set.dslca-active').closest('.dslca-module-edit-option').find('.dslca-module-edit-field-icon-next').trigger('click');

			// Hide sets
			$('.dslca-module-edit-field-icon-switch-sets').hide();

		});

		/**
		 * Action - Change current set on mouse enter of icon option
		 */

		jQuery(document).on( 'mouseenter', '.dslca-module-edit-option-icon', function(){

			var iconSet = $(this).find('.dslca-module-edit-field-icon-curr-set').text();

			// Change current icon set
			dslcIconsCurrentSet = DSLCIcons[iconSet];

			// Update 'icons grid' button data-modal attribute with selected set
			$('.dslca-open-modal-hook[data-modal^=".dslc-list-icons"]').data('modal', '.dslc-list-icons-' + iconSet );

		});

	});


/*********************************
 *
 * 9) = TEMPLATES =
 *
 * - dslc_load_template ( Load Template )
 * - dslc_import_template ( Import Template )
 * - dslc_save_template ( Save TEmplate )
 * - dslc_delete_template ( Delete Template )
 *
 ***********************************/

 	/**
 	 * TEMPLATES - Load
 	 */

 	function dslc_template_load( template ) {

		if ( dslcDebug ) console.log( 'dslc_load_template' );

		// Vars
		var dslcModule, dslcModuleID;

		// Ajax call to get template's HTML
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-load-template',
				dslc : 'active',
				dslc_template_id : template
			},
			function( response ) {

				// Apply the template's HTML
				jQuery('#dslc-main').html( response.output );

				// Call other functions
				dslc_carousel();
				dslc_drag_and_drop();
				dslc_show_publish_button();
				dslc_generate_code();

			}

		);

	}

	/**
	 * TEMPLATES - Import
	 */

	function dslc_template_import() {

		if ( dslcDebug ) console.log( 'dslc_import_template' );

		// Vars
		var dslcModule, dslcModuleID;

		// Hide the title on the button and show loading animation
		jQuery('.dslca-modal-templates-import .dslca-modal-title').css({ opacity : 0 });
		jQuery('.dslca-modal-templates-import .dslca-loading').show();

		// Ajax call to load template's HTML
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-import-template',
				dslc : 'active',
				dslc_template_code : jQuery('#dslca-import-code').val()
			},
			function( response ) {

				// Apply the template's HTML
				jQuery('#dslc-main').html( response.output );

				// Hide the loading on the button and show the title
				jQuery('.dslca-modal-templates-import .dslca-loading').hide();
				jQuery('.dslca-modal-templates-import .dslca-modal-title').css({ opacity : 1 });

				// Hide the modal
				dslc_hide_modal( '', '.dslca-modal-templates-import' );

				// Call other functions
				dslc_bg_video();
				dslc_center();
				dslc_drag_and_drop();
				dslc_show_publish_button();
				dslc_generate_code();

			}

		);

	}

	/**
	 * TEMPLATES - SAVE
	 */

	function dslc_template_save() {

		if ( dslcDebug ) console.log( 'dslc_save_template' );

		// AJAX call to save the template
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-save-template',
				dslc : 'active',
				dslc_template_code : jQuery('#dslca-code').val(),
				dslc_template_title : jQuery('#dslca-save-template-title').val()
			},
			function( response ) {

				// Hide the modal
				dslc_hide_modal( '', '.dslca-modal-templates-save' );

			}

		);

	}

	/**
	 * TEMPLATES - DELETE
	 */

	function dslc_template_delete( template ) {

		if ( dslcDebug ) console.log( 'dslc_delete_template' );

		// AJAX call to delete template
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-delete-template',
				dslc : 'active',
				dslc_template_id : template
			},
			function( response ) {

				// Remove template from the template listing
				jQuery('.dslca-template[data-id="' + template + '"]').fadeOut(200, function(){
					jQuery(this).remove();
				});

			}

		);

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	 function dslc_load_template( template ) { dslc_template_load( template ); }
	 function dslc_import_template() { dslc_template_import(); }
	 function dslc_save_template() { dslc_template_save(); }
	 function dslc_delete_template( template ) { dslc_template_delete( template ); }

	 /**
	  * TEMPLATES - Document Ready
	  */

	jQuery(document).ready(function($) {

		/**
		 * Hook - Load Template
		 */

		$(document).on( 'click', '.dslca-template', function(){

			dslc_template_load( jQuery(this).data('id') );

		});

		/**
		 * Hook - Import Template
		 */

		$('.dslca-template-import-form').submit(function(e){

			e.preventDefault();
			dslc_template_import();

		});

		/**
		 * Hook - Save Template
		 */

		$('.dslca-template-save-form').submit(function(e){

			e.preventDefault();
			dslc_template_save();

		});

		/**
		 * Hook - Delete Template
		 */

		$(document).on( 'click', '.dslca-delete-template-hook', function(e){

			e.stopPropagation();
			dslc_template_delete( $(this).data('id') );

		});

	});


/*********************************
 *
 * = 10) = CODE GENERATION =
 *
 * - dslc_save_composer ( Save the Page Changes )
 * - dslc_save_draft_composer ( Save the changes as draft, not publish )
 * - dslc_generate_code ( Generates Page's LC data )
 * - dslc_generate_section_code ( Generate LC data for a specific row/section )
 *
 ***********************************/

 	/**
 	 * CODE GENERATION - Save Page Changes
 	 */

 	function dslc_save_composer() {

		if ( dslcDebug ) console.log( 'dslc_save_composer' );

		// Vars
		var composerCode = jQuery('#dslca-code').val(),
		contentForSearch = jQuery('#dslca-content-for-search').val(),
		postID = jQuery('.dslca-container').data('post-id');

		// Apply class to body to know saving is in progress
		jQuery('body').addClass('dslca-saving-in-progress');

		// Replace the check in publish button with a loading animation
		jQuery('.dslca-save-composer .dslca-icon').removeClass('dslc-icon-ok').addClass('dslc-icon-spin dslc-icon-spinner');

		// Ajax call to save the new content
		jQuery.ajax({
			method: 'POST',
			type: 'POST',
			url: DSLCAjax.ajaxurl,
			data: {
				action : 'dslc-ajax-save-composer',
				dslc : 'active',
				dslc_post_id : postID,
				dslc_code : composerCode,
				dslc_content_for_search : contentForSearch
			},
			timeout: 10000
		}).done(function( response ) {

			// On success hide the publish button
			if ( response.status == 'success' ) {
				jQuery('.dslca-save-composer').fadeOut(250);
				jQuery('.dslca-save-draft-composer').fadeOut(250);
			// On fail show an alert message
			} else {
				alert( 'Something went wrong, please try to save again. Are you sure to make any changes? Error Code: ' + response.status);
			}

		}).fail(function( response ) {

			if ( response.statusText == 'timeout' ) {
				alert( 'The request timed out after 10 seconds. Server do not respond in time. Please try again.' );
			} else {
				alert( 'Something went wrong. Please try again. Error Code: ' + response.statusText  );
			}

		}).always(function( reseponse ) {

			// Replace the loading animation with a check icon
			jQuery('.dslca-save-composer .dslca-icon').removeClass('dslc-icon-spin dslc-icon-spinner').addClass('dslc-icon-ok')

			// Remove the class previously added so we know saving is finished
			jQuery('body').removeClass('dslca-saving-in-progress');

		});

	}

	/**
 	 * CODE GENERATION - Save Draft
 	 */

 	function dslc_save_draft_composer() {

		if ( dslcDebug ) console.log( 'dslc_save_draft_composer' );

		// Vars
		var composerCode = jQuery('#dslca-code').val(),
		postID = jQuery('.dslca-container').data('post-id');

		// Apply class to body to know saving is in progress
		jQuery('body').addClass('dslca-saving-in-progress');

		// Replace the check in publish button with a loading animation
		jQuery('.dslca-save-draft-composer .dslca-icon').removeClass('dslc-icon-ok').addClass('dslc-icon-spin dslc-icon-spinner');

		// Ajax call to save the new content
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-save-draft-composer',
				dslc : 'active',
				dslc_post_id : postID,
				dslc_code : composerCode,
			},
			function( response ) {

				// Replace the loading animation with a check icon
				jQuery('.dslca-save-draft-composer .dslca-icon').removeClass('dslc-icon-spin dslc-icon-spinner').addClass('dslc-icon-save')

				// On success hide the publish button
				if ( response.status == 'success' ) {
					jQuery('.dslca-save-draft-composer').fadeOut(250);

				// On fail show an alert message
				} else {
					alert( 'Something went wrong, please try to save again.' );
				}

				// Remove the class previously added so we know saving is finished
				jQuery('body').removeClass('dslca-saving-in-progress');

			}

		);

	}

	/**
	 * CODE GENERATION - Generate LC Data
	 */

	function dslc_generate_code() {

		if ( dslcDebug ) console.log( 'dslc_generate_code' );

		// Vars
		var moduleCode,
		moduleSize,
		composerCode = '',
		maxPerRow = 12,
		maxPerRowA = 12,
		currPerRow = 0,
		currPerRowA = 0,
		modulesAreaSize,
		modulesArea,
		modulesAreaLastState,
		modulesAreaFirstState,
		modulesSection,
		modulesSectionAtts = '';

		/**
		 * Go through module areas (empty or not empty)
		 */

		jQuery('#dslc-main .dslc-modules-area').each(function(){

			if ( jQuery('.dslc-module-front', this).length ) {
				jQuery(this).removeClass('dslc-modules-area-empty').addClass('dslc-modules-area-not-empty');
				jQuery('.dslca-no-content', this).hide();
			} else {
				jQuery(this).removeClass('dslc-modules-area-not-empty').addClass('dslc-modules-area-empty');
				jQuery('.dslca-no-content:not(:visible)', this).show().css({
					'-webkit-animation-name' : 'dslcBounceIn',
					'-moz-animation-name' : 'dslcBounceIn',
					'animation-name' : 'dslcBounceIn',
					'animation-duration' : '0.6s',
					'-webkit-animation-duration' : '0.6s',
					padding : 0
				}).animate({ padding : '35px 0' }, 300);
			}

		});

		/**
		 * Go through module sections (empty or not empty)
		 */

		jQuery('#dslc-main .dslc-modules-section').each(function(){

			if ( jQuery('.dslc-modules-area', this).length ) {
				jQuery(this).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');
			} else {
				jQuery(this).removeClass('dslc-modules-section-not-empty').addClass('dslc-modules-section-empty');
			}

		});

		// Remove last and first classes
		jQuery('#dslc-main .dslc-modules-area.dslc-last-col, .dslc-modules-area.dslc-first-col').removeClass('dslc-last-col dslc-first-col');
		jQuery('#dslc-main .dslc-module-front.dslc-last-col, .dslc-module-front.dslc-first-col').removeClass('dslc-last-col dslc-first-col');

		/**
		 * Go through each row
		 */

		jQuery('#dslc-main .dslc-modules-section').each(function(){

			// Vars
			currPerRowA = 0;
			modulesSection = jQuery(this);

			// Generate attributes for row shortcode
			modulesSectionAtts = '';
			jQuery('.dslca-modules-section-settings input', modulesSection).each(function(){
				modulesSectionAtts = modulesSectionAtts + jQuery(this).data('id') + '="' + jQuery(this).val() + '" ';
			});

			// Open the module section ( row ) shortcode
			composerCode = composerCode + '[dslc_modules_section ' + modulesSectionAtts + '] ';

			/**
			 * Go through each column of current row
			 */

			jQuery('.dslc-modules-area', modulesSection).each(function(){

				// Vars
				modulesArea = jQuery(this);
				modulesAreaSize = parseInt( modulesArea.data('size') );
				modulesAreaLastState = 'no';
				modulesAreaFirstState = 'no';

				// Increment area column counter
				currPerRowA += modulesAreaSize;

				// If area column counter same as maximum
				if ( currPerRowA == maxPerRowA ) {

					// Apply classes to current and next column
					jQuery(this).addClass('dslc-last-col').next('.dslc-modules-area').addClass('dslc-first-col');

					// Reset area column counter
					currPerRowA = 0;

					// Set shortcode's "last" attribute to "yes"
					modulesAreaLastState = 'yes';

				// If area column counter bigger than maximum
				} else if ( currPerRowA > maxPerRowA ) {

					// Apply classes to current and previous column
					jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');

					// Set area column counter to the size of the current area
					currPerRowA = modulesAreaSize;

					// Set shortcode's "first" attribute to yes
					modulesAreaFirstState = 'yes';

				}

				// If area column counter same as current area size
				if ( currPerRowA == modulesAreaSize ) {
					// Set shortcode's "first" attribute to yes
					modulesAreaFirstState = 'yes';
				}

				// Open the modules area ( area ) shortcode
				composerCode = composerCode + '[dslc_modules_area last="' + modulesAreaLastState + '" first="' + modulesAreaFirstState + '" size="' + modulesAreaSize + '"] ';

				/**
				 * Go through each module of current area
				 */

				jQuery('.dslc-module-front', modulesArea).each(function(){

					// Vars
					moduleSize = parseInt( jQuery(this).data('dslc-module-size') );
					var moduleLastState = 'no';
					var moduleFirstState = 'no';

					// Increment modules column counter
					currPerRow += moduleSize;

					// If modules column counter same as maximum
					if ( currPerRow == maxPerRow ) {

						// Add classes to current and next module
						jQuery(this).addClass('dslc-last-col').next('.dslc-module-front').addClass('dslc-first-col');

						// Reset modules column counter
						currPerRow = 0;

						// Set shortcode's "last" state to "yes"
						moduleLastState = 'yes';

					// If modules column counter bigger than maximum
					} else if ( currPerRow > maxPerRow ) {

						// Add classes to current and previous module
						jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');

						// Set modules column counter to the size of current module
						currPerRow = moduleSize;

						// Set shortcode's "first" state to "yes"
						moduleFirstState = 'yes';

					}

					// If modules column counter same as maximum
					if ( currPerRow == maxPerRow ) {

						// Set shorcode's "first" state to "yes"
						moduleFirstState = 'yes';

						// Add classes for current and next module
						jQuery(this).addClass('dslc-last-col').next('.dslc-module-front').addClass('dslc-first-col');

						// Resest modules column counter
						currPerRow = 0;
					}

					// Get module's LC data
					moduleCode = jQuery(this).find('.dslca-module-code').val();

					// Add the module shortcode containing the data
					composerCode = composerCode + '[dslc_module last="' + moduleLastState + '"]' + moduleCode + '[/dslc_module] ';

				});

				// Close area shortcode
				composerCode = composerCode + '[/dslc_modules_area] ';

			});

			// Close row ( section ) shortcode
			composerCode = composerCode + '[/dslc_modules_section] ';

		});

		// Apply the new code values to the setting containers
		jQuery('#dslca-code').val(composerCode);
		jQuery('#dslca-export-code').val(composerCode);

		// Generate content for search
		dslca_gen_content_for_search();

	}

	/**
	 * CODE GENERATION - Generate LC Data for Section
	 */

	function dslc_generate_section_code( theModulesSection ) {

		if ( dslcDebug ) console.log( 'dslc_generate_section_code' );

		var moduleCode,
		moduleSize,
		composerCode = '',
		maxPerRow = 12,
		maxPerRowA = 12,
		currPerRow = 0,
		currPerRowA = 0,
		modulesAreaSize,
		modulesArea,
		modulesAreaLastState,
		modulesAreaFirstState,
		modulesSection,
		modulesSectionAtts = '';

		currPerRowA = 0;

		var modulesSection = theModulesSection;

		jQuery('.dslca-modules-section-settings input', modulesSection).each(function(){

			modulesSectionAtts = modulesSectionAtts + jQuery(this).data('id') + '="' + jQuery(this).val() + '" ';

		});

		composerCode = composerCode + '[dslc_modules_section ' + modulesSectionAtts + '] ';

		// Go through each modules area
		jQuery('.dslc-modules-area', modulesSection).each(function(){

			modulesArea = jQuery(this);
			modulesAreaSize = parseInt( modulesArea.data('size') );
			modulesAreaLastState = 'no';
			modulesAreaFirstState = 'no';

			currPerRowA += modulesAreaSize;
			if ( currPerRowA == maxPerRowA ) {
				jQuery(this).addClass('dslc-last-col').next('.dslc-modules-area').addClass('dslc-first-col');
				currPerRowA = 0;
				modulesAreaLastState = 'yes';
			} else if ( currPerRowA > maxPerRowA ) {
				jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');
				currPerRowA = modulesAreaSize;
				modulesAreaFirstState = 'yes';
			}

			if ( currPerRowA == modulesAreaSize ) {
				modulesAreaFirstState = 'yes';
			}

			composerCode = composerCode + '[dslc_modules_area last="' + modulesAreaLastState + '" first="' + modulesAreaFirstState + '" size="' + modulesAreaSize + '"] ';

			// Go through each module in the area
			jQuery('.dslc-module-front', modulesArea).each(function(){

				moduleSize = parseInt( jQuery(this).data('dslc-module-size') );
				currPerRow += moduleSize;

				if ( currPerRow == modulesAreaSize ) {
					jQuery(this).addClass('dslc-last-col').next('.dslc-module-front').addClass('dslc-first-col');
					currPerRow = 0;
				}

				moduleCode = jQuery(this).find('.dslca-module-code').val();
				composerCode = composerCode + '[dslc_module]' + moduleCode + '[/dslc_module] ';

			});

			composerCode = composerCode + '[/dslc_modules_area] ';

		});

		composerCode = composerCode + '[/dslc_modules_section] ';

		return composerCode;

	}

	/**
	 * CODE GENERATION - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Hook - Save Page
		 */

		$(document).on( 'click', '.dslca-save-composer-hook', function(){

			// If some saving action not already in progress
			if ( ! $('body').hasClass('dslca-module-saving-in-progress') && ! $('body').hasClass('dslca-saving-in-progress') ) {
				// Call the function to save
				dslc_save_composer();
			}

		});

		/**
		 * Hook - Save Draft
		 */

		$(document).on( 'click', '.dslca-save-draft-composer-hook', function(){

			// If some saving action not already in progress
			if ( ! $('body').hasClass('dslca-module-saving-in-progress') && ! $('body').hasClass('dslca-saving-in-progress') ) {
				// Call the function to save
				dslc_save_draft_composer();
			}

		});

	});



/*********************************
 *
 * 11) = MODULE PRESETS =
 *
 * - dslc_update_preset ( Update Styling Preset )
 *
 ***********************************/

 	/**
 	 * Module Presets - Update
 	 */

	function dslc_update_preset() {

		if ( dslcDebug ) console.log( 'dslc_update_preset' );

		// Vars
		var module = jQuery('.dslca-module-being-edited'),
		presetName = module.find('.dslca-module-option-front[data-id="css_load_preset"]').val(),
		presetCode = module.find('.dslca-module-code').val(),
		moduleID = module.data('dslc-module-id');

		// If preset value not "none"
		if ( presetName !== 'none' ) {

			// AJAX Call to Save Preset
			jQuery.post(

				DSLCAjax.ajaxurl,
				{
					action : 'dslc-ajax-save-preset',
					dslc_preset_name : presetName,
					dslc_preset_code : presetCode,
					dslc_module_id : moduleID
				},
				function( response ) {

					// Reload all modules with the same preset
					jQuery('.dslc-module-front:not(#' + module.attr('id') + ')[data-dslc-module-id="' + module.data('dslc-module-id') + '"][data-dslc-preset="' + module.data('dslc-preset') + '"]').each(function(){
						dslc_module_output_reload( jQuery(this) );
					});

				}

			);

		}

	}

	/**
	 * Module Presets - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Action - Save preset
		 */

		$(document).on( 'keypress', '.dslca-module-edit-field[name="css_save_preset"]', function(e){

			// Enter Key Pressed
			if ( e.which == 13 ) {

				// Vars
				var presetName = $(this).val(),
				presetID = presetName.toLowerCase().replace(/\s/g, '-');

				// Add class to body that a new preset is added
				$('body').addClass('dslca-new-preset-added');

				// Append the new preset to the "Load Preset" option and trigger change
				$('.dslca-module-edit-field[name="css_load_preset"]').append('<option value="' + presetID + '">' + presetID + '</option>').val( presetID ).trigger('change');

				// Erase value from the "Save Preset" option
				$(this).val('');

			}

		});

		/**
		 * Action - Preset value changed
		 */

		$(document).on( 'change', '.dslca-module-edit-field[name="css_load_preset"]', function(e){
			$('.dslca-module-being-edited').addClass('dslca-preload-preset');
		});

	});


/*********************************
 *
 * 12) = OTHER =
 *
 * - dslc_dm_get_defaults ( Get Alter Module Defaults Code )
 * - dslca_gen_content_for_search ( Generate Readable Content For Search )
 * - dslca_draggable_calc_center ( Recalculate drag and drop centering )
 * - dslc_editable_content_gen_code ( Generate code of editable content )
 *
 ***********************************/

 	/**
 	 * Other - Get Alter Module Defaults Code
 	 */

 	function dslc_dm_get_defaults( module ) {

		if ( dslcDebug ) console.log( 'dslc_dm_get_defaults' );

		// The module code value
		var optionsCode = module.find('.dslca-module-code').val();

		// Ajax call to get the plain PHP code
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-dm-module-defaults',
				dslc : 'active',
				dslc_modules_options : optionsCode
			},
			function( response ) {

				// Apply the plain PHP code to the textarea
				jQuery('.dslca-prompt-modal textarea').val( response.output );

			}

		);

	}

	/**
	* Other - Generate Readable Content For Search
	*/

	function dslca_gen_content_for_search() {

		if ( dslcDebug ) console.log( 'dslca_gen_content_for_search' );

		// Vars
		var holder = document.getElementById('dslca-content-for-search');
		var prevContent = holder.value,
		content = '';

		// Go through each content element

		var elements = document.querySelectorAll('#dslc-main .dslc-module-front [data-exportable-content]');
		Array.prototype.forEach.call(elements, function(el, i){
			// el - current DOM element, i – counter
			var extracted_html_code;

			if ( el.getAttribute('data-exportable-content') !== '' ) {
				var wrapper_tag = el.getAttribute('data-exportable-content');
				extracted_html_code = '<' + wrapper_tag + '>' + el.innerHTML + '</' + wrapper_tag + '>';
			} else {
				extracted_html_code = el.innerHTML;
			}

			if ( extracted_html_code !== null ) {
				content += extracted_html_code.replace(/\s+/g, ' ').trim() + '\n';
			}
		});

		// Set the value of the content field
		holder.value = content;

		// Used to show the publish button for pages made before this feature
		if ( prevContent !== content ) {
			dslc_show_publish_button();
		}

	}

	/**
	 * Other - Recalculate drag and drop centering
	 */

	function dslca_draggable_calc_center( dslcArea ) {

		if ( dslcDebug ) console.log( 'dslca_draggable_calc_center' );

		jQuery( ".dslc-modules-section-inner" ).sortable( "option", "cursorAt", { top: dslcArea.outerHeight() / 2, left: dslcArea.outerWidth() / 2 } );

	}

	/**
	 * Other - Generate code of editable content
	 */

	function dslc_editable_content_gen_code( dslcField ) {

		if ( dslcDebug ) console.log( 'dslc_editable_content_gen_code' );

		var dslcModule, dslcContent, dslcFieldID;

		dslcModule = dslcField.closest('.dslc-module-front');
		dslcContent = dslcField.html().trim().replace(/<textarea/g, '<lctextarea').replace(/<\/textarea/g, '</lctextarea');
		dslcFieldID = dslcField.data('id');

		jQuery('.dslca-module-option-front[data-id="' + dslcFieldID + '"]', dslcModule).val( dslcContent );

		dslc_show_publish_button();

	}

	/**
	 * Other - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
	 	 * Action - Show code for altering module's defaults
	 	 */

	 	$(document).on( 'click', '.dslca-module-get-defaults-hook', function(){

	 		// Vars
			var module = jQuery(this).closest('.dslc-module-front');
			var code = dslc_dm_get_defaults( module );

			// Generate modal's text
			var message = '<span class="dslca-prompt-modal-title">Module Defaults</span>'
				+ '<span class="dslca-prompt-modal-descr">The code bellow is used to alter the defaults.</span>'
				+ '<textarea></textarea><br><br>';

			// Hide modal's cancel button
			$('.dslca-prompt-modal-cancel-hook').hide();

			// Show confirm button and change it to "OK"
			$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>OK');

			// Show the modal prompt
			dslc_js_confirm( 'dev_mode_get_default', message, module );

		});

		/**
		 * Action - Disable links from going anywhere
		 */

		$(document).on( 'click', 'a:not(.dslca-link)', function(e){
			e.preventDefault();
		});

		/**
		 * Action - Prevent backspace from navigating back
		 */

		$(document).unbind('keydown').bind('keydown', function (event) {

			var doPrevent = false;
			if (event.keyCode === 8) {
				var d = event.srcElement || event.target;
				if ((d.tagName.toUpperCase() === 'INPUT' && (d.type.toUpperCase() === 'TEXT' || d.type.toUpperCase() === 'PASSWORD' || d.type.toUpperCase() === 'FILE'))
					 || d.tagName.toUpperCase() === 'TEXTAREA' || $(d).hasClass('dslca-editable-content') || $(d).hasClass('dslc-tabs-nav-hook-title') || $(d).hasClass('dslc-accordion-title') ) {
					doPrevent = d.readOnly || d.disabled;
				} else {
					doPrevent = true;
				}
			}

			if (doPrevent) {
				event.preventDefault();
			}

		});

		/**
		 * Actions - Prompt Modal on F5
		 */

		$(document).on( 'keydown', function(e){
			if ( ( e.which || e.keyCode ) == 116 ) {
				if ( jQuery('.dslca-save-composer-hook').is(':visible') || jQuery('.dslca-module-edit-save').is(':visible') ) {
					e.preventDefault();
					dslc_js_confirm( 'disable_lc', '<span class="dslca-prompt-modal-title">' + DSLCString.str_refresh_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_refresh_descr + '</span>', document.URL );
				}
			}
		});

		/**
		 * Hook - Refresh Module
		 */

		$(document).on( 'click', '.dslca-refresh-module-hook', function(e){

			$(this).css({
				'-webkit-animation-name' : 'dslcRotate',
				'-moz-animation-name' : 'dslcRotate',
				'animation-name' : 'dslcRotate',
				'animation-duration' : '0.6s',
				'-webkit-animation-duration' : '0.6s',
				'animation-iteration-count' : 'infinite',
				'-webkit-animation-iteration-count' : 'infinite'
			});
			$(this).closest('.dslc-module-front').addClass('dslca-module-being-edited');
			dslc_module_output_altered( function() {
				$('.dslca-module-being-edited').removeClass('dslca-module-being-edited');
			});

		});

	});

	// Disable the prompt ( are you sure ) on refresh
	window.onbeforeunload = function () { return; };

/*********************************
 *
 * = PENDING CLEANUP
 *
 *********************************/

	 jQuery(document).ready(function($) {

	 	// Option changes

		$(document).on( 'change', '.dslca-modules-section-edit-field', function() {

			var dslcField, dslcFieldID, dslcEl, dslcModulesSection, dslcVal, dslcValReal, dslcRule, dslcSetting, dslcTargetEl, dslcImgURL;

			dslcField = $(this);
			dslcFieldID = dslcField.data('id');
			dslcVal = dslcField.val();
			dslcValReal = dslcVal;
			dslcRule = dslcField.data('css-rule');

			dslcEl = $('.dslca-modules-section-being-edited');
			dslcTargetEl = dslcEl;
			dslcSetting = $('.dslca-modules-section-settings input[data-id="' + dslcFieldID + '"]', dslcEl );

			dslcEl.addClass('dslca-modules-section-change-made');

			// If image/upload field alter the value ( use from data )
			if ( dslcField.hasClass('dslca-modules-section-edit-field-upload') ) {
				if ( dslcVal && dslcVal.length )
					dslcVal = dslcField.data('dslca-img-url');
			}

			if ( dslcRule == 'background-image' ) {
				 dslcVal = 'url("' + dslcVal + '")';
				 dslc_bg_video();
			}

			if ( dslcFieldID == 'bg_image_attachment' ) {
				dslcEl.removeClass('dslc-init-parallax');
			}

			if ( dslcFieldID == 'border-top' || dslcFieldID == 'border-right' || dslcFieldID == 'border-bottom' || dslcFieldID == 'border-left' ) {

				var dslcBorderStyle = $('.dslca-modules-section-settings input[data-id="border_style"]').val();
				dslcSetting = $('.dslca-modules-section-settings input[data-id="border"]', dslcEl );

				dslcValReal = '';

				var dslcChecboxesWrap = dslcField.closest('.dslca-modules-section-edit-option-checkbox-wrapper');
				dslcChecboxesWrap.find('.dslca-modules-section-edit-field-checkbox').each(function(){
					if ( $(this).is(':checked') ) {

						if ( $(this).data('id') == 'border-top' ) {
							dslcValReal += 'top ';
						} else if ( $(this).data('id') == 'border-right' ) {
							dslcValReal += 'right ';
						} else if ( $(this).data('id') == 'border-bottom' ) {
							dslcValReal += 'bottom ';
						} else if ( $(this).data('id') == 'border-left' ) {
							dslcValReal += 'left ';
						}

					}
				});

				if ( dslcField.is(':checked') ) {

					if ( dslcField.data('id') == 'border-top' ) {
						dslcEl.css({ 'border-top-style' : dslcBorderStyle });
					} else if ( dslcField.data('id') == 'border-right' ) {
						dslcEl.css({ 'border-right-style' : dslcBorderStyle });
					} else if ( dslcField.data('id') == 'border-bottom' ) {
						dslcEl.css({ 'border-bottom-style' : dslcBorderStyle });
					} else if ( dslcField.data('id') == 'border-left' ) {
						dslcEl.css({ 'border-left-style' : dslcBorderStyle });
					}

				} else {

					if ( dslcField.data('id') == 'border-top' ) {
						dslcEl.css({ 'border-top-style' : 'hidden' });
					} else if ( dslcField.data('id') == 'border-right' ) {
						dslcEl.css({ 'border-right-style' : 'hidden' });
					} else if ( dslcField.data('id') == 'border-bottom' ) {
						dslcEl.css({ 'border-bottom-style' : 'hidden' });
					} else if ( dslcField.data('id') == 'border-left' ) {
						dslcEl.css({ 'border-left-style' : 'hidden' });
					}

				}
			} else if ( dslcField.hasClass( 'dslca-modules-section-edit-field-checkbox' ) ) {

				var checkboxes = $(this).closest('.dslca-modules-section-edit-option-checkbox-wrapper').find('.dslca-modules-section-edit-field-checkbox');
				var checkboxesVal = '';
				checkboxes.each(function(){
					if ( $(this).prop('checked') ) {
						checkboxesVal += $(this).data('val') + ' ';
					}
				});
				var dslcValReal = checkboxesVal;

				/* Show On */
				if ( dslcField.data('id') == 'show_on' ) {

					console.log( checkboxesVal );

					if ( checkboxesVal.indexOf( 'desktop' ) !== -1 ) {
						$('.dslca-modules-section-being-edited').removeClass('dslc-hide-on-desktop');
					} else {
						$('.dslca-modules-section-being-edited').addClass('dslc-hide-on-desktop');
					}

					if ( checkboxesVal.indexOf( 'tablet' ) !== -1 ) {
						$('.dslca-modules-section-being-edited').removeClass('dslc-hide-on-tablet');
					} else {
						$('.dslca-modules-section-being-edited').addClass('dslc-hide-on-tablet');
					}

					if ( checkboxesVal.indexOf( 'phone' ) !== -1 ) {
						$('.dslca-modules-section-being-edited').removeClass('dslc-hide-on-phone');
					} else {
						$('.dslca-modules-section-being-edited').addClass('dslc-hide-on-phone');
					}

				}

			} else if ( ( dslcFieldID == 'bg_image_attachment' && dslcVal == 'parallax' ) || dslcFieldID == 'type' ) {

				if ( dslcFieldID == 'bg_image_attachment' ) {
					dslcEl.addClass( 'dslc-init-parallax' );
					dslc_parallax();
				} else if ( dslcFieldID == 'type' ) {

					if ( dslcVal == 'full' )
						dslcEl.addClass('dslc-full');
					else
						dslcEl.removeClass('dslc-full');

					dslc_masonry();

				}
			} else if ( dslcFieldID == 'columns_spacing' ) {

				if ( dslcVal == 'nospacing' ) {
					dslcEl.addClass('dslc-no-columns-spacing');
				} else {
					dslcEl.removeClass('dslc-no-columns-spacing');
				}
			} else if ( dslcFieldID == 'custom_class' ) {

			} else if ( dslcFieldID == 'custom_id' ) {

			} else if ( dslcFieldID == 'bg_video' ) {

				jQuery('.dslc-bg-video video', dslcEl).remove();

				if ( dslcVal && dslcVal.length ) {
					var dslcVideoVal = dslcVal;
					dslcVideoVal = dslcVideoVal.replace( '.webm', '' );
					dslcVideoVal = dslcVideoVal.replace( '.mp4', '' );
					jQuery('.dslc-bg-video-inner', dslcEl).html('<video><source type="video/mp4" src="' + dslcVideoVal + '.mp4" /><source type="video/webm" src="' + dslcVideoVal + '.webm" /></video>');
					dslc_bg_video();
				}

			} else if ( dslcFieldID == 'bg_image_thumb' ) {

				if ( dslcValReal == 'enabled' ) {

					if ( jQuery('#dslca-post-data-thumb').length ) {
						var dslcThumbURL = "url('" + jQuery('#dslca-post-data-thumb').val() + "')";
						dslcTargetEl.css(dslcRule, dslcThumbURL );
					}

				} else if ( dslcValReal == 'disabled' ) {
					dslcTargetEl.css(dslcRule, 'none' );
				}

			} else {

				if ( dslcField.data('css-element') ) {
					dslcTargetEl = jQuery( dslcField.data('css-element'), dslcEl );
				}
				dslcTargetEl.css(dslcRule, dslcVal);

			}

			dslcSetting.val( dslcValReal );

			dslc_generate_code();
			dslc_show_publish_button();

		});

		// Editable Content

		jQuery(document).on('blur', '.dslca-editable-content', function() {

			if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' ) && jQuery(this).data('type') == 'simple' ) {

				dslc_editable_content_gen_code( jQuery(this) );

			}

		}).on( 'paste', '.dslca-editable-content', function(){

			if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' )  && jQuery(this).data('type') == 'simple' ) {

				var dslcRealInput = jQuery(this);

				setTimeout(function(){

					if ( dslcRealInput.data('type') == 'simple' ) {
						dslcRealInput.html( dslcRealInput.text() );
					}

					dslc_editable_content_gen_code( jQuery(this) );

				}, 1);

			}

		}).on('focus', '.dslca-editable-content', function() {

			if (  jQuery(this).data('type') == 'simple' ) {

				if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' ) ) {

					if ( ! jQuery(this).closest('.dslc-module-front').hasClass('dslca-module-being-edited') ) {
						jQuery(this).closest('.dslc-module-front').find('.dslca-module-edit-hook').trigger('click');
					}

				} else {

					$(this).trigger('blur');

				}

			}

		}).on('keyup', '.dslca-editable-content', function(){

			if ( jQuery(this).data('type') == 'simple' ) {
				jQuery(this).closest('.dslc-module-front').addClass('dslca-module-change-made');
			}

		});


		$(document).on( 'blur', '.dslc-editable-area', function(e){

			var module = $(this).closest('.dslc-module-front');
			var optionID = $(this).data('dslc-option-id');
			var optionVal = $(this).html();

			jQuery( '.dslca-module-options-front textarea[data-id="' + optionID + '"]', module ).val(optionVal);

			dslc_module_output_altered();

		});

		// Preview Module Settings

		$(document).on( 'change', '.dslca-module-edit-field', function(){

			// Hide/Show tabs
			dslc_module_options_hideshow_tabs();

			var dslcOptionValue = '',
				dslcOptionValueOrig = '',
				dslcOption = $(this),
				dslcOptionID = dslcOption.data('id'),
				dslcOptionWrap = dslcOption.closest('.dslca-module-edit-option'),
				dslcModule = $('.dslca-module-being-edited'),
				dslcModuleID = dslcModule.data('dslc-module-id'),
				dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule );

			// Add changed class
			dslcModule.addClass('dslca-module-change-made');

			if ( jQuery(this).closest('.dslca-module-edit-option').data('refresh-on-change') == 'active' ) {

				/**
				 * Get the new value
				 */

				if ( dslcOptionWrap.find('.dslca-module-edit-option-checkbox-wrapper').length ) {

					var dslcOptionChoices = $('input[type="checkbox"]', dslcOptionWrap);

					dslcOptionChoices.each(function(){

						if ( $(this).prop('checked') ) {
							dslcOptionValue = dslcOptionValue + $(this).val() + ' ';
						}

					});

				} else if ( dslcOption.hasClass('dslca-module-edit-option-radio') ) {
					var dslcOptionValue = $('.dslca-module-edit-field:checked', dslcOption).val();
				} else {

					var dslcOptionValue = dslcOption.val();

					// Orientation change
					if ( dslcOptionID == 'orientation' && dslcOptionValue == 'horizontal' ) {
						var dslcSliderEl = jQuery('.dslca-module-edit-option-thumb_width .dslca-module-edit-field-slider');
						dslcSliderEl.slider({ value: 40 }).slider('option', 'slide')(null, { value: dslcSliderEl.slider('value') })
					} else if ( dslcOptionID == 'orientation' && dslcOptionValue == 'vertical' ) {
						var dslcSliderEl = jQuery('.dslca-module-edit-option-thumb_width .dslca-module-edit-field-slider');
						dslcSliderEl.slider({ value: 100 }).slider('option', 'slide')(null, { value: dslcSliderEl.slider('value') })
					}

				}

				/**
				 * Change old value with new value
				 */

				jQuery( '.dslca-module-options-front textarea[data-id="' + dslcOptionID + '"]', dslcModule ).val(dslcOptionValue);

				jQuery('.dslca-container-loader').show();

				dslc_module_output_altered( function(){
					jQuery('.dslca-module-being-edited').addClass('dslca-module-change-made');
					if ( dslcOptionID == 'css_load_preset' && ! jQuery('body').hasClass('dslca-new-preset-added') ) {
						dslc_module_options_show( dslcModuleID );
						jQuery('.dslca-container-loader').hide();
					} else {
						jQuery('.dslca-container-loader').hide();
					}
					jQuery('body').removeClass('dslca-new-preset-added');
				});

			} else {

				/**
				 * Live Preview
				 */

				if ( dslcOption.hasClass('dslca-module-edit-field-font') ) {

					var dslcFontsToLoad = dslcOption.val();
					dslcFontsToLoad = dslcFontsToLoad + ':400,100,200,300,500,600,700,800,900';

					var dslcAffectOnChangeEl = dslcOption.data('affect-on-change-el');
					var dslcAffectOnChangeRule = dslcOption.data('affect-on-change-rule');
					var dslcAffectOnChangeVal = dslcOption.val();
					var dslcAffectOnChangeValOrig = dslcAffectOnChangeVal;

					if ( dslcOption.val().length && dslcGoogleFontsArray.indexOf( dslcOption.val() ) !== -1  ) {

						WebFont.load({
								google: {
									families: [ dslcFontsToLoad ]
								},
								active : function(familyName, fvd) {
									if ( jQuery( '.dslca-font-loading' ).closest('.dslca-module-edit-field-font-next').length )
										jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-right');
									else
										jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-left');
									jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcAffectOnChangeVal );
								},
								inactive : function ( familyName, fvd ) {
									if ( jQuery( '.dslca-font-loading' ).closest('.dslca-module-edit-field-font-next').length )
										jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-right');
									else
										jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-left');
								}
							}
						);

					} else {

						setTimeout( function(){

							if ( jQuery( '.dslca-font-loading.dslca-module-edit-field-font-next' ).length )
								jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-right');
							else
								jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-left');

							jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcAffectOnChangeVal );

						}, 100);

					}

				} else if ( dslcOption.hasClass('dslca-module-edit-field-checkbox') ) {

					var dslcOptionChoices = $('input[type="checkbox"]', dslcOptionWrap);

					dslcOptionChoices.each(function(){

						if ( $(this).prop('checked') ) {
							dslcOptionValue = dslcOptionValue + 'solid ';
							dslcOptionValueOrig = dslcOptionValueOrig + $(this).val() + ' ';
						} else {
							dslcOptionValue = dslcOptionValue + 'none ';
						}

					});

				}

				if ( ! dslcOption.hasClass('dslca-module-edit-field-font') ) {

					var dslcAffectOnChangeEl = dslcOption.data('affect-on-change-el');
					var dslcAffectOnChangeRule = dslcOption.data('affect-on-change-rule');
					var dslcAffectOnChangeVal = dslcOption.val();
					var dslcAffectOnChangeValOrig = dslcAffectOnChangeVal;

					if ( dslcOption.hasClass('dslca-module-edit-field-checkbox') ) {
						dslcAffectOnChangeVal = dslcOptionValue;
						dslcAffectOnChangeValOrig = dslcOptionValueOrig;
					}

					if ( dslcOption.hasClass('dslca-module-edit-field-image') ) {
						dslcAffectOnChangeVal = 'url("' + dslcAffectOnChangeVal + '")';
					}

					if ( dslcAffectOnChangeVal.length < 1 && ( dslcAffectOnChangeRule == 'background-color' || dslcAffectOnChangeRule == 'background' ) ) {
						dslcAffectOnChangeVal = 'transparent';
					}

					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcAffectOnChangeVal );

				}

				/**
				 * Update option
				 */

				jQuery( '.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule ).val( dslcAffectOnChangeValOrig );

			}

		});


		// Preview Module Opt Change - Numeric

		$(document).on( 'keyup, blur', '.dslca-module-edit-field-numeric', function(){

			var dslcOptionValue = '',
				dslcOption = $(this),
				dslcOptionID = dslcOption.data('id'),
				dslcOptionWrap = dslcOption.closest('.dslca-module-edit-option'),
				dslcModule = $('.dslca-module-being-edited'),
				dslcModuleID = dslcModule.data('dslc-module-id'),
				dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
				dslcAffectOnChangeEl = dslcOption.data('affect-on-change-el'),
				dslcAffectOnChangeRule = dslcOption.data('affect-on-change-rule'),
				dslcAffectOnChangeValOrig = dslcOption.val(),
				dslcAffectOnChangeVal = dslcAffectOnChangeValOrig + dslcOption.data('ext'),
				dslcAffectOnChangeRules;

			// Add changed class
			dslcModule.addClass('dslca-module-change-made');

			if ( jQuery(this).closest('.dslca-module-edit-option').data('refresh-on-change') != 'active' ) {

				/**
				 * Live Preview
				 */

				dslcAffectOnChangeRules = dslcAffectOnChangeRule.replace(/ /g,'').split( ',' );

				// Loop through rules (useful when there are multiple rules)
				for ( var i = 0; i < dslcAffectOnChangeRules.length; i++ ) {
					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRules[i] , dslcAffectOnChangeVal );
				}

				/**
				 * Update option
				 */

				jQuery( '.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule ).val( dslcAffectOnChangeValOrig );

			}

		});


		//Preview Module Section Opt Change - Numeric

		$(document).on( 'keyup', '.dslca-modules-section-edit-field-numeric', function(){

			var dslcOptionValue = '',
				dslcOption = $(this),
				dslcOptionID = dslcOption.data('id'),
				dslcOptionWrap = dslcOption.closest('.dslca-modules-section-edit-option'),
				dslcModulesSection = $('.dslca-modules-section-being-edited'),
				dslcAffectOnChangeRule = dslcOption.data('css-rule'),
				dslcAffectOnChangeValOrig = dslcOption.val(),
				dslcAffectOnChangeVal = dslcAffectOnChangeValOrig + dslcOption.data('ext'),
				dslcAffectOnChangeRules;

			// Add changed class
			dslcModulesSection.addClass('dslca-modules-section-change-made');

			/**
			 * Live Preview
			 */

			dslcAffectOnChangeRules = dslcAffectOnChangeRule.replace(/ /g,'').split( ',' );

			// Loop through rules (useful when there are multiple rules)
			for ( var i = 0; i < dslcAffectOnChangeRules.length; i++ ) {
				dslcModulesSection.css( dslcAffectOnChangeRules[i] , dslcAffectOnChangeVal );
			}

			/**
			 * Update option
			 */

			jQuery( '.dslca-modules-section-settings input[data-id="' + dslcOptionID + '"]', dslcModulesSection ).val( dslcAffectOnChangeValOrig );

		});

	});


	jQuery(document).ready(function($){

		// Uploading files
		var file_frame;

		jQuery(document).on('click', '.dslca-module-edit-field-image-add-hook, .dslca-modules-section-edit-field-image-add-hook', function(){

			var hook = jQuery(this);

			if ( hook.hasClass( 'dslca-module-edit-field-image-add-hook' ) ) {

				var field = hook.siblings('.dslca-module-edit-field-image');
				var removeHook = hook.siblings('.dslca-module-edit-field-image-remove-hook');

			} else {

				var field = hook.siblings('.dslca-modules-section-edit-field-upload');
				var removeHook = hook.siblings('.dslca-modules-section-edit-field-image-remove-hook');

			}

			// Whether or not multiple files are allowed
			var multiple = false;

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Confirm',
				},
				multiple: multiple
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {

				var attachment = file_frame.state().get('selection').first().toJSON();
				field.val( attachment.id ).data( 'dslca-img-url', attachment.url ).trigger('change');
				hook.hide();
				removeHook.show();

			});

			// Finally, open the modal
			file_frame.open();

		});

		jQuery(document).on('click', '.dslca-module-edit-field-image-remove-hook, .dslca-modules-section-edit-field-image-remove-hook', function(){

			var hook = jQuery(this);

			if ( hook.hasClass( 'dslca-module-edit-field-image-remove-hook' ) ) {

				var field = hook.siblings('.dslca-module-edit-field-image');
				var addHook = hook.siblings('.dslca-module-edit-field-image-add-hook');

			} else {

				var field = hook.siblings('.dslca-modules-section-edit-field-upload');
				var addHook = hook.siblings('.dslca-modules-section-edit-field-image-add-hook');

			}

			field.val('').trigger('change');
			hook.hide();
			addHook.show();

		});

		/**
		 * Show WYSIWYG
		 */

		$(document).on( 'click', '.dslca-wysiwyg-actions-edit-hook', function(){

			var editable = $(this).parent().siblings('.dslca-editable-content');
			var module = editable.closest('.dslc-module-front');

			if ( module.hasClass('dslc-module-handle-like-accordion') ) {

				dslc_accordion_generate_code( module.find('.dslc-accordion') );
				var full_content = module.find( '.dslca-module-option-front[data-id="accordion_content"]' ).val();
				var full_content_arr = full_content.split('(dslc_sep)');
				var key_value = editable.closest('.dslc-accordion-item').index();
				var content = full_content_arr[key_value].trim().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');

			} else if ( module.hasClass('dslc-module-handle-like-tabs') ) {

				dslc_tabs_generate_code( module.find('.dslc-tabs') );
				var full_content = module.find( '.dslca-module-option-front[data-id="tabs_content"]' ).val();
				var full_content_arr = full_content.split('(dslc_sep)');
				var key_value = editable.closest('.dslc-tabs-tab-content').index();
				var content = full_content_arr[key_value].trim().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');

			} else {

				var content = module.find( '.dslca-module-option-front[data-id="' + editable.data('id') + '"]' ).val().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');

			}

			if( typeof tinymce != "undefined" ) {

				var editor = tinymce.get( 'dslcawpeditor' );
				if ( $('#wp-dslcawpeditor-wrap').hasClass('tmce-active') ) {
					editor.setContent( content, {format : 'html'} );
				} else {
					jQuery('textarea#dslcawpeditor').val( content );
				}

				if ( ! module.hasClass('dslca-module-being-edited') ) {
					module.find('.dslca-module-edit-hook').trigger('click');
				}

				$('.dslca-wp-editor').show();
				editable.addClass('dslca-wysiwyg-active');

				$('#dslcawpeditor_ifr, #dslcawpeditor').css({ height : $('.dslca-wp-editor').height() - 350 });

			}

		});

		/**
		 * Confirm WYSIWYG
		 */

		$(document).on( 'click', '.dslca-wp-editor-save-hook', function(){

			var module = $('.dslca-wysiwyg-active').closest('.dslc-module-front');

			if( typeof tinymce != "undefined" ) {

				if ( $('#wp-dslcawpeditor-wrap').hasClass('tmce-active') ) {
					var editor = tinymce.get( 'dslcawpeditor' );
					var content = editor.getContent();
				} else {
					var content = $('#dslcawpeditor').val();
				}

				$('.dslca-wp-editor').hide();
				$('.dslca-wysiwyg-active').html( content );

				if ( module.hasClass('dslc-module-handle-like-accordion') ) {
					$('.dslca-wysiwyg-active').siblings('.dslca-accordion-plain-content').val( content );
					var dslcAccordion = module.find('.dslc-accordion');
					dslc_accordion_generate_code( dslcAccordion );
				} else if ( module.hasClass('dslc-module-handle-like-tabs') ) {
					$('.dslca-wysiwyg-active').siblings('.dslca-tab-plain-content').val( content );
					var dslcTabs = module.find('.dslc-tabs');
					dslc_tabs_generate_code( dslcTabs );
				}


				dslc_editable_content_gen_code( $('.dslca-wysiwyg-active') );
				$('.dslca-wysiwyg-active').removeClass('dslca-wysiwyg-active');

			}

		});

		/**
		 * Cancel WYSIWYG
		 */

		$(document).on( 'click', '.dslca-wp-editor-cancel-hook', function(){

			$('.dslca-wp-editor').hide();
			$('.dslca-wysiwyg-active').removeClass('dslca-wysiwyg-active');

		});

	});