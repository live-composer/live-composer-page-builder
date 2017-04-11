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
function dslc_update_preset() {

	if ( dslcDebug ) console.log( 'dslc_update_preset' );

	// Vars
	var module = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument),
	presetName = module.find('.dslca-module-option-front[data-id="css_load_preset"]').val(),
	presetCode = module.find('.dslca-module-code').val(),
	moduleID = module.data('dslc-module-id');

	// If preset value not "none"
	if ( 'none' !== presetName && '' !== presetName ) {

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

				if ( response.preset_setting == 'enabled' ) {

					// Reload all modules with the same preset
					jQuery('.dslc-module-front:not(#' + module.attr('id') + ')[data-dslc-module-id="' + module.data('dslc-module-id') +
						'"][data-dslc-preset="' + module.data('dslc-preset') + '"]', LiveComposer.Builder.PreviewAreaDocument ).each(function(){
						dslc_module_output_reload( jQuery(this) );
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
		$('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).addClass('dslca-preload-preset');
	});
});