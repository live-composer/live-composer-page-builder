<?php
/**
 * Woo Commerce module
 */

/**
 * DSLC_WooCommerce_Products class
 */
class DSLC_WooCommerce_Products extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	/**
	 * @inherited
	 */
	function __construct( $settings = [], $atts = [] ) {

		$this->module_id = __CLASS__;
		$this->module_ver = 2;
		$this->module_title = __( 'Products ( Woo )', 'live-composer-page-builder' );
		$this->module_icon = 'dollar';
		$this->module_category = 'posts';

		parent::__construct( $settings, $atts );
	}

	/**
	 * @inherited
	 */
	function options() {

		$cats = get_terms( 'product_cat' );
		$cats_choices = array();

		if ( $cats ) {
			foreach ( $cats as $cat ) {
				if(!is_array($cat)){
				$cats_choices[] = array(
					'label' => $cat->name,
					'value' => $cat->slug
				);
			}
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
				'id' => 'posts_per_row',
				'std' => '3',
				'type' => 'select',
				'choices' => $this->shared_options('posts_per_row_choices'),
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

			// Query Altering
			array(
				'label' => __( 'On Author Archive', 'live-composer-page-builder' ),
				'id' => 'query_alter_author',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Show Posts Of That Author', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Do NOT Alter Query', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				),
				'section' => 'functionality',
				'tab' => __( 'Query Alter', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'On Category/Tag Archive', 'live-composer-page-builder' ),
				'id' => 'query_alter_cat',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Show Posts Of That Category/Tag', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Do NOT Alter Query', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				),
				'tab' => __( 'Query Alter', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'On Search Results Page', 'live-composer-page-builder' ),
				'id' => 'query_alter_search',
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Show Posts Matching Search Term', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Do NOT Alter Query', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				),
				'tab' => __( 'Query Alter', 'live-composer-page-builder' ),
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
				'section' => 'styling'
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
				'section' => 'styling'
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
				'section' => 'styling'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
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
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner, .dslc-product-thumb img',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner, .dslc-product-thumb img',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Thumbnail', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_thumbnail_margin_bottom',
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
				'tab' => __( 'thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_width_manual',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'thumbnail', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => __( 'thumbnail', 'live-composer-page-builder' ),
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
				'ext' => '%'
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
				'std' => '6',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price-bg',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_price_font_size',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_price_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'margin',
				'section' => 'styling',
				'tab' => __( 'Price', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'ext' => '',
				'min' => 0,
				'max' => 1,
				'ext' => '',
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
				'ext' => 'px'
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
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_bottom',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Main', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2,.dslc-product-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_title_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2,.dslc-product-title h2 a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2,.dslc-product-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_title_margin_bottom',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'ext' => 'px'
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
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'border-bottom-width',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_excerpt_font_weight',
				'std' => '500',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt, .dslc-product-excerpt p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Excerpt', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'excerpt_margin',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'excerpt', 'live-composer-page-builder' ),
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
				'tab' => __( 'excerpt', 'live-composer-page-builder' ),
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
				'tab' => __( 'excerpt', 'live-composer-page-builder' ),
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
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Price Secondary', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_price_2_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Price Secondary', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-sep',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Separator', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Add to cart - Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_addtocart_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Details - Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_details_font_weight',
				'std' => '600',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Other', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-products',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
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
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumbnail_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_thumbnail_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Price - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_price_font_size',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Price - Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_t_price_margin',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'margin',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_vertical',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_horizontal',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_font_size',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_line_height',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_margin_bottom',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_margin_hor',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt, .dslc-product-excerpt p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_excerpt_margin',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
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
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Price 2nd - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_price_2_font_size',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Separator - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_sep_margin_bottom',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-sep',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Add to cart - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_addtocart_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Details - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_details_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-products',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
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
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumbnail_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Thumbnail - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_thumbnail_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Price - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_price_font_size',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Price - Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_p_price_margin',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-thumb .dslc-product-price',
				'affect_on_change_rule' => 'margin',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_vertical',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_horizontal',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_font_size',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_line_height',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_margin_bottom',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_margin_hor',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title h2, .dslc-product-title h2 a',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt, .dslc-product-excerpt p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Excerpt - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_excerpt_margin',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
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
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Price 2nd - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_price_2_font_size',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-title .dslc-product-price-secondary',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Separator - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_sep_margin_bottom',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-sep',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Add to cart - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_addtocart_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-add-to-cart',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Details - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_details_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-product-extra .dslc-product-details',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options('carousel_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('heading_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('filters_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('carousel_arrows_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('carousel_circles_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('pagination_options') );
		$dslc_options = array_merge( $dslc_options, $this->shared_options('animation_options') );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	/**
	 * @inherited
	 */
	function output( $options = [] ) {

		$this->module_start();

		/* Module content start */
		echo $this->renderModule();
		/* Module content end */

		$this->module_end();
	}

	/**
	 * @inherited
	 */
	function afterRegister() {

		add_action( 'wp_enqueue_scripts', function(){

			global $LC_Registry;

			$path = explode( '/', __DIR__ );
			$path = array_pop( $path );

			if ( $LC_Registry->get( 'dslc_active' ) == true ) {

				wp_enqueue_script( 'js-wooc-editor-extender', DS_LIVE_COMPOSER_URL . '/modules/' . $path . '/editor-script.js', array( 'jquery' ) );
			}

			wp_enqueue_script( 'js-wooc-extender', DS_LIVE_COMPOSER_URL . '/modules/' . $path . '/script.js', array( 'jquery' ) );
		});
	}

	/**
	 * Returns filter HTML string
	 * @return string
	 */
	function wooc_filter() {

		global $LC_Registry;

		$dslc_query = $this->get_wooc();
		$LC_Registry->set( 'dslc-wooc-query', $dslc_query );

		$taxonomy_name = '';

		$cats_array = array();

		$cats_count = 0;

		if ( $dslc_query->have_posts() ) {

			while ( $dslc_query->have_posts() ) {

				$dslc_query->the_post();


				$post_cats = get_the_terms( get_the_ID(), 'product_cat' );
				if ( ! empty( $post_cats ) ) {
					foreach( $post_cats as $post_cat ) {
						$cats_array[$post_cat->slug] = $post_cat->name;
					}
				}
			}
		}

		ob_start();

		foreach ( $cats_array as $cat_slug => $cat_name ) {?>
			<span class="dslc-post-filter dslca-wooc-module dslc-inactive" data-id="<?php echo $cat_slug; ?>"><?php echo $cat_name; ?></span>
		<?php }

		return ob_get_clean();
	}

	/**
	 * Returns secondary price. Template function.
	 */
	function sec_price() {

		global $product;
		ob_start();
		echo $product->get_price_html();
		return ob_get_clean();
	}

	/**
	 * Return categories data to each post. Template function.
	 * @return string
	 */
	function wooc_categories() {

		$post_cats_data = '';
		$post_cats = get_the_terms( get_the_ID(), 'product_cat' );

		if ( ! empty( $post_cats ) ) {

			foreach( $post_cats as $post_cat ) {

				$post_cats_data .= 'in-cat-' . $post_cat->slug . ' ';
			}
		}

		return $post_cats_data . ' in-cat-all';
	}

	/**
	 * Posts fetcher.
	 * @return WP_Query
	 */
	function get_wooc() {

		global $dslc_active;

		$options = $this->getPropsValues();

		if ( ! isset( $options['price_pos'] ) ) {

			$options['price_pos'] = 'center';
		}

		/* Module output stars here */

		if ( $options['orderby'] == 'price' ) {
			$options['orderby'] = 'meta_value_num';
			$orderby = 'price';
		}

		if( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

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

		if ( defined('DOING_AJAX') && DOING_AJAX ) {
			$args['post_status'] = array( 'publish', 'private' );
		}

		if ( isset( $options['categories'] ) && $options['categories'] != '' ) {

			$cats_array = explode( ' ', trim( $options['categories'] ));

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
		if ( is_author() && $options['query_alter_author'] == 'enabled' ) {
			global $authordata;
			$args['author__in'] = array( $authordata->data->ID );
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
		if ( ( is_category() || is_tag() || is_tax() ) && $options['query_alter_cat'] == 'enabled' ) {
			global $wp_query;
			$dslc_query = $wp_query;
		} elseif ( is_search() && $options['query_alter_search'] == 'enabled' ) {
			global $wp_query;
			$dslc_query = $wp_query;
		} else {
			$dslc_query = new WP_Query( $args );
		}

		return $dslc_query;
	}

	/**
	 * Returns product price. Template function.
	 * @return string
	 */
	function post_price() {

		$options = $this->getPropsValues();
		global $product;
		ob_start();
		?>
		<a href="<?php echo do_shortcode( '[add_to_cart_url id="' . get_the_ID() . '"]' ); ?>" class="dslc-product-price dslc-init-square dslc-init-<?php echo $options['price_pos']; ?>">
			<span class="dslc-product-price-bg"></span>
			<span class="dslc-product-price-main">
				<?php echo $product->get_price_html(); ?>
			</span>
			</a><?php

			return ob_get_clean();
	}


	/**
	 * Posts render. Template function.
	 *
	 * @param  array $atts
	 * @param  array $content
	 *
	 * @return string
	 */
	function render_wooc( $atts, $content ) {

		global $LC_Registry;

		$out = '';
		$dslc_query = $LC_Registry->get( 'dslc-wooc-query' );

		if ( $dslc_query == null ) {

			$dslc_query = $this->get_wooc();
			$LC_Registry->set( 'dslc-wooc-query', $dslc_query );
		}

		if ( $dslc_query->have_posts() ) {

			$LC_Registry->set( 'curr_class', $this );

			$options = $this->getPropsValues();
			$cnt = 0;

			while ( $dslc_query->have_posts() ) {

				$dslc_query->the_post();
				$LC_Registry->set( 'dslc-wooc-elem-index', $cnt );


				$out .= DSLC_Main::dslc_do_shortcode( $content );

				if ( 	$options['type'] == 'grid' &&
				 		$cnt > 0 &&
				 		($cnt + 1) % $options['posts_per_row'] == 0 &&
				 		$options['separator_enabled'] != 'disabled' &&
				 		($cnt + 1) < $dslc_query->found_posts &&
				 		($cnt + 1) < $dslc_query->query_vars['posts_per_page']
				 	) {

					$out .= '<div class="dslc-post-separator"></div>';
				}

				$cnt++;
			}

			unset( $cnt );

			$LC_Registry->set( 'dslc-wooc-elem-index', null );
			$LC_Registry->set( 'curr_class', null );
		}

		return $out;
	}

	/**
	 * Returns last col class
	 * @return string
	 */
	function extra_col_class() {

		global $LC_Registry;

		$opts = $this->getPropsValues();
		$index = $LC_Registry->get( 'dslc-wooc-elem-index' );
		$extra_class = '';

		if ( $opts['type'] == 'grid' && $index > 0 && ($index + 1) % $opts['posts_per_row'] == 0 && $opts['separator_enabled'] != 'disabled' ) {

			$extra_class = 'dslc-last-col ';
		}

		if ( ! has_post_thumbnail() ) {

			$extra_class .= 'dslc-post-no-thumb';
		}

		return $extra_class;
	}

	/**
	 * Returns permalink. Repeater function.
	 * @return  string
	 */
	function permalink() {

		global $post;

		return get_post_permalink( $post->ID );
	}

	/**
	 * Returns add to cart button. Template function.
	 * @return string
	 */
	function add_to_cart() {

		$options = $this->getPropsValues();
		ob_start();?>
		<a href="<?php echo do_shortcode( '[add_to_cart_url id="' . get_the_ID() . '"]' ); ?>" class="dslc-product-add-to-cart">
			<span class="dslc-icon dslc-icon-shopping-cart"></span>
			<?php echo $options['addtocart_text']; ?>
		</a><?php

		return ob_get_clean();
	}

	/**
	 * Returns excerpt or content. Repeater function.
	 * @return string
	 */
	function excerpt() {

		$options = $this->getPropsValues();

		ob_start();
		if ( $options['excerpt_or_content'] == 'content' ) {

			the_content();
		} else {

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
		}

		return ob_get_clean();
	}

	/**
	 * Returns post title.Repeater function.
	 * @return string
	 */
	function post_title() {

		ob_start();
		the_title();

		return ob_get_clean();
	}

	/**
	 * Returns post thumbnail. Repeater function.
	 * @return  string
	 */
	function post_thumb() {

		if ( ! has_post_thumbnail() ) return '';

		$manual_resize = false;
		$options = $this->getPropsValues();

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

		ob_start();
		?>
		<div class="dslc-cpt-post-thumb-inner dslca-post-thumb">
			<a href="<?php the_permalink() ?>">
				<?php if ( $manual_resize ) {?>
					<img src="<?php $res_img = dslc_aq_resize( $thumb_url, $resize_width, $resize_height, true ); echo $res_img; ?>" alt="<?php echo $thumb_alt; ?>" />
				<?php } else { ?>
					<?php the_post_thumbnail( 'full' ); ?>
				<?php } ?>
			</a>
		</div><!-- .dslc-cpt-post-thumb-inner -->
		<?php

		return ob_get_clean();
	}

	/**
	 * Returns navigation HTML. Template shortcode function
	 * @param  array $atts
	 * @return string
	 */
	function pagination_nav( $atts ) {

		global $LC_Registry;

		$options = $this->getPropsValues();
		$dslc_query = $LC_Registry->get( 'dslc-wooc-query' );

		ob_start();

		if ( isset( $options['pagination_type'] ) && $options['pagination_type'] != 'disabled' ) {

			$num_pages = $dslc_query->max_num_pages;

			if ( $options['offset'] > 0 ) {
				$num_pages = ceil ( ( $dslc_query->found_posts - $options['offset '] ) / $options['amount'] );
			}

			dslc_post_pagination( array( 'pages' => $num_pages, 'type' => $options['pagination_type'] ) );
		}

		return ob_get_clean();
	}

}

/// Register module
( new DSLC_WooCommerce_Products )->register();