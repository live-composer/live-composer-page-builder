
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

/**
 * UI - GENERAL - Document Ready
 */

jQuery(document).ready(function($) {

 	// On iframe loaded
 	jQuery("#page-builder-frame").on('load', function(){

 		var self = this;
 		DSLC.Editor.frameContext = this.contentWindow;
 		DSLC.Editor.frame = jQuery(this).contents();

 		// Disable WP admin bar in editing mode
 		jQuery('#wpadminbar', DSLC.Editor.frame).remove();
 		jQuery('body', DSLC.Editor.frame).addClass('dslca-enabled dslca-drag-not-in-progress');

 		DSLC.Editor.initMediumEditor();
 		dslc_fix_contenteditable();

 		var mainDraggable = DSLC.Editor.frame.find("#dslc-main").eq(0)[0];
 		new DSLC.Editor.CSectionsContainer( mainDraggable );

 		jQuery(document).trigger('editorFrameLoaded');

 		dslc_drag_and_drop();
 		dslc_generate_code();

 	});

 	jQuery('body').addClass('dslca-enabled dslca-drag-not-in-progress');
 	jQuery('.dslca-invisible-overlay').hide();
 	jQuery('.dslca-section').eq(0).show();

});


/**
 * Action - "Currently Editing" scroll on click
 */

jQuery(document).on( 'click', '.dslca-currently-editing', function(){

	var activeElement = false,
	newOffset = false,
	outlineColor;

	if ( jQuery('.dslca-module-being-edited', DSLC.Editor.frame).length ) {

		activeElement = jQuery('.dslca-module-being-edited', DSLC.Editor.frame);
		outlineColor = '#5890e5';
	} else if ( jQuery('.dslca-modules-section-being-edited', DSLC.Editor.frame).length ) {

		activeElement = jQuery('.dslca-modules-section-being-edited', DSLC.Editor.frame);
		outlineColor = '#eabba9';
	}

	if ( activeElement ) {
		newOffset = activeElement.offset().top - 100;
		if ( newOffset < 0 ) { newOffset = 0; }

		var callbacks = [];

		jQuery( 'html, body', DSLC.Editor.frame ).animate({ scrollTop: newOffset }, 300, function(){
			activeElement.animate( { 'outline-color' : outlineColor }, 70, function(){
				activeElement.animate({ 'outline-color' : 'transparent' }, 70, function(){
					activeElement.animate( { 'outline-color' : outlineColor }, 70, function(){
						activeElement.animate({ 'outline-color' : 'transparent' }, 70, function(){
							activeElement.removeAttr('style');
						});
					});
				});
			});
		});
	}

});

/**
 * Hook - Hide Composer
 */

jQuery(document).on( 'click', '.dslca-hide-composer-hook', function(){

	dslc_hide_composer()
});

/**
 * Hook - Show Composer
 */

jQuery(document).on( 'click', '.dslca-show-composer-hook', function(){

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

	if ( ! jQuery('body').hasClass('dslca-saving-in-progress') ) {

		dslc_js_confirm( 'disable_lc', '<span class="dslca-prompt-modal-title">' +
			DSLCString.str_exit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_exit_descr + '</span>', jQuery(this).attr('href') );
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
		jQuery('.dslca-section-title-filter-options').slideToggle(300);
	}
});

/**
 * Hook - Apply Filter Origin
 */

