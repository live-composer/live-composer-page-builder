<?php

	// Prevent direct access to the file.
	if (! defined('ABSPATH')) {
		header('HTTP/1.0 403 Forbidden');
		exit;
	}

	class DSLC_Section extends DSLC_Module
	{

		public $module_id;
		public $module_title;
		public $module_icon;
		public $module_category;

		function __construct()
		{

			$this->module_id = 'DSLC_Section';
			$this->module_title = __('Section', 'live-composer-page-builder');
			$this->module_icon = 'th-large';
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
		function options()
		{

			// Check if we have this module options already calculated
			// and cached in WP Object Cache.
			$cached_dslc_options = wp_cache_get('dslc_options_' . $this->module_id, 'dslc_modules');
			if ($cached_dslc_options) {
				return apply_filters('dslc_module_options', $cached_dslc_options, $this->module_id);
			}

			// Options.
			$dslc_options = array(

				array(
					'label' => __('Show On', 'live-composer-page-builder'),
					'id' => 'css_show_on',
					'std' => 'desktop tablet phone',
					'type' => 'checkbox',
					'choices' => array(
						array(
							'label' => __('Desktop', 'live-composer-page-builder'),
							'value' => 'desktop',
						),
						array(
							'label' => __('Tablet', 'live-composer-page-builder'),
							'value' => 'tablet',
						),
						array(
							'label' => __('Phone', 'live-composer-page-builder'),
							'value' => 'phone',
						),
					),
				),
				array(
					'label' => __('Select Template', 'live-composer-page-builder'),
					'id' => 'template_id',
					'std' => '',
					'type' => 'select',
					'choices' => $this->get_section_templates_list(),
				),
				array(
					'label' => __('Sticky Section', 'live-composer-page-builder'),
					'id' => 'sticky_section',
					'help' => __('If enabled sticky Section will be pushed to the top. If disabled sticky section will follow regular order.', 'live-composer-page-builder'),
					'std' => 'disabled',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => __('Enabled', 'live-composer-page-builder'),
							'value' => 'enabled',
						),
						array(
							'label' => __('Disabled', 'live-composer-page-builder'),
							'value' => 'disabled',
						),
					),
				),

				/**
				 * Styling
				 */

				/**
				 * Wrapper
				 */

				array(
					'label' => __('BG Color', 'live-composer-page-builder'),
					'id' => 'css_wrapper_bg_color',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'background-color',
					'section' => 'styling',
				),
				array(
					'label' => __('Border Color', 'live-composer-page-builder'),
					'id' => 'css_wrapper_border_color',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
				),
				array(
					'label' => __('Border Width', 'live-composer-page-builder'),
					'id' => 'css_wrapper_border_width',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'border-width',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __('Borders', 'live-composer-page-builder'),
					'id' => 'css_wrapper_border_trbl',
					'std' => 'top right bottom left',
					'type' => 'checkbox',
					'choices' => array(
						array(
							'label' => __('Top', 'live-composer-page-builder'),
							'value' => 'top',
						),
						array(
							'label' => __('Right', 'live-composer-page-builder'),
							'value' => 'right',
						),
						array(
							'label' => __('Bottom', 'live-composer-page-builder'),
							'value' => 'bottom',
						),
						array(
							'label' => __('Left', 'live-composer-page-builder'),
							'value' => 'left',
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'border-style',
					'section' => 'styling',
				),
				array(
					'label' => __('Border Radius - Top', 'live-composer-page-builder'),
					'id' => 'css_wrapper_border_radius_top',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __('Border Radius - Bottom', 'live-composer-page-builder'),
					'id' => 'css_wrapper_border_radius_bottom',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __('Margin', 'live-composer-page-builder'),
					'id' => 'css_margin_group',
					'type' => 'group',
					'action' => 'open',
					'section' => 'styling',
				),
				array(
					'id' => 'css_margin_unit',
					'std' => 'px',
					'label' => __('Margin Unit', 'live-composer-page-builder'),
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
					'label' => __('Top', 'live-composer-page-builder'),
					'id' => 'css_margin_top',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '10',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-top',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __('Bottom', 'live-composer-page-builder'),
					'id' => 'css_margin_bottom',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '10',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __('Left', 'live-composer-page-builder'),
					'id' => 'css_margin_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '10',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-left',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __('Right', 'live-composer-page-builder'),
					'id' => 'css_margin_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '10',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
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
					'label' => __('Padding', 'live-composer-page-builder'),
					'id' => 'css_wrapper_padding_group',
					'type' => 'group',
					'action' => 'open',
					'section' => 'styling',
				),
				array(
					'id' => 'css_wrapper_padding_unit',
					'std' => 'px',
					'label' => __('Padding Unit', 'live-composer-page-builder'),
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
					'label' => __('Top', 'live-composer-page-builder'),
					'id' => 'css_wrapper_padding_top',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-top',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __('Bottom', 'live-composer-page-builder'),
					'id' => 'css_wrapper_padding_bottom',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-bottom',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __('Left', 'live-composer-page-builder'),
					'id' => 'css_wrapper_padding_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-left',
					'section' => 'styling',
					'ext' => 'px',
				),
				array(
					'label' => __('Right', 'live-composer-page-builder'),
					'id' => 'css_wrapper_padding_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
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

				/**
				 * Responsive Tablet
				 */

				array(
					'label' => __('Responsive Styling', 'live-composer-page-builder'),
					'id' => 'css_res_t',
					'std' => 'disabled',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => __('Disabled', 'live-composer-page-builder'),
							'value' => 'disabled',
						),
						array(
							'label' => __('Enabled', 'live-composer-page-builder'),
							'value' => 'enabled',
						),
					),
					'section' => 'responsive',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Margin', 'live-composer-page-builder'),
					'id' => 'css_res_t_margin_group',
					'type' => 'group',
					'action' => 'open',
					'section' => 'responsive',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'id' => 'css_res_t_margin_unit',
					'std' => 'px',
					'label' => __('Margin Unit', 'live-composer-page-builder'),
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
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Top', 'live-composer-page-builder'),
					'id' => 'css_res_t_margin_top',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-top',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Bottom', 'live-composer-page-builder'),
					'id' => 'css_res_t_margin_bottom',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Left', 'live-composer-page-builder'),
					'id' => 'css_res_t_margin_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-left',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Right', 'live-composer-page-builder'),
					'id' => 'css_res_t_margin_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-right',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'id' => 'css_res_t_margin_group',
					'type' => 'group',
					'action' => 'close',
					'section' => 'responsive',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Padding', 'live-composer-page-builder'),
					'id' => 'css_res_t_wrapper_padding_group',
					'type' => 'group',
					'action' => 'open',
					'section' => 'responsive',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'id' => 'css_res_t_wrapper_padding_unit',
					'std' => 'px',
					'label' => __('Padding Unit', 'live-composer-page-builder'),
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
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Top', 'live-composer-page-builder'),
					'id' => 'css_res_t_wrapper_padding_top',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-top',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Bottom', 'live-composer-page-builder'),
					'id' => 'css_res_t_wrapper_padding_bottom',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-bottom',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Left', 'live-composer-page-builder'),
					'id' => 'css_res_t_wrapper_padding_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-left',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Right', 'live-composer-page-builder'),
					'id' => 'css_res_t_wrapper_padding_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-right',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),
				array(
					'id' => 'css_res_t_wrapper_padding_group',
					'type' => 'group',
					'action' => 'close',
					'section' => 'responsive',
					'tab' => __('Tablet', 'live-composer-page-builder'),
				),

				/**
				 * Responsive Phone
				 */

				array(
					'label' => __('Responsive Styling', 'live-composer-page-builder'),
					'id' => 'css_res_p',
					'std' => 'disabled',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => __('Disabled', 'live-composer-page-builder'),
							'value' => 'disabled',
						),
						array(
							'label' => __('Enabled', 'live-composer-page-builder'),
							'value' => 'enabled',
						),
					),
					'section' => 'responsive',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Margin', 'live-composer-page-builder'),
					'id' => 'css_res_p_margin_group',
					'type' => 'group',
					'action' => 'open',
					'section' => 'responsive',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'id' => 'css_res_p_margin_unit',
					'std' => 'px',
					'label' => __('Margin Unit', 'live-composer-page-builder'),
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
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Top', 'live-composer-page-builder'),
					'id' => 'css_res_p_margin_top',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '5',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-top',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Bottom', 'live-composer-page-builder'),
					'id' => 'css_res_p_margin_bottom',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '5',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Left', 'live-composer-page-builder'),
					'id' => 'css_res_p_margin_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '5',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-left',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Right', 'live-composer-page-builder'),
					'id' => 'css_res_p_margin_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '5',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'margin-right',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'id' => 'css_res_p_margin_group',
					'type' => 'group',
					'action' => 'close',
					'section' => 'responsive',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Main - Padding', 'live-composer-page-builder'),
					'id' => 'css_res_p_wrapper_padding_group',
					'type' => 'group',
					'action' => 'open',
					'section' => 'responsive',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'id' => 'css_res_p_wrapper_padding_unit',
					'std' => 'px',
					'label' => __('Padding Unit', 'live-composer-page-builder'),
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
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Top', 'live-composer-page-builder'),
					'id' => 'css_res_p_wrapper_padding_top',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-top',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Bottom', 'live-composer-page-builder'),
					'id' => 'css_res_p_wrapper_padding_bottom',
					'onlypositive' => true, // Value can't be negative.
					'min' => -2000,
					'max' => 2000,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-bottom',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Left', 'live-composer-page-builder'),
					'id' => 'css_res_p_wrapper_padding_left',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-left',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'label' => __('Right', 'live-composer-page-builder'),
					'id' => 'css_res_p_wrapper_padding_right',
					'onlypositive' => true, // Value can't be negative.
					'std' => '0',
					'min' => -2000,
					'max' => 2000,
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-section',
					'affect_on_change_rule' => 'padding-right',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),
				array(
					'id' => 'css_res_p_wrapper_padding_group',
					'type' => 'group',
					'action' => 'close',
					'section' => 'responsive',
					'tab' => __('Phone', 'live-composer-page-builder'),
				),

			);

			$dslc_options = array_merge($dslc_options, $this->shared_options('animation_options', array(
				'hover_opts' => false,
			)));
			$dslc_options = array_merge($dslc_options, $this->presets_options());

			// Cache calculated array in WP Object Cache.
			wp_cache_add('dslc_options_' . $this->module_id, $dslc_options, 'dslc_modules');

			return apply_filters('dslc_module_options', $dslc_options, $this->module_id);
		}
		/**
		 * Module Get Section Temlates List.
		 *
		 * @param  array $options Module options to fill the module template.
		 * @return void
		 */
		function get_section_templates_list()
		{
			$args = array(
				'post_type'      => 'dslc_template_parts',
				'posts_per_page' => -1,
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key'     => 'dslc_template_part_for',
						'value'   => 'section',
						'compare' => '=',
					),
					array(
						'key'     => 'dslc_template_part_for',
						'compare' => 'NOT EXISTS',
					),
				),
			);

			$query = new WP_Query($args);
			$templates = array();

			if ($query->have_posts()) {
				
				// Templates exist: Add "Select" prompt first
				$templates[] = array(
					'label' => __( '-- Select a Template --', 'live-composer-page-builder' ),
					'value' => '',
				);

				while ($query->have_posts()) {
					$query->the_post();
					$templates[] = array(
						'label' => get_the_title(),
						'value' => get_the_ID(),
					);
				}
			} else {
				// No templates exist: Show specific notice
				$templates[] = array(
					'label' => __( 'No templates found to select', 'live-composer-page-builder' ),
					'value' => '',
				);
			}

			wp_reset_postdata();
			return $templates;
		}

		/**
		 * Module HTML output.
		 *
		 * @param  array $options Module options to fill the module template.
		 * @return void
		 */
		function output($options)
		{
			// Render the module output in the shortcode
			// to make sure it's not cached in LC and pagination works as expected.
			// @todo: add conditional caching only if pagination used.
			// if ( 'disabled' === $options['pagination_type'] )
			// # code...
			// }
			$dslc_options = apply_filters('dslc_module_options_before_output', $options);
			echo '[dslc_module_section_output]' . serialize($dslc_options) . '[/dslc_module_section_output]';
		}
	}

	function dslc_module_section_output( $atts, $content = null ) {

		// 1. Secure Deserialization
		$options = json_decode( $content, true );
		if ( ! is_array( $options ) ) {
			$options = @unserialize( $content, array( 'allowed_classes' => false ) );
		}

		if ( ! is_array( $options )) {
			return '';
		}

		$template_id = isset( $options['template_id'] ) ? $options['template_id'] : '';

		// If ID is empty OR template is no longer valid/available
		if ( ! $template_id || ! dslc_is_template_available( $template_id, 'section' ) ) {
			if ( dslc_is_editor_active( 'access' ) || ( isset( $_REQUEST['dslc'] ) && $_REQUEST['dslc'] === 'active' ) ) {
				return dslc_render_template_placeholder( 'Section' );
			}
			return '';
		}

		// Editor Detection
		$is_editor = ( dslc_is_editor_active( 'access' ) || ( isset( $_REQUEST['dslc'] ) && $_REQUEST['dslc'] === 'active' ) );

		if ( ! $is_editor ) {
			// FRONT-END: Standard render
			$rendered_code = dslc_render_content( dslc_get_code( $options['template_id'] ), false, true );
			return '<div class="dslc-section-template-render">' . do_shortcode( dslc_decode_shortcodes( $rendered_code ) ) . '</div>';
		} else {
			// EDITOR: Use the master helper with overlay enabled
			return dslc_render_template_part_preview( $options['template_id'], __( 'Edit Section Template', 'live-composer' ), true );
		}
	}
	add_shortcode('dslc_module_section_output', 'dslc_module_section_output');
