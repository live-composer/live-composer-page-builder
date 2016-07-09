/**
 *  Basic Module class
 */

;(function(){

	var bm = function(config){

		if( typeof config != 'object' ) return false;

		var self = this;

		this.elem = jQuery(config.elem);

		/** Listeners */
		/*this.elem.find('.dslca-module-edit-hook').click(function(){


		});*/
	};

	window.DSLC_BasicModule = bm;
}());