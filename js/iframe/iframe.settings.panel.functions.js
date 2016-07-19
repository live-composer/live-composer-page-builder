/**
 * Iframe settings panel functions
 */

;'use strict';

(function(){

	var self = DSLC_Iframe;

	DSLC_Iframe.initMediumEditor = function(elem){


		MediumEditor.extensions.button.prototype.defaults.bold.contentDefault = '<span class="dashicons dashicons-editor-bold"></span>';
		MediumEditor.extensions.button.prototype.defaults.italic.contentDefault = '<span class="dashicons dashicons-editor-italic"></span>';
		MediumEditor.extensions.button.prototype.defaults.quote.contentDefault = '<span class="dashicons dashicons-editor-quote"></span>';
		MediumEditor.extensions.button.prototype.defaults.orderedlist.contentDefault = '<span class="dashicons dashicons-editor-ol"></span>';
		MediumEditor.extensions.button.prototype.defaults.unorderedlist.contentDefault = '<span class="dashicons dashicons-editor-ul"></span>';
		MediumEditor.extensions.button.prototype.defaults.removeFormat.contentDefault = '<span class="dashicons dashicons-editor-removeformatting"></span>';


		return new MediumEditor(elem, {
			// buttonLabels: 'fontawesome',
			imageDragging: false,
			toolbar: {
				buttons: [
				'bold', 
				'italic', 
				'unorderedlist',
				'orderedlist',  'h2', 'h3', 'removeFormat'],
				diffLeft: 25,
				diffTop: 10,
			},
		});
	}
}());