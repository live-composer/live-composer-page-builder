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

	var actionAvail = function() {

		if ( LiveComposer.Builder.Flags.panelOpened ) {

			LiveComposer.Builder.UI.shakePanelConfirmButton();
			return false;
		}

		return true;
	}

	/**
	 * Hook - Copy Module
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-copy-module-hook', function(e){

		e.preventDefault();

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			dslc_module_copy( $(this).closest('.dslc-module-front') );
		}
	});

	/**
	 * Hook - Module Delete
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-delete-module-hook', function(e){

		e.preventDefault();

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		var self = this;

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			LiveComposer.Builder.UI.CModalWindow({
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
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-module-edit-hook, .dslc-module-front > div:not(.dslca-module-manage)', function(e){

		if(dslcDebug) console.log('dslca-module-edit-hook');

		e.preventDefault();

		var module_edited = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).length;
		var row_edited = jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).length;

		/// If settings panel opened - finish func
		if ( $('body').hasClass( 'dslca-composer-hidden' ) || module_edited > 0 || row_edited > 0 ) {

			if ( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument)[0] != jQuery(this).closest('.dslc-module-front')[0] ) {

				LiveComposer.Builder.UI.shakePanelConfirmButton();
			}

			return false;
		}

		// Vars
		var dslcModule = $(this).closest('.dslc-module-front'),
		dslc_module_id = dslcModule.data('dslc-module-id');
		// dslcModuleCurrCode = dslcModule.find('.dslca-module-code').val();

		// If a module is bening edited remove the "being edited" class from it
		$('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');

		// Add the "being edited" class to current module
		dslcModule.addClass('dslca-module-being-edited');

		// Call the function to display options
		dslc_module_options_show( dslc_module_id );

		// Cover up other modules with semi transp cover
		jQuery("body", LiveComposer.Builder.PreviewAreaDocument).addClass('module-editing-in-progress');

	});

	/**
	 * Action - Show/Hide Width Options
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-change-width-module-hook', function(e){

		e.preventDefault();

		// Check if action can be fired
		if ( !actionAvail() ) return false;

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			$('.dslca-change-width-module-options', this).toggle();
			$(this).closest('.dslca-module-manage').toggleClass('dslca-module-manage-change-width-active');
		}
	});

	/**
	 * Hook - Set Module Width
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-change-width-module-options span', function(){

		dslc_module_width_set( jQuery(this).closest('.dslc-module-front'), jQuery(this).data('size') );
	});

	/**
	 * Show WYSIWYG
	 */
	LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-wysiwyg-actions-edit-hook', function(){

		var editable = jQuery(this).parent().siblings('.dslca-editable-content');
		var module = editable.closest('.dslc-module-front');

		if ( module.hasClass('dslc-module-handle-like-accordion') ) {

			LiveComposer.Builder.PreviewAreaWindow.dslc_accordion_generate_code( module.find('.dslc-accordion') );
			var full_content = module.find( '.dslca-module-option-front[data-id="accordion_content"]' ).val();
			var full_content_arr = full_content.split('(dslc_sep)');
			var key_value = editable.closest('.dslc-accordion-item').index();
			var content = full_content_arr[key_value].trim().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');

		} else if ( module.hasClass('dslc-module-handle-like-tabs') ) {

			LiveComposer.Builder.PreviewAreaWindow.dslc_tabs_generate_code( module.find('.dslc-tabs') );
			var full_content = module.find( '.dslca-module-option-front[data-id="tabs_content"]' ).val();
			var full_content_arr = full_content.split('(dslc_sep)');
			var key_value = editable.closest('.dslc-tabs-tab-content').index();
			var content = full_content_arr[key_value].trim().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');
		} else {

			var content = module.find( '.dslca-module-option-front[data-id="' + editable.data('id') + '"]' ).val().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');
		}

		if ( typeof tinymce != 'undefined' ) {

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
	LiveComposer.Builder.PreviewAreaDocument.on('blur', '.dslca-editable-content', function() {

		if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' ) && jQuery(this).data('type') == 'simple' ) {

			dslc_editable_content_gen_code( jQuery(this) );
		}
	}).on( 'paste', '.dslca-editable-content:not(.inline-editor)', function(){

		if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' )  && jQuery(this).data('type') == 'simple' ) {

			var dslcRealInput = jQuery(this);

			setTimeout(function(){

				if ( dslcRealInput.data('type') == 'simple' ) {
					dslcRealInput.html( dslcRealInput.text() );
				}

				dslc_editable_content_gen_code( dslcRealInput );
			}, 100);
		}
	}).on('focus', '.dslca-editable-content', function() {

		if ( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).length > 0 && ! jQuery(this).closest('.dslc-module-front').hasClass('dslca-module-being-edited') ) {

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

	// Remove being edited class if some module is being edited
	jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');

	// Duplicate the module and append it to the same area
	var module_new = module[0].cloneNode(true);

	jQuery( module_new ).appendTo( module.closest( '.dslc-modules-area' ) ).css({
		'-webkit-animation-name' : 'none',
		'-moz-animation-name' : 'none',
		'animation-name' : 'none',
		'animation-duration' : '0',
		'-webkit-animation-duration' : '0',
		opacity : 0
	}).addClass('dslca-module-being-edited');

	// Generate new ID for the new module and change it in HTML/CSS of the module.
	dslc_module_new_id( module_new );

	// Module fully cloned. Finish the process.
	// Need to call this function to update last column class for the modules.
	dslc_generate_code();

	// Fade in the module
	jQuery( module_new ).css({ opacity : 0 }).removeClass('dslca-module-being-edited').animate({ opacity : 1 }, 300);

	dslc_show_publish_button();
}

/**
 * Generate new ID for the module provided
 *
 * Search/Replace old module ID with new one in HTML/CSS of the module.
 *
 * @param DOM module Module that needs ID updated (new ID).
 * @return void
 */
function dslc_module_new_id( module ) {

	// Vars
	var dslc_module_id = LiveComposer.Utils.get_unique_id(); // Generate new module ID.
	var dslc_module_id_original = module.getAttribute( 'id' ); // Original Module ID.

	// Update module ID in data attribute
	module.setAttribute( 'data-module-id', dslc_module_id );
	// Update module ID in id attribute of element
	module.setAttribute( 'id', 'dslc-module-' + dslc_module_id );

	/**
	 * Search/Replace module id in the inline CSS
	 */
	var inline_css_el = module.getElementsByTagName( 'style' )[0];
	var inline_css_code = inline_css_el.textContent;
	// Update id attribute for <style> element with new value
	inline_css_el.setAttribute( 'id', '#css-for-dslc-module-' + dslc_module_id );
	// Search/Replace all occurrences of module ID in inline CSS
	inline_css_code = inline_css_code.split( dslc_module_id_original ).join( 'dslc-module-' + dslc_module_id );
	// Put CSS code back into <style> element
	inline_css_el.textContent = inline_css_code;


	// Update module ID in raw base64 code (dslc_code) of the module
	LiveComposer.Utils.update_module_property_raw( module, 'module_instance_id', dslc_module_id );
}

/**
 * MODULES - Set Width
 */
function dslc_module_width_set( module, new_width ) {

	if ( dslcDebug ) console.log( 'dslc_module_width_set' );

	// Generate new column class
	var newClass = 'dslc-' + new_width + '-col';

	// Add new column class and change size "data"
	module
		.removeClass('dslc-1-col dslc-2-col dslc-3-col dslc-4-col dslc-5-col dslc-6-col dslc-7-col dslc-8-col dslc-9-col dslc-10-col dslc-11-col dslc-12-col')
		.addClass(newClass);
		// .data('dslc-module-size', new_width);
		//.addClass('dslca-module-being-edited'); – Deprecated

	// Change module size in element attribute
	module[0].setAttribute('data-dslc-module-size',new_width);

	// Update module size in raw base64 code (dslc_code) of the module
	LiveComposer.Utils.update_module_property_raw( module[0], 'dslc_m_size', new_width );

	dslc_generate_code();
	dslc_show_publish_button();
}

/**
 * MODULES - Show module options
 */
function dslc_module_options_show( moduleID ) {

	if ( dslcDebug ) console.log( 'dslc_module_options_show' );

	// Vars
	var dslcModule = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument),
	dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
	dslcDefaultSection = jQuery('.dslca-header').data('default-section'),
	pseudoPanel = jQuery(jQuery('#pseudo-panel').html());

	jQuery("#wpwrap").append(pseudoPanel);

	// Settings array for the Ajax call
	var dslcSettings = {};
	dslcSettings['action'] = 'dslc-ajax-display-module-options';
	dslcSettings['dslc'] = 'active';
	dslcSettings['dslc_module_id'] = moduleID;
	dslcSettings['dslc_post_id'] = jQuery('.dslca-container').data('data-post-id');
	dslcSettings.dslc_url_vars = LiveComposer.Utils.get_page_params();

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

	// Hide the publish button
	dslc_hide_publish_button();

	LiveComposer.Builder.UI.initInlineEditors();

	// Set up backup
	var moduleBackup = jQuery('.dslca-module-options-front', dslcModule).children().clone();
	LiveComposer.Builder.moduleBackup = moduleBackup;

	LiveComposer.Builder.Flags.panelOpened = true;

	// Show pseudo settings panel
	pseudoPanel.show();
	pseudoPanel.addClass('show');

	// AJAX call to get options HTML
	jQuery.post(
		DSLCAjax.ajaxurl,
		dslcSettings,
		function( response ) {

			// Hide pseudo panel
			pseudoPanel.remove();

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

			LiveComposer.Builder.UI.loadOptionsDeps();
		}
	);
}

