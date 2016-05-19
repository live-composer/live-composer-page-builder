/**
 * Posts js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Posts = DSLC.ModulesManager.AvailModules.DSLC_Posts;

		Posts.prototype.changeOptionsBeforeRender = function(options)
		{
			options.module_instance_id = this.settings.module_instance_id;
			/**
			 * Unnamed
			 */

				options.columns_class = 'dslc-col dslc-' + options.columns.value + '-col ';
				options.count = 0;
				options.real_count = 0;
				options.increment = options.columns.value;
				options.max_count = 12;

			/**
			 * Elements to show
			 */

				// Post Elements
				var post_elements = options.post_elements.value;
				if ( post_elements ) {

					options.post_elements.value = options.post_elements.value.trim().split();
				} else {

					options.post_elements.value = 'all';
				}

				// Carousel Elements
				var carousel_elements = options.carousel_elements.value;
				if ( carousel_elements && ! Array.isArray(carousel_elements) ) {

					options.carousel_elements.value = options.carousel_elements.value.trim().split(' ');
				} else {

					options.carousel_elements.value = [];
				}
			/**
			 * Classes generation
			 */

			// Posts container
			options.container_class = 'dslc-posts dslc-cpt-posts dslc-clearfix dslc-cpt-posts-type-' +
				options.type.value + ' dslc-posts-orientation-' + options.orientation.value + ' ';

			if(options.type.value == 'masonry'){

				options.container_class += 'dslc-init-masonry ';
			}else if(options.type.value == 'grid'){

				options.container_class += 'dslc-init-grid ';
			}

			// Post
			options.element_class = 'dslc-post dslc-cpt-post ';

			if(options.type.value == 'masonry'){

				options.element_class += 'dslc-masonry-item ';
			}else if(options.type.value == 'carousel'){

				options.element_class += 'dslc-carousel-item ';
			}

			options.extra_class = '';
			options.post_cats_data = {value: ''};
			options.manual_resize = false;

			/**
			 * What is shown
			 */

			options.show_header = false;
			options.show_heading = false;
			options.show_filters = false;
			options.show_carousel_arrows = false;
			options.show_view_all_link = false;

			if(options.elements.main_heading){

				options.show_heading = true;
			}

			if(( options.elements == 'all' || options.elements.filters ) && options.type.value !== 'carousel' ){

				options.show_filters = true;
			}

			if(options.type.value == 'carousel' && options.carousel_elements.arrows){

				options.show_carousel_arrows = true;
			}

			if(options.show_heading || options.show_filters || options.show_carousel_arrows){

				options.show_header = true;
			}

			/**
			 * Carousel Items
			 */

			switch(options.columns.value){
				case 12 :
					options.carousel_items = 1;
					break;
				case 6 :
					options.carousel_items = 2;
					break;
				case 4 :
					options.carousel_items = 3;
					break;
				case 3 :
					options.carousel_items = 4;
					break;
				case 2 :
					options.carousel_items = 6;
					break;
				default:
					options.carousel_items = 6;
					break;
			}

			var amount = options.amount.value ? options.amount.value : options.amount.std;
			options.posts = [];

			for(var i = 0; i < amount; i++){

				options.posts.push(true);
			}

			return options;
		}
	});
}());