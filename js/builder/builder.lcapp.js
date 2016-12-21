/**
 * Custom utils
 */
'use strict';

/**
 * We are using Sandbox pattern.
 * https://github.com/shichuan/javascript-patterns/blob/master/object-creation-patterns/sandbox.html
 */




/** Wait till tinyMCE loaded */
window.previewAreaTinyMCELoaded = function(){

	var self = this;
	var pagePreviewWindow = this;

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


	// Set focus on the search field.
	// document.getElementById('modules-search-input').focus(); 
	// @todo: not working.
	// @todo: firstly check if anyother field focused: http://stackoverflow.com/a/1593282

	// Make sidebar resizable.
	// @todo: add sidebar colapse on click on the resizing handle.
	jQuery( '.dslca-container' ).resizable({
		handles: 'e',
		minWidth: 255,
		resize: function( event, ui ) {
			// console.log( event );
			// console.log( ui.size.width );
			jQuery( '#wpbody-content' ).css( 'margin-left', ui.size.width + 'px' );
		}
	});

	// Make modules resizable in width;
	LiveComposer.Builder.UI.initResizableModules();



	console.log( "editorFrameLoaded" );

	// Start application via main object lcApp initialization.
	// (only after editing iframe fully loaded)
	//
	// lcApp is our main application object to work with.
	// You can call particular modules if needed:
	// LCAPP( ['module1', 'module2'], function(lcApp){
	LCAPP( function(lcApp){

		// Make preview iframe accessible via lcApp.previewArea.window/document.
		lcApp.pagePreview = {
			window: pagePreviewWindow,
			document: pagePreviewWindow.document
		};

		// Init Undo/Redo functionality.
		lcApp.revisions.init();

		// Detect drag event.
		// lcApp.pagePreview.document.addEventListener("dragstart", function(event) {
		// 	// Update dragging state.
		// 	lcApp.state.dragging = true;
		// 	console.log( 'drag start' );
		// 	// make it half transparent
	 //     event.target.style.opacity = .5;
		// });

		// lcApp.pagePreview.document.addEventListener("dragend", function(event) {
		// 	// Update dragging state.
		// 	lcApp.state.dragging = false;
		// 	console.log( 'drag end' );
		// 	// make it half transparent
	 //   	event.target.style.opacity = 1;
		// });

	});
};


// console.log( DSLCModules );

var LiveComposerApp = new Vue({
	el: '#livecomposer-app',
	mounted: function () {
		// console.log( 'Root Vue mounted' );

		// On load set focus on elements search field.
		document.getElementById('modules-search-input').focus();
	}

});

// console.log( "LiveComposerApp:" ); console.log( LiveComposerApp );

