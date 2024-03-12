/**
 *  Builder module functions & hooks
 *
 *   = MODULES =
 *
 * - dslc_module_delete ( Deletes a module )
 * - moduleDuplicate ( Copies a module )
 * - dslc_module_width_set ( Sets a width to module )
 * - dslc_module_options_show ( Show module options )
 * - dslc_module_options_section_filter ( Filter options section )
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

import { CModalWindow } from './modalwindow.class.js';
import { hidePublishButton, showSection } from './uigeneral.js';
import anime from 'animejs';
import { editableContentCodeGeneration } from "./codegeneration.js";

var actionAvail = function() {

	if ( LiveComposer.Builder.Flags.panelOpened ) {
		LiveComposer.Builder.UI.shakePanelConfirmButton();
		return false;
	}

	return true;
}

/**
 * Hook - Duplicate Module
 */
document.addEventListener('moduleDuplicate', function (customEvent) {
	const elClicked = customEvent.detail;  // customEvent.detail - is element being clicked passed as additional data in the event.

	// Check if action can be fired
	if ( ! actionAvail() ) return false;

	if ( ! elClicked.classList.contains('dslca-action-disabled') ) {
		moduleDuplicate( elClicked.closest('.dslc-module-front') );
	}
});

/**
 * Hook - Module Delete
 */

document.addEventListener( 'moduleDelete', function (customEvent) {
	const elClicked = customEvent.detail;  // customEvent.detail - is element being clicked passed as additional data in the event.

	// Check if action can be fired
	if ( ! actionAvail() ) return false;

	var self = this;

	if ( ! elClicked.classList.contains('dslca-action-disabled') ) {

		CModalWindow({
			title: DSLCString.str_del_module_title,
			content: DSLCString.str_del_module_descr,
			confirm: function() {

				var module = elClicked.closest('.dslc-module-front');
				dslc_module_delete( module );
			}
		});
	}
});

/**
 * Hook - Edit Module On Click ( Display Options Panel )
 */
document.addEventListener('moduleEdit', function (customEvent) {
	const elClicked = customEvent.detail;  // customEvent.detail - is element being clicked passed as additional data in the event.
	const currentModuleEl = elClicked.closest('.dslc-module-front');
	const currentModuleId = currentModuleEl.dataset.module;

	const elEditing = LiveComposer.Builder.PreviewAreaWindow.document.querySelector('.dslca-module-being-edited');
	const row_edited = jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).length;

	// If settings panel opened - do not proceed.
	if ( LiveComposer.Builder.Flags.uiHidden || ( null !== elEditing && elEditing.length > 0 ) || row_edited > 0 ) {
		if ( elEditing != currentModuleEl ) {
			LiveComposer.Builder.UI.shakePanelConfirmButton();
		}
		return false;
	}
	unmarkModulesBeingEdited();

	// Add the "being edited" class to current module
	currentModuleEl.classList.add('dslca-module-being-edited');
	// Call the function to display options
	window.dslc_module_options_show( currentModuleId );
	// Cover up other modules with semi transp cover
	LiveComposer.Builder.PreviewAreaWindow.document.body.classList.add('module-editing-in-progress');
});

/**
 * Hook - Copy Module Styles On Click
 */
document.addEventListener('copyModuleStyles', function (customEvent) {
	const elClicked = customEvent.detail;  // customEvent.detail - is element being clicked passed as additional data in the event.
	const currentModuleEl = elClicked.closest('.dslc-module-front');

	// Get module code.
	let currentModuleCode = currentModuleEl.querySelector( '.dslca-module-code').innerText;
	// Save coppied styles in local storage (real buffer isn't supported by all the browsers).
	localStorage.setItem( 'lcCopyPasteStorage', currentModuleCode );
});

/**
 * Hook - Paste Module Styles On Click
 */
