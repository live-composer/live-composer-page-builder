/**
 * Custom utils
 */
'use strict';

/**
 * We are using Sandbox JS pattern for main app object.
 */

// LCAPP.modules.returnLetters = function(MYAPP) {
// 	 MYAPP.returnABC = function() {return "ABC";};
// };

var lcAppState = {
	pageCode : '',
	// movingInHistory: false,
	pageRevisions: {}
}

function LCAPP() {

	/**
	 * LCAPP is a constructor, an new object is automatically created.
	 * We're in the constructor, so we refer to this new object as 'this'.
	 */

		 // Turn arguments into array.
	var args = Array.prototype.slice.call(arguments),
		// The last argument is the callback.
		callback = args.pop(),
		// Modules can be passed as an array or as individual parameters.
		modules = (args[0] && typeof args[0] === 'string') ? args : args[0],
		i;

	// Handle calling function constructor without 'new' keyword
	if ( !(this instanceof LCAPP) ){
		// Invoke me again!
		return new LCAPP( modules, callback );
	}

	// We can add properties to 'this'.
	// Each object will have it's own version of property (not shared).
   // this.someProp = "Property in constructor";

   // Now add modules to the core 'this' object.
   // No modules, or '*' means 'use all modules'.
   if ( !modules || modules === '*' ) {
   	modules = [];
   	for ( i in LCAPP.modules ) {
   		if ( LCAPP.modules.hasOwnProperty(i) ) {
   			modules.push(i);
   		}
   	}
   }

	// Initialize all required modules.
	for( i = 0; i < modules.length ; i++ ){
		//pass reference to 'this' for each required module and invoke it
		//'this' is poiting to new object which was created 
		//after calling new Sandbox()
		LCAPP.modules[modules[i]](this);
	}

	// Call the callback.
	// Return 'this' as main App object. It contains all methods
	// and properties attached in functions.
	callback(this);

}

LCAPP.modules = {};

//We can optionally create Sandbox methods and shared properties
LCAPP.prototype = {
	name: "Live Composer",
	version: "1.0",
	// uniqueId : Math.random().toString(32).slice(2),
	state : {
		pageCode : '',
		// movingInHistory: false,
		pageRevisions: {},
		dragging: false, // Drag in drop in progress.
		draggableElement: false
	},

	// Access points to the preview area (iframe with page).
	pagePreview: {
		document: '',
		window: ''
	},

	getName: function () {
		return this.name;
	},
	getVer: function () {
		return this.version;
	},
	// getId: function () {
	// 	return 'uniqueId:' + this.uniqueId;
	// },
	getPageCode: function () {
		return this.state.pageCode;
	},
	setPageCode: function ( newPageCode ) {
		this.state.pageCode = newPageCode;
	},
};

//Finally here is an example of usage

// new LCAPP('returnNumbers', 'returnLetters', function (MYAPP) {

// 	 console.log(MYAPP.return100());
// 	 console.log(MYAPP.returnABC());
// });

