<?php

class DSLC_Module {

	function shared_options( $options_id, $atts = false ) {

		$animation_options_choices = array(
			array(
				'label' => 'None',
				'value' => 'none'
			),
			array(
				'label' => 'Fade In',
				'value' => 'dslcFadeIn'
			),
			array(
				'label' => 'Slide Up',
				'value' => 'dslcSlideUp'
			),
			array(
				'label' => 'Slide Down',
				'value' => 'dslcSlideDown'
			),
			array(
				'label' => 'Slide Right',
				'value' => 'dslcSlideRight'
			),
			array(
				'label' => 'Slide Left',
				'value' => 'dslcSlideLeft'
			),
			array(
				'label' => 'Slide Up + Fade In',
				'value' => 'dslcSlideUpFadeIn'
			),
			array(
				'label' => 'Slide Down + Fade In',
				'value' => 'dslcSlideDownFadeIn'
			),
			array(
				'label' => 'Slide Right + Fade In',
				'value' => 'dslcSlideRightFadeIn'
			),
			array(
				'label' => 'Slide Left + Fade In',
				'value' => 'dslcSlideLeftFadeIn'
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
				'choices' => $animation_options_choices
			),
			array(
				'label' => 'On Load Animation - Delay ( ms )',
				'id' => 'css_anim_delay',
				'std' => '0',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Animation'
			),
			array(
				'label' => 'On Load Anim - Duration ( ms )',
				'id' => 'css_anim_duration',
				'std' => '650',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Animation'
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
						'value' => 'ease'
					),
					array(
						'label' => 'Linear',
						'value' => 'linear'
					),
					array(
						'label' => 'Ease In',
						'value' => 'ease-in'
					),
					array(
						'label' => 'Ease Out',
						'value' => 'ease-out'
					),
					array(
						'label' => 'Ease In Out',
						'value' => 'ease-in-out'
					),
				)
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
						'value' => 'none'
					),
					array(
						'label' => 'Fade In',
						'value' => 'dslcFadeIn'
					),
					array(
						'label' => 'Slide Up',
						'value' => 'dslcSlideUp'
					),
					array(
						'label' => 'Slide Down',
						'value' => 'dslcSlideDown'
					),
					array(
						'label' => 'Slide Right',
						'value' => 'dslcSlideRight'
					),
					array(
						'label' => 'Slide Left',
						'value' => 'dslcSlideLeft'
					),
					array(
						'label' => 'Slide Up + Fade In',
						'value' => 'dslcSlideUpFadeIn'
					),
					array(
						'label' => 'Slide Down + Fade In',
						'value' => 'dslcSlideDownFadeIn'
					),
					array(
						'label' => 'Slide Right + Fade In',
						'value' => 'dslcSlideRightFadeIn'
					),
					array(
						'label' => 'Slide Left + Fade In',
						'value' => 'dslcSlideLeftFadeIn'
					),
				)
			),
			array(
				'label' => 'On Hover Animation - Speed ( ms )',
				'id' => 'css_anim_speed',
				'std' => '650',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Animation'
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
				'tab' => 'Filters'
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
				'tab' => 'Filters'
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
				'tab' => 'Filters'
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
				'tab' => 'Filters'
			),
			array(
				'label' => 'Border Width',
				'id' => 'css_filter_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Filters'
			),
			array(
				'label' => 'Borders',
				'id' => 'css_filter_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => 'Top',
						'value' => 'top'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					),
					array(
						'label' => 'Bottom',
						'value' => 'bottom'
					),
					array(
						'label' => 'Left',
						'value' => 'left'
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
				'ext' => 'px'
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
				'tab' => 'Filters'
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
				'tab' => 'Filters'
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
				'ext' => 'px'
			),
			array(
				'label' => 'Font Weight',
				'id' => 'css_filter_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => 'Filters',
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Filters'
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
				'tab' => 'Filters'
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
				'tab' => 'Filters'
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
				'ext' => 'px'
			),

			/**
			 * Responsive Tablet
			 */

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
				'ext' => 'px'
			),
			array(
				'label' => 'Filters - Padding Vertical',
				'id' => 'css_res_t_filter_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Tablet'
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
				'tab' => 'Tablet'
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
				'tab' => 'Tablet'
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
				'ext' => 'px'
			),

			/**
			 * Responsive Phone
			 */

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
				'ext' => 'px'
			),
			array(
				'label' => 'Filters - Padding Vertical',
				'id' => 'css_res_p_filter_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-post-filter',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => 'Phone'
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
				'tab' => 'Phone'
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
				'tab' => 'Phone'
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
				'ext' => 'px'
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
				'visibility' => 'hidden'
			),
			array(
				'label' => 'View All Title',
				'id' => 'main_heading_link_title',
				'std' => 'VIEW ALL',
				'type' => 'text',
				'visibility' => 'hidden'
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
				'tab' => 'Heading'
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
				'ext' => 'px'
			),
			array(
				'label' => 'Title - Font Weight',
				'id' => 'css_main_heading_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading h2',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => 'px',
				'min' => -50,
				'max' => 50
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
				'ext' => 'px'
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
				'tab' => 'Heading'
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
				'tab' => 'Heading'
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
				'ext' => 'px'
			),
			array(
				'label' => 'Link - Font Weight',
				'id' => 'css_main_heading_link_font_weight',
				'std' => '600',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-module-heading-view-all a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => 'Heading',
				'ext' => 'px',
				'min' => -50,
				'max' => 50
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
				'ext' => 'px'
			),
			array(
				'label' => 'Link - URL',
				'id' => 'view_all_link',
				'std' => '#',
				'type' => 'text',
				'section' => 'styling',
				'tab' => 'Heading',
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
				'tab' => 'Heading'
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
				)
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'tab' => 'Carousel Arrows'
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
				'tab' => 'Carousel Arrows'
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
				'tab' => 'Carousel Arrows'
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
				'ext' => 'px'
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
				'tab' => 'Carousel Arrows'
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
				'tab' => 'Carousel Arrows'
			),
			array(
				'label' => 'Margin Top',
				'id' => 'css_arrows_margin_top',
				'std' => '6',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
				'ext' => 'px'
			),
			array(
				'label' => 'Size',
				'id' => 'css_arrows_size',
				'std' => '23',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav-prev,.dslc-carousel-nav-next',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Carousel Arrows'
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
				'tab' => 'Carousel Arrows'
			),
			array(
				'label' => 'Margin Bottom',
				'id' => 'css_arrows_margin_bottom',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-carousel-nav',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'tab' => 'Carousel Arrows',
				'ext' => 'px'
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
				'tab' => 'Carousel Circles'
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
				'tab' => 'Carousel Circles'
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
				'tab' => 'Carousel Circles'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'ext' => 'px'
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
				'tab' => 'Pagination'
			),
			array(
				'label' => 'Container - Border Width',
				'id' => 'css_pag_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination'
			),
			array(
				'label' => 'Container - Borders',
				'id' => 'css_pag_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => 'Top',
						'value' => 'top'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					),
					array(
						'label' => 'Bottom',
						'value' => 'bottom'
					),
					array(
						'label' => 'Left',
						'value' => 'left'
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
				'ext' => 'px'
			),
			array(
				'label' => 'Container - Padding Vertical',
				'id' => 'css_pag_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination'
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
				'tab' => 'Pagination'
			),

			array(
				'label' => 'Item - BG Color',
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
				'label' => 'Item - Border Color',
				'id' => 'css_pag_item_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-inactive a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'Pagination'
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
				'tab' => 'Pagination'
			),
			array(
				'label' => 'Item - Border Width',
				'id' => 'css_pag_item_border_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li.dslc-inactive a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination'
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
				'tab' => 'Pagination'
			),
			array(
				'label' => 'Item - Borders',
				'id' => 'css_pag_item_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => 'Top',
						'value' => 'top'
					),
					array(
						'label' => 'Right',
						'value' => 'right'
					),
					array(
						'label' => 'Bottom',
						'value' => 'bottom'
					),
					array(
						'label' => 'Left',
						'value' => 'left'
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
				'ext' => 'px'
			),
			array(
				'label' => 'Item - Color',
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
				'label' => 'Item - Font Size',
				'id' => 'css_pag_item_font_size',
				'std' => '11',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => 'Pagination',
				'ext' => 'px'
			),
			array(
				'label' => 'Item - Font Weight',
				'id' => 'css_pag_item_font_weight',
				'std' => '700',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => 'Pagination',
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
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
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => 'Pagination',
				'ext' => 'px',
				'min' => -50,
				'max' => 50
			),
			array(
				'label' => 'Item - Padding Vertical',
				'id' => 'css_pag_item_padding_vertical',
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-pagination li a',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => 'Pagination'
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
				'tab' => 'Pagination'
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
				'tab' => 'Pagination'
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
				'section' => 'responsive'
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
				'affect_on_change_el' => '.dslc-blog-post-thumb'
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
				'section' => 'responsive'
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
				'section' => 'responsive'
			),

		);

		$default_typo = array();

		if ( is_array( $atts ) &&
		    isset( $atts['selector'] ) &&
		    isset( $atts['tab'] )
		) {

			$id = preg_replace('/[\W]/', "_", strtolower( $atts['selector'] ) );

			$default_typo = array(

				array(
					'label' => 'Text align',
					'id' => 'css_filter_position_' . $id,
					'std' => '',
					'type' => 'text_align',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'],
					'affect_on_change_rule' => 'text-align',
					'section' => 'styling',
					'tab' => $atts['tab'],
				),
				array(
					'label' => __( 'Color', 'live-composer-page-builder' ),
					'id' => 'css_color_' . $id,
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'],
					'affect_on_change_rule' => 'color',
					'section' => 'styling',
					'tab' => __( $atts['tab'], 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
					'id' => 'css_color_hover_' . $id,
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'] . ":hover",
					'affect_on_change_rule' => 'color',
					'section' => 'styling',
					'tab' => __( $atts['tab'], 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Font Size', 'live-composer-page-builder' ),
					'id' => 'css_font_size_' . $id,
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'],
					'affect_on_change_rule' => 'font-size',
					'section' => 'styling',
					'tab' => __( $atts['tab'], 'live-composer-page-builder' ),
					'ext' => 'px'
				),
				array(
					'label' => __( 'Font Weight', 'live-composer-page-builder' ),
					'id' => 'css_font_weight_' . $id,
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'],
					'affect_on_change_rule' => 'font-weight',
					'section' => 'styling',
					'tab' => __( $atts['tab'], 'live-composer-page-builder' ),
					'ext' => '',
					'min' => 100,
					'max' => 900,
					'increment' => 100
				),
				array(
					'label' => __( 'Font Family', 'live-composer-page-builder' ),
					'id' => 'css_font_family_' . $id,
					'std' => '',
					'type' => 'font',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'],
					'affect_on_change_rule' => 'font-family',
					'section' => 'styling',
					'tab' => __( $atts['tab'], 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Letter Spacing', 'live-composer-page-builder' ),
					'id' => 'css_letter_spacing_' . $id,
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'],
					'affect_on_change_rule' => 'letter-spacing',
					'section' => 'styling',
					'tab' => __( $atts['tab'], 'live-composer-page-builder' ),
					'ext' => 'px',
					'min' => 0,
					'max' => 100
				),
				array(
					'label' => __( 'Line height', 'live-composer-page-builder' ),
					'id' => 'css_line_height_' . $id,
					'std' => '',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'],
					'affect_on_change_rule' => 'line-height',
					'section' => 'styling',
					'tab' => __( $atts['tab'], 'live-composer-page-builder' ),
					'ext' => 'px',
					'min' => 0,
					'max' => 150
				),
				array(
					'label' => __( 'Text Shadow', 'live-composer-page-builder' ),
					'id' => 'css_text_shadow_' . $id,
					'std' => '',
					'type' => 'text_shadow',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'],
					'affect_on_change_rule' => 'text-shadow',
					'section' => 'styling',
					'tab' => __( $atts['tab'], 'live-composer-page-builder' ),
				),
				array(
					'label' => __( 'Text Shadow Hover', 'live-composer-page-builder' ),
					'id' => 'css_text_shadow_' . $id . '_hover',
					'std' => '',
					'type' => 'text_shadow',
					'refresh_on_change' => false,
					'affect_on_change_el' => $atts['selector'] . ":hover",
					'affect_on_change_rule' => 'text-shadow',
					'section' => 'styling',
					'tab' => __( $atts['tab'], 'live-composer-page-builder' ),
				),
			);
		}

		return $$options_id;
	}

	/**
 	 * Declare module options
 	 */
	function options() {
		die( 'Function "options" must be over-ridden in a sub-class (the module class).' );
	}

	/**
	 * The front-end output of the module
	 */
	function output( $options ) {
		die( 'Function "output" must be over-ridden in a sub-class (the module class).' );
	}

	function module_start( $options ) {

		global $dslc_should_filter;
		$dslc_should_filter = false;

		if ( ! isset( $options['css_anim'] ) )
			$options['css_anim'] = 'none';

		if ( ! isset( $options['css_anim_delay'] ) )
			$options['css_anim_delay'] = '0';

		if ( ! isset( $options['css_anim_duration'] ) )
			$options['css_anim_duration'] = '650';

		if ( ! isset( $options['css_anim_easing'] ) )
			$options['css_anim_easing'] = 'default';

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

		if ( isset( $options['dslc_m_size_last'] ) && $options['dslc_m_size_last'] == 'yes' ) {
			$class_size_output .= ' dslc-last-col';
		}

		/**
		 * Show on ( desktop, tablet, phone )
		 */

		$class_show_on = '';
		if ( isset( $options['css_show_on'] ) ) {

			$show_on = explode( ' ', trim( $options['css_show_on'] ) );

			if ( ! in_array( 'desktop', $show_on ) )
				$class_show_on .= 'dslc-hide-on-desktop ';

			if ( ! in_array( 'tablet', $show_on ) )
				$class_show_on .= 'dslc-hide-on-tablet ';

			if ( ! in_array( 'phone', $show_on ) )
				$class_show_on .= 'dslc-hide-on-phone ';

		}

		/**
		 * Handle like
		 */

		if ( isset( $this->handle_like ) )
			$class_handle_like = 'dslc-module-handle-like-' . $this->handle_like;
		else
			$class_handle_like = 'dslc-module-handle-like-regular';

		/**
		 * Globals
		 */

		global $dslc_css_style;
		global $dslc_googlefonts_array;
		global $dslc_all_googlefonts_array;

		/**
		 * Title Attr
		 */

		$title_attr = '';
		if ( dslc_is_editor_active() ) {
			$title_attr = 'title="' . strtoupper( esc_attr( $this->module_title ) ) . '"';
		}

		/**
		 * Option Preset
		 */

		if ( ! isset( $options['css_load_preset'] ) ) {
			$options['css_load_preset'] = '';
		}

		// Module class array
		$module_class_arr = array();
		$module_class_arr[] = 'dslc-module-front';
		$module_class_arr[] = 'dslc-module-' . $this->module_id;
		$module_class_arr[] = 'dslc-in-viewport-check';
		$module_class_arr[] = 'dslc-in-viewport-anim-' . $options['css_anim'];
		$module_class_arr[] = $class_size_output;
		$module_class_arr[] = $class_show_on;
		$module_class_arr[] = $class_handle_like;

		// Module class array apply filters
		$module_class_arr = apply_filters( 'dslc_module_class', $module_class_arr, $this->module_id, $options );

		// Turn module class array into string
		$module_class = '';
		foreach ( $module_class_arr as $module_class_inst ) {
			$module_class .= $module_class_inst . ' ';
		}

		?>

		<div id="dslc-module-<?php echo $options['module_instance_id']; ?>" class="<?php echo $module_class; ?>" data-module-id="<?php echo $options['module_instance_id']; ?>" data-dslc-module-id="<?php echo $this->module_id; ?>" data-dslc-module-size="<?php echo $data_attr_size ?>" data-dslc-anim="<?php echo $options['css_anim'] ?>" data-dslc-anim-delay="<?php echo $options['css_anim_delay']; ?>" data-dslc-anim-duration="<?php echo $options['css_anim_duration']; ?>"  data-dslc-anim-easing="<?php echo $options['css_anim_easing']; ?>" data-dslc-preset="<?php echo $options['css_load_preset']; ?>" <?php echo $title_attr; ?>>

			<?php do_action( 'dslc_module_before' ); ?>

			<?php if ( DS_LIVE_COMPOSER_ACTIVE && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) : ?>

				<style type="text/css" id="css-for-dslc-module-<?php echo $options['module_instance_id']; ?>"><?php

					$options_arr = $this->options();

					if ( isset( $options['css_custom'] ) && $options['css_custom'] == 'disabled' ) {



					} else {

						dslc_generate_custom_css( $options_arr, $options, true );
						$googlefonts_output = '';
						foreach ( $dslc_googlefonts_array as $googlefont ) {
							if ( in_array( $googlefont, $dslc_all_googlefonts_array ) ) {
								$googlefont = str_replace( ' ', '+', $googlefont );
								if ( $googlefont != '' ) {
									$googlefonts_output .= '@import url("//fonts.googleapis.com/css?family=' . $googlefont . ':100,200,300,400,500,600,700,800,900&subset=latin,latin-ext"); ';
								}
							}
						}
						echo $googlefonts_output;
						echo $dslc_css_style;

					}

				?></style>

				<div class="dslca-module-manage">
					<span class="dslca-module-manage-line"></span>
					<div class="dslca-module-manage-inner">
						<span class="dslca-module-manage-hook dslca-module-edit-hook"><span class="dslc-icon-cog"></span></span>
						<span class="dslca-module-manage-hook dslca-copy-module-hook"><span class="dslc-icon-copy"></span></span>
						<span class="dslca-module-manage-hook dslca-move-module-hook"><span class="dslc-icon-move"></span></span>
						<span class="dslca-module-manage-hook dslca-change-width-module-hook">
							<span class="dslc-icon-columns"></span>
							<div class="dslca-change-width-module-options">
								<span>Module Width</span>
								<span data-size="1">1/12</span><span data-size="2">2/12</span>
								<span data-size="3">3/12</span><span data-size="4">4/12</span>
								<span data-size="5">5/12</span><span data-size="6">6/12</span>
								<span data-size="7">7/12</span><span data-size="8">8/12</span>
								<span data-size="9">9/12</span><span data-size="10">10/12</span>
								<span data-size="11">11/12</span><span data-size="12">12/12</span>
							</div>
						</span>
						<span class="dslca-module-manage-hook dslca-delete-module-hook"><span class="dslc-icon-remove"></span></span>
					</div>
					<?php if ( DS_LIVE_COMPOSER_DEV_MODE ) : ?>
						<div class="dslca-module-manage-inner dslca-dev-mode">
							<span class="dslca-module-manage-hook dslca-module-get-defaults-hook"><span class="dslc-icon-upload-alt"></span></span>
						</div>
					<?php endif; ?>
				</div>

			<?php endif; ?>

		<?php
	}

	function module_end( $user_options ) {

		// Get options array
		$options = $this->options();

		// Bring back IDs for image options
		global $dslc_var_image_option_bckp;
		foreach ( $dslc_var_image_option_bckp as $key => $value ) {
			$user_options[$key] = $value;
		}

		// Other vars
		$user_options['module_id'] = $this->module_id;
		if ( ! isset( $user_options['dslc_m_size'] ) ) $user_options['dslc_m_size'] = '12';
		$option_ids = array();
		$user_options_no_defaults = $user_options;

		?>

			<?php if ( DS_LIVE_COMPOSER_ACTIVE && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) : ?>

				<div class="dslca-module-options-front">

					<?php foreach ( $options as $key => $option ) : ?>

						<?php

							// Option ID
							$option_id = $option['id'];
							$options_ids[] = $option['id'];

							// If value already set use it, if not use default
							if ( isset( $user_options[$option_id] ) )
								$option_value = $user_options[$option_id];
							else
								$option_value = $option['std'];

							if ( isset( $user_options[$option_id] ) && $user_options[$option_id] == $option['std'] ) {
								unset( $user_options_no_defaults[$option_id] );
							}
						?>

						<textarea class="dslca-module-option-front" data-id="<?php echo $option_id; ?>"><?php echo stripslashes( $option_value ); ?></textarea>
					<?php endforeach; ?>

					<?php foreach ( $user_options as $user_option_id => $user_option_val ) : ?>

						<?php if ( ! in_array( $user_option_id, $options_ids ) ) : ?>

							<textarea class="dslca-module-option-front" data-id="<?php echo $user_option_id; ?>"><?php echo stripslashes( $user_option_val ); ?></textarea>

						<?php endif; ?>

					<?php endforeach; ?>

				</div><!-- dslca-module-options-front -->

				<textarea class="dslca-module-code"><?php echo base64_encode( serialize( $user_options_no_defaults ) ); ?></textarea>

				<span class="dslc-sortable-helper-icon dslc-icon-<?php echo $this->module_icon; ?>" data-title="<?php echo $this->module_title; ?>" data-icon="<?php echo $this->module_icon; ?>"></span>

			<?php endif; ?>

			<?php do_action( 'dslc_module_after' ); ?>

		</div><!-- .dslc-module -->
		<?php

		global $dslc_should_filter;
		$dslc_should_filter = true;

	}

	function presets_options() {

		$choices = array(
			array(
				'label' => 'None',
				'value' => 'none',
			),
		);

		// Get current presets
		$presets = get_option( 'dslc_presets' );
		if ( $presets === false ) {
			$presets = array();
		} else {
			$presets = maybe_unserialize( $presets );
			foreach ( $presets as $preset ) {
				if ( $preset['module'] == $this->module_id ) {
					$choices[] = array(
						'label' => $preset['title'],
						'value' => $preset['id']
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
				'help' => __( 'Type in the name of the preset and hit enter,<br>it will automatically be added to the presets on the left.', 'live-composer-page-builder' ),
			),
		);

		return $options;

	}

}