document.addEventListener('pasteModuleStyles', function (customEvent) {
	const elClicked = customEvent.detail;  // customEvent.detail - is element being clicked passed as additional data in the event.
	const currentModuleEl = elClicked.closest('.dslc-module-front');
	const dslcModule = jQuery( currentModuleEl );
	// Extract paste value from the local storage.
	const pasteModuleCode = localStorage.getItem( 'lcCopyPasteStorage' );
	let pasteModuleProperies = false;
	if ( pasteModuleCode ) {
		try {
			pasteModuleProperies = JSON.parse( pasteModuleCode );
		} catch(e) {
			console.log( "Can't parse copy/paste string into JSON:" );
			console.log( e );
		}
	}

	if ( pasteModuleProperies ) {
		// Does module id from paste data match with current block?
		if ( pasteModuleProperies.module_id === currentModuleEl.dataset.module ) {
			const currentModuleCodeContainer = currentModuleEl.querySelector('.dslca-module-code');
			const currentModuleCode = currentModuleCodeContainer.innerText;
			let currentModuleProperties = false;
			try {
				currentModuleProperties = JSON.parse( currentModuleCode );
			} catch(e) {
				console.log( "Can't parse current module code into JSON:" );
				console.log( e );
			}

			if ( currentModuleProperties ) {
				let modulePropertiesChanged = false;
				for (let propertyId in pasteModuleProperies) {
					// Override all styling properties with the ones from pasted styles.
					if ( propertyId.includes( 'css_' ) ) {
						currentModuleProperties[ propertyId ] = pasteModuleProperies[ propertyId ];
						modulePropertiesChanged = true;
					}
				}

				for (let propertyId in currentModuleProperties) {
					// If property is missing in pasted data make it empty.
					if ( propertyId.includes( 'css_' ) ) {
						if ( currentModuleProperties[ propertyId ] !== pasteModuleProperies[ propertyId ] ) {
							currentModuleProperties[ propertyId ] = '';
						}
						modulePropertiesChanged = true;
					}
				}

				if ( modulePropertiesChanged ) {
					// Prepare and call AJAX module redraw request.
					currentModuleProperties['action'] = 'dslc-ajax-add-module';
					currentModuleProperties['dslc'] = 'active';
					currentModuleProperties['dslc_module_id'] = currentModuleProperties.module_id;
					currentModuleProperties['dslc_module_instance_id'] = currentModuleProperties.module_instance_id;
					currentModuleProperties['dslc_post_id'] = currentModuleProperties.post_id;

					if ( dslcModule.hasClass('dslca-preload-preset') )
						currentModuleProperties['dslc_preload_preset'] = 'enabled';
					else
						currentModuleProperties['dslc_preload_preset'] = 'disabled';

					dslcModule.removeClass('dslca-preload-preset');
					currentModuleProperties.dslc_url_vars = LiveComposer.Utils.get_page_params();

					/**
					 * Call AJAX for module redraw
					 */
					jQuery.post(
						DSLCAjax.ajaxurl, currentModuleProperties,
						function( response ) {
							if ( response ) {
								dslcModule.after(response.output).next().addClass('dslca-module-being-edited');
								dslcModule.remove();
								window.dslc_generate_code();
								window.dslc_show_publish_button();

								LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
								LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();

								LiveComposer.Builder.PreviewAreaWindow.dslc_tabs();
								LiveComposer.Builder.PreviewAreaWindow.dslc_init_accordion();

								jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');
							}
						}
					);
				}
			}
		}
	}
});

/**
 * Hook - Edit Module On Click ( Display Options Panel ) - Fixed: https://github.com/live-composer/live-composer-page-builder/issues/895
 */

const adjustZindex = () => {
	LiveComposer.Builder.PreviewAreaDocument.on( {
		mouseenter: function(e) {
			// Adjust z-index.
			jQuery('.dslca-modules-section-manage', LiveComposer.Builder.PreviewAreaDocument).css("z-index", "99998");

			// Adjust module editing controls for too small elements.
			const moduleEl = e.target.closest("[data-module-id]");
			const elementHeight = moduleEl.offsetHeight;
			const elementWidth = moduleEl.offsetWidth;

			if ( elementHeight < 60 && elementWidth < 300 ) {
				moduleEl.classList.add('dslc-small-height-module');
			} else {
				moduleEl.classList.remove('dslc-small-height-module');
			}

		},
		mouseleave: function(e) {
			jQuery('.dslca-modules-section-manage', LiveComposer.Builder.PreviewAreaDocument).css("z-index", "999999");
		},
	}, '.dslca-change-width-module-hook, .dslc-module-front .dslca-module-manage');
}

/**
 * Hook - Set Module Width
 */

