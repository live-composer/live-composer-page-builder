/*********************************
 *
 * = ROWS =
 *
 * - dslc_row_add ( Add New )
 * - dslc_row_delete ( Delete )
 * - dslc_row_edit ( Edit )
 * - dslc_row_edit_slider_init ( Edit - Initiate Slider )
 * - dslc_row_edit_cancel ( Edit - Cancel Changes )
 * - dslc_row_edit_confirm ( Edit - Confirm Changes )
 * - dslc_row_copy ( Copy )
 * - dslc_row_import ( Import )
 *
 ***********************************/

'use strict';

;jQuery(document).on('editorFrameLoaded', function(){

	var $ = jQuery;

	var actionAvail = function() {

		if ( LiveComposer.Builder.Flags.panelOpened ) {

			LiveComposer.Builder.UI.shakePanelConfirmButton();
			return false;
		}

		return true;
	}

	jQuery(".dslc-modules-section", LiveComposer.Builder.PreviewAreaDocument).each(function(){

		new LiveComposer.Builder.Elements.CRow(this);
	});

	/**
	 * Hook - Delete Row
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-delete-modules-section-hook', function(e){

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		e.preventDefault();
		var self = this;

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			LiveComposer.Builder.UI.CModalWindow({
				title: DSLCString.str_del_row_title,
				content: DSLCString.str_del_row_descr,
				confirm: function() {

					dslc_row_delete( $(self).closest('.dslc-modules-section') );
				}
			})

		/*	dslc_js_confirm( 'delete_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_row_title +
				'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_row_descr + '</span>', $(this) );*/
		}
	});

	/**
	 * Hook - Import Row
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-import-modules-section-hook', function(e) {

		e.preventDefault();

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

			LiveComposer.Builder.UI.CModalWindow({
				title: DSLCString.str_import_row_title,
				content: DSLCString.str_import_row_descr + '<br><br><textarea></textarea>',
				confirm: function(){
					dslc_row_import( jQuery('.dslca-prompt-modal textarea').val() );
					jQuery('.dslca-prompt-modal-confirm-hook span').css({ opacity : 0 });
					jQuery('.dslca-prompt-modal-confirm-hook .dslca-loading').show();
				},
				confirm_title: DSLCString.str_import
			});

			/*$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span><span>' + DSLCString.str_import +
				'</span><div class="dslca-loading followingBallsGWrap"><div class="followingBallsG_1 followingBallsG"></div>'+
				'<div class="followingBallsG_2 followingBallsG"></div><div class="followingBallsG_3 followingBallsG"></div><div class="followingBallsG_4 followingBallsG"></div></div>');

			dslc_js_confirm( 'import_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_import_row_title +
				'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_import_row_descr + ' <br><br><textarea></textarea></span>', $(this) );*/
		}
	});

	/**
	 * Hook - Export Row
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-export-modules-section-hook', function(e) {

		e.preventDefault();

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			$('.dslca-prompt-modal-cancel-hook').hide();
			$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>' + DSLCString.str_ok);

			LiveComposer.Builder.UI.CModalWindow({

				title: DSLCString.str_export_row_title,
				content: DSLCString.str_export_row_descr + '<br><br><textarea>' + '[' + dslc_generate_section_code( $(this).closest('.dslc-modules-section') ) + ']' + '</textarea></span>'
			});

			// dslc_js_confirm( 'export_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_export_row_title +
			// 	'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_export_row_descr + ' <br><br><textarea></textarea></span>', $(this) );
			// $('.dslca-prompt-modal textarea').val( dslc_generate_section_code( $(this).closest('.dslc-modules-section') ) );
		}
	});

	/**
	 * Hook - Copy Row
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-copy-modules-section-hook', function() {

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

			dslc_row_copy( jQuery(this).closest('.dslc-modules-section') );
		}
	});

	/**
	 * Hook - Add Row
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-add-modules-section-hook', function(e){

		e.preventDefault();

		// Check if action can be fired
		if ( !actionAvail() ) return false;

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
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-edit-modules-section-hook', function(){

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		var self = this;

		var module_edited = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).length;
		var row_edited = jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).length;

		/// If settings panel opened - finish func
		if ( $('body').hasClass( 'dslca-composer-hidden' ) || module_edited > 0 || row_edited > 0 ) return false;

		// If not disabled ( disabling used for tutorial )
		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			// Trigger the function to edit
			dslc_row_edit( $(this).closest('.dslc-modules-section') );
		}

		jQuery('body', LiveComposer.Builder.PreviewAreaDocument).addClass('section-editing-in-progress');
	});
});

/**
 * Row - Add New
 */
