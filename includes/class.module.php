<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_Module {

	function shared_options( $options_id, $atts = false ) {
		// Average running time 0.00150696436564 (1.3%)
		$animation_options_choices = array(
			array(
				'label' => 'None',
				'value' => 'none',
			),
			array(
				'label' => 'Fade In',
				'value' => 'dslcFadeIn',
			),
			array(
				'label' => 'Slide Up',
				'value' => 'dslcSlideUp',
			),
			array(
				'label' => 'Slide Down',
				'value' => 'dslcSlideDown',
			),
			array(
				'label' => 'Slide Right',
				'value' => 'dslcSlideRight',
			),
			array(
				'label' => 'Slide Left',
				'value' => 'dslcSlideLeft',
			),
			array(
				'label' => 'Slide Up + Fade In',
				'value' => 'dslcSlideUpFadeIn',
			),
			array(
				'label' => 'Slide Down + Fade In',
				'value' => 'dslcSlideDownFadeIn',
			),
			array(
				'label' => 'Slide Right + Fade In',
				'value' => 'dslcSlideRightFadeIn',
			),
			array(
				'label' => 'Slide Left + Fade In',
				'value' => 'dslcSlideLeftFadeIn',
			),
		);

		$animation_options_choices = apply_filters( 'dslc_animation_options', $animation_options_choices );

		$animation_options_general = array(

			array(
				'label' => 'On Load Animation',
				'id' => 'css_anim',
				'std' => 'none',
				'type' => 'select',
				'section' => 'styling',
				'tab' => 'Animation',
				'choices' => $animation_options_choices,
			),
			array(
				'label' => 'On Load Animation - Delay ( ms )',
				'id' => 'css_anim_delay',
				'std' => '0',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Animation',
			),
			array(
				'label' => 'On Load Anim - Duration ( ms )',
				'id' => 'css_anim_duration',
				'std' => '650',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Animation',
			),
			array(
				'label' => 'On Load Animation - Easing',
				'id' => 'css_anim_easing',
				'std' => 'ease',
				'type' => 'select',
				'section' => 'styling',
				'tab' => 'Animation',
				'choices' => array(
					array(
						'label' => 'Default',
						'value' => 'ease',
					),
					array(
						'label' => 'Linear',
						'value' => 'linear',
					),
					array(
						'label' => 'Ease In',
						'value' => 'ease-in',
					),
					array(
						'label' => 'Ease Out',
						'value' => 'ease-out',
					),
					array(
						'label' => 'Ease In Out',
						'value' => 'ease-in-out',
					),
				),
			),

		);

		$animation_options_posts = array(

			array(
				'label' => 'On Hover Animation',
				'id' => 'css_anim_hover',
				'std' => 'none',
				'type' => 'select',
				'section' => 'styling',
				'tab' => 'Animation',
				'choices' => array(
					array(
						'label' => 'None',
						'value' => 'none',
					),
					array(
						'label' => 'Fade In',
						'value' => 'dslcFadeIn',
					),
					array(
						'label' => 'Slide Up',
						'value' => 'dslcSlideUp',
					),
					array(
						'label' => 'Slide Down',
						'value' => 'dslcSlideDown',
					),
					array(
						'label' => 'Slide Right',
						'value' => 'dslcSlideRight',
					),
					array(
						'label' => 'Slide Left',
						'value' => 'dslcSlideLeft',
					),
					array(
						'label' => 'Slide Up + Fade In',
						'value' => 'dslcSlideUpFadeIn',
					),
					array(
						'label' => 'Slide Down + Fade In',
						'value' => 'dslcSlideDownFadeIn',
					),
					array(
						'label' => 'Slide Right + Fade In',
						'value' => 'dslcSlideRightFadeIn',
					),
					array(
						'label' => 'Slide Left + Fade In',
						'value' => 'dslcSlideLeftFadeIn',
					),
				),
			),
			array(
				'label' => 'On Hover Animation - Speed ( ms )',
				'id' => 'css_anim_speed',
				'std' => '650',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Animation',
			),

		);

		if ( isset( $atts['hover_opts'] ) && ! $atts['hover_opts'] ) {
			$animation_options = $animation_options_general;
		} else {
			$animation_options = array_merge( $animation_options_general, $animation_options_posts );
		}

		$col_choices = array(
			array(
				'label' => '1/12',
				'value' => '1',
			),
			array(
				'label' => '2/12',
				'value' => '2',
			),
			array(
				'label' => '3/12',
				'value' => '3',
			),
			array(
				'label' => '4/12',
				'value' => '4',
			),
			array(
				'label' => '5/12',
				'value' => '5',
			),
			array(
				'label' => '6/12',
				'value' => '6',
			),
			array(
				'label' => '7/12',
				'value' => '7',
			),
			array(
				'label' => '8/12',
				'value' => '8',
			),
			array(
				'label' => '9/12',
				'value' => '9',
			),
			array(
				'label' => '10/12',
				'value' => '10',
			),
			array(
				'label' => '11/12',
				'value' => '11',
			),
			array(
				'label' => '12/12',
				'value' => '12',
			),
		);

		$posts_per_row_choices = array(
			array(
				'label' => '1',
				'value' => '12',
			),
			array(
				'label' => '2',
				'value' => '6',
			),
			array(
				'label' => '3',
				'value' => '4',
			),
			array(
				'label' => '4',
				'value' => '3',
			),
			array(
				'label' => '6',
				'value' => '2',
			),
		);

		/**
		 * Filter Options
		 */

		$filters_options = array(

			array(
				'label' => 'BG Color',
				'id' => 'css_filter_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter.dslc-inactive',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Filters',
			),
			array(
				'label' => 'BG Color - Active',
				'id' => 'css_filter_bg_color_active',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter.dslc-active',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Border Color',
				'id' => 'css_filter_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter.dslc-inactive',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Border Color - Active',
				'id' => 'css_filter_border_color_active',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter.dslc-active',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Border Width',
				'id' => 'css_filter_border_width',

				'max' => 10,
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Borders',
				'id' => 'css_filter_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => 'Top',
						'value' => 'top',
					),
					array(
						'label' => 'Right',
						'value' => 'right',
					),
					array(
						'label' => 'Bottom',
						'value' => 'bottom',
					),
					array(
						'label' => 'Left',
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Border Radius',
				'id' => 'css_filter_border_radius',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'border-radius',

				'section' => 'styling',
				'tab' => 'Filters',
				'ext' => 'px',
			),
			array(
				'label' => 'Color',
				'id' => 'css_filter_color',
				'std' => '#979797',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter.dslc-inactive',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Color - Active',
				'id' => 'css_filter_color_active',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter.dslc-active',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Font Size',
				'id' => 'css_filter_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => 'Filters',
				'ext' => 'px',
			),
			array(
				'label' => 'Font Weight',
				'id' => 'css_filter_font_weight',
				'std' => '700',
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
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => 'Filters',
				'ext' => '',
			),
			array(
				'label' => 'Font Family',
				'id' => 'css_filter_font_family',
				'std' => '',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Padding Vertical',
				'id' => 'css_filter_padding_vertical',
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Padding Horizontal',
				'id' => 'css_filter_padding_horizontal',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Position',
				'id' => 'css_filter_position',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filters',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Spacing',
				'id' => 'css_filter_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Filters',
			),
			array(
				'label' => 'Margin Bottom',
				'id' => 'css_filter_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filters',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => 'Filters',
				'ext' => 'px',
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => 'Filters - Position',
				'id' => 'css_res_t_filter_position',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filters',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => 'Tablet',
			),
			array(
				'label' => 'Filters - Font Size',
				'id' => 'css_res_t_filter_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),
			array(
				'label' => 'Filters - Padding Vertical',
				'id' => 'css_res_t_filter_padding_vertical',
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Tablet',
			),
			array(
				'label' => 'Filters - Padding Horizontal',
				'id' => 'css_res_t_filter_padding_horizontal',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Tablet',
			),
			array(
				'label' => 'Filters - Spacing',
				'id' => 'css_res_t_filter_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Tablet',
			),
			array(
				'label' => 'Filters Item - Margin Bottom',
				'id' => 'css_res_t_filter_item_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Tablet',
			),
			array(
				'label' => 'Filters - Margin Bottom',
				'id' => 'css_res_t_filter_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filters',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => 'Filters - Position',
				'id' => 'css_res_p_filter_position',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filters',
				'affect_on_change_rule' => 'text-align',
				'section' => 'responsive',
				'tab' => 'Phone',
			),
			array(
				'label' => 'Filters - Font Size',
				'id' => 'css_res_p_filter_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),
			array(
				'label' => 'Filters - Padding Vertical',
				'id' => 'css_res_p_filter_padding_vertical',
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Phone',
			),
			array(
				'label' => 'Filters - Padding Horizontal',
				'id' => 'css_res_p_filter_padding_horizontal',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Phone',
			),
			array(
				'label' => 'Filters - Spacing',
				'id' => 'css_res_p_filter_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Phone',
			),
			array(
				'label' => 'Filters Item - Margin Bottom',
				'id' => 'css_res_p_filter_item_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Phone',
			),
			array(
				'label' => 'Filters - Margin Bottom',
				'id' => 'css_res_p_filter_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filters',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),

		);

		/**
		 * Heading
		 */

		$heading_options = array(

			array(
				'label' => 'Main Heading Title',
				'id' => 'main_heading_title',
				'std' => 'CLICK TO EDIT',
				'type' => 'text',
				'visibility' => 'hidden',
			),
			array(
				'label' => 'View All Title',
				'id' => 'main_heading_link_title',
				'std' => 'VIEW ALL',
				'type' => 'text',
				'visibility' => 'hidden',
			),

			array(
				'label' => 'Post Filter – All',
				'id' => 'main_filter_title_all',
				'std' => 'All',
				'type' => 'text',
				'visibility' => 'hidden',
			),

			array(
				'label' => 'Title - Color',
				'id' => 'css_main_heading_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Heading',
			),
			array(
				'label' => 'Title - Font Size',
				'id' => 'css_main_heading_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => 'px',
			),
			array(
				'label' => 'Title - Font Weight',
				'id' => 'css_main_heading_font_weight',
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
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => '',
			),
			array(
				'label' => 'Title - Font Family',
				'id' => 'css_main_heading_font_family',
				'std' => '',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => 'Heading',
			),
			array(
				'label' => __( 'Title - Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_main_heading_letter_spacing',

				'max' => 30,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => 'px',
				'min' => -50,
				'max' => 50,
			),
			array(
				'label' => 'Title - Line Height',
				'id' => 'css_main_heading_line_height',
				'std' => '37',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => 'px',
			),

			array(
				'label' => 'Link - Color',
				'id' => 'css_main_heading_link_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Heading',
			),
			array(
				'label' => 'Link - Color - Hover',
				'id' => 'css_main_heading_link_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Heading',
			),
			array(
				'label' => 'Link - Font Size',
				'id' => 'css_main_heading_link_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => 'px',
			),
			array(
				'label' => 'Link - Font Weight',
				'id' => 'css_main_heading_link_font_weight',
				'std' => '600',
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
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => '',
			),
			array(
				'label' => 'Link - Font Family',
				'id' => 'css_main_heading_link_font_family',
				'std' => '',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => 'Heading',
			),
			array(
				'label' => __( 'Link - Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_main_heading_link_letter_spacing',

				'max' => 30,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => 'px',
				'min' => -50,
				'max' => 50,
			),
			array(
				'label' => 'Link - Padding Vertical',
				'id' => 'css_main_heading_link_padding_ver',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => 'px',
			),
			array(
				'label' => 'Link - URL',
				'id' => 'view_all_link',
				'std' => '#',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Heading',
				'ignored_by_preset' => true,
			),
			array(
				'label' => 'Separator - Color',
				'id' => 'css_main_heading_sep_color',
				'std' => '#4f4f4f',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'border-left-color',
				'section' => 'styling',
				'tab' => 'Heading',
			),
			array(
				'label' => 'Separator - Style',
				'id' => 'css_main_heading_sep_style',
				'std' => 'dotted',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'border-left-style',
				'section' => 'styling',
				'tab' => 'Heading',
				'choices' => array(
					array(
						'label' => 'Solid',
						'value' => 'solid',
					),
					array(
						'label' => 'Dashed',
						'value' => 'dashed',
					),
					array(
						'label' => 'Dotted',
						'value' => 'dotted',
					),
				),
			),

			array(
				'label' => 'Margin Bottom',
				'id' => 'css_heading_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => 'px',
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => 'Heading - Font Size',
				'id' => 'css_res_t_main_heading_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),
			array(
				'label' => 'Heading - Line Height',
				'id' => 'css_res_t_main_heading_line_height',
				'std' => '37',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),
			array(
				'label' => 'Heading Link - Font Size',
				'id' => 'css_res_t_main_heading_link_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),
			array(
				'label' => 'Heading Link - Padding Vertical',
				'id' => 'css_res_t_main_heading_link_padding_ver',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),
			array(
				'label' => 'Heading - Margin Bottom',
				'id' => 'css_res_t_heading_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => 'Heading - Font Size',
				'id' => 'css_res_p_main_heading_font_size',
				'std' => '17',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),
			array(
				'label' => 'Heading - Line Height',
				'id' => 'css_res_p_main_heading_line_height',
				'std' => '37',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),
			array(
				'label' => 'Heading Link - Font Size',
				'id' => 'css_res_p_main_heading_link_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),
			array(
				'label' => 'Heading Link - Padding Vertical',
				'id' => 'css_res_p_main_heading_link_padding_ver',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),
			array(
				'label' => 'Heading - Margin Bottom',
				'id' => 'css_res_p_heading_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),

		);

		/**
		 * Carousel Arrows
		 */

		$carousel_arrows_options = array(

			array(
				'label' => 'Slide Speed',
				'id' => 'arrows_slide_speed',
				'std' => '200',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'Position',
				'id' => 'arrows_position',
				'std' => 'above',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Above', 'live-composer-page-builder' ),
						'value' => 'above',
					),
					array(
						'label' => __( 'Aside', 'live-composer-page-builder' ),
						'value' => 'aside',
					),
				),
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'BG Color',
				'id' => 'css_arrows_bg_color',
				'std' => '#c9c9c9',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev,.dslc-carousel-nav-next',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'BG Color - Hover',
				'id' => 'css_arrows_bg_color_hover',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev:hover,.dslc-carousel-nav-next:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'Border Color',
				'id' => 'css_arrows_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev,.dslc-carousel-nav-next',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'Border Color - Hover',
				'id' => 'css_arrows_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev:hover,.dslc-carousel-nav-next:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'Border Width',
				'id' => 'css_arrows_border_width',
				'max' => 10,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev,.dslc-carousel-nav-next',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'Border Radius',
				'id' => 'css_arrows_border_radius',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev,.dslc-carousel-nav-next',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
				'ext' => 'px',
			),
			array(
				'label' => 'Color',
				'id' => 'css_arrows_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev span,.dslc-carousel-nav-next span',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'Color - Hover',
				'id' => 'css_arrows_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev:hover span,.dslc-carousel-nav-next:hover span',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'Size',
				'id' => 'css_arrows_size',
				'std' => '24',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev,.dslc-carousel-nav-next',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'Size - Arrows',
				'id' => 'css_arrows_arrow_size',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev span,.dslc-carousel-nav-next span',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => __( 'Margin ( Wrapper ) - Above', 'live-composer-page-builder' ),
				'id' => 'css_arrows_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
				array(
					'label' => 'Top',
					'id' => 'css_arrows_margin_top',
					'std' => '6',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-carousel-nav',
					'affect_on_change_rule' => 'margin-top',
					'section' => 'styling',
					'tab' => 'Carousel Arrows',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_arrows_margin_right',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-carousel-nav',
					'affect_on_change_rule' => 'margin-right',
					'section' => 'styling',
					'tab' => 'Carousel Arrows',
					'ext' => 'px',
				),
				array(
					'label' => 'Bottom',
					'id' => 'css_arrows_margin_bottom',
					'std' => '20',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-carousel-nav',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'styling',
					'tab' => 'Carousel Arrows',
					'ext' => 'px',
				),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_arrows_margint_left',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-carousel-nav',
					'affect_on_change_rule' => 'margin-left',
					'section' => 'styling',
					'tab' => 'Carousel Arrows',
					'ext' => 'px',
				),
			array(
				'id' => 'css_arrows_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
			),
			array(
				'label' => 'Margin Top ( Aside )',
				'id' => 'css_arrows_aside_margin_top',
				'std' => '-30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev.position-aside, .dslc-carousel-nav-next.position-aside',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Carousel Arrows', 'live-composer-page-builder' ),
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => 'Arrows - Margin Top ( Aside )',
				'id' => 'css_res_t_arrows_aside_margin_top',
				'std' => '-20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev.position-aside, .dslc-carousel-nav-next.position-aside',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => 'Arrows - Margin Top ( Aside )',
				'id' => 'css_res_p_arrows_aside_margin_top',
				'std' => '-20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev.position-aside, .dslc-carousel-nav-next.position-aside',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),
		);

		/**
		 * Carousel Circles
		 */

		$carousel_circles_options = array(

			array(
				'label' => 'Slide Speed',
				'id' => 'circles_slide_speed',
				'std' => '800',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Carousel Circles',
			),
			array(
				'label' => 'Color',
				'id' => 'css_circles_color',
				'std' => '#b9b9b9',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Carousel Circles',
			),
			array(
				'label' => 'Color - Active',
				'id' => 'css_circles_color_active',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page.active span',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Carousel Circles',
			),
			array(
				'label' => 'Margin Top',
				'id' => 'css_circles_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-controls',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'tab' => 'Carousel Circles',
				'ext' => 'px',
			),
			array(
				'label' => 'Size',
				'id' => 'css_circles_size',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'tab' => 'Carousel Circles',
				'ext' => 'px',
			),
			array(
				'label' => 'Spacing',
				'id' => 'css_circles_spacing',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'styling',
				'tab' => 'Carousel Circles',
				'ext' => 'px',
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => 'Carousel Circles - Margin Top',
				'id' => 'css_res_t_circles_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-controls',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),
			array(
				'label' => 'Carousel Circles - Size',
				'id' => 'css_res_t_circles_size',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),
			array(
				'label' => 'Carousel Circles - Spacing',
				'id' => 'css_res_t_circles_spacing',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => 'Tablet',
				'ext' => 'px',
			),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => 'Carousel Circles - Margin Top',
				'id' => 'css_res_p_circles_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-controls',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),
			array(
				'label' => 'Carousel Circles - Size',
				'id' => 'css_res_p_circles_size',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),
			array(
				'label' => 'Carousel Circles - Spacing',
				'id' => 'css_res_p_circles_spacing',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => 'Phone',
				'ext' => 'px',
			),

		);

		/**
		 * Carousel Options
		 */

		$carousel_options = array(

			array(
				'label' => 'Autoplay ( ms )',
				'help' => 'The amount of miliseconds between each automatic slide.',
				'id' => 'carousel_autoplay',
				'std' => '0',
				'type' => 'text',
				'tab' => 'carousel',
			),
			array(
				'label' => 'Autoplay - Stop on Hover',
				'id' => 'carousel_autoplay_hover',
				'std' => 'false',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Enabled',
						'value' => 'true',
					),
					array(
						'label' => 'Disabled',
						'value' => 'false',
					),
				),
				'tab' => 'carousel',
			),

		);

		/**
		 * Pagination
		 */

		$pagination_options = array(

			array(
				'label' => 'Align',
				'id' => 'css_pag_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Container - BG Color',
				'id' => 'css_pag_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Container - Border Color',
				'id' => 'css_pag_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Container - Border Width',
				'id' => 'css_pag_border_width',

				'max' => 10,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Container - Borders',
				'id' => 'css_pag_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => 'Top',
						'value' => 'top',
					),
					array(
						'label' => 'Right',
						'value' => 'right',
					),
					array(
						'label' => 'Bottom',
						'value' => 'bottom',
					),
					array(
						'label' => 'Left',
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Container - Border Radius',
				'id' => 'css_pag_border_radius',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'border-radius',

				'section' => 'styling',
				'tab' => 'Pagination',
				'ext' => 'px',
			),
			array(
				'label' => 'Container - Padding Vertical',
				'id' => 'css_pag_padding_vertical',
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Container - Padding Horizontal',
				'id' => 'css_pag_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Active - BG Color',
				'id' => 'css_pag_item_bg_color_active',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-active a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Active: Hover - BG Color',
				'id' => 'css_pag_item_bg_color_active_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-active a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Inactive - BG Color',
				'id' => 'css_pag_item_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-inactive a',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Inactive: Hover - BG Color',
				'id' => 'css_pag_item_bg_color_inactive_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-inactive a:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Border Color',
				'id' => 'css_pag_item_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-inactive a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Hover - Border Color',
				'id' => 'css_pag_item_border_color_hover',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-active a:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Active - Border Color',
				'id' => 'css_pag_item_border_color_active',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-active a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Border Width',
				'id' => 'css_pag_item_border_width',

				'max' => 10,
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-inactive a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Active - Border Width',
				'id' => 'css_pag_item_border_width_active',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-active a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Borders',
				'id' => 'css_pag_item_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => 'Top',
						'value' => 'top',
					),
					array(
						'label' => 'Right',
						'value' => 'right',
					),
					array(
						'label' => 'Bottom',
						'value' => 'bottom',
					),
					array(
						'label' => 'Left',
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Border Radius',
				'id' => 'css_pag_item_border_radius',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'border-radius',

				'section' => 'styling',
				'tab' => 'Pagination',
				'ext' => 'px',
			),
			array(
				'label' => 'Item - Active - Color',
				'id' => 'css_pag_item_color_active',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-active a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Active: Hover - Color',
				'id' => 'css_pag_item_color_hover',
				'std' => '#979797',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-active a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Inactive - Color',
				'id' => 'css_pag_item_color',
				'std' => '#979797',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-inactive a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Inactive: Hover - Color',
				'id' => 'css_pag_item_color_inactive_hover',
				'std' => '#979797',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-inactive a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Font Size',
				'id' => 'css_pag_item_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => 'Pagination',
				'ext' => 'px',
			),
			array(
				'label' => 'Item - Font Weight',
				'id' => 'css_pag_item_font_weight',
				'std' => '700',
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
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => 'Pagination',
				'ext' => '',
			),
			array(
				'label' => 'Item - Font Family',
				'id' => 'css_pag_item_font_family',
				'std' => '',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => __( 'Item - Letter Spacing', 'live-composer-page-builder' ),
				'id' => 'css_pag_item_letter_spacing',

				'max' => 30,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => 'Pagination',
				'ext' => 'px',
				'min' => -50,
				'max' => 50,
			),
			array(
				'label' => 'Item - Padding Vertical',
				'id' => 'css_pag_item_padding_vertical',
				'max' => 600,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Padding Horizontal',
				'id' => 'css_pag_item_padding_horizontal',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination',
			),
			array(
				'label' => 'Item - Spacing',
				'id' => 'css_pag_item_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination',
			),
			array(
				'label' => __( 'Button - Width', 'live-composer-page-builder' ),
				'id' => 'css_pag_button_width',
				'std' => 'inline-block',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Automatic', 'live-composer-page-builder' ),
						'value' => 'inline-block',
					),
					array(
						'label' => __( 'Full Width', 'live-composer-page-builder' ),
						'value' => 'block',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-pagination-load-more',
				'affect_on_change_rule' => 'display',
				'section' => 'styling',
				'tab' => 'Pagination',
			),
			array(
				'label' => __( 'Margin', 'live-composer-page-builder' ),
				'id' => 'css_pag_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'styling',
				'tab' => __( 'Pagination', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'id' => 'css_pag_margin_top',
					'std' => '30',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-top',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Pagination', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_pag_margin_right',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-right',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Pagination', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
					'id' => 'css_pag_margin_bottom',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Pagination', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_pag_margin_left',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-left',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __( 'Pagination', 'live-composer-page-builder' ),
				),
			array(
				'id' => 'css_pag_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'styling',
				'tab' => __( 'Pagination', 'live-composer-page-builder' ),
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => __( 'Pagination - Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_t_pag_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'id' => 'css_res_t_pag_margin_top',
					'std' => '30',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-top',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_res_t_pag_margin_right',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-right',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
					'id' => 'css_res_t_pag_margin_bottom',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_res_t_pag_margin_left',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-left',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				),
			array(
				'id' => 'css_res_t_pag_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => __( 'Pagination - Margin', 'live-composer-page-builder' ),
				'id' => 'css_res_p_pag_margin_group',
				'type' => 'group',
				'action' => 'open',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'id' => 'css_res_p_pag_margin_top',
					'std' => '30',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-top',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __( 'Phone', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'id' => 'css_res_p_pag_margin_right',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-right',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __( 'Phone', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
					'id' => 'css_res_p_pag_margin_bottom',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __( 'Phone', 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'id' => 'css_res_p_pag_margin_left',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.dslc-pagination',
					'affect_on_change_rule' => 'margin-left',
					'section' => 'responsive',
					'ext' => 'px',
					'tab' => __( 'Phone', 'live-composer-page-builder' ),
				),
			array(
				'id' => 'css_res_p_pag_margin_group',
				'type' => 'group',
				'action' => 'close',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),

		);

		/**
		 * Responsive
		 */
		$res_posts_options = array(

			/**
			 * Smaller Monitor
			 */

			array(
				'label' => 'Posts Per Row',
				'id' => 'res_sm_columns',
				'std' => 'auto',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Automatic',
						'value' => 'auto',
					),
					array(
						'label' => '1',
						'value' => '12',
					),
					array(
						'label' => '2',
						'value' => '6',
					),
					array(
						'label' => '3',
						'value' => '4',
					),
					array(
						'label' => '4',
						'value' => '3',
					),
					array(
						'label' => '6',
						'value' => '2',
					),
				),
				'tab' => 'smaller monitor',
				'section' => 'responsive',
			),
			array(
				'label' => 'Thumbnail',
				'id' => 'res_sm_thumb',
				'std' => 'block',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Enabled',
						'value' => 'block',
					),
					array(
						'label' => 'Disabled',
						'value' => 'none',
					),
				),
				'tab' => 'smaller monitor',
				'section' => 'responsive',
				'refresh_on_change' => false,
				'affect_on_change_rule' => 'display',
				'affect_on_change_el' => '.dslc-blog-post-thumb',
			),

			/**
			 * Tablet
			 */

			array(
				'label' => 'Posts Per Row',
				'id' => 'res_tp_columns',
				'std' => 'auto',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Automatic',
						'value' => 'auto',
					),
					array(
						'label' => '1',
						'value' => '12',
					),
					array(
						'label' => '2',
						'value' => '6',
					),
					array(
						'label' => '3',
						'value' => '4',
					),
					array(
						'label' => '4',
						'value' => '3',
					),
					array(
						'label' => '6',
						'value' => '2',
					),
				),
				'tab' => 'tablet portrait',
				'section' => 'responsive',
			),

			/**
			 * Phone
			 */

			array(
				'label' => 'Posts Per Row',
				'id' => 'res_p_columns',
				'std' => 'auto',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Automatic',
						'value' => 'auto',
					),
					array(
						'label' => '1',
						'value' => '12',
					),
					array(
						'label' => '2',
						'value' => '6',
					),
					array(
						'label' => '3',
						'value' => '4',
					),
					array(
						'label' => '4',
						'value' => '3',
					),
					array(
						'label' => '6',
						'value' => '2',
					),
				),
				'tab' => 'Phone',
				'section' => 'responsive',
			),

		);
		return $$options_id;
	}

	/**
	 * Returns common options for all modules
	 *
	 * @return array
	 */
	public static function common_options() {

		$options = array(
			array(
				'label' => 'Custom class',
				'id' => 'custom_class',
				'std' => '',
				'type' => 'text',
				'section' => 'functionality',
				'tab' => 'general',
			),
		);

		return $options;
	}

	/**
	 * Declare module options
	 */
	function options() {
		die( 'Function "options" must be over-ridden in a sub-class (the module class).' );
	}

	/**
	 * The front-end output of the module.
	 */
	function output( $options ) {
		die( 'Function "output" must be over-ridden in a sub-class (the module class).' );
	}

	function module_start( $user_options ) {
		// Function disabled. See new function module_before.
	}

	function module_before( $options ) {
		// Average running time 0.0339393615723 (28%)
		global $dslc_active;
		global $dslc_should_filter;
		$dslc_should_filter = false;

		if ( ! isset( $options['css_anim'] ) ) {
					$options['css_anim'] = 'none';
		}

		if ( ! isset( $options['css_anim_delay'] ) ) {
					$options['css_anim_delay'] = '0';
		}

		if ( ! isset( $options['css_anim_duration'] ) ) {
					$options['css_anim_duration'] = '650';
		}

		if ( ! isset( $options['css_anim_easing'] ) ) {
					$options['css_anim_easing'] = 'default';
		}

		$options['module_id'] = $this->module_id;

		/**
		 * Size Classes
		 */

		$class_size_output = '';
		$data_attr_size = '12';

		if ( isset( $options['dslc_m_size'] ) ) {
			$class_size_output .= ' dslc-col dslc-' . $options['dslc_m_size'] . '-col';
			$data_attr_size = $options['dslc_m_size'];
		}

		if ( isset( $options['dslc_m_size_last'] ) && 'yes' === $options['dslc_m_size_last'] ) {
			$class_size_output .= ' dslc-last-col';
		}

		/**
		 * Show on ( desktop, tablet, phone )
		 */

		$class_show_on = '';

		if ( isset( $options['css_show_on'] ) ) {

			$show_on = explode( ' ', trim( $options['css_show_on'] ) );

			if ( ! in_array( 'desktop', $show_on, true ) ) {
							$class_show_on .= 'dslc-hide-on-desktop ';
			}

			if ( ! in_array( 'tablet', $show_on, true ) ) {
							$class_show_on .= 'dslc-hide-on-tablet ';
			}

			if ( ! in_array( 'phone', $show_on, true ) ) {
							$class_show_on .= 'dslc-hide-on-phone ';
			}
		}

		/**
		 * Handle like
		 */

		if ( isset( $this->handle_like ) ) {
					$class_handle_like = 'dslc-module-handle-like-' . $this->handle_like;
		} else {
					$class_handle_like = 'dslc-module-handle-like-regular';
		}

		/**
		 * Globals
		 */

		global $dslc_css_style;
		global $dslc_googlefonts_array;

		global $dslc_available_fonts;
		$dslc_all_googlefonts_array = $dslc_available_fonts['google'];

		/**
		 * Title Attr
		 */

		$title_attr = '';

		if ( $dslc_active ) {

			$title_attr = 'title="' . strtoupper( esc_attr( $this->module_title ) ) . '"';
		}

		/**
		 * Option Preset
		 */

		if ( ! isset( $options['css_load_preset'] ) ) {
			$options['css_load_preset'] = '';
		}

		// Module class array.
		$module_class_arr = array();
		$module_class_arr[] = 'dslc-module-front';
		$module_class_arr[] = 'dslc-module-' . $this->module_id;
		$module_class_arr[] = 'dslc-in-viewport-check';
		$module_class_arr[] = 'dslc-in-viewport-anim-' . $options['css_anim'];
		$module_class_arr[] = $class_size_output;
		$module_class_arr[] = $class_show_on;
		$module_class_arr[] = $class_handle_like;

		// Process all class definitions.
		if ( isset( $options['custom_class'] ) ) {
			$custom_class = preg_replace( '/,/', ' ', $options['custom_class'] );
			$custom_class = preg_replace( '/\b\.\b/', ' ', $custom_class );
			$custom_class = preg_replace( '/\./', '', $custom_class );
			$custom_class = preg_replace( '/\s{2,}/', ' ', $custom_class );
			$custom_class = trim( $custom_class );
		} else {
			$custom_class = '';
		}

		$module_class_arr[] = $custom_class;

		// Module class array apply filters.
		$module_class_arr = apply_filters( 'dslc_module_class', $module_class_arr, $this->module_id, $options );

		// Turn module class array into string.
		$module_class = implode( ' ', $module_class_arr );

		if ( ! $dslc_active ) {

			// Before Module.
			$before_module_content = '';
			echo apply_filters( 'dslc_before_module', $before_module_content, $options );
		}

		?>

		<div id="dslc-module-<?php echo esc_attr( $options['module_instance_id'] ); ?>" class="<?php echo esc_attr( $module_class ); ?>" data-module-id="<?php echo esc_attr( $options['module_instance_id'] ); ?>" data-dslc-module-id="<?php echo esc_attr( $this->module_id ); ?>" data-dslc-module-size="<?php echo esc_attr( $data_attr_size ); ?>" data-dslc-anim="<?php echo esc_attr( $options['css_anim'] ); ?>" data-dslc-anim-delay="<?php echo esc_attr( $options['css_anim_delay'] ); ?>" data-dslc-anim-duration="<?php echo esc_attr( $options['css_anim_duration'] ); ?>"  data-dslc-anim-easing="<?php echo esc_attr( $options['css_anim_easing'] ); ?>" data-dslc-preset="<?php echo esc_attr( $options['css_load_preset'] ); ?>" <?php echo $title_attr; ?>>

			<?php do_action( 'dslc_module_before' ); ?>

			<?php
				// If Live Composer in editing mode: output <style> block for the current module.
			if ( DS_LIVE_COMPOSER_ACTIVE && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) :

				echo '<style type="text/css" id="css-for-dslc-module-' . esc_attr( $options['module_instance_id'] ) . '">';

				$options_arr = $this->options();

				if ( ! isset( $options['css_custom'] ) || 'enabled' === $options['css_custom'] ) {

					// Generate CSS for the module based on the selected options.
					// Funciton 'dslc_generate_custom_css' will fill global $dslc_css_style with CSS code.
					$module_css = dslc_generate_custom_css( $options_arr, $options, true );
					$googlefonts_output = '';
					foreach ( $dslc_googlefonts_array as $googlefont ) {
						if ( in_array( $googlefont, $dslc_all_googlefonts_array, true ) ) {
							$googlefont = str_replace( ' ', '+', $googlefont );
							if ( '' !== $googlefont ) {
								$googlefonts_output .= '@import url("//fonts.googleapis.com/css?family=' . $googlefont . ':100,200,300,400,500,600,700,800,900&subset=latin,latin-ext"); ';
							}
						}
					}
					echo $googlefonts_output;
					echo $module_css;
					// echo $dslc_css_style; // <– old method using globals.
				}

				echo '</style>';

				?>

				<div class="dslca-module-manage">
				<span class="dslca-module-manage-line"></span>
				<div class="dslca-module-manage-inner">
				<span class="dslca-manage-action dslca-module-manage-hook dslca-module-edit-hook" title="<?php esc_attr_e( 'Edit options', 'live-composer-page-builder' ); ?>"><span class="dslca-icon dslc-icon-cog"></span></span>
				<span class="dslca-manage-action dslca-module-manage-hook dslca-copy-module-hook" title="<?php esc_attr_e( 'Duplicate', 'live-composer-page-builder' ); ?>"><span class="dslca-icon dslc-icon-copy"></span></span>
				<span class="dslca-manage-action dslca-module-manage-hook dslca-move-module-hook" title="<?php esc_attr_e( 'Drag to move', 'live-composer-page-builder' ); ?>"><span class="dslca-icon dslc-icon-move"></span></span>
				<span class="dslca-manage-action dslca-module-manage-hook dslca-change-width-module-hook" title="<?php esc_attr_e( 'Change width', 'live-composer-page-builder' ); ?>">
					<span class="dslca-icon dslc-icon-columns"></span>
					<div class="dslca-change-width-module-options">
						<span><?php esc_attr_e( 'Element Width', 'live-composer-page-builder' ); ?></span>
						<span data-size="1">1/12</span><span data-size="2">2/12</span>
						<span data-size="3">3/12</span><span data-size="4">4/12</span>
						<span data-size="5">5/12</span><span data-size="6">6/12</span>
						<span data-size="7">7/12</span><span data-size="8">8/12</span>
						<span data-size="9">9/12</span><span data-size="10">10/12</span>
						<span data-size="11">11/12</span><span data-size="12">12/12</span>
					</div>
				</span>
				<span class="dslca-manage-action dslca-module-manage-hook dslca-delete-module-hook" title="<?php esc_attr_e( 'Delete', 'live-composer-page-builder' ); ?>"><span class="dslca-icon dslc-icon-remove"></span></span>
				</div>
				<?php if ( DS_LIVE_COMPOSER_DEV_MODE ) : ?>
						<div class="dslca-manage-action dslca-module-manage-inner dslca-dev-mode">
							<span class="dslca-module-manage-hook dslca-module-get-defaults-hook"><span class="dslca-icon dslc-icon-upload-alt"></span></span>
						</div>
					<?php endif; ?>
				</div>

			<?php endif; ?>

		<?php

	}

	function module_end( $user_options ) {
		// Function disabled. See new function module_after.
	}

	function module_after( $user_options ) {
		// Average running time 0.0530054050943 (48%)
		global $dslc_active;

		$options = array();
		$options_ids = array();

		// Clear the custom options by getting rid of all the default values.
		// Get the module structure.
		// Array of options with default values only.
		$options = $this->options();

		// Bring back IDs for image options.
		global $dslc_var_image_option_bckp;

		foreach ( $dslc_var_image_option_bckp as $key => $value ) {
			$user_options[ $key ] = $value;
		}

		// Other vars.
		$user_options['module_id'] = $this->module_id;
		if ( ! isset( $user_options['dslc_m_size'] ) ) {
			$user_options['dslc_m_size'] = '12';
		}

		if ( ! isset( $user_options['element_type'] ) ) {
			$user_options['element_type'] = 'module';
		}

		$user_options_no_defaults = $user_options;
		$user_options_no_defaults = dslc_encode_shortcodes_in_array( $user_options_no_defaults );

		// If Live Composer is in editing mode: output some additional (hidden) elements.
		if ( DS_LIVE_COMPOSER_ACTIVE && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) : ?>

			<div class="dslca-module-options-front">

				<?php
				// Output each options as a hidden textarea.
				// Go through standard set of options described in the module class.
				// Array $options do not contains custom data, but structure and defaults.
				// Array $user_options contains custom module settings.
				foreach ( $options as $key => $option ) {

					$id = $option['id'];
					$uid = false;
					if ( isset( $id ) && isset( $user_options[ $id ] ) ) {
						$uid = $user_options[ $id ];
					}

					// Sanitize User Option Values.
					if ( $uid ) {
						$option_satinitize_data = array(
							'value' => $uid,
							'id' => $id,
							// 'definition' => $option,
						);

						$uid = dslc_sanitize_option_val( $option_satinitize_data );
					}

					// 🔖 RAW CODE CLEANUP
					// Only clean options in the styling or custon sections.
					// Never clean 'Functionality' section (it has no section parameter set).
					/*
					if (
						isset( $uid ) &&
						isset( $option['section'] ) && 'FUNCTIONALITY' !== strtoupper( $option['section'] ) ) {

						// Do we have option with this id in the custom settings set by the user?
						// if ( isset( $user_options[ $id ] )  ) {

							// If current option is empty or the same as default value for this setting.
							// if ( '' === $user_options[ $id ] || isset( $option['std'] ) && $option['std'] === $user_options[ $id ] ) {
							if ( '' === $uid || false === $uid ) {
								unset( $user_options[ $id ] );
							}
						// }
					}
					*/

					// Option ID.
					$options_ids[] = $option['id'];

					// Set the setting value.
					if ( $uid ) {
						$option_value = $uid;
					} else {
						$option_value = '';
						// $option_value = $option['std'];
					}

					// 🔖 RAW CODE CLEANUP
					// if ( $user_options[ $id ] === $option['std'] || '' === $user_options[ $id ] ) {
					if ( false === $uid || '' === $uid ) {
						unset( $user_options_no_defaults[ $id ] );
					}

					// Sanitize Option Values.
					if ( $option_value ) {

						$option_satinitize_data = array(
							'value' => $option_value,
							'id' => $id,
							'definition' => $option,
						);

						$option_value = dslc_sanitize_option_val( $option_satinitize_data );
					}

					$option_value = dslc_encode_shortcodes( $option_value );

					echo '<textarea class="dslca-module-option-front" data-id="' . esc_attr( $id ) . '">' . stripslashes( $option_value ) . '</textarea>';
				}// End foreach().

				// Output additional (custom) options that are not part of the default module structure.
				foreach ( $user_options as $user_option_id => $user_option_val ) {

					if ( ! in_array( $user_option_id, $options_ids, true ) ) {
						$user_option_val = dslc_encode_shortcodes( $user_option_val );
						echo '<textarea class="dslca-module-option-front" data-id="' . esc_attr( $user_option_id ) . '">' . stripslashes( $user_option_val ) . '</textarea>';
					}
				}

				?>

			</div><!-- dslca-module-options-front -->

			<textarea class="dslca-module-code"><?php echo json_encode( $user_options_no_defaults ); ?></textarea>

			<span class="dslc-sortable-helper-icon dslc-icon-<?php echo esc_attr( $this->module_icon ); ?>" data-title="<?php echo esc_attr( $this->module_title ); ?>" data-icon="<?php echo esc_attr( $this->module_icon ); ?>"></span>

		<?php endif;?>

		<?php do_action( 'dslc_module_after' ); ?>
		</div><!-- .dslc-module -->
		<?php

		if ( ! $dslc_active ) {
			// After Module.
			$after_module_content = '';
			echo apply_filters( 'dslc_after_module', $after_module_content, $user_options );
		}

		global $dslc_should_filter;
		$dslc_should_filter = true;
	}

	/**
	 * Add presets data for the current module
	 *
	 * @return array Array with two more options to add into the module options
	 */
	function presets_options() {
		// Average time per module 0.00111207209135 (1%).
		$choices = array(
			array(
				'label' => 'None',
				'value' => 'none',
			),
		);

		// Get current presets.
		$presets = get_option( 'dslc_presets' );
		if ( false !== $presets ) {
			$presets = maybe_unserialize( $presets );
			foreach ( $presets as $preset ) {
				if ( $preset['module'] === $this->module_id ) {
					$choices[] = array(
						'label' => $preset['title'],
						'value' => $preset['id'],
					);
				}
			}
		}

		$options = array(
			array(
				'label' => __( 'Preset', 'live-composer-page-builder' ),
				'id' => 'css_load_preset',
				'std' => 'none',
				'type' => 'select',
				'section' => 'styling',
				'tab' => 'Presets',
				'choices' => $choices,
			),
			array(
				'label' => __( 'Register New Preset', 'live-composer-page-builder' ),
				'id' => 'css_save_preset',
				'std' => '',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Presets',
				'refresh_on_change' => false,
				'help' => __( 'Type in the name of the preset and hit enter, it will automatically be added to the presets on the left.', 'live-composer-page-builder' ),
			),
		);

		return $options;
	}
}
