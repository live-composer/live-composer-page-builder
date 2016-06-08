<?php

/**
 * Social module class
 */

/**
 * Class DSLC_Social
 *
 * @inherited
 */

class DSLC_Social extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct( $settings = [], $atts = [] ) {

		$this->module_ver = 2;
		$this->module_id = __CLASS__;
		$this->module_title = __( 'Social', 'live-composer-page-builder' );
		$this->module_icon = 'twitter';
		$this->module_category = 'elements';

		parent::__construct( $settings, $atts );

	}

	/**
	 * @inherited
	 */
	function options() {

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
				'label' => __( 'Show Labels', 'live-composer-page-builder' ),
				'id' => 'show_labels',
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
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_border_radius',
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
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
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
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social li',
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'tab' => __( 'icon', 'live-composer-page-builder' ),
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
				'tab' => __( 'icon', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Size', 'live-composer-page-builder' ),
				'id' => 'css_icon_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'icon', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'tab' => __( 'labels', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_label_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'labels', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_label_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'labels', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'tab' => __( 'labels', 'live-composer-page-builder' ),
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
				'tab' => __( 'labels', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'live-composer-page-builder' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'live-composer-page-builder' ),
						'value' => 'italic',
					),
				)
			),
			array(
				'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_label_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'labels', 'live-composer-page-builder' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_label_line_height',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'labels', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'tab' => __( 'labels', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_label_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'live-composer-page-builder' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Capitalize', 'live-composer-page-builder' ),
						'value' => 'capitalize'
					),
					array(
						'label' => __( 'Uppercase', 'live-composer-page-builder' ),
						'value' => 'uppercase'
					),
					array(
						'label' => __( 'Lowercase', 'live-composer-page-builder' ),
						'value' => 'lowercase'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'labels', 'live-composer-page-builder' ),
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
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
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
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Size ( Icon )', 'live-composer-page-builder' ),
				'id' => 'css_res_t_icon_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
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
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Size ( Icon )', 'live-composer-page-builder' ),
				'id' => 'css_res_p_icon_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}


	/**
	 * @inherited
	 */
	function output( $options = [] )
	{
		$this->module_start();

		/* Module output stars here */
		echo $this->renderModule( __DIR__, $options );
		/* Module output ends here */

		$this->module_end();
	}

}

/// Register module
( new DSLC_Social )->register();