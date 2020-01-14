<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_Social extends DSLC_Module {

	public $module_id;
	public $module_title;
	public $module_icon;
	public $module_category;

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
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
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
					'label' => __( 'Right', 'live-composer-page-builder' ),
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
					'label' => __( 'Top', 'live-composer-page-builder' ),
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
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
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
				'id' => 'css_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
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
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_res_t_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'text-align',
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
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_res_t_padding_left',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => 'ul.dslc-social',
					'affect_on_change_rule' => 'padding-left',
					'section' => 'responsive',
					'tab' => __( 'Tablet', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_res_t_padding_right',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => 'ul.dslc-social',
					'affect_on_change_rule' => 'padding-right',
					'section' => 'responsive',
					'tab' => __( 'Tablet', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'id' => 'css_res_t_padding_top',
					'max' => 600,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => 'ul.dslc-social',
					'affect_on_change_rule' => 'padding-top',
					'section' => 'responsive',
					'tab' => __( 'Tablet', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
					'id' => 'css_res_t_padding_bottom',
					'max' => 600,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => 'ul.dslc-social',
					'affect_on_change_rule' => 'padding-bottom',
					'section' => 'responsive',
					'tab' => __( 'Tablet', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
			array(
				'id' => 'css_res_t_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
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
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_res_p_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'text-align',
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
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_res_p_padding_left',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => 'ul.dslc-social',
					'affect_on_change_rule' => 'padding-left',
					'section' => 'responsive',
					'tab' => __( 'Phone', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_res_p_padding_right',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => 'ul.dslc-social',
					'affect_on_change_rule' => 'padding-right',
					'section' => 'responsive',
					'tab' => __( 'Phone', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'id' => 'css_res_p_padding_top',
					'max' => 600,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => 'ul.dslc-social',
					'affect_on_change_rule' => 'padding-top',
					'section' => 'responsive',
					'tab' => __( 'Phone', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
					'id' => 'css_res_p_padding_bottom',
					'max' => 600,
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => 'ul.dslc-social',
					'affect_on_change_rule' => 'padding-bottom',
					'section' => 'responsive',
					'tab' => __( 'Phone', 'live-composer-page-builder' ),
					'ext' => 'px',
				),
			array(
				'id' => 'css_res_p_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
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

		$social_network_icons = array(
			'twitter' 		=>'twitter',
			'facebook' 		=>'facebook',
			'youtube' 		=>'youtube-play',
			'vimeo' 		=>'vimeo-square',
			'tumblr' 		=>'tumblr',
			'pinterest' 	=>'pinterest',
			'linkedin' 		=>'linkedin',
			'instagram' 	=>'instagram',
			'github' 		=>'github-alt',
			'googleplus' 	=>'google-plus',
			'dribbble' 		=>'dribbble',
			'dropbox' 		=>'dropbox',
			'flickr'		 =>'flickr',
			'foursquare' 	=>'foursquare',
			'behance' 		=>'behance',
			'rss' 			=>'rss',
			'yelp' 			=>'yelp',
			'vk' 			=>'vk',
			'email' 		=>'envelope',
		);

		$social_network_titles = array(
			'twitter' 	=> __( 'Twitter', 'live-composer-page-builder' ),
			'facebook' 	=> __( 'Facebook', 'live-composer-page-builder' ),
			'youtube' 	=> __( 'YouTube', 'live-composer-page-builder' ),
			'vimeo' 	=> __( 'Vimeo', 'live-composer-page-builder' ),
			'tumblr' 	=> __( 'Tumblr', 'live-composer-page-builder' ),
			'pinterest' => __( 'Pinterest', 'live-composer-page-builder' ),
			'linkedin' 	=> __( 'LinkedIn', 'live-composer-page-builder' ),
			'instagram' => __( 'Instagram', 'live-composer-page-builder' ),
			'github' 	=> __( 'Github', 'live-composer-page-builder' ),
			'googleplus' => __( 'Google+', 'live-composer-page-builder' ),
			'dribbble' 	=> __( 'Dribbble', 'live-composer-page-builder' ),
			'dropbox' 	=> __( 'Dropbox', 'live-composer-page-builder' ),
			'flickr'	 => __( 'Flickr', 'live-composer-page-builder' ),
			'foursquare' => __( 'Foursquare', 'live-composer-page-builder' ),
			'behance' 	=> __( 'Behance', 'live-composer-page-builder' ),
			'rss' 		=> __( 'RSS', 'live-composer-page-builder' ),
			'yelp' 		=> __( 'Yelp', 'live-composer-page-builder' ),
			'vk' 		=> __( 'VK', 'live-composer-page-builder' ),
			'xing' 		=> __( 'XING', 'live-composer-page-builder' ),
			'email'		=> __( 'Email', 'live-composer-page-builder' ),
		);

		/* Module output starts here */

			?>
			<div class="dslc-social-wrap">

				<ul class="dslc-social">
				<?php
					foreach ($options as $id => $option) {
						if ( array_key_exists( $id, $social_network_icons ) && $option ) {
							?>
							<li>
								<a class="dslc-social-icon" target="_blank" href="<?php echo $options[$id]; ?>" <?php if ( $options['link_nofollow'] ) { echo 'rel="nofollow"';} ?>><span class="dslc-icon dslc-icon-<?php echo $social_network_icons[$id]; ?>"></span></a>
								<?php if ( $options['show_labels'] == 'enabled' ) : ?>
									<a class="dslc-social-label" target="_blank" href="<?php echo $options[$id]; ?>" <?php if ( $options['link_nofollow'] ) { echo 'rel="nofollow"';} ?>><span><?php echo $social_network_titles[$id]; ?></span></a>
								<?php endif; ?>
							</li>
							<?php
						}
					}
				?>
				</ul>

			</div><!-- .dslc-social-wrap -->

			<?php

	}

}
