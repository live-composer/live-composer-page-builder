<?php
/**
 * Initialization functions for the settings panel
 *
 * @package LiveComposer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Returns a base64 URL for the svg for use in the menu
 *
 * @return string
 */
function dslc_get_menu_svg() {
	$icon_svg = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9Ii0yOTcgMzg4IDE3IDE3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IC0yOTcgMzg4IDE3IDE3OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+Cgkuc3Qwe2ZpbGw6IzlFQTNBODt9Cjwvc3R5bGU+Cjx0aXRsZT5TbGljZSAxPC90aXRsZT4KPGRlc2M+Q3JlYXRlZCB3aXRoIFNrZXRjaC48L2Rlc2M+CjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0tMjg0LjIsMzg4aC05LjhjLTEuNiwwLTMsMS4zLTMsM3Y4LjljMCwxLjYsMS4zLDMsMywzaDEuNXYtMmgtMS41Yy0wLjYsMC0xLTAuNC0xLTFWMzkxYzAtMC41LDAuNC0xLDEtMWg5LjgKCWMwLjUsMCwxLDAuNCwxLDF2Mi4zaDJWMzkxQy0yODEuMiwzODkuMy0yODIuNSwzODgtMjg0LjIsMzg4eiIvPgo8ZyBpZD0iR3JvdXAtMTgiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMuNTMxMjUwLCA1LjI5Njg3NSkiPgoJPHBhdGggaWQ9IkNvbWJpbmVkLVNoYXBlIiBjbGFzcz0ic3QwIiBkPSJNLTI5Mi4yLDM5OS42di0xLjJjMCwwLTEuOC0yLjQtMi42LTMuM2MtMC44LTAuOS0xLjItMi40LDAtM2MxLjItMC42LDEuOCwxLjIsMS44LDEuMgoJCXMtMS43LTMuNywwLjItNGMxLjMtMC4yLDEuNiwxLjYsMS42LDEuNnMtMC4xLTIsMS40LTJjMS41LDAsMS41LDIsMS41LDJzMC0xLjgsMS4yLTEuOGMxLjIsMCwxLjQsMS41LDEuNCwxLjVzLTAuMi0wLjksMC45LTAuOQoJCWMwLjksMCwxLjEsMC42LDEuMiwxLjdjMCwwLjQtMC4xLDEuNS0wLjEsMmMwLDMtMiwzLjctMiwzLjd2Mi40aC0xLjJjMCwwLTAuOC0xLjItMS4yLTEuMnMtMC42LDEuMi0wLjYsMS4ySC0yOTIuMnogTS0yOTEuNSwzOTMuMQoJCXYyLjVjMCwwLjMsMC4yLDAuNSwwLjUsMC41YzAuMywwLDAuNS0wLjIsMC41LTAuNXYtMi41YzAtMC4zLTAuMi0wLjUtMC41LTAuNUMtMjkxLjIsMzkyLjYtMjkxLjUsMzkyLjgtMjkxLjUsMzkzLjF6CgkJIE0tMjg5LjUsMzkzLjF2M2MwLDAuMywwLjIsMC41LDAuNSwwLjVjMC4zLDAsMC41LTAuMiwwLjUtMC41di0zYzAtMC4zLTAuMi0wLjUtMC41LTAuNUMtMjg5LjMsMzkyLjYtMjg5LjUsMzkyLjgtMjg5LjUsMzkzLjF6CgkJIE0tMjg3LjUsMzkzLjF2Mi41YzAsMC4zLDAuMiwwLjUsMC41LDAuNWMwLjMsMCwwLjUtMC4yLDAuNS0wLjV2LTIuNWMwLTAuMy0wLjItMC41LTAuNS0wLjVDLTI4Ny4yLDM5Mi42LTI4Ny41LDM5Mi45LTI4Ny41LDM5My4xCgkJeiIvPgo8L2c+Cjwvc3ZnPgo=';

	return $icon_svg;
}

/**
 * Register all the option pages
 */
function dslc_plugin_options_setup() {

	global $dslc_plugin_options;
	do_action( 'dslc_hook_register_options' );

} add_action( 'plugins_loaded', 'dslc_plugin_options_setup' );

function dslc_add_lc_settings_page() {

	// Base 64 encoded SVG image.
	$icon_svg = dslc_get_menu_svg();

	add_menu_page(
		__( 'Live Composer', 'live-composer-page-builder' ),
		__( 'Live Composer', 'live-composer-page-builder' ),
		'manage_options',
		'dslc_plugin_options',
		'dslc_plugin_options_display',
		$icon_svg,
		'99.99'
	);

	// Custom options extension.
	global $dslc_options_extender;
	$dslc_options_extender->construct_panels();

} add_action( 'admin_menu', 'dslc_add_lc_settings_page' );


/**
 * Display option pages
 *
 * @param string $tab Tab to display.
 */
