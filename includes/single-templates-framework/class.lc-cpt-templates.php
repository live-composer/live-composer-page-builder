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
	 * Holds all post types powered by LC template system.
	 * Ex. global $dslc_var_templates_pt;
	 *
	 * @var array
	 * @access private
	 * @since 1.1.4
	 */
	private $postypes_with_templates = array();


	/**
	 * Holds all template options structure.
	 *
	 * @var array
	 * @access private
	 * @since 1.1.4
	 */
	private $template_options_structure = array();

	/**
	 * Launch all the hooks on class initialization.
	 *
	 * @return void
	 */
	public function __construct() {
		/**
		 * Register LC Templates CPT and all the metaboxes.
		 */
		// Register 'dslc_template' CPT.
		add_action( 'init',  array( $this, 'register_dslc_templates_cpt' ), 90 );

		// Define what post types should have LC templates.
		add_action( 'init', array( $this, 'default_posttypes_with_templates' ), 20 );

		// Set structure of post options for Template editing screen.
		add_action( 'init', array( $this, 'setup_template_options_structure' ), 20 );

		// Register post options for LC Template CPT.
		add_filter( 'dslc_filter_metaboxes', array( $this, 'add_template_postoptions' ) ); // Priority for this action is 30.

		/**
		 * Work logic for LC templates.
		 */

		// Redirect to the LC template.
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
	}

	/**
	 * Define what post types should have LC templates.
	 *
	 * @return void
	 */
	public function default_posttypes_with_templates() {

		$dslc_var_templates_pt = array();
		$dslc_var_templates_pt['post'] = 'Blog Posts';
		$dslc_var_templates_pt['dslc_projects'] = 'Projects';
		$dslc_var_templates_pt['dslc_galleries'] = 'Galleries';
		$dslc_var_templates_pt['dslc_downloads'] = 'Downloads';
		$dslc_var_templates_pt['dslc_staff'] = 'Staff';
		$dslc_var_templates_pt['dslc_partners'] = 'Partners';

		$dslc_var_templates_pt = apply_filters( 'dslc_filter_posttypes_with_templates', $dslc_var_templates_pt );

		$this->postypes_with_templates = $dslc_var_templates_pt;
	}

	/**
	 * Define what post types should have LC templates.
	 *
	 * @param  boolean $include_labels Return array with slug=>Name if true and slugs only if false.
	 * @return array List of all post types that use LC templates.
	 */
	public function get_posttypes_with_templates( $include_labels = false ) {

		// Array with slug=>Name.
		$dslc_post_types = $this->postypes_with_templates;

		// Array with slugs only.
		if ( ! $include_labels ) {
			// Ex. global $dslc_post_types.
			$dslc_post_types = array_keys( $dslc_post_types );
		}

		return $dslc_post_types;
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
				'name'          => __( 'Templates', 'live-composer-page-builder' ),
				'menu_name'     => __( 'Templates', 'live-composer-page-builder' ),
				'singular_name' => __( 'Template', 'live-composer-page-builder' ),
				'add_new'       => __( 'Add Template', 'live-composer-page-builder' ),
				'add_new_item'  => __( 'Add Template', 'live-composer-page-builder' ),
				'edit'          => __( 'Edit', 'live-composer-page-builder' ),
				'edit_item'     => __( 'Edit Template', 'live-composer-page-builder' ),
				'new_item'      => __( 'New Template', 'live-composer-page-builder' ),
				'view'          => __( 'View Templates', 'live-composer-page-builder' ),
				'view_item'     => __( 'View Template', 'live-composer-page-builder' ),
				'search_items'  => __( 'Search Templates', 'live-composer-page-builder' ),
				'parent'        => __( 'Parent Template', 'live-composer-page-builder' ),
				'not_found'     => __( 'No Templates found', 'live-composer-page-builder' ),
				'not_found_in_trash' => __( 'No Templates found in Trash', 'live-composer-page-builder' ),
			),
			'public' => true,
			// 'exclude_from_search' => true, // 404 page is broken with this parameter.
			'publicly_queryable' => true,
			'supports' => array( 'title', 'custom-fields', 'thumbnail' ),
			'capabilities' => array(
				'publish_posts'      => $capability,
				'edit_posts'         => $capability,
				'edit_others_posts'  => $capability,
				'edit_post'          => $capability,
				'delete_post'        => $capability,
				'read_post'          => $capability,
				'read_private_posts' => $capability,
				'delete_posts'       => $capability,
				'delete_others_posts' => $capability,
			),
			'show_in_menu' => 'themes.php',
		) );
	}

	/**
	 * Describe all the metaboxes for LC Template editing screen.
	 *
	 * @return void
	 */
	public function setup_template_options_structure() {

		/**
		 * LC Template Options Section:
		 * Template for...
		 */

		// Generate the choices.
		$dslc_var_templates_pt = $this->postypes_with_templates;

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
				'in_options' => true,
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
			'in_options' => true,
		);

		$template_for[] = array(
			'label' => __( 'Search Results', 'live-composer-page-builder' ),
			'value' => 'search_results',
			'in_options' => true,
		);

		$template_for[] = array(
			'label' => __( 'Author Archives', 'live-composer-page-builder' ),
			'value' => 'author',
			'in_options' => true,
		);

		/**
		 * Combine All LC Template Options.
		 */

		$template_options_structure = array(
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
		);

		$this->template_options_structure = $template_options_structure;
	}

	/**
	 * Add post options (metaboxes) on LC template post editing screen.
	 *
	 * @param   array $post_options_structure Post options structure.
	 * @return  array                         Modified post options structure.
	 */
	public function add_template_postoptions( $post_options_structure ) {

		$post_options_structure['dslc-templates-opts'] = array(
			'title' => 'Template Options',
			'show_on' => 'dslc_templates',
			'options' => $this->template_options_structure,
		);

		return $post_options_structure;
	}

	/**
	 * Redirect post to the right template.
	 *
	 * @return void
	 */
	public function template_redirect() {

		global $post;

		$lc = Live_Composer();
		$dslc_post_types = $lc->cpt_templates->get_posttypes_with_templates();

		// If there's no post, stop execution.
		if ( ! isset( $post ) ) {
			return;
		}

		// If the post is not supporting templates or it's not a template itself, stop execution.
		// @todo: Rewrite this condition.
		if ( is_singular( $dslc_post_types ) || is_singular( 'dslc_templates' ) ) { } else {
			return;
		}

		// If the currently shown page is the template CPT.
		if ( 'dslc_templates' === $post->post_type ) {

			// Get template base.
			$template_base = get_post_meta( $post->ID, 'dslc_template_base', true );

			// If custom base.
			if ( 'custom' === $template_base ) {

				// The template filename.
				$templatefilename = 'dslc-single.php';

				// If the template file is in the theme.
				if ( file_exists( TEMPLATEPATH . '/' . $templatefilename ) ) {

					$return_template = TEMPLATEPATH . '/' . $templatefilename;

				// If not in the theme use the default one from the plugin.
				} else {

					$return_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-single.php';
				}

				// Redirect.
				include( $return_template );

				// Bye bye.
	        	exit();

			}
		}

		// If the currently shown page is actually a post we should filter.
		if ( in_array( $post->post_type, $dslc_post_types, true ) ) {

			// Get template ID.
			$template_id = $lc->cpt_templates->get_template( 'by_post', $post->ID );

			// If the post has specific template, set it in variable.
			if ( $template_id ) {

				$template_base = get_post_meta( $template_id, 'dslc_template_base', true );

			// If the post does not have a specific template, just use regular base from theme.
			} else {
				$template_base = 'theme';
			}

			if ( 'custom' === $template_base ) {

				// The template filename.
				$templatefilename = 'dslc-single.php';

				// If the template file is in the theme.
				if ( file_exists( TEMPLATEPATH . '/' . $templatefilename ) ) {

					$return_template = TEMPLATEPATH . '/' . $templatefilename;

				// If not in the theme use the default one from the plugin.
				} else {

					$return_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-single.php';
				}

				// Redirect.
				include( $return_template );

				// Bye bye.
				exit();

			}
		}
	}
} // class
