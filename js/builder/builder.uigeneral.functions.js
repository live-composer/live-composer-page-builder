/*********************************
 *
 * = UI - GENERAL =
 *
 * - dslc_hide_composer ( Hides the composer elements )
 * - dslc_show_composer ( Shows the composer elements )
 * - dslc_show_publish_button ( Shows the publish button )
 * - dslc_show_section ( Show a specific section )
 * - dslc_generate_filters ( Generate origin filters )
 * - dslc_filter_origin ( Origin filtering for templates/modules listing )
 * - dslc_drag_and_drop ( Initiate drag and drop functionality )
 ***********************************/

'use strict';

/**
 * Try to detect JS errors in WP Admin part.
 */
 window.onerror = function( error, file, line, char ) {

	dslca_generate_error_report ( error, file, line, char );
}

/**
 * Hook - Open Error Log button
 */
jQuery(document).on( 'click', '.dslca-show-js-error-hook', function(e){

	e.preventDefault();

	var errors_container = document.getElementById('dslca-js-errors-report');

	if ( ! jQuery('body').hasClass('dslca-saving-in-progress') ) {

		LiveComposer.Builder.UI.CModalWindow({

			title: '<a href="https://livecomposerplugin.com/support/support-request/" target="_blank"><span class="dslca-icon dslc-icon-comment"></span> &nbsp; Open Support Ticket</a>',
			content: '<span class="dslca-error-report">' + errors_container.value + '</span>',
		});
	}
});


/**
 * UI - GENERAL - Document Ready
 */

jQuery(document).ready(function($) {

	/**
	 * Try to detect JS errors in preview area.
	 */
	jQuery("#page-builder-frame")[0].contentWindow.onerror = function( error, file, line, char ) {

		dslca_generate_error_report ( error, file, line, char );
	}

	// Put JS error log data in a hidden textarea.
	dslca_update_report_log();


 	jQuery('body').addClass('dslca-enabled dslca-drag-not-in-progress');
 	jQuery('.dslca-invisible-overlay').hide();
 	jQuery('.dslca-section').eq(0).show();


	/** Wait till tinyMCE loaded */
	window.previewAreaTinyMCELoaded = function(){

		var self = this;
		LiveComposer.Builder.PreviewAreaWindow = this;
		LiveComposer.Builder.PreviewAreaDocument = jQuery(this.document);

		// Disable WP admin bar in editing mode
		jQuery('#wpadminbar', LiveComposer.Builder.PreviewAreaDocument).remove();

		LiveComposer.Builder.UI.initInlineEditors();
		dslc_fix_contenteditable();

		var mainDraggable = LiveComposer.Builder.PreviewAreaDocument.find("#dslc-main").eq(0)[0];
		new LiveComposer.Builder.Elements.CSectionsContainer( mainDraggable );

		jQuery(document).trigger('editorFrameLoaded');

		dslc_drag_and_drop();

		dslc_generate_code();

		// Catch keypress events (from both parent and iframe) to add keyboard support
		dslc_keypress_events();
		LiveComposer.Builder.UI.initPreviewAreaScroller();
	};
});

/**
 * Action - "Currently Editing" scroll on click
 */

jQuery(document).on( 'click', '.dslca-currently-editing', function(){

	var activeElement = false,
	newOffset = false,
	outlineColor;

	if ( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).length ) {

		activeElement = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument);
		outlineColor = '#5890e5';

	} else if ( jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).length ) {

		activeElement = jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument);
		outlineColor = '#eabba9';
	}

	if ( activeElement ) {
		newOffset = activeElement.offset().top - 100;
		if ( newOffset < 0 ) { newOffset = 0; }

		var callbacks = [];

		jQuery( 'html, body', LiveComposer.Builder.PreviewAreaDocument ).animate({ scrollTop: newOffset }, 300, function(){
			activeElement.removeAttr('style');
		});
	}

});

/**
 * Save composer code with CMD+S or Ctrl+S
 */
jQuery(window).keypress( function(e){

	if ((e.metaKey || e.ctrlKey) && e.keyCode == 83) {

		dslc_ajax_save_composer();
		e.preventDefault();
        return false;
	}
});

