/**
 * Navigation production scripts
 */

'use strict'

;(function(){

	jQuery(document).ready(function($)
	{
		jQuery(document).on("mouseenter", ".dslc-navigation li", function($){

			$ = jQuery;

			var subnav = $(this).children('ul');

			if(subnav.length){

				if($(this).closest('.dslc-navigation').hasClass('dslc-navigation-sub-position-center')){

					var parentWidth = $(this).closest('li').width(),
					subnavWidth = subnav.outerWidth(),
					offsetToCenter = parseInt(parentWidth) / 2 - parseInt(subnavWidth) / 2 + 'px';

					subnav.css({ 'left' : offsetToCenter });

				}

				// Display child menu
				subnav.css({ 'display' : 'block' });

				var elOffsetLeft = subnav.offset().left;
				var elWidth = subnav.outerWidth();
				var docWidth = $('body').width();

				if(docWidth < (elOffsetLeft + elWidth)){
					subnav.addClass('dslc-navigation-invert-subnav');
				}

				// Show child menu
				$(this).children('ul').stop().animate({ opacity : 1 }, 300);

			}

		}).on("mouseleave", "li", function(){

			$(this).children('ul').stop().animate({ opacity : 0 }, 300, function(){
				$(this).css({ 'display' : 'none' }).children('ul').removeClass('dslc-navigation-invert-subnav');
			});

		});
	});
}());