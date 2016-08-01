
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


;jQuery(document).on('editorFrameLoaded', function(){

	var $ = jQuery;

	jQuery(".dslc-modules-section", DSLC.Editor.frame).each(function(){
		new DSLC.Editor.CRow(this);
	});

	/**
	 * Hook - Delete Row
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-delete-modules-section-hook', function(e){

		e.preventDefault();
		var self = this;

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			DSLC.Editor.CModalWindow({
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
	DSLC.Editor.frame.on( 'click', '.dslca-import-modules-section-hook', function(e) {

		e.preventDefault();

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

			DSLC.Editor.CModalWindow({
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
	DSLC.Editor.frame.on( 'click', '.dslca-export-modules-section-hook', function(e) {

		e.preventDefault();

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			$('.dslca-prompt-modal-cancel-hook').hide();
			$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>' + DSLCString.str_ok);

			dslc_js_confirm( 'export_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_export_row_title +
				'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_export_row_descr + ' <br><br><textarea></textarea></span>', $(this) );
			$('.dslca-prompt-modal textarea').val( dslc_generate_section_code( $(this).closest('.dslc-modules-section') ) );
		}
	});

	/**
	 * Hook - Copy Row
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-copy-modules-section-hook', function() {

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

			dslc_row_copy( jQuery(this).closest('.dslc-modules-section') );
		}
	});

	/**
	 * Hook - Add Row
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-add-modules-section-hook', function(){

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
	DSLC.Editor.frame.on( 'click', '.dslca-edit-modules-section-hook', function(){

		var self = this;

		var module_edited = jQuery('.dslca-module-being-edited', DSLC.Editor.frame).length;
		var row_edited = jQuery('.dslca-modules-section-being-edited', DSLC.Editor.frame).length;

		/// If settings panel opened - finish func
		if ( $('body').hasClass( 'dslca-composer-hidden' ) || module_edited > 0 || row_edited > 0 ) return false;

		// If not disabled ( disabling used for tutorial )
		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			// Trigger the function to edit
			dslc_row_edit( $(this).closest('.dslc-modules-section') );
		}
	});
});

/**
 * Row - Add New
 */
function dslc_row_add( callback ) {

	if ( dslcDebug ) console.log( 'dslc_row_add' );

	callback = typeof callback !== 'undefined' ? callback : false;

	var defer = jQuery.Deferred();

	// AJAX Request
	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-add-modules-section',
			dslc : 'active'
		},
		function( response ) {

			var newRow = jQuery(response.output);

			// Append new row
			newRow.appendTo(DSLC.Editor.frame.find("#dslc-main"));

			// Call other functions
			dslc_drag_and_drop();
			dslc_generate_code();
			dslc_show_publish_button();

			new DSLC.Editor.CRow(newRow);
			new DSLC.Editor.CModuleArea(newRow.find('.dslc-modules-area').eq(0)[0]);

			if ( callback ) { callback(); }

			newRow.find('.dslc-modules-area').addClass('dslc-modules-area-empty dslc-last-col');

			defer.resolve(newRow[0]);
		}
	);

	return defer;
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
	jQuery('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited');
	jQuery('.dslca-modules-section-being-edited', DSLC.Editor.frame).removeClass('dslca-modules-section-being-edited').removeClass('dslca-modules-section-change-made');
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

			if ( '' === jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="type"]', DSLC.Editor.frame).val() ||
				  'wrapped' === jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="type"]', DSLC.Editor.frame).val() ) {
				jQuery('select[data-id="type"]').val('wrapper').change();
			}
		}

		if ( jQuery(this).data('id') == 'border-top' ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]', DSLC.Editor.frame).val().indexOf('top') >= 0 ) {
				jQuery(this).prop('checked', true);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery(this).prop('checked', false);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}

		} else if ( jQuery(this).data('id') == 'border-right' ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]', DSLC.Editor.frame).val().indexOf('right') >= 0 ) {
				jQuery(this).prop('checked', true);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery(this).prop('checked', false);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}

		} else if ( jQuery(this).data('id') == 'border-bottom' ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]', DSLC.Editor.frame).val().indexOf('bottom') >= 0 ) {
				jQuery(this).prop('checked', true);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery(this).prop('checked', false);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}

		} else if ( jQuery(this).data('id') == 'border-left' ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]', DSLC.Editor.frame).val().indexOf('left') >= 0 ) {
				jQuery(this).prop('checked', true);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery(this).prop('checked', false);
				jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}
		} else if ( jQuery(this).hasClass('dslca-modules-section-edit-field-checkbox') ) {

			if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="' + jQuery(this).data('id') + '"]', DSLC.Editor.frame).val().indexOf( jQuery(this).data('val') ) >= 0 ) {
				jQuery( this ).prop('checked', true);
				jQuery( this ).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			} else {
				jQuery( this ).prop('checked', false);
				jQuery( this ).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			}
		} else {

			jQuery(this).val( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="' + jQuery(this).data('id') + '"]', DSLC.Editor.frame ).val() );

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
	DSLC.Editor.flags.generate_code_after_row_changed = false;

	// Recover original data from data-def attribute for each control
	jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input', DSLC.Editor.frame).each(function(){

		jQuery(this).val( jQuery(this).data('def') );

		// Fire change for every ROW control, so it redraw linked CSS properties
		jQuery('.dslca-modules-section-edit-field[data-id="' + jQuery(this).data('id') + '"]').val( jQuery(this).data('def') ).trigger('change');
	});

	DSLC.Editor.flags.generate_code_after_row_changed = true;
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
	jQuery('.dslca-modules-section-being-edited', DSLC.Editor.frame).removeClass('dslca-modules-section-being-edited dslca-modules-section-change-made');

	if ( callback ) { callback(); }

	// Show the publish button
	dslc_show_publish_button;
}

