"use strict";

// var Vuex = require('vuex');

// const debug = process.env.NODE_ENV !== 'production';

module.exports = store => {
	// called when the store is initialized
	store.subscribe((mutation, state) => {
		// called after every mutation.
		// The mutation comes in the format of { type, payload }.

		// console.log('STORE PLUGIN!!!!!!!')
		// console.log( "mutation.type:" ); console.log( mutation.type );

		if ( mutation.type === 'updatePageCode' ) {
				console.log('UPDATE PAGE CODE')
		}

		if ( mutation.type === 'savePage' ) {
				console.log('SAVE PAGE CODE')
		}

		// console.log( "state:" ); console.log( state );
	})
}