function dslc_plugin_options_display( $tab = '' ) {

	global $dslc_plugin_options;

	?>
	<style>
		#lc-settings-tabs .tab{display: none}
	</style>
	<div class="wrap">
		<h2 id="dslc-main-title">Live Composer <span class="dslc-ver"><?php echo esc_html( DS_LIVE_COMPOSER_VER ); ?></span></h2>

		<form autocomplete="off" class="docs-search-form" id="dslc-headersearch" method="GET" action="//livecomposer.help/search"  target="_blank">
			<input type="hidden" value="" name="collectionId">
			Search the knowledge base: &nbsp;
			<input type="text" value="" placeholder="Your question here..." class="search-query" title="search-query" name="query">
			<button type="submit" class="hssearch button button-hero"><span class="dashicons dashicons-search"></span> Search</button>
		</form>

		<?php
		settings_errors();

		$anchor = sanitize_text_field( @$_GET['anchor'] );
		$anchor = '' !== $anchor ? $anchor : 'dslc_extensions';

		?>
		<a name="dslc-top"></a>
		<h2 class="nav-tab-wrapper dslc-settigns-tabs" id="dslc-tabs">
			<!-- <a href="#" data-nav-to="tab-extend" class="nav-tab <?php echo 'tab-extend' === $anchor ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Extend', 'live-composer-page-builder' ) ?></a> -->
			<a href="#" data-nav-to="tab-settings" class="nav-tab <?php echo 'dslc_settings' === $anchor ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Settings', 'live-composer-page-builder' ) ?></a>
			<a href="#" data-nav-to="tab-extensions" class="nav-tab <?php echo 'dslc_extensions' === $anchor ? 'nav-tab-active' : ''; ?>"><?php  echo esc_html__( 'Extensions', 'live-composer-page-builder' ) . ' <span class="tag">' . esc_html__( 'New', 'live-composer-page-builder' ) . '</span>'; ?></a>
			<a href="#" data-nav-to="tab-woo" class="nav-tab <?php echo 'dslc_woo' === $anchor ? 'nav-tab-active' : ''; ?>"><?php  echo esc_html__( 'WooCommerce', 'live-composer-page-builder' ) . ' <span class="tag">' . esc_html__( 'New', 'live-composer-page-builder' ) . '</span>'; ?></a>
			<!-- <a href="#" data-nav-to="tab-themes" class="nav-tab <?php echo 'dslc_themes' === $anchor ? 'nav-tab-active' : ''; ?>"><?php  echo esc_html__( 'Themes', 'live-composer-page-builder' ) . ' <span class="tag">' . esc_html__( 'Free', 'live-composer-page-builder' ) . '</span>'; ?></a> -->
			<!-- <a href="#" data-nav-to="tab-designs" class="nav-tab <?php echo 'dslc_designs' === $anchor ? 'nav-tab-active' : ''; ?>"><?php  echo esc_html__( 'Designs', 'live-composer-page-builder' ) . ' <span class="tag">' . esc_html__( 'New', 'live-composer-page-builder' ) . '</span>'; ?></a> -->
			<a href="#" data-nav-to="tab-docs" class="nav-tab <?php echo 'dslc_docs' === $anchor ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Docs &amp; Support', 'live-composer-page-builder' ) ?></a>
		</h2>


		<div id="lc-settings-tabs">
				<!-- Extensions tab -->
				<div class="tab" id="tab-for-tab-extensions" <?php if ( $anchor != 'dslc_settings' ) echo 'style="display:block"'; ; ?>>
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-extensions.php'; ?>
				</div>
				<!-- Getting Started Tab -->
<?php /*
				<div class="tab" <?php if ( $anchor != 'dslc_settings' ) echo 'style="display:block"'; ; ?> id="tab-for-tab-extend">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-extend.php'; ?>
				</div>
*/ ?>
				<!-- Settings tab -->
				<div class="tab" <?php if ( $anchor == 'dslc_settings' ) echo 'style="display:block"'; ; ?>  id="tab-for-tab-settings">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-settings.php'; ?>
				</div>

				<!-- Woo tab -->
				<div class="tab" id="tab-for-tab-woo">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-woo.php'; ?>
				</div>

				<!-- Themes tab -->
				<div class="tab" id="tab-for-tab-themes">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-themes.php'; ?>
				</div>
				<!-- Designs tab -->
				<div class="tab" id="tab-for-tab-designs">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-designs.php'; ?>
				</div>
				<!-- Docs & Support tab -->
				<div class="tab" id="tab-for-tab-docs">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-docs.php'; ?>
				</div>
		</div>
	</div><!-- /.wrap -->
	<script>
		jQuery(document).ready(function($) {
			jQuery(".nav-tab-wrapper > a").on('click', function() {
				if ($(this).data('nav-to') != null ) {

					$("#lc-settings-tabs .tab").hide();
					$(".nav-tab-active").removeClass('nav-tab-active');
					$("#tab-for-" + $(this).data('nav-to')).show();
					$(this).addClass('nav-tab-active')

					var refer = $("#lc-settings-tabsjstabs").find("input[name='_wp_http_referer']");
					refer.val( '<?php echo admin_url( 'admin.php?page=dslc_plugin_options&anchor=dslc_settings&settings-updated=true' ); ?>' );

					return false;
				}
			});
		});
	</script>
	<?php

}

