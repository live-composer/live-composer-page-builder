/**
 * Mutation observer library written by Alexey Petlenko
 *
 * @author Alexey Petlenko(Massique)
 */

;(function(){

	var observerClass = function(element, callback, config) {

		if( ! element || typeof callback != 'function' || ( typeof config != 'object' && config ) ) {

			console.error('mq_mutation_obs:: invalid arguments in class constructor');
			return false;
		}

		// create an observer instance
		var observer = new MutationObserver(function(mutations) {

		    mutations.forEach(callback);
		});

		// configuration of the observer:
		var configFinal = config || { attributes: true, childList: true, characterData: true };

		// pass in the target node, as well as the observer options
		observer.observe(element, configFinal);

		return observer;
	}

	window.mqMutationObserver = observerClass;
}());