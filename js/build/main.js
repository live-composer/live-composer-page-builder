(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
/**
 * Custom utils
 */
'use strict';

/**
 * Coding Standards:
 * https://github.com/airbnb/javascript
 */

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

// var Vue = require('vue');

// Makes possible to update LiveComposerState.state.pageCode
// outside compiled js file. (Browserify wrap all the code making it unaccessible)
window.lcUpdatePageCode = function( newCode ){
	// LiveComposerState.commit('updatePageCode', newCode);
}


const LiveComposerApp = new Vue({
	el: '#livecomposer-app',
	liveComposerState,
	// render: function (createElement) {
	// 	return createElement(App)
	// },
	mounted: function () {
		console.log( 'Root Vue mounted' )
		Vue.use(blah)
	}
})

function blah(Vue) {
	console.log('blah');
}
},{}]},{},[1]);
