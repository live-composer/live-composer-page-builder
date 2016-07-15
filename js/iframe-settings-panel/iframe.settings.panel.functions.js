/**
 * Iframe settings panel functions
 */

;'use strict';

(function(){

	var self = DSLC_Iframe;

	DSLC_Iframe.initMediumEditor = function(elem){

		return new MediumEditor(elem, {
			// buttonLabels: 'fontawesome',
			imageDragging: false,
			toolbar: {
				buttons: ['bold', 'italic', 'unorderedlist', 'orderedlist',  'h2', 'h3', 'removeFormat'],
				diffLeft: 25,
				diffTop: 10,
			},
		});
	}
}());