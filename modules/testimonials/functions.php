<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

global $dslc_var_post_options;

$dslc_var_post_options['dslc-testimonials-post-options'] = array(
	'title' => 'Testimonial Options',
	'show_on' => 'dslc_testimonials',
	'options' => array(
		array(
			'label' => 'Position',
			'std' => '',
			'id' => 'dslc_testimonial_author_pos',
			'type' => 'text',
		),
		array(
			'label' => 'Logo',
			'std' => '',
			'id' => 'dslc_testimonial_logo',
			'type' => 'file',
		),
	),
);

/**
 * Register Post Type and Taxonomies
 *
 * @since 1.0
 */
function dslc_testimonials_module_cpt() {

	// If module not active return
	if ( ! dslc_is_module_active( 'DSLC_Testimonials', true ) ) {
		return;
	}

	// Get capability
	$capability = dslc_get_option( 'lc_min_capability_testimonials_m', 'dslc_plugin_options_access_control' );
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
		'menu_icon' => 'dashicons-format-quote',
		'labels' => array(
			'name' => __( 'Testimonials', 'live-composer-page-builder' ),
			'singular_name' => __( 'Testimonial', 'live-composer-page-builder' ),
			'add_new' => __( 'Add Testimonial', 'live-composer-page-builder' ),
			'add_new_item' => __( 'Add Testimonial', 'live-composer-page-builder' ),
			'edit' => __( 'Edit', 'live-composer-page-builder' ),
			'edit_item' => __( 'Edit Testimonial', 'live-composer-page-builder' ),
			'new_item' => __( 'New Testimonial', 'live-composer-page-builder' ),
			'view' => __( 'View Testimonial', 'live-composer-page-builder' ),
			'view_item' => __( 'View Testimonial', 'live-composer-page-builder' ),
			'search_items' => __( 'Search Testimonials', 'live-composer-page-builder' ),
			'not_found' => __( 'No Testimonials found', 'live-composer-page-builder' ),
			'not_found_in_trash' => __( 'No Testimonials found in Trash', 'live-composer-page-builder' ),
			'parent' => __( 'Parent Testimonial', 'live-composer-page-builder' ),
		),
		'publicly_queryable'  => false,
		'public' => true,
		'rewrite' => array(
			'slug' => dslc_get_option( 'testimonials_slug', 'dslc_plugin_options_cpt_slugs' ),
			'with_front' => $with_front,
		),
		'supports' => array( 'title', 'custom-fields', 'excerpt', 'editor', 'author', 'thumbnail' ),
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
	$cpt_args = apply_filters( 'dslc_testimonials_cpt_args', $cpt_args );

	// Register post type
	register_post_type( 'dslc_testimonials', $cpt_args );

	/**
	 * Register Taxonomy ( Category )
	 */

	// Arguments
	$cats_args = array(
		'labels' => array(
			'name' => __( 'Testimonials Categories', 'live-composer-page-builder' ),
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
			'slug' => dslc_get_option( 'testimonials_cats_slug', 'dslc_plugin_options_cpt_slugs' ),
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
	$cats_args = apply_filters( 'dslc_testimonials_cats_args', $cats_args );

	// Register taxonomy
	register_taxonomy( 'dslc_testimonials_cats', 'dslc_testimonials', $cats_args );

} add_action( 'init', 'dslc_testimonials_module_cpt' );