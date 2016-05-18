/**
 * Posts js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Posts = DSLC.ModulesManager.AvailModules.DSLC_Posts;

		Posts.prototype.changeOptionsBeforeRender = function(options)
		{
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
				post_elements = options['post_elements'];
				if ( ! empty( post_elements ) )
					post_elements = explode( ' ', trim( post_elements ) );
				else
					post_elements = 'all';

				// Carousel Elements
				carousel_elements = options['carousel_elements'];
				if ( ! empty( carousel_elements ) )
					carousel_elements = explode( ' ', trim( carousel_elements ) );
				else
					carousel_elements = array();
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

			return options;
		}
	});
}());