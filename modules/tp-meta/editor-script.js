/**
 * TP Meta js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Meta = DSLC.ModulesManager.AvailModules.DSLC_TP_Meta;

		Meta.prototype.changeOptionsBeforeRender = function(options)
		{
			var opt = options;
			opt.module_instance_id = this.settings.module_instance_id;
			opt.tp_elements.value = opt.tp_elements.value ? opt.tp_elements.value : opt.tp_elements.std;

			return options;
		}
	});
}());