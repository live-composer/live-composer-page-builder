/**
 * Main builder file
 */

"use strict";

var dslcRegularFontsArray = DSLCFonts.regular;
var dslcGoogleFontsArray = DSLCFonts.google;
var dslcAllFontsArray = dslcRegularFontsArray.concat( dslcGoogleFontsArray );

// Set current/default icons set
var dslcIconsCurrentSet = DSLCIcons.fontawesome;
var dslcDebug = true;


// Global Plugin Object
var DSLC = {
	Production: {}
};

DSLC.Editor = {
	flags: {
		generate_code_after_row_changed: true
	}
};
