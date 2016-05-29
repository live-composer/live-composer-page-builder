/**
 * Galleries production scripts
 */

'use strict'

;(function(){

	/**
	 * Filter
	 */

	jQuery(document).on('click', '.dslc-post-filter.dslc-galleries-module', function($){

		$ = jQuery;
		// Get info
		var dslcCat = $(this).data('id');
		var dslcWrapper = $(this).closest('.dslc-module-front');
		var dslcPosts = dslcWrapper.find('.dslc-post');
		var dslcFilterPosts = dslcWrapper.find('.dslc-post.in-cat-' + dslcCat);
		var dslcNotFilterPosts = dslcWrapper.find('.dslc-post:not(.in-cat-'+ dslcCat + ')');
		var dslcContainer = dslcPosts.closest('.dslc-posts');

		// Set active
		$(this).removeClass('dslc-inactive').addClass('dslc-active').siblings('.dslc-active').removeClass('dslc-active').addClass('dslc-inactive');

		if(dslcContainer.hasClass('dslc-init-grid')){

			dslcFilterPosts.stop().animate({
				opacity : 1
			}, 300);

			dslcNotFilterPosts.stop().animate({
				opacity : 0.3
			}, 300);

		}else{

			// Hide posts

			dslcNotFilterPosts.removeClass('dslc-masonry-item dslc-masonry-item-animate').css({ visibility : 'hidden' });
			dslcFilterPosts.addClass('dslc-masonry-item dslc-masonry-item-animate').css({ visibility : 'visible' }).show();

			dslc_masonry(dslcWrapper, true);

		}

	});
}());