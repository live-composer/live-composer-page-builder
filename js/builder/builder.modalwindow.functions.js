/*********************************
 *
 * = UI - MODAL =
 * Note: Used for the templates save/export/import and icons
 *
 * - dslc_show_modal ( Show Modal )
 * - dslc_hide_modal ( Hide Modal )
 *
 ***********************************/

'use strict';

	/**
	 * MODAL - Show
	 *
	 * @param {Object} hook - Button that was clicked to open modal
	 * @param {string} modal - CSS address of the modal, like '.modal-icons'
	 */

	function dslc_show_modal( hook, modal ) {

		if ( typeof dslcDebug !== 'undefined' && dslcDebug ) console.log( 'dslc_show_modal' );

		if ( jQuery('.dslca-modal:visible').length ) {
			// If a modal already visibile hide it
			dslc_hide_modal( '', jQuery('.dslca-modal:visible') );
		}

		// Vars
		var modal = jQuery(modal);

		// Calc popup height
		var containerHeight = jQuery('.dslca-container').height();
		modal.outerHide({
			clbk: function(){

				dslc_hide_modal( '', jQuery('.dslca-modal:visible') );
			}
		});

		// Vars ( Calc Offset )
		var position = jQuery(hook).position(),
		diff = modal.outerWidth() / 2 - hook.outerWidth() / 2,
		offset = position.left - diff;

		// Show Modal
		modal.css({ left : offset });
		jQuery(".dslca-prompt-modal-custom").insertAfter( modal );
		if ( jQuery(".dslca-prompt-modal-custom").length > 0 ) {
			jQuery(".dslca-prompt-modal-custom").fadeIn();
		}
		modal.addClass('dslca-modal-open').show();

		// Animate Modal
		// modal.css({
			// '-webkit-animation-name' : 'dslcBounceIn',
			// '-moz-animation-name' : 'dslcBounceIn',
			// 'animation-name' : 'dslcBounceIn',
			// 'animation-duration' : '0.6s',
			// '-webkit-animation-duration' : '0.6s'
		// }).fadeIn(600);
	}

	/**
	 * MODAL - Hide
	 */

	function dslc_hide_modal( hook, modal ) {

		if ( typeof dslcDebug !== 'undefined' && dslcDebug ) console.log( 'dslc_hide_modal' );

		console.log( 'dslc_hide_modal' );

		// Vars
		var modal = jQuery(modal);

		// Hide ( with animation )
		modal.outerHide( 'destroy' );
		modal.hide();
		if ( jQuery(".dslca-prompt-modal-custom").length > 0 ) {
			jQuery(".dslca-prompt-modal-custom").fadeOut();
		}
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
	/*jQuery(document).mouseup(function (e) {
		 var container = jQuery(".dslca-modal-open");

		 if (!container.is(e.target) // if the target of the click isn't the container...
			&& container.has(e.target).length === 0) // ... nor a descendant of the container
		 {
			container.hide();
		 }
	});*/

	/**
	 * MODAL - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Hook - Show Modal
		 */

		$(document).on( 'click', '.dslca-open-modal-hook', function(e){
			e.preventDefault();
			var modal = jQuery(this).data('modal');
			dslc_show_modal( jQuery(this), modal );
		});

		/**
		 * Hook - Hide Modal
		 */

		jQuery(document).on( 'click', '.dslca-close-modal-hook', function(e){

			e.preventDefault();

			if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

				var modal = jQuery(this).data('modal');
				dslc_hide_modal( jQuery(this), modal );
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

		if ( typeof dslcDebug !== 'undefined' && dslcDebug ) console.log( 'dslc_js_confirm' );

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

		if ( typeof dslcDebug !== 'undefined' && dslcDebug ) console.log( 'dslc_js_confirm_close' );

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
	 * Hook - Confirm on Enter, Cancel on Esc
	 */

	function dslc_modal_keypress_events(e) {

		// Enter ( confirm )
		if( e.which == 13 ) {
			if ( jQuery('.dslca-prompt-modal-active').length ) {
				jQuery('.dslca-prompt-modal-confirm-hook').trigger('click');
			}

		// Escape ( cancel )
		} else if ( e.which == 27 ) {
			if ( jQuery('.dslca-prompt-modal-active').length ) {
				jQuery('.dslca-prompt-modal-cancel-hook').trigger('click');
			}
		}

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

				/// MOVED
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

				/// MOVED
				dslc_module_options_confirm_changes( function(){
					dslcTarget.trigger('click');
				});

			} else if ( dslcAction == 'disable_lc' ) {

				window.location = dslcTarget;

			} else if ( 'delete_module' === dslcAction ) {

				/// MOVED
				var module = dslcTarget.closest('.dslc-module-front');
				dslc_delete_module( module );

			} else if ( 'delete_modules_area' === dslcAction ) {

				var modulesArea = dslcTarget.closest('.dslc-modules-area');
				var parentSectionContainer = modulesArea.closest('.dslc-modules-section-inner');
				dslc_modules_area_delete( modulesArea );

			} else if ( dslcAction == 'delete_modules_section' ) {

				/// MOVED
				dslc_row_delete( dslcTarget.closest('.dslc-modules-section') );

			} else if ( dslcAction == 'export_modules_section' ) {

			} else if ( dslcAction == 'import_modules_section' ) {

				/// MOVED
				dslc_row_import( $('.dslca-prompt-modal textarea').val() );
				$('.dslca-prompt-modal-confirm-hook span').css({ opacity : 0 });
				$('.dslca-prompt-modal-confirm-hook .dslca-loading').show();
				closeAtEnd = false;
			}

			if ( closeAtEnd )
				dslc_js_confirm_close();

			jQuery('.dslca-prompt-modal').data( 'id', '' );
		});

	});

	/**
	 * DON'T MOVE THE FUNCTION BELLOW OUT OF THIS FILE!
	 * Hide element when click on another element on the page
	 *
	 * @author Alexey Petlenko
	 */
	jQuery.fn.outerHide = function(params)
	{
	    var $ = jQuery;
	    params = params ? params : {};

	    var self = this;

	    if ( 'destroy' == params ) {

	        $(document).unbind('click.outer_hide');
	        return false;
	    }

	    $(document).bind('click.outer_hide', function(e) {

	        if ($(e.target).closest(self).length == 0 &&
	            e.target != self &&
	            $.inArray($(e.target)[0], $(params.clickObj)) == -1 &&
	            $(self).css('display') != 'none'
	        )
	        {
	            if(params.clbk)
	            {
	                params.clbk();
	            }else{
	                $(self).hide();
	            }
	        }
	    });
	}