/**
 * Hook - Hide Composer
 */

jQuery(document).on( 'click', '.dslca-hide-composer-hook', function(e){

	e.preventDefault();
	dslc_hide_composer()
});

/**
 * Hook - Show Composer
 */

jQuery(document).on( 'click', '.dslca-show-composer-hook', function(e){
	e.preventDefault();
	dslc_show_composer();
});

/**
 * Hook - Section Show - Modules Listing
 */

jQuery(document).on( 'click', '.dslca-go-to-modules-hook', function(e){
	e.preventDefault();
	dslc_show_section( '.dslca-modules' );
});

/**
 * Hook - Section Show - Dynamic
 */

jQuery(document).on( 'click', '.dslca-go-to-section-hook', function(e){

	e.preventDefault();

	// Do nothing if clicked on active tab
	if ( jQuery(this).hasClass('dslca-active') ) {

		return;
	}

	var sectionTitle = jQuery(this).data('section');
	dslc_show_section( sectionTitle );

	if ( jQuery(this).hasClass('dslca-go-to-section-modules') || jQuery(this).hasClass('dslca-go-to-section-templates')  ) {

		jQuery(this).addClass('dslca-active').siblings('.dslca-go-to-section-hook').removeClass('dslca-active');
	}
});

/**
 * Hook - Close Composer
 */

jQuery(document).on( 'click', '.dslca-close-composer-hook', function(e){

	e.preventDefault();

	var redirect_url = jQuery(this).attr('href');

	if ( ! jQuery('body').hasClass('dslca-saving-in-progress') ) {

		LiveComposer.Builder.UI.CModalWindow({

			title: DSLCString.str_exit_title,
			content: DSLCString.str_exit_descr,
			confirm: function() {
				window.location = redirect_url;
			}
		});

		/*dslc_js_confirm( 'disable_lc', '<span class="dslca-prompt-modal-title">' +
			DSLCString.str_exit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_exit_descr + '</span>', jQuery(this).attr('href') );*/
	}
});

/**
 * Submit Form
 */

jQuery(document).on( 'click', '.dslca-submit', function(){

	jQuery(this).closest('form').submit();

});

/**
 * Hook - Show Origin Filters
 */

jQuery(document).on( 'click', '.dslca-section-title', function(e){

	e.stopPropagation();

	if ( jQuery('.dslca-section-title-filter', this).length ) {

		dslc_generate_filters();

		// Open filter panel
		jQuery('.dslca-section-title-filter-options').slideToggle(300);
	}
});

/**
 * Hook - Apply Filter Origin
 */

jQuery(document).on( 'click', '.dslca-section-title-filter-options a', function(e){

	e.preventDefault();
	e.stopPropagation();

	var origin = jQuery(this).data('origin');
	var section = jQuery(this).closest('.dslca-section');

	if ( section.hasClass('dslca-templates-load') ) {

		jQuery('.dslca-section-title-filter-curr', section).text( jQuery(this).text());
	} else {

		jQuery('.dslca-section-title-filter-curr', section).text( jQuery(this).text());
	}

	jQuery('.dslca-section-scroller-inner').css({ left : 0 });

	dslc_filter_origin( origin, section );

	// Close filter panel
	jQuery('.dslca-section-title-filter-options').slideToggle(300);
});


/**
 * UI - GENERAL - Hide Composer
 */

function dslc_hide_composer() {

	if ( dslcDebug ) console.log( 'dslc_hide_composer' );

	// Hide "hide" button and show "show" button
	jQuery('.dslca-hide-composer-hook').hide();
	jQuery('.dslca-show-composer-hook').show();

	// Add class to know it's hidden
	jQuery('body').addClass('dslca-composer-hidden');
	jQuery('body', LiveComposer.Builder.PreviewAreaDocument).addClass('dslca-composer-hidden');


	// Hide ( animation ) the main composer area ( at the bottom )
	jQuery('.dslca-container').css({ bottom : jQuery('.dslca-container').outerHeight() * -1 });

	// Hide the header  part of the main composer area ( at the bottom )
	jQuery('.dslca-header').hide();

}

