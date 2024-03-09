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

import { sectionsInitJS } from './sections.js';
import { dragAndDropInit } from './dragndrop.js';
import { moduleareasInitJS } from './modulearea.js';
import { hideModal } from "./modalwindow.js";

/**
 * TEMPLATES - Load
 */
const loadTemplateById = ( template ) => {

	if ( window.dslcDebug ) console.log( 'dslc_load_template' );

	// Vars
	var dslcModule, dslcModuleID;

	// Template preloader
	jQuery('#wpcontent').prepend('<div class="lc-template-loader"></div>');

	var block = '<div class="lc-loader lds-css"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';

	jQuery('.lc-template-loader').prepend(block);


	// Ajax call to get template's HTML
	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-load-template',
			_wpnonce : DSLCAjax._wpnonce,
			dslc : 'active',
			dslc_template_id : template
		},
		function( response ) {

			// Apply the template's HTML
			jQuery('#dslc-main', LiveComposer.Builder.PreviewAreaDocument).html( response.output );

			jQuery('.lc-template-loader').remove();

			// Call other functions
			LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();

			// Check init for rows and module areas
			sectionsInitJS();
			moduleareasInitJS();

			dragAndDropInit();
			window.dslc_show_publish_button();
			window.dslc_generate_code();
		}
	);
}

/**
 * TEMPLATES - Import
 */
function dslc_template_import() {

	if ( window.dslcDebug ) console.log( 'dslc_import_template' );

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
			_wpnonce : DSLCAjax._wpnonce,
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
			hideModal( '', '.dslca-modal-templates-import' );

			// Call other functions
			LiveComposer.Builder.PreviewAreaWindow.dslc_bg_video();
			dragAndDropInit();
			window.dslc_show_publish_button();
			window.dslc_generate_code();
		}
	);
}

/**
 * TEMPLATES - SAVE
 */
function dslc_template_save() {
	if ( window.dslcDebug ) console.log( 'dslc_save_template' );

	// AJAX call to save the template
	jQuery.post(
		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-save-template',
			_wpnonce : DSLCAjax._wpnonce,
			dslc : 'active',
			dslc_template_code : jQuery('#dslca-code').val(),
			dslc_template_title : jQuery('#dslca-save-template-title').val()
		},
		function( response ) {
			// Hide the modal
			hideModal( '', '.dslca-modal-templates-save' );
		}
	);
}

/**
 * TEMPLATES - DELETE
 */
function dslc_template_delete( template ) {

	if ( window.dslcDebug ) console.log( 'dslc_delete_template' );

	// AJAX call to delete template
	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-delete-template',
			_wpnonce : DSLCAjax._wpnonce,
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
 function dslc_import_template() { dslc_template_import(); }
 function dslc_save_template() { dslc_template_save(); }
 function dslc_delete_template( template ) { dslc_template_delete( template ); }

 /**
  * TEMPLATES - Document Ready
  */

 export const templatesPanelInit = () => {

	/**
	 * Hook - Load Template
	 */
	let templateItem = document.querySelectorAll('.dslca-template');
	// Attach import function to each template item.
	templateItem.forEach(function(element) {
		element.addEventListener('click', event => {
			event.preventDefault();
			let importButton = event.target.closest("[data-id]");
			loadTemplateById( importButton.dataset.id );
		});
	});

	/**
	 * Hook - Import Template
	 */
	jQuery('.dslca-template-import-form').submit(function(e){
		e.preventDefault();
		dslc_template_import();
	});

	/**
	 * Hook - Save Template
	 */
	jQuery('.dslca-template-save-form').submit(function(e){
		e.preventDefault();
		dslc_template_save();
	});

	/**
	 * Hook - Delete Template
	 */
	jQuery(document).on( 'click', '.dslca-delete-template-hook', function(e){

		e.stopPropagation();
		dslc_template_delete( jQuery(this).data('id') );
	});

}
