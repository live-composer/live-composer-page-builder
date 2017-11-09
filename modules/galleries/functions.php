<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

global $dslc_var_post_options;

$dslc_var_post_options['dslc-gallery-post-options'] = array(
	'title' => 'Gallery Options',
	'show_on' => 'dslc_galleries',
	'options' => array(
		array(
			'label' => 'Images',
			'descr' => __( 'These images can be displayed on single gallery post pages using "Gallery Slider" module.', 'live-composer-page-builder' ),
			'std' => '',
			'id' => 'dslc_gallery_images',
			'type' => 'files',
		),
		array(
			'label' => 'Custom URL',
			'descr' => __( 'By default links in the "Galleries" module will link to single gallery post page. If you want them to go to a custom URL, enter it here.', 'live-composer-page-builder' ),
			'std' => '',
			'id' => 'dslc_custom_url',
			'type' => 'text',
		),
	),
);

/**
 * Register Post Type and Taxonomies
 *
 * @since 1.0
 */
function dslc_galleries_module_cpt() {

	// If module not active return
	if ( ! dslc_is_module_active( 'DSLC_Galleries', true ) ) {
		return;
	}

	// Get capability
	$capability = dslc_get_option( 'lc_min_capability_galleries_m', 'dslc_plugin_options_access_control' );
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
		'menu_icon' => 'dashicons-format-gallery',
		'labels' => array(
			'name' => __( 'Galleries', 'live-composer-page-builder' ),
			'singular_name' => __( 'Add Gallery', 'live-composer-page-builder' ),
			'add_new' => __( 'Add Gallery', 'live-composer-page-builder' ),
			'add_new_item' => __( 'Add Gallery', 'live-composer-page-builder' ),
			'edit' => __( 'Edit', 'live-composer-page-builder' ),
			'edit_item' => __( 'Edit Gallery', 'live-composer-page-builder' ),
			'new_item' => __( 'New Gallery', 'live-composer-page-builder' ),
			'view' => __( 'View Gallery', 'live-composer-page-builder' ),
			'view_item' => __( 'View Gallery', 'live-composer-page-builder' ),
			'search_items' => __( 'Search Gallery', 'live-composer-page-builder' ),
			'not_found' => __( 'No Gallery found', 'live-composer-page-builder' ),
			'not_found_in_trash' => __( 'No Gallery found in Trash', 'live-composer-page-builder' ),
			'parent' => __( 'Parent Gallery', 'live-composer-page-builder' ),
		),
		'public' => true,
		'rewrite' => array(
			'slug' => dslc_get_option( 'galleries_slug', 'dslc_plugin_options_cpt_slugs' ),
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
	$cpt_args = apply_filters( 'dslc_galleries_cpt_args', $cpt_args );

	// Register post type
	register_post_type( 'dslc_galleries', $cpt_args );

	/**
	 * Register Taxonomy ( Category )
	 */

	// Arguments
	$cats_args = array(
		'labels' => array(
			'name' => __( 'Galleries Categories', 'live-composer-page-builder' ),
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
			'slug' => dslc_get_option( 'galleries_cats_slug', 'dslc_plugin_options_cpt_slugs' ),
			'with_front' => $with_front,
		),
	);

	// Apply filters
	$cats_args = apply_filters( 'dslc_galleries_cats_args', $cats_args );

	// Register taxonomy
	register_taxonomy( 'dslc_galleries_cats', 'dslc_galleries', $cats_args );

} add_action( 'init', 'dslc_galleries_module_cpt' );