/**
 * UI - GENERAL - Show Composer
 */

function dslc_show_composer() {

	if ( dslcDebug ) console.log( 'dslc_show_composer' );

	// Hide the "show" button and show the "hide" button
	jQuery('.dslca-show-composer-hook').hide();
	jQuery('.dslca-hide-composer-hook').show();

	// Remove the class from the body so we know it's not hidden
	jQuery('body').removeClass('dslca-composer-hidden');
	jQuery('body', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-composer-hidden');


	// Show ( animate ) the main composer area ( at the bottom )
	jQuery('.dslca-container').css({ bottom : 0 });

	// Show the header of the main composer area ( at the bottom )
	jQuery('.dslca-header').show();
}

/**
 * UI - GENERAL - Show Publish Button
 */

function dslc_show_publish_button() {

	if ( dslcDebug ) console.log( 'dslc_show_publish_button' );

	jQuery('.dslca-save-composer').show().addClass('dslca-init-animation');
	jQuery('.dslca-save-draft-composer').show().addClass('dslca-init-animation');
}

function dslc_hide_publish_button() {

	if ( dslcDebug ) console.log( 'dslc_hide_publish_button' );

	jQuery('.dslca-save-composer').hide();
	jQuery('.dslca-save-draft-composer').hide();
}

/**
 * UI - GENERAL - Show Section
 */

function dslc_show_section( section ) {

	if ( dslcDebug ) console.log( 'dslc_show_section' );

	// Add class to body so we know it's in progress
	// jQuery('body').addClass('dslca-anim-in-progress');

	// Get vars
	var sectionTitle = jQuery(section).data('title'),
	newColor = jQuery(section).data('bg');

	// Hide ( animate ) the container
	jQuery('.dslca-container').css({ bottom: -500 });

	// Hide all sections and show specific section
	jQuery('.dslca-section').hide();
	jQuery(section).show();

	// Change "currently editing"
	if ( section == '.dslca-module-edit' ) {

		jQuery('.dslca-currently-editing')
			.show()
				.find('strong')
				.text( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).attr('title') + ' element' );
	} else if ( section == '.dslca-modules-section-edit' ) {

		jQuery('.dslca-currently-editing')
			.show()
			.css( 'background-color', '#e5855f' )
				.find('strong')
				.text( 'Row' );
	} else {

		jQuery('.dslca-currently-editing')
			.hide()
				.find('strong')
				.text('');
	}

	// Filter module option tabs
	dslc_module_options_tab_filter();

	// Show ( animate ) the container
	// setTimeout( function() {
		jQuery('.dslca-container').css({ bottom : 0 });
	// }, 300 );

	// Remove class from body so we know it's finished
	// jQuery('body').removeClass('dslca-anim-in-progress');

	// Set initial background color for the color picker fields
	// Fixes the bug with section color pickers to keep values from the previously
	// edited section.
	jQuery(section).find('input.dslca-module-edit-field-colorpicker').each( function (item) {
		jQuery(this).css('background', jQuery(this).val());
	});
}

/**
 * UI - GENERAL - Generate Origin Filters
 */

function dslc_generate_filters() {

	if ( dslcDebug ) console.log( 'dslc_generate_filters' );

	// Vars
	var el, filters = [], filtersHTML = '<a html="#" data-origin="">Show All</a>', els = jQuery('.dslca-section:visible .dslca-origin');

	// Go through each and generate the filters
	els.each(function(){
		el = jQuery(this);

		if ( jQuery.inArray( el.data('origin'), filters ) == -1 ) {
			filters.push( el.data('origin') );
			filtersHTML += '<a href="#" data-origin="' + el.data('origin') + '">' + el.data('origin') + '</a>';
		}
	});

	jQuery('.dslca-section:visible .dslca-section-title-filter-options').html( filtersHTML ).css( 'background', jQuery('.dslca-section:visible').data('bg') );
}

/**
 * UI - GENERAL - Origin Filter
 */