function dslc_row_add( callback ) {

	if ( dslcDebug ) console.log( 'dslc_row_add' );

	callback = typeof callback !== 'undefined' ? callback : false;

	var defer = jQuery.Deferred();
	var browserCacheTmp = sessionStorage;

	var newRow = jQuery();
	var cachedAjaxRequest = browserCacheTmp.getItem( 'cache-dslc-ajax-add-modules-section' );

	// If no cache for current Ajax request.
	if ( null === cachedAjaxRequest ) {

		// AJAX Request
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-add-modules-section',
				dslc : 'active'
			},
			function( response ) {

				// newRow = jQuery(response.output);
				browserCacheTmp.setItem( 'cache-dslc-ajax-add-modules-section', response.output );

				newRow = dslc_row_after_add( response.output );

				if ( callback ) { callback(); }
				return defer;
			}
		);

	} else {
		// There is cached version of AJAX request.
		// newRow = jQuery(cachedAjaxRequest);

		newRow = dslc_row_after_add( cachedAjaxRequest );

		if ( callback ) { callback(); }
		return defer;
	}
}

/**
 * Finish new row creation process.
 *
 * @param  {String} newRowHTML HTML code of the new row.
 * @return {jQuery}            New ROW jQuery object.
 */
function dslc_row_after_add( newRowHTML ) {

	var newRow = jQuery(newRowHTML);

	// Append new row
	newRow.appendTo(LiveComposer.Builder.PreviewAreaDocument.find("#dslc-main"));

	// Call other functions
	dslc_drag_and_drop();
	dslc_generate_code();
	dslc_show_publish_button();

	new LiveComposer.Builder.Elements.CRow(newRow);
	new LiveComposer.Builder.Elements.CModuleArea( newRow.find('.dslc-modules-area').eq(0)[0] );

	newRow.find('.dslc-modules-area').addClass('dslc-modules-area-empty dslc-last-col');

	return newRow;
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
	jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');
	jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-modules-section-being-edited').removeClass('dslca-modules-section-change-made');
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


		/**
		 * Temporary migration from 'wrapped' value to 'wrapper' in ROW type selector
		 * TODO: delete this block in a few versions as problem do not exists on new installs
		 *
		 * @since ver 1.1
		 */
		if ( 'type' === jQuery(this).data('id') ) {

			if ( '' === jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="type"]', LiveComposer.Builder.PreviewAreaDocument).val() ||
				  'wrapped' === jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="type"]', LiveComposer.Builder.PreviewAreaDocument).val() ) {
				jQuery('select[data-id="type"]').val('wrapper').change();
			}
		}

		if ( jQuery(this).data('id') == 'border-top' ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf('top') >= 0 ) {
				jQuery(this).prop('checked', true);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery(this).prop('checked', false);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}

		} else if ( jQuery(this).data('id') == 'border-right' ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf('right') >= 0 ) {
				jQuery(this).prop('checked', true);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery(this).prop('checked', false);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}

		} else if ( jQuery(this).data('id') == 'border-bottom' ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf('bottom') >= 0 ) {
				jQuery(this).prop('checked', true);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery(this).prop('checked', false);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}

		} else if ( jQuery(this).data('id') == 'border-left' ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf('left') >= 0 ) {
				jQuery(this).prop('checked', true);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery(this).prop('checked', false);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}
		} else if ( jQuery(this).hasClass('dslca-modules-section-edit-field-checkbox') ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="' + jQuery(this).data('id') + '"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf( jQuery(this).data('val') ) >= 0 ) {
				jQuery( this ).prop('checked', true);
				jQuery( this ).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery( this ).prop('checked', false);
				jQuery( this ).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}
		} else {

			jQuery(this).val( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="' + jQuery(this).data('id') + '"]', LiveComposer.Builder.PreviewAreaDocument ).val() );

			if ( jQuery( this ).hasClass( 'dslca-modules-section-edit-field-colorpicker' ) ) {

				var _this = jQuery( this );
				jQuery( this ).closest( '.dslca-modules-section-edit-option' )
						.find( '.sp-preview-inner' )
						.removeClass('sp-clear-display')
						.css({ 'background-color' : _this.val() });

				jQuery( this ).css({ 'background-color' : _this.val() });
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
	// dslc_row_edit_slider_init();

	// Show options management
	dslc_show_section('.dslca-modules-section-edit');

	LiveComposer.Builder.Flags.panelOpened = true;

	// Hide the publish button
	dslc_hide_publish_button();
}

/**
 * Row - Edit - Cancel Changes
 */
function dslc_row_edit_cancel( callback ) {

	if ( dslcDebug ) console.log( 'dslc_row_cancel_changes' );

	callback = typeof callback !== 'undefined' ? callback : false;

	// Time to generate code optimized {HACK}
	LiveComposer.Builder.Flags.generate_code_after_row_changed = false;

	// Recover original data from data-def attribute for each control
	jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input', LiveComposer.Builder.PreviewAreaDocument).each(function(){

		jQuery(this).val( jQuery(this).data('def') );

		// Fire change for every ROW control, so it redraw linked CSS properties
		jQuery('.dslca-modules-section-edit-field[data-id="' + jQuery(this).data('id') + '"]').val( jQuery(this).data('def') ).trigger('change');
	});

	LiveComposer.Builder.Flags.generate_code_after_row_changed = true;
	dslc_generate_code();
	dslc_show_publish_button();

	dslc_show_section('.dslca-modules');

	// Hide the save/cancel actions
	jQuery('.dslca-row-edit-actions').hide();

	// Hide the styling/responsive tabs
	jQuery('.dslca-row-options-filter-hook').hide();

	// Show the section hooks
	jQuery('.dslca-header .dslca-go-to-section-hook').show();

	// Show the publish button
	dslc_show_publish_button;

	// Remove being edited class
	jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-modules-section-being-edited dslca-modules-section-change-made');

	if ( callback ) { callback(); }

	LiveComposer.Builder.Flags.panelOpened = false;
	jQuery("body", LiveComposer.Builder.PreviewAreaDocument).removeClass('section-editing-in-progress');

}

