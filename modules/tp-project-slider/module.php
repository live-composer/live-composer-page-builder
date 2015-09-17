<?php

class DSLC_TP_Project_Slider extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_TP_Project_Slider';
		$this->module_title = __( 'Project Images Slider', 'dslc_string' );
		$this->module_icon = 'picture';
		$this->module_category = 'single';

	}
	
	function options() {	

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
				'label' => __( 'Animation', 'dslc_string' ),
				'id' => 'animation',
				'std' => 'fade',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Fade', 'dslc_string' ),
						'value' => 'fade'
					),
					array(
						'label' => __( 'Fade Up Slide', 'dslc_string' ),
						'value' => 'fadeUp'
					),
					array(
						'label' => __( 'Slide', 'dslc_string' ),
						'value' => 'false'
					),
					array(
						'label' => __( 'Back Slide', 'dslc_string' ),
						'value' => 'backSlide'
					),
					array(
						'label' => __( 'Go Down', 'dslc_string' ),
						'value' => 'goDown'
					),
				)
			),
			array(
				'label' => __( 'Animation Speed (ms)', 'dslc_string' ),
				'id' => 'animation_speed',
				'std' => '800',
				'type' => 'text',
			),
			array(
				'label' => __( 'Autoplay Speed (ms)', 'dslc_string' ),
				'id' => 'autoplay',
				'std' => '0',
				'type' => 'text',
			),
			array(
				'label' => __( 'Flexible Height', 'dslc_string' ),
				'id' => 'flexible_height',
				'std' => 'true',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'true'
					),
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'false'
					)
				)
			),
			array(
				'label' => __( 'Lightbox', 'dslc_string' ),
				'help' => __( 'Enabling will make clicking an image open up the image in a lightbox.', 'dslc_string' ),
				'id' => 'lightbox_state',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled'
					),
				)
			),

			/**
			 * General Styling
			 */

			array(
				'label' => __( ' BG Color', 'dslc_string' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_border_trbl',
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
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
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
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/**
			 * Slider
			 */

			array(
				'label' => __( ' BG Color', 'dslc_string' ),
				'id' => 'css_slider_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'slider', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_slider_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'slider', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_slider_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_slider_border_trbl',
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
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'slider', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_slider_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_slider_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_slider_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_slider_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider', 'dslc_string' ),
			),

			/**
			 * Slides
			 */

			array(
				'label' => __( ' BG Color', 'dslc_string' ),
				'id' => 'css_slider_item_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'slider - item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_slider_item_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'slider - item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_slider_item_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider - item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_slider_item_border_trbl',
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
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'slider - item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_slider_item_border_radius_top',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item,.dslc-tp-project-slider-main .dslc-slider-item img',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider - item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_slider_item_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item,.dslc-tp-project-slider-main .dslc-slider-item img',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider - item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_slider_item_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider - item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_slider_item_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'slider - item', 'dslc_string' ),
			),

			/**
			 * Navigation
			 */

			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_circles_bradius',
				'std' => '50',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_circles_color',
				'std' => '#b9b9b9',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color - Active', 'dslc_string' ),
				'id' => 'css_circles_color_active',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page.active span',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Vertical', 'dslc_string' ),
				'id' => 'css_circles_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-controls',
				'affect_on_change_rule' => 'margin',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Size', 'dslc_string' ),
				'id' => 'css_circles_size',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Spacing', 'dslc_string' ),
				'id' => 'css_circles_spacing',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
				'ext' => 'px'
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
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Slider - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_slider_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Slider - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_slider_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Slider Item - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_slider_item_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Slider Item - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_slider_item_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Nav - Margin Vertical', 'dslc_string' ),
				'id' => 'css_res_t_circles_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-controls',
				'affect_on_change_rule' => 'margin',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Nav - Size', 'dslc_string' ),
				'id' => 'css_res_t_circles_size',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Nav - Spacing', 'dslc_string' ),
				'id' => 'css_res_t_circles_spacing',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),

			/**
			 * Responsive phone
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
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Slider - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_slider_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Slider - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_slider_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Slider Item - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_slider_item_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Slider Item - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_slider_item_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-project-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Nav - Margin Vertical', 'dslc_string' ),
				'id' => 'css_res_p_circles_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-controls',
				'affect_on_change_rule' => 'margin',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Nav - Size', 'dslc_string' ),
				'id' => 'css_res_p_circles_size',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Nav - Spacing', 'dslc_string' ),
				'id' => 'css_res_p_circles_spacing',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),


		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active;
				
		$show_placeholder = true;
		$show_real = false;

		if ( is_singular() && get_post_type() !== 'dslc_templates' ) {

			$project_images = get_post_meta( get_the_ID(), 'dslc_project_images', true );
			if ( $project_images ) {
				$show_real = true;
				$project_images = explode( ' ', trim( $project_images ) );
			}

			$show_placeholder = false;

		}

		$this->module_start( $options );

		/* Module output starts here */

			if ( $show_placeholder || $show_real ) {
				
				$img_class = '';
				if ( $options['lightbox_state'] == 'enabled' ) {
					$img_class = 'dslc-trigger-lightbox-gallery';
				}

				?>

					<div class="dslc-tp-project-slider">

						<div class="dslc-tp-project-slider-main">

							<div class="dslc-loader"></div>

							<div class="dslc-slider"  data-animation="<?php echo $options['animation']; ?>" data-animation-speed="<?php echo $options['animation_speed']; ?>" data-autoplay="<?php echo $options['autoplay']; ?>" data-flexible-height="<?php echo $options['flexible_height']; ?>">

								<?php 

									if ( $show_placeholder ) {

										for ( $i=0; $i < 15; $i++ ) { 
											?><div class="dslc-slider-item"><img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/placeholders/big-placeholder.png" /></div><?php			
										}

									} else {

										foreach ( $project_images as $project_image ) {

											$project_image_src = wp_get_attachment_image_src( $project_image, 'full' );
											$project_image_src = $project_image_src[0];

											$thumb_alt = get_post_meta( $project_image, '_wp_attachment_image_alt', true );
											if ( ! $thumb_alt ) $thumb_alt = '';

											?><div class="dslc-slider-item"><img class="<?php echo $img_class; ?>" src="<?php echo $project_image_src; ?>" alt="<?php echo $thumb_alt; ?>" /></div><?php

										}

									}

								?>

							</div><!-- .dslc-slider -->

							<?php if ( ! $show_placeholder && $options['lightbox_state'] == 'enabled' ) : ?>

								<div class="dslc-lightbox-gallery">
									
									<?php foreach ( $project_images as $project_image ) : ?>

										<?php
											$project_image_src = wp_get_attachment_image_src( $project_image, 'full' );
											$project_image_src = $project_image_src[0];
										?>

										<a href="<?php echo $project_image_src; ?>"></a>

									<?php endforeach; ?>

								</div><!-- .dslc-gallery-lightbox -->

							<?php endif; ?>

						</div><!-- .slider -->

					</div><!-- .dslc-tp-project-slider -->

				<?php

			}

		/* Module output ends here */

		$this->module_end( $options );

	}

}