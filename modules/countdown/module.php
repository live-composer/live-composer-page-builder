<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_Countdown extends DSLC_Module {

	public $module_id;
	public $module_title;
	public $module_icon;
	public $module_category;

	function __construct() {
		$this->module_id = 'DSLC_Countdown';
		$this->module_title = __( 'Countdown', 'live-composer-page-builder' );
		$this->module_icon = 'hourglass-half';
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

		// Options.
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
				'label' => __( 'Countdown Ends At', 'live-composer-page-builder' ),
				'id' => 'datetime',
				'std' => '2027-01-01 00:00',
				'type' => 'datetime',
				'help'  => __( 'The timer will count down to this specific moment.', 'lcx-plugin' ),
			),
			array(
				'label' => __( 'Use Double Digits', 'live-composer-page-builder' ),
				'id'    => 'zero_pad',
				'std'   => 'yes',
				'type'  => 'select',
				'choices' => array(
					array(
						'label' => __( 'Yes (e.g. 05)', 'lcx-plugin' ),
						'value' => 'yes',
					),
					array(
						'label' => __( 'No (e.g. 5)', 'lcx-plugin' ),
						'value' => 'no',
					),
				),
				'help'  => __( 'Forces the numbers to always show two digits.', 'lcx-plugin' ),
			),

			/**
			 * Styling
			 */

			/**
			 * Wrapper
			 */
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
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
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_margin_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_margin_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_margin_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'margin-right',
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
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
			array(
				'id' => 'css_wrapper_padding_unit',
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
				'id' => 'css_wrapper_padding_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_padding_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'id' => 'css_wrapper_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_width',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
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
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_wrapper_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Box Shadow', 'live-composer-page-builder' ),
				'id' => 'css_main_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'wihtout_inner_shadow' => true,
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
			),
			/**
			 * Counter Number
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_counter_number_color',
				'std' => '#3d3d3d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-amount',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Counter Number', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_counter_number_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '17',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-amount',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Counter Number', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_counter_number_font_weight',
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
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-amount',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Counter Number', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_counter_number_font_family',
				'std' => 'Oswald',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-amount',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Counter Number', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_counter_number_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-amount',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Counter Number', 'live-composer-page-builder' ),
			),
			/**
			 * Counter Label
			 */
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_counter_label_color',
				'std' => '#3d3d3d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-word',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Counter Label', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_counter_label_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '17',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-word',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Counter Label', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_counter_label_font_weight',
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
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-word',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Counter Label', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_counter_label_font_family',
				'std' => 'Oswald',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-word',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Counter Label', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_counter_label_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-word',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Counter Label', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_counter_label__text_transform',
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
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-inner .dslc_countdown-word',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Counter Label', 'live-composer-page-builder' ),
			),
			/**
			 * Counter Item
			 */
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_item_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_item_margin_unit',
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
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_item_margin_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_item_margin_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_item_margin_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_item_margin_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'id' => 'css_item_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_item_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_item_padding_unit',
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
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_item_padding_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_item_padding_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_item_padding_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_item_padding_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'id' => 'css_item_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_item_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_item_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_item_border_width',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_item_border_trbl',
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
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_item_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_item_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Box Shadow', 'live-composer-page-builder' ),
				'id' => 'css_item_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'wihtout_inner_shadow' => true,
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Counter Item', 'live-composer-page-builder' ),
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
				'affect_on_change_el' => '.dslca-countdown-wrapper',
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
				'affect_on_change_el' => '.dslca-countdown-wrapper',
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
				'affect_on_change_el' => '.dslca-countdown-wrapper',
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
				'affect_on_change_el' => '.dslca-countdown-wrapper',
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
				'id' => 'css_res_t_wrapper_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_t_wrapper_padding_unit',
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
				'id' => 'css_res_t_wrapper_padding_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_wrapper_padding_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_t_wrapper_padding_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_wrapper_padding_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_t_wrapper_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			/**
			 * Counter Item
			 */
			array(
				'label' => __( 'Item Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_t_item_margin_unit',
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
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_margin_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_margin_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_margin_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_margin_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'id' => 'css_res_t_item_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Item Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_t_item_padding_unit',
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
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_padding_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_padding_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_padding_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_t_item_padding_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'id' => 'css_res_t_item_padding_group',
				'type' => 'group',
				'action' => 'close',
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
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
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
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '5',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '5',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
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
				'id' => 'css_res_p_wrapper_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_p_wrapper_padding_unit',
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
				'id' => 'css_res_p_wrapper_padding_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_wrapper_padding_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_p_wrapper_padding_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_wrapper_padding_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_p_wrapper_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			/**
			 * Counter Item
			 */
			array(
				'label' => __( 'Item Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_p_item_margin_unit',
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
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_margin_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_margin_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_margin_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_margin_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'id' => 'css_res_p_item_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Item Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_res_p_item_padding_unit',
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
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_padding_top',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_padding_bottom',
				'onlypositive' => true, // Value can't be negative.
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_padding_left',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_res_p_item_padding_right',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslca-countdown-wrapper .dslc_countdown-section',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'id' => 'css_res_p_item_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options' ) );
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
		$wrapper_classes = ! empty( $options['custom_class'] ) ? $options['custom_class'] : '';
		$datetime_value = ! empty( $options['datetime'] ) ? $options['datetime'] : '2027-01-01 00:00';

		$date_parts = date_parse( $datetime_value );
		// Normalize ZeroPad to '1' or '0' string for the data-attribute
		$zero_pad_val = ( isset( $options['zero_pad'] ) && $options['zero_pad'] === 'no' ) ? '0' : '1';

		// Fallbacks to ensure no empty attributes
		$year   = $date_parts['year'] ?: '2027';
		$month  = str_pad( $date_parts['month'] ?: '1', 2, '0', STR_PAD_LEFT );
		$day    = str_pad( $date_parts['day'] ?: '1', 2, '0', STR_PAD_LEFT );
		$hour   = str_pad( $date_parts['hour'] ?: '0', 2, '0', STR_PAD_LEFT );
		$minute = str_pad( $date_parts['minute'] ?: '0', 2, '0', STR_PAD_LEFT );

		ob_start();
		?>
		<div class="dslca-countdown-wrapper <?php echo esc_attr( $wrapper_classes ); ?>"
			data-year="<?php echo esc_attr( $year ); ?>"
			data-month="<?php echo esc_attr( $month ); ?>"
			data-day="<?php echo esc_attr( $day ); ?>"
			data-hour="<?php echo esc_attr( $hour ); ?>"
			data-minute="<?php echo esc_attr( $minute ); ?>"
			data-zeropad="<?php echo esc_attr( $zero_pad_val ? '1' : '0' ); ?>">
		</div>
		<?php

		$shortcode_rendered = ob_get_contents();
		ob_end_clean();

		echo $shortcode_rendered;
	}
}