function dslc_filter_origin( origin, section ) {

	if ( dslcDebug ) console.log( 'dslc_filter_origin' );

	jQuery('.dslca-origin', section).attr('data-display-module', 'false');
	jQuery('.dslca-origin[data-origin="' + origin + '"]', section).attr('data-display-module', 'true');

	if ( origin == '' ) {

		jQuery('.dslca-origin', section).attr('data-display-module', 'true');
		jQuery('.dslca-origin.dslca-exclude', section).attr('data-display-module', 'false')
	}
}


/**
 * UI - General - Initiate Drag and Drop Functonality
 */

function dslc_drag_and_drop() {

	if ( dslcDebug ) console.log( 'dslc_drag_and_drop' );

	var modulesSection, modulesArea, moduleID, moduleOutput;

	// Drag and Drop for module icons from the list of modules
	var modules_list = jQuery('.dslca-modules .dslca-section-scroller-content'); // Groups that can hold modules
	// jQuery(modules_list).each(function (i,e) {

	if( modules_list.length == 0 ) {

		modules_list = [ document.createElement( 'div' ) ];
	}

	var modules_list_sortable = Sortable.create(modules_list[0], {
		sort: false, // do not allow sorting inside the list of modules
		group: { name: 'modules', pull: 'clone', put: false },
		animation: 150,
		handle: '.dslca-module',
		draggable: '.dslca-module',
		// ghostClass: 'dslca-module-placeholder',
		chosenClass: 'dslca-module-dragging',
		scroll: true, // or HTMLElement
		scrollSensitivity: 150, // px, how near the mouse must be to an edge to start scrolling.
		scrollSpeed: 15, // px


		setData: function (dataTransfer, dragEl) {
		//dragEl – contains html of the draggable element like:
		//<div class="dslca-module dslca-scroller-item dslca-origin dslca-origin-General" data-id="DSLC_Button" data-origin="General" draggable="false" style="">

			  // dataTransfer.setData('Text', dragEl.textContent);
			dataTransfer.setData(LiveComposer.Utils.msieversion() !== false ? 'Text' : 'text/html', dragEl.innerHTML);
		},

		// dragging started
		onStart: function (/**Event*/evt) {
			evt.oldIndex;  // element index within parent

			// jQuery( '.dslc-modules-area' ).sortable( "refreshPositions" );
			jQuery('body').removeClass('dslca-new-module-drag-not-in-progress').addClass('dslca-new-module-drag-in-progress');
			jQuery('body', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-new-module-drag-not-in-progress').addClass('dslca-new-module-drag-in-progress');
			jQuery('#dslc-header').addClass('dslca-header-low-z-index');
		},

		// dragging ended
		onEnd: function (/**Event*/evt) {
			evt.oldIndex;  // element's old index within parent
			evt.newIndex;  // element's new index within parent

			var itemEl = evt.item;  // dragged HTML
			evt.preventDefault();
			// evt.stopPropagation();
			//return false;

			// Prevent drop into modules listing
			if(jQuery(itemEl).closest('.dslca-section-scroller-content').length > 0) return false;

			jQuery( '.dslca-options-hovered', LiveComposer.Builder.PreviewAreaDocument ).removeClass('dslca-options-hovered');

			// Vars
			modulesArea = jQuery(itemEl.parentNode); //jQuery(this);
			moduleID = itemEl.dataset.id; // get value of data-id attr.

			dslc_generate_code();

			if ( moduleID == 'DSLC_M_A' || jQuery('body').hasClass('dslca-module-drop-in-progress') ||
				modulesArea.closest('#dslc-header').length || modulesArea.closest('#dslc-footer').length ) {

				// nothing

			} else {

				jQuery('body').addClass('dslca-module-drop-in-progress');

				// Add padding to modules area
				/*
				if ( modulesArea.hasClass('dslc-modules-area-not-empty') )
					modulesArea.animate({ paddingBottom : 50 }, 150);
				*/

				// TODO: Optimize expensive ajax call in this function!
				// Load Output
				dslc_module_output_default( moduleID, function( response ){

					// Append Content
					moduleOutput = response.output;

					// Remove extra padding from area
					// modulesArea.css({ paddingBottom : 0 });

					// Add output
					// TODO: optimize jQuery in the string below

					var dslcJustAdded = LiveComposer.
										Builder.
										Helpers.
										insertModule( moduleOutput, jQuery('.dslca-module', modulesArea) );


					setTimeout( function(){
						LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();
						jQuery('body').removeClass('dslca-module-drop-in-progress');
					}, 700 );

					// "Show" no content text
					jQuery('.dslca-no-content-primary', modulesArea ).css({ opacity : 1 });

					// "Show" modules area management
					jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'visible' });

					// Generete
					LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
					LiveComposer.Builder.PreviewAreaWindow.dslc_tabs();
					LiveComposer.Builder.PreviewAreaWindow.dslc_init_accordion();

					dslc_generate_code();
					// Show publish
					dslc_show_publish_button();

					LiveComposer.Builder.UI.initInlineEditors();
				});

				// Loading animation

				// Show loader – Not used anymore.
				// jQuery('.dslca-module-loading', modulesArea).show();

				// Change module icon to the spinning loader.
				jQuery(itemEl).find('.dslca-icon').attr('class', '').attr('class', 'dslca-icon dslc-icon-refresh dslc-icon-spin');


				// Hide no content text
				jQuery('.dslca-no-content-primary', modulesArea).css({ opacity : 0 });

				// Hide modules area management
				jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'hidden' });

				// Animate loading
				/*
				var randomLoadingTime = Math.floor(Math.random() * (100 - 50 + 1) + 50) * 100;
				jQuery('.dslca-module-loading-inner', modulesArea).css({ width : 0 }).animate({
					width : '100%'
				}, randomLoadingTime, 'linear' );
				*/
			}

			LiveComposer.Builder.UI.stopScroller();
			jQuery('body').removeClass('dslca-new-module-drag-in-progress').addClass('dslca-new-module-drag-not-in-progress');
			jQuery('body', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-new-module-drag-in-progress').addClass('dslca-new-module-drag-not-in-progress');
			jQuery('#dslc-header').removeClass('dslca-header-low-z-index');
		},

		// Element is dropped into the list from another list
		onAdd: function (/**Event*/evt) {
			var itemEl = evt.item;  // dragged HTMLElement
			evt.from;  // previous list
			// + indexes from onEnd
			// evt.preventDefault();
		},

		// Changed sorting within list
		onUpdate: function (/**Event*/evt) {
			var itemEl = evt.item;  // dragged HTMLElement
			// + indexes from onEnd
			dslc_show_publish_button();
			// evt.preventDefault();
		},

		// Called by any change to the list (add / update / remove)
		onSort: function (/**Event*/evt) {
			// same properties as onUpdate
			evt.preventDefault();
			// evt.stopPropagation(); return false;
		},

		// Element is removed from the list into another list
		onRemove: function (/**Event*/evt) {
			  // same properties as onUpdate
		},

		// Attempt to drag a filtered element
		onFilter: function (/**Event*/evt) {
			var itemEl = evt.item;  // HTMLElement receiving the `mousedown|tapstart` event.
		},

		// Event when you move an item in the list or between lists
		onMove: function (/**Event*/evt) {
			// Example: http://jsbin.com/tuyafe/1/edit?js,output
			evt.dragged; // dragged HTMLElement
			evt.draggedRect; // TextRectangle {left, top, right и bottom}
			evt.related; // HTMLElement on which have guided
			evt.relatedRect; // TextRectangle
			// return false; — for cancel
			jQuery( evt.to ).addClass('dslca-options-hovered');
		}
	});
}

