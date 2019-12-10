/*********************************
 *
 * = UI - MODAL =
 * Note: Used for the templates save/export/import and icons
 *
 * - dslc_show_modal ( Show Modal )
 * - dslc_hide_modal ( Hide Modal )
 *
 ***********************************/
import { editableContentCodeGeneration } from "./codegeneration.js";

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
		hideModal( '', jQuery('.dslca-modal:visible') );
	}

	// Vars
	var modal = jQuery(modal);

	// Calc popup height
	var containerHeight = jQuery('.dslca-container').height();
	modal.outerHide({
		clbk: function(){

			hideModal( '', jQuery('.dslca-modal:visible') );
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

 // ex. dslc_hide_modal
export const hideModal = ( hook, modal ) => {

	if ( typeof dslcDebug !== 'undefined' && dslcDebug ) console.log( 'hideModal' );

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

	jQuery(document).on( 'click', '.dslca-open-modal-hook', function(e){
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
			hideModal( jQuery(this), modal );
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

// ex. dslc_js_confirm_close
export const confirmClose = () => {

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

window.dslc_modal_keypress_events = function dslc_modal_keypress_events(e) {

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

	jQuery(document).on( 'click', '.dslca-prompt-modal-cancel-hook', function(e){

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

		confirmClose();
		jQuery('.dslca-prompt-modal').data( 'id', '' );

	});

	jQuery(document).on( 'click', '.dslca-prompt-modal-confirm-hook', function(e){

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
			dslc_module_delete( module );

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
			dslc_row_import( jQuery('.dslca-prompt-modal textarea').val() );
			jQuery('.dslca-prompt-modal-confirm-hook span').css({ opacity : 0 });
			jQuery('.dslca-prompt-modal-confirm-hook .dslca-loading').show();
			closeAtEnd = false;
		}

		if ( closeAtEnd ) {
			confirmClose();
		}

		jQuery('.dslca-prompt-modal').data( 'id', '' );
	});

});

/**
 * DON'T MOVE THE FUNCTION BELLOW OUT OF THIS FILE!
 * Hide element when click on another element on the page
 */
jQuery.fn.outerHide = function(params) {
	var $ = jQuery;
	params = params ? params : {};

	var self = this;

	if ( 'destroy' == params ) {

		jQuery(document).unbind('click.outer_hide');
		return false;
	}

	jQuery(document).bind('click.outer_hide', function(e) {

		if (jQuery(e.target).closest(self).length == 0 &&
			e.target != self &&
			$.inArray(jQuery(e.target)[0], jQuery(params.clickObj)) == -1 &&
			jQuery(self).css('display') != 'none'
		)
		{
			if(params.clbk)
			{
				params.clbk();
			}else{
				jQuery(self).hide();
			}
		}
	});
}

/**
 * Cancel changes in standard WP Editor (TinyMCE) WYSIWYG
 */
document.addEventListener( 'modalWysiwygCancel', function ( customEvent ) {
	jQuery('.dslca-wp-editor').hide();
	jQuery('.dslca-wysiwyg-active', LiveComposer.Builder.PreviewAreaDocument ).removeClass('dslca-wysiwyg-active');
});

/**
 * Confirm changes in standard WP Editor (TinyMCE) WYSIWYG
 */
document.addEventListener( 'modalWysiwygConfirm', function ( customEvent ) {
	var module = jQuery('.dslca-wysiwyg-active', LiveComposer.Builder.PreviewAreaDocument ).closest('.dslc-module-front');

	if( typeof tinymce != "undefined" ) {
		if ( jQuery('#wp-dslcawpeditor-wrap').hasClass('tmce-active') ) {
			var editor = tinymce.get( 'dslcawpeditor' );
			var content = editor.getContent();
		} else {
			var content = jQuery('#dslcawpeditor').val();
		}

		content = content.trim();
		jQuery('.dslca-wp-editor').hide();
		jQuery('.dslca-wysiwyg-active', LiveComposer.Builder.PreviewAreaDocument ).html( content );

		if ( module.hasClass('dslc-module-handle-like-accordion') ) {
			jQuery('.dslca-wysiwyg-active', LiveComposer.Builder.PreviewAreaDocument ).siblings('.dslca-editable-content').html( content );
			jQuery('.dslca-wysiwyg-active', LiveComposer.Builder.PreviewAreaDocument ).siblings('.dslca-accordion-plain-content').val( content );
			var dslcAccordion = module.find('.dslc-accordion');
			LiveComposer.Builder.PreviewAreaWindow.dslc_accordion_generate_code( dslcAccordion );
		} else if ( module.hasClass('dslc-module-handle-like-tabs') ) {
			jQuery('.dslca-wysiwyg-active', LiveComposer.Builder.PreviewAreaDocument ).siblings('.dslca-editable-content').html( content );
			jQuery('.dslca-wysiwyg-active', LiveComposer.Builder.PreviewAreaDocument ).siblings('.dslca-tab-plain-content').val( content );
			var dslcTabs = module.find('.dslc-tabs');
			LiveComposer.Builder.PreviewAreaWindow.dslc_tabs_generate_code( dslcTabs );
		} else {
			// The next function is not compatible for Tab and Accordions.
			editableContentCodeGeneration( jQuery('.dslca-wysiwyg-active', LiveComposer.Builder.PreviewAreaDocument ) );
		}

		jQuery('.dslca-wysiwyg-active', LiveComposer.Builder.PreviewAreaDocument ).removeClass('dslca-wysiwyg-active');
	} else {
		console.info( 'Live Composer: TinyMCE is undefined.' );
	}
});

export const modalwindowInitJS = () => {

}
