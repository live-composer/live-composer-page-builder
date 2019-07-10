/**
 * UI - General - Initiate Drag and Drop Functonality
 */

import { moduleOutputDefault } from "./module.js";
import Sortable from 'sortablejs';

export const dragAndDropInit = () => {
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

			window.dslc_generate_code();

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
				moduleOutputDefault( moduleID, function( response ){

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

					// "Show" no content text // Not used anymore?
					// jQuery('.dslca-no-content-primary', modulesArea ).css({ opacity : 1 });

					// "Show" modules area management
					jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'visible' });

					// Generete
					LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
					LiveComposer.Builder.PreviewAreaWindow.dslc_tabs();
					LiveComposer.Builder.PreviewAreaWindow.dslc_init_accordion();

					window.dslc_generate_code();
					// Show publish
					window.dslc_show_publish_button();

					// LiveComposer.Builder.UI.initInlineEditors();
				});

				// Loading animation

				// Show loader – Not used anymore.
				// jQuery('.dslca-module-loading', modulesArea).show();

				// Change module icon to the spinning loader.
				jQuery(itemEl).find('.dslca-icon').attr('class', '').attr('class', 'dslca-icon dslc-icon-refresh dslc-icon-spin');


				// Hide no content text // Not used anymore?
				// jQuery('.dslca-no-content-primary', modulesArea).css({ opacity : 0 });

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
			window.dslc_show_publish_button();
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
