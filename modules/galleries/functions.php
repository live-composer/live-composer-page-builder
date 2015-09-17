<?php

global $dslc_var_post_options;

$dslc_var_post_options['dslc-gallery-post-options'] = array(
	'title' => 'Gallery Options',
	'show_on' => 'dslc_galleries',
	'options' => array(
		array(
			'label' => 'Images',
			'descr' => __( 'These images can be displayed on single gallery post pages using "Gallery Slider" module.', 'dslc_string' ),
			'std' => '',
			'id' => 'dslc_gallery_images',
			'type' => 'files',
		),
		array(
			'label' => 'Custom URL',
			'descr' => __( 'By default links in the "Galleries" module will link to single gallery post page. If you want them to go to a custom URL, enter it here.', 'dslc_string' ),
			'std' => '',
			'id' => 'dslc_custom_url',
			'type' => 'text',
		),
	)
);

function dslc_galleries_module_cpt() {

	if ( ! dslc_is_module_active( 'DSLC_Galleries', true ) )
		return;

	$capability = dslc_get_option( 'lc_min_capability_galleries_m', 'dslc_plugin_options_access_control' );
	if ( ! $capability ) $capability = 'publish_posts';

	// With Front
	$with_front = dslc_get_option( 'with_front', 'dslc_plugin_options_cpt_slugs' );
	if ( empty ( $with_front )  ) $with_front = 'disabled';
	if ( $with_front == 'enabled' ) $with_front = true; else $with_front = false;

	register_post_type( 'dslc_galleries', array(
		'menu_icon' => 'dashicons-format-gallery',
		'labels' => array(
			'name' => __( 'Galleries', 'dslc_string' ),
			'singular_name' => __( 'Add Gallery', 'dslc_string' ),
			'add_new' => __( 'Add Gallery', 'dslc_string' ),
			'add_new_item' => __( 'Add Gallery', 'dslc_string' ),
			'edit' => __( 'Edit', 'dslc_string' ),
			'edit_item' => __( 'Edit Gallery', 'dslc_string' ),
			'new_item' => __( 'New Gallery', 'dslc_string' ),
			'view' => __( 'View Gallery', 'dslc_string' ),
			'view_item' => __( 'View Gallery', 'dslc_string' ),
			'search_items' => __( 'Search Gallery', 'dslc_string' ),
			'not_found' => __( 'No Gallery found', 'dslc_string' ),
			'not_found_in_trash' => __( 'No Gallery found in Trash', 'dslc_string' ),
			'parent' => __( 'Parent Gallery', 'dslc_string' ),
		),
		'public' => true,
		'rewrite' => array( 'slug' => dslc_get_option( 'galleries_slug', 'dslc_plugin_options_cpt_slugs' ), 'with_front' => $with_front ),
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
			'read_post' => $capability
		),
	));
	
	register_taxonomy(
		'dslc_galleries_cats', 
		'dslc_galleries', 
		array(
			'labels' => array(
				'name' => __( 'Galleries Categories', 'dslc_string' ),
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
				'slug' => dslc_get_option( 'galleries_cats_slug', 'dslc_plugin_options_cpt_slugs' ),
				'with_front' => $with_front
			) 
		)
	);

} add_action( 'init', 'dslc_galleries_module_cpt' );