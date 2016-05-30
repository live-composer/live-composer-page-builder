/**
 * Gallery Slider js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Gallery_Slider = DSLC.ModulesManager.AvailModules.DSLC_TP_Gallery_Slider;

		Gallery_Slider.prototype.changeOptionsBeforeRender = function(options)
		{
			var opt = options;

			opt.module_instance_id = this.settings.module_instance_id;

			return options;
		}

		Gallery_Slider.prototype.afterRenderHook = function()
		{
			DSLCProd.Modules.gallerySlider.initCarousel();
		}
	});
}());