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
					'label' => __('Select Section', 'live-composer-page-builder'),
					'id' => 'template_id',
					'std' => $this->get_section_templates_list()[0]['value'] ? $this->get_section_templates_list()[0]['value'] : '',
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
						'value'   => 'dslc_post_loop',
						'compare' => '!=',
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
				while ($query->have_posts()) {
					$query->the_post();
					$templates[] = array(
						'label' => get_the_title(),
						'value' => get_the_ID(),
					);
				}
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

	function dslc_module_section_output($atts, $content = null)
	{

		// 1. Try JSON DECODING (New, secure format)
		$options = json_decode($content, true);

		// 2. Fallback to PHP unserialize if JSON fails
		// This handles all existing content saved in the serialized format.
		if (! is_array($options)) {

			// Define the secure unserialize arguments based on PHP version.
			$unserialize_args = (version_compare(PHP_VERSION, '7.0.0', '>='))
				? array('allowed_classes' => false) // Secure on PHP 7.0+
				: null; // Allows object injection on older PHP, but this is the necessary trade-off for legacy data loading.
			// For maximum security, you should deprecate support for PHP < 7.0.

			// Try standard unserialize with object injection blocked
			$options = @unserialize($content, $unserialize_args);

			// Fallback for broken serialization string length (from original code)
			if ($options === false) {
				$fixed_data = preg_replace_callback('!s:(\d+):"(.*?)";!', function ($match) {
					return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
				}, $content);
				// Try to unserialize the fixed string, still blocking objects
				$options = @unserialize($fixed_data, $unserialize_args);
			}
		}

		// 3. Final Validation
		if (! is_array($options)) {
			// Data is invalid or failed to deserialize securely.
			return '';
		}		

		ob_start();

		global $dslc_active;

		if ($dslc_active && is_user_logged_in() && current_user_can(DS_LIVE_COMPOSER_CAPABILITY)) {
			$dslc_is_admin = true;
		} else {
			$dslc_is_admin = false;
		}

		/**
		 * Unnamed
		 */

		$columns_class = 'dslc-col dslc-' . $options['columns'] . '-col ';

		/**
		 * Classes generation
		 */

		// section container.
		$container_class = 'custom-template-container dslc-section dslc-clearfix ';

		/**
		 * section ( output )
		 */

		if ($options['template_id']) {
			$edit_link = DSLC_EditorInterface::get_editor_link_url($options['template_id']);
	?>
 		<div class="<?php echo $container_class; ?>">

 			<div class="dslc-section-inner"><?php
				if (dslc_is_editor_active('access')) : ?>
 					<div class="dslc-loop-template-shield" style="position: relative;">
 						<div class="dslc-header dslc-is-global-post"
 							data-hf="header"
 							data-editing-link="<?php echo esc_url($edit_link); ?>"
 							data-editing-label="<?php _e('Edit Section Template', 'live-composer-page-builder'); ?>"
 							style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 999; cursor: pointer;">
 						</div>
 						<div class="dslc-template-preview-content dslc-clearfix" style="pointer-events: none;">
 						<?php endif;
							$composer_code = dslc_get_code($options['template_id']);
						?>

 						<div class="<?php echo $columns_class; ?>">
 							<?php
								if (!dslc_is_editor_active('access')) {

									// Render internal content
									// global $dslc_active;

									// $original_dslc_active = $dslc_active; // Store current state
									// $dslc_active = false; // Disable editor for inner modules

									// Render as "is_header_footer" (3rd param true) to isolate IDs
									$rendered_code = dslc_render_content($composer_code);
									$rendered_code = dslc_decode_shortcodes($rendered_code);

									// Remove internal edit icons/pencils via class swap
									// $rendered_code = str_replace( 'dslc-modules-section', 'dslc-module-section-view-only', $rendered_code );

									echo do_shortcode(do_shortcode($rendered_code));

									// $dslc_active = $original_dslc_active; // Restore state
								} else {
									echo 'Section template design box';
								}
								?>

 						</div>
 						<?php

							if (dslc_is_editor_active('access')) : ?>
 						</div>
 					</div>
 				<?php endif; ?>
 			</div><!--.dslc-section-inner -->

 		</div>
 		<?php
		} else {
			if ($dslc_is_admin) : ?>
				<div class="dslc-notification dslc-red">
					<?php _e('You do not have any Section the moment.', 'live-composer-page-builder'); ?> 
					<span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span>
				</div><?php
			endif;
		} // End if().

		$shortcode_rendered = ob_get_contents();
		ob_end_clean();

		return $shortcode_rendered;
	}
	add_shortcode('dslc_module_section_output', 'dslc_module_section_output');
