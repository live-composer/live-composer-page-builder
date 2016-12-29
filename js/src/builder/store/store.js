"use strict";

var Vuex = require('vuex');

var storePlugins = require('./store.plugins.js');
var storePluginSavePage = require('./store.plugin.savepage.js');

// const debug = process.env.NODE_ENV !== 'production';


module.exports = new Vuex.Store({
	// root state object.
	state: {
		postID: lcDataOnLoad.postID,
		pageCode: JSON.parse( lcDataOnLoad.pageCode ),
		needToSave: false,
		savingInProgress: false
	},

	plugins: [storePlugins, storePluginSavePage],

	// mutations are operations that actually mutates the state.
	// each mutation handler gets the entire state tree as the
	// first argument, followed by additional payload arguments.
	mutations: {
		updatePageCode (state, newCode) {
			state.pageCode = newCode
			state.needToSave = true
		},

		savePage (state) {
			state.savingInProgress = true
			state.needToSave = false
			// console.log('STORE > savePage')
		},

		pageSaved (state) {
			state.savingInProgress = false
			// console.log('STORE > savePage')
		},

		pageSaveFailed (state) {
			state.savingInProgress = false
			state.needToSave = true
			// console.log('STORE > savePage')
		},
	},

	// Actions are similar to mutations, the difference being that:
	// – Instead of mutating the state, actions commit mutations.
	// – Actions can contain arbitrary asynchronous operations.
	actions: {
		updatePageCode (context, newCode) {
			// console.log( 'STORE > ACTIONS > updatePageCode' );
			// console.log( "newCode:" ); console.log( newCode );
			context.commit('updatePageCode', newCode)
		},

		savePage (context) {
			// console.log( 'STORE > ACTIONS > savePage' );
			context.commit('savePage')
		}
	}
});

// module.exports = liveComposerState;

/*
LiveComposerState.state.pageCode
this.$store.commit('updatePageCode', 'something')
To use in components call: this.$store.state.pageCode

http://defiantjs.com/ – search over JSON

You can quickly find element in JSON by getting id of all the parents first
from HTML (creating a path to the item before searching for it in JSON).
*/
