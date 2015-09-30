<?php

class DSLC_Html extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Html';
		$this->module_title = __( 'HTML', 'dslc_string' );
		$this->module_icon = 'code';
		$this->module_category = 'general';

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
				'label' => __( 'HTML/Shortcode', 'dslc_string' ),
				'id' => 'content',
				'std' => '<p>Just some placeholder content. Edit the module to change it.</p>',
				'type' => 'textarea',
				'section' => 'functionality'
			),

			/**
			 * Styling Options
			 */

			array(
				'label' => __( 'Enable/Disable Custom CSS', 'dslc_string' ),
				'id' => 'css_custom',
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
				),
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_main_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_main_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_main_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
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
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_main_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_main_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
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
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_main_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_main_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Box Shadow', 'dslc_string' ),
				'id' => 'css_main_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
			),

			/**
			 * Content
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_main_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content,.dslc-html-module-content p',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_main_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content,.dslc-html-module-content p',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_main_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content,.dslc-html-module-content p',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_main_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content,.dslc-html-module-content p',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_main_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content,.dslc-html-module-content p',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
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
				'id' => 'css_main_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content,.dslc-html-module-content p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom ( paragraph )', 'dslc_string' ),
				'id' => 'css_main_margin_bottom',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content p',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_main_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content,.dslc-html-module-content p',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
			),

			/**
			 * Heading 1
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h1_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h1',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'H1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_h1_font_size',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h1',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'H1', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_h1_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h1',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'H1', 'dslc_string' ),
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
				'affect_on_change_el' => '.dslc-html-module-content h1',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'H1', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_h1_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h1',
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
				'affect_on_change_el' => '.dslc-html-module-content h1',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'H1', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_h1_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h1',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'H1', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h1_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h1',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'H1', 'dslc_string' ),
			),

			/**
			 * Heading 2
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h2_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h2',
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
				'affect_on_change_el' => '.dslc-html-module-content h2',
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
				'affect_on_change_el' => '.dslc-html-module-content h2',
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
				'affect_on_change_el' => '.dslc-html-module-content h2',
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
				'affect_on_change_el' => '.dslc-html-module-content h2',
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
				'affect_on_change_el' => '.dslc-html-module-content h2',
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
				'affect_on_change_el' => '.dslc-html-module-content h2',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h2_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h2',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'H2', 'dslc_string' ),
			),

			/**
			 * Heading 3
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h3_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'H3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_h3_font_size',
				'std' => '21',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'H3', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_h3_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'H3', 'dslc_string' ),
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
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'H3', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_h3_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
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
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'H3', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_h3_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'H3', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h3_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'H3', 'dslc_string' ),
			),

			/**
			 * Heading 4
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h4_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h4',
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
				'affect_on_change_el' => '.dslc-html-module-content h4',
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
				'affect_on_change_el' => '.dslc-html-module-content h4',
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
				'affect_on_change_el' => '.dslc-html-module-content h4',
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
				'affect_on_change_el' => '.dslc-html-module-content h4',
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
				'affect_on_change_el' => '.dslc-html-module-content h4',
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
				'affect_on_change_el' => '.dslc-html-module-content h4',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'H4', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h4_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h4',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'h4', 'dslc_string' ),
			),

			/**
			 * Heading 5
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h5_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h5',
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
				'affect_on_change_el' => '.dslc-html-module-content h5',
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
				'affect_on_change_el' => '.dslc-html-module-content h5',
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
				'affect_on_change_el' => '.dslc-html-module-content h5',
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
				'affect_on_change_el' => '.dslc-html-module-content h5',
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
				'affect_on_change_el' => '.dslc-html-module-content h5',
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
				'affect_on_change_el' => '.dslc-html-module-content h5',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'H5', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h5_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h5',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'h5', 'dslc_string' ),
			),

			/**
			 * Heading 6
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_h6_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h6',
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
				'affect_on_change_el' => '.dslc-html-module-content h6',
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
				'affect_on_change_el' => '.dslc-html-module-content h6',
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
				'affect_on_change_el' => '.dslc-html-module-content h6',
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
				'affect_on_change_el' => '.dslc-html-module-content h6',
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
				'affect_on_change_el' => '.dslc-html-module-content h6',
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
				'affect_on_change_el' => '.dslc-html-module-content h6',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'H6', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_h6_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h6',
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
				'affect_on_change_el' => '.dslc-html-module-content a',
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
				'affect_on_change_el' => '.dslc-html-module-content a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'links', 'dslc_string' ),
			),
			array(
				'label' => __( 'Blockquote Link - Color', 'dslc_string' ),
				'id' => 'css_blockquote_link_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content blockquote a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'links', 'dslc_string' ),
			),
			array(
				'label' => __( 'Blockquote Link - Hover Color', 'dslc_string' ),
				'id' => 'css_blockquote_link_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content blockquote a:hover',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content ul,.dslc-html-module-content ol',
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
				'affect_on_change_el' => '.dslc-html-module-content ul,.dslc-html-module-content ol',
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
				'affect_on_change_el' => '.dslc-html-module-content ul',
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
				'affect_on_change_el' => '.dslc-html-module-content ol',
				'affect_on_change_rule' => 'list-style-type',
			),
			array(
				'label' => __( 'Spacing', 'dslc_string' ),
				'id' => 'css_ul_li_margin_bottom',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => '.dslc-html-module-content li',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => 'input[type=text],input[type=password],input[type=number],input[type=email],textarea,select',
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
				'affect_on_change_el' => '.dslc-html-module-content blockquote, .dslc-html-module-content blockquote p',
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
				'affect_on_change_el' => '.dslc-html-module-content blockquote, .dslc-html-module-content blockquote p',
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
				'affect_on_change_el' => '.dslc-html-module-content blockquote, .dslc-html-module-content blockquote p',
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
				'affect_on_change_el' => '.dslc-html-module-content blockquote, .dslc-html-module-content blockquote p',
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
				'affect_on_change_el' => '.dslc-html-module-content blockquote, .dslc-html-module-content blockquote p',
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
			 * Submit Button
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_button_bg_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'dslc_string' ),
				'id' => 'css_button_bg_color_hover',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit]:hover, button:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_button_border_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'dslc_string' ),
				'id' => 'css_button_border_color_hover',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit]:hover, button:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_button_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_button_border_trbl',
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
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_button_border_radius',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_button_color',
				'std' => '#fff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color - Hover', 'dslc_string' ),
				'id' => 'css_button_color_hover',
				'std' => '#fff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit]:hover, button:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_button_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_button_font_weight',
				'std' => '500',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_button_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_button_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'buttons', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_button_padding_vertical',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'buttons', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_button_padding_horizontal',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input[type=submit], button',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'buttons', 'dslc_string' ),
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
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_main_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_main_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_res_t_main_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_res_t_main_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H2 - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_h2_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h2',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H2 - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_h2_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h2',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H2 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_h2_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h2',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H3 - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_h3_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H3 - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_h3_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H3 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_h3_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H4 - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_h4_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h4',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H4 - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_h4_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h4',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H4 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_h4_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h4',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H5 - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_h5_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h5',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H5 - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_h5_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h5',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H5 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_h5_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h5',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H6 - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_h6_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h6',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H6 - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_h6_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h6',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H6 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_h6_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h6',
				'affect_on_change_rule' => 'margin-bottom',
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
				'id' => 'css_res_ph_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_ph_main_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_ph_main_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_res_ph_main_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_res_ph_main_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H2 - Font Size', 'dslc_string' ),
				'id' => 'css_res_ph_h2_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h2',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H2 - Line Height', 'dslc_string' ),
				'id' => 'css_res_ph_h2_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h2',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H2 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_h2_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h2',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H3 - Font Size', 'dslc_string' ),
				'id' => 'css_res_ph_h3_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H3 - Line Height', 'dslc_string' ),
				'id' => 'css_res_ph_h3_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H3 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_h3_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h3',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H4 - Font Size', 'dslc_string' ),
				'id' => 'css_res_ph_h4_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h4',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H4 - Line Height', 'dslc_string' ),
				'id' => 'css_res_ph_h4_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h4',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H4 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_h4_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h4',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H5 - Font Size', 'dslc_string' ),
				'id' => 'css_res_ph_h5_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h5',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H5 - Line Height', 'dslc_string' ),
				'id' => 'css_res_ph_h5_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h5',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H5 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_h5_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h5',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H6 - Font Size', 'dslc_string' ),
				'id' => 'css_res_ph_h6_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h6',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H6 - Line Height', 'dslc_string' ),
				'id' => 'css_res_ph_h6_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h6',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'H6 - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_h6_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-html-module-content h6',
				'affect_on_change_rule' => 'margin-bottom',
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

		$this->module_start( $options );

		/* Module output starts here */
			
			?><div class="dslc-html-module-content"><?php 

				$output_content = stripslashes( $options['content'] );
				$output_content = do_shortcode( $output_content );
				echo $output_content;

			?></div><?php

			if ( empty( $output_content ) ) :

				?><div class="dslc-notification dslc-red">Looks like there is no content.</div><?php

			endif;

		/* Module output ends here */

		$this->module_end( $options );

	}

}