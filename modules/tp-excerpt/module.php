<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_TP_Excerpt extends DSLC_Module {

	public $module_id;
	public $module_title;
	public $module_icon;
	public $module_category;

	function __construct() {

		$this->module_id = 'DSLC_TP_Excerpt';
		$this->module_title = __( 'The Excerpt', 'live-composer-page-builder' );
		$this->module_icon = 'font';
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
				'label' => __( 'Use Post Content When No Excerpt', 'live-composer-page-builder' ),
				'id' => 'enable_post_content',
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
				'label' => __( 'Content Preview Length (Words)', 'live-composer-page-builder' ),
				'id' => 'content_word_limit',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_border_width',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
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
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
			),
			array(
				'id' => 'css_margin_unit',
				'std' => 'px',
				'label' => __( 'Margin Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array(
						'label' => 'px',
						'value' => 'px',
					),
					array(
						'label' => '%',
						'value' => '%',
					),
				),
				'section' => 'responsive',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_margin_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_margin_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_margin_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
			),
			array(
				'id' => 'css_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'increment' => 5,
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
			array(
				'id' => 'css_padding_unit',
				'std' => 'px',
				'label' => __( 'Padding Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array(
						'label' => 'px',
						'value' => 'px',
					),
					array(
						'label' => '%',
						'value' => '%',
					),
				),
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_padding_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_padding_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_padding_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_padding_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),

			/**
			 * Typography
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '14',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_font_weight',
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
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '26',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Shadow', 'live-composer-page-builder' ),
				'id' => 'css_text_shadow',
				'std' => '',
				'type' => 'text_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'text-shadow',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
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
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_t_margin_unit',
				'std' => 'px',
				'label' => __( 'Margin Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array(
						'label' => 'px',
						'value' => 'px',
					),
					array(
						'label' => '%',
						'value' => '%',
					),
				),
				'section' => 'responsive',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_t_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_t_padding_unit',
				'std' => 'px',
				'label' => __( 'Padding Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array(
						'label' => 'px',
						'value' => 'px',
					),
					array(
						'label' => '%',
						'value' => '%',
					),
				),
				'section' => 'responsive',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '14',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '26',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/**
			 * Responsive Tablet
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
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_p_margin_unit',
				'std' => 'px',
				'label' => __( 'Margin Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array(
						'label' => 'px',
						'value' => 'px',
					),
					array(
						'label' => '%',
						'value' => '%',
					),
				),
				'section' => 'responsive',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_p_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_p_padding_unit',
				'std' => 'px',
				'label' => __( 'Padding Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array(
						'label' => 'px',
						'value' => 'px',
					),
					array(
						'label' => '%',
						'value' => '%',
					),
				),
				'section' => 'responsive',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '14',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '26',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-excerpt',
				'affect_on_change_rule' => 'line-height',
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

	global $dslc_active;
	global $post;

	$post_id = isset( $options['post_id'] ) ? (int) $options['post_id'] : 0;

	if (
		isset( $post )
		&& is_object( $post )
		&& isset( $post->ID )
	) {
		$post_id = (int) $post->ID;
	}

	$post_type = get_post_type( $post_id );

	$is_template = in_array(
		$post_type,
		array( 'dslc_templates', 'dslc_template_parts' ),
		true
	);
	
	if ( $is_template ) {

		$the_excerpt = '
			<p>
				This is an example excerpt text. It gives a short preview of how
				the excerpt will look when displayed on the site. You can style
				this text while designing your template.
			</p>
		';

	}
	else{
		
		$the_excerpt = false;
		$use_content_fallback = (
			isset( $options['enable_post_content'] )
			&& $options['enable_post_content'] === 'enabled'
		);

		$word_limit = isset( $options['content_word_limit'] ) && (int) $options['content_word_limit'] > 0
			? (int) $options['content_word_limit']
			: 30;

		if ( has_excerpt( $post_id ) ) {

			$post_obj = get_post( $post_id );
			if ( $post_obj ) {
				$the_excerpt = apply_filters( 'get_the_excerpt', $post_obj->post_excerpt );
			}

		// Fallback to content if enabled
		} elseif ( $use_content_fallback ) {

			$post_obj = get_post( $post_id );
			if ( $post_obj && ! empty( $post_obj->post_content ) ) {

				$clean_content = wp_strip_all_tags(
					strip_shortcodes( $post_obj->post_content )
				);

				$clean_content = trim( preg_replace( '/\s+/', ' ', $clean_content ) );

				$the_excerpt = wp_trim_words(
					$clean_content,
					$word_limit,
					'...'
				);
			}
		}
	}

	/* Module output starts here */

	if ( $the_excerpt ) :
		?>
		<div class="dslc-tp-excerpt">
			<?php
			if ( $is_template ) {
				echo $the_excerpt;
			} else {
				echo esc_html( $the_excerpt );
			}
			?>
		</div>
		<?php
	endif;
}


}