jQuery(document).on( 'click', '.dslca-section-title-filter-options span', function(e){

	e.stopPropagation();

	var origin = jQuery(this).data('origin');
	var section = jQuery(this).closest('.dslca-section');

	if ( section.hasClass('dslca-templates-load') ) {

		jQuery('.dslca-section-title-filter-curr', section).text( $(this).text());
	} else {

		jQuery('.dslca-section-title-filter-curr', section).text( $(this).text());
	}

	jQuery('.dslca-section-scroller-inner').css({ left : 0 });

	dslc_filter_origin( origin, section );
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

/**
 * UI - GENERAL - Show Section
 */

function dslc_show_section( section ) {

	if ( dslcDebug ) console.log( 'dslc_show_section' );

	// Add class to body so we know it's in progress
	jQuery('body').addClass('dslca-anim-in-progress');

	// Get vars
	var sectionTitle = jQuery(section).data('title'),
	newColor = jQuery(section).data('bg');

	// Hide ( animate ) the container
	jQuery('.dslca-container').css({ bottom: -500 });

	// Change the section color
	jQuery('.dslca-sections').animate({ backgroundColor : newColor }, 200);

	// Hide all sections and show specific section
	jQuery('.dslca-section').hide();
	jQuery(section).show();

	// Initiate row scrollbar if editing ar row
	if ( section == '.dslca-modules-section-edit' ) { dslc_row_edit_scrollbar_init(); }

	// Change "currently editing"
	if ( section == '.dslca-module-edit' ) {

		jQuery('.dslca-currently-editing')
			.show()
				.find('strong')
				.text( jQuery('.dslca-module-being-edited', DSLC.Editor.frame).attr('title') + ' element' );
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

	// Initiate scroller ( if not module options edit section )
	if ( section != '.dslca-module-edit' ) { dslc_scroller_init(); }

	// Show ( animate ) the container
	setTimeout( function() {
		jQuery('.dslca-container').css({ bottom : 0 });
	}, 300 );

	// Remove class from body so we know it's finished
	jQuery('body').removeClass('dslca-anim-in-progress');
}

/**
 * UI - GENERAL - Generate Origin Filters
 */

function dslc_generate_filters() {

	if ( dslcDebug ) console.log( 'dslc_generate_filters' );

	// Vars
	var el, filters = [], filtersHTML = '<span data-origin="">Show All</span>', els = jQuery('.dslca-section:visible .dslca-origin');

	// Go through each and generate the filters
	els.each(function(){
		el = jQuery(this);

		if ( jQuery.inArray( el.data('origin'), filters ) == -1 ) {
			filters.push( el.data('origin') );
			filtersHTML += '<span data-origin="' + el.data('origin') + '">' + el.data('origin') + '</span>';
		}
	});

	jQuery('.dslca-section:visible .dslca-section-title-filter-options').html( filtersHTML ).css( 'background', jQuery('.dslca-section:visible').data('bg') );
}

/**
 * UI - GENERAL - Origin Filter
 */

function dslc_filter_origin( origin, section ) {

	if ( dslcDebug ) console.log( 'dslc_filter_origin' );

	jQuery('.dslca-origin', section).hide();
	jQuery('.dslca-origin[data-origin="' + origin + '"]', section).show();

	if ( origin == '' ) {
		jQuery('.dslca-origin', section).show();
	}

	dslc_scroller_init();
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

	var modules_list_sortable = Sortable.create( modules_list[0] , {
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
			  dataTransfer.setData('text/html', dragEl.innerHTML);
		},

		// dragging started
		onStart: function (/**Event*/evt) {
			evt.oldIndex;  // element index within parent

			// jQuery( '.dslc-modules-area' ).sortable( "refreshPositions" );
			jQuery('body').removeClass('dslca-new-module-drag-not-in-progress').addClass('dslca-new-module-drag-in-progress');
			jQuery('#dslc-header').addClass('dslca-header-low-z-index');
		},

		// dragging ended
		onEnd: function (/**Event*/evt) {
			evt.oldIndex;  // element's old index within parent
			evt.newIndex;  // element's new index within parent

			var itemEl = evt.item;  // dragged HTMLElement
			// evt.preventDefault();
			// evt.stopPropagation();
			//return false;

			// Prevent drop into modules listing
			if(itemEl.closest('.dslca-section-scroller-content')) return false;

			jQuery( '.dslca-options-hovered', DSLC.Editor.frame ).removeClass('dslca-options-hovered');

			// Vars
			modulesArea = jQuery(itemEl.parentNode); //jQuery(this);
			moduleID = itemEl.dataset.id; // get value of data-id attr.

			dslc_generate_code();

			if ( moduleID == 'DSLC_M_A' || jQuery('body').hasClass('dslca-module-drop-in-progress') ||
				modulesArea.closest('#dslc-header').length || modulesArea.closest('#dslc-footer').length ) {

				// nothing

			} else {

				jQuery('body').addClass('dslca-anim-in-progress dslca-module-drop-in-progress');

				// Add padding to modules area
				/*
				if ( modulesArea.hasClass('dslc-modules-area-not-empty') )
					modulesArea.animate({ paddingBottom : 50 }, 150);
				*/

				// Load Output
				dslc_module_output_default( moduleID, function( response ){

					// Append Content
					moduleOutput = response.output;

					// Remove extra padding from area
					// modulesArea.css({ paddingBottom : 0 });

					// Hide loader
					jQuery('.dslca-module-loading', modulesArea ).hide();

					// Add output
					// TODO: optimize jQuery in the string below
					var dslcJustAdded = jQuery(moduleOutput).insertAfter( jQuery('.dslca-module', modulesArea) ) ; /*.appendTo(modulesArea);*/
					jQuery('.dslca-module', modulesArea).remove();

					dslcJustAdded.css({
						'-webkit-animation-name' : 'dslcBounceIn',
						'-moz-animation-name' : 'dslcBounceIn',
						'animation-name' : 'dslcBounceIn',
						'animation-duration' : '0.6s',
						'-webkit-animation-duration' : '0.6s'
					});

					setTimeout( function(){
						dslc_init_square();
						dslc_center();
						dslc_masonry( dslcJustAdded );
						jQuery('body').removeClass('dslca-anim-in-progress dslca-module-drop-in-progress');
					}, 700 );

					// "Show" no content text
					jQuery('.dslca-no-content-primary', modulesArea ).css({ opacity : 1 });

					// "Show" modules area management
					jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'visible' });

					// Show publish
					jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
					jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

					// Generete
					dslc_carousel();
					dslc_tabs();
					dslc_init_accordion();
					dslc_init_square();
					dslc_center();
					dslc_generate_code();
					dslc_show_publish_button();

					DSLC.Editor.initMediumEditor();
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
				var randomLoadingTime = Math.floor(Math.random() * (100 - 50 + 1) + 50) * 100;
				jQuery('.dslca-module-loading-inner', modulesArea).css({ width : 0 }).animate({
					width : '100%'
				}, randomLoadingTime, 'linear' );
			}

			jQuery('body').removeClass('dslca-new-module-drag-in-progress').addClass('dslca-new-module-drag-not-in-progress');
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

	DSLC.Editor.frame.on('dragstart', '.dslca-module, .dslc-module-front, .dslc-modules-area, .dslc-modules-section', function (e) {

		jQuery('[contenteditable]', DSLC.Editor.frame).attr('contenteditable', false);
	});

	DSLC.Editor.frame.on('dragend', '.dslca-module, .dslc-module-front, .dslc-modules-area, .dslc-modules-section', function (e) {

		jQuery('[contenteditable]', DSLC.Editor.frame).attr('contenteditable', true);
	});
}