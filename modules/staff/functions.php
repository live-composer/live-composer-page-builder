<?php

global $dslc_var_post_options;

$dslc_var_post_options['dslc-staff-post-options'] = array(
	'title' => 'Staff Member Options',
	'show_on' => 'dslc_staff',
	'options' => array(
		array(
			'label' => 'Position',
			'std' => '',
			'id' => 'dslc_staff_position',
			'type' => 'text',
		),
		array(
			'label' => 'Social - Twitter',
			'std' => '',
			'id' => 'dslc_staff_social_twitter',
			'type' => 'text',
		),
		array(
			'label' => 'Social - Facebook',
			'std' => '',
			'id' => 'dslc_staff_social_facebook',
			'type' => 'text',
		),
		array(
			'label' => 'Social - GooglePlus',
			'std' => '',
			'id' => 'dslc_staff_social_googleplus',
			'type' => 'text',
		),
		array(
			'label' => 'Social - LinkedIn',
			'std' => '',
			'id' => 'dslc_staff_social_linkedin',
			'type' => 'text',
		),
		array(
			'label' => 'Social - Email',
			'std' => '',
			'id' => 'dslc_staff_social_email',
			'type' => 'text',
		)
	)
);

function dslc_staff_module_cpt() {

	if ( ! dslc_is_module_active( 'DSLC_Staff', true ) )
		return;

	$capability = dslc_get_option( 'lc_min_capability_staff_m', 'dslc_plugin_options_access_control' );
	if ( ! $capability ) $capability = 'publish_posts';

	// With Front
	$with_front = dslc_get_option( 'with_front', 'dslc_plugin_options_cpt_slugs' );
	if ( empty ( $with_front )  ) $with_front = 'disabled';
	if ( $with_front == 'enabled' ) $with_front = true; else $with_front = false;

	register_post_type( 'dslc_staff', array(
		'menu_icon' => 'dashicons-id',
		'labels' => array(
			'name' => __( 'Staff', 'live-composer-page-builder' ),
			'singular_name' => __( 'Staff Member', 'live-composer-page-builder' ),
			'add_new' => __( 'Add Staff', 'live-composer-page-builder' ),
			'add_new_item' => __( 'Add Staff Member', 'live-composer-page-builder' ),
			'edit' => __( 'Edit Staff', 'live-composer-page-builder' ),
			'edit_item' => __( 'Edit Staff Member', 'live-composer-page-builder' ),
			'new_item' => __( 'New Staff Member', 'live-composer-page-builder' ),
			'view' => __( 'View Staff', 'live-composer-page-builder' ),
			'view_item' => __( 'View Staff Member', 'live-composer-page-builder' ),
			'search_items' => __( 'Search Staff', 'live-composer-page-builder' ),
			'not_found' => __( 'No Staff found', 'live-composer-page-builder' ),
			'not_found_in_trash' => __( 'No Staff found in Trash', 'live-composer-page-builder' ),
			'parent' => __( 'Parent Staff Member', 'live-composer-page-builder' ),
		),
		'public' => true,
		'rewrite' => array( 'slug' => dslc_get_option( 'staff_slug', 'dslc_plugin_options_cpt_slugs' ), 'with_front' => $with_front ),
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
		'dslc_staff_cats', 
		'dslc_staff', 
		array( 
			'labels' => array(
				'name' => __( 'Staff Categories', 'live-composer-page-builder' ),
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
				'slug' => dslc_get_option( 'staff_cats_slug', 'dslc_plugin_options_cpt_slugs' ),
				'with_front' => $with_front
			)
		)
	);

} add_action( 'init', 'dslc_staff_module_cpt' );