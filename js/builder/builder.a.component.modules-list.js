/**
 * Custom utils
 */
'use strict';


console.log('component');

/**
 * Render list of modules with Vue.
 * We receive DSLCModules global var via WordPress localize.
 */

/**
 * Vue Component: Modules List Panel.
 */
Vue.component('modules-list', {
	template: '#modules-list-template',
	// options
	data: function () {
		return {
			modules: DSLCModules
		}
	},
	mounted: function () {
		// console.log( 'Component mounted' );

		/**
		 * Lists below should follow vue app init.
		 */

		// Init modules search field functionality.
		// Documentation: http://www.listjs.com/docs/options
		new List('dslca-modules', {
			valueNames: [ 'dslca-module-title' ],
			listClass: 'lc-modules-list',
			searchClass: 'modules-search-input',
		});
	}
});

/**
 * Prepare DSLCModules variable for component.
 * Go through all DSLCModules.icon properties and prepare data for output.
 */
(function() {
	var i,
		 hasOwn = Object.prototype.hasOwnProperty,
		 DLSCModulesWithSections = [],
		 DLSCModulesSections = [];; // Temporary object that we use to create objects by category

	for ( i in DSLCModules) {
		if ( hasOwn.call( DSLCModules, i ) ) { // filter out prototypes
			// console.log( DSLCModules[i] );

			// console.log( DLSCModulesSections[ DSLCModules[i].origin ] );

			// Do we have this section id in the object already?
			if ( undefined === DLSCModulesSections[ DSLCModules[i].origin ] ) {
				DLSCModulesSections[ DSLCModules[i].origin ] = DSLCModules[i].origin;
				DLSCModulesWithSections.push( { 'type': 'heading', 'id': DSLCModules[i].origin, 'title': DSLCModules[i].origin, 'origin': DSLCModules[i].origin } );
			}

			DSLCModules[i].type = 'module';

			DLSCModulesWithSections.push(  DSLCModules[i] );
			/*
			// Add new module to the section sub-tree.
			DLSCModulesBySection[ DSLCModules[i].origin ][ DSLCModules[i].id ] = DSLCModules[i] ;

			// console.log( DLSCModulesBySection );
			*/
		}
	}

	// console.log( DLSCModulesWithSections );
/*
	DSLCModules = {};
	console.log( "DLSCModulesBySection:" ); console.log( DLSCModulesBySection );
	for ( i in DLSCModulesBySection) {
		if ( hasOwn.call( DLSCModulesBySection, i ) ) { // filter out prototypes
			// DSLCModules[i] = {};
			// console.log( DLSCModulesBySection[i] );
			DSLCModules[ DLSCModulesBySection[i] ] = DLSCModulesBySection[i];
		}
	}
*/
	// We don't want to create many globals,
	// so replace original object with sorted one.
	DSLCModules = DLSCModulesWithSections;

}());