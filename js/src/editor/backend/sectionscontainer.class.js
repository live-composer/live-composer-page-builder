/**
 * Sections container class
 */

import Sortable from 'sortablejs';

export const CSectionsContainer = class{

	constructor (elem) {
		this.sortable;

		this.initSortable(elem);
		this.reactToSortableOnOff();
	}


	initSortable(elem) {
		this.sortable = Sortable.create( elem, {
			group: 'sections',
			animation: 350,
			handle: '.dslca-move-modules-section-hook',
			draggable: '.dslc-modules-section-dnd',
			ghostClass: 'dslca-sections-ghost',
			chosenClass: 'dslca-sections-dragging',
			scroll: true, // or HTMLElement
			scrollSensitivity: 150, // px, how near the mouse must be to an edge to start scrolling.
			scrollSpeed: 10, // px
			bubbleScroll: true, // apply autoscroll to all parent elements, allowing for easier movement
			direction: 'vertical',
			// forceFallback: true, // to make Drag + wheel scroll feature.

			setData: function (dataTransfer, dragEl) {
			  dataTransfer.setData( LiveComposer.Utils.msieversion() !== false ? 'Text' : 'text/html', dragEl.innerHTML);
			},
			// dragging started
			onStart: function (evt) {
				// evt.oldIndex;  // element index within parent
				jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');
				jQuery('body', LiveComposer.Builder.PreviewAreaWindow.document).removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');
				// ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + DSLCString.str_row_helper_text + '</span></span>');
				// jQuery( '.dslc-content' ).sortable( "refreshPositions" );
			},
			// dragging ended
			onEnd: function (evt) {
				evt.oldIndex;  // element's old index within parent
				evt.newIndex;  // element's new index within parent

				evt.preventDefault();

				window.dslc_generate_code();
				LiveComposer.Builder.UI.stopScroller();
				jQuery('body').removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
				jQuery('body', LiveComposer.Builder.PreviewAreaWindow.document).removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');

				jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');
			},

			// Element is dropped into the list from another list
			onAdd: function (evt) {

				/* var itemEl = evt.item;  // dragged HTMLElement
				evt.from;  // previous list

				// If container/column/modules area droped.
				if ( jQuery(itemEl).data('id') == 'DSLC_M_A' ) {

					modulesAreaAdd( jQuery(self.section).find('.dslc-modules-section-wrapper .dslc-modules-section-inner') );
					itemEl.remove();
				} */

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

				window.dslc_show_publish_button();
			},

			// Called by any change to the list (add / update / remove)
			onSort: function (evt) {

				jQuery( this ).removeClass( "ui-state-default" );
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
				// Example: http://jsbin.com/tuyafe/1/edit?js,output
				evt.dragged; // dragged HTMLElement
				evt.draggedRect; // TextRectangle {left, top, right и bottom}
				evt.related; // HTMLElement on which have guided
				evt.relatedRect; // TextRectangle
				// return false; — for cancel


				// Add here the function to update underlying class
				/* if ( jQuery('.dslc-modules-area-empty').find('.dslc-module-front').length > 0 ) {

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
				} */
			}
		});
	}

	reactToSortableOnOff() {
		self = this.sortable;

		/** Sort option setter */
		/* jQuery(document).on('LC.sortableOff', function(){
			if ( undefined !== self.sortable( "instance" ) ) {
				self.sortable('option','disabled', true);
			}
		});

		jQuery(document).on('LC.sortableOn', function(){
			if ( undefined !== self.sortable( "instance" ) ) {
				self.sortable('option','disabled', false);
			}
		}); */
	}

}