document.addEventListener('moduleChangeWidth', function ( customEvent ) {
	const elClicked = customEvent.detail;  // customEvent.detail - is element being clicked passed as additional data in the event.
	const currentModuleEl = elClicked.closest('.dslc-module-front');

	if ( ! elClicked.classList.contains('dslca-action-disabled') ) {
		var oldSize = currentModuleEl.dataset.dslcModuleSize;
		var newSize = elClicked.dataset.size;

		// Start expensive function only if the value changed.
		if (  Number(oldSize) !== Number(newSize) ) {
			dslc_module_width_set( currentModuleEl, newSize );
		}
	}

});

/**
 * Hook - Show code for altering module's defaults
 */
/*
FIXIT
LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-module-get-defaults-hook', function(){

	// Vars
	var module = jQuery(this).closest('.dslc-module-front');
	var code = dslc_dm_get_defaults( module );

	// Generate modal's text
	var message = '<span class="dslca-prompt-modal-title">Module Defaults</span>'
		+ '<span class="dslca-prompt-modal-descr">The code bellow is used to alter the defaults.</span>'
		+ '<textarea></textarea><br><br>';

	// Hide modal's cancel button
	jQuery('.dslca-prompt-modal-cancel-hook').hide();

	// Show confirm button and change it to "OK"
	jQuery('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>OK');

	// Show the modal prompt
	dslc_js_confirm( 'dev_mode_get_default', message, module );
}); */

/**
 * Hook - Refresh Module
 * We have 'refresh' icon on blog posts grid and other post-based modules.
 * It's visible only when there are no posts to render.
 */
/*
FIXIT
LiveComposer.Builder.PreviewAreaDocument.on( 'click', '.dslca-refresh-module-hook', function(e){

	jQuery(this).css({
		'-webkit-animation-name' : 'dslcRotate',
		'-moz-animation-name' : 'dslcRotate',
		'animation-name' : 'dslcRotate',
		'animation-duration' : '0.6s',
		'-webkit-animation-duration' : '0.6s',
		'animation-iteration-count' : 'infinite',
		'-webkit-animation-iteration-count' : 'infinite'
	});
	jQuery(this).closest('.dslc-module-front').addClass('dslca-module-being-edited');
	moduleOutputAltered( function() {

		jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');
	});
}); */

/**
 * Show WYSIWYG
 */

document.addEventListener('wysiwygEdit', function ( customEvent ) {
	const elClicked = customEvent.detail;  // customEvent.detail - is element being clicked passed as additional data in the event.
	const currentModuleEl = elClicked.closest('.dslc-module-front');

	// const editableEl = elClicked.querySelector('.dslca-editable-content');
	const idToEdit = elClicked.dataset.idToEdit;

	const editableEl = currentModuleEl.querySelector('[data-edit-id="' + idToEdit + '"]');
	let content = '';

	if ( 'TEXTAREA'=== editableEl.tagName || 'INPUT'=== editableEl.tagName ) {
		content = editableEl.value;
	} else {
		content = editableEl.innerHTML;
	}

	if ( undefined === content ) {
		content = '';
	}

	if ( content.trim().length ) {
		// Extract Content for current tab/accordion:
		/* if ( currentModuleEl.classList.contains('dslc-module-handle-like-accordion') || currentModuleEl.classList.contains('dslc-module-handle-like-tabs') ) {
			const full_content_arr = content.split('(dslc_sep)');
			if ( full_content_arr.length ) {
				content = full_content_arr[idToEdit].trim();
			}
		} */

		content = content.replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');
	}

	// Restore shortcodes presentation.
	if ( content.includes( '%' ) ) {
		content = content.replace(/%\(\(%/g, '[');
		content = content.replace(/%\)\)%/g, ']');
		content = content.replace(/%\(%/g, '[');
		content = content.replace(/%\)%/g, ']');
		content = content.replace(/%\{%/g, '[');
		content = content.replace(/%\}%/g, ']');
	}

	content = content.trim();

	// Fill TinyMCE editor with extracted above content.
	if ( typeof tinymce != 'undefined' ) {
		var editor = tinymce.get( 'dslcawpeditor' );

		if ( document.getElementById('wp-dslcawpeditor-wrap').classList.contains('tmce-active') ) {
			editor.setContent( content, {format : 'html'} );
		} else {
			document.getElementById('dslcawpeditor').value = content;
		}

		if ( ! currentModuleEl.classList.contains('dslca-module-being-edited') ) {
			currentModuleEl.querySelector('.dslca-module-edit-hook').click();
		}

		jQuery('.dslca-wp-editor').show();
		editableEl.classList.add('dslca-wysiwyg-active');
		jQuery('#dslcawpeditor_ifr, #dslcawpeditor').css({ height : jQuery('.dslca-wp-editor').height() - 300 });
	} else {
		console.info( 'Live Composer: TinyMCE is undefined.' );
	}
});