/**
 * Deprecated Functions and Fallbacks
 */

function dslc_option_changed() { dslc_show_publish_button(); }
function dslc_module_dragdrop_init() { dslc_drag_and_drop(); }


/**
 * Prevent drag and drop of the modules
 * into the inner content areas of the other modules
 */
function dslc_fix_contenteditable() {

	LiveComposer.Builder.PreviewAreaDocument.on('dragstart', '.dslca-module, .dslc-module-front, .dslc-modules-area, .dslc-modules-section', function (e) {

		jQuery('[contenteditable]', LiveComposer.Builder.PreviewAreaDocument).attr('contenteditable', false);
	});

	LiveComposer.Builder.PreviewAreaDocument.on('dragend mousedown', '.dslca-module, .dslc-module-front, .dslc-modules-area, .dslc-modules-section', function (e) {

		jQuery('[contenteditable]', LiveComposer.Builder.PreviewAreaDocument).attr('contenteditable', true);
	});
}

/**
 * Disable/Enable module control.
 *
 * @param  {string} control_id CSS ID of the control we are toggling
 * @return {void}
 */
function dslc_toogle_control ( control_id ) {

	if ( control_id === undefined) control_id = false;
	if ( !control_id ) return;

	var control         = jQuery('.dslca-module-edit-option-' + control_id );
	var control_storage = control.find('.dslca-module-edit-field');

	// Get the element we are editing
	var module = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument);

	// Get the element id
	var module_id = module[0].id;

	var responsive_prefix = '';

	if ( 'tablet_responsive' === control.data('tab') ) {
		responsive_prefix = 'body.dslc-res-tablet ';
	} else if ( 'phone_responsive' === control.data('tab') ) {
		responsive_prefix = 'body.dslc-res-phone ';
	}

	var affect_on_change_el = control_storage.data('affect-on-change-el');

	if ( affect_on_change_el === undefined) return;

	var affect_on_change_elmts = affect_on_change_el.split( ',' );

	affect_on_change_el = '';

	// Loop through elements (useful when there are multiple elements)
	for ( var i = 0; i < affect_on_change_elmts.length; i++ ) {

		if ( i > 0 ) {

			affect_on_change_el += ', ';
		}

		affect_on_change_el += responsive_prefix + '#' + module_id + ' ' + affect_on_change_elmts[i];
	}

	var affect_on_change_rule  = control_storage.data('affect-on-change-rule').replace(/ /g,'');
	var affect_on_change_rules = affect_on_change_rule.split( ',' );

	var control_value;
	var control_data_ext = control_storage.data('ext');

	control.toggleClass('dslca-option-off');

	if ( control.hasClass('dslca-option-off')) {
		// Disable

		control_value = dslc_get_control_value(control_id);
		// Temporary backup the current value as data attribute
		control_storage.data( 'val-bckp', control_value );
		// control_value = dslc_combine_value_and_extension( control_value, control_data_ext);

		// Loop through rules (useful when there are multiple rules)
		for ( var i = 0; i < affect_on_change_rules.length; i++ ) {

			// remove css rule in element inline style
			jQuery( affect_on_change_el, LiveComposer.Builder.PreviewAreaDocument ).css( affect_on_change_rules[i] , '' );
			// remove css rule in css block
			disable_css_rule ( affect_on_change_el, affect_on_change_rules[i], module_id);
			// PROBLEM do not work with multiply rules ex.: .dslc-text-module-content,.dslc-text-module-content p
		}

		control_storage.val('').trigger('change');
	} else {
		// Enable

		// Restore value of the data backup attribute
		control_storage.val( control_storage.data('val-bckp') ).trigger('change');
		control_value = dslc_get_control_value(control_id);
		control_value = dslc_combine_value_and_extension( control_value, control_data_ext || '');

		// Loop through rules (useful when there are multiple rules)
		for ( var i = 0; i < affect_on_change_rules.length; i++ ) {

			var styleContent = affect_on_change_el + "{" + affect_on_change_rules[i] + ": " + control_value + "}";

			LiveComposer.Builder.Helpers.processInlineStyleTag({

				context: control,
				rule: affect_on_change_rules[i],
				elems: affect_on_change_el.replace(new RegExp('#' + module_id, 'gi'), '').trim(),
				styleContent: styleContent
			});
		}
	}
}

