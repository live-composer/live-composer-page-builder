<?php

/**
 * Register all the option pages
 */

function dslc_plugin_options_setup() {

	global $dslc_plugin_options;
	do_action( 'dslc_hook_register_options' );

	add_menu_page(
		__('Live Composer', 'dslc_string' ),
		__('Live Composer', 'dslc_string' ),
		'manage_options',
		'dslc_plugin_options',
		'dslc_plugin_options_display'
	);

		add_submenu_page(
			'dslc_plugin_options',
			__('Getting Started', 'dslc_string' ),
			__('Getting Started', 'dslc_string' ),
			'manage_options',
			'dslc_getting_started',
			create_function( null, 'dslc_plugin_options_display( "dslc_getting_started" );' )
		);

		remove_submenu_page('dslc_plugin_options','dslc_plugin_options'); // delete duplicate

		foreach ( $dslc_plugin_options as $section_ID => $section ) {

			if ( $section_ID == 'dslc_plugin_options' ) {

				add_submenu_page(
					'dslc_plugin_options',
					$section['title'],
					$section['title'],
					'manage_options',
					$section_ID,
					'dslc_plugin_options_display'
				);

			} else {

				add_submenu_page(
					'dslc_plugin_options',
					$section['title'],
					$section['title'],
					'manage_options',
					$section_ID,
					create_function( null, 'dslc_plugin_options_display( "' . $section_ID . '" );' )
				);
			}
		}

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

		<div id="icon-themes" class="icon32"></div>
		<h2>Live Composer</h2>
<<<<<<< HEAD
		<?php settings_errors(); ?>
=======
		<?php settings_errors();
		$anchor = @$_GET['anchor'] != '' ? @$_GET['anchor'] : 'dslc_getting_started' ;?>
>>>>>>> 88c6120... LC 1.0.8: js based settings panel switch

		<h2 class="nav-tab-wrapper">
			<a href="#" data-nav-to="dslc_getting_started" class="nav-tab <?php echo $anchor == 'dslc_getting_started' ? 'nav-tab-active' : ''; ?>">Getting Started</a>
			<?php foreach ( $dslc_plugin_options as $section_ID => $section ) : ?>
				<a href="#"  data-nav-to="<?php echo $section_ID; ?>" class="nav-tab <?php echo $anchor == $section_ID ? 'nav-tab-active' : ''; ?>"><?php echo $section['title']; ?></a>
			<?php endforeach; ?>
		</h2>

			<div id="jstabs">
					<div class="tab" <?php echo $anchor == 'dslc_getting_started' ? "style='display:block'" : '' ?>  id="tab-for-dslc_getting_started">
						<?php include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/getting-started.php'; ?>
					</div>
					<form method="post" action="options.php">
					<?php echo settings_fields( 'dslc_plugin_options' ); ?>
				<?php

				 foreach($dslc_plugin_options as $section_ID => $section){?>
					<div class="tab" <?php echo $anchor == $section_ID ? 'style="display: block"' : ''?> id="tab-for-<?php echo $section_ID?>">

							<?php do_settings_sections( $section_ID ); ?>
							<?php submit_button();?>
					</div>
				<?php }?>
				</form>
			</div>
	</div><!-- /.wrap -->
	<script>
		jQuery(document).ready(function($)
		{
			jQuery(".nav-tab-wrapper > a").on('click', function()
			{
				if ($(this).data('nav-to') != null ) {

					$("#jstabs .tab").hide();
					$("#tab-for-" + $(this).data('nav-to')).show();
				}

				var refer = $("#jstabs").find("input[name='_wp_http_referer']");

				refer.val( '/wp-admin/admin.php?page=dslc_getting_started&anchor=' + $(this).data('nav-to') + '&settings-updated=true' );

				return false;
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
	 * Add Sections
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

	}

	/**
	 * Add Fields
	 */

	foreach ( $dslc_plugin_options as $section_ID => $section ) {

		foreach ( $section['options'] as $option_ID => $option ) {

			$option['id'] = $option_ID;

			if ( ! isset( $option['section'] ) ){

				$option['section'] = $section_ID;
			}

<<<<<<< HEAD
			$option['name'] = $option['section'] . '[' . $option['id'] . ']';
=======
			$option['name'] = 'dslc_plugin_options[' . $option['id'] . ']';

			$value = '';
			$options = get_option( 'dslc_plugin_options' );

			if ( isset( $options[ $option_ID ] ) ) {

				$value = $options[$option_ID];
			}

			/// Prev version struct
			if ( $value == '' ) {

				$options = get_option( $section_ID );

				if ( isset( $options[ $option_ID ] ) ) {

					$value = $options[$option_ID];
				}

				if ( $value == '' ) {

					$value = $option['std'];
				}
			}

			$option['value'] = $value;
>>>>>>> 88c6120... LC 1.0.8: js based settings panel switch

			add_settings_field(
				$option_ID,
				$option['label'],
				function() use ($option) {

					$func = 'dslc_plugin_option_display_' . $option['type'];
					$func($option);
				},
				$section_ID,
				$section_ID
			);
		}

	}


} add_action( 'admin_init', 'dslc_plugin_options_init' );

function dslc_plugin_options_display_options( $section ) {



}

/*
 * Active Campaign
 */

add_action( 'wp_ajax_dslc_activecampaign', 'dslc_ajax_check_activecampaign' );
function dslc_ajax_check_activecampaign(){

    // Check Nonce
    if ( !wp_verify_nonce( $_POST['security']['nonce'], 'dlscajax' ) ) {
        wp_die('NO');
    }

    // Access permissions
    if ( !current_user_can( 'install_plugins' ) ) {
        wp_die('You do not have rights!');
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