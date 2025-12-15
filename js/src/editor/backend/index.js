/**
 * Main builder file
 */

import { templatesPanelInit } from './templates.js';
import { fixContenteditable, keypressEvents } from './uigeneral.js';
import { CSectionsContainer } from './sectionscontainer.class.js';
import { settingsPanelInit } from './settings.panel.js';
import { sectionsInit } from './sections.js';
import { dragAndDropInit } from './dragndrop.js';
import { codeGenerationInitJS } from './codegeneration.js';
import { initPreviewAreaScroller } from './scroller.js';
import { untilsInitJs } from './utils.class.js';
import { modalwindowInitJS } from './modalwindow.js';
import { moduleInitJS } from './module.js';
import { presetsInit } from "./presets.js";
import { eventsInit } from './events.js';


var dslcDebug = false;
// window.dslcDebug = true;

// Global Plugin Object
window.LiveComposer = {

    Builder: {

        Elements: {},
        UI: {},
        Actions: {},
        Flags: {},
        PreviewFrame: {},
        Helpers: {},

        // ----------------------------------------------------
        // ** NEW: HISTORY MANAGEMENT OBJECT **
        // ----------------------------------------------------
        History: {
            undoStack: [],
            redoStack: [],
            maxHistory: 5 // Limit the history stack size
        }
    },
    Production: {

    },
    Utils: {}
};

(function(){

    LiveComposer.Builder.Flags = {

        windowScroller: false,
        panelOpened: false, // Settings panel opened
        uiHidden: false, // ex composer-hidden
        modalOpen: false,

        // Used to prevent multiple code generation when
        // cancelling row edits or applying historical states
        generate_code_after_row_changed: true
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
        },

        // LiveComposer.Builder.Actions.optionsChanged() - if calling from parent.
        // parent.LiveComposer.Builder.Actions.optionsChanged() - if calling from iframe.
        optionsChanged: function () {
            window.dslc_show_publish_button();
        },

        // ----------------------------------------------------
        // ** NEW: UNDO/REDO FUNCTIONS **
        // ----------------------------------------------------

        /**
         * 💾 Captures the current state of the page content and saves it to the undoStack.
         */
        saveState: function() {
			console.log('Saving the state');
            var history = LiveComposer.Builder.History;

            // Capture the current HTML of the main content area
            var currentState = LiveComposer.Builder.PreviewAreaDocument.find("#dslc-main").html();

            // Guard: Prevent saving redundant states
            if (currentState && history.undoStack.length > 0 && history.undoStack[history.undoStack.length - 1] === currentState) {
                return;
            }

            // 1. Push current state to undo stack
            history.undoStack.push(currentState);

            // 2. Limit the stack size
            if (history.undoStack.length > history.maxHistory) {
                history.undoStack.shift(); // Remove the oldest state (first-in)
            }

            // 3. Any new action clears the redo stack
            history.redoStack = [];

            // TODO: Optional: Call a function to visually update Undo/Redo buttons
            // LiveComposer.Builder.Actions.updateUndoRedoUI();
        },

        /**
         * 🔄 Applies a historical HTML state to the editor content area.
         * @param {string} stateHTML - The saved HTML content.
         */
        applyState: function(stateHTML) {
			var mainContainer = LiveComposer.Builder.PreviewAreaDocument.find("#dslc-main").eq(0);

			// ... (Flags set to false here) ...

			// 1. Replace the HTML content in the preview area
			mainContainer.html(stateHTML);
			mainContainer.find('.dslc-module-front').css('opacity', 1);

			// 2. **CRITICAL: Re-initialize and Re-bind Functions**

			// These need to re-bind events and functionality on the new DOM
			if (typeof sectionsInit === 'function') sectionsInit(); // Re-initialize rows/sections
			if (typeof dragAndDropInit === 'function') dragAndDropInit(); // Re-bind D&D handlers
			if (typeof fixContenteditable === 'function') fixContenteditable(); // Re-initialize editors

			// *** ADD ANY MISSING RENDERING/INIT FUNCTIONS HERE ***

			// Live Composer rendering functions (must run on the new DOM structure)
			// Note: These must be available on the preview area window object
			LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();
			LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
			LiveComposer.Builder.PreviewAreaWindow.dslc_tabs();
			LiveComposer.Builder.PreviewAreaWindow.dslc_init_accordion(); 

			// 3. Re-enable the code generation flag
			LiveComposer.Builder.Flags.generate_code_after_row_changed = true;

			// 4. Trigger the final code generation and UI update
			window.dslc_generate_code();
			LiveComposer.Builder.Actions.optionsChanged();
		},

        /**
         * ⏪ Reverts to the previous page state.
         */
		undo: function() {
			console.log('undo is called');
            var history = LiveComposer.Builder.History;

            // Need at least two states: the current state and the previous state to revert to.
            if (history.undoStack.length < 2) {
                return;
            }

            // 1. Pop the current state and push it to the redo stack
            var currentState = history.undoStack.pop();
            history.redoStack.push(currentState);

            // 2. Get the previous state (the new last item) and apply it
            var previousState = history.undoStack[history.undoStack.length - 1];
            LiveComposer.Builder.Actions.applyState(previousState);

            // TODO: Optional: Update UI
            // LiveComposer.Builder.Actions.updateUndoRedoUI();
        },

        /**
         * ⏩ Re-applies the next state after an undo operation.
         */
        redo: function() {
			console.log('redo is called');
            var history = LiveComposer.Builder.History;

            if (history.redoStack.length === 0) {
                return;
            }

            // 1. Pop the next state from the redo stack
            var futureState = history.redoStack.pop();

            // 2. Apply the future state
            LiveComposer.Builder.Actions.applyState(futureState);

            // 3. Push the applied state back onto the undo stack
            history.undoStack.push(futureState);

            // TODO: Optional: Update UI
            // LiveComposer.Builder.Actions.updateUndoRedoUI();
        }
    }

    /**
     * Inserts module fixing inline scripts bug
     * (Original LiveComposer.Builder.Helpers.insertModule function)
     * ...
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

/** Wait till tinyMCE loaded */
window.previewAreaTinyMCELoaded = function( windowObj ){
    LiveComposer.Builder.PreviewAreaWindow = windowObj;
    LiveComposer.Builder.PreviewAreaDocument = jQuery(windowObj.document);

    // Disable WP admin bar in editing mode
    jQuery('#wpadminbar', LiveComposer.Builder.PreviewAreaDocument).remove();

    // LiveComposer.Builder.UI.initInlineEditors();
    fixContenteditable();

    templatesPanelInit();
    settingsPanelInit();

    sectionsInit();

    var mainDraggable = LiveComposer.Builder.PreviewAreaDocument.find("#dslc-main").eq(0)[0];
    new CSectionsContainer( mainDraggable );

    jQuery(document).trigger('editorFrameLoaded');
    dragAndDropInit();
    codeGenerationInitJS();
    window.dslc_generate_code();
    clearInterval(LiveComposer.Builder.Flags.windowScroller);
    LiveComposer.Builder.Flags.windowScroller = false;

    // ------------------------------------------------------------------
    // ** IMPORTANT: Initial state capture after editor is fully loaded **
    // ------------------------------------------------------------------
    LiveComposer.Builder.Actions.saveState();

    // Catch keypress events (from both parent and iframe) to add keyboard support
    keypressEvents();
    initPreviewAreaScroller();
    modalwindowInitJS();
    moduleInitJS();
    untilsInitJs();
    presetsInit();
    eventsInit();
};

// Disable the prompt ( are you sure ) on refresh
window.onbeforeunload = function () { return; };