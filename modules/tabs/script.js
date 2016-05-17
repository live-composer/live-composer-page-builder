/**
 * Tabs production JS
 */

'use strict'

;(function(){

	jQuery(document).ready(function($)
	{
		jQuery(document).on('click', '.dslc-tabs-nav-hook', function(e){

			if(!jQuery(this).hasClass('dslc-active')){

				var dslcTabs = jQuery(this).closest('.dslc-tabs');
				var dslcTabsNav = jQuery('.dslc-tabs-nav', dslcTabs);
				var dslcTabsContent = jQuery('.dslc-tabs-content', dslcTabs);
				var dslcTabContent = jQuery('.dslc-tabs-tab-content', dslcTabs);
				var dslcTabIndex = jQuery(this).index();

				// Tabs nav
				jQuery('.dslc-tabs-nav-hook.dslc-active', dslcTabs).removeClass('dslc-active');
				jQuery(this).addClass('dslc-active');

				// Tabs content

				if(jQuery('.dslc-tabs-tab-content.dslc-active', dslcTabs).length){

					jQuery('.dslc-tabs-tab-content.dslc-active', dslcTabs).animate({
						opacity : 0
					}, 250, function(){
						jQuery(this).removeClass('dslc-active');
						dslcTabContent.eq(dslcTabIndex).css({ opacity : 0 }).addClass('dslc-active').show().animate({
							opacity : 1
						}, 250);
					});

				}else{
					dslcTabContent.eq(dslcTabIndex).css({ opacity : 0 }).addClass('dslc-active').show().animate({
						opacity : 1
					}, 250);
				}
			}
		});
	});
}());