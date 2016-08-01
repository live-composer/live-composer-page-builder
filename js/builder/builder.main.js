/**
 * Main builder file
 */

"use strict";

var dslcRegularFontsArray = DSLCFonts.regular;
var dslcGoogleFontsArray = DSLCFonts.google;
var dslcAllFontsArray = dslcRegularFontsArray.concat( dslcGoogleFontsArray );

// Set current/default icons set
var dslcIconsCurrentSet = DSLCIcons.fontawesome;
var dslcDebug = false;


// Global Plugin Object
var DSLC = {
	Production: {}
};

DSLC.Editor = {
	flags: {
		generate_code_after_row_changed: true
	},

	postponed_actions_queue: {},
/*
	{
		'action_to_run' : counter
		action_to_run – function name to launch once counter == 0
	},
*/

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

		jQuery.each( this.postponed_actions_queue, function(index, value) {

			if ( 1 < value ) {
				DSLC.Editor.postponed_actions_queue[index] -= 1;
			} else if ( 1 == value ) {
				window[index](); // Run function with action name
				DSLC.Editor.postponed_actions_queue[index] -= 1;
			}
		});
	}

};
