/**
 * Table of Contents
 *
 * - dslc_responsive_classes
 * - dslc_init_lightbox
 * - dslc_bg_video (Initiate row BG video)
 * - dslc_parallax
 * - dslc_masonry
 * - dslc_browser_classes
 * - dslc_center
 * - dslc_init_square
 * - dslc_check_viewport (Check ifelement in viewport)
 * - dslc_validate_comment_form
 * - dslc_social_share
 */

/**
 * Responsive Classes
 */

function dslc_responsive_classes(force){

	if(force === undefined) force = false;
	var windowWidth = jQuery(window).width();
	var body = jQuery('body');

	if(force == true || (!body.hasClass('dslc-res-disabled') && !jQuery('.dslca-module-edit-options-tab-hook.dslca-active[data-section="responsive"]').length)){

		body.removeClass('dslc-res-phone dslc-res-tablet dslc-res-smaller-monitor dslc-res-big');

		if(windowWidth >= 1024 && windowWidth < 1280)
			body.addClass('dslc-res-smaller-monitor');
		else if(windowWidth >= 768 && windowWidth < 1024)
			body.addClass('dslc-res-tablet');
		else if(windowWidth < 768)
			body.addClass('dslc-res-phone');
		else
			body.addClass('dslc-res-big');
	}

	if(!body.hasClass('dslca-enabled')){

		if(windowWidth >= 768 && windowWidth < 1024){

			jQuery('.dslc-modules-area').each(function(){

				if(
				   jQuery(this).find('.dslc-module-front').length != 0 &&
				   jQuery(this).find('.dslc-module-front').length == jQuery(this).find('.dslc-module-front.dslc-hide-on-tablet').length
				){

					jQuery(this).hide();
				}else{

					jQuery(this).show();
				}
			});

		}else if(windowWidth < 768){

			jQuery('.dslc-modules-area').each(function(){

				if(jQuery(this).find('.dslc-module-front').length != 0 &&
				   jQuery(this).find('.dslc-module-front').length == jQuery(this).find('.dslc-module-front.dslc-hide-on-phone').length
				){

					jQuery(this).hide();
				}else{

					jQuery(this).show();
				}
			});
		}else{

			jQuery('.dslc-modules-area').each(function(){

				if(
				   jQuery(this).find('.dslc-module-front').length != 0 &&
				   jQuery(this).find('.dslc-module-front').length == jQuery(this).find('.dslc-module-front.dslc-hide-on-desktop').length
				){

					jQuery(this).hide();
				}else{

					jQuery(this).show();
				}
			});
		}

		jQuery('.dslc-modules-section').each(function(){

			jQuery(this).show();

			if(jQuery(this).find('.dslc-modules-area').length == jQuery(this).find('.dslc-modules-area:not(:visible)').length){
				jQuery(this).hide();
			}
		});

	}

	dslc_masonry();
	dslc_center();

}


/**
 * Init Lightbox
 */

function dslc_init_lightbox(){

	var type;

	jQuery('.dslc-lightbox-image').each(function(){

		if(jQuery(this).attr('url_type') != undefined){

			type = jQuery(this).attr('url_type');
		}else{

			// Default type
			type = 'image';

			// Check ifvideo
			if(jQuery(this).attr('href').indexOf('youtube.com') >= 0 || jQuery(this).attr('href').indexOf('vimeo.com') >= 0){
				type = 'iframe';
			}
		}

		jQuery(this).magnificPopup({ type: type });

	});

	jQuery('.dslc-lightbox-gallery').each(function(){
		jQuery(this).magnificPopup({ delegate : 'a', type:'image', gallery:{ enabled: true }});
	});

}

/**
 * Fix responsivness of carousel
 */

function dslc_carousel_responsive(){

	// Loop through each carousel
	jQuery('.dslc-carousel').each(function(){

		// Variables
		var carousel, container;

		// Elements
		carousel = jQuery(this);
		container = carousel.closest('.dslc-module-front');

		carousel.css({ 'margin-left' : 0, 'width' : 'auto' });

		if(container.closest('.dslc-modules-section').hasClass('dslc-no-columns-spacing'))
			var margin = 0;
		else
			var margin = (container.width() / 100 * 2.12766) / 2;

		if(carousel.hasClass('dslc-carousel')){
			carousel.find('.dslc-col').css({ 'margin-left' : margin, 'margin-right' : margin });
			carousel.css({ 'margin-left' : margin * -1, 'width' : carousel.width() + margin * 2 });
		}

	});

}

