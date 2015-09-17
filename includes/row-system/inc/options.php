<?php

/**
 * Table of Contents
 *
 * - dslc_row_register_options ( Register options )
 */

	
	/**
	 * Register Options
	 *
	 * @since 1.0
	 */
	
	function dslc_row_register_options() {

		global $dslc_var_row_options;

		$dslc_var_row_options['show_on'] = array(
			'id' => 'show_on',
			'std' => 'desktop tablet phone',
			'label' => __( 'Show On', 'dslc_string' ),
			'type' => 'checkbox',
			'choices' => array(
				array(
					'label' => 'Desktop',
					'value' => 'desktop',
				),
				array(
					'label' => 'Tablet',
					'value' => 'tablet',
				),
				array(
					'label' => 'Phone',
					'value' => 'phone',
				),
			)
		);

		$dslc_var_row_options['type'] = array(
			'id' => 'type',
			'std' => 'wrapped',
			'label' => __( 'Type', 'dslc_string' ),
			'type' => 'select',
			'choices' => array(
				array(
					'label' => 'Wrapped',
					'value' => 'wrapper',
				),
				array(
					'label' => 'Full',
					'value' => 'full',
				),
			)
		);

		$dslc_var_row_options['columns_spacing'] = array(
			'id' => 'columns_spacing',
			'std' => 'spacing',
			'label' => __( 'Columns Spacing', 'dslc_string' ),
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( 'With Spacing', 'dslc_string' ),
					'value' => 'spacing',
				),
				array(
					'label' => __( 'Without Spacing', 'dslc_string' ),
					'value' => 'nospacing',
				),
			)
		);

		$dslc_var_row_options['bg_color'] = array(
			'id' => 'bg_color',
			'label' => __( 'BG Color', 'dslc_string' ),
			'type' => 'color',
			'affect_on_change_rule' => 'background-color',
		);

		$dslc_var_row_options['bg_image_thumb'] = array(
			'id' => 'bg_image_thumb',
			'std' => 'disabled',
			'label' => __( 'BG Image - Use Featured', 'dslc_string' ),
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( 'Enabled', 'dslc_string' ),
					'value' => 'enabled',
				),
				array(
					'label' => __( 'Disabled', 'dslc_string' ),
					'value' => 'disabled',
				),
			),
			'affect_on_change_rule' => 'background-image',
		);

		$dslc_var_row_options['bg_image'] = array(
			'id' => 'bg_image',
			'label' => __( 'BG Image', 'dslc_string' ),
			'type' => 'image',
			'affect_on_change_rule' => 'background-image',
		);

		$dslc_var_row_options['bg_image_repeat'] = array(
			'id' => 'bg_image_repeat',
			'std' => 'repeat',
			'label' => __( 'BG Image Repeat', 'dslc_string' ),
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
			'affect_on_change_rule' => 'background-repeat',
		);

		$dslc_var_row_options['bg_image_position'] = array(
			'id' => 'bg_image_position',
			'std' => 'left top',
			'label' => __( 'BG Image Position', 'dslc_string' ),
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
					'value' => 'center top',
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
			'affect_on_change_rule' => 'background-position',
		);

		$dslc_var_row_options['bg_image_attachment'] = array(
			'id' => 'bg_image_attachment',
			'std' => 'scroll',
			'label' => __( 'BG Image Attachment', 'dslc_string' ),
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
				array(
					'label' => __( 'Parallax', 'dslc_string' ),
					'value' => 'parallax',
				),
			),
			'affect_on_change_rule' => 'background-attachment',
		);

		$dslc_var_row_options['bg_image_size'] = array(
			'id' => 'bg_image_size',
			'std' => 'auto',
			'label' => __( 'BG Image Size', 'dslc_string' ),
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( 'Original', 'dslc_string' ),
					'value' => 'auto',
				),
				array(
					'label' => __( 'Cover', 'dslc_string' ),
					'value' => 'cover',
				),
				array(
					'label' => __( 'Contain', 'dslc_string' ),
					'value' => 'contain',
				),
			),
			'affect_on_change_rule' => 'background-size',
		);

		$dslc_var_row_options['bg_video'] = array(
			'id' => 'bg_video',
			'label' => __( 'BG Video', 'dslc_string' ),
			'type' => 'video',
			'affect_on_change_rule' => 'background-video',
		);

		$dslc_var_row_options['bg_video_overlay_color'] = array(
			'id' => 'bg_video_overlay_color',
			'std' => '#000000',
			'label' => __( 'BG - Overlay Color', 'dslc_string' ),
			'type' => 'color',
			'affect_on_change_el' => '.dslc-bg-video-overlay',
			'affect_on_change_rule' => 'background-color',
		);
	
		$dslc_var_row_options['bg_video_overlay_opacity'] = array(
			'id' => 'bg_video_overlay_opacity',
			'std' => '0',
			'label' => __( 'BG - Overlay Opacity', 'dslc_string' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'opacity',
			'affect_on_change_el' => '.dslc-bg-video-overlay',
			'min' => 0,
			'max' => 1.01,
			'increment' => 0.1,
		);

		$dslc_var_row_options['border_color'] = array(
			'id' => 'border_color',
			'label' => __( 'Border Color', 'dslc_string' ),
			'type' => 'color',
			'affect_on_change_rule' => 'border-color',
		);

		$dslc_var_row_options['border_width'] = array(
			'id' => 'border_width',
			'std' => '0',
			'label' => __( 'Border Width', 'dslc_string' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'border-width',
			'ext' => 'px'
		);

		$dslc_var_row_options['border_style'] = array(
			'id' => 'border_style',
			'std' => 'solid',
			'label' => __( 'Border Style', 'dslc_string' ),
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( 'Solid', 'dslc_string' ),
					'value' => 'solid',
				),
				array(
					'label' => __( 'Dotted', 'dslc_string' ),
					'value' => 'dotted',
				),
				array(
					'label' => __( 'Dashed', 'dslc_string' ),
					'value' => 'dashed',
				),
			),
			'affect_on_change_rule' => 'border-style',
		);

		$dslc_var_row_options['border'] = array(
			'id' => 'border',
			'std' => 'top right bottom left',
			'label' => __( 'Borders', 'dslc_string' ),
			'type' => 'border_checkbox',
		);

		$dslc_var_row_options['margin_h'] = array(
			'id' => 'margin_h',
			'std' => '0',
			'label' => __( 'Margin Horizontal', 'dslc_string' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-left,margin-right',
			'ext' => '%',
			'max' => 30,
			'increment' => 0.5,
		);

		$dslc_var_row_options['margin_b'] = array(
			'id' => 'margin_b',
			'std' => '0',
			'label' => __( 'Margin Bottom', 'dslc_string' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-bottom',
			'ext' => 'px',
			'max' => 500,
			'increment' => 1,
		);

		$dslc_var_row_options['padding'] = array(
			'id' => 'padding',
			'std' => '80',
			'label' => __( 'Padding Vertical', 'dslc_string' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-bottom,padding-top',
			'ext' => 'px',
			'max' => 500,
		);

		$dslc_var_row_options['padding_h'] = array(
			'id' => 'padding_h',
			'std' => '0',
			'label' => __( 'Padding Horizontal', 'dslc_string' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-left,padding-right',
			'ext' => '%',
			'max' => 30,
			'increment' => 0.5,
		);

		$dslc_var_row_options['custom_class'] = array(
			'id' => 'custom_class',
			'label' => __( 'Custom Class', 'dslc_string' ),
			'type' => 'text',
		);

		$dslc_var_row_options['custom_id'] = array(
			'id' => 'custom_id',
			'label' => __( 'Custom ID', 'dslc_string' ),
			'type' => 'text',
		);

		// Hook to register custom modules or alter current
		do_action( 'dslc_hook_row_options' );

	} add_action( 'init', 'dslc_row_register_options' );