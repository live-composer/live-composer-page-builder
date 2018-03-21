<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_TP_Comments_Form extends DSLC_Module {

	public $module_id;
	public $module_title;
	public $module_icon;
	public $module_category;

	function __construct() {

		$this->module_id = 'DSLC_TP_Comments_Form';
		$this->module_title = __( 'Comment Form', 'live-composer-page-builder' );
		$this->module_icon = 'comment';
		$this->module_category = 'For Templates';

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

		// Check if we have this module options already calculated
		// and cached in WP Object Cache.
		$cached_dslc_options = wp_cache_get( 'dslc_options_' . $this->module_id, 'dslc_modules' );
		if ( $cached_dslc_options ) {
			return apply_filters( 'dslc_module_options', $cached_dslc_options, $this->module_id );
		}

		$css_inputs_color_selector = '';
		$css_inputs_color_selector .= '.dslc-tp-comment-form input[type=text], .dslc-tp-comment-form input[type=url], .dslc-tp-comment-form input[type=email], .dslc-tp-comment-form textarea,';
		$css_inputs_color_selector .= '.dslc-tp-comment-form input[type=text]::-moz-placeholder, .dslc-tp-comment-form input[type=url]::-moz-placeholder, .dslc-tp-comment-form input[type=email]::-moz-placeholder, .dslc-tp-comment-form textarea::-moz-placeholder,';
		$css_inputs_color_selector .= '.dslc-tp-comment-form input[type=text]::-webkit-input-placeholder, .dslc-tp-comment-form input[type=url]::-webkit-input-placeholder, .dslc-tp-comment-form input[type=email]::-webkit-input-placeholder, .dslc-tp-comment-form textarea::-webkit-input-placeholder,';
		$css_inputs_color_selector .= '.dslc-tp-comment-form input[type=text]:-ms-input-placeholder, .dslc-tp-comment-form input[type=url]:-ms-input-placeholder, .dslc-tp-comment-form input[type=email]:-ms-input-placeholder, .dslc-tp-comment-form textarea:-ms-input-placeholder';

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
				'label' => __( '"Leave a Comment" Text', 'live-composer-page-builder' ),
				'id' => 'txt_leave_comment',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( '"Comment" Placeholder Text', 'live-composer-page-builder' ),
				'id' => 'txt_comment',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( '"Name" Placeholder Text', 'live-composer-page-builder' ),
				'id' => 'txt_name',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( '"Email" Placeholder Text', 'live-composer-page-builder' ),
				'id' => 'txt_email',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( '"Website" Placeholder Text', 'live-composer-page-builder' ),
				'id' => 'txt_url',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( '"Submit Comment" Button Text', 'live-composer-page-builder' ),
				'id' => 'txt_submit_comment',
				'std' => '',
				'type' => 'text',
			),

			/**
			 * General
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_border_width',
				'onlypositive' => true, // Value can't be negative.
				'max' => 10,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
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
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_border_radius',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_text_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Color - Link', 'live-composer-page-builder' ),
				'id' => 'css_link_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'increment' => 5,
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/**
			 * Heading
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_heading_color',
				'std' => '#4d4d4d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_heading_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '18',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_heading_font_weight',
				'std' => '600',
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
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_heading_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_heading_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '18',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_heading_margin',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/**
			 * Inputs
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_inputs_bg_color',
				'std' => '#fff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_inputs_border_color',
				'std' => '#ddd',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_inputs_border_width',
				'onlypositive' => true, // Value can't be negative.
				'max' => 10,
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_inputs_border_trbl',
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
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_inputs_border_radius',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_inputs_color',
				'std' => '#4d4d4d',
				'type' => 'color',
				'refresh_on_change' => true,
				// 'affect_on_change_el' => $css_inputs_color_selector,
				// 'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_inputs_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_inputs_font_weight',
				'std' => '500',
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
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_inputs_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_inputs_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_inputs_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_inputs_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_inputs_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Inputs', 'live-composer-page-builder' ),
			),

			/**
			 * Submit Button
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_button_bg_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_bg_color_hover',
				'std' => '#4b7bc2',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_button_border_width',
				'onlypositive' => true, // Value can't be negative.
				'max' => 10,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_button_border_trbl',
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
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_button_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_button_border_radius',
				'onlypositive' => true, // Value can't be negative.
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_button_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_button_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => 'px',
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
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_button_font_family',
				'std' => 'Lato',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Button', 'live-composer-page-builder' ),
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
				'affect_on_change_el' => '.dslc-tp-comment-form',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Heading - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_heading_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '18',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Heading - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_heading_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '18',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Heading - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_heading_margin',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Inputs - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_inputs_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Inputs - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_inputs_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Inputs - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_inputs_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Inputs - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_inputs_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Inputs - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_inputs_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_button_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
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
				'affect_on_change_el' => '.dslc-tp-comment-form',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#respond',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Heading - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_heading_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '18',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Heading - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_heading_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '18',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Heading - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_heading_margin',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '#reply-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Inputs - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_inputs_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Inputs - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_inputs_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Inputs - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_inputs_margin_bottom',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Inputs - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_inputs_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Inputs - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_inputs_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-comment-form input[type=text],dslc-tp-comment-form input[type=url],dslc-tp-comment-form input[type=email],.dslc-tp-comment-form textarea',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Button - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Button - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_button_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'input#submit',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array(
			'hover_opts' => false,
		) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		// Cache calculated array in WP Object Cache.
		wp_cache_add( 'dslc_options_' . $this->module_id, $dslc_options, 'dslc_modules' );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	/**
	 * Module HTML output.
	 *
	 * @param  array $options Module options to fill the module template.
	 * @return void
	 */
	function output( $options ) {
	?>
		[dslc_module_comments_form_output]<?php echo serialize( $options ); ?>[/dslc_module_comments_form_output]
	<?php
	}
}



