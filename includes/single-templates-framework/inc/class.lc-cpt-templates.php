<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * LC_Single_Template_Engine
 *
 * @since 1.1.4
 */
class LC_CPT_Templates {

	/**
	 * Launch all the hooks on class initialization.
	 *
	 * @return void
	 */
	public function __construct() {
		// Register 'dslc_template' CPT and post options.
		add_action( 'init',  array( $this, 'register_dslc_templates_cpt' ), 90 );
	}

	/**
	 * Return Template post ID using indicated method
	 * from context data provided.
	 *
	 * @param  string $method  What method to use.
	 * @param  string $context Data needed to find template.
	 * @return int/boolean     Post ID or false if not found.
	 */
	public function get_template( $method, $context ) {

		$template = false;

		if ( 'by_type' === $method || 'by_option' === $method ) {

			// Get the template ID by post type or by option name.
			$post_type = $context;
			$template = dslc_get_option( $post_type, 'dslc_plugin_options_archives' );

			// Add back-compatability with post archive options without '_archive' suffix.
			if ( ! $template && stristr( $post_type, '_archive' ) ) {
				$template = dslc_get_option( str_replace( '_archive', '', $post_type ), 'dslc_plugin_options_archives' );
			}
		} elseif ( 'by_post' === $method ) {

			// Get the template ID of a specific post.
			$post_id = $context;
			$template_id = false;

			// Get the template ID set for the post ( returns false if not set ).
			$template = get_post_meta( $post_id, 'dslc_post_template', true );

			// If no template set, make it "default".
			if ( ! $template ) {
				$template = 'default';
			}

			// Default template supplied, find it and return the ID.
			if ( 'default' === $template ) {

				// Query for default template.
				$args = array(
					'post_type' => 'dslc_templates',
					'post_status' => 'publish',
					'posts_per_page' => 1,
					'meta_query' => array(
						array(
							'key' => 'dslc_template_for',
							'value' => get_post_type( $post_id ),
							'compare' => '=',
						),
						array(
							'key' => 'dslc_template_type',
							'value' => 'default',
							'compare' => '=',
						),
					),
					'order' => 'DESC',
				);
				$tpls = get_posts( $args );

				// If default template found set the ID if not make it false.
				if ( $tpls ) {
					$template_id = $tpls[0]->ID;
				} else {
					$template_id = false;
				}

			// Specific template supplied, return the ID.
			} elseif ( $template ) {

				$template_id = $template;
			}

			// Return the template ID.
			$template = $template_id;
		}

		return $template;
	}

	/**
	 * Build post options for Live Composer Templates CPT.
	 *
	 * @return void
	 */
	public function register_dslc_templates_cpt() {

		$capability = dslc_get_option( 'lc_min_capability_page', 'dslc_plugin_options_access_control' );
		if ( ! $capability ) { $capability = 'publish_posts'; }

		register_post_type( 'dslc_templates', array(
			'menu_icon' => 'dashicons-admin-page',
			'labels' => array(
				'name' => __( 'Templates', 'live-composer-page-builder' ),
				'menu_name' => __( 'Templates', 'live-composer-page-builder' ),
				'singular_name' => __( 'Template', 'live-composer-page-builder' ),
				'add_new' => __( 'Add Template', 'live-composer-page-builder' ),
				'add_new_item' => __( 'Add Template', 'live-composer-page-builder' ),
				'edit' => __( 'Edit', 'live-composer-page-builder' ),
				'edit_item' => __( 'Edit Template', 'live-composer-page-builder' ),
				'new_item' => __( 'New Template', 'live-composer-page-builder' ),
				'view' => __( 'View Templates', 'live-composer-page-builder' ),
				'view_item' => __( 'View Template', 'live-composer-page-builder' ),
				'search_items' => __( 'Search Templates', 'live-composer-page-builder' ),
				'not_found' => __( 'No Templates found', 'live-composer-page-builder' ),
				'not_found_in_trash' => __( 'No Templates found in Trash', 'live-composer-page-builder' ),
				'parent' => __( 'Parent Template', 'live-composer-page-builder' ),
			),
			'public' => true,
			// 'exclude_from_search' => true, // 404 page is broken with this parameter.
			'publicly_queryable' => true,
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
				'read_post' => $capability,
			),
			'show_in_menu' => 'themes.php',
		) );

