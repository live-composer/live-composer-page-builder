<?php

/**
 * Table of Contents
 *
 * dslc_access_control_init ( Register options )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Register options
 *
 * @since 1.0
 */

function dslc_access_control_init() {

	global $dslc_plugin_options;

	$capability_opts = array(
		array(
			'label' => __( 'Administrators', 'live-composer-page-builder' ),
			'value' => 'manage_options'
		),
		array(
			'label' => __( 'Editors', 'live-composer-page-builder' ),
			'value' => 'publish_pages'
		),
		array(
			'label' => __( 'Authors', 'live-composer-page-builder' ),
			'value' => 'publish_posts'
		),
		array(
			'label' => __( 'Contributors', 'live-composer-page-builder' ),
			'value' => 'edit_posts'
		),
	);

	$dslc_plugin_options['dslc_plugin_options_access_control'] = array(
		'title' => __( 'Access Control', 'live-composer-page-builder' ),
		'options' => array(

			'lc_min_capability_page' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Front-End Editor', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can use Live Composer in the front-end? This will also affect who can manage post templates.', 'live-composer-page-builder' ),
				'choices' => $capability_opts
			),

			'lc_min_capability_projects_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Projects Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage projects ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts
			),

			'lc_min_capability_galleries_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Galleries Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage galleries ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts
			),

			'lc_min_capability_staff_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Staff Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage staff ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts
			),

			'lc_min_capability_downloads_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Downloads Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage downloads ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts
			),

			'lc_min_capability_testimonials_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Testimonials Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage testimonials ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts
			),

			'lc_min_capability_partners_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Partners Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage partners ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts
			)
		)
	);

} add_action( 'dslc_hook_register_options', 'dslc_access_control_init' );