/**
 * Initiate Video
 */

function dslc_bg_video(){

	jQuery('.dslc-bg-video').each(function(){
		if(!jQuery(this).find('video').length){
			jQuery(this).css({ opacity : 1 });
		}
	});

	jQuery('.dslc-bg-video video').mediaelementplayer({
		loop: true,
		pauseOtherPlayers: false,
		success: function(mediaElement, domObject){

			mediaElement.addEventListener('loadeddata', function (e){
				jQuery(domObject).closest('.dslc-bg-video').animate({ opacity : 1 }, 400);
			});

			mediaElement.play();
		}
	});
}

/**
 * Initiate Parallax
 */

function dslc_parallax(){

	jQuery('.dslc-init-parallax').each(function(){

		var dslcSpeed = 4,
		bgPosition = jQuery(this).css('background-position').split(' '),
		bgPositionHor = bgPosition[0],
		dslcPos = bgPositionHor + " " + (-1 * (window.pageYOffset - jQuery(this).offset().top) / dslcSpeed) + "px";

		jQuery(this).css({ backgroundPosition : dslcPos });

	});

	window.onscroll = function(){
		jQuery('.dslc-init-parallax').each(function(){

			var dslcSpeed = 4,
			bgPosition = jQuery(this).css('background-position').split(' '),
			bgPositionHor = bgPosition[0],
			dslcPos = bgPositionHor + " " + (-1 * (window.pageYOffset - jQuery(this).offset().top) / dslcSpeed) + "px";

			jQuery(this).css({ backgroundPosition : dslcPos });

		});
	}

}

/**
 * Initiate Masonry
 */

function dslc_masonry(dslcWrapper, dslcAnimate){

	dslcWrapper = typeof dslcWrapper !== 'undefined' ? dslcWrapper : jQuery('body');
	dslcAnimate = typeof dslcAnimate !== 'undefined' ? dslcAnimate : false;

	jQuery('.dslc-init-masonry', dslcWrapper).each(function(){

		var dslcContainer, dslcSelector, dslcItems, dslcItemWidth, dslcContainerWidth, dslcGutterWidth;

		if(jQuery(this).find('.dslc-posts-inner').length)
			dslcContainer = jQuery(this).find('.dslc-posts-inner');
		else
			dslcContainer = jQuery(this);

		dslcSelector = '.dslc-masonry-item';
		dslcItemWidth = jQuery(dslcSelector, dslcContainer).width();
		dslcContainerWidth = jQuery(dslcContainer).width();

		if(jQuery(this).closest('.dslc-modules-section').hasClass('dslc-no-columns-spacing'))
			dslcGutterWidth = 0;
		else
			dslcGutterWidth = dslcContainerWidth / 100 * 2.05;

		if(dslcContainer.data('masonry')){

			jQuery(dslcContainer).waitForImages(function(){

				jQuery(dslcContainer).masonry('destroy').masonry({
					gutter : dslcGutterWidth,
					itemSelector : dslcSelector
				});

				jQuery(dslcContainer).find('.dslc-post:not(.dslc-masonry-item)').hide();

				if(dslcAnimate){

					jQuery(dslcSelector, dslcContainer).css({ 'scale' : '0.2'}).animate({
						'scale' : '1'
					}, 500);

				}

			});

		}else{

			jQuery(dslcSelector).css({ marginRight : 0 });

			jQuery(dslcContainer).waitForImages(function(){

				jQuery(dslcContainer).masonry({
					gutter : dslcGutterWidth,
					itemSelector : dslcSelector
				});

			});

		}

	});

}

/**
 * Broser class
 */

function dslc_browser_classes(){

	var os = [
	    'iphone',
	    'ipad',
	    'windows',
	    'mac',
	    'linux'
	];

	var match = navigator.appVersion.toLowerCase().match(new RegExp(os.join('|')));
	if(match){
	    jQuery('body').addClass(match[0]);
	};

}

/**
 * Center element inside parent
 */

