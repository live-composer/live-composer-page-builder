<?php

if ( dslc_is_module_active( 'DSLC_Widgets' ) )
	include DS_LIVE_COMPOSER_ABS . '/modules/widgets/functions.php';

class DSLC_Widgets extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Widgets';
		$this->module_title = __( 'Widgets', 'dslc_string' );
		$this->module_icon = 'pencil';
		$this->module_category = 'elements';

	}

	function options() {	

		$sidebars = dslc_get_option( 'sidebars', 'dslc_plugin_options_widgets_m' );

		$sidebars_choices = array();
		$sidebars_choices[] = array(
			'label' => __( 'Choose sidebar', 'dslc_string' ),
			'value' => 'not_set',
		);

		if ( $sidebars !== '' ) {

			$sidebars_array = explode( ',', substr( $sidebars, 0, -1 ) );

			foreach ( $sidebars_array as $sidebar ) {
				
				$sidebar_ID = 'dslc_' . strtolower( str_replace( ' ', '_', $sidebar ) );

				$sidebars_choices[] = array(
					'label' => $sidebar,
					'value' => $sidebar_ID
				);

			}

		}

		$dslc_options = array(

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
				'label' => __( 'Widgets', 'dslc_string' ),
				'id' => 'sidebar',
				'std' => 'not_set',
				'type' => 'select',
				'choices' => $sidebars_choices,
				'help' => __( 'You can register sidebars for this module in <br>WP Admin > Live Composer > Widgets Module.', 'dslc_string' ),
			),
			array(
				'label' => __( 'Widgets Per Row', 'dslc_string' ),
				'id' => 'columns',
				'std' => '3',
				'type' => 'select',
				'choices' => $this->shared_options('posts_per_row_choices'),
			),
			
			/**
			 * Styling
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_widgets_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_widgets_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_widgets_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_widgets_border_trbl',
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
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_widgets_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_widgets_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
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
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_widgets_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_widgets_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/**
			 * Widget
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_widget_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'widget', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_widget_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'widget', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_widget_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'widget', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_widget_border_trbl',
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
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'widget', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_widget_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'widget', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_widget_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'widget', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_widget_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'widget', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_widget_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'widget', 'dslc_string' ),
			),
			array(
				'label' => __( 'Spacing', 'dslc_string' ),
				'id' => 'css_widget_margin_bottom',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'widget', 'dslc_string' ),
			),

			/**
			 * Title
			 */

			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_title_border_color',
				'std' => '#e5e5e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'border-bottom-color',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_title_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'border-bottom-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_title_color',
				'std' => '#222222',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'title_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_title_font_weight',
				'std' => '600',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_title_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
			),
			array(
				'label' => __( 'Letter Spacing', 'dslc_string' ),
				'id' => 'css_title_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_title_line_height',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_title_margin',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Bottom', 'dslc_string' ),
				'id' => 'css_title_padding',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_title_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
			),
			array(
				'label' => __( 'Text Transform', 'dslc_string' ),
				'id' => 'css_title_text_transform',
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
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'Title', 'dslc_string' ),
			),

			/**
			 * Title Inner
			 */

			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_title_inner_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title-inner',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'title inner', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_title_inner_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title-inner',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'title inner', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_title_inner_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title-inner',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'title inner', 'dslc_string' ),
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_title_inner_border_trbl',
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
				'affect_on_change_el' => '.dslc-widget-title-inner',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'title inner', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'dslc_string' ),
				'id' => 'css_title_inner_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title-inner',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'title inner', 'dslc_string' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'dslc_string' ),
				'id' => 'css_title_inner_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title-inner',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'title inner', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_title_inner_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title-inner',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'title inner', 'dslc_string' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_title_inner_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title-inner',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'title inner', 'dslc_string' ),
			),

			/**
			 * Content
			 */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_main_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_main_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_main_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_main_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_main_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Link - Color', 'dslc_string' ),
				'id' => 'css_link_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Link - Hover - Color', 'dslc_string' ),
				'id' => 'css_link_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
			),
			array(
				'label' => __( 'Link - Font Weight', 'dslc_string' ),
				'id' => 'css_link_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'content', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Text Align', 'dslc_string' ),
				'id' => 'css_main_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Content', 'dslc_string' ),
			),

			/**
			 * Content - Lists
			 */

			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_ul_margin_bottom',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget ul',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'content lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Left', 'dslc_string' ),
				'id' => 'css_ul_margin_left',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget ul',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'tab' => __( 'content lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_ul_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget ul',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'tab' => __( 'content lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_ul_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget ul',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'content lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Style', 'dslc_string' ),
				'id' => 'css_ul_style',
				'std' => 'disc',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Armenian', 'dslc_string' ),
						'value' => 'armenian'
					),
					array(
						'label' => __( 'Circle', 'dslc_string' ),
						'value' => 'circle'
					),
					array(
						'label' => __( 'cjk-ideographic', 'dslc_string' ),
						'value' => 'cjk-ideographic'
					),
					array(
						'label' => __( 'Decimal', 'dslc_string' ),
						'value' => 'decimal'
					),
					array(
						'label' => __( 'Decimal Leading Zero', 'dslc_string' ),
						'value' => 'decimal-leading-zero'
					),
					array(
						'label' => __( 'Hebrew', 'dslc_string' ),
						'value' => 'hebrew'
					),
					array(
						'label' => __( 'Hiragana', 'dslc_string' ),
						'value' => 'hiragana'
					),
					array(
						'label' => __( 'Hiragana Iroha', 'dslc_string' ),
						'value' => 'hiragana-iroha'
					),
					array(
						'label' => __( 'Katakana', 'dslc_string' ),
						'value' => 'katakana'
					),
					array(
						'label' => __( 'Katakana Iroha', 'dslc_string' ),
						'value' => 'katakana-iroha'
					),
					array(
						'label' => __( 'Lower Alpha', 'dslc_string' ),
						'value' => 'lower-alpha'
					),
					array(
						'label' => __( 'Lower Greek', 'dslc_string' ),
						'value' => 'lower-greek'
					),
					array(
						'label' => __( 'Lower Latin', 'dslc_string' ),
						'value' => 'lower-latin'
					),
					array(
						'label' => __( 'Lower Roman', 'dslc_string' ),
						'value' => 'lower-roman'
					),
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Upper Alpha', 'dslc_string' ),
						'value' => 'upper-alpha'
					),
					array(
						'label' => __( 'Upper Latin', 'dslc_string' ),
						'value' => 'upper-latin'
					),
					array(
						'label' => __( 'Upper Roman', 'dslc_string' ),
						'value' => 'upper-roman'
					),
					array(
						'label' => __( 'Inherit', 'dslc_string' ),
						'value' => 'inherit'
					),
				),
				'section' => 'styling',
				'tab' => __( 'content lists', 'dslc_string' ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget ul',
				'affect_on_change_rule' => 'list-style-type',
			),
			array(
				'label' => __( 'Item - BG Color', 'dslc_string' ),
				'id' => 'css_ul_li_bg_color',
				'std' => 'rgba( 255, 255, 255, 0 )',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget li',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'content lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Border Color', 'dslc_string' ),
				'id' => 'css_ul_li_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget li',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'content lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Border Width', 'dslc_string' ),
				'id' => 'css_ul_li_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget li',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'content lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Borders', 'dslc_string' ),
				'id' => 'css_ul_li_borders',
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
				'affect_on_change_el' => '.dslc-widget li',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'content lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Border Radius', 'dslc_string' ),
				'id' => 'css_ul_li_bradius',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget li',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'content lists', 'dslc_string' ),
			),
			array(
				'label' => __( 'Item - Margin Bottom', 'dslc_string' ),
				'id' => 'css_ul_li_margin_bottom',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget ul li',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => __( 'content lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Item - Padding Vertical', 'dslc_string' ),
				'id' => 'css_ul_li_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget ul li',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'tab' => __( 'content lists', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Item - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_ul_li_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget ul li',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'content lists', 'dslc_string' ),
			),
			
			

			/**
			 * Responsive Tablet
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
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_widgets_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_widgets_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Widget - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_t_widget_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Widget - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_t_widget_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_title_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_title_line_height',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_title_margin',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Padding Bottom', 'dslc_string' ),
				'id' => 'css_res_t_title_padding',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Font Size', 'dslc_string' ),
				'id' => 'css_res_t_main_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Line Height', 'dslc_string' ),
				'id' => 'css_res_t_main_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),


			/**
			 * Responsive Phone
			 */

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
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_widgets_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_widgets_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widgets-wrap',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Widget - Padding Vertical', 'dslc_string' ),
				'id' => 'css_res_p_widget_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Widget - Padding Horizontal', 'dslc_string' ),
				'id' => 'css_res_p_widget_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-wrap',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Font Size', 'dslc_string' ),
				'id' => 'css_res_p_title_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'dslc_string' ),
				'id' => 'css_res_p_title_line_height',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_title_margin',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Padding Bottom', 'dslc_string' ),
				'id' => 'css_res_p_title_padding',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget-title',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Font Size', 'dslc_string' ),
				'id' => 'css_res_p_main_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Content - Line Height', 'dslc_string' ),
				'id' => 'css_res_p_main_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-widget',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;

		$this->module_start( $options );

		/* Module output starts here */
			
			?>
			<div class="dslc-widgets dslc-clearfix dslc-widgets-<?php echo $options['columns']; ?>-col">
				<div class="dslc-widgets-wrap dslc-clearfix">
					<?php

					if ( isset( $options['sidebar'] ) && $options['sidebar'] !== 'not_set' ) {

						if ( ! dynamic_sidebar( $options['sidebar'] ) ) :

							if ( $dslc_is_admin ) :
								?><div class="dslc-notification dslc-red"><?php _e( 'The sidebar you have chosen is empty. Click the refresh icon on the right when you add a widget.', 'dslc_string' ); ?> <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
							endif;

						endif;

					} else {

						if ( $dslc_is_admin ) :
							?><div class="dslc-notification dslc-red"><?php _e( 'Click the cog icon on the right of this box to choose which sidebar to show.', 'dslc_string' ); ?> <span class="dslca-module-edit-hook dslc-icon dslc-icon-cog"></span></span></div><?php
						endif;

					}

				?>
				</div>
			</div>
			<?php

		/* Module output ends here */

		$this->module_end( $options );

	}

}