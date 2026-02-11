/**
 * Functions powering Module Areas functionality
 *
 * = AREAS ( MODULE AREAS ) =
 *
 * - Actions/Events (Duplicate, Change Width, Delete, ...)
 * - dslc_modules_area_add ( Adds a new modules area )
 * - dslc_modules_area_delete ( Deletes modules area )
 * - dslc_modules_area_width_set ( Sets specific width to the modules area )
 * - dslc_copy_modules_area ( Copies modules area )
 *
 */

import { dragAndDropInit } from './dragndrop.js';
import { addSection } from './sections.js';
import { ModuleArea } from './modulearea.class.js';
import { CModalWindow } from './modalwindow.class.js';
import { hidePublishButton, showSection } from './uigeneral.js';
import { getNewModuleId } from "./module.js";
import { dslc_row_delete } from "./sections.js";
import {dslc_disable_responsive_view } from "./settings.panel.js"


/**
 * Module Area Actions (Duplicate, Change Width, Delete, ...)
 *
 * Attach these actions once the editing iFrame loaded.
 */

export function init_sortables() {
    var el = jQuery('.dslc-modules-area', LiveComposer.Builder.PreviewAreaDocument); // Groups that can hold modules

    jQuery(el).each(function (i, e) {
        new ModuleArea(e);
    });
}

