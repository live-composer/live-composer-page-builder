'use strict';

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

// console.log( "LiveComposerState.state.pageCode:" );
// console.log( LiveComposerState.state.pageCode );