jQuery(document).ready(function($){

	// Option Control Toggle
	jQuery(document).on( 'click', '.dslca-module-edit-option .dslc-control-toggle', function(e){

		e.preventDefault();
		var control_id = jQuery(e.target).closest('.dslca-module-edit-option').find('.dslca-module-edit-field').data('id');
		dslc_toogle_control ( control_id );
	});


	// Disable Toggle If the Control Focused
	jQuery(document).on( 'mousedown', '.dslca-module-edit-option', function(e){

		var toggle = $('.dslc-control-toggle');
		if ( ! toggle.is(e.target) // if the target of the click isn't the container...
		     && toggle.has(e.target).length === 0 ) // ... nor a descendant of the container
		{

			if ( jQuery(e.target).closest('.dslca-module-edit-option').hasClass('dslca-option-off') ) {

				var control_id = $(e.target).closest('.dslca-module-edit-option').find('.dslca-module-edit-field').data('id');
				dslc_toogle_control (control_id);
			}
		}
	});

/* Reset all styling – not ready

	$(document).on( 'click', '.dslca-clear-styling-button', function(e){
		e.preventDefault();


		$('.dslca-option-with-toggle').each(function(e){
			// var control_id = $(this).find('.dslca-module-edit-field').data('id');
			$(this).find('.dslca-module-edit-field').val('').trigger('change');
		});

		dslc_module_output_altered(); // call module regeneration

	});
*/
});

