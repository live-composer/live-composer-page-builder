/**
 * Staff Social js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Staff_Social = DSLC.ModulesManager.AvailModules.DSLC_TP_Staff_Social;

		Staff_Social.prototype.changeOptionsBeforeRender = function(options)
		{
			var opt = options;

			opt.module_instance_id = this.settings.module_instance_id;

			return options;
		}
	});
}());