/*********************************
*
* = MODULE PRESETS =
*
* - dslc_update_preset ( Update Styling Preset )
*
***********************************/

'use strict';

/**
 * Module Presets - Update
 */
export const updatePreset = () => {
	if ( window.dslcDebug ) console.log( 'updatePreset' );
	// Vars
	var module = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument),
	presetName = module.find('.dslca-module-option-front[data-id="css_load_preset"]').val(),
	// presetCode = module.find('.dslca-module-code').val(), - don't use. Creating bugs.
	presetCode = module.find('.dslca-module-code').innerText,
	moduleID = module.data('module');

	// If preset value not "none"
	if ( 'none' !== presetName && '' !== presetName ) {

		// AJAX Call to Save Preset
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-save-preset',
				_wpnonce : DSLCAjax._wpnonce,
				dslc_preset_name : presetName,
				dslc_preset_code : presetCode,
				dslc_module_id : moduleID
			},
			function( response ) {

				if ( response.preset_setting == 'enabled' ) {

					// Reload all modules with the same preset
					jQuery('.dslc-module-front:not(#' + module.attr('id') + ')[data-module="' + module.data('module') +
						'"][data-dslc-preset="' + module.data('dslc-preset') + '"]', LiveComposer.Builder.PreviewAreaDocument ).each(function(){
						window.dslc_module_output_reload( jQuery(this) );
					});
				}
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

	jQuery(document).on( 'keypress', '.dslca-module-edit-field[name="css_save_preset"]', function(e){

		// Enter Key Pressed
		if ( e.which == 13 ) {

			// Vars
			var presetName = jQuery(this).val(),
			presetID = presetName.toLowerCase().replace(/\s/g, '-');

			// Add class to body that a new preset is added
			jQuery('body').addClass('dslca-new-preset-added');

			// Append the new preset to the "Load Preset" option and trigger change
			jQuery('.dslca-module-edit-field[name="css_load_preset"]').append('<option value="' + presetID + '">' + presetID + '</option>').val( presetID ).trigger('change');

			// Erase value from the "Save Preset" option
			jQuery(this).val('');

			jQuery('.dslc-delete-preset').removeClass('dslc-delete-preset-hide');
		}
	});

	/**
	 * Action - Preset value changed
	 */

	jQuery(document).on( 'change', '.dslca-module-edit-field[name="css_load_preset"]', function(e){
		jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).addClass('dslca-preload-preset');
	});

	/**
	 * Action - Delete Preset
	 */

	jQuery(document).on( 'click', '.dslc-delete-preset', function(e){

		// Vars
		var module = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument),
		presetName = module.find('.dslca-module-option-front[data-id="css_load_preset"]').val(),
		moduleID = module.data('module');

		// If preset value not "none"
		if ( 'none' !== presetName && '' !== presetName ) {

			// AJAX Call to Save Preset
			jQuery.post(

				DSLCAjax.ajaxurl,
				{
					action : 'dslc-ajax-delete-preset',
					_wpnonce : DSLCAjax._wpnonce,
					dslc_preset_name : presetName,
					dslc_module_id : moduleID
				},
				function( response ) {

					window.dslc_module_options_show(moduleID);
				}
			);
		}
	});
});


export const presetsInit = () => {

}
