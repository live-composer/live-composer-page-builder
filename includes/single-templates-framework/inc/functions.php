<?php

/**
 * "st" in function names stands for "single template", that's what the functions are related to
 */

function dslc_st_init() {

	$capability = dslc_get_option( 'lc_min_capability_page', 'dslc_plugin_options_access_control' );
	if ( ! $capability ) $capability = 'publish_posts';

	register_post_type( 'dslc_templates', array(
		'menu_icon' => 'dashicons-admin-page',
		'labels' => array(
			'name' => __( 'Templates', 'dslc_string' ),
			'singular_name' => __( 'Template', 'dslc_string' ),
			'add_new' => __( 'Add Template', 'dslc_string' ),
			'add_new_item' => __( 'Add Template', 'dslc_string' ),
			'edit' => __( 'Edit', 'dslc_string' ),
			'edit_item' => __( 'Edit Template', 'dslc_string' ),
			'new_item' => __( 'New Template', 'dslc_string' ),
			'view' => __( 'View Templates', 'dslc_string' ),
			'view_item' => __( 'View Template', 'dslc_string' ),
			'search_items' => __( 'Search Templates', 'dslc_string' ),
			'not_found' => __( 'No Templates found', 'dslc_string' ),
			'not_found_in_trash' => __( 'No Templates found in Trash', 'dslc_string' ),
			'parent' => __( 'Parent Template', 'dslc_string' ),
		),
		'public' => true,
		'supports' => array( 'title', 'custom-fields', 'thumbnail' ),
		'capabilities' => array(
			'publish_posts' => $capability,
			'edit_posts' => $capability,
			'edit_others_posts' => $capability,
			'delete_posts' => $capability,
			'delete_others_posts' => $capability,
			'read_private_posts' => $capability,
			'edit_post' => $capability,
			'delete_post' => $capability,
			'read_post' => $capability
		),
	));

	global $dslc_var_post_options;
	
	// Generate the choices
	global $dslc_var_templates_pt;
	$pt_choices = array();
	foreach ( $dslc_var_templates_pt as $pt_id => $pt_label ) {
		$pt_choices[] = array(
			'label' => $pt_label,
			'value' => $pt_id
		);
	}

	$dslc_var_post_options['dslc-templates-opts'] = array(
		'title' => 'Template Options',
		'show_on' => 'dslc_templates',
		'options' => array(
			array(
				'label' => __( 'Post Type', 'dslc_string' ),
				'descr' => __( 'Which post type is this template for?', 'dslc_string' ),
				'std' => '',
				'id' => 'dslc_template_for',
				'type' => 'select',
				'choices' => $pt_choices
			),
			array(
				'label' => __( 'Base', 'dslc_string' ),
				'descr' => __( 'If set to <strong>theme template</strong> the template will be appeneded to the regular single post template ( ex. If the theme shows thumbnail and title in it\'s template they will still be there ). If set to <strong>plugin template</strong> everything will be stripped and only the content from this template shown.', 'dslc_string' ),
				'std' => 'theme',
				'id' => 'dslc_template_base',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Theme Template',
						'value' => 'theme'
					),
					array(
						'label' => 'Custom Template',
						'value' => 'custom'
					),
				)
			),
			array(
				'label' => __( 'Type', 'dslc_string' ),
				'std' => 'regular',
				'descr' => __( '<strong>Default</strong> template will be used as the default for all the posts. <strong>Regular</strong> template is an additional template that you can set to specific posts.', 'dslc_string' ),
				'id' => 'dslc_template_type',
				'type' => 'radio',
				'choices' => array(
					array(
						'label' => 'Regular',
						'value' => 'regular'
					),
					array(
						'label' => 'Default',
						'value' => 'default'
					),
				)
			),
		)
	);

} add_action( 'init', 'dslc_st_init' );

/**
 * Get the template ID of a specific post
 *
 * @since 1.0
 */

function dslc_st_get_template_ID( $post_ID ) {

	// Get the template ID set for the post ( returns false if not set )
	$template = get_post_meta( $post_ID, 'dslc_post_template', true );

	// If no template set, make it "default"
	if ( ! $template ) {
		$template = 'default';
	}

	// Default template supplied, find it and return the ID
	if ( $template == 'default' ) {

		// Query for default template
		$args = array(
			'post_type' => 'dslc_templates',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'meta_query' => array(
				array (
					'key' => 'dslc_template_for',
					'value' => get_post_type( $post_ID ),
					'compare' => '=',
				),
				array (
					'key' => 'dslc_template_type',
					'value' => 'default',
					'compare' => '=',
				),
			),
			'order' => 'DESC'
		);
		$tpls = get_posts( $args );

		// If default template found set the ID if not make it false
		if ( $tpls ) 
			$template_ID = $tpls[0]->ID;
		else
			$template_ID = false;

	// Specific template supplied, return the ID
	} elseif ( $template ) {

		$template_ID = $template;

	}

	// Return the template ID
	return $template_ID;

}