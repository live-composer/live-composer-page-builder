<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_WooCommerce_Products extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_WooCommerce_Products';
		$this->module_title = __( 'Woo Products', 'live-composer-page-builder' );
		$this->module_icon = 'shopping-cart';
		$this->module_category = 'Post-Based';

	}

	/**
	 * Module options.
	 * Function build array with all the module functionality and styling options.
	 * Based on this array Live Composer builds module settings panel.
	 * – Every array inside $dslc_options means one option = one control.
	 * – Every option should have unique (for this module) id.
	 * – Options divides on "Functionality" and "Styling".
	 * – Styling options start with css_XXXXXXX
	 * – Responsive options start with css_res_t_ (Tablet) or css_res_p_ (Phone)
	 * – Options can be hidden.
	 * – Options can have a default value.
	 * – Options can request refresh from server on change or do live refresh via CSS.
	 *
	 * @return array All the module options in array.
	 */
	function options() {

		$cats = get_terms( 'product_cat' );
		$cats_choices = array();

		if ( $cats ) {
			foreach ( $cats as $cat ) {
				$cats_choices[] = array(
					'label' => $cat->name,
					'value' => $cat->slug
				);
			}
		}

		$dslc_options = array(

			array(
				'label' => __( 'Show On', 'live-composer-page-builder' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'live-composer-page-builder' ),
						'value' => 'desktop'
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet'
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone'
					),
				),
			),
			array(
				'label' => __( 'Type', 'live-composer-page-builder' ),
				'id' => 'type',
				'std' => 'grid',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Grid', 'live-composer-page-builder' ),
						'value' => 'grid',
					),
					array(
						'label' => __( 'Masonry Grid', 'live-composer-page-builder' ),
						'value' => 'masonry'
					),
					array(
						'label' => __( 'Carousel', 'live-composer-page-builder' ),
						'value' => 'carousel'
					)
				)
			),
			array(
				'label' => __( 'Orientation', 'live-composer-page-builder' ),
				'id' => 'orientation',
				'std' => 'vertical',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Vertical', 'live-composer-page-builder' ),
						'value' => 'vertical'
					),
					array(
						'label' => __( 'Horizontal', 'live-composer-page-builder' ),
						'value' => 'horizontal'
					)
				)
			),
			array(
				'label' => __( 'Posts Per Page', 'live-composer-page-builder' ),
				'id' => 'amount',
				'std' => '8',
				'type' => 'text',
			),
			array(
				'label' => __( 'Pagination', 'live-composer-page-builder' ),
				'id' => 'pagination_type',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Numbered', 'live-composer-page-builder' ),
						'value' => 'numbered',
					),
					array(
						'label' => __( 'Prev/Next', 'live-composer-page-builder' ),
						'value' => 'prevnext',
					),
					array(
						'label' => __( 'Load More', 'live-composer-page-builder' ),
						'value' => 'loadmore',
					),
				),
			),
			array(
				'label' => __( 'Items Per Row', 'live-composer-page-builder' ),
				'id' => 'columns',
				'std' => '3',
				'type' => 'select',
				'choices' => $this->shared_options( 'posts_per_row_choices' ),
			),
			array(
				'label' => __( 'Categories', 'live-composer-page-builder' ),
				'id' => 'categories',
				'std' => '',
				'type' => 'checkbox',
				'choices' => $cats_choices
			),
			array(
				'label' => __( 'Categories Operator', 'live-composer-page-builder' ),
				'id' => 'categories_operator',
				'std' => 'IN',
				'help' => __( '<strong>IN</strong> - Posts must be in at least one chosen category.<br><strong>AND</strong> - Posts must be in all chosen categories.<br><strong>NOT IN</strong> Posts must not be in the chosen categories.', 'live-composer-page-builder' ),
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'IN', 'live-composer-page-builder' ),
						'value' => 'IN',
					),
					array(
						'label' => __( 'AND', 'live-composer-page-builder' ),
						'value' => 'AND',
					),
					array(
						'label' => __( 'NOT IN', 'live-composer-page-builder' ),
						'value' => 'NOT IN',
					),
				)
			),
			array(
				'label' => __( 'Order By', 'live-composer-page-builder' ),
				'id' => 'orderby',
				'std' => 'date',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Publish Date', 'live-composer-page-builder' ),
						'value' => 'date'
					),
					array(
						'label' => __( 'Modified Date', 'live-composer-page-builder' ),
						'value' => 'modified'
					),
					array(
						'label' => __( 'Random', 'live-composer-page-builder' ),
						'value' => 'rand'
					),
					array(
						'label' => __( 'Alphabetic', 'live-composer-page-builder' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Comment Count', 'live-composer-page-builder' ),
						'value' => 'comment_count'
					),
					array(
						'label' => __( 'Price', 'live-composer-page-builder' ),
						'value' => 'price'
					),
				)
			),
			array(
				'label' => __( 'Order', 'live-composer-page-builder' ),
				'id' => 'order',
				'std' => 'DESC',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Ascending', 'live-composer-page-builder' ),
						'value' => 'ASC'
					),
					array(
						'label' => __( 'Descending', 'live-composer-page-builder' ),
						'value' => 'DESC'
					)
				)
			),
			array(
				'label' => __( 'Offset', 'live-composer-page-builder' ),
				'id' => 'offset',
				'std' => '0',
				'type' => 'text',
			),
			array(
				'label' => __( 'Out of Stock', 'live-composer-page-builder' ),
				'id' => 'outofstock',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Display out of stock products', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Do not display out of stock products', 'live-composer-page-builder' ),
						'value' => 'disabled'
					)
				)
			),
			array(
				'label' => __( 'Include (IDs)', 'live-composer-page-builder' ),
				'id' => 'query_post_in',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Exclude (IDs)', 'live-composer-page-builder' ),
				'id' => 'query_post_not_in',
				'std' => '',
				'type' => 'text',
			),

			// Archive Listinging
			array(
				'label' => __( 'Archive/Search Listing', 'live-composer-page-builder' ),
				'id' => 'query_alter',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Apply Page Query', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Ignore Page Query', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				),
				'help' => __( 'Apply Page Query – show posts according to the selected tag, category, author or search query.<br /> Ignore Page Query – ignore the page query and list posts as on any other page.', 'live-composer-page-builder' ),
			),

			/**
			 * General
			 */

			array(
				'label' => __( 'Elements', 'live-composer-page-builder' ),
				'id' => 'elements',
				'std' => '',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Heading', 'live-composer-page-builder' ),
						'value' => 'main_heading'
					),
					array(
						'label' => __( 'Filters', 'live-composer-page-builder' ),
						'value' => 'filters'
					),
				),
				'section' => 'styling',
			),

			array(
				'label' => __( 'Post Elements', 'live-composer-page-builder' ),
				'id' => 'post_elements',
				'std' => 'thumbnail price title separator exceprt price_2 addtocart details',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Thumbnail', 'live-composer-page-builder' ),
						'value' => 'thumbnail',
					),
					array(
						'label' => __( 'Price', 'live-composer-page-builder' ),
						'value' => 'price',
					),
					array(
						'label' => __( 'Title', 'live-composer-page-builder' ),
						'value' => 'title',
					),
					array(
						'label' => __( 'Separator', 'live-composer-page-builder' ),
						'value' => 'separator',
					),
					array(
						'label' => __( 'Excerpt', 'live-composer-page-builder' ),
						'value' => 'excerpt',
					),
					array(
						'label' => __( 'Price Secondary', 'live-composer-page-builder' ),
						'value' => 'price_2',
					),
					array(
						'label' => __( 'Add to cart', 'live-composer-page-builder' ),
						'value' => 'addtocart',
					),
					array(
						'label' => __( 'Details', 'live-composer-page-builder' ),
						'value' => 'details'
					)
				),
				'section' => 'styling',
			),

			array(
				'label' => __( 'Carousel Elements', 'live-composer-page-builder' ),
				'id' => 'carousel_elements',
				'std' => 'arrows circles',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Arrows', 'live-composer-page-builder' ),
						'value' => 'arrows'
					),
					array(
						'label' => __( 'Circles', 'live-composer-page-builder' ),
						'value' => 'circles'
					),
				),
				'section' => 'styling',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-products',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-products',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			),

			/**
			 * Separator
			 */

			array(
				'label' => __( 'Enable/Disable', 'live-composer-page-builder' ),
				'id' => 'separator_enabled',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				),
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_sep_border_color',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Height', 'live-composer-page-builder' ),
				'id' => 'css_sep_height',
				'std' => '32',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 0,
				'max' => 300,
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thickness', 'live-composer-page-builder' ),
				'id' => 'css_sep_thickness',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'border-bottom-width',
				'ext' => 'px',
				'min' => 0,
				'max' => 50,
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Style', 'live-composer-page-builder' ),
				'id' => 'css_sep_style',
				'std' => 'dashed',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Invisible', 'live-composer-page-builder' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Solid', 'live-composer-page-builder' ),
						'value' => 'solid'
					),
					array(
						'label' => __( 'Dashed', 'live-composer-page-builder' ),
						'value' => 'dashed'
					),
					array(
						'label' => __( 'Dotted', 'live-composer-page-builder' ),
						'value' => 'dotted'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'live-composer-page-builder' ),
			),

			/**
			 * Thumbnail
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_thumb_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_color',
				'std' => '#e6e6e6',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_width',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_thumb_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_border_radius_top',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner, .dslc-product-thumb img',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_border_radius_bottom',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner, .dslc-product-thumb img',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Height', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_height',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_width_manual',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Width', 'live-composer-page-builder' ),
				'id' => 'thumb_width',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-thumb',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'min' => 1,
				'max' => 100,
				'ext' => '%',
			),

			/**
			 * Price
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_price_bg_color',
				'std' => '#437bcf',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price-bg',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_price_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price-bg',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_price_border_width',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price-bg',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_price_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price-bg',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_price_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_price_border_radius',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '6',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price-bg',
				'affect_on_change_rule' => 'border-radius',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_price_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_price_font_weight',
				'std' => '400',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_price_font_family',
				'std' => 'Oswald',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_price_margin',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'margin',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Opacity', 'live-composer-page-builder' ),
				'id' => 'css_price_bg_opacity',
				'std' => '0.82',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price-bg',
				'affect_on_change_rule' => 'opacity',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
				'min' => 0,
				'max' => 1,
				'increment' => 0.01
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_price_padding',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'padding',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Position', 'live-composer-page-builder' ),
				'id' => 'price_pos',
				'std' => 'center',
				'type' => 'select',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'live-composer-page-builder' ),
						'value' => 'topleft'
					),
					array(
						'label' => __( 'Top Right', 'live-composer-page-builder' ),
						'value' => 'topright'
					),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center'
					),
					array(
						'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
						'value' => 'bottomleft'
					),
					array(
						'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
						'value' => 'bottomright'
					),
				)
			),

			/**
			 * Main
			 */

			array(
				'label' => __( 'Location', 'live-composer-page-builder' ),
				'id' => 'main_location',
				'std' => 'bellow',
				'type' => 'select',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Bellow Thumbnail', 'live-composer-page-builder' ),
						'value' => 'bellow'
					),
					array(
						'label' => __( 'Inside Thumbnail ( hover )', 'live-composer-page-builder' ),
						'value' => 'inside'
					),
					array(
						'label' => __( 'Inside Thumbnail ( always visible )', 'live-composer-page-builder' ),
						'value' => 'inside_visible'
					),
				),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_main_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_main_border_width',
				'min' => 0,
				'max' => 10,
				'increment' => 1,
				
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_main_border_trbl',
				'std' => 'right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_top',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_bottom',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_main_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'min' => 0,
				'max' => 500
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_main_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_main_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
			),

			/**
			 * Main Inner
			 */

			array(
				'label' => __( 'Position', 'live-composer-page-builder' ),
				'id' => 'main_position',
				'std' => 'center',
				'type' => 'select',
				'section' => 'styling',
				'tab' => __( 'Main Inner', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'live-composer-page-builder' ),
						'value' => 'topleft'
					),
					array(
						'label' => __( 'Top Right', 'live-composer-page-builder' ),
						'value' => 'topright'
					),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center'
					),
					array(
						'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
						'value' => 'bottomleft'
					),
					array(
						'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
						'value' => 'bottomright'
					),
				)
			),
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_main_inner_margin',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main-inner',
				'affect_on_change_rule' => 'margin',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main Inner', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Width', 'live-composer-page-builder' ),
				'id' => 'css_main_inner_width',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main-inner',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
				'ext' => '%',
				'tab' => __( 'Main Inner', 'live-composer-page-builder' ),
			),

			/**
			 * Title
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_title_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_title_color',
				'std' => '#636363',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2 a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_title_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2:hover a,.dslc-product-title h2 a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_title_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2,.dslc-product-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_title_font_weight',
				'std' => '700',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2,.dslc-product-title h2 a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_title_font_family',
				'std' => 'Lato',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2,.dslc-product-title h2 a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_title_line_height',
				'min' => 0,
				'max' => 120,
				'increment' => 1,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2,.dslc-product-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_title_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_title_margin_hor',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2 a',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_title_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'live-composer-page-builder' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Capitalize', 'live-composer-page-builder' ),
						'value' => 'capitalize'
					),
					array(
						'label' => __( 'Uppercase', 'live-composer-page-builder' ),
						'value' => 'uppercase'
					),
					array(
						'label' => __( 'Lowercase', 'live-composer-page-builder' ),
						'value' => 'lowercase'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			/**
			 * Excerpt
			 */

			array(
				'label' => __( 'Excerpt or Content', 'live-composer-page-builder' ),
				'id' => 'excerpt_or_content',
				'std' => 'excerpt',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Excerpt', 'live-composer-page-builder' ),
						'value' => 'excerpt'
					),
					array(
						'label' => __( 'Content', 'live-composer-page-builder' ),
						'value' => 'content'
					),
				),
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Bottom Color', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'border-bottom-color',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Bottom Width', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_border_width',
				'min' => 0,
				'max' => 10,
				'increment' => 1,
				
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'border-bottom-width',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_color',
				'std' => '#adadad',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_weight',
				'std' => '500',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_family',
				'std' => 'Muli',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_line_height',
				'min' => 0,
				'max' => 120,
				'increment' => 1,
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt, .dslc-product-excerpt p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'excerpt_margin',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Max Length ( amount of words )', 'live-composer-page-builder' ),
				'id' => 'excerpt_length',
				'std' => '17',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Bottom', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_padding',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_text_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
			),

			/**
			 * Price Secondary
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_price_2_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Price Secondary', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color ( Non-discount price )', 'live-composer-page-builder' ),
				'id' => 'css_price_2_non_discount_color',
				'std' => '#d1d1d1',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary del',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Price Secondary', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_price_2_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Price Secondary', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_price_2_font_weight',
				'std' => '400',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Price Secondary', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_price_2_font_family',
				'std' => 'Oswald',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Price Secondary', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Position', 'live-composer-page-builder' ),
				'id' => 'css_price_2_pos',
				'std' => 'right',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'float',
				'section' => 'styling',
				'tab' => __( 'Price Secondary', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
				)
			),

			/**
			 * Separator
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_sep_color',
				'std' => '#ebebeb',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-sep',
				'affect_on_change_rule' => 'border-bottom-color',
				'section' => 'styling',
				'tab' => __( 'Separator', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_sep_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-sep',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Separator', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/**
			 * Other
			 */

			array(
				'label' => __( 'Add to cart - Text', 'live-composer-page-builder' ),
				'id' => 'addtocart_text',
				'std' => 'Add to cart',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Add to cart - Color', 'live-composer-page-builder' ),
				'id' => 'css_addtocart_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Add to cart - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_addtocart_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Add to cart - Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_addtocart_font_weight',
				'std' => '700',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Add to cart - Font Family', 'live-composer-page-builder' ),
				'id' => 'css_addtocart_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Details - Text', 'live-composer-page-builder' ),
				'id' => 'details_text',
				'std' => 'Details',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Details - Color', 'live-composer-page-builder' ),
				'id' => 'css_details_color',
				'std' => '#8d8d8d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Details - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_details_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Details - Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_details_font_weight',
				'std' => '600',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Details - Font Family', 'live-composer-page-builder' ),
				'id' => 'css_details_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
				'id' => 'css_res_t',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_s_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-products',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Row Separator - Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_sep_height',
				'std' => '32',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 1,
				'max' => 300,
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumbnail_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumbnail_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Price - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_price_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Price - Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_t_price_margin',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'margin',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Price - Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_t_price_padding',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'padding',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_line_height',
				'min' => 0,
				'max' => 120,
				'increment' => 1,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Margin Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_margin_hor',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2 a',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_line_height',
				'min' => 0,
				'max' => 120,
				'increment' => 1,
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt, .dslc-product-excerpt p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_margin',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Excerpt - Padding Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_padding',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Price 2nd - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_price_2_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Separator - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_sep_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-sep',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Add to cart - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_addtocart_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Details - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_details_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
				'id' => 'css_res_p',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-products',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Row Separator - Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_sep_height',
				'std' => '32',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 1,
				'max' => 300,
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumbnail_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumbnail_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Price - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_price_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Price - Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_p_price_margin',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'margin',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Price - Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_p_price_padding',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'padding',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_line_height',
				'min' => 0,
				'max' => 120,
				'increment' => 1,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Margin Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_margin_hor',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2 a',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_line_height',
				'min' => 0,
				'max' => 120,
				'increment' => 1,
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt, .dslc-product-excerpt p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Excerpt - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_margin',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Excerpt - Padding Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_padding',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Price 2nd - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_price_2_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Separator - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_sep_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-sep',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Add to cart - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_addtocart_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Details - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_details_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'carousel_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'heading_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'filters_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'carousel_arrows_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'carousel_circles_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'pagination_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options' ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}
	/**
	 * Module HTML output.
	 *
	 * @param  array $options Module options to fill the module template.
	 * @return void
	 */
	function output( $options ) {

		if ( is_feed() ) {
			// Prevent category/tag feeds to stuck in an infinite loop
			return false;
		}

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;

		// Fix slashes on apostrophes
		if ( isset( $options['addtocart_text'] ) ) {
			$options['addtocart_text'] = stripslashes( $options['addtocart_text'] );
		}

		// Fix slashes on apostrophes
		if ( isset( $options['details_text'] ) ) {
			$options['details_text'] = stripslashes( $options['details_text'] );
		}

		$this->module_start( $options );

		if ( ! isset( $options['price_pos'] ) )
			$options['price_pos'] = 'center';

		if ( class_exists( 'Woocommerce' ) ) :

			/* Module output stars here */

				if ( $options['orderby'] == 'price' ) {
					$options['orderby'] = 'meta_value_num';
					$orderby = 'price';
				}

				if ( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

				// Fix for pagination from other modules affecting this one when pag disabled
				if ( $options['pagination_type'] == 'disabled' ) $paged = 1;

				// Fix for offset braking pagination
				$query_offset = $options['offset'];
				if ( $query_offset > 0 && $paged > 1 ) $query_offset = ( $paged - 1 ) * $options['amount'] + $options['offset'];

				$args = array(
					'paged' => $paged,
					'post_type' => 'product',
					'posts_per_page' => $options['amount'],
					'order' => $options['order'],
					'orderby' => $options['orderby'],
				);

				// Add offset
				if ( $query_offset > 0 ) {
					$args['offset'] = $query_offset;
				}

				if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
					$args['post_status'] = array('publish', 'private');
				}

				if ( isset( $options['categories'] ) && $options['categories'] != '' ) {

					$cats_array = explode( ' ', trim( $options['categories'] ) );

					$args['tax_query'] = array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'slug',
							'terms' => $cats_array,
							'operator' => $options['categories_operator']
						)
					);

				}

				if ( isset( $orderby ) && $orderby == 'price' ) {

					$args['meta_key'] = '_price';

				}

				// Exlcude and Include arrays
				$exclude = array();
				$include = array();

				// Exclude current post
				if ( is_singular( get_post_type() ) )
					$exclude[] = get_the_ID();

				// Exclude posts ( option )
				if ( $options['query_post_not_in'] )
					$exclude = array_merge( $exclude, explode( ' ', $options['query_post_not_in'] ) );

				// Include posts ( option )
				if ( $options['query_post_in'] )
					$include = array_merge( $include, explode( ' ', $options['query_post_in'] ) );

				// Include query parameter
				if ( ! empty( $include ) )
					$args['post__in'] = $include;

				// Exclude query parameter
				if ( ! empty( $exclude ) )
					$args['post__not_in'] = $exclude;

				// Author archive page
				if ( is_author() && $options['query_alter'] == 'enabled' ) {
					global $authordata;
					$args['author__in'] = array($authordata->data->ID);
				}

				// No paging
				if ( $options['pagination_type'] == 'disabled' )
					$args['no_found_rows'] = true;

				// Out of stock ( show/hide )
				if ( $options['outofstock'] == 'disabled' ) {
					$args['meta_query'] = array(
						array(
							'key'     => '_stock_status',
							'value'   => 'outofstock',
							'compare' => '!=',
						),
					);
				}

				// Do the query
				if ( ( is_category() || is_tag() || is_tax() || is_search() || is_date() ) && $options['query_alter'] == 'enabled' ) {
					global $wp_query;
					$dslc_query = $wp_query;
				} else {
					$dslc_query = new WP_Query( $args );
				}

				$columns_class = 'dslc-col dslc-' . $options['columns'] . '-col ';
				$count = 0;
				$real_count = 0;
				$increment = $options['columns'];
				$max_count = 12;

			/**
			 * Elements to show
			 */

				// Main Elements
				$elements = $options['elements'];
				if ( ! empty( $elements ) )
					$elements = explode( ' ', trim( $elements ) );
				else
					$elements = array();


				// Post Elements
				$post_elements = $options['post_elements'];
				if ( ! empty( $post_elements ) )
					$post_elements = explode( ' ', trim( $post_elements ) );
				else
					$post_elements = 'all';

				// Carousel Elements
				$carousel_elements = $options['carousel_elements'];
				if ( ! empty( $carousel_elements ) )
					$carousel_elements = explode( ' ', trim( $carousel_elements ) );
				else
					$carousel_elements = array();

				/* Container Class */

				$container_class = 'dslc-posts dslc-products dslc-clearfix dslc-products-type-' . $options['type'] . ' dslc-posts-orientation-' . $options['orientation'] . ' ';

				if ( $options['type'] == 'masonry' )
					$container_class .= 'dslc-init-masonry ';
				elseif ( $options['type'] == 'grid' )
					$container_class .= 'dslc-init-grid ';

				/* Element Class */

				$element_class = 'dslc-post dslc-product ';

				if ( $options['type'] == 'masonry' )
					$element_class .= 'dslc-masonry-item ';
				elseif ( $options['type'] == 'carousel' )
					$element_class .= 'dslc-carousel-item ';

				// Responsive
				//$element_class .= 'dslc-res-sm-' . $options['res_sm_columns'] . ' ';
				//$element_class .= 'dslc-res-tp-' . $options['res_tp_columns'] . ' ';

			/**
			 * What is shown
			 */

				$show_header = false;
				$show_heading = false;
				$show_filters = false;
				$show_carousel_arrows = false;
				$show_view_all_link = false;

				if ( in_array( 'main_heading', $elements ) )
					$show_heading = true;

				if ( ( $elements == 'all' || in_array( 'filters', $elements ) ) && $options['type'] !== 'carousel' )
					$show_filters = true;

				if ( $options['type'] == 'carousel' && in_array( 'arrows', $carousel_elements ) )
					$show_carousel_arrows = true;

				if ( $show_heading || $show_filters || $show_carousel_arrows )
					$show_header = true;

			/**
			 * Carousel Items
			 */

				switch ( $options['columns'] ) {
					case 12 :
						$carousel_items = 1;
						break;
					case 6 :
						$carousel_items = 2;
						break;
					case 4 :
						$carousel_items = 3;
						break;
					case 3 :
						$carousel_items = 4;
						break;
					case 2 :
						$carousel_items = 6;
						break;
					default:
						$carousel_items = 6;
						break;
				}

			/**
			 * Heading ( output )
			 */

				if ( $show_header ) :
					?>
						<div class="dslc-module-heading">

							<!-- Heading -->

							<?php if ( $show_heading ) : ?>

								<h2 class="dslca-editable-content" data-id="main_heading_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?> ><?php echo stripslashes( $options['main_heading_title'] ); ?></h2>

								<!-- View all -->

								<?php if ( isset( $options['view_all_link'] ) && $options['view_all_link'] !== '' ) : ?>

									<span class="dslc-module-heading-view-all"><a href="<?php echo $options['view_all_link']; ?>" class="dslca-editable-content" data-id="main_heading_link_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?> ><?php echo $options['main_heading_link_title']; ?></a></span>

								<?php endif; ?>

							<?php endif; ?>

							<!-- Filters -->

							<?php

								if ( $show_filters ) {

									$cats_array = array();

									if ( $dslc_query->have_posts() ) {

										while ( $dslc_query->have_posts() ) {

											$dslc_query->the_post();

											$post_cats = get_the_terms( get_the_ID(), 'product_cat' );
											if ( ! empty( $post_cats ) ) {
												foreach ( $post_cats as $post_cat ) {
													$cats_array[$post_cat->slug] = $post_cat->name;
												}
											}

										}

									}

									?>

										<div class="dslc-post-filters">

											<span class="dslc-post-filter dslc-active" data-id=" "><?php _ex( 'All', 'Post Filter', 'live-composer-page-builder' ); ?></span>

											<?php foreach ( $cats_array as $cat_slug => $cat_name ) : ?>
												<span class="dslc-post-filter dslc-inactive" data-id="<?php echo $cat_slug; ?>"><?php echo $cat_name; ?></span>
											<?php endforeach; ?>

										</div><!-- .dslc-post-filters -->

									<?php

								}

							?>

							<!-- Carousel -->

							<?php if ( $show_carousel_arrows ) : ?>
								<span class="dslc-carousel-nav fr">
									<span class="dslc-carousel-nav-inner">
										<a href="#" class="dslc-carousel-nav-prev"><span class="dslc-icon-chevron-left"></span></a>
										<a href="#" class="dslc-carousel-nav-next"><span class="dslc-icon-chevron-right"></span></a>
									</span>
								</span><!-- .carousel-nav -->
							<?php endif; ?>

						</div><!-- .dslc-module-heading -->
					<?php

				endif;

			/**
			 * Posts ( output )
			 */

				if ( $dslc_query->have_posts() ) :

					?><div class="<?php echo $container_class; ?>"><?php

						?><div class="dslc-posts-inner"><?php

							if ( $options['type'] == 'carousel' ) :

								?><div class="dslc-loader"></div><div class="dslc-carousel" data-stop-on-hover="<?php echo $options['carousel_autoplay_hover']; ?>" data-autoplay="<?php echo $options['carousel_autoplay']; ?>" data-columns="<?php echo $carousel_items; ?>" data-pagination="<?php if ( in_array( 'circles', $carousel_elements ) ) echo 'true'; else echo 'false'; ?>" data-slide-speed="<?php echo $options['arrows_slide_speed']; ?>" data-pagination-speed="<?php echo $options['circles_slide_speed']; ?>"><?php

							endif;

							while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); $count += $increment; $real_count++;

								global $product;

								if ( $count == $max_count ) {
									$count = 0;
									$extra_class = ' dslc-last-col';
								} elseif ( $count == $increment ) {
									$extra_class = ' dslc-first-col';
								} else {
									$extra_class = '';
								}

								if ( ! has_post_thumbnail() )
									$extra_class .= ' dslc-post-no-thumb';


								$post_cats = get_the_terms( get_the_ID(), 'product_cat' );
								$post_cats_data = '';
								if ( ! empty( $post_cats ) ) {
									foreach ( $post_cats as $post_cat ) {
										$post_cats_data .= $post_cat->slug . ' ';
									}
								}

								?>

								<div class="<?php echo $element_class . $columns_class . $extra_class; ?>" data-cats="<?php echo $post_cats_data; ?>">

									<?php if ( $post_elements == 'all' || in_array( 'thumbnail', $post_elements ) ) : ?>

										<?php if ( has_post_thumbnail() ) : ?>

											<div class="dslc-post-thumb dslc-product-thumb dslc-on-hover-anim">

												<?php
													/**
													 * Manual Resize
													 */

													$manual_resize = false;
													if ( isset( $options['thumb_resize_height'] ) && ! empty( $options['thumb_resize_height'] ) || isset( $options['thumb_resize_width_manual'] ) && ! empty( $options['thumb_resize_width_manual'] ) ) {

														$manual_resize = true;
														$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
														$thumb_url = $thumb_url[0];

														$thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
														if ( ! $thumb_alt ) $thumb_alt = '';

														$resize_width = false;
														$resize_height = false;

														if ( isset( $options['thumb_resize_width_manual'] ) && ! empty( $options['thumb_resize_width_manual'] ) ) {
															$resize_width = $options['thumb_resize_width_manual'];
														}

														if ( isset( $options['thumb_resize_height'] ) && ! empty( $options['thumb_resize_height'] ) ) {
															$resize_height = $options['thumb_resize_height'];
														}

													}
												?>


												<div class="dslc-product-thumb-inner dslca-post-thumb">

													<?php if ( $manual_resize ) : ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php $res_img = dslc_aq_resize( $thumb_url, $resize_width, $resize_height, true ); echo $res_img; ?>" alt="<?php echo $thumb_alt; ?>" /></a>
													<?php else : ?>
														<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
													<?php endif; ?>

													<?php if ( $post_elements == 'all' || in_array( 'price', $post_elements ) ) : ?>
														<a href="<?php echo do_shortcode( '[add_to_cart_url id="' . get_the_ID() . '"]' ); ?>" class="dslc-product-price dslc-init-square dslc-init-<?php echo $options['price_pos']; ?>"><span class="dslc-product-price-bg"></span><span class="dslc-product-price-main"><?php echo $product->get_price_html(); ?></span></a>
													<?php endif; ?>

												</div><!-- .dslc-product-thumb-inner -->

												<?php if ( ( $options['main_location'] == 'inside' || $options['main_location'] == 'inside_visible' ) && ( $post_elements == 'all' || in_array( 'title', $post_elements ) || in_array( 'excerpt', $post_elements ) || in_array( 'addtocart', $post_elements ) || in_array( 'details', $post_elements ) ) ) : ?>

													<div class="dslc-post-main dslc-init-<?php echo $options['main_position']; ?> dslc-product-main <?php if ( $options['main_location'] == 'inside_visible' ) echo 'dslc-product-main-visible'; ?> dslc-on-hover-anim-target dslc-anim-<?php echo $options['css_anim_hover']; ?>" data-dslc-anim="<?php echo $options['css_anim_hover'] ?>" data-dslc-anim-speed="<?php echo $options['css_anim_speed']; ?>">

														<div class="dslc-product-main-inner dslc-init-target">

															<?php if ( $post_elements == 'all' || in_array( 'title', $post_elements ) ) : ?>

																<div class="dslc-product-title dslc-clearfix">
																	<?php if ( $post_elements == 'all' || in_array( 'price_2', $post_elements ) ) : ?>
																		<span class="dslc-product-price-secondary"><?php echo $product->get_price_html(); ?></span>
																	<?php endif; ?>
																	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
																</div><!-- .dslc-product-title -->

															<?php endif; ?>

															<?php if ( $post_elements == 'all' || in_array( 'separator', $post_elements ) ) : ?>

																<span class="dslc-product-sep"></span>

															<?php endif; ?>

															<?php if ( $post_elements == 'all' || in_array( 'excerpt', $post_elements ) ) : ?>

																<div class="dslc-product-excerpt">
																	<?php if ( $options['excerpt_or_content'] == 'content' ) : ?>
																		<?php the_content(); ?>
																	<?php else : ?>
																		<?php
																			if ( $options['excerpt_length'] > 0 ) {
																				if ( has_excerpt() )
																					echo do_shortcode( wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ) );
																				else
																					echo do_shortcode( wp_trim_words( get_the_content(), $options['excerpt_length'] ) );
																			} else {
																				if ( has_excerpt() )
																					echo do_shortcode( get_the_excerpt() );
																				else
																					echo do_shortcode( get_the_content() );
																			}
																		?>
																	<?php endif; ?>
																</div><!-- .dslc-product-excerpt -->

															<?php endif; ?>

															<div class="dslc-product-extra dslc-clearfix">

																<?php if ( $post_elements == 'all' || in_array( 'addtocart', $post_elements ) ) : ?>
																	<a href="<?php echo do_shortcode( '[add_to_cart_url id="' . get_the_ID() . '"]' ); ?>" class="dslc-product-add-to-cart"><span class="dslc-icon dslc-icon-shopping-cart"></span><?php echo $options['addtocart_text']; ?></a>
																<?php endif; ?>

																<?php if ( $post_elements == 'all' || in_array( 'details', $post_elements ) ) : ?>
																	<a href="<?php the_permalink(); ?>" class="dslc-product-details"><span class="dslc-icon dslc-icon-file-text"></span><?php echo $options['details_text']; ?></a>
																<?php endif; ?>

															</div><!-- .dslc-product-extra -->

														</div><!-- .dslc-product-main-inner -->

														<a href="<?php the_permalink(); ?>" class="dslc-post-main-inner-link-cover"></a>

													</div><!-- .dslc-product-main -->

												<?php endif; ?>

											</div><!-- .dslc-product-thumb -->

										<?php endif; ?>

									<?php endif; ?>

									<?php if ( $options['main_location'] == 'bellow' && ( $post_elements == 'all' || in_array( 'title', $post_elements ) || in_array( 'separator', $post_elements ) || in_array( 'excerpt', $post_elements ) || in_array( 'addtocart', $post_elements ) || in_array( 'details', $post_elements ) ) ) : ?>

										<div class="dslc-post-main dslc-product-main">

											<?php if ( $post_elements == 'all' || in_array( 'title', $post_elements ) ) : ?>

												<div class="dslc-product-title dslc-clearfix">
													<?php if ( $post_elements == 'all' || in_array( 'price_2', $post_elements ) ) : ?>
														<span class="dslc-product-price-secondary"><?php echo $product->get_price_html(); ?></span>
													<?php endif; ?>
													<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
												</div><!-- .dslc-product-title -->

											<?php endif; ?>

											<?php if ( $post_elements == 'all' || in_array( 'separator', $post_elements ) ) : ?>

												<span class="dslc-product-sep"></span>

											<?php endif; ?>

											<?php if ( $post_elements == 'all' || in_array( 'excerpt', $post_elements ) ) : ?>

												<div class="dslc-product-excerpt">
													<?php if ( $options['excerpt_or_content'] == 'content' ) : ?>
														<?php the_content(); ?>
													<?php else : ?>
														<?php
															if ( $options['excerpt_length'] > 0 ) {
																if ( has_excerpt() )
																	echo do_shortcode( wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ) );
																else
																	echo do_shortcode( wp_trim_words( get_the_content(), $options['excerpt_length'] ) );
															} else {
																if ( has_excerpt() )
																	echo do_shortcode( get_the_excerpt() );
																else
																	echo do_shortcode( get_the_content() );
															}
														?>
													<?php endif; ?>
												</div><!-- .dslc-product-excerpt -->

											<?php endif; ?>

											<div class="dslc-product-extra dslc-clearfix">

												<?php if ( $post_elements == 'all' || in_array( 'addtocart', $post_elements ) ) : ?>
													<a href="<?php echo do_shortcode( '[add_to_cart_url id="' . get_the_ID() . '"]' ); ?>" class="dslc-product-add-to-cart"><span class="dslc-icon dslc-icon-shopping-cart"></span><?php echo $options['addtocart_text']; ?></a>
												<?php endif; ?>

												<?php if ( $post_elements == 'all' || in_array( 'details', $post_elements ) ) : ?>
													<a href="<?php the_permalink(); ?>" class="dslc-product-details"><span class="dslc-icon dslc-icon-file-text"></span><?php echo $options['details_text']; ?></a>
												<?php endif; ?>

											</div><!-- .dslc-product-extra -->

										</div><!-- .dslc-product-main -->

									<?php endif; ?>

								</div><!-- .dslc-product -->

								<?php

								// Row Separator
								if ( $options['type'] == 'grid' && $count == 0 && $real_count != $dslc_query->found_posts && $real_count != $options['amount'] && $options['separator_enabled'] == 'enabled' ) {
									echo '<div class="dslc-post-separator"></div>';
								}

							endwhile;

							if ( $options['type'] == 'carousel' ) :

								?></div><?php

							endif;

						?></div><!-- .dslc-posts-inner --><?php

					?></div><?php

				else :

					if ( $dslc_is_admin ) :
						?><div class="dslc-notification dslc-red"><?php _e( 'You do not have products at the moment. Go to <strong>WP Admin &rarr; Products</strong> to add some.', 'live-composer-page-builder' ); ?> <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
					endif;

				endif;

			else :

				if ( $dslc_is_admin ) :
					?><div class="dslc-notification dslc-red"><?php _e( 'You do not have WooCommerce installed at the moment. You need to install it to use this module.', 'live-composer-page-builder' ); ?> <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
				endif;

			endif;

			/**
			 * Pagination
			 */

			if ( isset( $options['pagination_type'] ) && $options['pagination_type'] != 'disabled' ) {
				$num_pages = $dslc_query->max_num_pages;
				if ( $options['offset'] > 0 ) {
					$num_pages = ceil( ( $dslc_query->found_posts - $options['offset'] ) / $options['amount'] );
				}
				dslc_post_pagination( array('pages' => $num_pages, 'type' => $options['pagination_type']) );
			}

			wp_reset_postdata();

		/* Module output ends here */

		$this->module_end( $options );

	}

}