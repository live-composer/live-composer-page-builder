/**
 *  Builder module functions & hooks
 *
 *   = MODULES =
 *
 * - dslc_module_delete ( Deletes a module )
 * - dslc_module_copy ( Copies a module )
 * - dslc_module_width_set ( Sets a width to module )
 * - dslc_module_options_show ( Show module options )
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
 *
 */

'use strict';

;jQuery(document).on('editorFrameLoaded', function(){

	var $ = jQuery;

	/**
	 * Hook - Copy Module
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-copy-module-hook', function(e){

		e.preventDefault();

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			dslc_module_copy( $(this).closest('.dslc-module-front') );
		}
	});

	/**
	 * Hook - Module Delete
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-delete-module-hook', function(e){

		e.preventDefault();
		var self = this;

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			DSLC.Editor.CModalWindow({
				title: DSLCString.str_del_module_title,
				content: DSLCString.str_del_module_descr,
				confirm: function() {

					var module = jQuery(self).closest('.dslc-module-front');
					dslc_delete_module( module );
				}
			});

			/*dslc_js_confirm( 'delete_module', '<span class="dslca-prompt-modal-title">' +
				DSLCString.str_del_module_title +
				'</span><span class="dslca-prompt-modal-descr">' +
				DSLCString.str_del_module_descr + '</span>', $(this) );*/
		}
	});

	/**
	 * Hook - Edit Module On Click ( Display Options Panel )
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-module-edit-hook, .dslc-module-front > div:not(.dslca-module-manage)', function(e){

		e.preventDefault();
		var module_edited = jQuery('.dslca-module-being-edited', DSLC.Editor.frame).length;
		var row_edited = jQuery('.dslca-modules-section-being-edited', DSLC.Editor.frame).length;

		/// If settings panel opened - finish func
		if ( $('body').hasClass( 'dslca-composer-hidden' ) || module_edited > 0 || row_edited > 0 ) return false;


		if(dslcDebug) console.log('dslca-module-edit-hook');

		// Vars
		var dslcModule = $(this).closest('.dslc-module-front'),
		dslcModuleID = dslcModule.data('dslc-module-id');
		// dslcModuleCurrCode = dslcModule.find('.dslca-module-code').val();

		// If a module is bening edited remove the "being edited" class from it
		$('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited');

		// Add the "being edited" class to current module
		dslcModule.addClass('dslca-module-being-edited');

		// Call the function to display options
		dslc_module_options_show( dslcModuleID );

	});

	/**
	 * Action - Show/Hide Width Options
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-change-width-module-hook', function(e){

		e.preventDefault();

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			$('.dslca-change-width-module-options', this).toggle();
			$(this).closest('.dslca-module-manage').toggleClass('dslca-module-manage-change-width-active');
		}
	});

	/**
	 * Hook - Set Module Width
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-change-width-module-options span', function(){

		dslc_module_width_set( jQuery(this).closest('.dslc-module-front'), jQuery(this).data('size') );
	});

	/**
	 * Show WYSIWYG
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-wysiwyg-actions-edit-hook', function(){

		var editable = jQuery(this).parent().siblings('.dslca-editable-content');
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

		if ( typeof tinymce != "undefined" ) {

			var editor = tinymce.get( 'dslcawpeditor' );

			if ( jQuery('#wp-dslcawpeditor-wrap').hasClass('tmce-active') ) {

				editor.setContent( content, {format : 'html'} );
			} else {

				jQuery('textarea#dslcawpeditor').val( content );
			}

			if ( ! module.hasClass('dslca-module-being-edited') ) {

				module.find('.dslca-module-edit-hook').trigger('click');
			}

			jQuery('.dslca-wp-editor').show();
			editable.addClass('dslca-wysiwyg-active');

			jQuery('#dslcawpeditor_ifr, #dslcawpeditor').css({ height : jQuery('.dslca-wp-editor').height() - 300 });

		} else {
			console.info( 'Live Composer: TinyMCE is undefined.' );
		}
	});

	// Editable Content
	DSLC.Editor.frame.on('blur', '.dslca-editable-content', function() {

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

		if ( ! jQuery(this).closest('.dslc-module-front').hasClass('dslca-module-being-edited') ) {

			jQuery(this).trigger('blur');
		}
	}).on('keyup', '.dslca-editable-content', function(){

		if ( jQuery(this).data('type') == 'simple' ){

			jQuery(this).closest('.dslc-module-front').addClass('dslca-module-change-made');
		}
	});
});

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

	// AJAX request new module ID
	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-get-new-module-id',
		},
		function( response ) {

			// Remove being edited class if some module is being edited
			jQuery('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited');

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

				// Once module has been redrawn > run the code below:

				// Fade in the module
				jQuery('.dslca-module-being-edited', DSLC.Editor.frame).css({ opacity : 0 }).removeClass('dslca-module-being-edited').animate({ opacity : 1 }, 300);

				dslc_generate_code(); // Need to call this function to update last column class for the modules.
				dslc_show_publish_button();
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
		.data('dslc-module-size', newWidth);
		//.addClass('dslca-module-being-edited'); – Deprecated

	// Change the module size attribute
	jQuery( '.dslca-module-option-front[data-id="dslc_m_size"]', module ).val( newWidth );

	// Get module raw code
	var module_code = module.find('.dslca-module-code').val();

 	// Decode
	module_code = DSLC_Util.decode( module_code );

	// Change size property
	module_code.dslc_m_size = newWidth;

	// Encode
	module_code = DSLC_Util.encode( module_code );

	// Update raw code
	module.find('.dslca-module-code').val(module_code);

	// Preview Change – DEPRECATED
	/*
	dslc_module_output_altered( function(){

		jQuery('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited');
	});
	*/

	dslc_generate_code();

	dslc_show_publish_button();
}