// Editable Contents.
const editableContentTextEvents = () => {

	// Preview iframe events.
	/* LiveComposer.Builder.PreviewAreaWindow.document.addEventListener('blur', function (event) {
		// event.preventDefault();
		if ( event.target.matches( '[data-event="module-edit"]' ) ) {

		}
	});
 */
/* 	LiveComposer.Builder.PreviewAreaWindow.document.addEventListener('keyup', function (event) {
		// event.preventDefault();
		if ( event.target.matches( '[data-event="module-edit"]' ) ) {

		}
	});
 */
	LiveComposer.Builder.PreviewAreaDocument.on('blur', '.dslca-editable-content', function() {
		if ( ! LiveComposer.Builder.Flags.uiHidden && jQuery(this).data('type') == 'simple' ) {
			editableContentCodeGeneration( jQuery(this) );
		}
	}).on( 'paste', '.dslca-editable-content:not(.inline-editor)', function(){
		if ( ! LiveComposer.Builder.Flags.uiHidden  && jQuery(this).data('type') == 'simple' ) {
			var dslcRealInput = jQuery(this);

			setTimeout(function(){
				if ( dslcRealInput.data('type') == 'simple' ) {
					dslcRealInput.html( dslcRealInput.text() );
				}
				editableContentCodeGeneration( dslcRealInput );
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
}

/**
 * Hook - On contenteditable focusout.
 */
document.addEventListener('contentEditableFocusOut', function (customEvent) {
	window.dslc_show_publish_button();
});



/**
 * MODULES - Delete a Module
 */
function dslc_module_delete( module ) {

	if ( window.dslcDebug ) console.log( 'dslc_delete_module' );
	showSection( '.dslca-modules' );

	anime({
		targets: module,
		easing: 'easeOutExpo',
		scale: 0,
		opacity: 0,
		duration: 350,
		delay: 0,
		endDelay: 0,
		complete: function(anim) {
			// Remove module, regenerate code, show publish button
			module.parentNode.removeChild( module );
			window.dslc_generate_code();
			window.dslc_show_publish_button();
		}
	  });
}

const unmarkModulesBeingEdited = () => {
	// Remove being edited class if some module is being edited.
	const elEditing = LiveComposer.Builder.PreviewAreaWindow.document.querySelector('.dslca-module-being-edited');
	if ( null !== elEditing ) {
		elEditing.classList.remove('dslca-module-being-edited');
	}
}

/**
 * Modules - Copy a Module
 */
function moduleDuplicate( module ) {
	if ( window.dslcDebug ) console.log( 'dslc_copy_module' );
	unmarkModulesBeingEdited();

	// Duplicate the module and append it to the same area
	var module_new = module.cloneNode(true);

	jQuery( module_new ).appendTo( module.closest( '.dslc-modules-area' ) ).css({
		'-webkit-animation-name' : 'none',
		'-moz-animation-name' : 'none',
		'animation-name' : 'none',
		'animation-duration' : '0',
		'-webkit-animation-duration' : '0',
		opacity : 0,
		top: -50
	}).addClass('dslca-module-being-edited');

	// Generate new ID for the new module and change it in HTML/CSS of the module.
	getNewModuleId( module_new );

	// Module fully cloned. Finish the process.
	// Need to call this function to update last column class for the modules.
	window.dslc_generate_code();

	// Fade in the module
	anime({
		targets: module_new,
		easing: 'easeOutExpo',
		// scale: 0,
		top: 0,
		opacity: 1,
		duration: 400,
		delay: 0,
		endDelay: 0,
		complete: function(anim) {
			module_new.classList.remove( 'dslca-module-being-edited' );
		}
	});

	window.dslc_show_publish_button();
}

/**
 * Generate new ID for the module provided
 *
 * Search/Replace old module ID with new one in HTML/CSS of the module.
 *
 * @param DOM module Module that needs ID updated (new ID).
 * @return void
 */
export const getNewModuleId = ( moduleEl ) => {

	// Vars
	var dslc_module_id = LiveComposer.Utils.get_unique_id(); // Generate new module ID.
	var dslc_module_id_original = moduleEl.getAttribute( 'id' ); // Original Module ID.

	// Update module ID in data attribute
	moduleEl.setAttribute( 'data-module-id', dslc_module_id );
	// Update module ID in id attribute of element
	moduleEl.setAttribute( 'id', 'dslc-module-' + dslc_module_id );

	/**
	 * Search/Replace module id in the inline CSS
	 */
	var inline_css_el = moduleEl.getElementsByTagName( 'style' )[0];
	var inline_css_code = inline_css_el.textContent;
	// Update id attribute for <style> element with new value
	inline_css_el.setAttribute( 'id', '#css-for-dslc-module-' + dslc_module_id );
	// Search/Replace all occurrences of module ID in inline CSS
	inline_css_code = inline_css_code.split( dslc_module_id_original ).join( 'dslc-module-' + dslc_module_id );
	// Put CSS code back into <style> element
	inline_css_el.textContent = inline_css_code;

	// Update module ID in raw base64 code (dslc_code) of the module
	LiveComposer.Utils.update_module_property_raw( moduleEl, 'module_instance_id', dslc_module_id );
}

/**
 * MODULES - Set Width
 */
function dslc_module_width_set( moduleEl, new_width ) {

	if ( window.dslcDebug ) console.log( 'dslc_module_width_set' );

	// Generate new column class
	var newClass = 'dslc-' + new_width + '-col';

	// Add new column class and change size "data"
	jQuery( moduleEl )
		.removeClass('dslc-1-col dslc-2-col dslc-3-col dslc-4-col dslc-5-col dslc-6-col dslc-7-col dslc-8-col dslc-9-col dslc-10-col dslc-11-col dslc-12-col')
		.addClass(newClass)
		.data('dslc-module-size', new_width);
		//.addClass('dslca-module-being-edited'); – Deprecated

	// Change module size in element attribute
	moduleEl.setAttribute('data-dslc-module-size',new_width);

	// Update module size in raw base64 code (dslc_code) of the module
	LiveComposer.Utils.update_module_property_raw( moduleEl, 'dslc_m_size', new_width );

	LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();

	window.dslc_generate_code();
	window.dslc_show_publish_button();
}

/**
 * MODULES - Show module options
 */
window.dslc_module_options_show = function( moduleID ) {

	if ( window.dslcDebug ) console.log( 'dslc_module_options_show' );

	if ( undefined === moduleID ) {
		console.warn( 'No module ID defined in dslc_module_options_show function.' )
	}

	// Vars
	var dslcModule = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument),
	dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
	dslcDefaultSection = jQuery('.dslca-header').data('default-section'),
	pseudoPanel = jQuery(jQuery('#pseudo-panel').html());

	jQuery("#wpwrap").append(pseudoPanel);

	// Settings array for the Ajax call
	var dslcSettings = {};
	dslcSettings['action'] = 'dslc-ajax-display-module-options';
	_wpnonce : DSLCAjax._wpnonce,
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

		if ( dslcOptionValue.includes( '%' ) ) {
			// Restore shortcodes.
			dslcOptionValue = dslcOptionValue.replace(/%\(\(%/g, '[');
			dslcOptionValue = dslcOptionValue.replace(/%\)\)%/g, ']');
			dslcOptionValue = dslcOptionValue.replace(/%\(%/g, '[');
			dslcOptionValue = dslcOptionValue.replace(/%\)%/g, ']');
			dslcOptionValue = dslcOptionValue.replace(/%\{%/g, '[');
			dslcOptionValue = dslcOptionValue.replace(/%\}%/g, ']');
		}

		// Add option ID and value to the settings array
		dslcSettings[dslcOptionID] = dslcOptionValue;
	});

	// Hide the save/cancel actions for text editor and show notification
	jQuery('.dslca-wp-editor-actions').hide();
	jQuery('.dslca-wp-editor-notification').show();

	// Hide the publish button
	hidePublishButton();

	// LiveComposer.Builder.UI.initInlineEditors();

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
			showSection('.dslca-module-edit');

			// Add the options
			if ( ! jQuery('body').hasClass('rtl') ) {

				jQuery('.dslca-module-edit-options-inner').html( response.output );
			} else {

				jQuery('.dslca-module-edit-options-inner').html( response.output );
			}

			jQuery('.dslca-module-edit-options-tabs').html( response.output_tabs );


			var sectionsUsed = []; // – Array with tab ids to show for current module.

			/**
			 * Go through each option and check its tab property.
			 * Fill sectionsUsed array with ids of the tabs to display.
			 * We don't want to display tabs with no options inside.
			 */
			jQuery('.dslca-module-edit-options-inner .dslca-module-edit-option').each(function(){
				var currentOptionSection = jQuery(this).data('section');

				// Check if this section is in the list of tabs to show.
				if ( sectionsUsed.indexOf(currentOptionSection) == -1 ) {
					sectionsUsed.push(currentOptionSection);
				}
			});

			var tabs_total = sectionsUsed.length;

			for (var i = 0; i < tabs_total; i++) {
				// Show the tabs used by the current module.
				jQuery('.dslca-header .dslca-options-filter-hook[data-section="' + sectionsUsed[i] + '"]').show();
			}

			// Show the filter hooks
			// jQuery('.dslca-header .dslca-options-filter-hook').show();

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
	).done(function() {
		// Attach evenets to the Font family selection fields.
		window.dslc_module_options_font();
	});
}

/**
 * MODULES - Module output default settings
 */
export const moduleOutputDefault = ( dslc_module_id, callback ) => {

	if ( window.dslcDebug ) console.log( 'moduleOutputDefault' );

	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-add-module',
			_wpnonce : DSLCAjax._wpnonce,
			dslc : 'active',
			dslc_module_id : dslc_module_id, // ex. DSLC_Button
			dslc_post_id : jQuery('.dslca-container').data('post-id'),
			dslc_url_vars: LiveComposer.Utils.get_page_params(),
			dslc_new_module: true
		},
		function( response ) {
			callback(response);
		}
	);
}

