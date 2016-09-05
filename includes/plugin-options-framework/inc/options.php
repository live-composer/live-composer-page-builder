<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Register All The Plugin Options
 *
 * @since 1.0
 * @param  array $dslc_plugin_options Plugin options structure.
 * @return array                      Modified array with plugin options structure.
 */
function dslc_plugin_options( $dslc_plugin_options ) {

	/**
	 * Plugin options section:
	 * GENERAL OPTIONS
	 */

	$dslc_plugin_options['dslc_plugin_options'] = array(
		'title' => __( 'General Options', 'live-composer-page-builder' ),
		'icon' => 'admin-settings',
		'options' => array(

		   'lc_max_width' => array(

			   'section' => 'dslc_plugin_options',
				'label' => __( 'Max Width', 'live-composer-page-builder' ),
				'std' => '',
				'type' => 'text',
				'descr' => __( 'The width of the modules section when row is set to wrapped. If not set the $content_width variable from theme will be used.', 'live-composer-page-builder' ),
			),

			'lc_force_important_css' => array(

				'section' => 'dslc_plugin_options',
				'label' => __( 'Force !important CSS', 'live-composer-page-builder' ),
				'std' => 'disabled',
				'type' => 'select',
				'descr' => __( 'In case the CSS from the theme is influencing CSS for the modules, enabling this will in most cases fix that.', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
				),
			),

			'lc_css_position' => array(

				'section' => 'dslc_plugin_options',
				'label' => __( 'Dynamic CSS Location', 'live-composer-page-builder' ),
				'std' => 'head',
				'type' => 'select',
				'descr' => __( 'Choose where the dynamic CSS is located, at the end of &lt;head&gt; or at the end of the &lt;body&gt;.', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => __( 'End of &lt;head&gt;', 'live-composer-page-builder' ),
						'value' => 'head',
					),
					array(
						'label' => __( 'End of &lt;body&gt;', 'live-composer-page-builder' ),
						'value' => 'body',
					),
				),
			),
		),
	);

	/**
	 * Plugin options section:
	 * PERFORMANCE
	 */

	$dslc_plugin_options['dslc_plugin_options_performance'] = array(
		'title' => __( 'Performance', 'live-composer-page-builder' ),
		'icon' => 'dashboard',
		'options' => array(

			'lc_gfont_subsets' => array(

				'section' => 'dslc_plugin_options_performance',
				'label' => __( 'Font Subsets', 'live-composer-page-builder' ),
				'std' => array( 'latin', 'latin-ext', 'cyrillic', 'cyrillic-ext' ),
				'type' => 'checkbox',
				'descr' => __( 'Which font subsets should be loaded.', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => 'Latin',
						'value' => 'latin',
					),
					array(
						'label' => 'Latin Extended',
						'value' => 'latin-ext',
					),
					array(
						'label' => 'Cyrillic',
						'value' => 'cyrillic',
					),
					array(
						'label' => 'Cyrillic Extended',
						'value' => 'cyrillic-ext',
					),
					array(
						'label' => 'Greek',
						'value' => 'greek',
					),
					array(
						'label' => 'Greek Extended',
						'value' => 'greek-ext',
					),
					array(
						'label' => 'Vietnamese',
						'value' => 'vietnamese',
					),
				),
			),
		),
	);

	/**
	 * Plugin options section:
	 * OTHER OPTIONS
	 */

	$dslc_plugin_options['dslc_plugin_options_other'] = array(
		'title' => __( 'Other', 'live-composer-page-builder' ),
		'icon' => 'admin-tools',
		'options' => array(

			'lc_editor_type' => array(

				'section' => 'dslc_plugin_options_other',
				'label' => __( 'Text Editor Type', 'live-composer-page-builder' ),
				'std' => 'both',
				'type' => 'select',
				'descr' => __( 'Choose if you want both the Visual and HTML mode for the editor or only Visual.', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => 'Visual and HTML',
						'value' => 'both',
					),
					array(
						'label' => 'Visual Only',
						'value' => 'visual',
					),
				),
			),

			'lc_default_opts_section' => array(

				'section' => 'dslc_plugin_options_other',
				'label' => __( 'Default Options Section', 'live-composer-page-builder' ),
				'std' => 'functionality',
				'type' => 'select',
				'descr' => __( 'Choose which options section is active by default ( when you click to edit a module and the options show up ).', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => 'Functionality',
						'value' => 'functionality',
					),
					array(
						'label' => 'Styling',
						'value' => 'styling',
					),
				),
			),

			'lc_module_activate_button_pos' => array(

				'section' => 'dslc_plugin_options_other',
				'label' => __( '"Activate Editor" Position', 'live-composer-page-builder' ),
				'std' => 'right',
				'type' => 'select',
				'descr' => __( 'Choose the position of the "Activate Editor" button.', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => 'Left',
						'value' => 'left',
					),
					array(
						'label' => 'Right',
						'value' => 'right',
					),
				),
			),
		),
	);

	/**
	 * Plugin options section:
	 * WIDGETS MODULE
	 */

	$dslc_plugin_options['dslc_plugin_options_widgets_m'] = array(
		'title' => __( 'Widgets Module', 'live-composer-page-builder' ),
		'icon' => 'welcome-widgets-menus',
		'options' => array(
			'sidebars' => array(

				'section' => 'dslc_plugin_options_widgets_m',
				'label' => __( 'Sidebars', 'live-composer-page-builder' ),
				'std' => '',
				'type' => 'list',
			),
		),
	);

	/**
	 * Plugin options section:
	 * CUSTOM POST TYPE SLUGS
	 */

	$dslc_plugin_options['dslc_plugin_options_cpt_slugs'] = array(

		'title' => __( 'Post Types (Slugs)', 'live-composer-page-builder' ),
		'icon' => 'index-card',
		'options' => array(

			'with_front' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( 'With Front', 'live-composer-page-builder' ),
				'descr' => __( 'Prepend the permalink structure with the front base. ( example: if your permalink structure is /blog/, then your links will be: disabled -> /project-view/, enabled -> /blog/project-view/ ).', 'live-composer-page-builder' ),
				'std' => 'enabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Enabled',
						'value' => 'enabled',
					),
					array(
						'label' => 'Disabled',
						'value' => 'disabled',
					),
				),
			),

			'projects_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Project</strong> Slug', 'live-composer-page-builder' ),
				'std' => 'project-view',
				'type' => 'text',
			),

			'projects_cats_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Projects</strong> Category Slug', 'live-composer-page-builder' ),
				'std' => 'dslc_projects_cats',
				'type' => 'text',
			),

			'galleries_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Gallery</strong> Slug', 'live-composer-page-builder' ),
				'std' => 'gallery-view',
				'type' => 'text',
			),

			'galleries_cats_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Galleries</strong> Category Slug', 'live-composer-page-builder' ),
				'std' => 'dslc_galleries_cats',
				'type' => 'text',
			),

			'downloads_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Download</strong> Slug', 'live-composer-page-builder' ),
				'std' => 'download-view',
				'type' => 'text',
			),

			'downloads_cats_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Downloads</strong> Categories Slug', 'live-composer-page-builder' ),
				'std' => 'dslc_downloads_cat',
				'type' => 'text',
			),

			'downloads_tags_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Downloads</strong> Tags Slug', 'live-composer-page-builder' ),
				'std' => 'dslc_downloads_tag',
				'type' => 'text',
			),

			'staff_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Staff</strong> Slug', 'live-composer-page-builder' ),
				'std' => 'staff-view',
				'type' => 'text',
			),

			'staff_cats_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Staff</strong> Categories Slug', 'live-composer-page-builder' ),
				'std' => 'dslc_staff_cats',
				'type' => 'text',
			),

			'partners_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Partner</strong> Slug', 'live-composer-page-builder' ),
				'std' => 'partner-view',
				'type' => 'text',
			),

			'partners_cats_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Partners</strong> Categories Slug', 'live-composer-page-builder' ),
				'std' => 'dslc_partners_cats',
				'type' => 'text',
			),

			'testimonials_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Testimonials</strong> Slug', 'live-composer-page-builder' ),
				'std' => 'testimonial-view',
				'type' => 'text',
			),
			'testimonials_cats_slug' => array(

				'section' => 'dslc_plugin_options_cpt_slugs',
				'label' => __( '<strong>Testimonials</strong> Categories Slug', 'live-composer-page-builder' ),
				'std' => 'dslc_testimonials_cats',
				'type' => 'text',
			),
		),
	);

	/**
	 * Plugin options section:
	 * FEATURE CONTROL (ENABLE/DISABLE MODULES)
	 */
	global $dslc_var_modules;
	$module_opts_array = array();

	foreach ( $dslc_var_modules as $module ) {

		$module_opts_array[ $module['id'] ] = array(

			'section' => 'dslc_plugin_options_features',
			'label' => '"' . $module['title'] . '" <small>module</small>',
			'std' => 'enabled',
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( '&#x2714; Enabled', 'live-composer-page-builder' ),
					'value' => 'enabled',
				),
				array(
					'label' => __( '&#x2716; Disabled', 'live-composer-page-builder' ),
					'value' => 'disabled',
				),
			),
		);

	}

	$dslc_plugin_options['dslc_plugin_options_features'] = array(
		'title' => __( 'Features Control', 'live-composer-page-builder' ),
		'icon' => 'forms',
		'options' => $module_opts_array,
	);

	/**
	 * Plugin options section:
	 * ACCESS CONTROL
	 */

	$capability_opts = array(
		array(
			'label' => __( 'Administrators', 'live-composer-page-builder' ),
			'value' => 'manage_options',
		),
		array(
			'label' => __( 'Editors', 'live-composer-page-builder' ),
			'value' => 'publish_pages',
		),
		array(
			'label' => __( 'Authors', 'live-composer-page-builder' ),
			'value' => 'publish_posts',
		),
		array(
			'label' => __( 'Contributors', 'live-composer-page-builder' ),
			'value' => 'edit_posts',
		),
	);

	$dslc_plugin_options['dslc_plugin_options_access_control'] = array(
		'title' => __( 'Access Control', 'live-composer-page-builder' ),
		'icon' => 'admin-network',
		'options' => array(

			'lc_min_capability_page' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Front-End Editor', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can use Live Composer in the front-end? This will also affect who can manage post templates.', 'live-composer-page-builder' ),
				'choices' => $capability_opts,
			),

			'lc_min_capability_projects_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Projects Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage projects ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts,
			),

			'lc_min_capability_galleries_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Galleries Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage galleries ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts,
			),

			'lc_min_capability_staff_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Staff Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage staff ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts,
			),

			'lc_min_capability_downloads_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Downloads Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage downloads ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts,
			),

			'lc_min_capability_testimonials_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Testimonials Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage testimonials ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts,
			),

			'lc_min_capability_partners_m' => array(

				'section' => 'dslc_plugin_options_access_control',
				'label' => __( 'Partners Management', 'live-composer-page-builder' ),
				'std' => 'publish_posts',
				'type' => 'select',
				'descr' => __( 'Who can manage partners ( add, edit, trash... )?', 'live-composer-page-builder' ),
				'choices' => $capability_opts,
			),
		),
	);

	return $dslc_plugin_options;

} add_filter( 'dslc_filter_plugin_options', 'dslc_plugin_options' );