/**
 * Row - Edit - Confirm Changes
 */
function dslc_row_edit_confirm( callback ) {

	if ( dslcDebug ) console.log( 'dslc_confirm_row_changes' );

	callback = typeof callback !== 'undefined' ? callback : false;

	jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input', LiveComposer.Builder.PreviewAreaDocument).each(function(){

		jQuery(this).data( 'def', jQuery(this).val() );
	});

	dslc_show_section('.dslca-modules');

	// Hide the save/cancel actions
	jQuery('.dslca-row-edit-actions').hide();

	// Hide the styling/responsive tabs
	jQuery('.dslca-row-options-filter-hook').hide();

	// Show the section hooks
	jQuery('.dslca-header .dslca-go-to-section-hook').show();

	// Remove being edited class
	jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-modules-section-being-edited dslca-modules-section-change-made');

	dslc_generate_code();

	// Show the publish button
	dslc_show_publish_button();

	if ( callback ) { callback(); }

	LiveComposer.Builder.Flags.panelOpened = false;
	jQuery("body", LiveComposer.Builder.PreviewAreaDocument).removeClass('section-editing-in-progress');
}

/**
 * Row - Copy
 */
function dslc_row_copy( row ) {

	if ( dslcDebug ) console.log( 'dslc_row_copy' );

	// Vars that will be used
	var dslc_module_id,
	dslcModulesSectionCloned,
	dslcModule;

	// Clone the row
	dslcModulesSectionCloned = row.clone().appendTo( jQuery('#dslc-main', LiveComposer.Builder.PreviewAreaDocument ) );

	// Mark new ROW as NON initialized
	dslcModulesSectionCloned[0].removeAttribute('data-jsinit');

	// Go through each area of the new row and apply correct data-size
	// Mark each module area inside as NON initialized (2)
	dslcModulesSectionCloned.find('.dslc-modules-area').each(function(){
		var dslcIndex = jQuery(this).index();
		jQuery(this).data('size', row.find('.dslc-modules-area:eq( ' + dslcIndex + ' )').data('size') );

		this.removeAttribute('data-jsinit'); // (2)
	});

	new LiveComposer.Builder.Elements.CRow(dslcModulesSectionCloned);

	/**
	 * Re-render modules inside of the new ROW
	 */

	// Remove animations and temporary hide modules inside
	dslcModulesSectionCloned.find('.dslc-module-front').css({
		'-webkit-animation-name' : 'none',
		'-moz-animation-name' : 'none',
		'animation-name' : 'none',
		'animation-duration' : '0',
		'-webkit-animation-duration' : '0',
		opacity : 0

	// Go through each module inside the new ROW
	}).each(function(){

		// Current module
		var dslc_module = jQuery(this);

		//Generate new ID for the new module and change it in HTML/CSS of the module.
		dslc_module_new_id( dslc_module[0] );

		// Check init for rows and module areas
		LiveComposer.Builder.rows_init();
		LiveComposer.Builder.moduleareas_init();

		// TODO: the next function contains AJAX call. It needs optimization.
		dslc_generate_code();

		/**
		 * Re-init drag and drop from modules list into modules areas.
		 * Need this function, so we can drop new modules on the cloned areas.
		 */
		dslc_drag_and_drop();

		// Remove "dslca-module-being-edited" class form any element
		jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');

		// Show back new created module
		dslc_module.animate({
			opacity : 1
		}, 300);

		dslc_show_publish_button();
	});

	// Generate new ID for the new section.
	dslc_section_new_id( dslcModulesSectionCloned[0] );
}

