<?php

/**
 * Table of Contents
 *
 * - dslc_modules_area_register_options ( Register options )
 *
 * @package LiveComposer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Register Options
 *
 * @since 1.0
 */
function dslc_modules_area_register_options() {

	global $dslc_var_modules_area_options;

	$dslc_var_modules_area_options['element_type'] = array(
		'id' => 'element_type',
		'std' => 'module_area',
		'label' => '',
		'type' => 'hidden',
	);

	$dslc_var_modules_area_options['show_on'] = array(
		'id' => 'show_on',
		'std' => 'desktop tablet phone',
		'label' => __( 'Show On', 'live-composer-page-builder' ),
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
		),
	);

	$dslc_var_modules_area_options['columns_spacing'] = array(
		'id' => 'columns_spacing',
		'std' => 'spacing',
		'label' => __( 'Columns Spacing', 'live-composer-page-builder' ),
		'type' => 'select',
		'choices' => array(
			array(
				'label' => __( 'With Spacing', 'live-composer-page-builder' ),
				'value' => 'spacing',
			),
			array(
				'label' => __( 'Without Spacing', 'live-composer-page-builder' ),
				'value' => 'nospacing',
			),
		),
	);
	$dslc_var_modules_area_options['alignment_group_open'] = array(
		'label' => __( 'Alignment', 'live-composer-page-builder' ),
		'id' => 'alignment_group_open',
		'type' => 'group',
		'action' => 'open',
	);

		$dslc_var_modules_area_options['valign'] = array(
			'id' => 'valign',
			'std' => 'top',
			'label' => __( 'Vertical Alignment', 'live-composer-page-builder' ),
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( 'Top', 'live-composer-page-builder' ),
					'value' => 'top',
				),
				array(
					'label' => __( 'Middle', 'live-composer-page-builder' ),
					'value' => 'middle',
				),
				array(
					'label' => __( 'Bottom', 'live-composer-page-builder' ),
					'value' => 'bottom',
				),
			),
		);

		$dslc_var_modules_area_options['halign'] = array(
			'id' => 'halign',
			'std' => 'left',
			'label' => __( 'Horizontal Alignment', 'live-composer-page-builder' ),
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( 'Left', 'live-composer-page-builder' ),
					'value' => 'start',
				),
				array(
					'label' => __( 'Center', 'live-composer-page-builder' ),
					'value' => 'center',
				),
				array(
					'label' => __( 'Right', 'live-composer-page-builder' ),
					'value' => 'end',
				),
			),
		);

	$dslc_var_modules_area_options['alignment_group_close'] = array(
		'label' => __( 'Alignment', 'live-composer-page-builder' ),
		'id' => 'alignment_group_close',
		'type' => 'group',
		'action' => 'close',
	);
	
	$dslc_var_modules_area_options['custom_class'] = array(
		'id' => 'custom_class',
		'label' => __( 'Custom Class', 'live-composer-page-builder' ),
		'type' => 'text',
	);

	$dslc_var_modules_area_options['custom_id'] = array(
		'id' => 'custom_id',
		'label' => __( 'Custom ID', 'live-composer-page-builder' ),
		'type' => 'text',
	);

	$dslc_var_modules_area_options['modules_area_instance_id'] = array(
		'id' => 'modules_area_instance_id',
		'std'   => '',
		'label' => '',
		'type' => 'hidden',
	);

	// =============================== Styling Section=============================
	$dslc_var_modules_area_options['css_custom'] = array(
			'label' => __( 'Enable/Disable Custom CSS', 'live-composer-page-builder' ),
			'id' => 'css_custom',
			'std' => 'enabled',
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( 'Enabled', 'live-composer-page-builder' ),
					'value' => 'enabled',
				),
				array(
					'label' => __( 'Disabled', 'live-composer-page-builder' ),
					'value' => 'disabled',
				),
			),
			'section' => 'styling',
		);

	$dslc_var_modules_area_options['margin_group_open'] = array(
		'label' => __( 'Margin', 'live-composer-page-builder' ),
		'id' => 'bg_group_open',
		'type' => 'group',
		'action' => 'open',
		'section' => 'styling',
	);
		$dslc_var_modules_area_options['margin_unit'] = array(
			'id' => 'margin_unit',
			'std' => 'px',
			'label' => __('Margin Unit', 'live-composer-page-builder'),
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
		);
		$dslc_var_modules_area_options['margin_top'] = array(
			'id' => 'margin_top',
			'std' => '',
			'label' => __( 'Top', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-top',
			'section' => 'styling',
			'ext' => 'px',
			'max' => 500,
		);
		$dslc_var_modules_area_options['margin_bottom'] = array(
			'id' => 'margin_bottom',
			'std' => '0',
			'label' => __( 'Bottom', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-bottom',
			'section' => 'styling',
			'ext' => 'px',
			'max' => 500,
		);
		$dslc_var_modules_area_options['margin_left'] = array(
			'id' => 'margin_left',
			'std' => '',
			'label' => __( 'Left', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-left',
			'section' => 'styling',
			'ext' => 'px',
			'max' => 90,
		);
		$dslc_var_modules_area_options['margin_right'] = array(
			'id' => 'margin_right',
			'std' => '',
			'label' => __( 'Right', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-right',
			'section' => 'styling',
			'ext' => 'px',
			'max' => 90,
		);

	$dslc_var_modules_area_options['margin_group_close'] = array(
		'label' => __( 'Margin', 'live-composer-page-builder' ),
		'id' => 'bg_group_close',
		'type' => 'group',
		'action' => 'close',
	);

	$dslc_var_modules_area_options['padding_group_open'] = array(
		'label' => __( 'Padding', 'live-composer-page-builder' ),
		'id' => 'bg_group_open',
		'type' => 'group',
		'action' => 'open',
		'section' => 'styling',
	);
		$dslc_var_modules_area_options['padding_unit'] = array(
			'id' => 'padding_unit',
			'std' => 'px',
			'label' => __('Padding Unit', 'live-composer-page-builder'),
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
		);
		$dslc_var_modules_area_options['padding_top'] = array(
			'id' => 'padding_top',
			'std' => '',
			'label' => __( 'Top', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-top',
			'section' => 'styling',
			'ext' => 'px',
			'max' => 500,
		);
		$dslc_var_modules_area_options['padding_bottom'] = array(
			'id' => 'padding_bottom',
			'std' => '',
			'label' => __( 'Bottom', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-bottom',
			'section' => 'styling',
			'ext' => 'px',
			'max' => 500,
		);

		$dslc_var_modules_area_options['padding_left'] = array(
			'id' => 'padding_left',
			'std' => '',
			'label' => __( 'Left', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-left',
			'section' => 'styling',
			'ext' => 'px',
			'max' => 90,
		);
		$dslc_var_modules_area_options['padding_right'] = array(
			'id' => 'padding_right',
			'std' => '',
			'label' => __( 'Padding Rightl', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-right',
			'section' => 'styling',
			'ext' => 'px',
			'max' => 90,
		);

	$dslc_var_modules_area_options['padding_group_close'] = array(
		'label' => __( 'Padding', 'live-composer-page-builder' ),
		'id' => 'bg_group_close',
		'type' => 'group',
		'action' => 'close',
		'section' => 'styling',
	);

	$dslc_var_modules_area_options['border_group_open'] = array(
		'label' => __( 'Border', 'live-composer-page-builder' ),
		'id' => 'bg_group_open',
		'type' => 'group',
		'action' => 'open',
		'section' => 'styling',
	);

	$dslc_var_modules_area_options['border_color'] = array(
		'id' => 'border_color',
		'std' => '',
		'label' => __( 'Border Color', 'live-composer-page-builder' ),
		'type' => 'color',
		'affect_on_change_rule' => 'border-color',
		'section' => 'styling',
	);

	$dslc_var_modules_area_options['border_width'] = array(
		'id' => 'border_width',
		'min' => 0,
		'std' => '0',
		'label' => __( 'Border Width', 'live-composer-page-builder' ),
		'type' => 'slider',
		'affect_on_change_rule' => 'border-width',
		'ext' => 'px',
		'section' => 'styling',
	);

	$dslc_var_modules_area_options['border_style'] = array(
		'id' => 'border_style',
		'std' => 'solid',
		'label' => __( 'Border Style', 'live-composer-page-builder' ),
		'type' => 'select',
		'choices' => array(
			array(
				'label' => __( 'Solid', 'live-composer-page-builder' ),
				'value' => 'solid',
			),
			array(
				'label' => __( 'Dotted', 'live-composer-page-builder' ),
				'value' => 'dotted',
			),
			array(
				'label' => __( 'Dashed', 'live-composer-page-builder' ),
				'value' => 'dashed',
			),
		),
		'affect_on_change_rule' => 'border-style',
		'section' => 'styling',
	);

	$dslc_var_modules_area_options['border'] = array(
		'id' => 'border',
		'std' => 'top right bottom left',
		'label' => __( 'Borders', 'live-composer-page-builder' ),
		'type' => 'border_checkbox',
		'section' => 'styling',
	);

	$dslc_var_modules_area_options['border_group_close'] = array(
		'label' => __( 'Border', 'live-composer-page-builder' ),
		'id' => 'bg_group_close',
		'type' => 'group',
		'action' => 'close',
		'section' => 'styling',
	);

	// ============================ Responsive Settings ============================
	/**
	 * Responsive Tablet
	 */

	$dslc_var_modules_area_options['css_res_t'] = array(
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
	);
	$dslc_var_modules_area_options['css_res_t_margin_group_open'] = array(
		'label' => __( 'Margin', 'live-composer-page-builder' ),
		'id' => 'css_res_t_margin_group_open',
		'type' => 'group',
		'action' => 'open',
		'section' => 'responsive',
		'tab' => __( 'Tablet', 'live-composer-page-builder' ),
	);
		$dslc_var_modules_area_options['css_res_t_margin_unit'] = array(
			'id' => 'css_res_t_margin_unit',
			'std' => 'px',
			'label' => __('Margin Unit', 'live-composer-page-builder'),
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
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'affect_on_change_el' => '',
			'affect_on_change_rule' => '',
		);
		$dslc_var_modules_area_options['css_res_t_margin_top'] = array(
			'id' => 'css_res_t_margin_top',
			'std' => '',
			'label' => __( 'Top', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-top',
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 500,
		);
		$dslc_var_modules_area_options['css_res_t_margin_bottom'] = array(
			'id' => 'css_res_t_margin_bottom',
			'std' => '',
			'label' => __( 'Bottom', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-bottom',
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 500,
		);
		$dslc_var_modules_area_options['css_res_t_margin_left'] = array(
			'id' => 'css_res_t_margin_left',
			'std' => '',
			'label' => __( 'Left', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-left',
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 90,
		);
		$dslc_var_modules_area_options['css_res_t_margin_right'] = array(
			'id' => 'css_res_t_margin_right',
			'std' => '',
			'label' => __( 'Right', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-right',
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 90,
		);

	$dslc_var_modules_area_options['css_res_t_margin_group_close'] = array(
		'label' => __( 'Margin', 'live-composer-page-builder' ),
		'id' => 'css_res_t_margin_group_close',
		'type' => 'group',
		'action' => 'close', 
		'section' => 'responsive',
		'tab' => __( 'Tablet', 'live-composer-page-builder' ),
	);

	$dslc_var_modules_area_options['css_res_t_padding_group_open'] = array(
		'label' => __( 'Padding', 'live-composer-page-builder' ),
		'id' => 'css_res_t_padding_group_open',
		'type' => 'group',
		'action' => 'open',
		'section' => 'responsive',
		'tab' => __( 'Tablet', 'live-composer-page-builder' ),
	);
		$dslc_var_modules_area_options['css_res_t_padding_unit'] = array(
			'id' => 'css_res_t_padding_unit',
			'std' => 'px',
			'label' => __('Padding Unit', 'live-composer-page-builder'),
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
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'affect_on_change_el' => '',
			'affect_on_change_rule' => '',
		);
		$dslc_var_modules_area_options['css_res_t_padding_top'] = array(
			'id' => 'css_res_t_padding_top',
			'std' => '',
			'label' => __( 'Top', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-top',
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 500,
		);
		$dslc_var_modules_area_options['css_res_t_padding_bottom'] = array(
			'id' => 'css_res_t_padding_bottom',
			'std' => '',
			'label' => __( 'Bottom', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-bottom',
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 500,
		);

		$dslc_var_modules_area_options['css_res_t_padding_left'] = array(
			'id' => 'css_res_t_padding_left',
			'std' => '',
			'label' => __( 'Left', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-left',
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 90,
		);
		$dslc_var_modules_area_options['css_res_t_padding_right'] = array(
			'id' => 'css_res_t_padding_right',
			'std' => '',
			'label' => __( 'Right', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-right',
			'section' => 'responsive',
			'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 90,
		);

	$dslc_var_modules_area_options['css_res_t_padding_group_close'] = array(
		'label' => __( 'Padding', 'live-composer-page-builder' ),
		'id' => 'css_res_t_padding_group_close',
		'type' => 'group',
		'action' => 'close',
		'section' => 'responsive',
		'tab' => __( 'Tablet', 'live-composer-page-builder' ),
	);
	/**
	 * Responsive Phone
	 */

	$dslc_var_modules_area_options['css_res_p'] = array(
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
	);
	$dslc_var_modules_area_options['css_res_p_margin_group_open'] = array(
		'label' => __( 'Margin', 'live-composer-page-builder' ),
		'id' => 'css_res_p_margin_group_open',
		'type' => 'group',
		'action' => 'open',
		'section' => 'responsive',
		'tab' => __( 'Phone', 'live-composer-page-builder' ),
	);
		$dslc_var_modules_area_options['css_res_p_margin_unit'] = array(
			'id' => 'css_res_p_margin_unit',
			'std' => 'px',
			'label' => __('Margin Unit', 'live-composer-page-builder'),
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
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'affect_on_change_el' => '',
			'affect_on_change_rule' => '',
		);
		$dslc_var_modules_area_options['css_res_p_margin_top'] = array(
			'id' => 'css_res_p_margin_top',
			'std' => '',
			'label' => __( 'Top', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-top',
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 500,
		);
		$dslc_var_modules_area_options['css_res_p_margin_bottom'] = array(
			'id' => 'css_res_p_margin_bottom',
			'std' => '',
			'label' => __( 'Bottom', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-bottom',
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 500,
		);
		$dslc_var_modules_area_options['css_res_p_margin_left'] = array(
			'id' => 'css_res_p_margin_left',
			'std' => '',
			'label' => __( 'Left', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-left',
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 90,
		);
		$dslc_var_modules_area_options['css_res_p_margin_right'] = array(
			'id' => 'css_res_p_margin_right',
			'std' => '',
			'label' => __( 'Right', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'margin-right',
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 90,
		);

	$dslc_var_modules_area_options['css_res_p_margin_group_close'] = array(
		'label' => __( 'Margin', 'live-composer-page-builder' ),
		'id' => 'css_res_p_margin_group_close',
		'type' => 'group',
		'action' => 'close', 
		'section' => 'responsive',
		'tab' => __( 'Phone', 'live-composer-page-builder' ),
	);

	$dslc_var_modules_area_options['css_res_p_padding_group_open'] = array(
		'label' => __( 'Padding', 'live-composer-page-builder' ),
		'id' => 'css_res_p_padding_group_open',
		'type' => 'group',
		'action' => 'open',
		'section' => 'responsive',
		'tab' => __( 'Phone', 'live-composer-page-builder' ),
	);
		$dslc_var_modules_area_options['css_res_p_padding_unit'] = array(
			'id' => 'css_res_p_padding_unit',
			'std' => 'px',
			'label' => __('Padding Unit', 'live-composer-page-builder'),
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
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'affect_on_change_el' => '',
			'affect_on_change_rule' => '',
		);
		$dslc_var_modules_area_options['css_res_p_padding_top'] = array(
			'id' => 'css_res_p_padding_top',
			'std' => '',
			'label' => __( 'Top', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-top',
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 500,
		);
		$dslc_var_modules_area_options['css_res_p_padding_bottom'] = array(
			'id' => 'css_res_p_padding_bottom',
			'std' => '',
			'label' => __( 'Bottom', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-bottom',
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 500,
		);

		$dslc_var_modules_area_options['css_res_p_padding_left'] = array(
			'id' => 'css_res_p_padding_left',
			'std' => '',
			'label' => __( 'Left', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-left',
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 90,
		);
		$dslc_var_modules_area_options['css_res_p_padding_right'] = array(
			'id' => 'css_res_p_padding_right',
			'std' => '',
			'label' => __( 'Right', 'live-composer-page-builder' ),
			'type' => 'slider',
			'affect_on_change_rule' => 'padding-right',
			'section' => 'responsive',
			'tab' => __( 'Phone', 'live-composer-page-builder' ),
			'ext' => 'px',
			'max' => 90,
		);

	$dslc_var_modules_area_options['css_res_p_padding_group_close'] = array(
		'label' => __( 'Padding', 'live-composer-page-builder' ),
		'id' => 'css_res_p_padding_group_close',
		'type' => 'group',
		'action' => 'close',
		'section' => 'responsive',
		'tab' => __( 'Phone', 'live-composer-page-builder' ),
	);

	// Hook to register custom modules or alter current.
	do_action( 'dslc_hook_modules_area_options' );

	// Filter to filter the registered Modules Area controls.
	$dslc_var_modules_area_options = apply_filters( 'dslc_filter_modules_area_options', $dslc_var_modules_area_options );
}

add_action( 'init', 'dslc_modules_area_register_options' );
