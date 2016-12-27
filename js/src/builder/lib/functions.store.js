module.exports = function (Vue) {

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
};