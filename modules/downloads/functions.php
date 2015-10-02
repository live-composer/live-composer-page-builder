<?php

include DS_LIVE_COMPOSER_ABS . '/modules/downloads/inc/ajax.php';

function dslc_downloads_module_init() {

	if ( ! dslc_is_module_active( 'DSLC_Downloads', true ) )
		return;
	
	$capability = dslc_get_option( 'lc_min_capability_downloads_m', 'dslc_plugin_options_access_control' );
	if ( ! $capability ) $capability = 'publish_posts';

	// With Front
	$with_front = dslc_get_option( 'with_front', 'dslc_plugin_options_cpt_slugs' );
	if ( empty ( $with_front )  ) $with_front = 'disabled';
	if ( $with_front == 'enabled' ) $with_front = true; else $with_front = false;

	/**
	 * Custom Post Type
	 */

	register_post_type( 'dslc_downloads', array(
		'menu_icon' => 'dashicons-download',
		'labels' => array(
			'name' => __( 'Downloads', 'live-composer-page-builder' ),
			'singular_name' => __( 'Download Item', 'live-composer-page-builder' ),
			'add_new' => __( 'Add Download Item', 'live-composer-page-builder' ),
			'add_new_item' => __( 'Add Download Item', 'live-composer-page-builder' ),
			'edit' => __( 'Edit', 'live-composer-page-builder' ),
			'edit_item' => __( 'Edit Download Item', 'live-composer-page-builder' ),
			'new_item' => __( 'New Download Item', 'live-composer-page-builder' ),
			'view' => __( 'View Download Item', 'live-composer-page-builder' ),
			'view_item' => __( 'View Download Item', 'live-composer-page-builder' ),
			'search_items' => __( 'Search Download Item', 'live-composer-page-builder' ),
			'not_found' => __( 'No Download Item found', 'live-composer-page-builder' ),
			'not_found_in_trash' => __( 'No Download Item found in Trash', 'live-composer-page-builder' ),
			'parent' => __( 'Parent Download Item', 'live-composer-page-builder' ),
		),
		'public' => true,
		'rewrite' => array( 'slug' => dslc_get_option( 'downloads_slug', 'dslc_plugin_options_cpt_slugs' ), 'with_front' => $with_front ),
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
	
	/**
	 * Custom Taxonomies
	 */

	register_taxonomy(
		'dslc_downloads_cats', 
		'dslc_downloads', 
		array( 
			'labels' => array(
				'name' => __( 'Downloads Categories', 'live-composer-page-builder' ),
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
				'slug' => dslc_get_option( 'downloads_cats_slug', 'dslc_plugin_options_cpt_slugs' ),
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

	register_taxonomy(
		'dslc_downloads_tags', 
		'dslc_downloads', 
		array( 
			'labels' => array(
				'name' => __( 'Downloads Tags', 'live-composer-page-builder' ),
				'singular_name' => __( 'Tag', 'live-composer-page-builder' ),
				'search_items'  => __( 'Search Tags', 'live-composer-page-builder' ),
				'all_items' => __( 'All Tags', 'live-composer-page-builder' ),
				'parent_item' => __( 'Parent Tag', 'live-composer-page-builder' ),
				'parent_item_colon' => __( 'Parent Tag:', 'live-composer-page-builder' ),
				'edit_item' => __( 'Edit Tag', 'live-composer-page-builder' ),
				'update_item' => __( 'Update Tag', 'live-composer-page-builder' ),
				'add_new_item' => __( 'Add New Tag', 'live-composer-page-builder' ),
				'new_item_name' => __( 'New Tag Name', 'live-composer-page-builder' ),
				'menu_name' => __( 'Tags', 'live-composer-page-builder' ),
			),
			'hierarchical' => false, 
			'public' => true, 
			'rewrite' => array( 
				'slug' => dslc_get_option( 'downloads_tags_slug', 'dslc_plugin_options_cpt_slugs' ),
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

	/**
	 * Post Options
	 */

	global $dslc_var_post_options;
	$dslc_var_post_options['dslc-downloads-module-options'] = array(
		'title' => 'Download Options',
		'show_on' => 'dslc_downloads',
		'options' => array(
			array(
				'label' => 'Downloadable File - Self Hosted',
				'descr' => 'If you want the file hosted on your server you can upload and choose it here.',
				'std' => '',
				'id' => 'dslc_download_file',
				'type' => 'file',
			),
			array(
				'label' => 'Downloadable File - URL',
				'descr' => 'If the file is already hosted somewhere else you can set the URL to it here.',
				'std' => '',
				'id' => 'dslc_download_url',
				'type' => 'text',
			),
		)
	);

} add_action( 'init', 'dslc_downloads_module_init' );