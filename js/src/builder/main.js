/**
 * Custom utils
 */
'use strict';

/**
 *   Live Composer team is using next tools for development:
 *
 * – Vue as main app "framework".
 *   Documentation: http://vuejs.org/v2/guide/
 *
 * – Vuex to store the app state (page code, revisions, state vars, etc)
 *   Documentation: https://vuex.vuejs.org/en/
 *
 * – The project needs to be compiled with Browserify.
 *   For development we use https://www.npmjs.com/package/watchify
 *
 * – Vueify: Allow us to write components in a single file that we can later
 *   require like in this example var App = require('./app.vue')
 *   Documentation: ://github.com/vuejs/vueify
 *
 * – Browserify: Browserify used by vueify. It lets you require('modules')
 *   in the browser by bundling up all of your dependencies.
 *   Documentation: https://github.com/substack/browserify-handbook
 */

/**
 *    How to install all the required packages for development.
 *    NOTE: This instruction for Mac users only.
 *
 *    To start development on your machine, you need to perform the next steps:
 *
 * 1. Install node.js and nmp on your machine:
 *    https://docs.npmjs.com/getting-started/installing-node
 *
 * 2. Install required modules via terminal (nmp):
 * 	NOTE: Add 'sudo' before the next lines if you get permission errors.
 * 	npm install vue
 * 	npm install vuex
 *  	npm install -g browserify
 *	  	npm install vueify --save-dev
 *	   npm install babel-core babel-preset-es2015 --save-dev
 *	   npm install --save-dev babelify
 *	   npm install -g watchify
 *
 * 3. If you make any changes to the JS code, you should run the next command:
 *    browserify -t vueify -e js/src/builder/main.js -o js/build/main.js
 *
 *    or use the next command to compile on every file save:
 *    watchify  -t vueify -e js/src/builder/main.js -o js/build/main.js  -v
 *    (to exit watchify click CMD+C)
 */

/**
 * 	ES6(ES2015) usage
 *
 * 	vueify only converts JavaScript in *.vue files - you still need
 * 	babelify for normal *.js files.
 */

/**
 * 	Building for Production (version to upload on WordPress.org)
 *
 * 	Make sure to have the NODE_ENV environment variable set to "production"
 * 	when building for production! This strips away unnecessary code
 * 	(e.g. hot-reload) for smaller bundle size.
 *
 * 	For production (run in terminal):
 * 	export NODE_ENV=production
 *
 * 	For development (run in terminal):
 * 	export NODE_ENV=development
 *
 * 	To check the current state (run in terminal):
 * 	printenv
 */

var Vue = require('vue');

/*
var Vuex = require('vuex');
Vue.use(Vuex);

const LiveComposerState = new Vuex.Store({
	// root state object.
	state: {
		pageCode: null
	},
	// mutations are operations that actually mutates the state.
	// each mutation handler gets the entire state tree as the
	// first argument, followed by additional payload arguments.
	mutations: {
		updatePageCode (state, newCode) {
			state.pageCode = newCode;
		}
	}
});

*/

// Makes possible to update LiveComposerState.state.pageCode
// outside compiled js file. (Browserify wrap all the code making it unaccessible)
window.lcUpdatePageCode =function( newCode ){
	LiveComposerState.commit('updatePageCode', newCode);
};

// LiveComposerState.state.pageCode
// LiveComposerState.commit('updatePageCode', 'something')
// To use in components call: this.$LiveComposerState.state.pageCode

// http://defiantjs.com/ – search over JSON
//
// You can quickly find element in JSON by getting id of all the parents first
// from HTML (creating a path to the item before searching for it in JSON).


/**
 * Prepare DSLCModules variable for component.
 * Go through all DSLCModules.icon properties and prepare data for output.
 */
(function() {
	var i,
		 hasOwn = Object.prototype.hasOwnProperty,
		 DLSCModulesWithSections = [],
		 DLSCModulesSections = []; // Temporary object that we use to create objects by category

	for ( i in DSLCModules) {
		if ( hasOwn.call( DSLCModules, i ) ) { // filter out prototypes

			// Do we have this section id in the object already?
			if ( undefined === DLSCModulesSections[ DSLCModules[i].origin ] ) {
				DLSCModulesSections[ DSLCModules[i].origin ] = DSLCModules[i].origin;
				DLSCModulesWithSections.push( { 'type': 'heading', 'id': DSLCModules[i].origin, 'title': DSLCModules[i].origin, 'origin': DSLCModules[i].origin, 'show': true } );
			}

			DSLCModules[i].type = 'module';
			DSLCModules[i].show = true;

			DLSCModulesWithSections.push(  DSLCModules[i] );
		}
	}
	// We don't want to create many globals,
	// so replace original object with sorted one.
	DSLCModules = DLSCModulesWithSections;

}());

// Request modules-list component:
var modulesList = require('./components/modules-list.vue');
var LiveComposerState = require('./store/store.vue');

var LiveComposerApp = new Vue({
	el: '#livecomposer-app',
	LiveComposerState,
	components : {
      modulesList
   },
	// render: function (createElement) {
	// 	return createElement(App)
	// },
	mounted: function () {
		console.log( 'Root Vue mounted' );
		// document.getElementById('dslca-code');
		// console.log( "document.getElementById('dslca-code'):" ); console.log( document.getElementById('dslca-code').value );

		// console.log( "LiveComposerState.state.pageCode:" ); console.log( LiveComposerState.state.pageCode );
	}
});