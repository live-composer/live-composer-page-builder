<?php

class DSLC_Notification extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Notification';
		$this->module_title = __( 'Notification', 'dslc_string' );
		$this->module_icon = 'info';
		$this->module_category = 'elements';

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

			/**
			 * Styling
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_bg_color',
				'std' => '#f65757',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_border_color',
				'std' => '#e43737',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
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
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_border_radius',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
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
				'affect_on_change_el' => '.dslc-notification-box',
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
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_padding_horizontal',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px'
			),

			/* Text */

			array(
				'label' => __( 'Content', 'dslc_string' ),
				'id' => 'content',
				'std' => __( 'This is just placeholder text.', 'dslc_string' ),
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'styling',
				'tab' => __( 'text', 'dslc_string' ),
			),
			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box, .dslc-notification-box p',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Text', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_text_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box, .dslc-notification-box p',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'text', 'dslc_string' ),
			),
			array(
				'label' => __( 'Link - Color', 'dslc_string' ),
				'id' => 'css_text_link_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'text', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_text_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box, .dslc-notification-box p',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'text', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_text_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box, .dslc-notification-box p',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'text', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_text_line_height',
				'std' => '26',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box, .dslc-notification-box p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'text', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_font_family',
				'std' => 'Droid Serif',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box, .dslc-notification-box p',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'text', 'dslc_string' ),
			),

			/* Close */

			array(
				'label' => __( 'Enable/Disable', 'dslc_string' ),
				'id' => 'css_close_display',
				'std' => 'block',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'block'
					),
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'none'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'display',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_close_bg_color',
				'std' => '#fff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'dslc_string' ),
				'id' => 'css_close_bg_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_close_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'dslc_string' ),
				'id' => 'css_close_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_close_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_close_border_trbl',
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
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_close_border_radius',
				'std' => '50',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Top', 'dslc_string' ),
				'id' => 'css_close_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'top',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
				'ext' => 'px',
			),
			
			array(
				'label' => __( 'Margin Right', 'dslc_string' ),
				'id' => 'css_close_right',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'right',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
				'ext' => 'px',
			),
			
			array(
				'label' => __( 'Size', 'dslc_string' ),
				'id' => 'css_close_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'close', 'dslc_string' ),
			),

			/* Icon */

			array(
				'label' => __( 'Icon - Color', 'dslc_string' ),
				'id' => 'css_close_icon_color',
				'std' => '#f65757',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon - Color - Hover', 'dslc_string' ),
				'id' => 'css_close_icon_color',
				'std' => '#f65757',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close:hover .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'close', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon - Size', 'dslc_string' ),
				'id' => 'css_close_icon_size',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close .dslc-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'close', 'dslc_string' ),
			),

			/**
			 * Responsive tablet
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
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_padding_vertical',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_padding_horizontal',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_res_t_text_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_res_t_text_line_height',
				'std' => '26',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Icon - Size ( Wrapper )', 'dslc_string' ),
				'id' => 'css_res_t_close_icon_size',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close .dslc-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Icom - Size ( Icon )', 'dslc_string' ),
				'id' => 'css_res_t_close_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'width,height',
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
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_padding_vertical',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_padding_horizontal',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_res_p_text_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_res_p_text_line_height',
				'std' => '26',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Icon - Size ( Wrapper )', 'dslc_string' ),
				'id' => 'css_res_p_close_icon_size',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close .dslc-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Icom - Size ( Icon )', 'dslc_string' ),
				'id' => 'css_res_p_close_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-notification-box-close',
				'affect_on_change_rule' => 'width,height',
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

		$this->module_start( $options );

		/* Module output starts here */
			
			?>

			<div class="dslc-notification-box">
				<div class="dslc-notification-box-content  dslca-editable-content" data-id="content">
					<?php
						$output_content = stripslashes( $options['content'] );
						$output_content = do_shortcode( $output_content );
						echo $output_content;
					?>
				</div>
				<?php if ( $dslc_active ) : ?>
					<div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e( 'Edit Content', 'dslc_string' ); ?></span></div>
				<?php endif; ?>
				<span class="dslc-notification-box-close"><span class="dslc-icon dslc-icon-remove dslc-init-center"></span></span>
			</div><!-- .dslc-notification-box -->

			<?php

		/* Module output ends here */

		$this->module_end( $options );

	}

}