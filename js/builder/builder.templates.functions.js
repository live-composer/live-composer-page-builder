/*********************************
 *
 * = TEMPLATES =
 *
 * - dslc_load_template ( Load Template )
 * - dslc_import_template ( Import Template )
 * - dslc_save_template ( Save TEmplate )
 * - dslc_delete_template ( Delete Template )
 *
 ***********************************/

'use strict';

/**
 * TEMPLATES - Load
 */
function dslc_template_load( template ) {

	if ( dslcDebug ) console.log( 'dslc_load_template' );

	// Vars
	var dslcModule, dslcModuleID;

	// Ajax call to get template's HTML
	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-load-template',
			dslc : 'active',
			dslc_template_id : template
		},
		function( response ) {

			// Apply the template's HTML
			jQuery('#dslc-main', LiveComposer.Builder.PreviewAreaDocument).html( response.output );

			// Call other functions
			LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
			dslc_drag_and_drop();
			dslc_show_publish_button();
			dslc_generate_code();
		}
	);
}

/**
 * TEMPLATES - Import
 */
function dslc_template_import() {

	if ( dslcDebug ) console.log( 'dslc_import_template' );

	// Vars
	var dslcModule, dslcModuleID;

	// Hide the title on the button and show loading animation
	jQuery('.dslca-modal-templates-import .dslca-modal-title').css({ opacity : 0 });
	jQuery('.dslca-modal-templates-import .dslca-loading').show();

	// Ajax call to load template's HTML
	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-import-template',
			dslc : 'active',
			dslc_template_code : jQuery('#dslca-import-code').val()
		},
		function( response ) {

			// Apply the template's HTML
			jQuery('#dslc-main', LiveComposer.Builder.PreviewAreaDocument).html( response.output );

			// Hide the loading on the button and show the title
			jQuery('.dslca-modal-templates-import .dslca-loading').hide();
			jQuery('.dslca-modal-templates-import .dslca-modal-title').css({ opacity : 1 });

			// Hide the modal
			dslc_hide_modal( '', '.dslca-modal-templates-import' );

			// Call other functions
			LiveComposer.Builder.PreviewAreaWindow.dslc_bg_video();
			dslc_drag_and_drop();
			dslc_show_publish_button();
			dslc_generate_code();
		}
	);
}

/**
 * TEMPLATES - SAVE
 */
function dslc_template_save() {

	if ( dslcDebug ) console.log( 'dslc_save_template' );

	// AJAX call to save the template
	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-save-template',
			dslc : 'active',
			dslc_template_code : jQuery('#dslca-code').val(),
			dslc_template_title : jQuery('#dslca-save-template-title').val()
		},
		function( response ) {

			// Hide the modal
			dslc_hide_modal( '', '.dslca-modal-templates-save' );
		}
	);
}

/**
 * TEMPLATES - DELETE
 */
function dslc_template_delete( template ) {

	if ( dslcDebug ) console.log( 'dslc_delete_template' );

	// AJAX call to delete template
	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-delete-template',
			dslc : 'active',
			dslc_template_id : template
		},
		function( response ) {

			// Remove template from the template listing
			jQuery('.dslca-template[data-id="' + template + '"]').fadeOut(200, function(){
				jQuery(this).remove();
			});
		}
	);
}

/**
 * Deprecated Functions and Fallbacks
 */

 function dslc_load_template( template ) { dslc_template_load( template ); }
 function dslc_import_template() { dslc_template_import(); }
 function dslc_save_template() { dslc_template_save(); }
 function dslc_delete_template( template ) { dslc_template_delete( template ); }

 /**
  * TEMPLATES - Document Ready
  */

jQuery(document).ready(function($) {

	/**
	 * Hook - Load Template
	 */
	jQuery(document).on( 'click', '.dslca-template', function(e){

		e.preventDefault();
		dslc_template_load( jQuery(this).data('id') );
	});

	/**
	 * Hook - Import Template
	 */
	$('.dslca-template-import-form').submit(function(e){

		e.preventDefault();
		dslc_template_import();
	});

	/**
	 * Hook - Save Template
	 */
	$('.dslca-template-save-form').submit(function(e){

		e.preventDefault();
		dslc_template_save();
	});

	/**
	 * Hook - Delete Template
	 */
	$(document).on( 'click', '.dslca-delete-template-hook', function(e){

		e.stopPropagation();
		dslc_template_delete( $(this).data('id') );
	});

});