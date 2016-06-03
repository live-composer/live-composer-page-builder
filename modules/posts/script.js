/**
 * Posts production scripts
 */

'use strict'

;(function(){

	/**
	 * Filter
	 */

	jQuery(document).on('click', '.dslc-post-filter.dslc-posts-module', function($){

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

	/**
	 * Carousel
	 */

	jQuery(document).ready(function($)
	{
		DSLCProd.Modules.postsSlider.initCarousel();
	});

	DSLCProd.Modules.postsSlider = {};
	DSLCProd.Modules.postsSlider.initCarousel = function()
	{
		// Loop through each carousel
		jQuery('.dslc-carousel.gallery-slider').each(function(){

			// Variables
			var carousel, container, defSettings, usrSettings, settings;

			// Elements
			carousel = jQuery(this);
			container = carousel.closest('.dslc-module-front');

			if(container.closest('.dslc-modules-section').hasClass('dslc-no-columns-spacing'))
				var margin = 0;
			else
				var margin = (container.width() / 100 * 2.12766) / 2;

			if(carousel.hasClass('dslc-carousel')){
				carousel.find('.dslc-col').css({ 'margin-left' : margin, 'margin-right' : margin });
				carousel.css({ 'margin-left' : margin * -1, 'width' : carousel.width() + margin * 2 });
			}

			// Default settings
			defSettings = {
				items : 4,
				pagination : true,
				singleItem : false,
				itemsScaleUp : false,
				slideSpeed : 200,
				paginationSpeed : 800,
				rewindSpeed : 1000,
				autoPlay : false,
				stopOnHover : false,
				lazyLoad : false,
				lazyFollow : true,
				autoHeight : false,
				mouseDrag : true,
				touchDrag : true,
				addClassActive : true,
				transitionStyle : 'fade',
				scrollPerPage : true
			};

			// Custom Settings
			usrSettings ={
				items : carousel.data('columns'),
				pagination : carousel.data('pagination'),
				itemsScaleUp : carousel.data('scale-up'),
				slideSpeed : carousel.data('slide-speed'),
				paginationSpeed : carousel.data('pagination-speed'),
				rewindSpeed : carousel.data('rewind-speed'),
				autoPlay : carousel.data('autoplay'),
				stopOnHover : carousel.data('stop-on-hover'),
				lazyLoad : carousel.data('lazy-load'),
				lazyFollow : carousel.data('lazy-follow'),
				autoHeight : carousel.data('flexible-height'),
				mouseDrag : carousel.data('mouse-drag'),
				touchDrag : carousel.data('touch-drag'),
				addClassActive : carousel.data('active-class'),
				transitionStyle : carousel.data('animation'),
				scrollPerPage : carousel.data('scroll-per-page')
			};

			// Merge default and custom settings
			settings = jQuery.extend({}, defSettings, usrSettings);

			// ifit's a slider set singleItem to true
			if(carousel.hasClass('dslc-slider') || settings.items == 1){
				settings.singleItem = true;
			}

			// ifautoplay is 0 set to false
			if(settings.autoPlay == 0)
				settings.autoPlay = false;

			// Initialize
			carousel.owlCarousel({

				items : settings.items,
				pagination : settings.pagination,
				singleItem : settings.singleItem,
				itemsScaleUp : settings.itemsScaleUp,
				slideSpeed : settings.slideSpeed,
				paginationSpeed : settings.paginationSpeed,
				rewindSpeed : settings.rewindSpeed,
				autoPlay : settings.autoPlay,
				stopOnHover : settings.stopOnHover,
				lazyLoad : settings.lazyLoad,
				lazyFollow : settings.lazyFollow,
				mouseDrag : settings.mouseDrag,
				touchDrag : settings.touchDrag,
				scrollPerPage : settings.scrollPerPage,
				transitionStyle : settings.transitionStyle,
				autoHeight : settings.autoHeight,
				itemsDesktop : false,
				itemsDesktopSmall : false,
				itemsTablet : false,
				itemsMobile : [766,1],
				afterInit: function(){
					carousel.prev('.dslc-loader').remove();
					carousel.css({
						opacity : 1,
						maxHeight : 'none'
					});
				},
				afterAction : function(){
					var visible_items = this.owl.visibleItems;
					carousel.find('.dslc-carousel-item-visible').removeClass('dslc-carousel-item-visible');
					carousel.find('.owl-item').filter(function(index){
						return visible_items.indexOf(index) > -1;
					}).addClass('dslc-carousel-item-visible');
				}

			});

			// Previous
			jQuery('.dslc-carousel-nav-next', container).click(function(e){
				e.preventDefault();
				carousel.data('owlCarousel').next();
			});

			// Next
			jQuery('.dslc-carousel-nav-prev', container).click(function(e){
				e.preventDefault();
				carousel.data('owlCarousel').prev();
			});
		});
	}
}());