/**
 * Main builder file
 */

'use strict';

var dslcRegularFontsArray = DSLCFonts.regular;
var dslcGoogleFontsArray = DSLCFonts.google;
var dslcAllFontsArray = dslcRegularFontsArray.concat( dslcGoogleFontsArray );

// Set current/default icons set
var dslcIconsCurrentSet = DSLCIcons.fontawesome;
var dslcDebug = false;
// dslcDebug = true;


// Global Plugin Object
var LiveComposer = {

    Builder: {

        Elements: {},
        UI: {},
        Actions: {},
        State: {},
        PreviewFrame: {},
        Helpers: {}
    },
    Production: {

    },
    Utils: {}
};

(function(){

	LiveComposer.Builder.State = {

		windowScroller: false,
		panelOpened: false, // Settings panel opened.
		moduleBeingEdited: '', // ID of the module we currently editing.

		// Used to prevent multiple code generation when
		// cancelling row edits
		generate_code_after_row_changed: true,

		pageCode: '',

		pageRevisions: {},
		movingInHistory: false

		// pageRevisions: {
		// 	revisions: {},
		// 	current: 0,
		// 	count: 0,
		// 	movingInHistory: false
		// } // Store page code changes.
	};

	LiveComposer.Builder.Actions = {

		postponed_actions_queue: {},
		add_postponed_action: function( action_name ) {

			if (action_name === undefined) {
			   return;
			}

			if ( isNaN ( this.postponed_actions_queue[ action_name ] ) ) {
				this.postponed_actions_queue[ action_name ] = 0;
			}

			this.postponed_actions_queue[ action_name ] += 1;
		},

		release_postponed_actions: function() {

			var self = this;

			jQuery.each( this.postponed_actions_queue, function(index, value) {

				if ( 1 < value ) {
					self.postponed_actions_queue[index] -= 1;
				} else if ( 1 == value ) {
					window[index](); // Run function with action name
					self.postponed_actions_queue[index] -= 1;
				}
			});
		}
	}

	/**
	 * Inserts module fixing inline scripts bug
	 *
	 * @param {string} moduleHTML
	 * @param {string} afterObject after what module should be inserted
	 *
	 * @return {DOM} inserted object
	 */
	LiveComposer.Builder.Helpers.insertModule = function( moduleHTML, afterObject ) {

		var newModule = jQuery(moduleHTML),
			afterObject = jQuery(afterObject);

		var scripts = [];

		newModule.find('script').each(function(){

			scripts.push(this.innerHTML);
			this.parentNode.removeChild(this);
		});

		// Insert 'updated' module output after module we are editing.
		// && Delete 'old' instance of the module we are editing.
		afterObject
			.after(newModule)
			.remove();

		scripts.forEach(function(item) {

			var script = LiveComposer.Builder.PreviewAreaDocument[0].createElement('script');
			script.innerHTML = item;
			script.type = 'text/javascript';

			LiveComposer.Builder.PreviewAreaDocument[0].getElementById(newModule[0].id).appendChild(script);
		});

		scripts = null;
		afterObject = null;

		return newModule;
	}
}());



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

	/**
	 * Update LiveComposerState.state.pageCode with current JSON code.
	 */
	var currentPageCode = document.getElementById('dslca-code').value;
	lcUpdatePageCode(currentPageCode);
	// LiveComposerState.commit('updatePageCode', currentPageCode);

	// On load set focus on elements search field.
	document.getElementById('modules-search-input').focus();
};
