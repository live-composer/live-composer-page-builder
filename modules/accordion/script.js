/**
 * Accordion js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		DSLC.ModulesManager.AvailModules.DSLC_Accordion.prototype.changeOptionsBeforeRender = function(options)
		{
			var accordion_nav = options.accordion_nav.value || options.accordion_nav.std;
			accordion_nav = accordion_nav.trim().split( '(dslc_sep)' );

			if ( options.accordion_content.value == '' || options.accordion_content.value == undefined ) {

				options.accordion_contents = false;
			} else {

				options.accordion_contents = options.accordion_content.value.trim().split( '(dslc_sep)' );
			}

			return options;
		}
	});
}());