// Very Slow do not use for live editing
// Only use when you need to disable some of the CSS properties.

function disable_css_rule(selectorCSS, ruleCSS, moduleID) {

	var cssRules;
	var target_stylsheet_ID = 'css-for-' + moduleID;
	var stylesheet = document.getElementById('page-builder-frame').contentWindow.document.getElementById(target_stylsheet_ID);

	selectorCSS = selectorCSS.replace( /\s\s+/g, ' ' );

	if (stylesheet) {

	   stylesheet = stylesheet.sheet;

		if (stylesheet['rules']) {

			cssRules = 'rules';
		} else if (stylesheet['cssRules']) {

			cssRules = 'cssRules';
		} else {

			//no rules found... browser unknown
		}

		// Go through each CSS rule (ex.: .content h1 {...})
		for (var R = 0; R < stylesheet[cssRules].length; R++) {

			// Is current CSS rule equal to the selectorCSS we are looking for?
			// (ex.: '.content h1' == '.content h1' )
			if (stylesheet[cssRules][R].selectorText == selectorCSS) {

				// Get CSS property we are looking for... (ex.: font-size : ...; )
				if(stylesheet[cssRules][R].style[ruleCSS]){

						stylesheet[cssRules][R].style[ruleCSS] = '';
					break;
				}
			}
		}
	}
}

function dslc_combine_value_and_extension ( value, extension) {

	if ( '' === value || null === value ) {

		return value;
	}

	// Check if value do not already include extension
	if ( value.indexOf(extension) == -1 ) {

		value = value + extension;
	}

	return value;
}

function dslc_get_control_value ( control_id ) {

	var control      = jQuery('.dslca-module-edit-option-' + control_id );
	var control_type = 'text';
	var control_storage = control.find('.dslca-module-edit-field');
	var value;

/*
	if ( control.hasClass('dslca-module-edit-option-select') ) {

	} else {
		// text based controls
		value = control_storage.val();
	}
*/
	value = control_storage.val();

	return value;
}

/**
 * Bind keypress events with both parent and iframe pages.
 * Function called when content inside iframe is loaded.
 *
 * @return {void}
 */
function dslc_keypress_events() {

	jQuery( [document, LiveComposer.Builder.PreviewAreaWindow.document ] ).unbind('keydown').bind('keydown', function (keydown_event) {

		// Modal window [ESC]/[Enter]
		dslc_modal_keypress_events(keydown_event);

		// Prevent backspace from navigating back
		dslc_disable_backspace_navigation(keydown_event);

		// Prompt Modal on F5
		dslc_notice_on_refresh(keydown_event);

		// Save Page
		dslc_save_page(keydown_event);
	});
}

/**
 * Action - Prevent backspace from navigating back
 */

