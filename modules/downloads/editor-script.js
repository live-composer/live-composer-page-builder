/**
 * Downloads js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Downloads = DSLC.ModulesManager.AvailModules.DSLC_Downloads;

		Downloads.prototype.changeOptionsBeforeRender = function(options)
		{
			var opt = options;
			/**
			* Common
			*/

			opt.module_instance_id = this.settings.module_instance_id;
			opt.posts_per_row.value = opt.posts_per_row.value ? opt.posts_per_row.value : opt.posts_per_row.std;
			opt.columns_class = 'dslc-col dslc-' + 12 / opt.posts_per_row.value + '-col ';
			opt.count = 0;
			opt.real_count = 0;
			opt.separator_enabled.value = opt.separator_enabled.value ? opt.separator_enabled.value : opt.separator_enabled.std;
			opt.max_count = 12;
			opt.type.value = opt.type.value ? opt.type.value : opt.type.std;

			opt.main_location.value = opt.main_location.value ? opt.main_location.value : opt.main_location.std;
			opt.elements.value = opt.elements.value ? opt.elements.value : opt.elements.std;

			/**
			* Header
			*/
			opt.show_filters = false;
			opt.show_carousel_arrows = false;
			opt.show_view_all_link = false;

			opt.carousel_elements.value = opt.carousel_elements.value ?
												opt.carousel_elements.value :
			 									opt.carousel_elements.std;

			if(opt.elements.value.indexOf('filters') > -1 && opt.type.value !== 'carousel'){

				opt.show_filters = true;
			}

			if(opt.type.value == 'carousel' && 	opt.carousel_elements.value.indexOf('arrows') > -1){

				opt.show_carousel_arrows = true;
			}

			/**
			* Posts
			*/
			opt.post_elements.value = opt.post_elements.value ? opt.post_elements.value : opt.post_elements.std;

			/**
			* Dummy content
			*/
			opt.cats_array = [
				{
					cat_slug: 'troufle',
					cat_name: 'Troufle'
				},
				{
					cat_slug: 'icecream',
					cat_name: 'Icecream'
				},
				{
					cat_slug: 'cool_trees',
					cat_name: 'Cool trees'
				}
			];

			opt.download_tags = [
				{
					name: 'SEO'
				},
				{
					name: 'Marketing'
				}
			]

			opt.posts = [];

			var amount = opt.amount.value ? opt.amount.value : opt.amount.std;

			for(var i = 0; i < amount; i++){

				opt.posts.push({});
			}

			/**
			 * Classes generation
			 */

			// Posts container
			opt.container_class = 'dslc-posts dslc-downloads dslc-clearfix dslc-posts-orientation-' + opt.orientation.value + ' ';

			if(opt.type.value == 'masonry'){

				opt.container_class += 'dslc-init-masonry ';
			}else if(opt.type.value == 'grid'){

				opt.container_class += 'dslc-init-grid ';
			}

			// Post
			opt.element_class = 'dslc-post dslc-download ';

			if(opt.type.value == 'masonry'){

				opt.element_class += 'dslc-masonry-item ';
			}else if(opt.type.value == 'carousel'){

				opt.element_class += 'dslc-carousel-item ';
			}

			opt.extra_class = 'in-cat-all';
			opt.post_cats_data = {value: ''};
			opt.manual_resize = false;

			/**
			 * Carousel Items
			 */

			opt.carousel_items = opt.posts_per_row.value ? 12 / opt.posts_per_row.value : 6;

			return options;
		}
	});
}());