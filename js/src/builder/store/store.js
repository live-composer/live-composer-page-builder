var Vue = require('vue');
var Vuex = require('vuex');

Vue.use(Vuex);

// const debug = process.env.NODE_ENV !== 'production';

var liveComposerState = new Vuex.Store({
	// root state object.
	state: {
		pageCode: []
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

module.exports = liveComposerState;

/*
LiveComposerState.state.pageCode
LiveComposerState.commit('updatePageCode', 'something')
To use in components call: this.$LiveComposerState.state.pageCode

http://defiantjs.com/ – search over JSON

You can quickly find element in JSON by getting id of all the parents first
from HTML (creating a path to the item before searching for it in JSON).
*/
