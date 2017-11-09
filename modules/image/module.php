<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_Image extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Image';
		$this->module_title = __( 'Image', 'live-composer-page-builder' );
		$this->module_icon = 'picture';
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

		// Check if we have this module options already calculated
		// and cached in WP Object Cache.
		$cached_dslc_options = wp_cache_get( 'dslc_options_' . $this->module_id, 'dslc_modules' );
		if ( $cached_dslc_options ) {
			return apply_filters( 'dslc_module_options', $cached_dslc_options, $this->module_id );
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
				'label' => __( 'CT', 'live-composer-page-builder' ),
				'id' => 'custom_text',
				'std' => __( 'This is just some placeholder text. Click to edit it.', 'live-composer-page-builder' ),
				'type' => 'textarea',
				'visibility' => 'hidden',
			),

			array(
				'label' => __( 'Image - File', 'live-composer-page-builder' ),
				'id' => 'image',
				'std' => '',
				'type' => 'image',
			),
			array(
				'label' => __( 'Image - URL', 'live-composer-page-builder' ),
				'help' => __( 'Will be used as a fallback if file ( previous option ) not supplied.', 'live-composer-page-builder' ),
				'id' => 'image_url',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Link Type', 'live-composer-page-builder' ),
				'id' => 'link_type',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'live-composer-page-builder' ),
						'value' => 'none',
					),
					array(
						'label' => __( 'URL - Same Tab', 'live-composer-page-builder' ),
						'value' => 'url_same',
					),
					array(
						'label' => __( 'URL - New Tab', 'live-composer-page-builder' ),
						'value' => 'url_new',
					),
					array(
						'label' => __( 'Lightbox', 'live-composer-page-builder' ),
						'value' => 'lightbox',
					),
				),
			),
			array(
				'label' => __( 'Link - URL', 'live-composer-page-builder' ),
				'id' => 'link_url',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Lightbox Image', 'live-composer-page-builder' ),
				'id' => 'link_lb_image',
				'std' => '',
				'type' => 'image',
			),
			array(
				'label' => __( 'Custom text', 'live-composer-page-builder' ),
				'id' => 'custom_text_state',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
				),
			),
			array(
				'label' => __( 'Resize - Height', 'live-composer-page-builder' ),
				'id' => 'resize_height',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'resize_width',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Image - ALT attribute', 'live-composer-page-builder' ),
				'id' => 'image_alt',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Image - TITLE attribute', 'live-composer-page-builder' ),
				'id' => 'image_title',
				'std' => '',
				'type' => 'text',
			),

			/**
			 * Styling
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-container',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ) . ' ' . __( '(Block)', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-container',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ) . ' ' . __( '(Image)', 'live-composer-page-builder' ),
				'id' => 'css_bg_color_inner',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
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
				'affect_on_change_el' => '.dslc-image',
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
				'affect_on_change_el' => '.dslc-image',
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
				'affect_on_change_el' => '.dslc-image, .dslc-image img',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				// 'affect_on_change_el' => '.dslc-image-container',
				'affect_on_change_el' => '.dslc-image', // @todo: check how it affects?
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'min' => -250,
				'max' => 250,
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'min' => -250,
				'max' => 250,
			),
			array(
				'label' => __( 'Max Width', 'live-composer-page-builder' ),
				'id' => 'css_max_width',
				'std' => '',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'max-width',
				'section' => 'styling',
				'ext' => 'px',
				'max' => 1400,
				'increment' => 5,
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
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
				'affect_on_change_el' => '.dslc-image',
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
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Force 100% Width', 'live-composer-page-builder' ),
				'id' => 'css_force_width',
				'std' => 'auto',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => '100%',
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'auto',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image, .dslc-image a, .dslc-image img',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
			),

			array(
				'label' => __( 'Box Shadow', 'live-composer-page-builder' ),
				'id' => 'css_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'wihtout_inner_shadow' => true,
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
			),

			/**
			 * Custom Text
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_ct_text_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Custom text', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_ct_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Custom text', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_ct_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Custom text', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_ct_font_weight',
				'std' => '400',
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
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Custom text', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_ct_font_family',
				'std' => '',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Custom text', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_ct_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Custom text', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_ct_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Custom text', 'live-composer-page-builder' ),
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
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_res_t_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-container',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Max Width', 'live-composer-page-builder' ),
				'id' => 'css_res_t_max_width',
				'std' => '',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'max-width',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
				'max' => 1400,
				'increment' => 5,
			),

			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
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
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_ct_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_ct_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text - Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_res_t_ct_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
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
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_res_p__align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-container',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Max Width', 'live-composer-page-builder' ),
				'id' => 'css_res_p_max_width',
				'std' => '',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'max-width',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
				'max' => 1400,
				'increment' => 5,
			),

			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
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
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_ct_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_ct_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text - Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_res_p_ct_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array(
			'hover_opts' => false,
		) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		// Cache calculated array in WP Object Cache.
		wp_cache_add( 'dslc_options_' . $this->module_id, $dslc_options ,'dslc_modules' );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}
	/**
	 * Module HTML output.
	 *
	 * @param  array $options Module options to fill the module template.
	 * @return void
	 */
	function output( $options ) {

		/* Module output starts here */

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

			$dslc_is_admin = true;
		} else {

			$dslc_is_admin = false;
		}

		$anchor_class = '';
		$anchor_target = '_self';
		$anchor_href = '#';

		if ( 'url_new' === $options['link_type'] ) {
			$anchor_target = '_blank';
		}

		if ( ! empty( $options['link_url'] ) ) {
			$anchor_href = $options['link_url'];
		}

		if ( 'lightbox' === $options['link_type'] && ! empty( $options['link_lb_image'] ) ) {
			$anchor_class .= 'dslc-lightbox-image ';
			$anchor_href = $options['link_lb_image'];
		}

		?>
		<div class="dslc-image-container">
		<div class="dslc-image"<?php if ( $dslc_is_admin ) { echo ' data-exportable-content';} ?>>

			<?php if ( empty( $options['image'] ) && empty( $options['image_url'] ) && is_user_logged_in() ) : ?>

				<div class="dslc-notification dslc-red"><?php _e( 'No image has been set yet, edit the module to set one.', 'live-composer-page-builder' ); ?></div>

				<?php

				// Alt and title empty when an image will remove.
				if ( $dslc_is_admin ) {
					$options['image_alt'] = '';
					$options['image_title'] = '';
				}

				?>

			<?php else : ?>

				<?php

				$resize = false;
				$the_image = $options['image'];

				if ( empty( $options['image'] ) ) {

					$the_image = $options['image_url'];

				} else {

					if ( ! empty( $options['resize_width'] ) || ! empty( $options['resize_height'] ) ) {

						$resize = true;
						$resize_width = false;
						$resize_height = false;

						if ( ! empty( $options['resize_width'] ) ) {
							$resize_width = $options['resize_width'];
						}

						if ( ! empty( $options['resize_height'] ) ) {
							$resize_height = $options['resize_height'];
						}

						$the_image = dslc_aq_resize( $options['image'], $resize_width, $resize_height, true );

					}
				}

				if ( $dslc_is_admin && ( strlen( $options['image'] ) > 0 ) ) {
					$image_id = attachment_url_to_postid( $options['image'] );
					$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
					$image_title = get_the_title( $image_id );

					if ( strlen( $options['image_alt'] ) === 0 ) {
						$options['image_alt'] = $image_alt;
					} elseif ( $options['image_alt'] !== $image_alt ) {
						update_post_meta( $image_id, '_wp_attachment_image_alt', $options['image_alt'] );
					}

					if ( strlen( $options['image_title'] ) === 0 ) {
						$options['image_title'] = $image_title;
					} elseif ( $options['image_title'] !== $image_title ) {
						$image = array();
						$image['ID'] = $image_id;
						$image['post_title'] = $options['image_title'];
						wp_update_post( $image );
					}
				}

				?>

				<?php if ( 'none' !== $options['link_type'] ) : ?>
					<a class="<?php echo esc_attr( $anchor_class ); ?>" href="<?php echo esc_attr( $anchor_href ); ?>" target="<?php echo esc_attr( $anchor_target ); ?>">
				<?php endif; ?>
					<img src="<?php echo esc_attr( $the_image ); ?>" alt="<?php echo esc_attr( $options['image_alt'] ); ?>" title="<?php echo esc_attr( $options['image_title'] ); ?>" />
				<?php if ( 'none' !== $options['link_type'] ) : ?>
					</a>
				<?php endif; ?>

				<?php if ( 'enabled' === $options['custom_text_state'] ) : ?>

					<div class="dslc-image-caption">

						<?php if ( $dslc_is_admin ) : ?>
							<div class="dslca-editable-content" data-id="custom_text" data-type="simple" <?php if ( $dslc_is_admin ) { echo 'contenteditable';} ?>>
								<?php
								$output_content = stripslashes( $options['custom_text'] );
								echo apply_filters( 'dslc_before_render', $output_content );
								?>
							</div>
						<?php else : ?>
							<?php
							$output_content = stripslashes( $options['custom_text'] );
							echo apply_filters( 'dslc_before_render', $output_content );
							?>
						<?php endif; ?>

					</div>

				<?php endif; ?>

			<?php endif; ?>

		</div><!-- .dslc-image -->
		</div>
		<?php

	}
}