/**
 * MODULES - Show module options
 */
function dslc_module_options_show( moduleID ) {

	if ( dslcDebug ) console.log( 'dslc_module_options_show' );

	// Vars
	var dslcModule = jQuery('.dslca-module-being-edited', DSLC.Editor.frame),
	dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
	dslcDefaultSection = jQuery('.dslca-header').data('default-section');

	// Settings array for the Ajax call
	var dslcSettings = {};
	dslcSettings['action'] = 'dslc-ajax-display-module-options';
	dslcSettings['dslc'] = 'active';
	dslcSettings['dslc_module_id'] = moduleID;
	dslcSettings['dslc_post_id'] = jQuery('.dslca-container').data('data-post-id');
	dslcSettings.dslc_url_vars = DSLC_Util.get_page_params();

	// Go through each option to fill dslcSettings array
	// with current module setting values
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
			dslc_hide_publish_button();

			// Show edit section
			dslc_show_section('.dslca-module-edit');

			// Add the options
			if ( ! jQuery('body').hasClass('rtl') ) {

				jQuery('.dslca-module-edit-options-inner').html( response.output );
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

			DSLC.Editor.initMediumEditor();
			DSLC.Editor.loadOptionsDeps();

			// Set up backup
			var moduleBackup = jQuery('.dslca-module-options-front', dslcModule).children().clone();
			DSLC.Editor.moduleBackup = moduleBackup;
		}
	);
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
			dslc_post_id : jQuery('.dslca-container').data('post-id'),
			dslc_url_vars: DSLC_Util.get_page_params()
		},
		function( response ) {

			callback(response);
		}
	);
}

/**
 * MODULES - Redraw module output when settings altered
 */
function dslc_module_output_altered( callback ) {

	if ( dslcDebug ) console.log( 'dslc_module_output_altered' );

	callback = typeof callback !== 'undefined' ? callback : false;

	var dslcModule = jQuery('.dslca-module-being-edited', DSLC.Editor.frame),
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

	dslcSettings.dslc_url_vars = DSLC_Util.get_page_params();

	/**
	 * Call AJAX for preview
	 */
	jQuery.post(

		DSLCAjax.ajaxurl, dslcSettings,
		function( response ) {

			DSLC.Editor.clearUtils();

			// Insert 'updated' module output after module we are editing.
			dslcModule.after(response.output).next().addClass('dslca-module-being-edited');

			// Delete 'old' instance of the module we are editing.
			dslcModule.remove();

			// TODO: Add new postponed action to run after all done

			// dslc_generate_code();
			// dslc_show_publish_button();
			DSLC.Editor.frameContext.dslc_carousel();
			DSLC.Editor.frameContext.dslc_masonry( jQuery('.dslca-module-being-edited', DSLC.Editor.frame) );

			jQuery( '.dslca-module-being-edited img' , DSLC.Editor.frame).load( function(){

				DSLC.Editor.frameContext.dslc_masonry( jQuery('.dslca-module-being-edited', DSLC.Editor.frame) );
			});

			DSLC.Editor.frameContext.dslc_tabs();
			DSLC.Editor.frameContext.dslc_init_accordion();

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

			DSLC.Editor.frameContext.dslc_carousel();
			DSLC.Editor.frameContext.dslc_masonry( jQuery('.dslca-module-being-edited', DSLC.Editor.frame) );

			jQuery( '.dslca-module-being-edited img' , DSLC.Editor.frame).load( function(){
				DSLC.Editor.frameContext.dslc_masonry( jQuery('.dslca-module-being-edited', DSLC.Editor.frame) );
			});

			DSLC.Editor.frameContext.dslc_tabs();
			DSLC.Editor.frameContext.dslc_init_accordion();

			if ( callback ) {

				callback( response );
			}

			jQuery('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited');
		}
	);
}

/**
 * Deprecated Functions and Fallbacks
 */

function dslc_delete_module( module ) { dslc_module_delete( module ); }
function dslc_copy_module( module ) { dslc_module_copy( module ); }
function dslc_display_module_options( moduleID ) { dslc_module_options_show( moduleID ); }
function dslc_get_module_output( moduleID, callback ) { dslc_module_output_default( moduleID, callback ); }
function dslc_preview_change( callback ) { dslc_module_output_altered( callback ); }
function dslc_reload_module( moduleID, callback ) { dslc_module_output_reload( moduleID, callback ); }