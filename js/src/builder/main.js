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
var Vuex = require('vuex');

Vue.use(Vuex);

var store = require('./store/store.js');

// store.commit('updatePageCode', 'something');
// console.log( "appState:" ); console.log( store.state.pageCode );

// Request modules-list component:
var modulesList = require('./components/modules-list.vue');
var buttonSave  = require('./components/button-save.vue');
var sectionTitle  = require('./components/section-title.vue');
// var droppableArea = require('./components/droppable-area.vue');
// var storeFunctions = require('./lib/functions.store.js')(Vue);

var LiveComposerApp = new Vue({
	el: '#livecomposer-app',
	store,
	components : {
		modulesList,
		buttonSave,
		sectionTitle
	},
	// render: function (createElement) {
	// 	return createElement(App)
	// },
	mounted: function () {
		console.log( 'Root Vue mounted' );
		// document.getElementById('dslca-code');
		// console.log( "document.getElementById('dslca-code'):" ); console.log( document.getElementById('dslca-code').value );

		// console.log( "LiveComposerState.state.pageCode:" ); console.log( LiveComposerState.state.pageCode );
		Vue.use(blah);
	},



	methods: {
		onEnd: function () {
			console.log('END vue app');
		}
	}
});

console.log( "LiveComposerApp:" ); console.log( LiveComposerApp );

function blah(Vue) {
	console.log('blah');
}