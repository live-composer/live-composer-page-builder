/**
 * Download Button production JS
 */

'use strict'

;(function(){

	jQuery(document).ready(function($)
	{
		/**
		 * Notification Close
		 */

		$('.dslc-notification-box-has-timeout').each(function(){

			var nBox = $(this);
			nTimeout = 'none',
			moduleID = nBox.closest('.dslc-module-front').data('module-id'),
			cookieID = 'nBox' + moduleID;

			// Check timeout
			if(nBox.data('notification-timeout')){

				if(Cookies.get(cookieID) == undefined){
					nBox.show();
				}

			}
		});

		$(document).on('click', '.dslc-notification-box-close', function(){

			var nBox = $(this).closest('.dslc-notification-box'),
			nTimeout = 'none',
			moduleID = nBox.closest('.dslc-module-front').data('module-id'),
			cookieID = 'nBox' + moduleID;

			// Check timeout
			if(nBox.data('notification-timeout')){
				nTimeout = nBox.data('notification-timeout');
			}

			// Set cookie iftimeout exists
			if(nTimeout !== 'none'){
				Cookies.set(cookieID, 'closed',{ expires: nTimeout });
			}

			// Close with animation
			nBox.animate({
				opacity : 0
			}, 400, function(){
				$(this).remove();
			});

		});
	});

}());