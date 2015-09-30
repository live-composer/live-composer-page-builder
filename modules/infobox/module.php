<?php

class DSLC_Info_Box extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Info_Box';
		$this->module_title = __( 'Info Box', 'dslc_string' );
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
			array(
				'label' => __( 'Title Link', 'dslc_string' ),
				'id' => 'title_link',
				'std' => '',
				'type' => 'text'
			),
			array(
				'label' => __( 'Title Link - Open in', 'dslc_string' ),
				'id' => 'title_link_target',
				'std' => '_self',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Same Tab', 'dslc_string' ),
						'value' => '_self',
					),
					array(
						'label' => __( 'New Tab', 'dslc_string' ),
						'value' => '_blank',
					),
				)
			),
			array(
				'label' => __( 'Icon Link', 'dslc_string' ),
				'id' => 'icon_link',
				'std' => '',
				'type' => 'text'
			),
			array(
				'label' => __( 'Icon Link - Open in', 'dslc_string' ),
				'id' => 'icon_link_target',
				'std' => '_self',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Same Tab', 'dslc_string' ),
						'value' => '_self',
					),
					array(
						'label' => __( 'New Tab', 'dslc_string' ),
						'value' => '_blank',
					),
				)
			),
			array(
				'label' => __( 'Primary Button Link', 'dslc_string' ),
				'id' => 'button_link',
				'std' => '#',
				'type' => 'text'
			),
			array(
				'label' => __( 'Primary Button - Open in', 'dslc_string' ),
				'id' => 'button_target',
				'std' => '_self',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Same Tab', 'dslc_string' ),
						'value' => '_self',
					),
					array(
						'label' => __( 'New Tab', 'dslc_string' ),
						'value' => '_blank',
					),
				)
			),
			array(
				'label' => __( 'Secondary Button Link', 'dslc_string' ),
				'id' => 'button_2_link',
				'std' => '',
				'type' => 'text'
			),
			array(
				'label' => __( 'Secondary Button - Open in', 'dslc_string' ),
				'id' => 'button_2_target',
				'std' => '_self',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Same Tab', 'dslc_string' ),
						'value' => '_self',
					),
					array(
						'label' => __( 'New Tab', 'dslc_string' ),
						'value' => '_blank',
					),
				)
			),
			
			/**
			 * General
			 */
			
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'icon title content button',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Icon', 'dslc_string' ),
						'value' => 'icon'
					),
					array(
						'label' => __( 'Title', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Content', 'dslc_string' ),
						'value' => 'content'
					),
					array(
						'label' => __( 'Button', 'dslc_string' ),
						'value' => 'button'
					),
				),
				'section' => 'styling'
			),
			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'text_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image', 'dslc_string' ),
				'id' => 'css_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image Repeat', 'dslc_string' ),
				'id' => 'css_bg_img_repeat',
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
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image Attachment', 'dslc_string' ),
				'id' => 'css_bg_img_attch',
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
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image Position', 'dslc_string' ),
				'id' => 'css_bg_img_pos',
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
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_border_color',
				'std' => '#000000',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
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
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_border_radius',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
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
				'affect_on_change_el' => '.dslc-info-box',
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
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'max' => 500,
				'increment' => 1,
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Width', 'dslc_string' ),
				'id' => 'css_content_width',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-main-wrap',
				'affect_on_change_rule' => 'max-width',
				'section' => 'styling',
				'ext' => '%'
			),
			array(
				'label' => __( 'Box Shadow', 'dslc_string' ),
				'id' => 'css_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
			),

			/**
			 * Wrapper
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_wrapper_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'BG Image', 'dslc_string' ),
				'id' => 'css_wrapper_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'BG Image Repeat', 'dslc_string' ),
				'id' => 'css_wrapper_bg_img_repeat',
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
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'BG Image Attachment', 'dslc_string' ),
				'id' => 'css_wrapper_bg_img_attch',
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
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'BG Image Position', 'dslc_string' ),
				'id' => 'css_wrapper_bg_img_pos',
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
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_wrapper_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_wrapper_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_wrapper_border_trbl',
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
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_wrapper_border_radius',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_wrapper_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'max' => 500,
				'increment' => 1,
				'ext' => 'px',
				'tab' => __( 'wrapper', 'dslc_string' )
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_wrapper_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'wrapper', 'dslc_string' )
			),

			/**
			 * Icon
			 */

			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_icon_text_align',
				'std' => 'inherit',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_icon_bg_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_icon_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_icon_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Icon', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_icon_border_trbl',
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
				'affect_on_change_el' => '.dslc-info-box-image-inner',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_icon_border_radius',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_icon_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon', 'dslc_string' ),
				'id' => 'icon_id',
				'std' => 'comments',
				'type' => 'icon',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
				'include_in_preset' => false
			),
			array(
				'label' => __( 'Margin Top', 'dslc_string' ),
				'id' => 'css_icon_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
				'ext' => 'px',
				'min' => -100,
				'max' => 50
			),
			array(
				'label' => __( 'Margin Right', 'dslc_string' ),
				'id' => 'css_icon_margin_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
				'ext' => 'px',
				'min' => 0,
				'max' => 100
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_icon_margin_bottom',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
				'ext' => 'px',
				'min' => 0,
				'max' => 100
			),
			array(
				'label' => __( 'Position', 'dslc_string' ),
				'id' => 'icon_position',
				'std' => 'above',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Above', 'dslc_string' ),
						'value' => 'above',
					),
					array(
						'label' => __( 'Aside', 'dslc_string' ),
						'value' => 'aside',
					),
				),
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
			),
			array(
				'label' => __( 'Size ( Wrapper )', 'dslc_string' ),
				'id' => 'css_icon_wrapper_width',
				'std' => '84',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
				'ext' => 'px',
				'min' => 0,
				'max' => 300
			),
			array(
				'label' => __( 'Size ( Icon )', 'dslc_string' ),
				'id' => 'css_icon_width',
				'std' => '31',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner .dslc-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Box Shadow', 'dslc_string' ),
				'id' => 'css_icon_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Icon', 'dslc_string' ),
			),

			/**
			 * Title
			 */

			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_title_text_align',
				'std' => 'inherit',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_title_color',
				'std' => '#3d3d3d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title h4',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_title_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title h4',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_title_font_weight',
				'std' => '800',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title h4',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_title_font_family',
				'std' => 'Lato',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title h4',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_title_line_height',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title h4',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_title_margin',
				'std' => '21',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => 'px'
			),
			

			/**
			 * Content
			 */

			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_content_text_align',
				'std' => 'inherit',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_content_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_content_font_size',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_content_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
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
				'id' => 'css_content_font_family',
				'std' => 'Lato',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_content_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_content_margin',
				'std' => '28',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
				'ext' => 'px'
			),

			/**
			 * Button
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_button_bg_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'dslc_string' ),
				'id' => 'css_button_bg_color_hover',
				'std' => '#3e73c2',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_button_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
				'ext' => 'px'
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
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_button_border_color',
				'std' => '#d8d8d8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'dslc_string' ),
				'id' => 'css_button_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_button_border_radius',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_button_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
				array(
				'label' => __( 'Color - Hover', 'dslc_string' ),
				'id' => 'css_button_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_button_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_button_font_weight',
				'std' => '800',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
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
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Letter Spacing', 'dslc_string' ),
				'id' => 'css_button_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50
			),
			array(
				'label' => __( 'Margin Top', 'dslc_string' ),
				'id' => 'css_button_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Right', 'dslc_string' ),
				'id' => 'css_button_margin_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Position', 'dslc_string' ),
				'id' => 'button_pos',
				'std' => 'bellow',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Right of content', 'dslc_string' ),
						'value' => 'aside',
					),
					array(
						'label' => __( 'Bellow content', 'dslc_string' ),
						'value' => 'bellow',
					),
				),
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_button_padding_vertical',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_button_padding_horizontal',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon', 'dslc_string' ),
				'id' => 'button_icon_id',
				'std' => 'cog',
				'type' => 'icon',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon - Color', 'dslc_string' ),
				'id' => 'css_button_icon_color',
				'std' => '#b0c8eb',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon - Color Hover', 'dslc_string' ),
				'id' => 'css_button_icon_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a:hover .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon - Margin Right', 'dslc_string' ),
				'id' => 'css_button_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Box Shadow', 'dslc_string' ),
				'id' => 'css_button_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-primary',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Box Shadow - Hover', 'dslc_string' ),
				'id' => 'css_button_box_shadow_hover',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-primary:hover',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Primary Button', 'dslc_string' ),
			),

			/**
			 * Secondary Button
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_button_2_bg_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'dslc_string' ),
				'id' => 'css_button_2_bg_color_hover',
				'std' => '#3e73c2',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_button_2_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_button_2_border_trbl',
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
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_button_2_border_color',
				'std' => '#d8d8d8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'dslc_string' ),
				'id' => 'css_button_2_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_button_2_border_radius',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_button_2_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
				array(
				'label' => __( 'Color - Hover', 'dslc_string' ),
				'id' => 'css_button_2_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_button_2_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_button_2_font_weight',
				'std' => '800',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_button_2_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Letter Spacing', 'dslc_string' ),
				'id' => 'css_button_2_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50
			),
			array(
				'label' => __( 'Margin Left', 'dslc_string' ),
				'id' => 'css_button_2_mleft',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Top', 'dslc_string' ),
				'id' => 'css_button_2_mtop',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_button_2_padding_vertical',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_button_2_padding_horizontal',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon', 'dslc_string' ),
				'id' => 'button_2_icon_id',
				'std' => 'cog',
				'type' => 'icon',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon - Color', 'dslc_string' ),
				'id' => 'css_button_2_icon_color',
				'std' => '#b0c8eb',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon - Color Hover', 'dslc_string' ),
				'id' => 'css_button_2_icon_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary:hover .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Icon - Margin Right', 'dslc_string' ),
				'id' => 'css_button_2_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Box Shadow', 'dslc_string' ),
				'id' => 'css_button_2_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),
			array(
				'label' => __( 'Box Shadow - Hover', 'dslc_string' ),
				'id' => 'css_button_2_box_shadow_hover',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary:hover',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Secondary Button', 'dslc_string' ),
			),

			/**
			 * Hidden
			 */

			array(
				'label' => __( 'Title', 'dslc_string' ),
				'id' => 'title',
				'std' => 'CLICK TO EDIT',
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'styling'
			),
			array(
				'label' => __( 'Content', 'dslc_string' ),
				'id' => 'content',
				'std' => 'This is just placeholder text. Click here to edit it.',
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'styling'
			),
			array(
				'label' => __( 'Button Title', 'dslc_string' ),
				'id' => 'button_title',
				'std' => 'CLICK TO EDIT',
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'styling'
			),
			array(
				'label' => __( 'Button Title', 'dslc_string' ),
				'id' => 'button_2_title',
				'std' => 'CLICK TO EDIT',
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'styling'
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
				'affect_on_change_el' => '.dslc-info-box',
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
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'max' => 500,
				'increment' => 1,
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Wrapper - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_inner_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'max' => 500,
				'increment' => 1,
				'ext' => 'px'
			),
			array(
				'label' => __( 'Wrapper - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_inner_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Width', 'dslc_string' ),
				'id' => 'css_res_t_content_width',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-main-wrap',
				'affect_on_change_rule' => 'max-width',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => '%'
			),
			array(
				'label' => __( 'Icon - Margin Top', 'dslc_string' ),
				'id' => 'css_res_t_icon_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
				'min' => -100,
				'max' => 50
			),
			array(
				'label' => __( 'Icon - Margin Right', 'dslc_string' ),
				'id' => 'css_res_t_icon_margin_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
				'min' => 0,
				'max' => 100
			),
			array(
				'label' => __( 'Icon - Size ( Wrapper )', 'dslc_string' ),
				'id' => 'css_res_t_icon_wrapper_width',
				'std' => '84',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
				'min' => 0,
				'max' => 300
			),
			array(
				'label' => __( 'Icon - Size ( Icon )', 'dslc_string' ),
				'id' => 'css_res_t_icon_width',
				'std' => '31',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner .dslc-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_title_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title h4',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_title_line_height',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title h4',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_title_margin',
				'std' => '21',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_content_font_size',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_content_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_content_margin',
				'std' => '28',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_button_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Margin Top', 'dslc_string' ),
				'id' => 'css_res_t_button_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Margin Right', 'dslc_string' ),
				'id' => 'css_res_t_button_margin_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_button_padding_vertical',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_button_padding_horizontal',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Icon - Margin Right', 'dslc_string' ),
				'id' => 'css_res_t_button_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( '2nd Button Margin Left', 'dslc_string' ),
				'id' => 'css_res_t_button_2_mleft',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( '2nd Button Margin Top', 'dslc_string' ),
				'id' => 'css_res_t_button_2_mtop',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'tablet', 'dslc_string' ),
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
				'affect_on_change_el' => '.dslc-info-box',
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
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'max' => 500,
				'increment' => 1,
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Wrapper - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_inner_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'max' => 500,
				'increment' => 1,
				'ext' => 'px'
			),
			array(
				'label' => __( 'Wrapper - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_inner_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-wrapper',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Width', 'dslc_string' ),
				'id' => 'css_res_p_content_width',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-main-wrap',
				'affect_on_change_rule' => 'max-width',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => '%'
			),
			array(
				'label' => __( 'Icon - Margin Top', 'dslc_string' ),
				'id' => 'css_res_p_icon_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
				'min' => -100,
				'max' => 50
			),
			array(
				'label' => __( 'Icon - Margin Right', 'dslc_string' ),
				'id' => 'css_res_p_icon_margin_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
				'min' => 0,
				'max' => 100
			),
			array(
				'label' => __( 'Icon - Size ( Wrapper )', 'dslc_string' ),
				'id' => 'css_res_p_icon_wrapper_width',
				'std' => '84',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
				'min' => 0,
				'max' => 300
			),
			array(
				'label' => __( 'Icon - Size ( Icon )', 'dslc_string' ),
				'id' => 'css_res_p_icon_width',
				'std' => '31',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-image-inner .dslc-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Font Size', 'dslc_string' ),
				'id' => 'css_res_p_title_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title h4',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'dslc_string' ),
				'id' => 'css_res_p_title_line_height',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title h4',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_title_margin',
				'std' => '21',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Font Size', 'dslc_string' ),
				'id' => 'css_res_p_content_font_size',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Line Height', 'dslc_string' ),
				'id' => 'css_res_p_content_line_height',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content, .dslc-info-box-content p',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_content_margin',
				'std' => '28',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-content',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Font Size', 'dslc_string' ),
				'id' => 'css_res_p_button_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Button - Margin Top', 'dslc_string' ),
				'id' => 'css_res_p_button_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Margin Right', 'dslc_string' ),
				'id' => 'css_res_p_button_margin_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_button_padding_vertical',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_button_padding_horizontal',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Icon - Margin Right', 'dslc_string' ),
				'id' => 'css_res_p_button_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( '2nd Button Margin Left', 'dslc_string' ),
				'id' => 'css_res_p_button_2_mleft',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( '2nd Button Margin Top', 'dslc_string' ),
				'id' => 'css_res_p_button_2_mtop',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-info-box-button a.dslc-secondary',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'phone', 'dslc_string' ),
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

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

		?>

			<div class="dslc-info-box dslc-info-box-icon-pos-<?php echo $options['icon_position']; ?>">

				<div class="dslc-info-box-wrapper">

					<?php if ( $options['button_pos'] == 'aside' && in_array( 'button', $elements ) ) : ?>
						<div class="dslc-info-box-button dslc-info-box-button-aside">
							<?php if ( isset( $options['button_link'] ) && ! empty( $options['button_link'] ) ) : ?>
								<a href="<?php echo $options['button_link']; ?>" target="<?php echo $options['button_target']; ?>" class="dslc-primary">
									<?php if ( isset( $options['button_icon_id'] ) && $options['button_icon_id'] != '' ) : ?>
										<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>
									<?php endif; ?>
									<?php if ( $dslc_is_admin ) : ?>
										<span class="dslca-editable-content" data-id="button_title" data-type="simple" contenteditable><?php echo $options['button_title']; ?></span>
									<?php else : echo $options['button_title']; endif; ?>
								</a>
							<?php endif; ?>	
							<?php if ( isset( $options['button_2_link'] ) && ! empty( $options['button_2_link'] ) ) : ?>
								<a href="<?php echo $options['button_2_link']; ?>" target="<?php echo $options['button_2_target']; ?>" class="dslc-secondary">
									<?php if ( isset( $options['button_2_icon_id'] ) && $options['button_2_icon_id'] != '' ) : ?>
										<span class="dslc-icon dslc-icon-<?php echo $options['button_2_icon_id']; ?>"></span>
									<?php endif; ?>
									<?php if ( $dslc_is_admin ) : ?>
										<span class="dslca-editable-content" data-id="button_2_title" data-type="simple" contenteditable><?php echo $options['button_2_title']; ?></span>
									<?php else : echo $options['button_2_title']; endif; ?>
								</a>
							<?php endif; ?>
						</div><!-- .dslc-info-box-button -->
					<?php endif; ?>

					<div class="dslc-info-box-main-wrap dslc-clearfix">

						<?php if ( in_array( 'icon', $elements ) ) : ?>
							<div class="dslc-info-box-image">
								<div class="dslc-info-box-image-inner">
									<span class="dslc-icon dslc-icon-<?php echo $options['icon_id']; ?> dslc-init-center"></span>
									<?php if ( ! empty( $options['icon_link'] ) ) : ?>
										<a class="dslc-info-box-image-link" href="<?php echo $options['icon_link']; ?>" target="<?php echo $options['icon_link_target']; ?>"></a>
									<?php endif; ?>
								</div><!-- .dslc-info-box-image-inner -->
							</div><!-- .dslc-info-box-image -->
						<?php endif; ?>

						<div class="dslc-info-box-main">

							<?php if ( in_array( 'title', $elements ) ) : ?>
								<div class="dslc-info-box-title">
									<?php if ( $dslc_is_admin ) : ?>
										<h4 class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes( $options['title'] ); ?></h4>
									<?php else : ?>
										<?php if ( $options['title_link'] != '' ) : ?>
											<h4><a href="<?php echo $options['title_link']; ?>" target="<?php echo $options['title_link_target']; ?>"><?php echo stripslashes( $options['title'] ); ?></a></h4>
										<?php else : ?>
											<h4><?php echo stripslashes( $options['title'] ); ?></h4>
										<?php endif; ?>
									<?php endif; ?>
								</div><!-- .dslc-info-box-title -->
							<?php endif; ?>

							<?php if ( in_array( 'content', $elements ) ) : ?>
								<div class="dslc-info-box-content">
									<?php if ( $dslc_is_admin ) : ?>
										<div class="dslca-editable-content" data-id="content">								
											<?php echo stripslashes( $options['content'] ); ?>
										</div><!-- .dslca-editable-content -->
										<div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e( 'Edit Content', 'dslc_string' ); ?></span></div>
									<?php else : ?>
										<?php echo do_shortcode( stripslashes( $options['content'] ) ); ?>
									<?php endif; ?>
								</div><!-- .dslc-info-box-content -->
							<?php endif; ?>

							<?php if ( $options['button_pos'] == 'bellow' && in_array( 'button', $elements ) ) : ?>
								<div class="dslc-info-box-button">
									<?php if ( isset( $options['button_link'] ) && ! empty( $options['button_link'] ) ) : ?>
										<a href="<?php echo $options['button_link']; ?>" target="<?php echo $options['button_target']; ?>" class="dslc-primary">
											<?php if ( isset( $options['button_icon_id'] ) && $options['button_icon_id'] != '' ) : ?>
												<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>
											<?php endif; ?>
											<?php if ( $dslc_is_admin ) : ?>
												<span class="dslca-editable-content" data-id="button_title" data-type="simple" contenteditable><?php echo $options['button_title']; ?></span>
											<?php else : echo $options['button_title']; endif; ?>
										</a>
									<?php endif; ?>	
									<?php if ( isset( $options['button_2_link'] ) && ! empty( $options['button_2_link'] ) ) : ?>
										<a href="<?php echo $options['button_2_link']; ?>" target="<?php echo $options['button_2_target']; ?>" class="dslc-secondary">
											<?php if ( isset( $options['button_2_icon_id'] ) && $options['button_2_icon_id'] != '' ) : ?>
												<span class="dslc-icon dslc-icon-<?php echo $options['button_2_icon_id']; ?>"></span>
											<?php endif; ?>
											<?php if ( $dslc_is_admin ) : ?>
												<span class="dslca-editable-content" data-id="button_2_title" data-type="simple" contenteditable><?php echo $options['button_2_title']; ?></span>
											<?php else : echo $options['button_2_title']; endif; ?>
										</a>
									<?php endif; ?>
								</div><!-- .dslc-info-box-button -->
							<?php endif; ?>

						</div><!-- .dslc-info-box-main -->

					</div><!-- .dslc-info-box-main-wrap -->

				</div><!-- .dslc-info-box-wrapper -->

			</div><!-- .dslc-info-box -->

		<?php

		/* Module output ends here */

		$this->module_end( $options );

	}

}