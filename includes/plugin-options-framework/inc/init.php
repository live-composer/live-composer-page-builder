<?php

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

		// add_submenu_page(
		// 	'dslc_plugin_options',
		// 	__('Geeting Started', 'live-composer-page-builder' ),
		// 	__('Geeting Started', 'live-composer-page-builder' ),
		// 	'manage_options',
		// 	'dslc_getting_started',
		// 	create_function( null, 'dslc_plugin_options_display( "dslc_getting_started" );' )
		// );

		// remove_submenu_page( 'dslc_plugin_options', 'dslc_plugin_options' ); // delete duplicate
} add_action( 'admin_menu', 'dslc_plugin_options_setup' );

/**
 * Display option pages
 */

function dslc_plugin_options_display( $tab = '' ) {

	global $dslc_plugin_options;

	?>
	<style>
		#jstabs .tab{display: none}
	</style>
	<div class="wrap">
		<h2 id="dslc-main-title">Live Composer <span class="dslc-ver"><?php echo DS_LIVE_COMPOSER_VER; ?></span></h2>

		<form autocomplete="off" class="docs-search-form" id="dslc-headersearch" method="GET" action="//livecomposer.help/search"  target="_blank">
			<input type="hidden" value="" name="collectionId">
			Search the knowledge base: &nbsp;
			<input type="text" value="" placeholder="Your question here..." class="search-query" title="search-query" name="query">
			<button type="submit" class="hssearch button button-hero"><span class="dashicons dashicons-search"></span> Search</button>
		</form>

		<?php
		settings_errors();

		$anchor = sanitize_text_field( @$_GET['anchor'] );
		$anchor = $anchor != '' ? $anchor : 'dslc_getting_started';
		?>
		<a name="dslc-top"></a>
		<h2 class="nav-tab-wrapper dslc-settigns-tabs" id="dslc-tabs">
			<a href="#" data-nav-to="dslc_getting_started" class="nav-tab <?php echo $anchor == 'dslc_getting_started' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Getting Started', 'live-composer-page-builder' ) ?></a>
			<a href="#" data-nav-to="tab-settings" class="nav-tab <?php echo $anchor == 'dslc_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Settings', 'live-composer-page-builder' ) ?></a>
			<a href="#" data-nav-to="tab-extensions" class="nav-tab <?php echo $anchor == 'dslc_extensions' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Extensions <span class="tag">Free</span>', 'live-composer-page-builder' ) ?></a>
			<a href="#" data-nav-to="tab-themes" class="nav-tab <?php echo $anchor == 'dslc_themes' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Themes <span class="tag">Free</span>', 'live-composer-page-builder' ) ?></a>
			<a href="#" data-nav-to="tab-docs" class="nav-tab <?php echo $anchor == 'dslc_docs' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Docs &amp; Support', 'live-composer-page-builder' ) ?></a>
		</h2>


		<div id="jstabs">
				<!-- Getting Started Tab -->
				<div class="tab" <?php if ( $anchor != 'dslc_settings') echo 'style="display:block"'; ; ?> id="tab-for-dslc_getting_started">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-getting-started.php'; ?>
				</div>
				<!-- Settings tab -->
				<div class="tab" <?php if ( $anchor == 'dslc_settings') echo 'style="display:block"'; ; ?>  id="tab-for-tab-settings">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-settings.php'; ?>
				</div>
				<!-- Themes tab -->
				<div class="tab" id="tab-for-tab-themes">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-themes.php'; ?>
				</div>
				<!-- Extensions tab -->
				<div class="tab" id="tab-for-tab-extensions">
					<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/tab-extensions.php'; ?>
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

					$("#jstabs .tab").hide();
					$(".nav-tab-active").removeClass('nav-tab-active');
					$("#tab-for-" + $(this).data('nav-to')).show();
					$(this).addClass('nav-tab-active')


				var refer = $("#jstabs").find("input[name='_wp_http_referer']");

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

	foreach ( $dslc_plugin_options as $section_ID => $section ) {

		add_settings_section(
			$section_ID,
			$section['title'],
			'dslc_plugin_options_display_options',
			$section_ID
		);

		register_setting(
			$section_ID,
			$section_ID
		);

		foreach ( $section['options'] as $option_ID => $option ) {


			$option['id'] = $option_ID;

			if ( ! isset( $option['section'] ) ) {

				$option['section'] = $section_ID;
			}

			$option['name'] = 'dslc_plugin_options[' . $option['id'] . ']';

			$value = '';
			$options = get_option( 'dslc_plugin_options' );

			if ( isset( $options[$option_ID] ) ) {

				$value = $options[$option_ID];
			}

			/// Prev version struct
			if ( $value == '' ) {

				$options = get_option( $section_ID );

				if ( isset( $options[$option_ID] ) ) {

					$value = $options[$option_ID];
				}

				if ( $value == '' ) {

					$value = $option['std'];
				}
			}

			$option['value'] = $value;

			add_settings_field(
				$option_ID, // id
				$option['label'], //title
				'dslc_option_display_funcitons_router', //callback
				$section_ID, //page
				$section_ID, //section
				$option //args
			);
		}

	}


} add_action( 'admin_init', 'dslc_plugin_options_init' );


function dslc_option_display_funcitons_router( $option ) {
	if ( $option['type'] == 'text' ) {
		dslc_plugin_option_display_text ($option);
	} elseif ( $option['type'] == 'textarea' ) {
		dslc_plugin_option_display_textarea ($option);
	} elseif ( $option['type'] == 'select' ) {
		dslc_plugin_option_display_select ($option);
	} elseif ( $option['type'] == 'checkbox' ) {
		dslc_plugin_option_display_checkbox ($option);
	} elseif ( $option['type'] == 'list' ) {
		dslc_plugin_option_display_list ($option);
	} elseif ( $option['type'] == 'radio' ) {
		dslc_plugin_option_display_radio ($option);
	} elseif ( $option['type'] == 'styling_presets' ) {
		dslc_plugin_option_display_styling_presets ($option);
	}
}

function dslc_plugin_options_display_options( $section ) {
  /*
	* Function is required for add_settings_section
	* even if we don't print any data insite of it.
	* In our case all the settings fields rendered
	* by callback from add_settings_field.
	*
	*/
}

/*
 * Active Campaign
 */

add_action( 'wp_ajax_dslc_activecampaign', 'dslc_ajax_check_activecampaign' );
function dslc_ajax_check_activecampaign() {

    // Check Nonce
    if ( ! wp_verify_nonce( $_POST['security']['nonce'], 'dslc-optionspanel-ajax' ) ) {
        wp_die( 'You do not have rights!' );
    }

    // Access permissions
    if ( ! current_user_can( 'install_plugins' ) ) {
        wp_die( 'You do not have rights!' );
    }

    $email = sanitize_email( $_POST["email"] );
    $name = sanitize_text_field( $_POST["name"] );

    $dslc_getting_started = array(
    	'email' => $email,
    	'name' => $name,
    	'subscribed' => '1'
    );

    add_option( 'dslc_user', $dslc_getting_started );

    wp_die();

}