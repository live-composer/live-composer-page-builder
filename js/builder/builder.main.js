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