/**
 * MODULES - Redraw module output when settings altered
 */
export const moduleOutputAltered = ( callback ) => {

	if ( window.dslcDebug ) console.log( 'moduleOutputAltered' );
	callback = typeof callback !== 'undefined' ? callback : false;

	var dslcModule = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument),
	dslc_module_id = dslcModule.data('module'),
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

			var newModule = LiveComposer.
								Builder.
								Helpers.
								insertModule( response.output, dslcModule );

			newModule.addClass('dslca-module-being-edited');

			response = null;
			newModule = null;

			// TODO: Add new postponed action to run after all done

			// window.dslc_show_publish_button();
			LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();

			LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();

			LiveComposer.Builder.PreviewAreaWindow.dslc_tabs();
			LiveComposer.Builder.PreviewAreaWindow.dslc_init_accordion();


			/**
			 * Create Custom Event/Hook
			 *
			 * Third-party developers should use it like this:
			 * window.addEventListener('moduleOutputAltered', function (e) {
			 * 	....
			 * }, false);
			 */
			var event = new Event('moduleOutputAltered');
			// Dispatch the event.
			LiveComposer.Builder.PreviewAreaWindow.dispatchEvent(event);

			if ( callback ) {
				callback( response );
			}
		}
	);
}

/**
 * MODULES - Reload a specific module
 */
