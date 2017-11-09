<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_Social extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Social';
		$this->module_title = __( 'Social', 'live-composer-page-builder' );
		$this->module_icon = 'twitter';
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

			/**
			 * General
			 */
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
				'label' => __( 'Show Labels', 'live-composer-page-builder' ),
				'id' => 'show_labels',
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
			),
			array(
				'label' => __( 'Twitter', 'live-composer-page-builder' ),
				'id' => 'twitter',
				'std' => '#',
				'type' => 'text',
			),
			array(
				'label' => __( 'Facebook', 'live-composer-page-builder' ),
				'id' => 'facebook',
				'std' => '#',
				'type' => 'text',
			),
			array(
				'label' => __( 'Youtube', 'live-composer-page-builder' ),
				'id' => 'youtube',
				'std' => '#',
				'type' => 'text',
			),
			array(
				'label' => __( 'Vimeo', 'live-composer-page-builder' ),
				'id' => 'vimeo',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Tumblr', 'live-composer-page-builder' ),
				'id' => 'tumblr',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Pinterest', 'live-composer-page-builder' ),
				'id' => 'pinterest',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'LinkedIn', 'live-composer-page-builder' ),
				'id' => 'linkedin',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Instagram', 'live-composer-page-builder' ),
				'id' => 'instagram',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'GitHub', 'live-composer-page-builder' ),
				'id' => 'github',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Google Plus', 'live-composer-page-builder' ),
				'id' => 'googleplus',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Dribbble', 'live-composer-page-builder' ),
				'id' => 'dribbble',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Dropbox', 'live-composer-page-builder' ),
				'id' => 'dropbox',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Flickr', 'live-composer-page-builder' ),
				'id' => 'flickr',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'FourSquare', 'live-composer-page-builder' ),
				'id' => 'foursquare',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Behance', 'live-composer-page-builder' ),
				'id' => 'behance',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'RSS', 'live-composer-page-builder' ),
				'id' => 'rss',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Yelp', 'live-composer-page-builder' ),
				'id' => 'yelp',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'VK', 'live-composer-page-builder' ),
				'id' => 'vk',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'XING', 'live-composer-page-builder' ),
				'id' => 'xing',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Email', 'live-composer-page-builder' ),
				'id' => 'email',
				'std' => '',
				'type' => 'text',
			),

			/**
			 * Styling
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_border_color',
				'std' => '#000000',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_border_width',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
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
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_border_radius',
				'onlypositive' => true, // Value can't be negative.
				'std' => '50',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '#40bde6',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => ' ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_bg_color_hover',
				'std' => '#40bde6',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => ' ul.dslc-social a.dslc-social-icon:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
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
				'affect_on_change_el' => '.ul.dslc-social',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'increment' => 5,
			),
			array(
				'label' => __( 'Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Left', 'live-composer-page-builder' ),
				'id' => 'css_padding_left',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Right', 'live-composer-page-builder' ),
				'id' => 'css_padding_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Top', 'live-composer-page-builder' ),
				'id' => 'css_padding_top',
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Bottom', 'live-composer-page-builder' ),
				'id' => 'css_padding_bottom',
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size', 'live-composer-page-builder' ),
				'id' => 'css_size',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Spacing', 'live-composer-page-builder' ),
				'id' => 'css_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social li',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/* Icon */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_icon_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => ' ul.dslc-social .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_icon_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => ' ul.dslc-social a.dslc-social-icon:hover .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Size', 'live-composer-page-builder' ),
				'id' => 'css_icon_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Icon', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/* Label */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_label_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Labels', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_label_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Labels', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_label_font_weight',
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
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Labels', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_label_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Labels', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Style', 'live-composer-page-builder' ),
				'id' => 'css_label_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'Labels', 'live-composer-page-builder' ),
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
				'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_label_letter_spacing',
				'max' => 30,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'Labels', 'live-composer-page-builder' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50,
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_label_line_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Labels', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Left', 'live-composer-page-builder' ),
				'id' => 'css_label_mleft',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'tab' => __( 'Labels', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_label_text_transform',
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
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Labels', 'live-composer-page-builder' ),
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
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size ( Wrapper )', 'live-composer-page-builder' ),
				'id' => 'css_res_t_size',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size ( Icon )', 'live-composer-page-builder' ),
				'id' => 'css_res_t_icon_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Spacing', 'live-composer-page-builder' ),
				'id' => 'css_res_t_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social li',
				'affect_on_change_rule' => 'margin-right',
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
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size ( Wrapper )', 'live-composer-page-builder' ),
				'id' => 'css_res_p_size',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size ( Icon )', 'live-composer-page-builder' ),
				'id' => 'css_res_p_icon_font_size',
				'onlypositive' => true, // Value can't be negative.
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Spacing', 'live-composer-page-builder' ),
				'id' => 'css_res_p_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social li',
				'affect_on_change_rule' => 'margin-right',
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

			?>

			<div class="dslc-social-wrap">

				<ul class="dslc-social">
					<?php if ( isset( $options['twitter'] ) && $options['twitter'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['twitter']; ?>"><span class="dslc-icon dslc-icon-twitter"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['twitter']; ?>"><span><?php _e( 'Twitter', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['facebook'] ) && $options['facebook'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['facebook']; ?>"><span class="dslc-icon dslc-icon-facebook"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['facebook']; ?>"><span><?php _e( 'Facebook', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['youtube'] ) && $options['youtube'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['youtube']; ?>"><span class="dslc-icon dslc-icon-youtube-play"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['youtube']; ?>"><span><?php _e( 'Youtube', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['vimeo'] ) && $options['vimeo'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['vimeo']; ?>"><span class="dslc-icon dslc-icon-vimeo-square"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['vimeo']; ?>"><span><?php _e( 'Vimeo', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['tumblr'] ) && $options['tumblr'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['tumblr']; ?>"><span class="dslc-icon dslc-icon-tumblr"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['tumblr']; ?>"><span><?php _e( 'Tumblr', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['pinterest'] ) && $options['pinterest'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['pinterest']; ?>"><span class="dslc-icon dslc-icon-pinterest"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['pinterest']; ?>"><span><?php _e( 'Pinterest', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['linkedin'] ) && $options['linkedin'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['linkedin']; ?>"><span class="dslc-icon dslc-icon-linkedin"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['linkedin']; ?>"><span><?php _e( 'LinkedIn', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['instagram'] ) && $options['instagram'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['instagram']; ?>"><span class="dslc-icon dslc-icon-instagram"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['instagram']; ?>"><span><?php _e( 'Instagram', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['github'] ) && $options['github'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['github']; ?>"><span class="dslc-icon dslc-icon-github-alt"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['github']; ?>"><span><?php _e( 'Github', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['googleplus'] ) && $options['googleplus'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['googleplus']; ?>"><span class="dslc-icon dslc-icon-google-plus"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['googleplus']; ?>"><span><?php _e( 'Google+', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['dribbble'] ) && $options['dribbble'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['dribbble']; ?>"><span class="dslc-icon dslc-icon-dribbble"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['dribbble']; ?>"><span><?php _e( 'Dribbble', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['dropbox'] ) && $options['dropbox'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['dropbox']; ?>"><span class="dslc-icon dslc-icon-dropbox"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['dropbox']; ?>"><span><?php _e( 'Dropbox', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['flickr'] ) && $options['flickr'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['flickr']; ?>"><span class="dslc-icon dslc-icon-flickr"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['flickr']; ?>"><span><?php _e( 'Flickr', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['foursquare'] ) && $options['foursquare'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['foursquare']; ?>"><span class="dslc-icon dslc-icon-foursquare"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['foursquare']; ?>"><span><?php _e( 'Foursquare', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['behance'] ) && $options['behance'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['behance']; ?>"><span class="dslc-icon dslc-icon-behance"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['behance']; ?>"><span><?php _e( 'Behance', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['rss'] ) && $options['rss'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['rss']; ?>"><span class="dslc-icon dslc-icon-rss"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['rss']; ?>"><span><?php _e( 'RSS', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['yelp'] ) && $options['yelp'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['yelp']; ?>"><span class="dslc-icon dslc-icon-yelp"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['yelp']; ?>"><span><?php _e( 'Yelp', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['vk'] ) && $options['vk'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['vk']; ?>"><span class="dslc-icon dslc-icon-vk"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['vk']; ?>"><span><?php _e( 'VK', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['xing'] ) && $options['xing'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['xing']; ?>"><span class="dslc-icon dslc-icon-xing"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['xing']; ?>"><span><?php _e( 'XING', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['email'] ) && $options['email'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['email']; ?>"><span class="dslc-icon dslc-icon-envelope"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['email']; ?>"><span><?php _e( 'Email', 'live-composer-page-builder' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
				</ul>

			</div><!-- .dslc-social-wrap -->

			<?php

	}

}
