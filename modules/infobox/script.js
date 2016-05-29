/**
 * Infobox js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		DSLC.ModulesManager.AvailModules.DSLC_Info_Box.prototype.changeOptionsBeforeRender = function(options)
		{
			/// Change elements
			var elements = typeof options.elements.value != 'undefined' ? options.elements.value : options.elements.std;

			if(!Array.isArray(elements)){

				if(elements != ''){

					elements = elements.trim().split(' ');
				}else{

					elements = [];
				}
			}

			options.elements.show_elements = {};

			[].forEach.call(elements, function(item){
				options.elements.show_elements[item] = true;
			});

			options['dslc_is_admin'] = true;

			return options;
		}

		jQuery(document).on('DSLC_setOptionValue', function(e)
		{
			var data = e.message.details;

			if(data.module.settings.id != 'DSLC_Info_Box') return false;

			if(data.optionId == 'elements'){

				var allElems = 'icon title content button image';
				var currValue = data.module.getOption('elements');

				allElems.split(' ').forEach(function(item){

					if(item == 'button'){

						var elem = jQuery(".dslca-module-edit-options-tab-hook[data-id='secondary_button'], .dslca-module-edit-options-tab-hook[data-id='primary_button']");
					}else{

						var elem = jQuery(".dslca-module-edit-options-tab-hook[data-id='" + item + "']");
					}

					if(currValue.indexOf(item) > -1){

						elem.removeClass('hide-hook');
					}else{

						elem.addClass('hide-hook');
					}
				});
			}
		});

		jQuery(document).on('DSLC_tabHooksRendered', function(e)
		{
			var data = e.message.details;

			if(data.module.settings.id != 'DSLC_Info_Box') return false;

			var allElems = 'icon title content button image';
			var elementsOn = data.module.getOption('elements');

			allElems.split(' ').forEach(function(item){

				if(item == 'button'){

					var elem = jQuery(".dslca-module-edit-options-tab-hook[data-id='secondary_button'], .dslca-module-edit-options-tab-hook[data-id='primary_button']");
				}else{

					var elem = jQuery(".dslca-module-edit-options-tab-hook[data-id='" + item + "']");
				}

				if(elementsOn.indexOf(item) > -1){

					elem.removeClass('hide-hook');
				}else{

					elem.addClass('hide-hook');
				}
			});
		});
	});
}());