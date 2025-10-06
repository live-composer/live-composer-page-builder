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
// dslcDebug = true;

// Global Plugin Object
window.LiveComposer = {

    Builder: {

        Elements: {},
        UI: {},
        Actions: {},
        Flags: {},
        PreviewFrame: {},
        Helpers: {}
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
		// cancelling row edits
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
