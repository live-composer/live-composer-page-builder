<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

global $dslc_var_post_options;

$dslc_var_post_options['dslc-partners-post-options'] = array(
	'title' => 'Partner Options',
	'show_on' => 'dslc_partners',
	'options' => array(
		array(
			'label' => 'Partner URL',
			'std' => '',
			'id' => 'dslc_partner_url',
			'type' => 'text',
		),
	),
);

/**
 * Register Post Types and Taxonomies
 *
 * @since 1.0
 */
function dslc_partners_module_cpt() {

	// If module not active return
	if ( ! dslc_is_module_active( 'DSLC_Partners', true ) ) {
		return;
	}

	// Get capability
	$capability = dslc_get_option( 'lc_min_capability_partners_m', 'dslc_plugin_options_access_control' );
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
		'menu_icon' => 'dashicons-groups',
		'labels' => array(
			'name' => __( 'Partners', 'live-composer-page-builder' ),
			'singular_name' => __( 'Partner', 'live-composer-page-builder' ),
			'add_new' => __( 'Add Partner', 'live-composer-page-builder' ),
			'add_new_item' => __( 'Add Partner', 'live-composer-page-builder' ),
			'edit' => __( 'Edit', 'live-composer-page-builder' ),
			'edit_item' => __( 'Edit Partner', 'live-composer-page-builder' ),
			'new_item' => __( 'New Partner', 'live-composer-page-builder' ),
			'view' => __( 'View Partner', 'live-composer-page-builder' ),
			'view_item' => __( 'View Partner', 'live-composer-page-builder' ),
			'search_items' => __( 'Search Partner', 'live-composer-page-builder' ),
			'not_found' => __( 'No Partner found', 'live-composer-page-builder' ),
			'not_found_in_trash' => __( 'No Partner found in Trash', 'live-composer-page-builder' ),
			'parent' => __( 'Parent Partner', 'live-composer-page-builder' ),
		),
		'public' => true,
		'rewrite' => array(
			'slug' => dslc_get_option( 'partners_slug', 'dslc_plugin_options_cpt_slugs' ),
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
	$cpt_args = apply_filters( 'dslc_partners_cpt_args', $cpt_args );

	// Register post type
	register_post_type( 'dslc_partners', $cpt_args );

	/**
	 * Register Taxonomy ( Category )
	 */

	// Arguments
	$cats_args = array(
		'labels' => array(
			'name' => __( 'Partners Categories', 'live-composer-page-builder' ),
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
			'slug' => dslc_get_option( 'partners_cats_slug', 'dslc_plugin_options_cpt_slugs' ),
			'with_front' => $with_front,
		),
	);

	// Apply filters
	$cats_args = apply_filters( 'dslc_partners_cats_args', $cats_args );

	// Register taxonomy
	register_taxonomy( 'dslc_partners_cats', 'dslc_partners', $cats_args );

} add_action( 'init', 'dslc_partners_module_cpt' );
