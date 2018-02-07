<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_Button extends DSLC_Module {

	public $module_id;
	public $module_title;
	public $module_icon;
	public $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Button';
		$this->module_title = __( 'Button', 'live-composer-page-builder' );
		$this->module_icon = 'link';
		$this->module_category = 'General';

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

		// Custom classes fix
		if ( ! empty( $_POST['button_class'] ) ) {

			$_POST['custom_class'] = $_POST['button_class'];
			$_POST['button_class'] = '';
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
						'value' => 'desktop',
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet',
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone',
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
				'visibility' => 'hidden',
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
				'type' => 'text',
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
				),
			),
			array(
				'id' => 'link_nofollow',
				'std' => '',
				'type' => 'checkbox',
				'help' => __( 'Nofollow tells search engines to not follow this specific link', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Nofollow', 'live-composer-page-builder' ),
						'value' => 'nofollow',
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
				'label' => __( 'Background', 'live-composer-page-builder' ),
				'id' => 'css_bg_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
				array(
					'label' => __( 'Color', 'live-composer-page-builder' ),
					'id' => 'css_bg_color',
					'std' => '#5890e5',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-button a',
					'affect_on_change_rule' => 'background-color',
					'section' => 'styling',
				),
				array(
					'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
					'id' => 'css_bg_color_hover',
					'std' => '#4b7bc2',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-button a:hover',
					'affect_on_change_rule' => 'background-color',
					'section' => 'styling',
				),

			array(
				'id' => 'css_bg_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),

			array(
				'label' => __( 'Border', 'live-composer-page-builder' ),
				'id' => 'css_border_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),

				array(
					'label' => __( 'Color', 'live-composer-page-builder' ),
					'id' => 'css_border_color',
					'std' => '#000',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-button a',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
				),
				array(
					'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
					'id' => 'css_border_color_hover',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-button a:hover',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
				),
				array(
					'label' => __( 'Width', 'live-composer-page-builder' ),
					'id' => 'css_border_width',
					'onlypositive' => true, // Value can't be negative.
					'max' => 10,
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
							'value' => 'top',
						),
						array(
							'label' => __( 'Right', 'live-composer-page-builder' ),
							'value' => 'right',
						),
						array(
							'label' => __( 'Bottom', 'live-composer-page-builder' ),
							'value' => 'bottom',
						),
						array(
							'label' => __( 'Left', 'live-composer-page-builder' ),
							'value' => 'left',
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-button a',
					'affect_on_change_rule' => 'border-style',
					'section' => 'styling',
				),
				array(
					'label' => __( 'Radius', 'live-composer-page-builder' ),
					'id' => 'css_border_radius',
					'onlypositive' => true, // Value can't be negative.
					'std' => '3',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-button a',
					'affect_on_change_rule' => 'border-radius',
					'section' => 'styling',
					'ext' => 'px',
				),

			array(
				'id' => 'css_border_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),

			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'id' => 'css_margin_top',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-button',
					'affect_on_change_rule' => 'margin-top',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_margin_right',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-button',
					'affect_on_change_rule' => 'margin-right',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
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
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_margin_left',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-button',
					'affect_on_change_rule' => 'margin-left',
					'section' => 'styling',
					'ext' => 'px',
				),
			array(
				'id' => 'css_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),

			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				// 'min' => 0,
				// 'max' => 2000,
				// 'increment' => 5,
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 50,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '12',
				'max' => 50,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Width', 'live-composer-page-builder' ),
				'id' => 'css_width',
				'std' => 'inline-block',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Automatic', 'live-composer-page-builder' ),
						'value' => 'inline-block',
					),
					array(
						'label' => __( 'Full Width', 'live-composer-page-builder' ),
						'value' => 'block',
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
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
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
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_button_font_size',
				'onlypositive' => true, // Value can't be negative.
				'max' => 50,
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Style', 'live-composer-page-builder' ),
				'id' => 'css_button_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'live-composer-page-builder' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'live-composer-page-builder' ),
						'value' => 'italic',
					),
				),
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_button_font_weight',
				'std' => '800',
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
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'ext' => '',
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
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_button_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'live-composer-page-builder' ),
						'value' => 'none',
					),
					array(
						'label' => __( 'Capitalize', 'live-composer-page-builder' ),
						'value' => 'capitalize',
					),
					array(
						'label' => __( 'Uppercase', 'live-composer-page-builder' ),
						'value' => 'uppercase',
					),
					array(
						'label' => __( 'Lowercase', 'live-composer-page-builder' ),
						'value' => 'lowercase',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_button_letter_spacing',
				'max' => 30,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50,
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
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
				),
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
				'dependent_controls' => array(
					'enabled' => 'icon_pos, button_icon_id, css_icon_color, css_icon_color_hover, css_icon_margin, css_icon_margin_left, show_icon, button_inline_svg, css_button_icon_size_svg',
				),
			),
			array(
				'label' => __( 'Position', 'live-composer-page-builder' ),
				'id' => 'icon_pos',
				'std' => 'left',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
				),
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Show Icon', 'live-composer-page-builder' ),
				'id' => 'show_icon',
				'std' => 'font',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Font', 'live-composer-page-builder' ),
						'value' => 'font',
					),
					array(
						'label' => __( 'SVG', 'live-composer-page-builder' ),
						'value' => 'svg',
					),
				),
				'help' => __( 'Select type of icon.', 'live-composer-page-builder' ),
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Icon', 'live-composer-page-builder' ),
				'id' => 'button_icon_id',
				'std' => 'link',
				'type' => 'icon',
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Inline SVG', 'live-composer-page-builder' ),
				'id' => 'button_inline_svg',
				'std' => '',
				'type' => 'textarea',
				'section' => 'styling',
				'help' => __( 'Paste your SVG code.', 'live-composer-page-builder' ),
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Size ( SVG )', 'live-composer-page-builder' ),
				'id' => 'css_button_icon_size_svg',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a svg',
				'affect_on_change_rule' => 'width, height',
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_icon_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon, .dslc-button a svg',
				'affect_on_change_rule' => 'color, fill',
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_icon_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a:hover .dslc-icon, .dslc-button:hover a svg',
				'affect_on_change_rule' => 'color, fill',
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon, .dslc-button a svg',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Left', 'live-composer-page-builder' ),
				'id' => 'css_icon_margin_left',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon, .dslc-button a svg',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
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
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
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
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
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
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
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
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
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
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
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
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_width',
				'onlypositive' => true, // Value can't be negative.
				'max' => 10,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Box Shadow', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Wrapper', 'live-composer-page-builder' ),
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
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
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
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Icon Size ( SVG )', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_icon_size_svg',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a svg',
				'affect_on_change_rule' => 'width, height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon, .dslc-button a svg',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
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
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
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
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
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
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Icon Size ( SVG )', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_icon_size_svg',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a svg',
				'affect_on_change_rule' => 'width, height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Icon - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_icon_margin',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-button a .dslc-icon, .dslc-button a svg',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
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
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array(
			'hover_opts' => false,
		) ) );
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

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
					$dslc_is_admin = true;
		} else {
					$dslc_is_admin = false;
		}

		/* Module output starts here */

		$anchor_append = '';

		if ( isset( $options['button_onclick'] ) && $options['button_onclick'] !== '' ) {

			$anchor_append = ' onClick="' . stripslashes( $options['button_onclick'] ) . '"';
		}

		$classes = $options['button_class'] . ' ' . $options['custom_class'];

			?>

			<div class="dslc-button">
				<?php if ( $options['button_target'] == 'lightbox' ) : ?>
					<a href="<?php echo $options['button_url']; ?>" <?php echo $anchor_append;
					if ( $options['link_nofollow'] ) { echo 'rel="nofollow"';} ?> class="dslc-lightbox-image <?php echo trim( esc_attr( $classes ) ); ?>">
						<?php if ( $options['button_state'] == 'enabled' && $options['icon_pos'] == 'left' ) : ?>
							<?php if ( 'svg' == $options['show_icon'] ) : ?>
								<?php echo stripslashes( $options['button_inline_svg'] ); ?>
							<?php else : ?>
								<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>	
							<?php endif; ?>
						<?php endif; ?>
						<?php if ( $dslc_is_admin ) : ?>
							<span class="dslca-editable-content" data-id="button_text"  data-type="simple" contenteditable="true"><?php echo stripslashes( $options['button_text'] ); ?></span>
						<?php else : ?>
							<?php echo stripslashes( $options['button_text'] ); ?>
						<?php endif; ?>
						<?php if ( $options['button_state'] == 'enabled' && $options['icon_pos'] == 'right' ) : ?>
							<?php if ( 'svg' == $options['show_icon'] ) : ?>
								<?php echo stripslashes( $options['button_inline_svg'] ); ?>
							<?php else : ?>
								<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>	
							<?php endif; ?>
						<?php endif; ?>
					</a>
				<?php else : ?>
					<a href="<?php echo $options['button_url']; ?>" target="<?php echo $options['button_target']; ?>" <?php echo $anchor_append;
					if ( $options['link_nofollow'] ) { echo 'rel="nofollow"';} ?> class="<?php echo trim( esc_attr( $classes ) ); ?>">
						<?php if ( $options['button_state'] == 'enabled' && $options['icon_pos'] == 'left' ) : ?>
							<?php if ( 'svg' == $options['show_icon'] ) : ?>
								<?php echo stripslashes( $options['button_inline_svg'] ); ?>
							<?php else : ?>
								<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>	
							<?php endif; ?>
						<?php endif; ?>
						<?php if ( $dslc_is_admin ) : ?>
							<span class="dslca-editable-content" data-id="button_text"  data-type="simple" contenteditable="true"><?php echo stripslashes( $options['button_text'] ); ?></span>
						<?php else : ?>
							<?php echo stripslashes( $options['button_text'] ); ?>
						<?php endif; ?>
						<?php if ( $options['button_state'] == 'enabled' && $options['icon_pos'] == 'right' ) : ?>
							<?php if ( 'svg' == $options['show_icon'] ) : ?>
								<?php echo stripslashes( $options['button_inline_svg'] ); ?>
							<?php else : ?>
								<span class="dslc-icon dslc-icon-<?php echo $options['button_icon_id']; ?>"></span>	
							<?php endif; ?>
						<?php endif; ?>
					</a>
				<?php endif; ?>
			</div><!-- .dslc-button -->


			<?php if ( $dslc_is_admin ) :
				/* We output this button code for clean html export only */ ?>
				<div style="display: none;"<?php if ( $dslc_is_admin ) { echo ' data-exportable-content';} ?>>
					<a href="<?php echo $options['button_url']; ?>" target="<?php echo $options['button_target']; ?>" <?php if ( $options['link_nofollow'] ) { echo 'rel="nofollow"';} ?>>
							<?php echo stripslashes( $options['button_text'] ); ?>
					</a>
				</div><!-- .dslc-button -->
			<?php endif; ?>
			<?php

	}

}
