<?php
/**
 * Navigation module class
 */

if ( dslc_is_module_active( 'DSLC_Navigation' ) ) {

	include DS_LIVE_COMPOSER_ABS . '/modules/navigation/functions.php';
}

/**
 * Class DSLC_Navigation
 */
class DSLC_Navigation extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	/**
	 * @inherited
	 */
	function __construct( $settings = [], $atts = [] ) {

		$this->module_ver = 2;
		$this->module_id = __CLASS__;
		$this->module_title = __( 'Navigation', 'live-composer-page-builder' );
		$this->module_icon = 'link';
		$this->module_category = 'elements';

		parent::__construct( $settings, $atts );
	}

	/**
	 * @inherited
	 */
	function options() {

		$locs = get_registered_nav_menus();

		$loc_choices = array();
		$loc_choices[] = array(
			'label' => __( 'Choose Navigation', 'live-composer-page-builder' ),
			'value' => 'not_set',
		);

		if ( ! empty( $locs ) ) {

			foreach ( $locs as $loc_id => $loc_label ) {

				$loc_choices[] = array(
					'label' => $loc_label,
					'value' => $loc_id,
				);
			}
		}

		$dslc_options = array(

			/**
			 * Functionality
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
				'label' => __( 'Navigation', 'live-composer-page-builder' ),
				'id' => 'location',
				'std' => 'not_set',
				'type' => 'select',
				'choices' => $loc_choices,
				'help' => __( 'The locations from the theme will be shown here but you can register your own in <br>WP Admin > Live Composer > Navigation.', 'live-composer-page-builder' ),
			),

			/**
			 * Styling
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_main_align',
				'std' => 'right',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image Repeat', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img_repeat',
				'std' => 'repeat',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Repeat', 'live-composer-page-builder' ),
						'value' => 'repeat',
					),
					array(
						'label' => __( 'Repeat Horizontal', 'live-composer-page-builder' ),
						'value' => 'repeat-x',
					),
					array(
						'label' => __( 'Repeat Vertical', 'live-composer-page-builder' ),
						'value' => 'repeat-y',
					),
					array(
						'label' => __( 'Do NOT Repeat', 'live-composer-page-builder' ),
						'value' => 'no-repeat',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image Attachment', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img_attch',
				'std' => 'scroll',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Scroll', 'live-composer-page-builder' ),
						'value' => 'scroll',
					),
					array(
						'label' => __( 'Fixed', 'live-composer-page-builder' ),
						'value' => 'fixed',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Image Position', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img_pos',
				'std' => 'top left',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'live-composer-page-builder' ),
						'value' => 'left top',
					),
					array(
						'label' => __( 'Top Right', 'live-composer-page-builder' ),
						'value' => 'right top',
					),
					array(
						'label' => __( 'Top Center', 'live-composer-page-builder' ),
						'value' => 'Center Top',
					),
					array(
						'label' => __( 'Center Left', 'live-composer-page-builder' ),
						'value' => 'left center',
					),
					array(
						'label' => __( 'Center Right', 'live-composer-page-builder' ),
						'value' => 'right center',
					),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center center',
					),
					array(
						'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
						'value' => 'left bottom',
					),
					array(
						'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
						'value' => 'right bottom',
					),
					array(
						'label' => __( 'Bottom Center', 'live-composer-page-builder' ),
						'value' => 'center bottom',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_main_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
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
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_main_border_trbl',
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
				'affect_on_change_el' => '.dslc-navigation-inner',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
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
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
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
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
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
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
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
				'increment' => 5,
			),
			array(
				'label' => __( 'Orientation', 'live-composer-page-builder' ),
				'id' => 'nav_orientation',
				'std' => 'horizontal',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Horizontal', 'live-composer-page-builder' ),
						'value' => 'horizontal',
					),
					array(
						'label' => __( 'Vertical', 'live-composer-page-builder' ),
						'value' => 'vertical',
					),
				),
				'section' => 'styling',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
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
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
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
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_item_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_item_bg_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color - Active', 'live-composer-page-builder' ),
				'id' => 'css_item_bg_color_active',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li.current-menu-item > a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_item_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_item_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color - Active', 'live-composer-page-builder' ),
				'id' => 'css_item_border_color_active',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li.current-menu-item > a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_item_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'live-composer-page-builder' ),
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
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_item_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_item_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_item_color',
				'std' => '#555555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_item_color_hover',
				'std' => '#fd4970',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Active', 'live-composer-page-builder' ),
				'id' => 'css_item_color_active',
				'std' => '#fd4970',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li.current-menu-item > a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_item_font_size',
				'std' => '14',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_item_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100,
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_item_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_item_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50,
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_item_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_item_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_item_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_item_text_transform',
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
				'affect_on_change_el' => '.dslc-navigation .menu > li > a',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Spacing', 'live-composer-page-builder' ),
				'id' => 'css_item_spacing',
				'std' => '40',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu > li',
				'affect_on_change_rule' => 'margin-left,margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Chevron - Enable/Disable', 'live-composer-page-builder' ),
				'id' => 'css_item_chevron_display',
				'std' => 'none',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-arrow',
				'affect_on_change_rule' => 'display',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'inline-block',
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'none',
					),
				),
			),
			array(
				'label' => __( 'Chevron - Color', 'live-composer-page-builder' ),
				'id' => 'css_item_chevron_color',
				'std' => '#555555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-arrow',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Chevron - Size', 'live-composer-page-builder' ),
				'id' => 'css_item_chevron_size',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-arrow',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Chevron - Spacing', 'live-composer-page-builder' ),
				'id' => 'css_item_chevron_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation-arrow',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'tab' => __( 'item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/**
			 * Subnav
			 */

			array(
				'label' => __( 'Position', 'live-composer-page-builder' ),
				'id' => 'css_subnav_position',
				'std' => 'default',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Default', 'live-composer-page-builder' ),
						'value' => 'default',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
				),
				'section' => 'styling',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_subnav_bg_color',
				'std' => '#fff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Image', 'live-composer-page-builder' ),
				'id' => 'css_subnav_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Image Repeat', 'live-composer-page-builder' ),
				'id' => 'css_subnav_bg_img_repeat',
				'std' => 'repeat',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Repeat', 'live-composer-page-builder' ),
						'value' => 'repeat',
					),
					array(
						'label' => __( 'Repeat Horizontal', 'live-composer-page-builder' ),
						'value' => 'repeat-x',
					),
					array(
						'label' => __( 'Repeat Vertical', 'live-composer-page-builder' ),
						'value' => 'repeat-y',
					),
					array(
						'label' => __( 'Do NOT Repeat', 'live-composer-page-builder' ),
						'value' => 'no-repeat',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Image Attachment', 'live-composer-page-builder' ),
				'id' => 'css_subnav_bg_img_attch',
				'std' => 'scroll',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Scroll', 'live-composer-page-builder' ),
						'value' => 'scroll',
					),
					array(
						'label' => __( 'Fixed', 'live-composer-page-builder' ),
						'value' => 'fixed',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Image Position', 'live-composer-page-builder' ),
				'id' => 'css_subnav_bg_img_pos',
				'std' => 'top left',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'live-composer-page-builder' ),
						'value' => 'left top',
					),
					array(
						'label' => __( 'Top Right', 'live-composer-page-builder' ),
						'value' => 'right top',
					),
					array(
						'label' => __( 'Top Center', 'live-composer-page-builder' ),
						'value' => 'Center Top',
					),
					array(
						'label' => __( 'Center Left', 'live-composer-page-builder' ),
						'value' => 'left center',
					),
					array(
						'label' => __( 'Center Right', 'live-composer-page-builder' ),
						'value' => 'right center',
					),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center center',
					),
					array(
						'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
						'value' => 'left bottom',
					),
					array(
						'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
						'value' => 'right bottom',
					),
					array(
						'label' => __( 'Bottom Center', 'live-composer-page-builder' ),
						'value' => 'center bottom',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_subnav_border_color',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_subnav_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_subnav_border_trbl',
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
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_subnav_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_subnav_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_subnav_padding_vertical',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_subnav_padding_horizontal',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav', 'live-composer-page-builder' ),
			),

			/**
			 * Styling - Item
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_bg_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'BG Color - Active', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_bg_color_active',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li.current-menu-item > a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_border_color',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_border_color_hover',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li > a:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color - Active', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_border_color_active',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li.current-menu-item > a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_border_trbl',
				'std' => 'bottom',
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
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_color',
				'std' => '#555555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_color_hover',
				'std' => '#fd4970',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Active', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_color_active',
				'std' => '#fd4970',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li.current-menu-item > a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100,
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50,
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_line_height',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_padding_vertical',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Transform', 'live-composer-page-builder' ),
				'id' => 'css_subnav_item_text_transform',
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
				'affect_on_change_el' => '.dslc-navigation .menu ul li a',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'subnav item', 'live-composer-page-builder' ),
			),

			/**
			 * Responsive
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
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_res_t_align',
				'std' => 'right',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_res_t_color',
				'std' => '#555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation-hook',
				'affect_on_change_rule' => 'color',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_size',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation-hook',
				'affect_on_change_rule' => 'font-size, line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

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
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_res_p_align',
				'std' => 'right',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_res_p_color',
				'std' => '#555',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation-hook',
				'affect_on_change_rule' => 'color',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_size',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-mobile-navigation-hook',
				'affect_on_change_rule' => 'font-size, line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	/**
	 * @inherited
	 */
	function afterRegister() {

		add_action( 'wp_enqueue_scripts', function(){

			$path = explode( '/', __DIR__ );
			$path = array_pop( $path );

			wp_enqueue_script( 'js-navigation-extender', DS_LIVE_COMPOSER_URL . '/modules/' . $path . '/script.js', array( 'jquery' ) );
		});
	}

	/**
	 * Navigation
	 */
	function get_navigation() {

		$options = $this->getPropsValues();

		ob_start();

		wp_nav_menu( array( 'theme_location' => $options['location'] ) );

		return ob_get_clean();
	}

	/**
	 * Mobile Navigation
	 */
	function get_mobile_navigation() {

		$options = $this->getPropsValues();

		if ( has_nav_menu( $options['location'] ) ) {

			$mobile_nav_output = '';
			$mobile_nav_output .= '<select>';
			$mobile_nav_output .= '<option>' . __( '- Select -', 'live-composer-page-builder' ) . '</option>';

			if ( has_nav_menu( $options['location'] ) ) {

				$locations = get_nav_menu_locations();
				$menu = wp_get_nav_menu_object( $locations[ $options['location'] ] );
				$menu_items = wp_get_nav_menu_items( $menu->term_id );

				foreach ( $menu_items as $key => $menu_item ) {

					$title = $menu_item->title;
					$url = $menu_item->url;
					$nav_selected = '';

					if ( 0 !== $menu_item->post_parent ) {

						$mobile_nav_output .= '<option value="' . $url . '" ' . $nav_selected . '> - ' . $title . '</option>';
					} else {

						$mobile_nav_output .= '<option value="' . $url . '" ' . $nav_selected . '>' . $title . '</option>';
					}
				}
			}

			$mobile_nav_output .= '</select>';
		}

		ob_start();

		echo $mobile_nav_output;?>
		<div class="dslc-mobile-navigation-hook"><span class="dslc-icon dslc-icon-reorder"></span></div>
		<?php return ob_get_clean();
	}

	/**
	 * @inherited
	 */
	function output( $options = [] ) {

		$this->module_start();

		/* Module output stars here */
		echo $this->renderModule();
		/* Module output ends here */

		$this->module_end();
	}
}

/* Register module */
( new DSLC_Navigation )->register();
