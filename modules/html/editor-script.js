/**
 * HTML editor script
 */
;'use strict';

(function(){

	var $ = jQuery;

	$(document).on('click', '.dslca-options-filter-hook[data-section="styling"]', function()
	{
		var module = DSLC.F.currEditedMod();
		var enable_css = module.getOption('css_custom');

		if(enable_css == 'disabled'){

			$(".tab-filter-container-styling").css('visibility', 'hidden');
			$(".tab-filter-options-container-styling__general_styling").addClass('dslc-html-module-hidden');
		}else{

			$(".tab-filter-container-styling").css('visibility', 'visible');
			$(".tab-filter-options-container-styling__general_styling").removeClass("dslc-html-module-hidden");
		}
	});

	$(document).on('DSLC_setOptionValue', function(e)
	{
		var data = e.message.details;

		if(data.module.settings.id != 'DSLC_Html') return false;

		if(data.optionId == 'css_custom'){

			if(data.value == 'disabled'){

				$(".tab-filter-container-styling").css('visibility', 'hidden');
				$(".tab-filter-options-container-styling__general_styling").addClass('dslc-html-module-hidden');
			}else{

				$(".tab-filter-container-styling").css('visibility', 'visible');
				$(".tab-filter-options-container-styling__general_styling").removeClass("dslc-html-module-hidden");
				dslc_module_options_scrollbar();
			}
		}
	});
}());