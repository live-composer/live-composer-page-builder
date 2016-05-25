/**
 * Downloads Button js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Excerpt = DSLC.ModulesManager.AvailModules.DSLC_TP_Excerpt;

		Excerpt.prototype.changeOptionsBeforeRender = function(options)
		{
			var opt = options;

			opt.module_instance_id = this.settings.module_instance_id;

			return options;
		}
	});
}());