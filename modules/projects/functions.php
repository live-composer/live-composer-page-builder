<?php

global $dslc_var_post_options;

$dslc_var_post_options['dslc-projects-post-options'] = array(
	'title' => 'Project Options',
	'show_on' => 'dslc_projects',
	'options' => array(
		array(
			'label' => 'Project URL',
			'std' => '',
			'id' => 'dslc_project_url',
			'type' => 'text',
		),
		array(
			'label' => 'Images',
			'descr' => 'These images can be shown using the "Project Images Slider" module.',
			'std' => '',
			'id' => 'dslc_project_images',
			'type' => 'files',
		),
	)
);

function dslc_projects_module_cpt() {

	if ( ! dslc_is_module_active( 'DSLC_Projects', true ) )
		return;

	$capability = dslc_get_option( 'lc_min_capability_projects_m', 'dslc_plugin_options_access_control' );
	if ( ! $capability ) $capability = 'publish_posts';

	// With Front
	$with_front = dslc_get_option( 'with_front', 'dslc_plugin_options_cpt_slugs' );
	if ( empty ( $with_front )  ) $with_front = 'disabled';
	if ( $with_front == 'enabled' ) $with_front = true; else $with_front = false;

	register_post_type( 'dslc_projects', array(
		'menu_icon' => 'dashicons-feedback',
		'labels' => array(
			'name' => __( 'Projects', 'dslc_string' ),
			'singular_name' => __( 'Project', 'dslc_string' ),
			'add_new' => __( 'Add Project', 'dslc_string' ),
			'add_new_item' => __( 'Add Project', 'dslc_string' ),
			'edit' => __( 'Edit', 'dslc_string' ),
			'edit_item' => __( 'Edit Project', 'dslc_string' ),
			'new_item' => __( 'New Project', 'dslc_string' ),
			'view' => __( 'View Project', 'dslc_string' ),
			'view_item' => __( 'View Project', 'dslc_string' ),
			'search_items' => __( 'Search Project', 'dslc_string' ),
			'not_found' => __( 'No Project found', 'dslc_string' ),
			'not_found_in_trash' => __( 'No Project found in Trash', 'dslc_string' ),
			'parent' => __( 'Parent Project', 'dslc_string' ),
		),
		'public' => true,
		'rewrite' => array( 'slug' => dslc_get_option( 'projects_slug', 'dslc_plugin_options_cpt_slugs' ), 'with_front' => $with_front ),
		'supports' => array( 'title', 'custom-fields', 'excerpt', 'editor', 'author', 'thumbnail', 'comments'  ),
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
	
	register_taxonomy(
		'dslc_projects_cats', 
		'dslc_projects', 
		array( 
			'labels' => array(
				'name' => __( 'Projects Categories', 'dslc_string' ),
				'singular_name' => __( 'Category', 'dslc_string' ),
				'search_items'  => __( 'Search Categories', 'dslc_string' ),
				'all_items' => __( 'All Categories', 'dslc_string' ),
				'parent_item' => __( 'Parent Category', 'dslc_string' ),
				'parent_item_colon' => __( 'Parent Category:', 'dslc_string' ),
				'edit_item' => __( 'Edit Category', 'dslc_string' ),
				'update_item' => __( 'Update Category', 'dslc_string' ),
				'add_new_item' => __( 'Add New Category', 'dslc_string' ),
				'new_item_name' => __( 'New Category Name', 'dslc_string' ),
				'menu_name' => __( 'Categories', 'dslc_string' ),
			),
			'hierarchical' => true, 
			'public' => true, 
			'rewrite' => array( 
				'slug' => dslc_get_option( 'projects_cats_slug', 'dslc_plugin_options_cpt_slugs' ),
				'with_front' => $with_front
			), 
			'capabilities' => array(
				'manage_terms' => $capability,
				'edit_terms' => $capability,
				'delete_terms' => $capability,
				'assign_terms' => $capability,
			),
		)
	);

} add_action( 'init', 'dslc_projects_module_cpt' );