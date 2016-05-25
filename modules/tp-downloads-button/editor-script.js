/**
 * Downloads Button js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Downloads_Button = DSLC.ModulesManager.AvailModules.DSLC_TP_Downloads_Button;

		Downloads_Button.prototype.changeOptionsBeforeRender = function(options)
		{
			var opt = options;

			opt.module_instance_id = this.settings.module_instance_id;

			return options;
		}
	});
}());