function dslc_center(){

	var dslcElement, dslcContainer, dslcElementHeight, dslcContainerHeight, dslcElementWidth, dslcContainerWidth, dslcTopOffset, dslcLeftOffset;

	jQuery('.dslc-init-center').each(function(){

		// Get elements
		dslcElement = jQuery(this);
		dslcContainer = dslcElement.parent();

		// Get height and width
		dslcElementWidth = dslcElement.outerWidth();
		dslcElementHeight = dslcElement.outerHeight();
		dslcContainerWidth = dslcContainer.width();
		dslcContainerHeight = dslcContainer.height();

		// Get center offset
		dslcTopOffset = dslcContainerHeight / 2 - dslcElementHeight / 2;
		dslcLeftOffset = dslcContainerWidth / 2 - dslcElementWidth / 2;

		// Apply offset
		if(dslcTopOffset > 0){
			dslcElement.css({ top : dslcTopOffset, left : dslcLeftOffset });
			dslcElement.css({ visibility : 'visible' });
		}

	});

	jQuery('.dslc-navigation .menu > li:has(ul):not(:has(.dslc-navigation-arrow)) > a').after('<span class="dslc-navigation-arrow dslc-icon dslc-icon-chevron-down"></span>');

}

/**
 * Make element squared
 */

function dslc_init_square(dslcWrapper){

	dslcWrapper = typeof dslcWrapper !== 'undefined' ? dslcWrapper : jQuery('body');

	var dslcElement, dslcHeight, dslcWidth;

	jQuery('.dslc-init-square', dslcWrapper).each(function(){

		dslcElement = jQuery(this);
		dslcElement.css({ width : 'auto', height : 'auto' });
		dslcHeight = dslcElement.height();
		dslcWidth = dslcElement.width();

		if(dslcHeight > dslcWidth)
			dslcElement.width(dslcHeight);
		else
			dslcElement.height(dslcWidth);

	});

}

/**
 * Check if element in viewport
 */

function dslc_check_viewport(){

	var isIE = /*@cc_on!@*/false || !!document.documentMode;
	if(!isIE){

		jQuery('.dslc-in-viewport-check:in-viewport:not(.dslc-in-viewport)').each(function(){

			var _this = jQuery(this);
			var anim = _this.data('dslc-anim');
			var animDuration = parseInt(_this.data('dslc-anim-duration')) / 1000;

			var anim_speed = animDuration + 's';
			if(jQuery(window).width() < 768)
				anim_speed = '0s';

			var anim_delay = parseInt(_this.data('dslc-anim-delay'));
			var anim_easing =  _this.data('dslc-anim-easing');
			var anim_params = anim + ' ' + anim_speed + ' ' + anim_easing + ' forwards';

			jQuery(this).addClass('dslc-in-viewport');

			if(anim_delay > 0){

				setTimeout(function(){
					_this.css({
						'-webkit-animation': anim_params,
						'-moz-animation': anim_params,
						animation: anim_params
					});
				}, anim_delay);

			}else{

				_this.css({
					'-webkit-animation': anim_params,
					'-moz-animation': anim_params,
					animation: anim_params
				});
			}

		});

	}else{

		jQuery('.dslc-in-viewport-check').css('opacity', 1);

	}

}

/**
 * Animation of elements on hover (posts modules)
 */

function dslc_el_anim_hover(){

	jQuery('.dslc-on-hover-anim-target').each(function(){

		var anim_speed = parseInt(jQuery(this).data('dslc-anim-speed')) / 1000;
		var anim_value = 'all ' + anim_speed + 's ease-out';

		jQuery(this).css({
			'-webkit-transition' : anim_value,
			'-moz-transition' : anim_value,
			'transition' : anim_value
		});
	});

}

/**
 * Progress Bar - Check viewport and animate
 */

function dslc_check_progress_bar_viewport(){

	jQuery('.dslc-progress-bar-animated:in-viewport:not(.dslc-progress-bar-in-viewport)').each(function(){

		var dslcWrapper = jQuery(this),
		dslcEl = dslcWrapper.find('.dslc-progress-bar-loader-inner'),
		dslcVal = dslcEl.data('amount') + '%',
		dslcSpeed = dslcEl.data('speed');

		dslcWrapper.addClass('dslc-progress-bar-in-viewport');

		dslcEl.css({ width : 0, opacity : 1 }).animate({ width : dslcVal }, dslcSpeed);

	});

}

/**
 * Validate Comment Form
 */

