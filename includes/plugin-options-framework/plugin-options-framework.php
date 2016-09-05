<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

//@todo: delete this var
$dslc_plugin_options = array(); // Holds all plugin options

/**
 * LC_Plugin_Options
 *
 * @since 1.1.4
 */
class LC_Plugin_Options {

	/**
	 * Holds all plugin options values.
	 *
	 * @var array
	 * @access private
	 * @since 1.1.4
	 */
	private $plugin_options;

	/**
	 * Holds all plugin options structure.
	 *
	 * @var array
	 * @access private
	 * @since 1.1.4
	 */
	private $plugin_options_structure = array();

	/**
	 * Setup the class.
	 */
	public function __construct() {

		// Fill the options attribute from DB.
		$this->plugin_options = get_option( 'dslc_plugin_options' );

		add_action( 'admin_menu', array( $this, 'create_plugin_options_page' ) );
		add_action( 'admin_init', array( $this, 'register_option_panels' ) );

		// Allow extension developers to add their own setting pages.
		add_action( 'init', array( $this, 'filter_options' ) );

		// Additional processing on options saving.
		add_action( 'update_option', array( $this, 'on_options_update' ), 10, 4 );

	}

	/**
	 * Actions to run when saving options page.
	 *
	 * @param  string $option     Name of the option being saved.
	 * @param  array  $old_value  Old settings values.
	 * @param  array  $value     	New settings values.
	 * @return void
	 */
	public function on_options_update( $option, $old_value, $value ) {

		// If Live Composer Plugins Changed/Updated.
		if ( 'dslc_plugin_options' !== $option ) { return; }

		/**
		 * Do update/delete actions on presets.
		 *
		 * Presets get stored as a separate row
		 * called 'dslc_presets' in wp_options table.
		 */

		// 1. Get presets from the database.
		// 2. Get only keys of $presets array.
		// 3. Remove empty keys.
		$presets = maybe_unserialize( get_option( 'dslc_presets' ) ); // 1.

		if ( ! is_array( $presets ) ) { return; }

		$presets_old = array_keys( $presets ); // 2.
		$presets_old = array_filter(
			$presets_old,
			function ( $value ) {
				return '' !== $value;
			}
		); // 3.

		if ( empty( $presets_old ) ) { return; }

		// 4. Get presets submitted by form on settings page (string).
		// 5. Create array from $presets_submited string.
		// 6. Remove empty keys.
		$presets_submited = $value['lc_styling_presets']; // 4.
		$presets_new = explode( ',', $presets_submited ); // 5.
		if ( ! $presets_new ) { $presets_new = array(); }

		// Remove empty keys.
		$presets_new = array_filter(
			$presets_new,
			function ( $value ) {
				return '' !== $value;
			}
		); // 6.

		// Function array_diff depends on the order of arguments,
		// so we compare twice and then merge result to get what wee need.
		$presets_to_delete_a = array_diff( $presets_old, $presets_new );
		$presets_to_delete_b = array_diff( $presets_new, $presets_old );
		$presets_to_delete   = array_merge( $presets_to_delete_a, $presets_to_delete_b );

		if ( ! empty( $presets_to_delete ) ) {

			foreach ( $presets as $preset_key => $value ) {

				if ( in_array( $preset_key, $presets_to_delete, true ) || '' === $preset_key ) {
					unset( $presets[ $preset_key ] );
				}
			}

			// Put presets back into the database.
			update_option( 'dslc_presets', maybe_serialize( $presets ) );
		}
	}


	/**
	 * Allow extension developers to add their own setting pages.
	 *
	 * @return void
	 */
	public function filter_options() {
		// Allow extension developers to add their own setting pages.
		$this->plugin_options_structure = apply_filters( 'dslc_filter_plugin_options', $this->plugin_options_structure );

	}

	/**
	 * Return plugin options if called directly.
	 *
	 * @return array Plugin options.
	 */
	public function init() {

		return $this->plugin_options;
	}

	/**
	 * Retrieve value of a single option
	 *
	 * @since  1.1.4
	 * @param  string $option_id  			   Unique option ID.
	 * @param  string $deprecated_section_id  Optional option class/section (deprecated).
	 * @return string             				Option Value
	 */
	public function get_option( $option_id, $deprecated_section_id = '' ) {

		$value = null;
		$dslc_plugin_options_structure = $this->plugin_options_structure;
		$options = $this->plugin_options;

		// Since 1.0.8 no section required to get the option value.
		if ( isset( $options[ $option_id ] ) ) {

			$value = $options[ $option_id ];
		}

		// Back-compatibility: Old way to get options (section + option id).
		if ( null === $value ) {

			$options = get_option( $deprecated_section_id );

			if ( isset( $options[ $option_id ] ) ) {
				$value = $options[ $option_id ];
			} elseif ( isset( $dslc_plugin_options_structure[ $deprecated_section_id ]['options'][ $option_id ] ) ) {
				// Standard value.
				$value = $dslc_plugin_options_structure[ $deprecated_section_id ]['options'][ $option_id ]['std'];
			} else {
				$value = '';
			}
		}

		return $value;
	}

