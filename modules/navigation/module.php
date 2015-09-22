<?php

if ( dslc_is_module_active( 'DSLC_Navigation' ) )
	include DS_LIVE_COMPOSER_ABS . '/modules/navigation/functions.php';

class DSLC_Navigation extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Navigation';
		$this->module_title = __( 'Navigation', 'dslc_string' );
		$this->module_icon = 'link';
		$this->module_category = 'elements';

	}

	function options() {	

		$locs = get_registered_nav_menus();

		$loc_choices = array();
		$loc_choices[] = array(
			'label' => __( 'Choose Navigation', 'dslc_string' ),
			'value' => 'not_set',
		);
			
		if ( ! empty( $locs ) ) {
			foreach ( $locs as $loc_ID => $loc_label ) {
				$loc_choices[] = array(
					'label' => $loc_label,
					'value' => $loc_ID,
				);
			}
		}

		$dslc_options = array(
			
			/**
			 * Functionality
			 */

			array(
				'label' => __( 'Show On', 'dslc_string' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'dslc_string' ),
						'value' => 'desktop'
					),
					array(
						'label' => __( 'Tablet', 'dslc_string' ),
						'value' => 'tablet'
					),
					array(
						'label' => __( 'Phone', 'dslc_string' ),
						'value' => 'phone'
					),
				),
			),
			array(
				'label' => __( 'Navigation', 'dslc_string' ),
				'id' => 'location',
				'std' => 'not_set',
				'type' => 'select',
				'choices' => $loc_choices,
				'help' => __( 'The locations from the theme will be shown here but you can register your own in <br>WP Admin > Live Composer > Navigation.', 'dslc_string' ),
			),

			/**
			 * Styling
			 */

			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_main_align',
				'std' => 'right',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			),
			array(
				'label' => __( ' BG Color', 'dslc_string' ),
				'id' => 'css_main_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image', 'dslc_string' ),
				'id' => 'css_main_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image Repeat', 'dslc_string' ),
				'id' => 'css_main_bg_img_repeat',
				'std' => 'repeat',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Repeat', 'dslc_string' ),
						'value' => 'repeat',
					),
					array(
						'label' => __( 'Repeat Horizontal', 'dslc_string' ),
						'value' => 'repeat-x',
					),
					array(
						'label' => __( 'Repeat Vertical', 'dslc_string' ),
						'value' => 'repeat-y',
					),
					array(
						'label' => __( 'Do NOT Repeat', 'dslc_string' ),
						'value' => 'no-repeat',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image Attachment', 'dslc_string' ),
				'id' => 'css_main_bg_img_attch',
				'std' => 'scroll',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Scroll', 'dslc_string' ),
						'value' => 'scroll',
					),
					array(
						'label' => __( 'Fixed', 'dslc_string' ),
						'value' => 'fixed',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image Position', 'dslc_string' ),
				'id' => 'css_main_bg_img_pos',
				'std' => 'top left',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'dslc_string' ),
						'value' => 'left top',
					),
					array(
						'label' => __( 'Top Right', 'dslc_string' ),
						'value' => 'right top',
					),
					array(
						'label' => __( 'Top Center', 'dslc_string' ),
						'value' => 'Center Top',
					),
					array(
						'label' => __( 'Center Left', 'dslc_string' ),
						'value' => 'left center',
					),
					array(
						'label' => __( 'Center Right', 'dslc_string' ),
						'value' => 'right center',
					),
					array(
						'label' => __( 'Center', 'dslc_string' ),
						'value' => 'center center',
					),
					array(
						'label' => __( 'Bottom Left', 'dslc_string' ),
						'value' => 'left bottom',
					),
					array(
						'label' => __( 'Bottom Right', 'dslc_string' ),
						'value' => 'right bottom',
					),
					array(
						'label' => __( 'Bottom Center', 'dslc_string' ),
						'value' => 'center bottom',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_main_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_main_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_main_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_main_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_main_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'dslc_string' ),
				'id' => 'css_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			),
			array(
				'label' => __( 'Orientation', 'dslc_string' ),
				'id' => 'nav_orientation',
				'std' => 'horizontal',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Horizontal', 'dslc_string' ),
						'value' => 'horizontal',
					),
					array(
						'label' => __( 'Vertical', 'dslc_string' ),
						'value' => 'vertical',
					),
				),
				'section' => 'styling',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_main_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_main_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/**
			 * Styling - Item 
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_item_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'dslc_string' ),
				'id' => 'css_item_bg_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color - Active', 'dslc_string' ),
				'id' => 'css_item_bg_color_active',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li.current-menu-item > a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_item_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'dslc_string' ),
				'id' => 'css_item_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color - Active', 'dslc_string' ),
				'id' => 'css_item_border_color_active',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li.current-menu-item > a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_item_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_item_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_item_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_item_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_item_color',
				'std' => '#555555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color - Hover', 'dslc_string' ),
				'id' => 'css_item_color_hover',
				'std' => '#fd4970',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color - Active', 'dslc_string' ),
				'id' => 'css_item_color_active',
				'std' => '#fd4970',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li.current-menu-item > a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_item_font_size',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_item_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_item_font_family',
				'std' => 'Montserrat',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Letter Spacing', 'dslc_string' ),
				'id' => 'css_item_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_item_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_item_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_item_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Transform', 'dslc_string' ),
				'id' => 'css_item_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Capitalize', 'dslc_string' ),
						'value' => 'capitalize'
					),
					array(
						'label' => __( 'Uppercase', 'dslc_string' ),
						'value' => 'uppercase'
					),
					array(
						'label' => __( 'Lowercase', 'dslc_string' ),
						'value' => 'lowercase'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Spacing', 'dslc_string' ),
				'id' => 'css_item_spacing',
				'std' => '40',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li',
				'affect_on_change_rule' => 'margin-left,margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'dslc_string' ),
			),

			array(
				'label' => __( 'Chevron - Enable/Disable', 'dslc_string' ),
				'id' => 'css_item_chevron_display',
				'std' => 'none',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-arrow',
				'affect_on_change_rule' => 'display',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'inline-block',
					),
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'none',
					),
				)
			),
			array(
				'label' => __( 'Chevron - Color', 'dslc_string' ),
				'id' => 'css_item_chevron_color',
				'std' => '#555555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-arrow',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Chevron - Size', 'dslc_string' ),
				'id' => 'css_item_chevron_size',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-arrow',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Chevron - Spacing', 'dslc_string' ),
				'id' => 'css_item_chevron_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-arrow',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'tab' => __( 'item', 'dslc_string' ),
				'ext' => 'px'
			),

			/**
			 * Subnav
			 */

			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_subnav_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( ' BG Color', 'dslc_string' ),
				'id' => 'css_subnav_bg_color',
				'std' => '#fff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Image', 'dslc_string' ),
				'id' => 'css_subnav_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Image Repeat', 'dslc_string' ),
				'id' => 'css_subnav_bg_img_repeat',
				'std' => 'repeat',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Repeat', 'dslc_string' ),
						'value' => 'repeat',
					),
					array(
						'label' => __( 'Repeat Horizontal', 'dslc_string' ),
						'value' => 'repeat-x',
					),
					array(
						'label' => __( 'Repeat Vertical', 'dslc_string' ),
						'value' => 'repeat-y',
					),
					array(
						'label' => __( 'Do NOT Repeat', 'dslc_string' ),
						'value' => 'no-repeat',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Image Attachment', 'dslc_string' ),
				'id' => 'css_subnav_bg_img_attch',
				'std' => 'scroll',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Scroll', 'dslc_string' ),
						'value' => 'scroll',
					),
					array(
						'label' => __( 'Fixed', 'dslc_string' ),
						'value' => 'fixed',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Image Position', 'dslc_string' ),
				'id' => 'css_subnav_bg_img_pos',
				'std' => 'top left',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'dslc_string' ),
						'value' => 'left top',
					),
					array(
						'label' => __( 'Top Right', 'dslc_string' ),
						'value' => 'right top',
					),
					array(
						'label' => __( 'Top Center', 'dslc_string' ),
						'value' => 'Center Top',
					),
					array(
						'label' => __( 'Center Left', 'dslc_string' ),
						'value' => 'left center',
					),
					array(
						'label' => __( 'Center Right', 'dslc_string' ),
						'value' => 'right center',
					),
					array(
						'label' => __( 'Center', 'dslc_string' ),
						'value' => 'center center',
					),
					array(
						'label' => __( 'Bottom Left', 'dslc_string' ),
						'value' => 'left bottom',
					),
					array(
						'label' => __( 'Bottom Right', 'dslc_string' ),
						'value' => 'right bottom',
					),
					array(
						'label' => __( 'Bottom Center', 'dslc_string' ),
						'value' => 'center bottom',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_subnav_border_color',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_subnav_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_subnav_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_subnav_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_subnav_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'dslc_string' ),
			),			
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_subnav_padding_vertical',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_subnav_padding_horizontal',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'dslc_string' ),
			),

			/**
			 * Styling - Item 
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_subnav_item_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'dslc_string' ),
				'id' => 'css_subnav_item_bg_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'BG Color - Active', 'dslc_string' ),
				'id' => 'css_subnav_item_bg_color_active',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li.current-menu-item > a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_subnav_item_border_color',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'dslc_string' ),
				'id' => 'css_subnav_item_border_color_hover',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li > a:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color - Active', 'dslc_string' ),
				'id' => 'css_subnav_item_border_color_active',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li.current-menu-item > a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_subnav_item_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_subnav_item_border_trbl',
				'std' => 'bottom',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_subnav_item_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_subnav_item_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_subnav_item_color',
				'std' => '#555555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color - Hover', 'dslc_string' ),
				'id' => 'css_subnav_item_color_hover',
				'std' => '#fd4970',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color - Active', 'dslc_string' ),
				'id' => 'css_subnav_item_color_active',
				'std' => '#fd4970',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li.current-menu-item > a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_subnav_item_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_subnav_item_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_subnav_item_font_family',
				'std' => 'Montserrat',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Letter Spacing', 'dslc_string' ),
				'id' => 'css_subnav_item_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_subnav_item_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_subnav_item_padding_vertical',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_subnav_item_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Transform', 'dslc_string' ),
				'id' => 'css_subnav_item_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Capitalize', 'dslc_string' ),
						'value' => 'capitalize'
					),
					array(
						'label' => __( 'Uppercase', 'dslc_string' ),
						'value' => 'uppercase'
					),
					array(
						'label' => __( 'Lowercase', 'dslc_string' ),
						'value' => 'lowercase'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'dslc_string' ),
			),

			/**
			 * Responsive
			 */

			array(
				'label' => __( 'Responsive Styling', 'dslc_string' ),
				'id' => 'css_res_t',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_res_t_align',
				'std' => 'right',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_res_t_color',
				'std' => '#555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation-hook',
				'affect_on_change_rule' => 'color',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Top', 'dslc_string' ),
				'id' => 'css_res_t_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size', 'dslc_string' ),
				'id' => 'css_res_t_size',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation-hook',
				'affect_on_change_rule' => 'font-size, line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),

			array(
				'label' => __( 'Responsive Styling', 'dslc_string' ),
				'id' => 'css_res_p',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_res_p_align',
				'std' => 'right',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_res_p_color',
				'std' => '#555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation-hook',
				'affect_on_change_rule' => 'color',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Top', 'dslc_string' ),
				'id' => 'css_res_p_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size', 'dslc_string' ),
				'id' => 'css_res_p_size',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation-hook',
				'affect_on_change_rule' => 'font-size, line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		$this->module_start( $options );

		/* Module output starts here */

			global $dslc_active;

			if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
				$dslc_is_admin = true;
			else
				$dslc_is_admin = false;

			?>

			<?php
				if ( $options['location'] == 'not_set' ) {
					if ( $dslc_is_admin ) {
						?><div class="dslc-notification dslc-red"><?php _e( 'Edit the module and choose which location to show.', 'dslc_string' ); ?> <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
					}
				} elseif ( ! has_nav_menu( $options['location'] ) ) {
					if ( $dslc_is_admin ) {
						?><div class="dslc-notification dslc-red"><?php _e( 'The chosen location does not have a menu assigned.', 'dslc_string' ); ?> <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
					}
				} else {
					?>
					<div class="dslc-navigation dslc-navigation-res-t-<?php echo $options['css_res_t']; ?> dslc-navigation-res-p-<?php echo $options['css_res_p']; ?> dslc-navigation-orientation-<?php echo $options['nav_orientation']; ?>">
						<div class="dslc-navigation-inner">
							<?php wp_nav_menu( array( 'theme_location' => $options['location'] ) ); ?>
						</div>
					</div>
					<div class="dslc-mobile-navigation dslc-navigation-res-t-<?php echo $options['css_res_t']; ?>  dslc-navigation-res-p-<?php echo $options['css_res_p']; ?>">
						<?php
							if( has_nav_menu( $options['location'] ) ) {

								$mobile_nav_output = '';
								$mobile_nav_output .= '<select>';
								$mobile_nav_output .= '<option>' . __( '- Select -', 'dslc_string' ) . '</option>';
								
								if ( has_nav_menu( $options['location'] ) ) {

									$locations = get_nav_menu_locations();
									$menu = wp_get_nav_menu_object( $locations[$options['location']] );
									$menu_items = wp_get_nav_menu_items($menu->term_id);
										
									foreach ( $menu_items as $key => $menu_item ) {
										$title = $menu_item->title;
										$url = $menu_item->url;
										$nav_selected = '';
										if($menu_item->post_parent !== 0){
											$mobile_nav_output .= '<option value="'.$url.'" '.$nav_selected.'> - '.$title.'</option>';
										}else{
											$mobile_nav_output .= '<option value="'.$url.'" '.$nav_selected.'>'.$title.'</option>';
										}
									}

								}

								$mobile_nav_output .= '</select>';
								echo $mobile_nav_output;
							}
						?>
						<div class="dslc-mobile-navigation-hook"><span class="dslc-icon dslc-icon-reorder"></span></div>
					</div><!-- .dslc-mobile-navigation -->
					<?php
				}

		/* Module output ends here */

		$this->module_end( $options );

	}

}