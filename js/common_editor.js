/**
 * Common scripts for LC Editor
 */

/* Editor scripts */
DSLC.Editor = new (function()
{
	var $ = jQuery;

	this.dslc_init_medium_editor = function()
	{
		jQuery(".dslca-editable-content[contenteditable]").each(function(){

			if($(this).data('medium-editor-element') == null){

				var medium = new MediumEditor(this);
			}
		});
	}
})();