jQuery(document).on('editorFrameLoaded', function(){

	var actionAvail = function() {

		if ( LiveComposer.Builder.Flags.panelOpened ) {

			LiveComposer.Builder.UI.shakePanelConfirmButton();
			return false;
		}

		return true;
	}

	/**
	 * Action - Automatically Add a Row if Empty
	 */
	if ( ! jQuery( '#dslc-main .dslc-modules-section', LiveComposer.Builder.PreviewAreaDocument).length && ! jQuery( '#dslca-tut-page', LiveComposer.Builder.PreviewAreaDocument).length ) {

		addSection( init_sortables() );
		LiveComposer.Builder.History.unlock();
		parent.LiveComposer.Builder.Actions.saveState();
	} else {

		init_sortables();
		LiveComposer.Builder.History.unlock();
		parent.LiveComposer.Builder.Actions.saveState();
	}
	/**
	 * Start: Module area edit options logic
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-edit-modules-area-hook', function(){

        // Check if action can be fired
        if ( !actionAvail() ) return false;

        var self = this;

        var module_edited = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).length;
        var row_edited = jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).length;

        /// If settings panel opened - finish func
        if ( LiveComposer.Builder.Flags.uiHidden || module_edited > 0 || row_edited > 0 ) return false;

        // If not disabled ( disabling used for tutorial )
        if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

            // Trigger the function to edit
            dslc_modules_area_edit( jQuery(this).closest('.dslc-modules-area') );
        }

        jQuery('body', LiveComposer.Builder.PreviewAreaDocument).addClass('modules-area-editing-in-progress');
    });
	
	/**
	 * Modules Area - Edit
	 */
	function dslc_modules_area_edit( modules_area ) {
	
		if ( window.dslcDebug ) console.log( 'dslc_modules_area_edit' );
	
		// Vars we will use
		var dslcModulesAreaOpts, dslcVal;
	
		// Set editing class
		jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');
		jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-modules-section-being-edited');
		jQuery('.dslca-modules-area-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-modules-area-being-edited').removeClass('dslca-modules-area-change-made');
		modules_area.addClass('dslca-modules-area-being-edited');
	
		// Hide the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').hide();
	
		// Show the styling/responsive tabs
		jQuery('.dslca-modules-area-options-filter-hook[data-section="functionality"], .dslca-modules-area-options-filter-hook[data-section="styling"], .dslca-modules-area-options-filter-hook[data-section="responsive"]').show();
		jQuery('.dslca-modules-area-options-filter-hook[data-section="functionality"]').trigger('click');
	
		// Hide the filter hooks
		jQuery('.dslca-header .dslca-options-filter-hook').hide();
	
		// Hide the save/cancel actions
		jQuery('.dslca-module-edit-actions').hide();
	
		// Hide the save/cancel actions
		jQuery('.dslca-row-edit-actions').hide();

		// show the save/cancel actions
		jQuery('.dslca-modules-area-edit-actions').show();
		
		// i will update later 
		// Set current values
		jQuery('.dslca-modules-area-edit-field').each(function(){

			if ( jQuery(this).data('id') == 'border-top' ) {
	
				if ( jQuery('.dslca-modules-area-being-edited .dslca-modules-area-settings input[data-id="border"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf('top') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}
	
			} else if ( jQuery(this).data('id') == 'border-right' ) {
	
				if ( jQuery('.dslca-modules-area-being-edited .dslca-modules-area-settings input[data-id="border"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf('right') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}
	
			} else if ( jQuery(this).data('id') == 'border-bottom' ) {
	
				if ( jQuery('.dslca-modules-area-being-edited .dslca-modules-area-settings input[data-id="border"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf('bottom') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}
	
			} else if ( jQuery(this).data('id') == 'border-left' ) {
	
				if ( jQuery('.dslca-modules-area-being-edited .dslca-modules-area-settings input[data-id="border"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf('left') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}
			} else if ( jQuery(this).hasClass('dslca-modules-area-edit-field-checkbox') ) {
	
				if ( jQuery('.dslca-modules-area-being-edited .dslca-modules-area-settings input[data-id="' + jQuery(this).data('id') + '"]', LiveComposer.Builder.PreviewAreaDocument).val().indexOf( jQuery(this).data('val') ) >= 0 ) {
					jQuery( this ).prop('checked', true);
					jQuery( this ).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery( this ).prop('checked', false);
					jQuery( this ).siblings('.dslca-modules-area-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}
			} else {				
			jQuery( this ).val( jQuery('.dslca-modules-area-being-edited .dslca-modules-area-settings input[data-id="' + jQuery( this ).data('id') + '"]', LiveComposer.Builder.PreviewAreaDocument ).val().trim().replace('%(%', '[').replace('%)%', ']') );
			}
		});
	
		jQuery('.dslca-modules-area-edit-field-upload').each(function(){
	
			var dslcParent = jQuery(this).closest('.dslca-modules-area-edit-option');
	
			if ( jQuery(this).val() && jQuery(this).val() !== 'disabled' ) {
	
				jQuery('.dslca-modules-area-edit-field-image-add-hook', dslcParent ).hide();
				jQuery('.dslca-modules-area-edit-field-image-remove-hook', dslcParent ).show();
			} else {
	
				jQuery('.dslca-modules-area-edit-field-image-remove-hook', dslcParent ).hide();
				jQuery('.dslca-modules-area-edit-field-image-add-hook', dslcParent ).show();
			}
		});
	
		// Show options management
		showSection('.dslca-modules-area-edit');
	
		LiveComposer.Builder.Flags.panelOpened = true;
	
		// Hide the publish button
		LiveComposer.Builder.History.lock();
		hidePublishButton();
	}

	/**
     * Hook - Confirm Module Area Changes
     */
    jQuery(document).on( 'click', '.dslca-modules-area-edit-save', function(){

        dslc_modules_area_edit_confirm();

        jQuery(".dslca-currently-editing").removeAttr('style');
        jQuery('.dslca-modules-area-options-filter-hook.dslca-active').removeClass('dslca-active');
        LiveComposer.Builder.PreviewAreaWindow.dslc_responsive_classes( true );
		dslc_disable_responsive_view();
    });

    /**
     * Hook - Cancel Module Area Changes
     */
    jQuery(document).on( 'click', '.dslca-modules-area-edit-cancel', function(){

        dslc_modules_area_edit_cancel();

        jQuery(".dslca-currently-editing").removeAttr('style');
        jQuery('.dslca-modules-area-options-filter-hook.dslca-active').removeClass('dslca-active');
        LiveComposer.Builder.PreviewAreaWindow.dslc_responsive_classes( true );
		dslc_disable_responsive_view();
    });

	/**
	 * Modules Area - Edit - Confirm Changes
	 */
	function dslc_modules_area_edit_confirm( callback ) {

		if ( window.dslcDebug ) console.log( 'dslc_confirm_modules_area_changes' );

		callback = typeof callback !== 'undefined' ? callback : false;

		jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input', LiveComposer.Builder.PreviewAreaDocument).each(function(){

			jQuery(this).data( 'def', jQuery(this).val() );
		});

		showSection('.dslca-modules');

		// Hide the save/cancel actions
		jQuery('.dslca-modules-area-edit-actions').hide();

		// Hide the styling/responsive tabs
		jQuery('.dslca-modules-area-options-filter-hook').hide();    

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Remove being edited class
		jQuery('.dslca-modules-area-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-modules-area-being-edited dslca-modules-area-change-made');
		// need to add functionality to generate modules area section code in dslc_generate_code()
		window.dslc_generate_code();

		// Show the publish button
		window.dslc_show_publish_button();
		LiveComposer.Builder.History.unlock();
		parent.LiveComposer.Builder.Actions.saveState();

		if ( callback ) { callback(); }

		LiveComposer.Builder.Flags.panelOpened = false;
		jQuery("body", LiveComposer.Builder.PreviewAreaDocument).removeClass('modules-area-editing-in-progress');
	}
	/**
	 * Modules Area - Edit - Cancel Changes
	 */
	function dslc_modules_area_edit_cancel( callback ) {

		if ( window.dslcDebug ) console.log( 'dslc_modules_area_cancel_changes' );

		callback = typeof callback !== 'undefined' ? callback : false;

		// Time to generate code optimized {HACK}
		LiveComposer.Builder.Flags.generate_code_after_modules_area_changed = false;

		// Recover original data from data-def attribute for each control
		jQuery('.dslca-modules-area-being-edited .dslca-modules-area-settings input', LiveComposer.Builder.PreviewAreaDocument).each(function(){

			jQuery(this).val( jQuery(this).data('def') );

			// Fire change for every ROW control, so it redraw linked CSS properties
			jQuery('.dslca-modules-area-edit-field[data-id="' + jQuery(this).data('id') + '"]').val( jQuery(this).data('def') ).trigger('change');
		});

		LiveComposer.Builder.Flags.generate_code_after_modules_area_changed = true;
		window.dslc_generate_code();
		LiveComposer.Builder.History.unlock();
		window.dslc_show_publish_button();

		showSection('.dslca-modules');

		// Hide the save/cancel actions
		jQuery('.dslca-modules-area-edit-actions').hide();

		// Hide the styling/responsive tabs
		jQuery('.dslca-modules-area-options-filter-hook').hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Show the publish button
		dslc_show_publish_button;

		// Remove being edited class
		jQuery('.dslca-modules-area-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-modules-area-being-edited dslca-modules-area-change-made');

		if ( callback ) { callback(); }

		LiveComposer.Builder.Flags.panelOpened = false;
		jQuery("body", LiveComposer.Builder.PreviewAreaDocument).removeClass('modules-area-editing-in-progress');

	}
	/**
	 * End: Module area edit options logic
	 */

	/**
	 * Hook - Copy Module Area
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-copy-modules-area-hook', function(e){

		e.preventDefault();

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

			var modulesArea = jQuery(this).closest('.dslc-modules-area');
			dslc_copy_modules_area( modulesArea );
		}
	});

	/**
	 * Hook - Delete Module Area
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-delete-modules-area-hook', function(e){

		e.preventDefault();

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {

			// Check if current modules area is empty.
			var modulesAreaEmpty = jQuery(this).closest('.dslc-modules-area').hasClass('dslc-modules-area-empty');

			if ( ! modulesAreaEmpty ) {

				var self = jQuery(this);

				CModalWindow({

					title: DSLCString.str_del_area_title,
					content: DSLCString.str_del_area_descr,
					confirm: function() {

						var modulesArea = self.closest('.dslc-modules-area');
						dslc_modules_area_delete( modulesArea );
					}
				});

				// Show confirmation modal only if the module area isn't empty.
				/*dslc_js_confirm( 'delete_modules_area', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_area_title +
					'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_area_descr + '</span>', jQuery(this) );*/
			} else {

				var modulesArea = jQuery(this).closest('.dslc-modules-area');
				// Delete module area without asking anything.
				dslc_delete_modules_area( modulesArea );
			}
		}
	});

	/**
	 * Hook - Set Width of the Module Area
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-change-width-modules-area-options span', function(){
		// Check if action can be fired
		if ( !actionAvail() ) return false;

		if ( ! jQuery(this).hasClass('dslca-action-disabled') ) {
			var moduleAreaJQ = jQuery(this).closest('.dslc-modules-area');
			var oldSize = moduleAreaJQ.data('size');
			var newSize = jQuery(this).data('size');

			// Start expensive function only if the value changed.
			if (  Number(oldSize) !== Number(newSize) ) {
				dslc_modules_area_width_set( moduleAreaJQ, newSize );
			}
		}
	});

	/**
	 * Hook - Add Modules Area
	 * TODO: Where we use it? Delete maybe?
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-add-modules-area-hook', function(e){
		e.preventDefault();

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		modulesAreaAdd( jQuery(this).closest('.dslc-modules-section').find('.dslc-modules-section-inner') );
	});

});

/**
 * AREAS - Add New
 */

// ex. dslc_modules_area_add
export const modulesAreaAdd = ( row, callback = false ) => {

	if ( window.dslcDebug ) console.log( 'modulesAreaAdd' );

	const defer = jQuery.Deferred();
	const browserCacheTmp = sessionStorage;
	const cacheKey = 'cache-dslc-ajax-add-modules-area-v1';

	let cachedAjaxRequest = browserCacheTmp.getItem( cacheKey );

	// Current post ID (same logic as sections)
	const currentPostId =
		typeof dslca_post_id !== 'undefined' ? dslca_post_id : 0;

	/**
	 * USE CACHE
	 */
	if ( cachedAjaxRequest ) {

		dslc_modules_area_render( cachedAjaxRequest, row );

		if ( callback ) callback();
		defer.resolve();
		return defer;
	}

	/**
	 * AJAX REQUEST (same architecture as addSection)
	 */
	jQuery.post(
		DSLCAjax.ajaxurl,
		{
			action   : 'dslc-ajax-add-modules-area',
			_wpnonce : DSLCAjax._wpnonce,
			dslc     : 'active',
			post_id  : currentPostId
		},
		function ( response ) {

			if ( response && response.output ) {

				// Cache canonical PHP output
				browserCacheTmp.setItem(
					cacheKey,
					response.output
				);

				dslc_modules_area_render( response.output, row );
			}

			if ( callback ) callback();
			defer.resolve();
		}
	);

	return defer;
};

// render modules area

function dslc_modules_area_render( html, row ) {

	const $area = jQuery( html )
		.appendTo( row )
		.css({ height: 0 })
		.animate({ height: 99 }, 300, function () {
			jQuery(this).css({ height: 'auto' });
		})
		.addClass('dslca-init-animation');

	// Init newly added module area
	jQuery('.dslc-modules-area', $area).each(function () {
		new ModuleArea(this);
	});

	dragAndDropInit();
	window.dslc_generate_code();
	window.dslc_show_publish_button();
	LiveComposer.Builder.History.unlock();
	parent.LiveComposer.Builder.Actions.saveState();

	return $area;
}

/**
 * AREAS - Delete
 */

function dslc_modules_area_delete( area ) {

	if ( window.dslcDebug ) console.log( 'dslc_delete_modules_area' );

	// Vars
	var modulesSection = area.closest('.dslc-modules-section').find('.dslc-modules-section-inner'),
	dslcDeleteSectionToo = false;

	// Add a class to the area so we know it's being deleted
	area.addClass('dslca-modules-area-being-deleted');

	// If it's the last area in the row delete section as well
	if ( modulesSection.find('.dslc-modules-area').length < 2 ) {
		dslcDeleteSectionToo = true;
	}

	// If a module in the area is being edited
	if ( area.find('.dslca-module-being-edited').length ) {

		// Hide the filter hooks
		jQuery('.dslca-header .dslca-options-filter-hook', LiveComposer.Builder.PreviewAreaDocument).hide();

		// Hide the save/cancel actions
		jQuery('.dslca-module-edit-actions', LiveComposer.Builder.PreviewAreaDocument).hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook', LiveComposer.Builder.PreviewAreaDocument).show();

		// Show the modules listing
		// showSection('.dslca-modules');

	}

	// Set a timeout so we handle deletion after animation ends
	setTimeout( function(){

		// Delete section if no more module areas inside.
		if ( dslcDeleteSectionToo ) {

			var parentSectionContainer = area.closest('.dslc-modules-section-inner');
			// modulesAreaAdd( modulesSection );

			// Don't delete latest module area in the latest section on the page
			if (2 <= area.closest('#dslc-main').find('.dslc-modules-section').length ) {

				dslc_row_delete( area.closest('.dslc-modules-section') );
			} else {

				// Remove the area
				area.remove();
				// Create new empty area in current module section
				modulesAreaAdd( modulesSection );
			}
		}

		// Remove the area
		area.remove();

		// Call other functions
		window.dslc_generate_code();
		window.dslc_show_publish_button();
		LiveComposer.Builder.History.unlock();
		parent.LiveComposer.Builder.Actions.saveState();
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
		window.dslc_generate_code();
		window.dslc_show_publish_button();
		LiveComposer.Builder.History.unlock();
		parent.LiveComposer.Builder.Actions.saveState();
	});
}

/**
 * AREAS - Copy
 */

function dslc_modules_area_copy( area ) {

	if ( window.dslcDebug ) console.log( 'dslc_copy_modules_area' );

	// Vars
	var dslc_moduleID,
	modulesSection = area.closest('.dslc-modules-section').find('.dslc-modules-section-inner');

	// Copy the area and append to the row
	var dslc_modulesAreaCloned = area.clone().appendTo(modulesSection);

	new ModuleArea(dslc_modulesAreaCloned[0]);

	// Trigger mouseleave ( so the actions that show on hover go away )
	dslc_modulesAreaCloned.find('.dslca-modules-area-manage').trigger('mouseleave');

	// Apply correct data size and get rid of animations
	dslc_modulesAreaCloned.data('size', area.data('size') ).find('.dslc-module-front').css({
		'-webkit-animation-name' : 'none',
		'-moz-animation-name' : 'none',
		'animation-name' : 'none',
		'animation-duration' : '0',
		'-webkit-animation-duration' : '0',
		opacity : 0

	// Go through each module in the area
	}).each(function(){

		var dslc_module = jQuery(this);

		//Generate new ID for the new module and change it in HTML/CSS of the module.
		getNewModuleId( dslc_module[0] );

		// Remove "dslca-module-being-edited" class form any element
		jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');

		// Need to call this function to update last column class for the modules.
		window.dslc_generate_code();

		// Show back new created module
		dslc_module.animate({
			opacity : 1
		}, 300);

	});

	// Call other functions
	dragAndDropInit();
	dslc_modules_area_new_id( dslc_modulesAreaCloned[0] );
	window.dslc_show_publish_button();
	LiveComposer.Builder.History.unlock();
	parent.LiveComposer.Builder.Actions.saveState();

	// Need to call this function to update last column class for the module areas.
	window.dslc_generate_code();

}

/**
 * Generate new ID for the modules area provided
 *
 *
 * @param DOM modules area that needs ID updated (new ID).
 * @return void
 */
function dslc_modules_area_new_id( modules_area ) {

    if ( window.dslcDebug ) console.log( 'dslc_modules_area_new_id' );

    var dslc_modules_area_id = LiveComposer.Utils.get_unique_id(); // Generate new modules area ID.

    // Update modules area ID in data attribute
    modules_area.setAttribute( 'data-modules-area-id', dslc_modules_area_id );

    // Update modules area ID in raw base64 code (dslc_code) of the modules area
    LiveComposer.Utils.update_modules_area_property_raw( modules_area, 'modules_area_instance_id', dslc_modules_area_id );
}

/**
 * AREAS - Set Width
 */
function dslc_modules_area_width_set( area, newWidth ) {

	if ( window.dslcDebug ) console.log( 'dslc_modules_area_width_set' );

	// Generate new class based on width
	var newClass = 'dslc-' + newWidth + '-col';

	// Remove width classes, add new width class and set the data-size attr
	area
		.removeClass('dslc-1-col dslc-2-col dslc-3-col dslc-4-col dslc-5-col dslc-6-col dslc-7-col dslc-8-col dslc-9-col dslc-10-col dslc-11-col dslc-12-col')
		.addClass(newClass)
		.data('size', newWidth);

	// Call other functions
	LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();

	if ( LiveComposer.Builder.Flags.panelOpened ) {
		return false;
	}

	window.dslc_generate_code();
	window.dslc_show_publish_button();
	LiveComposer.Builder.History.unlock();
	parent.LiveComposer.Builder.Actions.saveState();

}

/**
 * Check Module Areas initialization
 *
 * @return void
 */
export const moduleareasInitJS = () => {

	// Select all the module areas form the main section of the page
	jQuery( '#dslc-main .dslc-modules-area', LiveComposer.Builder.PreviewAreaDocument ).each( function() {

		// Check if all the module areas have data attribute 'jsinit' set to 'initialized'?
		if ( jQuery( this ).data('jsinit') !== 'initialized' ) {

			// Initialize all the module areas without 'jsinit' attribute!
			new ModuleArea( this );
		}
	} );

}

/**
 * Deprecated Functions and Fallbacks
 */
function dslc_delete_modules_area( area ) { dslc_modules_area_delete( area ); }
function dslc_copy_modules_area( area ) { dslc_modules_area_copy( area ); }
