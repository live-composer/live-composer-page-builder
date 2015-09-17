<?php

/**
 * Table of Contents
 *
 * dslc_access_control_init ( Register options )
 */


/**
 * Register options
 *
 * @since 1.0
 */

function dslc_access_control_init() {

	global $dslc_plugin_options;
	global $dslc_var_modules;

	$capability_opts = array(
		array(
			'label' => __( 'Administrators', 'dslc_string' ),
			'value' => 'manage_options'
		),
		array(
			'label' => __( 'Editors', 'dslc_string' ),
			'value' => 'publish_pages'
		),
		array(
			'label' => __( 'Authors', 'dslc_string' ),
			'value' => 'publish_posts'
		),
		array(
			'label' => __( 'Contributors', 'dslc_string' ),
			'value' => 'edit_posts'
		),
	);

	$dslc_plugin_options['dslc_plugin_options_access_control'] = array(
		'title' => __( 'Access Control', 'dslc_string' ),
		'options' => array(
			'lc_min_capability_page' => array(
				'label' => __( 'Front-End Editor', 'dslc_string' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can use Live Composer in the front-end? This will also affect who can manage post templates.', 'dslc_string' ),
				'choices' => $capability_opts
			),
			'lc_min_capability_projects_m' => array(
				'label' => __( 'Projects Management', 'dslc_string' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage projects ( add, edit, trash... )?', 'dslc_string' ),
				'choices' => $capability_opts
			),
			'lc_min_capability_galleries_m' => array(
				'label' => __( 'Galleries Management', 'dslc_string' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage galleries ( add, edit, trash... )?', 'dslc_string' ),
				'choices' => $capability_opts
			),
			'lc_min_capability_staff_m' => array(
				'label' => __( 'Staff Management', 'dslc_string' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage staff ( add, edit, trash... )?', 'dslc_string' ),
				'choices' => $capability_opts
			),
			'lc_min_capability_downloads_m' => array(
				'label' => __( 'Downloads Management', 'dslc_string' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage downloads ( add, edit, trash... )?', 'dslc_string' ),
				'choices' => $capability_opts
			),
			'lc_min_capability_testimonials_m' => array(
				'label' => __( 'Testimonials Management', 'dslc_string' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage testimonials ( add, edit, trash... )?', 'dslc_string' ),
				'choices' => $capability_opts
			),
			'lc_min_capability_partners_m' => array(
				'label' => __( 'Partners Management', 'dslc_string' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage partners ( add, edit, trash... )?', 'dslc_string' ),
				'choices' => $capability_opts
			),
		)
	);

} add_action( 'dslc_hook_register_options', 'dslc_access_control_init' );