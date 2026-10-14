<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_CTA_Box extends DSLC_Module {

	public $module_id;
	public $module_title;
	public $module_icon;
	public $module_category;

	function __construct() {

		$this->module_id = 'DSLC_CTA_Box';
		$this->module_title = __( 'Call to Action (CTA)', 'live-composer-page-builder' );
		$this->module_icon = 'bullhorn';
		$this->module_category = 'General';

	}

	function options() {

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
				'label' => 'Title',
				'id' => 'title',
				'std' => 'Join Us Today',
				'type' => 'text',
			),

			array(
				'label' => 'Description',
				'id' => 'desc',
				'std' => 'Start your journey with us now.',
				'type' => 'textarea',
			),

			array(
				'label' => 'Button Text',
				'id' => 'btn_text',
				'std' => 'Get Started',
				'type' => 'text',
			),

			array(
				'label' => 'Button Link',
				'id' => 'btn_link',
				'std' => '#',
				'type' => 'text',
			),

			array(
				'id' => 'link_nofollow',
				'std' => '',
				'type' => 'checkbox',
				'help' => __( 'Nofollow tells search engines to not follow this specific link', 'live-composer-page-builder' ),
				'choices' => array(
					array( 'label' => __( 'Nofollow', 'live-composer-page-builder' ), 'value' => 'nofollow' ),
				),
			),

			/**
			 * Styling – General
			 */

			
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),

			array(
				'id' => 'css_margin_top_unit',
				'std' => 'px',
				'label' => __( 'Top Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array( 'label' => 'px', 'value' => 'px' ),
					array( 'label' => '%', 'value' => '%' ),
				),
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_margin_top',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
			),

			array(
				'id' => 'css_margin_right_unit',
				'std' => 'px',
				'label' => __( 'Right Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array( 'label' => 'px', 'value' => 'px' ),
					array( 'label' => '%', 'value' => '%' ),
				),
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_margin_right',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			array(
				'id' => 'css_margin_bottom_unit',
				'std' => 'px',
				'label' => __( 'Bottom Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array( 'label' => 'px', 'value' => 'px' ),
					array( 'label' => '%', 'value' => '%' ),
				),
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),

			array(
				'id' => 'css_margin_left_unit',
				'std' => 'px',
				'label' => __( 'Left Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array( 'label' => 'px', 'value' => 'px' ),
					array( 'label' => '%', 'value' => '%' ),
				),
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_margin_left',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
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
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_old_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),

			array(
				'id' => 'css_old_padding_top_unit',
				'std' => 'px',
				'label' => __( 'Top Unit', 'live-composer-page-builder' ),
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
				'id' => 'css_old_padding_top',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => 'px',
			),

			array(
				'id' => 'css_old_padding_bottom_unit',
				'std' => 'px',
				'label' => __( 'Bottom Unit', 'live-composer-page-builder' ),
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
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_old_padding_bottom',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),

			array(
				'id' => 'css_old_padding_left_unit',
				'std' => 'px',
				'label' => __( 'Left Unit', 'live-composer-page-builder' ),
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
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_old_padding_left',
				'onlypositive' => true,
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'ext' => 'px',
			),

			array(
				'id' => 'css_old_padding_right_unit',
				'std' => 'px',
				'label' => __( 'Right Unit', 'live-composer-page-builder' ),
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
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_old_padding_right',
				'onlypositive' => true,
				'std' => '10',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			array(
				'id' => 'css_old_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),

			array(
				'label' => __( 'Background', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_color',
				'std' => '#ccc',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Image', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Image Repeat', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img_repeat',
				'std' => 'repeat',
				'type' => 'select',
				'choices' => array(
					array( 'label' => __( 'Repeat', 'live-composer-page-builder' ), 'value' => 'repeat' ),
					array( 'label' => __( 'Repeat Horizontal', 'live-composer-page-builder' ), 'value' => 'repeat-x' ),
					array( 'label' => __( 'Repeat Vertical', 'live-composer-page-builder' ), 'value' => 'repeat-y' ),
					array( 'label' => __( 'Do NOT Repeat', 'live-composer-page-builder' ), 'value' => 'no-repeat' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Image Attachment', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img_attch',
				'std' => 'scroll',
				'type' => 'select',
				'choices' => array(
					array( 'label' => __( 'Scroll', 'live-composer-page-builder' ), 'value' => 'scroll' ),
					array( 'label' => __( 'Fixed', 'live-composer-page-builder' ), 'value' => 'fixed' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Image Position', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img_pos',
				'std' => 'top left',
				'type' => 'select',
				'choices' => array(
					array( 'label' => __( 'Top Left', 'live-composer-page-builder' ), 'value' => 'left top' ),
					array( 'label' => __( 'Top Right', 'live-composer-page-builder' ), 'value' => 'right top' ),
					array( 'label' => __( 'Top Center', 'live-composer-page-builder' ), 'value' => 'Center Top' ),
					array( 'label' => __( 'Center Left', 'live-composer-page-builder' ), 'value' => 'left center' ),
					array( 'label' => __( 'Center Right', 'live-composer-page-builder' ), 'value' => 'right center' ),
					array( 'label' => __( 'Center', 'live-composer-page-builder' ), 'value' => 'center center' ),
					array( 'label' => __( 'Bottom Left', 'live-composer-page-builder' ), 'value' => 'left bottom' ),
					array( 'label' => __( 'Bottom Right', 'live-composer-page-builder' ), 'value' => 'right bottom' ),
					array( 'label' => __( 'Bottom Center', 'live-composer-page-builder' ), 'value' => 'center bottom' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
			),
			array(
				'id' => 'css_main_bg_img_size',
				'std' => 'auto',
				'label' => __( 'Image Size', 'live-composer-page-builder' ),
				'type' => 'select',
				'choices' => array(
					array( 'label' => __( 'Original', 'live-composer-page-builder' ), 'value' => 'auto' ),
					array( 'label' => __( 'Cover', 'live-composer-page-builder' ), 'value' => 'cover' ),
					array( 'label' => __( 'Contain', 'live-composer-page-builder' ), 'value' => 'contain' ),
				),
				'affect_on_change_rule' => 'background-size',
				'affect_on_change_el' => '.dslc-cta-module',
				'section' => 'styling',
			),
			array(
				'id' => 'css_main_bg_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),

			array(
				'label' => __( 'Border', 'live-composer-page-builder' ),
				'id' => 'css_main_border_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_main_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Width', 'live-composer-page-builder' ),
				'id' => 'css_main_border_width',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_main_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array( 'label' => __( 'Top', 'live-composer-page-builder' ), 'value' => 'top' ),
					array( 'label' => __( 'Right', 'live-composer-page-builder' ), 'value' => 'right' ),
					array( 'label' => __( 'Bottom', 'live-composer-page-builder' ), 'value' => 'bottom' ),
					array( 'label' => __( 'Left', 'live-composer-page-builder' ), 'value' => 'left' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_top',
				'onlypositive' => true,
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_bottom',
				'onlypositive' => true,
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'id' => 'css_main_border_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
			),

			array(
				'label' => __( 'Box Shadow', 'live-composer-page-builder' ),
				'id' => 'css_main_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-module',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
			),


			/**
			 * Title Tab
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_title_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Typography', 'live-composer-page-builder' ),
				'id' => 'css_title_typography_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_title_font_size',
				'onlypositive' => true,
				'std' => '26',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_title_font_weight',
				'std' => '600',
				'type' => 'select',
				'choices' => array(
					array( 'label' => '100 - Thin', 'value' => '100' ),
					array( 'label' => '200 - Extra Light', 'value' => '200' ),
					array( 'label' => '300 - Light', 'value' => '300' ),
					array( 'label' => '400 - Normal', 'value' => '400' ),
					array( 'label' => '500 - Medium', 'value' => '500' ),
					array( 'label' => '600 - Semi Bold', 'value' => '600' ),
					array( 'label' => '700 - Bold', 'value' => '700' ),
					array( 'label' => '800 - Extra Bold', 'value' => '800' ),
					array( 'label' => '900 - Black', 'value' => '900' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_title_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Style', 'live-composer-page-builder' ),
				'id' => 'css_title_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'choices' => array(
					array( 'label' => __( 'Normal', 'live-composer-page-builder' ), 'value' => 'normal' ),
					array( 'label' => __( 'Italic', 'live-composer-page-builder' ), 'value' => 'italic' ),
				),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_title_line_height',
				'onlypositive' => true,
				'std' => '22',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_title_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
				'min' => -2000,
				'max' => 2000,
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_title_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array( 'label' => __( 'None', 'live-composer-page-builder' ), 'value' => 'none' ),
					array( 'label' => __( 'Capitalize', 'live-composer-page-builder' ), 'value' => 'capitalize' ),
					array( 'label' => __( 'Uppercase', 'live-composer-page-builder' ), 'value' => 'uppercase' ),
					array( 'label' => __( 'Lowercase', 'live-composer-page-builder' ), 'value' => 'lowercase' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_title_typography_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Padding ( paragraph )', 'live-composer-page-builder' ),
				'id' => 'css_title_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_padding_top_unit',
				'std' => 'px',
				'label' => __( 'Top Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_title_padding_top',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_padding_right_unit',
				'std' => 'px',
				'label' => __( 'Right Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_title_padding_right',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_padding_bottom_unit',
				'std' => 'px',
				'label' => __( 'Bottom Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_title_padding_bottom',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_padding_left_unit',
				'std' => 'px',
				'label' => __( 'Left Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_title_padding_left',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin ( paragraph )', 'live-composer-page-builder' ),
				'id' => 'css_title_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_margin_top_unit',
				'std' => 'px',
				'label' => __( 'Top Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array( 'label' => 'px', 'value' => 'px' ),
					array( 'label' => '%', 'value' => '%' ),
				),
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_title_margin_top',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_margin_bottom_unit',
				'std' => 'px',
				'label' => __( 'Bottom Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array( 'label' => 'px', 'value' => 'px' ),
					array( 'label' => '%', 'value' => '%' ),
				),
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_title_margin_bottom',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_margin_left_unit',
				'std' => 'px',
				'label' => __( 'Left Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array( 'label' => 'px', 'value' => 'px' ),
					array( 'label' => '%', 'value' => '%' ),
				),
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_title_margin_left',
				'onlypositive' => true,
				'std' => '25',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_margin_right_unit',
				'std' => 'px',
				'label' => __( 'Right Unit', 'live-composer-page-builder' ),
				'type' => 'select',
				'refresh_on_change' => false,
				'choices' => array(
					array( 'label' => 'px', 'value' => 'px' ),
					array( 'label' => '%', 'value' => '%' ),
				),
				'section' => 'styling',
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_title_margin_right',
				'onlypositive' => true,
				'std' => '25',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_title_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_title_text_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Shadow', 'live-composer-page-builder' ),
				'id' => 'css_title_text_shadow',
				'std' => '',
				'type' => 'text_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-title',
				'affect_on_change_rule' => 'text-shadow',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),


			/**
			 * Description Tab
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_desc_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Typography', 'live-composer-page-builder' ),
				'id' => 'css_desc_typography_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_desc_font_size',
				'onlypositive' => true,
				'std' => '16',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_desc_font_weight',
				'std' => '400',
				'type' => 'select',
				'choices' => array(
					array( 'label' => '100 - Thin', 'value' => '100' ),
					array( 'label' => '200 - Extra Light', 'value' => '200' ),
					array( 'label' => '300 - Light', 'value' => '300' ),
					array( 'label' => '400 - Normal', 'value' => '400' ),
					array( 'label' => '500 - Medium', 'value' => '500' ),
					array( 'label' => '600 - Semi Bold', 'value' => '600' ),
					array( 'label' => '700 - Bold', 'value' => '700' ),
					array( 'label' => '800 - Extra Bold', 'value' => '800' ),
					array( 'label' => '900 - Black', 'value' => '900' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_desc_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Style', 'live-composer-page-builder' ),
				'id' => 'css_desc_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
				'choices' => array(
					array( 'label' => __( 'Normal', 'live-composer-page-builder' ), 'value' => 'normal' ),
					array( 'label' => __( 'Italic', 'live-composer-page-builder' ), 'value' => 'italic' ),
				),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_desc_line_height',
				'onlypositive' => true,
				'std' => '22',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_desc_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
				'ext' => 'px',
				'min' => -2000,
				'max' => 2000,
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_desc_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array( 'label' => __( 'None', 'live-composer-page-builder' ), 'value' => 'none' ),
					array( 'label' => __( 'Capitalize', 'live-composer-page-builder' ), 'value' => 'capitalize' ),
					array( 'label' => __( 'Uppercase', 'live-composer-page-builder' ), 'value' => 'uppercase' ),
					array( 'label' => __( 'Lowercase', 'live-composer-page-builder' ), 'value' => 'lowercase' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_desc_typography_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Padding ( paragraph )', 'live-composer-page-builder' ),
				'id' => 'css_desc_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_desc_padding_top_unit',
				'std' => 'px',
				'label' => __( 'Top Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_desc_padding_top',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_desc_padding_right_unit',
				'std' => 'px',
				'label' => __( 'Right Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_desc_padding_right',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_desc_padding_bottom_unit',
				'std' => 'px',
				'label' => __( 'Bottom Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_desc_padding_bottom',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_desc_padding_left_unit',
				'std' => 'px',
				'label' => __( 'Left Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_desc_padding_left',
				'std' => '0',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_desc_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin ( paragraph )', 'live-composer-page-builder' ),
				'id' => 'css_desc_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_desc_margin_top_unit',
				'std' => 'px',
				'label' => __( 'Top Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_desc_margin_top',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_desc_margin_bottom_unit',
				'std' => 'px',
				'label' => __( 'Bottom Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_desc_margin_bottom',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_desc_margin_left_unit',
				'std' => 'px',
				'label' => __( 'Left Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_desc_margin_left',
				'onlypositive' => true,
				'std' => '25',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_desc_margin_right_unit',
				'std' => 'px',
				'label' => __( 'Right Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_desc_margin_right',
				'onlypositive' => true,
				'std' => '25',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'id' => 'css_desc_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_desc_text_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Shadow', 'live-composer-page-builder' ),
				'id' => 'css_desc_text_shadow',
				'std' => '',
				'type' => 'text_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-description',
				'affect_on_change_rule' => 'text-shadow',
				'section' => 'styling',
				'tab' => __( 'Description', 'live-composer-page-builder' ),
			),


			/**
			 * Buttons Tab
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_button_bg_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_bg_color_hover',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_button_border_color',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_border_color_hover',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_button_border_width',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_button_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array( 'label' => __( 'Top', 'live-composer-page-builder' ), 'value' => 'top' ),
					array( 'label' => __( 'Right', 'live-composer-page-builder' ), 'value' => 'right' ),
					array( 'label' => __( 'Bottom', 'live-composer-page-builder' ), 'value' => 'bottom' ),
					array( 'label' => __( 'Left', 'live-composer-page-builder' ), 'value' => 'left' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_button_border_radius',
				'onlypositive' => true,
				'std' => '3',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_button_color',
				'std' => '#fff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_color_hover',
				'std' => '#fff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_button_font_size',
				'onlypositive' => true,
				'std' => '16',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_button_font_weight',
				'std' => '500',
				'type' => 'select',
				'choices' => array(
					array( 'label' => '100 - Thin', 'value' => '100' ),
					array( 'label' => '200 - Extra Light', 'value' => '200' ),
					array( 'label' => '300 - Light', 'value' => '300' ),
					array( 'label' => '400 - Normal', 'value' => '400' ),
					array( 'label' => '500 - Medium', 'value' => '500' ),
					array( 'label' => '600 - Semi Bold', 'value' => '600' ),
					array( 'label' => '700 - Bold', 'value' => '700' ),
					array( 'label' => '800 - Extra Bold', 'value' => '800' ),
					array( 'label' => '900 - Black', 'value' => '900' ),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_button_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_button_line_height',
				'onlypositive' => true,
				'std' => '13',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			array(
				'label' => __( 'Margin ( paragraph )', 'live-composer-page-builder' ),
				'id' => 'css_btn_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_btn_margin_top_unit',
				'std' => 'px',
				'label' => __( 'Top Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_btn_margin_top',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-button-container',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_btn_margin_bottom_unit',
				'std' => 'px',
				'label' => __( 'Bottom Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_btn_margin_bottom',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-button-container',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_btn_margin_left_unit',
				'std' => 'px',
				'label' => __( 'Left Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_btn_margin_left',
				'onlypositive' => true,
				'std' => '25',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-button-container',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_btn_margin_right_unit',
				'std' => 'px',
				'label' => __( 'Right Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_btn_margin_right',
				'onlypositive' => true,
				'std' => '25',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-button-container',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_btn_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Padding', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_button_padding_top_unit',
				'std' => 'px',
				'label' => __( 'Top Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Top', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_top',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_button_padding_bottom_unit',
				'std' => 'px',
				'label' => __( 'Bottom Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Bottom', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_bottom',
				'onlypositive' => true,
				'min' => -2000,
				'max' => 2000,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_button_padding_left_unit',
				'std' => 'px',
				'label' => __( 'Left Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Left', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_left',
				'onlypositive' => true,
				'std' => '18',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_button_padding_right_unit',
				'std' => 'px',
				'label' => __( 'Right Unit', 'live-composer-page-builder' ),
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
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Right', 'live-composer-page-builder' ),
				'id' => 'css_button_padding_right',
				'onlypositive' => true,
				'std' => '18',
				'min' => -2000,
				'max' => 2000,
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'id' => 'css_button_padding_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Button Align', 'live-composer-page-builder' ),
				'id' => 'css_title_text_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-button-container',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Text Shadow', 'live-composer-page-builder' ),
				'id' => 'css_button_text_shadow',
				'std' => '',
				'type' => 'text_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'text-shadow',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Box Shadow', 'live-composer-page-builder' ),
				'id' => 'css_button_box_shadow',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Box Shadow - Hover', 'live-composer-page-builder' ),
				'id' => 'css_button_box_shadow_hover',
				'std' => '',
				'type' => 'box_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-cta-btn:hover',
				'affect_on_change_rule' => 'box-shadow',
				'section' => 'styling',
				'tab' => __( 'Buttons', 'live-composer-page-builder' ),
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		wp_cache_add( 'dslc_options_' . $this->module_id, $dslc_options, 'dslc_modules' );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );
	}


	function output( $options ) {
		global $dslc_active;

		$dslc_is_admin = ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) );

		$rel = ( isset( $options['link_nofollow'] ) && $options['link_nofollow'] == 'nofollow' ) ? 'rel="nofollow"' : '';


		?>

		<div class="dslc-cta-module">

			<!-- TITLE SECTION -->
			<div class="dslc-cta-title-container">
				<h2 class="dslc-cta-title">
					<?php if ( $dslc_active ) : ?>
						<span class="dslca-editable-content"
							data-type="simple"
							data-id="title"
							<?php if ( $dslc_is_admin ) echo 'data-exportable-content'; ?>
							contenteditable="true">
					<?php endif; ?>

					<?php echo apply_filters( 'dslc_text_block_render', stripslashes( $options['title'] ) ); ?>

					<?php if ( $dslc_active ) : ?>
						</span>
					<?php endif; ?>
				</h2>
			</div>

			<!-- DESCRIPTION SECTION -->
			<div class="dslc-cta-desc-container">
				<div class="dslc-cta-description">
					<?php if ( $dslc_active ) : ?>
						<div class="dslca-editable-content"
							data-type="simple"
							data-id="desc"
							<?php if ( $dslc_is_admin ) echo 'data-exportable-content'; ?>
							contenteditable="true">
					<?php endif; ?>

					<?php echo apply_filters( 'dslc_text_block_render', stripslashes( $options['desc'] ) ); ?>

					<?php if ( $dslc_active ) : ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- BUTTON SECTION -->
			<div class="dslc-cta-button-container">
				<a href="<?php echo $dslc_active ? 'javascript:void(0)' : esc_url($options['btn_link']); ?>" <?php echo $rel; ?> class="dslc-cta-btn">
					<?php if ( $dslc_active ) : ?>
						<span class="dslca-editable-content"
							data-type="simple"
							data-id="btn_text"
							<?php if ( $dslc_is_admin ) echo 'data-exportable-content'; ?>
							contenteditable="true">
							<?php echo apply_filters( 'dslc_text_block_render', stripslashes( $options['btn_text'] ) ); ?>
						</span>
					<?php endif; ?>

					<?php if ( ! $dslc_active ) : ?>
						<span><?php echo apply_filters( 'dslc_text_block_render', stripslashes( $options['btn_text'] ) ); ?></span>
					<?php endif; ?>
				</a>
			</div>

		</div>

		<?php
	}

}