/**
 * Generate new ID for the section provided
 *
 *
 * @param DOM section that needs ID updated (new ID).
 * @return void
 */
function dslc_section_new_id( section ) {

	if ( dslcDebug ) console.log( 'dslc_section_new_id' );

	var dslc_section_id = LiveComposer.Utils.get_unique_id(); // Generate new section ID.

	// Update section ID in data attribute
	section.setAttribute( 'data-section-id', dslc_section_id );

	// Update section ID in raw base64 code (dslc_code) of the section
	LiveComposer.Utils.update_section_property_raw( section, 'section_instance_id', dslc_section_id );
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
			jQuery('#dslc-main', LiveComposer.Builder.PreviewAreaDocument).append( response.output );

			// Call other functions
			LiveComposer.Builder.PreviewAreaWindow.dslc_bg_video();
			LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
			LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();

			// Check init for rows and module areas
			LiveComposer.Builder.rows_init();
			LiveComposer.Builder.moduleareas_init();

			dslc_drag_and_drop();
			dslc_generate_code();

			dslc_show_publish_button();
		}
	);
}

/**
 * Deprecated Functions and Fallbacks
 */

function dslc_add_modules_section() { dslc_row_add(); }
function dslc_delete_modules_section( row  ) { dslc_row_delete( row ); }
function dslc_edit_modules_section( row ) { dslc_row_edit( row ); }
function dslc_copy_modules_section( row ) { dslc_row_copy( row ); }
function dslc_import_modules_section( rowCode ) { dslc_row_import( rowCode ); }

/**
 * Row - Document Ready Actions
 */

jQuery(document).ready(function($){

	/**
	 * Hook - Confirm Row Changes
	 */
	$(document).on( 'click', '.dslca-row-edit-save', function(){

		dslc_row_edit_confirm();

		$(".dslca-currently-editing").removeAttr('style');
		$('.dslca-row-options-filter-hook.dslca-active').removeClass('dslca-active');
		LiveComposer.Builder.PreviewAreaWindow.dslc_responsive_classes( true );
	});

	/**
	 * Hook - Cancel Row Changes
	 */
	$(document).on( 'click', '.dslca-row-edit-cancel', function(){

		dslc_row_edit_cancel();

		$(".dslca-currently-editing").removeAttr('style');
		$('.dslca-row-options-filter-hook.dslca-active').removeClass('dslca-active');
		LiveComposer.Builder.PreviewAreaWindow.dslc_responsive_classes( true );
	});
});

/**
 * Check ROWs initialization
 *
 * @return void
 */
LiveComposer.Builder.rows_init = function() {

	// Select all the ROWs form the main section of the page
	jQuery( '#dslc-main .dslc-modules-section', LiveComposer.Builder.PreviewAreaDocument ).each( function() {

		// Check if all the rows have data attribute 'jsinit' set to 'initialized'?
		if ( jQuery( this ).data('jsinit') !== 'initialized' ) {

			// Initialize all the rows without 'jsinit' attribute!
			new LiveComposer.Builder.Elements.CRow( this );
		}
	} );

}