function dslc_disable_backspace_navigation (event) {

	var doPrevent = false;

	if (event.keyCode === 8) {

		var d = event.srcElement || event.target;

		if ( (d.tagName.toUpperCase() === 'INPUT' && (
				d.type.toUpperCase() === 'TEXT' ||
				d.type.toUpperCase() === 'PASSWORD' ||
				d.type.toUpperCase() === 'NUMBER' ||
				d.type.toUpperCase() === 'FILE')
			  )
			 || d.tagName.toUpperCase() === 'TEXTAREA'
			 || jQuery(d).hasClass('dslca-editable-content')
			 || jQuery(d).hasClass('dslc-tabs-nav-hook-title')
			 || jQuery(d).hasClass('dslc-accordion-title') ) {

			doPrevent = d.readOnly || d.disabled;
		} else {

			doPrevent = true;
		}
	}

	if (doPrevent) {
		event.preventDefault();
	}
}

/**
 * Actions - Prompt Modal on F5
 *
 * 116 – F5
 * 81 + event.metaKey = CMD + R
 */

function dslc_notice_on_refresh(e) {

	if ( e.which == 116 || ( e.which === 82 && e.metaKey ) ) {

		if ( jQuery('.dslca-save-composer-hook').offsetParent !== null || jQuery('.dslca-module-edit-save').offsetParent !== null ) {

			e.preventDefault();
			LiveComposer.Builder.UI.CModalWindow({

				title: DSLCString.str_refresh_title,
				content: DSLCString.str_refresh_descr,
				confirm: function() {

					window.location.reload();
				}
			});

			/*dslc_js_confirm( 'disable_lc', '<span class="dslca-prompt-modal-title">' + DSLCString.str_refresh_title +
			 '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_refresh_descr + '</span>', document.URL );*/
		}
	}
}

/**
 * If Control or Command key is pressed and the S key is pressed run dslc_save_composer.
 * 83 is the key code for S.
 */
function dslc_save_page(e) {

    if ( e.which == 83 && ( e.metaKey || e.ctrlKey )  ) {
    	if ( jQuery('.dslca-save-composer-hook').css('display') == 'block' ) {
	        dslc_save_composer();
	        e.preventDefault();
	        return false;
	    }
    }
}

/**
 * Generate report about JS error and save it in a local storage.
 * @param  String error Error text
 * @param  String file  File with error
 * @param  String line  Line with error
 * @param  String char  Column with error
 * @return void
 */
function dslca_generate_error_report ( error, file, line, char ) {

	var title = 'JavaScript error detected in a third-party plugin';

	if ( file.match("wp-content\/plugins\/live-composer-page-builder\/js") != null ) {

		title = 'Live Composer returned JS error';
	}

	var error_report = '';
	error_report += '<br /><strong style="color:#E55F5F;">' + title + '</strong><br />';
	error_report += error + '<br /> File "' + file + '", line ' + line + ', char ' + char + '<br />';

	if ( 'undefined' !== typeof(Storage)) {
		localStorage.setItem('js_errors_report', error_report);
	}
}

/**
 * Put in a hidden div#dslca-js-errors-report information from local storage
 * @return void
 */
function dslca_update_report_log() {

	var errors_container = document.getElementById('dslca-js-errors-report');
	var error_report = localStorage.getItem('js_errors_report');

	if ( null !== error_report ) {
		errors_container.value = error_report;
		localStorage.removeItem('js_errors_report');
		document.querySelector( '.dslca-show-js-error-hook' ).setAttribute('style','visibility:visible');
	}
}


// ============================================================
jQuery(document).on('editorFrameLoaded', function(){

	var $ = jQuery;
	var headerFooter = $('div[data-hf]', LiveComposer.Builder.PreviewAreaDocument);
	var overlay = '';

	headerFooter.each(function(index, el) {
		var linkToEdit = $(el).data('editing-link');
		var hfType = $(el).data('editing-type');
		var editingLabel = $(el).data('editing-label');
		var editingSubLabel = $(el).data('editing-sublabel');

		overlay += '<div class="dslc-hf-block-overlay"><a target="_blank" href="' + linkToEdit + '" class="dslc-hf-block-overlay-button dslca-link">' + editingLabel + '</a>';
		if ( editingSubLabel !== undefined ) {
			overlay += ' <span class="dslc-hf-block-overlay-text">' + editingSubLabel + '</span>';
		}
		overlay += '</div>';

		var htmlObject = document.createElement('div');
		htmlObject.innerHTML = overlay;

		el.append( htmlObject );
	});

});