	/**
	 * Retrieve all plugin options in array.
	 *
	 * @since  1.1.4
	 * @return array All plugin options in array.
	 */
	public function get_all_options() {

		$options = $this->plugin_options;

		return $options;
	}

	/**
	 * Register all the pages with plugin options
	 *
	 * @since  1.1.4
	 */
	public function create_plugin_options_page() {

		do_action( 'dslc_hook_register_options' ); //@todo remove this action;

		$lc = Live_Composer();
		// Get plugin icon.
		$icon_svg = $lc->sidebar_icon;

		$page_hook_suggix = add_menu_page(
			__( 'Live Composer', 'live-composer-page-builder' ),
			__( 'Live Composer', 'live-composer-page-builder' ),
			'manage_options', 										      // Cap.
			'dslc_plugin_options', 									      // Menu slug.
			array( $this, 'render_options_page_content' ),        // Page Content.
			$icon_svg,
			'99.99'
		);

		//@todo: add hook here to make possible to add sub-pages from extensions.
		// Create class object.
		// $dslc_options_extender = new LC_Options_Extender;
		// $dslc_options_extender->construct_panels();
	}

	/**
	 * Output Plugin Options Page Content
	 *
	 * @param string $tab Tab to display.
	 * @since  1.1.4
	 */
	public function render_options_page_content( $tab = '' ) {

		?>
		<style>
			#jstabs .tab{display: none}
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
			$anchor = '' !== $anchor ? $anchor : 'dslc_getting_started';
			?>
			<a name="dslc-top"></a>
			<h2 class="nav-tab-wrapper dslc-settigns-tabs" id="dslc-tabs">
				<a href="#" data-nav-to="dslc_getting_started" class="nav-tab <?php echo 'dslc_getting_started' === $anchor ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Getting Started', 'live-composer-page-builder' ) ?></a>
				<a href="#" data-nav-to="tab-settings" class="nav-tab <?php echo 'dslc_settings' === $anchor ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Settings', 'live-composer-page-builder' ) ?></a>
				<a href="#" data-nav-to="tab-extensions" class="nav-tab <?php echo 'dslc_extensions' === $anchor ? 'nav-tab-active' : ''; ?>"><?php  echo esc_html__( 'Extensions', 'live-composer-page-builder' ) . ' <span class="tag">' . esc_html__( 'Free', 'live-composer-page-builder' ) . '</span>'; ?></a>
				<a href="#" data-nav-to="tab-themes" class="nav-tab <?php echo 'dslc_themes' === $anchor ? 'nav-tab-active' : ''; ?>"><?php  echo esc_html__( 'Themes', 'live-composer-page-builder' ) . ' <span class="tag">' . esc_html__( 'Free', 'live-composer-page-builder' ) . '</span>'; ?></a>
				<a href="#" data-nav-to="tab-docs" class="nav-tab <?php echo 'dslc_docs' === $anchor ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Docs &amp; Support', 'live-composer-page-builder' ) ?></a>
			</h2>


			<div id="jstabs">
					<!-- Getting Started Tab -->
					<div class="tab" <?php if ( $anchor != 'dslc_settings' ) echo 'style="display:block"'; ; ?> id="tab-for-dslc_getting_started">
						<?php include DSLC_PO_FRAMEWORK_ABS . '/options-page-tabs/tab-getting-started.php'; ?>
					</div>
					<!-- Settings tab -->
					<div class="tab" <?php if ( $anchor == 'dslc_settings' ) echo 'style="display:block"'; ; ?>  id="tab-for-tab-settings">
						<?php include DSLC_PO_FRAMEWORK_ABS . '/options-page-tabs/tab-settings.php'; ?>
					</div>
					<!-- Themes tab -->
					<div class="tab" id="tab-for-tab-themes">
						<?php include DSLC_PO_FRAMEWORK_ABS . '/options-page-tabs/tab-themes.php'; ?>
					</div>
					<!-- Extensions tab -->
					<div class="tab" id="tab-for-tab-extensions">
						<?php include DSLC_PO_FRAMEWORK_ABS . '/options-page-tabs/tab-extensions.php'; ?>
					</div>
					<!-- Docs & Support tab -->
					<div class="tab" id="tab-for-tab-docs">
						<?php include DSLC_PO_FRAMEWORK_ABS . '/options-page-tabs/tab-docs.php'; ?>
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
	 * Register sections/panels with options inside on the settings page.
	 *
	 * @since  1.1.4
	 * @return void
	 */
	public function register_option_panels() {

		$dslc_plugin_options = $this->plugin_options_structure;

		/**
		 * Add Sections and Fields on the settings page
		 */

		foreach ( $dslc_plugin_options as $section_id => $section ) {

			// Init action.
			add_settings_section(
				$section_id,
				$section['title'],
				'dslc_plugin_options_display_options',
				$section_id
			);

			// Register a setting and its sanitization callback.
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
	}
}


include DSLC_PO_FRAMEWORK_ABS . '/inc/options.php';
include DSLC_PO_FRAMEWORK_ABS . '/inc/functions.php';
include DSLC_PO_FRAMEWORK_ABS . '/inc/display-options.php';