window.dslc_module_output_reload = function ( dslcModule, callback ) {

	if ( window.dslcDebug ) console.log( 'dslc_module_output_reload' );
	callback = typeof callback !== 'undefined' ? callback : false;

	var dslc_module_id = dslcModule.data('module'),
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
			window.dslc_generate_code();
			window.dslc_show_publish_button();

			LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
			LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();

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
 * Other - Get Alter Module Defaults Code
 */
function dslc_dm_get_defaults( module ) {

	if ( window.dslcDebug ) console.log( 'dslc_dm_get_defaults' );

	// The module code value
	// var optionsCode = module.find('.dslca-module-code').val(); – Don't use. Causes bugs!
	var optionsCode = module.find('.dslca-module-code').innerText;

	// Ajax call to get the plain PHP code
	jQuery.post(
		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-dm-module-defaults',
			_wpnonce : DSLCAjax._wpnonce,
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
 * Deprecated Functions and Fallbacks
 */
function dslc_copy_module( module ) { moduleDuplicate( module ); }
function dslc_display_module_options( moduleID ) { window.dslc_module_options_show( moduleID ); }
function dslc_preview_change( callback ) { moduleOutputAltered( callback ); }
function dslc_reload_module( moduleID, callback ) { window.dslc_module_output_reload( moduleID, callback ); }

export const moduleInitJS = () => {
	adjustZindex();
	editableContentTextEvents();
}
