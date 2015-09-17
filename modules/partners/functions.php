<?php

function dslc_partners_module_cpt() {

	if ( ! dslc_is_module_active( 'DSLC_Partners', true ) )
		return;

	$capability = dslc_get_option( 'lc_min_capability_partners_m', 'dslc_plugin_options_access_control' );
	if ( ! $capability ) $capability = 'publish_posts';

	// With Front
	$with_front = dslc_get_option( 'with_front', 'dslc_plugin_options_cpt_slugs' );
	if ( empty ( $with_front )  ) $with_front = 'disabled';
	if ( $with_front == 'enabled' ) $with_front = true; else $with_front = false;

	register_post_type( 'dslc_partners', array(
		'menu_icon' => 'dashicons-groups',
		'labels' => array(
			'name' => __( 'Partners', 'dslc_string' ),
			'singular_name' => __( 'Partner', 'dslc_string' ),
			'add_new' => __( 'Add Partner', 'dslc_string' ),
			'add_new_item' => __( 'Add Partner', 'dslc_string' ),
			'edit' => __( 'Edit', 'dslc_string' ),
			'edit_item' => __( 'Edit Partner', 'dslc_string' ),
			'new_item' => __( 'New Partner', 'dslc_string' ),
			'view' => __( 'View Partner', 'dslc_string' ),
			'view_item' => __( 'View Partner', 'dslc_string' ),
			'search_items' => __( 'Search Partner', 'dslc_string' ),
			'not_found' => __( 'No Partner found', 'dslc_string' ),
			'not_found_in_trash' => __( 'No Partner found in Trash', 'dslc_string' ),
			'parent' => __( 'Parent Partner', 'dslc_string' ),
		),
		'public' => true,
		'rewrite' => array( 'slug' => dslc_get_option( 'partners_slug', 'dslc_plugin_options_cpt_slugs' ), 'with_front' => $with_front ),
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
		'dslc_partners_cats', 
		'dslc_partners', 
		array( 
			'labels' => array(
				'name' => __( 'Partners Categories', 'dslc_string' ),
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
				'slug' => dslc_get_option( 'partners_cats_slug', 'dslc_plugin_options_cpt_slugs' ),
				'with_front' => $with_front
			)
		)
	);

} add_action( 'init', 'dslc_partners_module_cpt' );