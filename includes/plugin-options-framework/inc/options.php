<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

add_action( 'plugins_loaded', 'dslc_plugin_options_add', 20 );
function dslc_plugin_options_add() {

	global $content_width, $dslc_plugin_options;

	$dslc_plugin_options['dslc_plugin_options'] = array(
		'title' => __( 'General Options', 'live-composer-page-builder' ),
		'options' => array(

		   'lc_max_width' => array(

			   'section' => 'dslc_plugin_options',
				'label' => __( 'Max Width', 'live-composer-page-builder' ),
				'std' => '',
				'type' => 'text',
				'descr' => __( 'The width of the modules section when row is set to wrapped. If not set the $content_width variable from theme will be used.', 'live-composer-page-builder' ),
			),

			'lc_section_paddings' => array(

			   'section' => 'dslc_plugin_options',
				'label' => __( 'Section Paddings <br>(horizontal)', 'live-composer-page-builder' ),
				'std' => '4%',
				'type' => 'text',
				'descr' => __( 'Spacing to add on the left and right side of the each row. Used to prevent the content from touching the sides of the window. Default: 4%', 'live-composer-page-builder' ),
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

	$dslc_plugin_options['dslc_plugin_options_widgets_m'] = array(
		'title' => __( 'Widgets Module', 'live-composer-page-builder' ),
		'options' => array(
			'sidebars' => array(

				'section' => 'dslc_plugin_options_widgets_m',
				'label' => __( 'Sidebars', 'live-composer-page-builder' ),
				'std' => '',
				'type' => 'list',
			),
		),
	);

	$dslc_plugin_options['dslc_plugin_options_cpt_slugs'] = array(

		'title' => __( 'Slugs', 'live-composer-page-builder' ),
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
}

/**
 * Feature Control
 */
function dslc_feature_control_settings() {

	global $dslc_var_modules;
	global $dslc_plugin_options;

	$module_opts_array = array();

	foreach ( $dslc_var_modules as $module ) {

		$module_opts_array[$module['id']] = array(

			'section' => 'dslc_plugin_options_features',
			'label' => '"' . $module['title'] . '" <small>module</small>',
			'std' => 'enabled',
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( '&#x2714; Enabled', 'live-composer-page-builder' ),
					'value' => 'enabled'
				),
				array(
					'label' => __( '&#x2716; Disabled', 'live-composer-page-builder' ),
					'value' => 'disabled'
				)
			)
		);

	}

	$dslc_plugin_options['dslc_plugin_options_features'] = array(
		'title' => __( 'Features Control', 'live-composer-page-builder' ),
		'options' => $module_opts_array
	);

} add_action( 'dslc_hook_register_modules', 'dslc_feature_control_settings', 999 );

function dslc_feature_control_unregister() {

	global $dslc_var_modules;
	$features = dslc_get_options( 'dslc_plugin_options_features' );

	foreach ( $dslc_var_modules as $module ) {
		if ( isset( $features[$module['id']] ) && $features[$module['id']] == 'disabled' ) {
			dslc_unregister_module( $module['id'] );
		}
	}


} add_action( 'dslc_hook_unregister_modules', 'dslc_feature_control_unregister', 999 );

/**
 * Register Other Options
 *
 * @since 1.0
 */
function dslc_plugin_opts_other() {

	global $dslc_plugin_options;

	$dslc_plugin_options['dslc_plugin_options_other'] = array(
		'title' => __( 'Other', 'live-composer-page-builder' ),
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

} add_action( 'dslc_hook_register_options', 'dslc_plugin_opts_other', 50 );

/**
 * Register Archives Options
 *
 * @since 1.0
 */
function dslc_plugin_opts_archives() {

	global $dslc_plugin_options;

	$module_opts_array = array();

	$args = array(
		'post_type' => 'dslc_templates',
		'post_status' => 'publish',
		'numberposts' => -1,
	);

	$templates = get_posts( $args );

	foreach ( $templates as $template ) {
		$custom_fields = get_post_meta( $template->ID, 'dslc_template_for', false );

		foreach ( $custom_fields as $custom_field ) {
			if ( ! empty( $custom_field ) ) {
				if ( 'author' == $custom_field || 'search_results' == $custom_field || '404_page' == $custom_field || strripos( $custom_field, '_archive' ) ) {

					$module_opts_array[ $custom_field ] = array(

						'section' => 'dslc_plugin_options_archives',
						'label' => '' . $template->post_title . '',
						'std' => '' . $template->ID . '',
						'type' => 'text',
					);
				}
			}
		}
	}

	$dslc_plugin_options['dslc_plugin_options_archives'] = array(
		'title' => __( 'Archives', 'live-composer-page-builder' ),
		'options' => $module_opts_array,
	);

} add_action( 'dslc_hook_register_options', 'dslc_plugin_opts_archives', 999 );
