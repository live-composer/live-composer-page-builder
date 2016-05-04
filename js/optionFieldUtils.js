/**
 * Option field utils
 *
 * Contains extendings for field options
 */

'use strict';

;(function(){

	/**
	 * Image option field
	 */
	DSLC.optionFieldUtils.image = {};
	DSLC.optionFieldUtils.image.fixCrashedUrl = function()
	{
		var fieldId = jQuery(this).closest(".dslca-module-edit-option").data("id");
		var module = DSLC.F.currEditedMod();
		var attachInfo = {id: module.values[fieldId].id};

		if(module.settings.id == 'DSLC_Image'){

			attachInfo.width = module.values.resize_width;
			attachInfo.height = module.values.resize_height;
		}

		jQuery.post(
		    DSLCAjax.ajaxurl,
			{
				action: 'dslc-callback-request',
				dslc: 'active',
				method: 'getInvalidAttachURL',
				params: {
					moduleId: module.moduleInfo.id,
					additional: {
						postId: module.settings.postId
					},
					attach: attachInfo
				}
			},
			'json')
		.done(function(response)
		{
			module
				.setOption(fieldId, response.attach)
				.reloadModuleBody()
				.saveEdits();
		})
		.fail(function()
		{
			module
				.setOption(fieldId, "")
				.reloadModuleBody()
				.saveEdits();
		});
	}

	/**
	 * Icon option field
	 */
	DSLC.optionFieldUtils.icon = {};
	DSLC.optionFieldUtils.icon.setIconSet = function()
	{
	}
}());