/**
 * Iframe settings panel functions
 */

;'use strict';

(function(){

	var self = DSLC_Iframe;

	DSLC_Iframe.initInlineEditor = function(elem){

		return tinyMCE.init({
			target: elem,
			menubar: false,
		  	inline: true
		});
	}
}());