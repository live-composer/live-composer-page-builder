<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

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
	),
);

/**
 * Register Post Type and Taxonomies
 *
 * @since 1.0
 */
function dslc_projects_module_cpt() {

	// If module not active return
	if ( ! dslc_is_module_active( 'DSLC_Projects', true ) ) {
		return;
	}

	// Get capability
	$capability = dslc_get_option( 'lc_min_capability_projects_m', 'dslc_plugin_options_access_control' );
	if ( ! $capability ) { $capability = 'publish_posts';
	}

	// With Front
	$with_front = dslc_get_option( 'with_front', 'dslc_plugin_options_cpt_slugs' );
	if ( empty( $with_front ) ) { $with_front = 'disabled';
	}
	if ( $with_front == 'enabled' ) { $with_front = true;
	} else { $with_front = false;
	}

	/**
	 * Register Post Type
	 */

	// Arguments
	$cpt_args = array(
		'menu_icon' => 'dashicons-feedback',
		'labels' => array(
			'name' => __( 'Projects', 'live-composer-page-builder' ),
			'singular_name' => __( 'Project', 'live-composer-page-builder' ),
			'add_new' => __( 'Add Project', 'live-composer-page-builder' ),
			'add_new_item' => __( 'Add Project', 'live-composer-page-builder' ),
			'edit' => __( 'Edit', 'live-composer-page-builder' ),
			'edit_item' => __( 'Edit Project', 'live-composer-page-builder' ),
			'new_item' => __( 'New Project', 'live-composer-page-builder' ),
			'view' => __( 'View Project', 'live-composer-page-builder' ),
			'view_item' => __( 'View Project', 'live-composer-page-builder' ),
			'search_items' => __( 'Search Project', 'live-composer-page-builder' ),
			'not_found' => __( 'No Project found', 'live-composer-page-builder' ),
			'not_found_in_trash' => __( 'No Project found in Trash', 'live-composer-page-builder' ),
			'parent' => __( 'Parent Project', 'live-composer-page-builder' ),
		),
		'public' => true,
		'rewrite' => array(
			'slug' => dslc_get_option( 'projects_slug', 'dslc_plugin_options_cpt_slugs' ),
			'with_front' => $with_front,
		),
		'supports' => array( 'title', 'custom-fields', 'excerpt', 'editor', 'author', 'thumbnail', 'comments' ),
		'capabilities' => array(
			'publish_posts' => $capability,
			'edit_posts' => $capability,
			'edit_others_posts' => $capability,
			'delete_posts' => $capability,
			'delete_others_posts' => $capability,
			'read_private_posts' => $capability,
			'edit_post' => $capability,
			'delete_post' => $capability,
			'read_post' => $capability,
		),
	);

	// Apply filters
	$cpt_args = apply_filters( 'dslc_projects_cpt_args', $cpt_args );

	// Register Post Type
	register_post_type( 'dslc_projects', $cpt_args );

	/**
	 * Register Taxonomy ( Category )
	 */

	// Arguments
	$tax_args = array(
		'labels' => array(
			'name' => __( 'Projects Categories', 'live-composer-page-builder' ),
			'singular_name' => __( 'Category', 'live-composer-page-builder' ),
			'search_items'  => __( 'Search Categories', 'live-composer-page-builder' ),
			'all_items' => __( 'All Categories', 'live-composer-page-builder' ),
			'parent_item' => __( 'Parent Category', 'live-composer-page-builder' ),
			'parent_item_colon' => __( 'Parent Category:', 'live-composer-page-builder' ),
			'edit_item' => __( 'Edit Category', 'live-composer-page-builder' ),
			'update_item' => __( 'Update Category', 'live-composer-page-builder' ),
			'add_new_item' => __( 'Add New Category', 'live-composer-page-builder' ),
			'new_item_name' => __( 'New Category Name', 'live-composer-page-builder' ),
			'menu_name' => __( 'Categories', 'live-composer-page-builder' ),
		),
		'hierarchical' => true,
		'public' => true,
		'rewrite' => array(
			'slug' => dslc_get_option( 'projects_cats_slug', 'dslc_plugin_options_cpt_slugs' ),
			'with_front' => $with_front,
		),
		'capabilities' => array(
			'manage_terms' => $capability,
			'edit_terms' => $capability,
			'delete_terms' => $capability,
			'assign_terms' => $capability,
		),
	);

	// Apply filters
	$tax_args = apply_filters( 'dslc_projects_cats_args', $tax_args );

	// Register Taxonomy
	register_taxonomy( 'dslc_projects_cats', 'dslc_projects', $tax_args );

} add_action( 'init', 'dslc_projects_module_cpt' );
