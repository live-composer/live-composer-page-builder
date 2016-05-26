/**
 * Widgets js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Widgets = DSLC.ModulesManager.AvailModules.DSLC_Widgets;

		Widgets.prototype.changeOptionsBeforeRender = function(options)
		{
			var opt = options;

			opt.module_instance_id = this.settings.module_instance_id;

			return options;
		}
	});
}());