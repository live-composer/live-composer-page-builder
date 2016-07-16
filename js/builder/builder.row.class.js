/**
 * Modules row class
 */

'use strict';
/**
 * Builder row class
 */

DSLC.Editor.CRow = function(elem) {

	var self = this;
	this.elem = elem;

	var sortableContainer = jQuery(elem).find('.dslc-modules-section-wrapper .dslc-modules-section-inner').eq(0)[0];

	jQuery( elem ).droppable({
		drop: function( event, ui ) {
			var modulesSection = jQuery(this).find('.dslc-modules-section-inner');
			var moduleID = ui.draggable.data( 'id' );
			if ( moduleID == 'DSLC_M_A' ) {

				dslc_modules_area_add( modulesSection );
			}
		}
	});

	this.sortable = jQuery( sortableContainer ).sortable({
		connectWith: '.dslc-modules-section-inner',
		items: ".dslc-modules-area",
		handle: '.dslca-move-modules-area-hook:not(".dslca-action-disabled")',
		placeholder: 'dslca-modules-area-placeholder',
		cursorAt: { top: 0, left: 0 },
		tolerance : 'intersect',
		scroll: true,
		scrollSensitivity: 100,
		scrollSpeed : 15,
		sort: function() {

			jQuery( this ).removeClass( "ui-state-default" );
		},
		over: function (e, ui) {

			var dslcSection = ui.placeholder.closest('.dslc-modules-section');

			jQuery(dslcSection).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');

			dslcSection.siblings('.dslc-modules-section').each( function(){
				if ( jQuery('.dslc-modules-area:not(.ui-sortable-helper)', jQuery(this)).length ) {
					jQuery(this).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');
				} else {
					jQuery(this).removeClass('dslc-modules-section-not-empty').addClass('dslc-modules-section-empty');
				}
			});
		},
		remove: function() {

			(jQuery(self.elem).find('.dslc-modules-area').length == 0) && dslc_modules_area_add(jQuery(sortableContainer));
		},
		update: function (e, ui) {

			dslc_generate_code();
			dslc_show_publish_button();
		},
		start: function(e, ui){

			// Placeholder
			ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + DSLCString.str_area_helper_text + '</span></span>');
			if ( ! jQuery(ui.item).hasClass('dslc-12-col') ) {
				ui.placeholder.width(ui.item.width() - 10)
			} else {
				ui.placeholder.width(ui.item.width()).css({ margin : 0 });
			}

			// Add drag in progress class
			jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress dslca-modules-area-drag-in-progress');

			// Refresh positions
			jQuery( '.dslc-modules-section-inner' ).sortable( "refreshPositions" );

		},
		stop: function(e, ui){

			jQuery('body').removeClass('dslca-drag-in-progress dslca-modules-area-drag-in-progress').addClass('dslca-drag-not-in-progress');
			jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');

		},
		change: function( e, ui ) {

		}
	});

	/*this.sortable = Sortable.create(sortableContainer, {
		group: 'modules-areas',
		animation: 150,
		handle: '.dslca-move-modules-area-hook',
		draggable: '.dslc-modules-area',
		sort: true,
		// ghostClass: 'dslca-module-placeholder',
		chosenClass: 'dslca-module-area-dragging',
		scroll: true, // or HTMLElement
		scrollSensitivity: 150, // px, how near the mouse must be to an edge to start scrolling.
		scrollSpeed: 15, // px

		setData: function (dataTransfer, dragEl) {

		  dataTransfer.setData('text/html', dragEl.innerHTML);
		},

		// dragging started
		onStart: function (evt) {

			console.log('sortable row - onStart');
			evt.oldIndex;  // element index within parent

			jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');

		/*	if ( jQuery('.dslc-module-front', evt.from).length < 2 ) {

				jQuery('.dslca-no-content:not(:visible)', evt.from).show().css({
					'-webkit-animation-name' : 'dslcBounceIn',
					'-moz-animation-name' : 'dslcBounceIn',
					'animation-name' : 'dslcBounceIn',
					'animation-duration' : '0.6s',
					'-webkit-animation-duration' : '0.6s',
					padding : 0
				}).animate({ padding : '35px 0' }, 300, function(){

				});
			}*
		},
		// dragging ended

		onEnd: function (evt) {
			evt.oldIndex;  // element's old index within parent
			evt.newIndex;  // element's new index within parent

			evt.preventDefault();

			dslc_generate_code();
			jQuery('body').removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
		},

		// Element is dropped into the list from another list
		onAdd: function (evt) {

			var itemEl = evt.item;  // dragged HTMLElement
			evt.from;  // previous list
			// + indexes from onEnd
			// evt.preventDefault();
			// evt.stopPropagation(); return false;
		},

		// Changed sorting within list
		onUpdate: function (evt) {

			var itemEl = evt.item;  // dragged HTMLElement
			// + indexes from onEnd
			// evt.preventDefault();
			// evt.stopPropagation(); return false;

			dslc_show_publish_button();
		},

		// Called by any change to the list (add / update / remove)
		onSort: function (evt) {
			// same properties as onUpdate
			// evt.preventDefault();
			// evt.stopPropagation(); return false;
		},

		// Element is removed from the list into another list
		onRemove: function (evt) {

		  // same properties as onUpdate
		},

		// Attempt to drag a filtered element
		onFilter: function (evt) {

			var itemEl = evt.item;  // HTMLElement receiving the `mousedown|tapstart` event.
		},

		// Event when you move an item in the list or between lists
		onMove: function (evt) {

			console.log('sortable row - onMove');
			// Example: http://jsbin.com/tuyafe/1/edit?js,output
			evt.dragged; // dragged HTMLElement
			evt.draggedRect; // TextRectangle {left, top, right и bottom}
			evt.related; // HTMLElement on which have guided
			evt.relatedRect; // TextRectangle
			// return false; — for cancel

			// Add here the function to update underlying class
			/**if ( jQuery('.dslc-modules-area-empty').find('.dslc-module-front').length > 0 ) {

				jQuery(this).removeClass('dslc-modules-area-empty').addClass('dslc-modules-area-not-empty');

				jQuery('.dslca-no-content:not(:visible)', this).show().css({
					'-webkit-animation-name' : 'dslcBounceIn',
					'-moz-animation-name' : 'dslcBounceIn',
					'animation-name' : 'dslcBounceIn',
					'animation-duration' : '0.6s',
					'-webkit-animation-duration' : '0.6s',
					padding : 0
				}).animate({ padding : '35px 0' }, 300, function(){

				});
			}*
		}
	});*/
}