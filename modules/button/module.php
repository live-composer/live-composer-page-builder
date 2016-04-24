<?php
/**
 * Button module class
 *
 * @inherited
 */

/**
 * Class DSLC_Button
 */
class DSLC_Button extends DSLC_Module{

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	/**
	 * @inherited
	 */
	function __construct()
	{
		$this->module_ver = 2;
		$this->module_id = __CLASS__;
		$this->module_title = __( 'Button', 'live-composer-page-builder' );
		$this->module_icon = 'link';
		$this->module_category = 'elements';
	}

	/**
	 * @inherited
	 */
	function options()
	{
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
				'label' => __( 'On Click ( JS )', 'live-composer-page-builder' ),
				'help' => __( '<u>Do not use double quotes</u>.<br>Allows you to call JavaScript code on click event.<br>Can be used for the Google Analytics Event Tracking feature.', 'live-composer-page-builder' ),
				'id' => 'button_onclick',
				'std' => '',
				'type' => 'text',
			 ),
			array(
				'label' => __( 'Custom Classes', 'live-composer-page-builder' ),
				'id' => 'button_class',
				'std' => '',
				'type' => 'text',
			 ),

			/**
			 * Styling
			 */

			array(
				'label' => __( 'Button Text', 'live-composer-page-builder' ),
				'id' => 'button_text',
				'std' => 'CLICK TO EDIT',
				'type' => 'text',
				'visibility' => 'hidden',
			 ),
			array(
				'label' => __( 'URL', 'live-composer-page-builder' ),
				'id' => 'button_url',
				'std' => '#',
				'type' => 'text'
			 ),
			array(
				'label' => __( 'Open in', 'live-composer-page-builder' ),
				'id' => 'button_target',
				'std' => '_self',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Same Tab', 'live-composer-page-builder' ),
						'value' => '_self',
					 ),
					array(
						'label' => __( 'New Tab', 'live-composer-page-builder' ),
						'value' => '_blank',
					 ),
					array(
						'label' => __( 'Lightbox', 'live-composer-page-builder' ),
						'value' => 'lightbox',
					 ),
				 )
			 ),
			array(
				'label' => __( 'Lightbox image', 'live-composer-page-builder' ),
				'id' => 'lightbox_image',
				'std' => '',
				'type' => 'image',
			 ),
			array(
				'id' => 'link_nofollow',
				'std' => '',
				'type' => 'checkbox',
				'help' => __( 'Nofollow tells search engines to not follow this specific link', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Nofollow', 'live-composer-page-builder' ),
						'value' => 'nofollow'
					 ),
				 ),
			 ),

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'BG Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_bg_color_hover',
				'std' => '#4b7bc2',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling'
			 ),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_border_color',
				'std' => '#000',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Border Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			 ),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_border_trbl',
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
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_border_radius',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
			 ),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
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
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			 ),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px'
			 ),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_padding_horizontal',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px'
			 ),
			array(
				'label' => __( 'Width', 'live-composer-page-builder' ),
				'id' => 'css_width',
				'std' => 'inline-block',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Automatic', 'live-composer-page-builder' ),
						'value' => 'inline-block'
					 ),
					array(
						'label' => __( 'Full Width', 'live-composer-page-builder' ),
						'value' => 'block'
					 ),
				 ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'display',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Box Shadow', 'live-composer-page-builder' ),
				'id' => 'css_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Box Shadow - Hover', 'live-composer-page-builder' ),
				'id' => 'css_box_shadow_hover',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a:hover',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
			 ),

			/**
			 * Typography
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_button_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'typography', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'typography', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_button_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'typography', 'live-composer-page-builder' ),
				'ext' => 'px'
			 ),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_button_font_weight',
				'std' => '800',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'typography', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			 ),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_button_font_family',
				'std' => 'Lato',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'typography', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_button_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'typography', 'live-composer-page-builder' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50
			 ),

			/**
			 * Icon
			 */

			array(
				'label' => __( 'Enable/Disable', 'live-composer-page-builder' ),
				'id' => 'button_state',
				'std' => 'enabled',
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
				'section' => 'styling',
				'tab' => __( 'icon', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Position', 'live-composer-page-builder' ),
				'id' => 'icon_pos',
				'std' => 'left',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					 ),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					 ),
				 ),
				'section' => 'styling',
				'tab' => __( 'icon', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Icon', 'live-composer-page-builder' ),
				'id' => 'button_icon_id',
				'std' => 'link',
				'type' => 'icon',
				'section' => 'styling',
				'tab' => __( 'icon', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_icon_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'icon', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_icon_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a:hover .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'icon', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'icon', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Margin Left', 'live-composer-page-builder' ),
				'id' => 'css_icon_margin_left',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'icon', 'live-composer-page-builder' ),
			 ),

			/**
			 * Wrapper
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'BG Image', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'BG Image Repeat', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_bg_img_repeat',
				'std' => 'repeat',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Repeat', 'live-composer-page-builder' ),
						'value' => 'repeat',
					 ),
					array(
						'label' => __( 'Repeat Horizontal', 'live-composer-page-builder' ),
						'value' => 'repeat-x',
					 ),
					array(
						'label' => __( 'Repeat Vertical', 'live-composer-page-builder' ),
						'value' => 'repeat-y',
					 ),
					array(
						'label' => __( 'Do NOT Repeat', 'live-composer-page-builder' ),
						'value' => 'no-repeat',
					 ),
				 ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'BG Image Attachment', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_bg_img_attch',
				'std' => 'scroll',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Scroll', 'live-composer-page-builder' ),
						'value' => 'scroll',
					 ),
					array(
						'label' => __( 'Fixed', 'live-composer-page-builder' ),
						'value' => 'fixed',
					 ),
				 ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'BG Image Position', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_bg_img_pos',
				'std' => 'top left',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'live-composer-page-builder' ),
						'value' => 'left top',
					 ),
					array(
						'label' => __( 'Top Right', 'live-composer-page-builder' ),
						'value' => 'right top',
					 ),
					array(
						'label' => __( 'Top Center', 'live-composer-page-builder' ),
						'value' => 'Center Top',
					 ),
					array(
						'label' => __( 'Center Left', 'live-composer-page-builder' ),
						'value' => 'left center',
					 ),
					array(
						'label' => __( 'Center Right', 'live-composer-page-builder' ),
						'value' => 'right center',
					 ),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center center',
					 ),
					array(
						'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
						'value' => 'left bottom',
					 ),
					array(
						'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
						'value' => 'right bottom',
					 ),
					array(
						'label' => __( 'Bottom Center', 'live-composer-page-builder' ),
						'value' => 'center bottom',
					 ),
				 ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
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
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
			 ),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'wrapper', 'live-composer-page-builder' )
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
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			 ),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			 ),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_horizontal',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			 ),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			 ),
			array(
				'label' => __( 'Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			 ),
			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_res_t_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
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
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			 ),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			 ),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_horizontal',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			 ),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			 ),
			array(
				'label' => __( 'Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			 ),
			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_res_ph_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			 ),


		 );

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );
	}

	/**
	 * Enqueue needed scripts
	 */
	static function wp_enqueue_scripts()
	{
		$path = explode( '/', __DIR__ );
		$path = array_pop( $path );
		wp_enqueue_script( 'js-button-extender',
		                  DS_LIVE_COMPOSER_URL . '/modules/' . $path . '/script.js',
		                  array( 'jquery' ) );
	}

	/**
	 * @inherit
	 */
	static function afterRegister()
	{
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wp_enqueue_scripts') );
	}


	/**
	 * @inherited
	 */
	function output( $options )
	{
		$this->module_start( $options );

		/* Module output starts here */
		echo $this->renderModule( __DIR__, $options );
		/* Module output ends here */

		$this->module_end( $options );
	}

}

/// Register
( new DSLC_Button )->register();