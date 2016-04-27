/**
 * Button js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		DSLC.ModulesManager.AvailModules.DSLC_Button.prototype.changeOptionsBeforeRender = function(options)
		{
			options.lightbox_final_url = '';

			if(options.button_target.value == 'lightbox' &&
			   typeof options.lightbox_image.value == 'object' &&
			   options.lightbox_image.value.url != ''){

				options.lightbox_final_url = options.lightbox_image.value.url;
			}else{

				if(options.button_url.value != '' && options.button_url.value != undefined){

					options.lightbox_final_url = options.button_url.value;
				}
			}
			var regexp = /jpg|jpeg|tiff|png|bmp/i;
			options.lightbox_url_type = 'image';

			if(options.lightbox_final_url.indexOf('youtube.com') > -1 ||
			   options.lightbox_final_url.indexOf('vimeo.com') > -1 ||
			   !regexp.test(options.lightbox_final_url)){

				options.lightbox_url_type = 'iframe';
			}

			options.dslc_is_admin = true;

			return options;
		}
	});
}());