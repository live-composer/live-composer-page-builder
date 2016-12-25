// import Vue from 'vue'
// import Vuex from 'vuex'
// import * as actions from './actions'
// import * as getters from './getters'
// import cart from './modules/cart'
// import products from './modules/products'
// import createLogger from '../../../src/plugins/logger'

// Vue.use(Vuex)

// const debug = process.env.NODE_ENV !== 'production'

// export default new Vuex.Store({
//   actions,
//   getters,
//   modules: {
//     cart,
//     products
//   },
//   strict: debug,
//   plugins: debug ? [createLogger()] : []
// })

var Vue = require('vue');
var Vuex = require('vuex');


Vue.use(Vuex);

// const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
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

  // actions,
  // getters,
  // modules: {
  //   cart,
  //   products
  // },
  // strict: debug,
  // plugins: debug ? [createLogger()] : []
});

/*
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