/**
 * Register options
 */
function dslc_plugin_options_init() {

	global $dslc_plugin_options;

	/**
	 * Add Sections and Fields on the settings page
	 */

	foreach ( $dslc_plugin_options as $section_id => $section ) {

		add_settings_section(
			$section_id,
			$section['title'],
			'dslc_plugin_options_display_options',
			$section_id
		);

		register_setting(
			$section_id, // Option Group.
			$section_id, // Option Name.
			'dslc_plugin_options_input_sanitize'// Sanitize.
		);

		foreach ( $section['options'] as $option_id => $option ) {

			$option['id'] = $option_id;

			if ( ! isset( $option['section'] ) ) {

				$option['section'] = $section_id;
			}

			$option['name'] = 'dslc_plugin_options[' . $option['id'] . ']';

			$value = '';
			$options = get_option( 'dslc_plugin_options' );

			if ( isset( $options[ $option_id ] ) ) {
				$value = $options[ $option_id ];
			}

			// Previous version structure.
			if ( '' === $value ) {

				$options = get_option( $section_id );

				if ( isset( $options[ $option_id ] ) ) {

					$value = $options[ $option_id ];
				}

				if ( '' === $value ) {

					$value = $option['std'];
				}
			}

			$option['value'] = $value;

			add_settings_field(

				$option_id, // Id.
				$option['label'], // Title.
				'dslc_option_display_funcitons_router', // Callback.
				$section_id, // Page.
				$section_id, // Section.
				$option // Args.
			);
		}
	}

} add_action( 'admin_init', 'dslc_plugin_options_init' );

/**
 * Function router to not use anonymous functions
 *
 * @param  array $option Option data.
 * @return void
 */
function dslc_option_display_funcitons_router( $option ) {
	if ( 'text' === $option['type'] ) {
		dslc_plugin_option_display_text( $option );
	} elseif ( 'textarea' === $option['type'] ) {
		dslc_plugin_option_display_textarea( $option );
	} elseif ( 'select' === $option['type'] ) {
		dslc_plugin_option_display_select( $option );
	} elseif ( 'checkbox' === $option['type'] ) {
		dslc_plugin_option_display_checkbox( $option );
	} elseif ( 'list' === $option['type'] ) {
		dslc_plugin_option_display_list( $option );
	} elseif ( 'radio' === $option['type'] ) {
		dslc_plugin_option_display_radio( $option );
	} elseif ( 'styling_presets' === $option['type'] ) {
		dslc_plugin_option_display_styling_presets( $option );
	}
}

/**
 * Required Function
 *
 * This function is required for add_settings_section
 * even if we don't print any data inside of it.
 * In our case all the settings fields rendered
 * by callback from add_settings_field.
 *
 * @param section $section Docs section.
 */
function dslc_plugin_options_display_options( $section ) {
	echo apply_filters( 'dslc_filter_section_description', '', $section['id'] );
}

/**
 * Sanitize each setting field on submit
 *
 * @param array $input Contains all the settings as single array, with fields as array keys.
 */
function dslc_plugin_options_input_sanitize( $input ) {

	$new_input = array();

	if ( is_array( $input ) ) {
		foreach ( $input as $key => $option_value ) {

			if ( ! is_array( $option_value ) ) {

				$new_input[ $key ] = sanitize_text_field( $option_value );

			} else {

				foreach ( $option_value as $inner_key => $inner_option_value ) {

					$new_input[ $key ][ $inner_key ] = sanitize_text_field( $inner_option_value );

				}
			}
		}

		return $new_input;

	} else {
		return $input;
	}

}

/**
 * Active Campaign
 */
function dslc_ajax_check_activecampaign() {

	// Check Nonce.
	if ( ! wp_verify_nonce( $_POST['security']['nonce'], 'dslc-optionspanel-ajax' ) ) {
		wp_die( 'You do not have rights!' );
	}

	// Check access permissions.
	if ( ! current_user_can( 'install_plugins' ) ) {
		wp_die( 'You do not have rights!' );
	}

	$email = sanitize_email( $_POST['email'] );
	$name = sanitize_text_field( $_POST['name'] );

	$dslc_getting_started = array(
	'email' => $email,
	'name' => $name,
	'subscribed' => '1',
	);

	add_option( 'dslc_user', $dslc_getting_started );

	wp_die();

}
add_action( 'wp_ajax_dslc_activecampaign', 'dslc_ajax_check_activecampaign' );
