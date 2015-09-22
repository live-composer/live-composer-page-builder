<?php

class DSLC_Tabs extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;
	var $handle_like;

	function __construct() {

		$this->module_id = 'DSLC_Tabs';
		$this->module_title = __( 'Tabs', 'dslc_string' );
		$this->module_icon = 'list';
		$this->module_category = 'elements';
		$this->handle_like = 'tabs';

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
				'label' => __( '(hidden) Tabs Content', 'dslc_string' ),
				'id' => 'tabs_content',
				'std' => __( 'This is just placeholder text.', 'dslc_string' ),
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'styling',
			),
			array(
				'label' => __( '(hidden) Tabs Nav', 'dslc_string' ),
				'id' => 'tabs_nav',
				'std' => __( 'Click to edit', 'dslc_string' ),
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'styling',
			),

			/**
			 * Tabs Nav
			 */

			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_nav_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_nav_bg_color',
				'std' => '#fbfbfb',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_nav_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_nav_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_nav_border_trbl',
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
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_nav_border_radius_top',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_nav_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( ' Color', 'dslc_string' ),
				'id' => 'css_nav_color',
				'std' => '#8d8d8d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_nav_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_nav_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_nav_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_nav_padding_vertical',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_nav_padding_horizontal',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			array(
				'label' => __( 'Spacing - Items', 'dslc_string' ),
				'id' => 'css_nav_item_margin_right',
				'std' => '-1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Navigation', 'dslc_string' ),
				'min' => -10,
				'max' => 100
			),
			array(
				'label' => __( 'Spacing - Nav and Content', 'dslc_string' ),
				'id' => 'css_nav_content_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Navigation', 'dslc_string' ),
			),
			
			/**
			 * Tabs Nav - Active
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_nav_active_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook.dslc-active',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Navigation Active', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_nav_border_color_active',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook.dslc-active',
				'affect_on_change_rule' => 'border-left-color,border-right-color,border-top-color',
				'section' => 'styling',
				'tab' => __( 'Navigation Active', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Bottom Color', 'dslc_string' ),
				'id' => 'css_nav_border_bottom_color_active',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook.dslc-active',
				'affect_on_change_rule' => 'border-bottom-color',
				'section' => 'styling',
				'tab' => __( 'Navigation Active', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_nav_border_trbl_active',
				'std' => 'top bottom right left',
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
				'affect_on_change_el' => '.dslc-tabs-nav-hook.dslc-active',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Navigation Active', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_nav_active_color',
				'std' => '#8d8d8d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook.dslc-active',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Navigation Active', 'dslc_string' ),
			),

			/**
			 * Tabs Content
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_content_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_content_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_content_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_content_border_trbl',
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
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_content_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_content_border_radius_bottom',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
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
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_content_padding_vertical',
				'std' => '35',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-tab-content',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_content_padding_horizontal',
				'std' => '35',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-tab-content',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/* Content */

			array(
				'label' => __( ' Color', 'dslc_string' ),
				'id' => 'css_content_color',
				'std' => '#8d8d8d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content, .dslc-tabs-content p',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_content_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content, .dslc-tabs-content p',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_content_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content, .dslc-tabs-content p',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100,
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_content_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content, .dslc-tabs-content p',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_content_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content, .dslc-tabs-content p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Bottom ( paragraph )', 'dslc_string' ),
				'id' => 'css_content_margin_bottom',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content p',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_content_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content, .dslc-tabs-content p',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
			),

			/**
			 * Heading 1
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_h1_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_h1_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_h1_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_h1_border_trbl',
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
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_h1_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_h1_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h1_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_h1_font_size',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_h1_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_h1_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_h1_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'dslc_string' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'dslc_string' ),
						'value' => 'italic',
					),
				)
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_h1_line_height',
				'std' => '35',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_h1_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_h1_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_h1_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h1_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h1',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'h1', 'dslc_string' ),
			),

			/**
			 * Heading 2
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_h2_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_h2_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_h2_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_h2_border_trbl',
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
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_h2_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_h2_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h2_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_h2_font_size',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_h2_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_h2_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_h2_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'h2', 'dslc_string' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'dslc_string' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'dslc_string' ),
						'value' => 'italic',
					),
				)
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_h2_line_height',
				'std' => '33',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_h2_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_h2_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_h2_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'H2', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h2_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h2',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
			),

			/**
			 * Heading 3
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_h3_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_h3_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_h3_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_h3_border_trbl',
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
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_h3_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_h3_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h3_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_h3_font_size',
				'std' => '21',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_h3_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_h3_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_h3_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'dslc_string' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'dslc_string' ),
						'value' => 'italic',
					),
				)
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_h3_line_height',
				'std' => '31',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_h3_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_h3_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_h3_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h3_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h3',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'h3', 'dslc_string' ),
			),

			/**
			 * Heading 4
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_h4_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_h4_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_h4_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_h4_border_trbl',
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
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_h4_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_h4_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h4_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_h4_font_size',
				'std' => '19',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_h4_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_h4_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_h4_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'dslc_string' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'dslc_string' ),
						'value' => 'italic',
					),
				)
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_h4_line_height',
				'std' => '29',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_h4_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_h4_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_h4_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h4', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h4_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h4',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
			),

			/**
			 * Heading 5
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_h5_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_h5_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_h5_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_h5_border_trbl',
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
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_h5_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_h5_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h5_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_h5_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_h5_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_h5_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_h5_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'dslc_string' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'dslc_string' ),
						'value' => 'italic',
					),
				)
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_h5_line_height',
				'std' => '27',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_h5_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_h5_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_h5_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h5', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h5_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h5',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
			),

			/**
			 * Heading 6
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_h6_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_h6_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_h6_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_h6_border_trbl',
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
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_h6_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_h6_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h6_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_h6_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_h6_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_h6_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_h6_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'dslc_string' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'dslc_string' ),
						'value' => 'italic',
					),
				)
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_h6_line_height',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_h6_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_h6_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_h6_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'h6', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h6_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content h6',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'h6', 'dslc_string' ),
			),

			/**
			 * Links
			 */

			array(
				'label' => __( 'Link Color', 'dslc_string' ),
				'id' => 'css_link_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'links', 'dslc_string' ),
			),
			array(
				'label' => __( 'Link - Hover Color', 'dslc_string' ),
				'id' => 'css_link_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'links', 'dslc_string' ),
			),

			/**
			 * Lists
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_li_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_li_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_li_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_li_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_li_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_ul_margin_bottom',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content ul,.dslc-tabs-content ol',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Left', 'dslc_string' ),
				'id' => 'css_ul_margin_left',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content ul,.dslc-tabs-content ol',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Unordered Style', 'dslc_string' ),
				'id' => 'css_ul_style',
				'std' => 'disc',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Armenian', 'dslc_string' ),
						'value' => 'armenian'
					),
					array(
						'label' => __( 'Circle', 'dslc_string' ),
						'value' => 'circle'
					),
					array(
						'label' => __( 'cjk-ideographic', 'dslc_string' ),
						'value' => 'cjk-ideographic'
					),
					array(
						'label' => __( 'Decimal', 'dslc_string' ),
						'value' => 'decimal'
					),
					array(
						'label' => __( 'Decimal Leading Zero', 'dslc_string' ),
						'value' => 'decimal-leading-zero'
					),
					array(
						'label' => __( 'Hebrew', 'dslc_string' ),
						'value' => 'hebrew'
					),
					array(
						'label' => __( 'Hiragana', 'dslc_string' ),
						'value' => 'hiragana'
					),
					array(
						'label' => __( 'Hiragana Iroha', 'dslc_string' ),
						'value' => 'hiragana-iroha'
					),
					array(
						'label' => __( 'Katakana', 'dslc_string' ),
						'value' => 'katakana'
					),
					array(
						'label' => __( 'Katakana Iroha', 'dslc_string' ),
						'value' => 'katakana-iroha'
					),
					array(
						'label' => __( 'Lower Alpha', 'dslc_string' ),
						'value' => 'lower-alpha'
					),
					array(
						'label' => __( 'Lower Greek', 'dslc_string' ),
						'value' => 'lower-greek'
					),
					array(
						'label' => __( 'Lower Latin', 'dslc_string' ),
						'value' => 'lower-latin'
					),
					array(
						'label' => __( 'Lower Roman', 'dslc_string' ),
						'value' => 'lower-roman'
					),
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Upper Alpha', 'dslc_string' ),
						'value' => 'upper-alpha'
					),
					array(
						'label' => __( 'Upper Latin', 'dslc_string' ),
						'value' => 'upper-latin'
					),
					array(
						'label' => __( 'Upper Roman', 'dslc_string' ),
						'value' => 'upper-roman'
					),
					array(
						'label' => __( 'Inherit', 'dslc_string' ),
						'value' => 'inherit'
					),
				),
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content ul',
				'affect_on_change_rule' => 'list-style-type',
			),
			array(
				'label' => __( 'Ordered Style', 'dslc_string' ),
				'id' => 'css_ol_style',
				'std' => 'decimal',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Armenian', 'dslc_string' ),
						'value' => 'armenian'
					),
					array(
						'label' => __( 'Circle', 'dslc_string' ),
						'value' => 'circle'
					),
					array(
						'label' => __( 'cjk-ideographic', 'dslc_string' ),
						'value' => 'cjk-ideographic'
					),
					array(
						'label' => __( 'Decimal', 'dslc_string' ),
						'value' => 'decimal'
					),
					array(
						'label' => __( 'Decimal Leading Zero', 'dslc_string' ),
						'value' => 'decimal-leading-zero'
					),
					array(
						'label' => __( 'Hebrew', 'dslc_string' ),
						'value' => 'hebrew'
					),
					array(
						'label' => __( 'Hiragana', 'dslc_string' ),
						'value' => 'hiragana'
					),
					array(
						'label' => __( 'Hiragana Iroha', 'dslc_string' ),
						'value' => 'hiragana-iroha'
					),
					array(
						'label' => __( 'Katakana', 'dslc_string' ),
						'value' => 'katakana'
					),
					array(
						'label' => __( 'Katakana Iroha', 'dslc_string' ),
						'value' => 'katakana-iroha'
					),
					array(
						'label' => __( 'Lower Alpha', 'dslc_string' ),
						'value' => 'lower-alpha'
					),
					array(
						'label' => __( 'Lower Greek', 'dslc_string' ),
						'value' => 'lower-greek'
					),
					array(
						'label' => __( 'Lower Latin', 'dslc_string' ),
						'value' => 'lower-latin'
					),
					array(
						'label' => __( 'Lower Roman', 'dslc_string' ),
						'value' => 'lower-roman'
					),
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Upper Alpha', 'dslc_string' ),
						'value' => 'upper-alpha'
					),
					array(
						'label' => __( 'Upper Latin', 'dslc_string' ),
						'value' => 'upper-latin'
					),
					array(
						'label' => __( 'Upper Roman', 'dslc_string' ),
						'value' => 'upper-roman'
					),
					array(
						'label' => __( 'Inherit', 'dslc_string' ),
						'value' => 'inherit'
					),
				),
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content ol',
				'affect_on_change_rule' => 'list-style-type',
			),
			array(
				'label' => __( 'Spacing', 'dslc_string' ),
				'id' => 'css_ul_li_margin_bottom',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Item - BG Color', 'dslc_string' ),
				'id' => 'css_li_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Border Color', 'dslc_string' ),
				'id' => 'css_li_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Border Width', 'dslc_string' ),
				'id' => 'css_li_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Borders', 'dslc_string' ),
				'id' => 'css_li_border_trbl',
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
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Border Radius - Top', 'dslc_string' ),
				'id' => 'css_li_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_li_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Padding Vertical', 'dslc_string' ),
				'id' => 'css_li_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'tab' => __( 'lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Item - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_li_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content li',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'lists', 'dslc_string' ),
			),

			/**
			 * Inputs
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_inputs_bg_color',
				'std' => '#fff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'inputs', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_inputs_border_color',
				'std' => '#ddd',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'inputs', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_inputs_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'inputs', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_inputs_border_trbl',
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
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'inputs', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_inputs_border_radius',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'inputs', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_inputs_color',
				'std' => '#4d4d4d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'inputs', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_inputs_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'inputs', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_inputs_font_weight',
				'std' => '500',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'inputs', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_inputs_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'inputs', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_inputs_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'textarea',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'inputs', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_inputs_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'inputs', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_inputs_padding_vertical',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'inputs', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_inputs_padding_horizontal',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=text],input[type=email],textarea',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'inputs', 'dslc_string' ),
			),

			/**
			 * Blockquote
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_blockquote_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_blockquote_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_blockquote_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_blockquote_border_trbl',
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
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_blockquote_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_blockquote_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_blockquote_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content blockquote, .dslc-tabs-content blockquote p',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_blockquote_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content blockquote, .dslc-tabs-content blockquote p',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'blockquote', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_blockquote_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content blockquote, .dslc-tabs-content blockquote p',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'blockquote', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_blockquote_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content blockquote, .dslc-tabs-content blockquote p',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_blockquote_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content blockquote, .dslc-tabs-content blockquote p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'blockquote', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_blockquote_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Left', 'dslc_string' ),
				'id' => 'css_blockquote_margin_left',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_blockquote_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_blockquote_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'blockquote', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_blockquote_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'blockquote',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'blockquote', 'dslc_string' ),
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
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_res_t_content_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_res_t_content_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_content_padding_vertical',
				'std' => '35',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-tab-content',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_content_padding_horizontal',
				'std' => '35',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-tab-content',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_nav_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Nav - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_nav_padding_vertical',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_nav_padding_horizontal',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Spacing', 'dslc_string' ),
				'id' => 'css_res_t_nav_item_margin_right',
				'std' => '-1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
				'min' => -10,
				'max' => 100
			),
			array(
				'label' => __( 'Spacing - Nav and Content', 'dslc_string' ),
				'id' => 'css_res_t_nav_content_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
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
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_res_p_content_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_res_p_content_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-content',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_content_padding_vertical',
				'std' => '35',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-tab-content',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_content_padding_horizontal',
				'std' => '35',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-tab-content',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Font Size', 'dslc_string' ),
				'id' => 'css_res_p_nav_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Nav - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_nav_padding_vertical',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_nav_padding_horizontal',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Spacing', 'dslc_string' ),
				'id' => 'css_res_p_nav_item_margin_right',
				'std' => '-1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav-hook',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
				'min' => -10,
				'max' => 100
			),
			array(
				'label' => __( 'Spacing - Nav and Content', 'dslc_string' ),
				'id' => 'css_res_p_nav_content_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tabs-nav',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
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

		$this->module_start( $options );

		/* Module output stars here */ 

			$tabs_nav = explode( '(dslc_sep)', trim( $options['tabs_nav'] ) );
			$tabs_content = explode( '(dslc_sep)', trim( $options['tabs_content'] ) );

		?>

			<div class="dslc-tabs">

				<div class="dslc-tabs-nav dslc-clearfix">
					
					<?php if ( is_array( $tabs_nav ) ) : ?>

						<?php foreach ( $tabs_nav as $tab_nav ) : ?>
							<span class="dslc-tabs-nav-hook">
								<span class="dslc-tabs-nav-hook-title" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes( $tab_nav ); ?></span>
								<?php if ( $dslc_is_admin ) : ?>
									<span class="dslca-delete-tab-hook"><span class="dslca-icon dslc-icon-remove"></span></span>
								<?php endif; ?>
							</span>
						<?php endforeach; ?>

					<?php else : ?>
						<span class="dslc-tabs-nav-hook">
							<span class="dslc-tabs-nav-hook-title" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php _e( 'Click to edit', 'dslc_string' ); ?></span>
							<?php if ( $dslc_is_admin ) : ?>
								<span class="dslca-delete-tab-hook"><span class="dslca-icon dslc-icon-remove"></span></span>
							<?php endif; ?>
						</span>

					<?php endif; ?>

					<?php if ( $dslc_is_admin ) : ?>

						<span class="dslca-add-new-tab-hook">
							<span class="dslca-icon dslc-icon-plus"></span>
						</span>

					<?php endif; ?>

				</div><!-- .dslc-tabs-nav -->

				<div class="dslc-tabs-content">

					<?php if ( is_array( $tabs_content ) ) : $count = 0; ?>

						<?php foreach( $tabs_content as $tab_content ) : ?>

							<div class="dslc-tabs-tab-content">
								<h4 class="dslc-tabs-nav-hook"><?php echo $tabs_nav[$count]; ?></h4>
								<div class="dslca-editable-content">
									<?php 
										$tab_content_output = stripslashes( $tab_content ); 
										$tab_content_output = str_replace( '<lctextarea', '<textarea', $tab_content_output );
										$tab_content_output = str_replace( '</lctextarea', '</textarea', $tab_content_output );
										echo do_shortcode( $tab_content_output );
									?>
								</div>
								<?php if ( $dslc_is_admin ) : ?>
									<textarea class="dslca-tab-plain-content"><?php echo $tab_content_output; ?></textarea>
									<div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e( 'Edit Content', 'dslc_string' ); ?></span></div>
								<?php endif; ?>
							</div><!-- .dslc-tabs-tab-content -->

						<?php $count++; endforeach; ?>

					<?php else : ?>

						<div class="dslc-tabs-tab-content">
							<h4 class="dslc-tabs-nav-hook">CLICK TO EDIT</h4>
							<div class="dslca-editable-content">
								<?php _e( 'This is just placeholder text.', 'dslc_string' ); ?>
							</div>
							<?php if ( $dslc_is_admin ) : ?>
								<textarea class="dslca-tab-plain-content"><?php _e( 'This is just placeholder text.', 'dslc_string' ); ?></textarea>
								<div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e( 'Edit Content', 'dslc_string' ); ?></span></div>
							<?php endif; ?>
						</div><!-- .dslc-tabs-tab-content -->

					<?php endif; ?>

				</div><!-- .dslc-tabs-content -->

			</div><!-- .dslc-tabs -->

		<?php /* Module output ends here */

		$this->module_end( $options );

	}

}