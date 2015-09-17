<?php

if ( dslc_is_module_active( 'DSLC_Testimonials' ) )
	include DS_LIVE_COMPOSER_ABS . '/modules/testimonials/functions.php';

class DSLC_Testimonials extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Testimonials';
		$this->module_title = __( 'Testimonials', 'dslc_string' );
		$this->module_icon = 'quote-right';
		$this->module_category = 'posts';

	}

	function options() {

		$cats = get_terms( 'dslc_testimonials_cats' );
		$cats_choices = array();

		foreach ( $cats as $cat ) {
			$cats_choices[] = array(
				'label' => $cat->name,
				'value' => $cat->slug
			);
		}

		$dslc_options = array(

			array(
				'label' => __( 'Show On', 'dslc_string' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'dslc_string' ),
						'value' => 'desktop'
					),
					array(
						'label' => __( 'Tablet', 'dslc_string' ),
						'value' => 'tablet'
					),
					array(
						'label' => __( 'Phone', 'dslc_string' ),
						'value' => 'phone'
					),
				),
			),
			array(
				'label' => __( 'Type', 'dslc_string' ),
				'id' => 'type',
				'std' => 'grid',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Grid', 'dslc_string' ),
						'value' => 'grid'
					),
					array(
						'label' => __( 'Masonry Grid', 'dslc_string' ),
						'value' => 'masonry'
					),
					array(
						'label' => __( 'Carousel', 'dslc_string' ),
						'value' => 'carousel'
					)
				)
			),
			array(
				'label' => __( 'Posts Per Page', 'dslc_string' ),
				'id' => 'amount',
				'std' => '8',
				'type' => 'text',
			),
			array(
				'label' => __( 'Pagination', 'dslc_string' ),
				'id' => 'pagination_type',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Numbered', 'dslc_string' ),
						'value' => 'numbered',
					),
					array(
						'label' => __( 'Prev/Next', 'dslc_string' ),
						'value' => 'prevnext',
					)
				),
			),
			array(
				'label' => __( 'Posts Per Row', 'dslc_string' ),
				'id' => 'columns',
				'std' => '3',
				'type' => 'select',
				'choices' => $this->shared_options('posts_per_row_choices'),
			),
			array(
				'label' => __( 'Categories', 'dslc_string' ),
				'id' => 'categories',
				'std' => '',
				'type' => 'checkbox',
				'choices' => $cats_choices
			),
			array(
				'label' => __( 'Categories Operator', 'dslc_string' ),
				'id' => 'categories_operator',
				'std' => 'IN',
				'help' => __( '<strong>IN</strong> - Posts must be in at least one chosen category.<br><strong>AND</strong> - Posts must be in all chosen categories.<br><strong>NOT IN</strong> Posts must not be in the chosen categories.', 'dslc_string' ),
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'IN', 'dslc_string' ),
						'value' => 'IN',
					),
					array(
						'label' => __( 'AND', 'dslc_string' ),
						'value' => 'AND',
					),
					array(
						'label' => __( 'NOT IN', 'dslc_string' ),
						'value' => 'NOT IN',
					),
				)
			),
			array(
				'label' => __( 'Order By', 'dslc_string' ),
				'id' => 'orderby',
				'std' => 'date',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Publish Date', 'dslc_string' ),
						'value' => 'date'
					),
					array(
						'label' => __( 'Modified Date', 'dslc_string' ),
						'value' => 'modified'
					),
					array(
						'label' => __( 'Random', 'dslc_string' ),
						'value' => 'rand'
					),
					array(
						'label' => __( 'Alphabetic', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Comment Count', 'dslc_string' ),
						'value' => 'comment_count'
					),
				)
			),
			array(
				'label' => __( 'Order', 'dslc_string' ),
				'id' => 'order',
				'std' => 'DESC',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Ascending', 'dslc_string' ),
						'value' => 'ASC'
					),
					array(
						'label' => __( 'Descending', 'dslc_string' ),
						'value' => 'DESC'
					)
				)
			),
			array(
				'label' => __( 'Offset', 'dslc_string' ),
				'id' => 'offset',
				'std' => '0',
				'type' => 'text',
			),
			array(
				'label' => __( 'Include (IDs)', 'dslc_string' ),
				'id' => 'query_post_in',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Exclude (IDs)', 'dslc_string' ),
				'id' => 'query_post_not_in',
				'std' => '',
				'type' => 'text',
			),

			/** 
			 * General
			 */

			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => '',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Heading', 'dslc_string' ),
						'value' => 'main_heading'
					),
					array(
						'label' => __( 'Filters', 'dslc_string' ),
						'value' => 'filters'
					),
				),
				'section' => 'styling'
			),

			array(
				'label' => __( 'Post Elements', 'dslc_string' ),
				'id' => 'post_elements',
				'std' => 'quote avatar name position',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Quote', 'dslc_string' ),
						'value' => 'quote',
					),
					array(
						'label' => __( 'Avatar', 'dslc_string' ),
						'value' => 'avatar',
					),
					array(
						'label' => __( 'Name', 'dslc_string' ),
						'value' => 'name',
					),
					array(
						'label' => __( 'Position', 'dslc_string' ),
						'value' => 'position',
					),
				),
				'section' => 'styling'
			),

			array(
				'label' => __( 'Carousel Elements', 'dslc_string' ),
				'id' => 'carousel_elements',
				'std' => 'arrows circles',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Arrows', 'dslc_string' ),
						'value' => 'arrows'
					),
					array(
						'label' => __( 'Circles', 'dslc_string' ),
						'value' => 'circles'
					),
				),
				'section' => 'styling'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonials',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'dslc_string' ),
				'id' => 'css_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonials',
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
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_sep_border_color',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'dslc_string' ),
			),
			array(
				'label' => __( 'Height', 'dslc_string' ),
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
				'tab' => __( 'Row Separator', 'dslc_string' ),
			),
			array(
				'label' => __( 'Thickness', 'dslc_string' ),
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
				'tab' => __( 'Row Separator', 'dslc_string' ),
			),
			array(
				'label' => __( 'Style', 'dslc_string' ),
				'id' => 'css_sep_style',
				'std' => 'dashed',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Invisible', 'dslc_string' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Solid', 'dslc_string' ),
						'value' => 'solid'
					),
					array(
						'label' => __( 'Dashed', 'dslc_string' ),
						'value' => 'dashed'
					),
					array(
						'label' => __( 'Dotted', 'dslc_string' ),
						'value' => 'dotted'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-separator',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Row Separator', 'dslc_string' ),
			),

			/**
			 * Main
			 */

			array(
				'label' => __( ' BG Color', 'dslc_string' ),
				'id' => 'css_main_bg_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Main', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Image', 'dslc_string' ),
				'id' => 'css_main_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
				'tab' => __( 'Main', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Image Repeat', 'dslc_string' ),
				'id' => 'css_main_bg_img_repeat',
				'std' => 'repeat',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Repeat', 'dslc_string' ),
						'value' => 'repeat',
					),
					array(
						'label' => __( 'Repeat Horizontal', 'dslc_string' ),
						'value' => 'repeat-x',
					),
					array(
						'label' => __( 'Repeat Vertical', 'dslc_string' ),
						'value' => 'repeat-y',
					),
					array(
						'label' => __( 'Do NOT Repeat', 'dslc_string' ),
						'value' => 'no-repeat',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
				'tab' => __( 'Main', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Image Attachment', 'dslc_string' ),
				'id' => 'css_main_bg_img_attch',
				'std' => 'scroll',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Scroll', 'dslc_string' ),
						'value' => 'scroll',
					),
					array(
						'label' => __( 'Fixed', 'dslc_string' ),
						'value' => 'fixed',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
				'tab' => __( 'Main', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Image Position', 'dslc_string' ),
				'id' => 'css_main_bg_img_pos',
				'std' => 'top left',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'dslc_string' ),
						'value' => 'left top',
					),
					array(
						'label' => __( 'Top Right', 'dslc_string' ),
						'value' => 'right top',
					),
					array(
						'label' => __( 'Top Center', 'dslc_string' ),
						'value' => 'Center Top',
					),
					array(
						'label' => __( 'Center Left', 'dslc_string' ),
						'value' => 'left center',
					),
					array(
						'label' => __( 'Center Right', 'dslc_string' ),
						'value' => 'right center',
					),
					array(
						'label' => __( 'Center', 'dslc_string' ),
						'value' => 'center center',
					),
					array(
						'label' => __( 'Bottom Left', 'dslc_string' ),
						'value' => 'left bottom',
					),
					array(
						'label' => __( 'Bottom Right', 'dslc_string' ),
						'value' => 'right bottom',
					),
					array(
						'label' => __( 'Bottom Center', 'dslc_string' ),
						'value' => 'center bottom',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
				'tab' => __( 'Main', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_main_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Main', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_main_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_main_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Main', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_main_border_radius_top',
				'std' => '4',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Main', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_main_border_radius_bottom',
				'std' => '4',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Main', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_main_padding_vertical',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_main_padding_horizontal',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Main', 'dslc_string' ),
			),

			/**
			 * Quote
			 */

			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_quote_border_color',
				'std' => '#83adec',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'quote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_quote_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'quote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_quote_border_trbl',
				'std' => 'bottom',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'quote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_quote_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'quote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_quote_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'quote', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_quote_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'quote', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_quote_font_family',
				'std' => 'Roboto',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'quote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_quote_line_height',
				'std' => '29',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'quote', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_quote_margin',
				'std' => '18',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'quote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Bottom', 'dslc_string' ),
				'id' => 'css_quote_padding_bottom',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'quote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Top', 'dslc_string' ),
				'id' => 'css_quote_padding_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'quote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_quote_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'quote', 'dslc_string' ),
			),

			/**
			 * Author
			 */

			array(
				'label' => __( 'Position', 'dslc_string' ),
				'id' => 'author_pos',
				'std' => 'inside bottom',
				'type' => 'select',
				'section' => 'styling',
				'tab' => __( 'author', 'dslc_string' ),
				'choices' => array(
					array(
						'label' => __( 'Inside Bottom', 'dslc_string' ),
						'value' => 'inside bottom',
					),
					array(
						'label' => __( 'Inside Top', 'dslc_string' ),
						'value' => 'inside top',
					),
					array(
						'label' => __( 'Outside Bottom', 'dslc_string' ),
						'value' => 'outside bottom',
					),
					array(
						'label' => __( 'Outside Top', 'dslc_string' ),
						'value' => 'outside top',
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'outside left',
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'outside right',
					),
				)
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_author_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'author', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Top', 'dslc_string' ),
				'id' => 'css_author_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'author', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Left', 'dslc_string' ),
				'id' => 'css_author_margin_left',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'author', 'dslc_string' ),
				'min' => -100
			),
			array(
				'label' => __( 'Margin Right', 'dslc_string' ),
				'id' => 'css_author_margin_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'author', 'dslc_string' ),
				'min' => -100
			),

			/**
			 * Avatar
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_avatar_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'avatar', 'dslc_string' ),
			),	
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_avatar_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'avatar', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_avatar_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'avatar', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_avatar_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'avatar', 'dslc_string' ),
			),		
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_avatar_border_radius_top',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar img, .dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'tab' => __( 'avatar', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Right', 'dslc_string' ),
				'id' => 'css_avatar_margin_right',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'tab' => __( 'avatar', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding', 'dslc_string' ),
				'id' => 'css_avatar_padding',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'padding',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'avatar', 'dslc_string' ),
			),
			array(
				'label' => __( 'Size', 'dslc_string' ),
				'id' => 'css_avatar_size',
				'std' => '55',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar img',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
				'tab' => __( 'avatar', 'dslc_string' ),
				'min' => 1,
				'max' => 100,
				'ext' => 'px'
			),

			/**
			 * Title
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_name_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'name', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_name_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'name', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_name_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'name', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_name_font_family',
				'std' => 'Roboto',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'name', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_name_margin_bottom',
				'std' => '8',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'name', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Top', 'dslc_string' ),
				'id' => 'css_name_margin_top',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'name', 'dslc_string' ),
			),

			/**
			 * Position
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_position_color',
				'std' => '#cddef7',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-position',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'position', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_position_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-position',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'position', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_position_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-position',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'position', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_position_font_family',
				'std' => 'Bitter',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-position',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'position', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_position_lheight',
				'std' => '1.1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-position',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'position', 'dslc_string' ),
				'increment' => '0.05',
				'max' => 3
			),
			
			/**
			 * Responsive Tablet
			 */

			array(
				'label' => __( 'Responsive Styling', 'dslc_string' ),
				'id' => 'css_res_t',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonials',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Separator - Height', 'dslc_string' ),
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
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_main_padding_vertical',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_main_padding_horizontal',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Quote - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_quote_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Quote - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_quote_line_height',
				'std' => '29',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Quote - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_quote_margin',
				'std' => '18',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Quote - Padding Bottom', 'dslc_string' ),
				'id' => 'css_res_t_quote_padding_bottom',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Quote - Padding Top', 'dslc_string' ),
				'id' => 'css_res_t_quote_padding_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Author - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_author_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Author - Margin Top', 'dslc_string' ),
				'id' => 'css_res_t_author_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Author - Margin Left', 'dslc_string' ),
				'id' => 'css_res_t_author_margin_left',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
				'min' => -100
			),
			array(
				'label' => __( 'Author - Margin Right', 'dslc_string' ),
				'id' => 'css_res_t_author_margin_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
				'min' => -100
			),
			array(
				'label' => __( 'Avatar - Margin Right', 'dslc_string' ),
				'id' => 'css_res_t_avatar_margin_right',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Avatar - Padding', 'dslc_string' ),
				'id' => 'css_res_t_avatar_padding',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'padding',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Avatar - Size', 'dslc_string' ),
				'id' => 'css_res_t_avatar_size',
				'std' => '55',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar img',
				'affect_on_change_rule' => 'width',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'min' => 1,
				'max' => 100,
				'ext' => 'px'
			),
			array(
				'label' => __( 'Name - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_name_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Name - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_name_margin_bottom',
				'std' => '8',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Name - Margin Top', 'dslc_string' ),
				'id' => 'css_res_t_name_margin_top',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Position - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_position_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-position',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => __( 'Responsive Styling', 'dslc_string' ),
				'id' => 'css_res_p',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonials',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Separator - Height', 'dslc_string' ),
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
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Main - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_main_padding_vertical',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Main - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_main_padding_horizontal',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Quote - Font Size', 'dslc_string' ),
				'id' => 'css_res_p_quote_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Quote - Line Height', 'dslc_string' ),
				'id' => 'css_res_p_quote_line_height',
				'std' => '29',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Quote - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_quote_margin',
				'std' => '18',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Quote - Padding Bottom', 'dslc_string' ),
				'id' => 'css_res_p_quote_padding_bottom',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Quote - Padding Top', 'dslc_string' ),
				'id' => 'css_res_p_quote_padding_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-quote',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Author - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_author_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Author - Margin Top', 'dslc_string' ),
				'id' => 'css_res_p_author_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Author - Margin Left', 'dslc_string' ),
				'id' => 'css_res_p_author_margin_left',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
				'min' => -100
			),
			array(
				'label' => __( 'Author - Margin Right', 'dslc_string' ),
				'id' => 'css_res_p_author_margin_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
				'min' => -100
			),
			array(
				'label' => __( 'Avatar - Margin Right', 'dslc_string' ),
				'id' => 'css_res_p_avatar_margin_right',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Avatar - Padding', 'dslc_string' ),
				'id' => 'css_res_p_avatar_padding',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar',
				'affect_on_change_rule' => 'padding',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Avatar - Size', 'dslc_string' ),
				'id' => 'css_res_p_avatar_size',
				'std' => '55',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-avatar img',
				'affect_on_change_rule' => 'width',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'min' => 1,
				'max' => 100,
				'ext' => 'px'
			),
			array(
				'label' => __( 'Name - Font Size', 'dslc_string' ),
				'id' => 'css_res_p_name_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Name - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_name_margin_bottom',
				'std' => '8',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Name - Margin Top', 'dslc_string' ),
				'id' => 'css_res_p_name_margin_top',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-name',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Position - Font Size', 'dslc_string' ),
				'id' => 'css_res_p_position_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-testimonial-author-position',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
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

	function output( $options ) {

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;		

		$this->module_start( $options );

		/* Module output stars here */

			if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;
			if ( ! isset( $options['type'] ) ) $options['type'] = 'grid';

			if( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

			// Fix for pagination from other modules affecting this one when pag disabled
			if ( $options['pagination_type'] == 'disabled' ) $paged = 1;

			// Fix for offset braking pagination
			$query_offset = $options['offset'];
			if ( $query_offset > 0 && $paged > 1 ) $query_offset = ( $paged - 1 ) * $options['amount'] + $options['offset'];

			$args = array(
				'paged' => $paged, 
				'post_type' => 'dslc_testimonials',
				'posts_per_page' => $options['amount'],
				'order' => $options['order'],
				'orderby' => $options['orderby'],
				'offset' => $query_offset
			);

			if ( defined('DOING_AJAX') && DOING_AJAX ) {
				$args['post_status'] = array( 'publish', 'private' );
			}

			if ( isset( $options['categories'] ) && $options['categories'] != '' ) {
				
				$cats_array = explode( ' ', trim( $options['categories'] ));

				$args['tax_query'] = array(
					array(
						'taxonomy' => 'dslc_testimonials_cats',
						'field' => 'slug',
						'terms' => $cats_array,
						'operator' => $options['categories_operator']
					)
				);
				
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
		
			// No paging
			if ( $options['pagination_type'] == 'disabled' )
				$args['no_found_rows'] = true;

			$dslc_query = new WP_Query( $args );

			$wrapper_class = '';
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

			$container_class = 'dslc-posts dslc-testimonials dslc-clearfix ';

			if ( $options['type'] == 'masonry' )
				$container_class .= 'dslc-init-masonry ';
			elseif ( $options['type'] == 'grid' )
				$container_class .= 'dslc-init-grid ';

			/* Element Class */

			$element_class = 'dslc-post dslc-testimonial ';

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

										$post_cats = get_the_terms( get_the_ID(), 'dslc_testimonials_cats' );
										if ( ! empty( $post_cats ) ) {
											foreach( $post_cats as $post_cat ) {
												$cats_array[$post_cat->slug] = $post_cat->name;
											}
										}

									}

								}

								?>

									<div class="dslc-post-filters">

										<span class="dslc-post-filter dslc-active" data-id=" "><?php _ex( 'All', 'Post Filter', 'dslc_string' ); ?></span>

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
									<a href="#" class="dslc-carousel-nav-prev"><span class="dslc-icon-chevron-left dslc-init-center"></span></a>
									<a href="#" class="dslc-carousel-nav-next"><span class="dslc-icon-chevron-right dslc-init-center"></span></a>
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

					if ( $options['type'] == 'carousel' ) :

						?><div class="dslc-loader"></div><div class="dslc-carousel" data-stop-on-hover="<?php echo $options['carousel_autoplay_hover']; ?>" data-autoplay="<?php echo $options['carousel_autoplay']; ?>" data-columns="<?php echo $carousel_items; ?>" data-pagination="<?php if ( in_array( 'circles', $carousel_elements ) ) echo 'true'; else echo 'false'; ?>" data-slide-speed="<?php echo $options['arrows_slide_speed']; ?>" data-pagination-speed="<?php echo $options['circles_slide_speed']; ?>"><?php

					endif;

					while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); $count += $increment; $real_count++;

						if ( $count == $max_count ) {
							$count = 0;
							$extra_class = ' dslc-last-col';
						} elseif ( $count == $increment ) {
							$extra_class = ' dslc-first-col';
						} else {
							$extra_class = '';
						}

						$post_cats_count = 0;
						$post_cats = get_the_terms( get_the_ID(), 'dslc_testimonials_cats' );

						$post_cats_data = '';
						if ( ! empty( $post_cats ) ) {
							foreach( $post_cats as $post_cat ) {
								$post_cats_data .= $post_cat->slug . ' ';
							}
						}

						?>

						<?php ob_start(); ?>

							<div class="dslc-testimonial-author dslc-testimonial-author-pos-<?php echo str_replace( ' ', '-', $options['author_pos'] ); ?> dslc-clearfix">

								<?php if ( $post_elements == 'all' || in_array( 'avatar', $post_elements ) ) : ?>

									<div class="dslc-testimonial-author-avatar">
										<?php the_post_thumbnail( 'full' ); ?>
									</div><!-- .dslc-testimonial-author-avatar -->

								<?php endif; ?>

								<div class="dslc-testimonial-author-main">

									<?php if ( $post_elements == 'all' || in_array( 'name', $post_elements ) ) : ?>

										<div class="dslc-testimonial-author-name">
											<?php the_title(); ?>
										</div><!-- .dslc-testimonial-author-name -->

									<?php endif; ?>

									<?php if ( $post_elements == 'all' || in_array( 'position', $post_elements ) ) : ?>

										<div class="dslc-testimonial-author-position">
											<?php echo get_post_meta( get_the_ID(), 'dslc_testimonial_author_pos', true ); ?>
										</div><!-- .dslc-testimoniala-author-position -->

									<?php endif; ?>

								</div><!-- .dslc-testimonial-author-main -->

							</div><!-- .dslc-testimonial-author -->

						<?php $author_output = ob_get_contents(); ob_end_clean(); ?>

						<div class="<?php echo $element_class . $columns_class . $extra_class; ?>" data-cats="<?php echo $post_cats_data; ?>">

							<div class="dslc-testimonial-inner">	

								<?php if ( $options['author_pos'] == 'outside top' || $options['author_pos'] == 'outside left' || $options['author_pos'] == 'outside right' ) echo $author_output; ?>

								<div class="dslc-testimonial-main">

									<?php if ( $options['author_pos'] == 'inside top' ) echo $author_output; ?>

									<?php if ( $post_elements == 'all' || in_array( 'quote', $post_elements ) ) : ?>

										<div class="dslc-testimonial-quote">
											<?php echo do_shortcode( get_the_content() ); ?>
										</div><!-- .dslc-testimonial-quote -->

									<?php endif; ?>

									<?php if ( $options['author_pos'] == 'inside bottom' ) echo $author_output; ?>

								</div><!-- .dslc-testimonial-main -->

								<?php if ( $options['author_pos'] == 'outside bottom' ) echo $author_output; ?>

							</div><!-- .dslc-testimonial-inner -->

						</div><!-- .dslc-testimonial -->

						<?php 

						// Row Separator
						if ( $options['type'] == 'grid' && $count == 0 && $real_count != $dslc_query->found_posts && $real_count != $options['amount'] ) {
							echo '<div class="dslc-post-separator"></div>';
						}

					endwhile;

					if ( $options['type'] == 'carousel' ) :

						?></div><?php

					endif;

					?>

				</div><!-- .dslc-testimonials -->

			<?php else :

				if ( $dslc_is_admin ) :
					?><div class="dslc-notification dslc-red"><?php _e( 'You do not have any testimonials at the moment. Go to <strong>WP Admin &rarr; Testimonials</strong> to add some.', 'dslc_string' ); ?> <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
				endif;

			endif;

			/**
			 * Pagination
			 */
			
			if ( isset( $options['pagination_type'] ) && $options['pagination_type'] != 'disabled' ) {
				$num_pages = $dslc_query->max_num_pages;
				if ( $options['offset'] > 0 ) {
					$num_pages = ceil ( ( $dslc_query->found_posts - $options['offset'] ) / $options['amount'] );
				}
				dslc_post_pagination( array( 'pages' => $num_pages, 'type' => $options['pagination_type'] ) ); 
			}

			wp_reset_postdata();

		/* Module output ends here */

		$this->module_end( $options );

	}

}