/**
 * MODULES - Module output default settings
 */
function dslc_module_output_default( dslc_module_id, callback ) {

	if ( dslcDebug ) console.log( 'dslc_module_output_default' );

	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-add-module',
			dslc : 'active',
			dslc_module_id : dslc_module_id,
			dslc_post_id : jQuery('.dslca-container').data('post-id'),
			dslc_url_vars: LiveComposer.Utils.get_page_params()
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

	var dslcModule = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument),
	dslc_module_id = dslcModule.data('dslc-module-id'),
	dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
	dslcModuleInstanceID = dslcModule.data('module-id');

	/**
	 * Generate code
	 */

	var dslcSettings = {};

	dslcSettings['action'] = 'dslc-ajax-add-module';
	dslcSettings['dslc'] = 'active';
	dslcSettings['dslc_module_id'] = dslc_module_id;
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

	dslcSettings.dslc_url_vars = LiveComposer.Utils.get_page_params();

	/**
	 * Call AJAX for preview
	 */
	jQuery.post(

		DSLCAjax.ajaxurl, dslcSettings,
		function( response ) {

			LiveComposer.Builder.UI.clearUtils();

			var newModule = LiveComposer.
								Builder.
								Helpers.
								insertModule( response.output, dslcModule );

			newModule.addClass('dslca-module-being-edited');

			// TODO: Add new postponed action to run after all done

			dslc_generate_code(); // Do not delete. It refresh classes on "option preview refresh -> true"
			// dslc_show_publish_button();
			LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
			LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();
			//LiveComposer.Builder.PreviewAreaWindow.dslc_masonry( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument) );

			jQuery( '.dslca-module-being-edited img' , LiveComposer.Builder.PreviewAreaDocument).load( function(){

				LiveComposer.Builder.PreviewAreaWindow.dslc_masonry( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument) );
			});

			LiveComposer.Builder.PreviewAreaWindow.dslc_tabs();
			LiveComposer.Builder.PreviewAreaWindow.dslc_init_accordion();

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

	var dslc_module_id = dslcModule.data('dslc-module-id'),
	dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
	dslcModuleInstanceID = dslcModule.data('module-id');

	/**
	 * Generate code
	 */

	var dslcSettings = {};

	dslcSettings['action'] = 'dslc-ajax-add-module';
	dslcSettings['dslc'] = 'active';
	dslcSettings['dslc_module_id'] = dslc_module_id;
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

			LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
			LiveComposer.Builder.PreviewAreaWindow.dslc_masonry( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument) );

			jQuery( '.dslca-module-being-edited img' , LiveComposer.Builder.PreviewAreaDocument).load( function(){
				LiveComposer.Builder.PreviewAreaWindow.dslc_masonry( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument) );
			});

			LiveComposer.Builder.PreviewAreaWindow.dslc_tabs();
			LiveComposer.Builder.PreviewAreaWindow.dslc_init_accordion();

			if ( callback ) {

				callback( response );
			}

			jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');
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