function dslc_validate_comment_form(commentForm){

	var commentName = commentForm.find('#author'),
	commentEmail = commentForm.find('#email'),
	commentWebsite = commentForm.find('#url'),
	commentMessage = commentForm.find('#comment'),
	commentStatus = true;

	// Name
	if(commentName.length && commentName.val().length == 0){
		commentName.css({ borderColor : '#e55f5f' });
		commentStatus = false;
	}else{
		commentName.attr('style', '');
	}

	// Email
	if(commentEmail.length && (commentEmail.val().length == 0 || commentEmail.val().indexOf('@') === -1)){
		commentEmail.css({ borderColor : '#e55f5f' });
		commentStatus = false;
	}else{
		commentEmail.attr('style', '');
	}

	// Message
	if(commentMessage.val().length == 0){
		commentMessage.css({ borderColor : '#e55f5f' });
		commentStatus = false;
	}else{
		commentMessage.attr('style', '');
	}

	return commentStatus;

}

/**
 * Social Sharing
 */
function dslc_social_share(width, height, url){

	var leftPosition, topPosition, u, t;
	//Allow for borders.
	leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
	//Allow for title and status bars.
	topPosition = (window.screen.height / 2) - ((height / 2) + 50);
	var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
	u=location.href;
	t=document.title;
	window.open(url,'sharer', windowFeatures);
	return false;

}

jQuery(document).ready(function($){

	dslc_el_anim_hover();
	dslc_browser_classes();
	dslc_bg_video();
	dslc_init_square();
	dslc_center();

	// Load More Posts
	$(document).on('click', '.dslc-pagination-load-more a', function(e){

		e.preventDefault();

		if($(this).parent().hasClass('dslc-active')){

			var _this = $(this),
			module = $(this).closest('.dslc-module-front'),
			pagination = module.find('.dslc-pagination'),
			postsContainer = module.find('.dslc-posts-inner'),
			moduleID = module.attr('id'),
			pagLink = _this.attr('href'),
			tempHolder = module.find('.dslc-load-more-temp');

			_this.find('.dslc-icon').addClass('dslc-icon-spin');

			tempHolder.load(pagLink + ' #' + moduleID, function(){

				postsContainer.append('<div class="dslc-post-separator"></div>');
				postsContainer.append(tempHolder.find('.dslc-posts-inner').html());

				module.find('.dslc-pagination').html(tempHolder.find('.dslc-pagination').html());

				pagination.replaceWith(tempHolder.find('.dslc-pagination'));

				tempHolder.html('');

				postsContainer.imagesLoaded(function(){
					if(module.find('.dslc-init-masonry').length){
						module.find('.dslc-init-masonry .dslc-posts-inner').masonry("reloadItems").masonry();
					}
				});

			});
		}

	});

	// Comment Form Validation
	$('.dslc-tp-comment-form form').submit(function(e){

		if(!dslc_validate_comment_form(jQuery(this))){
			e.preventDefault();
		}

	});

	/**
	 * Mobile Nav
	 */

   	jQuery('.dslc-mobile-navigation select').change(function(){
		window.location = $(this).val();
	});


	// Close Notification
	$(document).on('click', '.dslc-notification-close', function(e){
		$(this).closest('.dslc-notification').slideUp(200, function(){
			$(this).remove();
		});
	});

	/**
	 * Lightbox
	 */

	dslc_init_lightbox();


	$(document).on('click', '.dslc-trigger-lightbox-gallery', function(e){

		e.preventDefault();

		if(jQuery(this).closest('.dslc-post').length){

			jQuery(this).closest('.dslc-post').find('.dslc-lightbox-gallery a:first-child').trigger('click');

		}else if(jQuery(this).closest('.dslc-col')){

			var imageIndex = jQuery(this).closest('.dslc-col').index();
			jQuery(this).closest('.dslc-module-front').find('.dslc-lightbox-gallery a:eq(' + imageIndex + ')').trigger('click');

		}else{

			jQuery(this).closest('.dslc-module-front').find('.dslc-lightbox-gallery a:first-child').trigger('click');

		}

	});

	dslc_check_viewport();
	dslc_check_progress_bar_viewport();

	$(document).on('scroll', function(){

		dslc_check_viewport();
		dslc_check_progress_bar_viewport();

	});

});

jQuery(window).load(function(){

	dslc_responsive_classes();
	dslc_parallax();
	dslc_init_square();
	dslc_center();
	dslc_init_lightbox();

});

jQuery(window).resize(function(){

	dslc_center();
	dslc_responsive_classes();
	dslc_carousel_responsive();

});