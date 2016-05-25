/**
 * Content js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Content = DSLC.ModulesManager.AvailModules.DSLC_TP_Content;

		Content.prototype.changeOptionsBeforeRender = function(options)
		{
			var opt = options;

			opt.module_instance_id = this.settings.module_instance_id;

			return options;
		}
	});
}());