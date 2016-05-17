/**
 * Accordion production JS
 */

'use strict'

;(function(){

	jQuery(document).ready(function($)
	{
		jQuery(document).on('click', '.dslc-accordion-hook', function()
		{
			var currSlide = $(this).closest('.dslc-accordion-item');
			var otherSlides = $(this).closest('.dslc-accordion').find('.dslc-accordion-item').not(currSlide);

			otherSlides.find('.dslc-accordion-content-wrapper').slideUp();
			currSlide.find('.dslc-accordion-content-wrapper').slideDown();

			return true;
		});
	});
}());