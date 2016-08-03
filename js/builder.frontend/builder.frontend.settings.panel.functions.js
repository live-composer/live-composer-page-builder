/**
 * Iframe settings panel functions
 */

;'use strict';

(function(){

	var self = DSLC_Iframe;

	DSLC_Iframe.initInlineEditors = function(elem){

		return tinyMCE.init({
			selector: '.inline-editor.dslca-editable-content',
			editor_deselector: 'mce-content-body',
			menubar: false,
		  	inline: true,
		  	plugins: 'link',
		  	style_formats: [
			    {title: 'Headers', items: [
			      {title: 'Header 1', format: 'h1'},
			      {title: 'Header 2', format: 'h2'},
			      {title: 'Header 3', format: 'h3'},
			      {title: 'Header 4', format: 'h4'},
			      {title: 'Header 5', format: 'h5'},
			      {title: 'Header 6', format: 'h6'}
			    ]},
			   /* {title: 'Inline', items: [
			      {title: 'Bold', icon: 'bold', format: 'bold'},
			      {title: 'Italic', icon: 'italic', format: 'italic'},
			      {title: 'Underline', icon: 'underline', format: 'underline'},
			      {title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
			      {title: 'Superscript', icon: 'superscript', format: 'superscript'},
			      {title: 'Subscript', icon: 'subscript', format: 'subscript'},
			      {title: 'Code', icon: 'code', format: 'code'}
			    ]},*/
			    {title: 'Blocks', items: [
			      {title: 'Paragraph', format: 'p'},
			     // {title: 'Blockquote', format: 'blockquote'},
			      {title: 'Div', format: 'div'},
			      {title: 'Pre', format: 'pre'}
			    ]},
			   /* {title: 'Alignment', items: [
			      {title: 'Left', icon: 'alignleft', format: 'alignleft'},
			      {title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
			      {title: 'Right', icon: 'alignright', format: 'alignright'},
			      {title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
			    ]}*/
			  ],
		  	toolbar: 'styleselect | bold italic blockquote | removeformat | link unlink | bullist numlist '
		});
	}
}());