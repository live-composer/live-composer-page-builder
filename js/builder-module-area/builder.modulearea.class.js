/**
 * DSLC_ModuleArea class
 */

'use strict';

DSLC.Editor.CModuleArea = function(elem) {

	var self = this;
	this.section = elem.closest('.dslc-modules-section');
	this.elem = elem;

	/** Set observer to change elems class */
	this.observer = new mqMutationObserver(elem, function(){

		var classList = self.elem.classList;

		if (elem.querySelectorAll('.dslc-module-front').length == 0) {

			classList.add('dslc-modules-area-empty');
			classList.add('dslc-last-col');
			classList.remove('dslc-modules-area-not-empty');
		} else {

			classList.remove('dslc-last-col');
			classList.remove('dslc-modules-area-empty');
			classList.add('dslc-modules-area-not-empty');
		}
	}, {childList: true});

	/**
	 * Make MODULES inside the Modules Area draggable/sortable
	 */
	this.sortable = Sortable.create(elem, {
		group: 'modules',
		animation: 150,
		handle: '.dslca-move-module-hook',
		draggable: '.dslc-module-front',
		// ghostClass: 'dslca-module-placeholder',
		chosenClass: 'dslca-module-dragging',
		scroll: true, // or HTMLElement
		scrollSensitivity: 150, // px, how near the mouse must be to an edge to start scrolling.
		scrollSpeed: 15, // px

		setData: function (dataTransfer, dragEl) {

		  dataTransfer.setData('text/html', dragEl.innerHTML);
		},

		// dragging started
		onStart: function (evt) {
			evt.oldIndex;  // element index within parent

			jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');

			if ( jQuery('.dslc-module-front', evt.from).length < 2 ) {

				jQuery('.dslca-no-content:not(:visible)', evt.from).show().css({
					'-webkit-animation-name' : 'dslcBounceIn',
					'-moz-animation-name' : 'dslcBounceIn',
					'animation-name' : 'dslcBounceIn',
					'animation-duration' : '0.6s',
					'-webkit-animation-duration' : '0.6s',
					padding : 0
				}).animate({ padding : '35px 0' }, 300, function(){

				});
			}
		},
		// dragging ended

		onEnd: function (evt) {

			evt.oldIndex;  // element's old index within parent
			evt.newIndex;  // element's new index within parent

			evt.preventDefault();
			//console.info( 'sortable - onEnd' );

			dslc_generate_code();
			jQuery('body').removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
		},

		// Element is dropped into the list from another list
		onAdd: function (evt) {

			var itemEl = evt.item;  // dragged HTMLElement
			evt.from;  // previous list

			if ( jQuery(itemEl).data('id') == 'DSLC_M_A' ) {

				dslc_modules_area_add( jQuery(self.section).find('.dslc-modules-section-wrapper .dslc-modules-section-inner') );
				itemEl.remove();
			}

			// + indexes from onEnd
			// evt.preventDefault();
			// evt.stopPropagation(); return false;
			//console.info( 'sortable - onAdd' );
		},

		// Changed sorting within list
		onUpdate: function (evt) {
			var itemEl = evt.item;  // dragged HTMLElement
			// + indexes from onEnd
			// evt.preventDefault();
			// evt.stopPropagation(); return false;

			dslc_show_publish_button();
			//console.info( 'sortable - onUpdate' );
		},

		// Called by any change to the list (add / update / remove)
		onSort: function (evt) {
			// same properties as onUpdate
			// evt.preventDefault();
			// evt.stopPropagation(); return false;
			//console.info( 'sortable - onSort' );
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
			if ( jQuery('.dslc-modules-area-empty').find('.dslc-module-front').length > 0 ) {

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
			}
		}
	});

	/**
	 * Modules Areas / Columns – Drag & Drop
	 *
	 * Make columns draggable/sortable
	 */
	/*jQuery( '.dslc-modules-section-inner', DSLC.Editor.frame ).sortable({
		connectWith: '.dslc-modules-section-inner',
		items: ".dslc-modules-area",
		handle: '.dslca-move-modules-area-hook:not(".dslca-action-disabled")',
		placeholder: 'dslca-modules-area-placeholder',
		// helper: 'clone',
		cursor: 'grabbing',
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
	});*/
}
