/**
 * DSLC_ModuleArea class
 */
var DSLC_ModuleArea = function(elem) {

	this.elem = elem;
	this.sortable = Sortable.create(elem, {
	group: 'module-areas',
	animation: 150,
	handle: '.dslca-move-module-hook',
	draggable: '.dslc-module-front',
	// ghostClass: 'dslca-module-placeholder',
	chosenClass: 'dslca-module-dragging',
	scroll: true, // or HTMLElement
	scrollSensitivity: 150, // px, how near the mouse must be to an edge to start scrolling.
	scrollSpeed: 15, // px

	setData: function (dataTransfer, dragEl) {

	  // dataTransfer.setData('Text', dragEl.textContent);
	  dataTransfer.setData('text/html', dragEl.innerHTML);
	},

	// dragging started
	onStart: function (/**Event*/evt) {
		evt.oldIndex;  // element index within parent

		/*
		ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + ui.item.find('.dslc-sortable-helper-icon').data('title') + '</span></span>');

		if ( ! jQuery(ui.item).hasClass('dslc-12-col') ) {
			ui.placeholder.width(ui.item.width() - 10)
		} else {
			ui.placeholder.width(ui.item.width()).css({ margin : 0 });
		}
		*/

		jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');

		// console.info( jQuery('.dslc-module-front', evt.from.innerHTML) );
		if ( jQuery('.dslc-module-front', evt.from).length < 2 ) {

			console.info( 'empty now' );

			jQuery(evt.from).removeClass('dslc-modules-area-not-empty').addClass('dslc-modules-area-empty');

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
		// jQuery( '.dslc-modules-area' ).sortable( "refreshPositions" );
	},
	// dragging ended
	onEnd: function (/**Event*/evt) {
		evt.oldIndex;  // element's old index within parent
		evt.newIndex;  // element's new index within parent

		evt.preventDefault();
		console.info( 'sortable - onEnd' );

		dslc_generate_code();
		jQuery('body').removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
		// jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');
		// ui.item.trigger('mouseleave');
	},

	// Element is dropped into the list from another list
	onAdd: function (/**Event*/evt) {
		var itemEl = evt.item;  // dragged HTMLElement
		evt.from;  // previous list
		// + indexes from onEnd
		evt.preventDefault();
		evt.stopPropagation(); return false;
		console.info( 'sortable - onAdd' );
	},

	// Changed sorting within list
	onUpdate: function (/**Event*/evt) {
		var itemEl = evt.item;  // dragged HTMLElement
		// + indexes from onEnd
		evt.preventDefault();
		evt.stopPropagation(); return false;

		dslc_show_publish_button();
		console.info( 'sortable - onUpdate' );
	},

	// Called by any change to the list (add / update / remove)
	onSort: function (/**Event*/evt) {
		// same properties as onUpdate
		evt.preventDefault();
		evt.stopPropagation(); return false;
		console.info( 'sortable - onSort' );
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
		console.info( 'sortable - onMove' );


		console.info( jQuery('.dslc-modules-area-empty .dslc-module-front') );
		console.info( jQuery('.dslc-modules-area-empty .dslc-module-front').length );
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
}