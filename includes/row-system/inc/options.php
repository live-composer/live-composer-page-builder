<?php
/**
 * Table of Contents
 *
 * - dslc_row_register_options ( Register options )
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
function dslc_row_register_options() {

	global $dslc_var_row_options;

	$dslc_var_row_options['element_type'] = array(
		'id' => 'element_type',
		'std' => 'row',
		'label' => '',
		'type' => 'hidden',
	);

	$dslc_var_row_options['show_on'] = array(
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

	$dslc_var_row_options['type'] = array(
		'id' => 'type',
		'std' => 'wrapper',
		'label' => __( 'Type', 'live-composer-page-builder' ),
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
		),
	);

	$dslc_var_row_options['columns_spacing'] = array(
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

	$dslc_var_row_options['bg_color'] = array(
		'id' => 'bg_color',
		'std' => '',
		'label' => __( 'BG Color', 'live-composer-page-builder' ),
		'type' => 'color',
		'affect_on_change_rule' => 'background-color',
	);

	$dslc_var_row_options['bg_image_thumb'] = array(
		'id' => 'bg_image_thumb',
		'std' => 'disabled',
		'label' => __( 'BG Image - Use Featured', 'live-composer-page-builder' ),
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
		'affect_on_change_rule' => 'background-image',
	);

	$dslc_var_row_options['bg_image'] = array(
		'id' => 'bg_image',
		'std' => '',
		'label' => __( 'BG Image', 'live-composer-page-builder' ),
		'type' => 'image',
		'affect_on_change_rule' => 'background-image',
	);

	$dslc_var_row_options['bg_image_repeat'] = array(
		'id' => 'bg_image_repeat',
		'std' => 'repeat',
		'label' => __( 'BG Image Repeat', 'live-composer-page-builder' ),
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
		'affect_on_change_rule' => 'background-repeat',
	);

	$dslc_var_row_options['bg_image_position'] = array(
		'id' => 'bg_image_position',
		'std' => 'left top',
		'label' => __( 'BG Image Position', 'live-composer-page-builder' ),
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
				'value' => 'center top',
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
		'affect_on_change_rule' => 'background-position',
	);

	$dslc_var_row_options['bg_image_attachment'] = array(
		'id' => 'bg_image_attachment',
		'std' => 'scroll',
		'label' => __( 'BG Image Attachment', 'live-composer-page-builder' ),
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
			array(
				'label' => __( 'Parallax', 'live-composer-page-builder' ),
				'value' => 'parallax',
			),
		),
		'affect_on_change_rule' => 'background-attachment',
	);

	$dslc_var_row_options['bg_image_size'] = array(
		'id' => 'bg_image_size',
		'std' => 'auto',
		'label' => __( 'BG Image Size', 'live-composer-page-builder' ),
		'type' => 'select',
		'choices' => array(
			array(
				'label' => __( 'Original', 'live-composer-page-builder' ),
				'value' => 'auto',
			),
			array(
				'label' => __( 'Cover', 'live-composer-page-builder' ),
				'value' => 'cover',
			),
			array(
				'label' => __( 'Contain', 'live-composer-page-builder' ),
				'value' => 'contain',
			),
		),
		'affect_on_change_rule' => 'background-size',
	);

	$dslc_var_row_options['bg_video'] = array(
		'id' => 'bg_video',
		'std' => '',
		'label' => __( 'BG Video', 'live-composer-page-builder' ),
		'type' => 'video',
		'affect_on_change_rule' => 'background-video',
	);

	$dslc_var_row_options['bg_video_overlay_color'] = array(
		'id' => 'bg_video_overlay_color',
		'std' => '#000000',
		'label' => __( 'BG - Overlay Color', 'live-composer-page-builder' ),
		'type' => 'color',
		'affect_on_change_el' => '.dslc-bg-video-overlay',
		'affect_on_change_rule' => 'background-color',
	);

	$dslc_var_row_options['bg_video_overlay_opacity'] = array(
		'id' => 'bg_video_overlay_opacity',
		'std' => '0',
		'label' => __( 'BG - Overlay Opacity', 'live-composer-page-builder' ),
		'type' => 'slider',
		'affect_on_change_rule' => 'opacity',
		'affect_on_change_el' => '.dslc-bg-video-overlay',
		'min' => 0,
		'max' => 1,
		'increment' => 0.05,
	);

	$dslc_var_row_options['border_color'] = array(
		'id' => 'border_color',
		'std' => '',
		'label' => __( 'Border Color', 'live-composer-page-builder' ),
		'type' => 'color',
		'affect_on_change_rule' => 'border-color',
	);

	$dslc_var_row_options['border_width'] = array(
		'id' => 'border_width',
		'min' => 0,
		'std' => '0',
		'label' => __( 'Border Width', 'live-composer-page-builder' ),
		'type' => 'slider',
		'affect_on_change_rule' => 'border-width',
		'ext' => 'px',
	);

	$dslc_var_row_options['border_style'] = array(
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
	);

	$dslc_var_row_options['border'] = array(
		'id' => 'border',
		'std' => 'top right bottom left',
		'label' => __( 'Borders', 'live-composer-page-builder' ),
		'type' => 'border_checkbox',
	);

	$dslc_var_row_options['margin_h'] = array(
		'id' => 'margin_h',
		'std' => '0',
		'label' => __( 'Margin Horizontal', 'live-composer-page-builder' ),
		'type' => 'slider',
		'affect_on_change_rule' => 'margin-left,margin-right',
		'ext' => '%',
		'max' => 90,
	);

	$dslc_var_row_options['margin_b'] = array(
		'id' => 'margin_b',
		'std' => '0',
		'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
		'type' => 'slider',
		'affect_on_change_rule' => 'margin-bottom',
		'ext' => 'px',
		'max' => 500,
	);

	$dslc_var_row_options['padding'] = array(
		'id' => 'padding',
		'std' => '80',
		'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
		'type' => 'slider',
		'affect_on_change_rule' => 'padding-bottom,padding-top',
		'ext' => 'px',
		'max' => 500,
	);

	$dslc_var_row_options['padding_h'] = array(
		'id' => 'padding_h',
		'std' => '0',
		'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
		'type' => 'slider',
		'affect_on_change_rule' => 'padding-left,padding-right',
		'ext' => '%',
		'max' => 90,
	);

	$dslc_var_row_options['custom_class'] = array(
		'id' => 'custom_class',
		'label' => __( 'Custom Class', 'live-composer-page-builder' ),
		'type' => 'text',
	);

	$dslc_var_row_options['custom_id'] = array(
		'id' => 'custom_id',
		'label' => __( 'Custom ID', 'live-composer-page-builder' ),
		'type' => 'text',
	);

	$dslc_var_row_options['section_instance_id'] = array(
		'id' => 'section_instance_id',
		'label' => '',
		'type' => 'hidden',
	);

	// Hook to register custom modules or alter current.
	do_action( 'dslc_hook_row_options' );

	// Filter to filter the registered row controls.
	$dslc_var_row_options = apply_filters( 'dslc_filter_row_options', $dslc_var_row_options );
}

add_action( 'init', 'dslc_row_register_options' );