function dslc_module_comments_form_output( $atts, $content = null ) {

	// Uncode module options passed as serialized content.
	$options = unserialize( $content );

	ob_start();

	global $dslc_active;

	$post_id = $options['post_id'];
	$show_fake = true;

	if ( is_singular() && get_post_type() !== 'dslc_templates' && ! $dslc_active ) {

		$post_id = get_the_ID();
		$show_fake = false;
	}

	$txt_submit_comment = __( 'SUBMIT YOUR COMMENT', 'live-composer-page-builder' );
	$txt_leave_comment = __( 'Leave a Comment', 'live-composer-page-builder' );
	$txt_comment = __( 'Comment', 'live-composer-page-builder' );
	$txt_name = __( 'Name', 'live-composer-page-builder' );
	$txt_email = __( 'Email', 'live-composer-page-builder' );
	$txt_url = __( 'Website', 'live-composer-page-builder' );

	if ( isset( $options['txt_submit_comment'] ) && $options['txt_submit_comment'] != '' ) {
		$txt_submit_comment = $options['txt_submit_comment'];
	}

	if ( isset( $options['txt_leave_comment'] ) && $options['txt_leave_comment'] != '' ) {
		$txt_leave_comment = $options['txt_leave_comment'];
	}

	if ( isset( $options['txt_comment'] ) && $options['txt_comment'] != '' ) {
		$txt_comment = $options['txt_comment'];
	}

	if ( isset( $options['txt_name'] ) && $options['txt_name'] != '' ) {
		$txt_name = $options['txt_name'];
	}

	if ( isset( $options['txt_email'] ) && $options['txt_email'] != '' ) {
		$txt_email = $options['txt_email'];
	}

	if ( isset( $options['txt_url'] ) && $options['txt_url'] != '' ) {
		$txt_url = $options['txt_url'];
	}

	if ( isset( $options['css_inputs_color'] ) && $options['css_inputs_color'] != '' ) {
		$css_inputs_color = $options['css_inputs_color'];
	} else {
		$css_inputs_color = 'initial';
	}

	/* Module output starts here */
	?>

		<div class="dslc-tp-comment-form">

			<?php if ( $show_fake ) : ?>

				<?php

				if ( isset( $_POST['dslc_post_id'] ) ) {
					$page_id = $_POST['dslc_post_id'];
				} elseif ( isset( $_GET['dslc_post_id'] ) ) {
					$page_id = $_GET['dslc_post_id'];
				} else {
					$page_id = get_the_ID();
				}

				?>

				<?php if ( get_post_type( $page_id ) === 'dslc_templates' || comments_open( $page_id ) ) { ?>

					<div id="respond" class="comment-respond">
						<h3 id="reply-title" class="comment-reply-title"><?php echo $txt_leave_comment; ?></h3>
						<form action="#" method="post" id="commentform" class="comment-form" novalidate="">
							<div class="comment-form-comment"><textarea id="comment" name="comment"  placeholder="<?php echo $txt_comment; ?>" aria-required="true"></textarea></div>
							<div class="comment-form-name"><input id="author" name="author" type="text" value="" size="30" placeholder="<?php echo $txt_name; ?> *" aria-required="true"></div>
							<div class="comment-form-email"><input id="email" name="email" type="text" value="" size="30" placeholder="<?php echo $txt_email; ?> *" aria-required="true"></div>
							<div class="comment-form-website"><input id="url" name="url" type="text" value="" size="30" placeholder="<?php echo $txt_url; ?>"></div>

							<p class="form-submit">
								<input name="submit" type="submit" id="submit" class="submit" value="<?php echo $txt_submit_comment; ?>">
							</p>
						</form>
					</div>

				<?php } else {

	if ( $dslc_active ) {
		echo '<div class="dslc-notification dslc-red">' . __( 'Comments disabled for the current post ( whole website ), please enable comments on your website.', 'live-composer-page-builder' ) . '</div>';
	}
} ?>

			<?php else :

				global $commenter;
				comment_form( array(
					'label_submit' => $txt_submit_comment,
					'cancel_reply_link' => __( 'cancel', 'live-composer-page-builder' ),
					'comment_notes_before' => '',
					'comment_notes_after' => '',
					'title_reply' => $txt_leave_comment,
					'title_reply_to' => __( 'Reply to %s.', 'live-composer-page-builder' ),
					'comment_field' => '<div class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . $txt_comment . '" aria-required="true"></textarea></div>',
					'fields' => apply_filters( 'comment_form_default_fields', array(
						'author' => '<div class="comment-form-name"><input id="author" name="author" type=text value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="' . $txt_name . ' *" aria-required="true" /></div>',
						'email' => '<div class="comment-form-email"><input id="email" name="email" type=text value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" placeholder="' . $txt_email . ' *" aria-required="true" /></div>',
						'url' => '<div class="comment-form-website"><input id="url" name="url" type=text value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="' . $txt_url . '" /></div>',
					) ),
				), $post_id );

			endif; ?>

		</div><!-- dslc-tp-comment-form -->

		<?php
		/**
		 * In-line CSS below required to style placeholder text color.
		 * Due to poor browser support we can't change it the normal way.
		 */
		?>
		<style type="text/css">
			.dslc-tp-comment-form input[type=text]::-moz-placeholder, .dslc-tp-comment-form input[type=url]::-moz-placeholder, .dslc-tp-comment-form input[type=email]::-moz-placeholder, .dslc-tp-comment-form textarea::-moz-placeholder {
				color: <?php echo $css_inputs_color ?>;
			}
			.dslc-tp-comment-form input[type=text]::-webkit-input-placeholder, .dslc-tp-comment-form input[type=url]::-webkit-input-placeholder, .dslc-tp-comment-form input[type=email]::-webkit-input-placeholder, .dslc-tp-comment-form textarea::-webkit-input-placeholder {
				color: <?php echo $css_inputs_color ?>;
			}
			.dslc-tp-comment-form input[type=text]:-ms-input-placeholder, .dslc-tp-comment-form input[type=url]:-ms-input-placeholder, .dslc-tp-comment-form input[type=email]:-ms-input-placeholder, .dslc-tp-comment-form textarea:-ms-input-placeholder {
				color: <?php echo $css_inputs_color ?>;
			}
		</style>
		<?php

		$shortcode_rendered = ob_get_contents();
		ob_end_clean();

		return $shortcode_rendered;

} add_shortcode( 'dslc_module_comments_form_output', 'dslc_module_comments_form_output' );