		global $dslc_var_post_options;

		// Generate the choices.
		global $dslc_var_templates_pt;

		$pt_choices = array();
		$template_for = array();

		$template_for[] = array(
			'label' => __( 'Single Post Templates:', 'live-composer-page-builder' ),
			'description' => __( 'Design for a single blog post or custom post type entries', 'live-composer-page-builder' ),
			'value' => 'list-heading',
		);

		foreach ( $dslc_var_templates_pt as $pt_id => $pt_label ) {

			$template_for[] = array(
				'label' => $pt_label,
				'value' => $pt_id,
			);
		}

		$template_for[] = array(
			'label' => __( 'Archive Index Templates:', 'live-composer-page-builder' ),
			'description' => __( 'Design for posts listings like Category, Tag, Date or Custom Taxonomies', 'live-composer-page-builder' ),
			'value' => 'list-heading',
		);

		foreach ( $dslc_var_templates_pt as $pt_id => $pt_label ) {

			$template_for[] = array(
				'label' => $pt_label . __( ' (archive)', 'live-composer-page-builder' ),
				'value' => $pt_id . '_archive',
			);
		}

		$template_for[] = array(
			'label' => __( 'Special Page Templates:', 'live-composer-page-builder' ),
			'description' => __( 'Design a custom "Page Not Found" screen or search results page', 'live-composer-page-builder' ),
			'value' => 'list-heading',
		);

		$template_for[] = array(
			'label' => __( '404 Page', 'live-composer-page-builder' ),
			'value' => '404_page',
		);

		$template_for[] = array(
			'label' => __( 'Search Results', 'live-composer-page-builder' ),
			'value' => 'search_results',
		);

		$template_for[] = array(
			'label' => __( 'Author Archives', 'live-composer-page-builder' ),
			'value' => 'author',
		);

		$dslc_var_post_options['dslc-templates-opts'] = array(
			'title' => 'Template Options',
			'show_on' => 'dslc_templates',
			'options' => array(
				array(
					'label' => __( 'Use this template to output...', 'live-composer-page-builder' ),
					// 'descr' => __( '', 'live-composer-page-builder' ),
					'std' => '',
					'id' => 'dslc_template_for',
					'type' => 'checkbox',
					'choices' => $template_for,
				),
				array(
					'label' => __( 'Base', 'live-composer-page-builder' ),
					'descr' => __( 'If set to <strong>theme template</strong> the template will be appeneded to the regular single post template ( ex. If the theme shows thumbnail and title in it\'s template they will still be there ). If set to <strong>plugin template</strong> everything will be stripped and only the content from this template shown.', 'live-composer-page-builder' ),
					'std' => 'custom',
					'id' => 'dslc_template_base',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => 'Plugin Template',
							'value' => 'custom',
						),
						array(
							'label' => 'Theme Template',
							'value' => 'theme',
						),
					),
				),
				array(
					'label' => __( 'Type', 'live-composer-page-builder' ),
					'std' => 'default',
					'descr' => __( '<strong>Default</strong> template will be used as the default for all the posts. <br><strong>Optional</strong> template is an additional template that you can set to specific posts.', 'live-composer-page-builder' ),
					'id' => 'dslc_template_type',
					'type' => 'radio',
					'choices' => array(
						array(
							'label' => 'Default',
							'value' => 'default',
						),
						array(
							'label' => 'Optional',
							'value' => 'regular',
						),
					),
				),
			),
		);
	} // function register_dslc_templates_cpt
} // class