/**
 * Row - Edit - Confirm Changes
 */
function dslc_row_edit_confirm( callback ) {

	if ( dslcDebug ) console.log( 'dslc_confirm_row_changes' );

	callback = typeof callback !== 'undefined' ? callback : false;

	jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input', DSLC.Editor.frame).each(function(){

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
	jQuery('.dslca-modules-section-being-edited', DSLC.Editor.frame).removeClass('dslca-modules-section-being-edited dslca-modules-section-change-made');

	dslc_generate_code();

	// Show the publish button
	dslc_show_publish_button();

	if ( callback ) { callback(); }
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
	dslcModulesSectionCloned = row.clone().appendTo( jQuery('#dslc-main', DSLC.Editor.frame ) );

	// Mark new ROW as NON initialized
	dslcModulesSectionCloned[0].removeAttribute('data-jsinit');

	// Go through each area of the new row and apply correct data-size
	// Mark each module area inside as NON initialized (2)
	dslcModulesSectionCloned.find('.dslc-modules-area').each(function(){
		var dslcIndex = jQuery(this).index();
		jQuery(this).data('size', row.find('.dslc-modules-area:eq( ' + dslcIndex + ' )').data('size') );

		this.removeAttribute('data-jsinit'); // (2)
	});


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
		dslc_module = jQuery(this);

		// Generate new (pseudo) unique ID for the module
		dslc_module_id = DSLC_Util.get_unique_id();

		// Remove "dslca-module-being-edited" class form any element
		jQuery('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited');

		// Update module attributes with new ID
		dslc_module.data( 'module-id', dslc_module_id ).attr( 'id', 'dslc-module-' + dslc_module_id );

		// Add "dslca-module-being-edited" class
		// Class required for dslc_module_output_altered function.
		dslc_module.addClass('dslca-module-being-edited');

		// Add new postponed action to run after ajax is done
		DSLC.Editor.add_postponed_action('dslc_actions_after_row_copy');

		// Redraw module output, remove "being-edited" class and show module
		dslc_module_output_altered( function(){

			jQuery('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited').animate({
				opacity : 1
			}, 300);

			// Ajax is done check-out postponed actions queue
			DSLC.Editor.release_postponed_actions();
		});
	});
}

/**
 * Set of actions to run after row being copied
 * and all the ajax calls completed
 *
 * @return void
 */
function dslc_actions_after_row_copy() {

	if ( dslcDebug ) console.info( 'dslc_after_copy_actions' );

	// Check init for rows and module areas
	DSLC.Editor.rows_init();
	DSLC.Editor.moduleareas_init();

	dslc_generate_code();
	dslc_drag_and_drop();

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
			jQuery('#dslc-main', DSLC.Editor.frame).append( response.output );

			// Call other functions
			DSLC.Editor.frameContext.dslc_bg_video();
			DSLC.Editor.frameContext.dslc_carousel();
			DSLC.Editor.frameContext.dslc_masonry( jQuery('#dslc-main', DSLC.Editor.frame).find('.dslc-modules-section:last-child') );

			// Check init for rows and module areas
			DSLC.Editor.rows_init();
			DSLC.Editor.moduleareas_init();

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
		DSLC.Editor.frameContext.dslc_responsive_classes( true );
	});

	/**
	 * Hook - Cancel Row Changes
	 */
	$(document).on( 'click', '.dslca-row-edit-cancel', function(){

		dslc_row_edit_cancel();

		$(".dslca-currently-editing").removeAttr('style');
		$('.dslca-row-options-filter-hook.dslca-active').removeClass('dslca-active');
		DSLC.Editor.frameContext.dslc_responsive_classes( true );
	});
});

/**
 * Check ROWs initialization
 *
 * @return void
 */
DSLC.Editor.rows_init = function() {

	// Select all the ROWs form the main section of the page
	jQuery( '#dslc-main .dslc-modules-section', DSLC.Editor.frame ).each( function() {

		// Check if all the rows have data attribute 'jsinit' set to 'initialized'?
		if ( jQuery( this ).data('jsinit') !== 'initialized' ) {

			// Initialize all the rows without 'jsinit' attribute!
			new DSLC.Editor.CRow( this );
		}
	} );

}
