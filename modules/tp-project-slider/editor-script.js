/**
 * Project Slider js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Project_Slider = DSLC.ModulesManager.AvailModules.DSLC_TP_Project_Slider;

		Project_Slider.prototype.changeOptionsBeforeRender = function(options)
		{
			var opt = options;

			opt.module_instance_id = this.settings.module_instance_id;

			return options;
		}

		Project_Slider.prototype.afterRenderHook = function()
		{
			DSLCProd.Modules.projectSlider.initCarousel();
		}
	});
}());