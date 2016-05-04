<?php

class __DSLC_Progress_Bars extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = __CLASS__;
		$this->module_title = __( 'Progress Bar', 'live-composer-page-builder' );
		$this->module_icon = 'tasks';
		$this->module_category = 'elements';

	}

	function options() {	

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
				'label' => __( 'Label', 'live-composer-page-builder' ),
				'id' => 'label',
		 		'std' => __( 'CLICK TO EDIT', 'live-composer-page-builder' ),
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'functionality',
			),

			/**
			 * General Settings
			 */

			array(
				'label' => __( 'Amount', 'live-composer-page-builder' ),
				'id' => 'amount',
				'std' => '50',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader-inner',
				'affect_on_change_rule' => 'width',
				'ext' => '%',
				'section' => 'functionality',
			),
			array(
				'label' => __( 'Animation', 'live-composer-page-builder' ),
				'id' => 'animation',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled ', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
				),
				'section' => 'functionality',
			),
			array(
				'label' => __( 'Animation Speed ( miliseconds )', 'live-composer-page-builder' ),
				'id' => 'animation_speed',
		 		'std' => '1000',
				'type' => 'text',
				'section' => 'functionality',
			),

			/**
			 * Wrapper Style
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_trbl',
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
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
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
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/**
			 * Label
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_label_color',
				'std' => '#3d3d3d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_label_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_label_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
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
				'id' => 'css_label_font_family',
				'std' => 'Oswald',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_label_margin',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_label_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_label_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Position', 'live-composer-page-builder' ),
				'id' => 'label_position',
				'std' => 'above',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Above', 'live-composer-page-builder' ),
						'value' => 'above'
					),
					array(
						'label' => __( 'Inside ', 'live-composer-page-builder' ),
						'value' => 'inside'
					),
				),
				'section' => 'styling',
				'tab' => __( 'title', 'live-composer-page-builder' ),
			),

			/**
			 * Loader
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_loader_bg_color',
				'std' => '#f1f1f1',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_loader_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_loader_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_loader_border_trbl',
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
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_loader_border_radius',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader, .dslc-progress-bar-loader-inner',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_loader_color',
				'std' => '#62cbd7',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader-inner',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_loader_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_loader_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_loader_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Size', 'live-composer-page-builder' ),
				'id' => 'css_loader_height',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader, .dslc-progress-bar-loader-inner',
				'affect_on_change_rule' => 'height',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'bar', 'live-composer-page-builder' ),
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
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_wrapper_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_wrapper_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_label_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_label_margin',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_label_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_label_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bar - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_loader_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bar - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_loader_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bar - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_loader_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bar - Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_loader_height',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader, .dslc-progress-bar-loader-inner',
				'affect_on_change_rule' => 'height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
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
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_wrapper_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_wrapper_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_label_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_label_margin',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_label_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_label_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'h4.dslc-progress-bar-label',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bar - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_loader_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bar - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_loader_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bar - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_loader_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bar - Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_loader_height',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-progress-bar-loader, .dslc-progress-bar-loader-inner',
				'affect_on_change_rule' => 'height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

		);
	
		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;

		/* Module output starts here */

			$wrapper_class = '';

			if ( $options['animation'] == 'enabled' )
				$wrapper_class .= 'dslc-progress-bar-animated ';

			?>

				<div class="dslc-progress-bar <?php echo $wrapper_class; ?>">

					<?php if ( $options['label_position'] == 'above' ) : ?>

						<?php if ( $dslc_is_admin ) : ?>
							<h4 class="dslc-progress-bar-label dslca-editable-content" data-id="label" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo $options['label']; ?></h4>
						<?php else : ?>
							<h4 class="dslc-progress-bar-label"><?php echo $options['label']; ?></h4>
						<?php endif; ?>

					<?php endif; ?>

					<span class="dslc-progress-bar-loader">
						<span class="dslc-progress-bar-loader-inner dslc-in-viewport" data-amount="<?php echo $options['amount']; ?>" data-speed="<?php echo $options['animation_speed']; ?>">
							<?php if ( $options['label_position'] == 'inside' ) : ?>
								<?php if ( $dslc_is_admin ) : ?>
									<h4 class="dslc-progress-bar-label dslca-editable-content" data-id="label" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo $options['label']; ?></h4>
								<?php else : ?>
									<h4 class="dslc-progress-bar-label"><?php echo $options['label']; ?></h4>
								<?php endif; ?>
							<?php endif; ?>
						</span>
					</span><!-- .dslc-progress-bar-loader -->

				</div><!-- .dslc-progress-bar -->

			<?php

		/* Module output ends here */
	}

}