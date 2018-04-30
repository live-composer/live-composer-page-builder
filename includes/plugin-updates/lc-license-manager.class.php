<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if ( ! class_exists( 'LC_License_Manager' ) ):

	/**
	 * Core Class
	 */
	class LC_License_Manager {

		/**
		 * Path to this module dir.
		 *
		 * @var string
		 */
		private $abspath;

		/**
		 * Was this class ever instantiated?
		 *
		 * @var bool
		 */
		public static $initiated = false;

		/**
		 * All the data we know about module licenses.
		 *
		 * @var array
		 */
		public static $licenses = array();

		public static $store_url = 'https://livecomposerplugin.com';


		/**
		 * Do all the required job on core object creation.
		 */
		function __construct( $plugin_data = false ) {
			// Actions that needs to be lunched only once.
			if ( ! self::$initiated ) {
				$this->abspath = __DIR__;
				$this->set_license_from_db();
				$this->require_files();
				add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );
				add_action( 'admin_init', array( $this, 'setup_plugin_updater' ), 10 );
				// add_action( 'wp_ajax_dslc-ajax-activate-license', array( $this, 'ajax_activate_license' ) );
				add_action( 'wp_ajax_dslc-ajax-toggle-license', array( $this, 'ajax_toggle_license' ) );
				add_action( 'wp_ajax_dslc-ajax-activate-plugin', array( $this, 'activate_installed_plugin' ) );
				add_action( 'current_screen', array( $this, 'initiate_license_check' ), 0 );
				self::$initiated = true;
			}

			if ( $plugin_data ) {
				$this->register_licensed_plugin( $plugin_data );
			}
		}

		/**
		 * Load JS/CSS for this module.
		 */
		public function load_admin_scripts( $hook ) {
			/* If current screen is Live Composer options page */
			if ( 'toplevel_page_dslc_plugin_options' === $hook ) {
				wp_enqueue_script( 'dslc-licensemanager-js-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-updates/admin-license-manager.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
				// wp_enqueue_style( 'dslc-plugin-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/css/main' . $min_suffix . '.css', array(), DS_LIVE_COMPOSER_VER );
			}
		}

		/**
		 * Register plugin that needs license and automatic updates. 
		 */
		public function register_licensed_plugin( $plugin_data ) {
			$plugin_slug = false;
			$item_id = false;
			$plugin_version = 0;
			$plugin_author = '';
			$plugin_file = '';

			if ( isset( $plugin_data['slug'] ) ) {
				$plugin_slug = $plugin_data['slug'];
			} else {
				return;
			}

			if ( isset( $plugin_data['product_id'] ) ) {
				$item_id = $plugin_data['product_id'];
			} else {
				return;
			}

			if ( isset( $plugin_data['file'] ) ) {
				$plugin_file = $plugin_data['file'];
			} else {
				return;
			}

			if ( isset( $plugin_data['version'] ) ) {
				$plugin_version = $plugin_data['version'];
			} else {
				return;
			}

			if ( isset( $plugin_data['author'] ) ) {
				$plugin_author = $plugin_data['author'];
			} else {
				return;
			}

			self::$licenses[ $plugin_slug ]['version'] = $plugin_version;
			self::$licenses[ $plugin_slug ]['author'] = $plugin_author;
			self::$licenses[ $plugin_slug ]['item_id'] = $item_id;
			self::$licenses[ $plugin_slug ]['plugin_file'] = $plugin_file;

			if ( ! isset( self::$licenses[ $plugin_slug ]['license'] ) ) {
				self::$licenses[ $plugin_slug ]['license'] = '';
			}

			if ( ! isset( self::$licenses[ $plugin_slug ]['status'] ) ) {
				self::$licenses[ $plugin_slug ]['status'] = '';
			}

			if ( ! isset( self::$licenses[ $plugin_slug ]['expires'] ) ) {
				self::$licenses[ $plugin_slug ]['expires'] = '';
			}

			if ( ! isset( self::$licenses[ $plugin_slug ]['updated'] ) ) {
				self::$licenses[ $plugin_slug ]['updated'] = '';
			}
		}

		/**
		 * Setup the updater.
		 */
		public function setup_plugin_updater() {

			foreach ( self::$licenses as $slug => $data ) {
				if ( 	! isset( $data['plugin_file'] ) ||
					! isset( $data['version'] ) ||
					! isset( $data['item_id'] ) || 
					! isset( $data['author'] ) ) return;

				// Setup the updater.
				$edd_updater = new LC_Plugins_Updater(
					self::$store_url,
					$data['plugin_file'],
					array(
						'version' 	=> $data['version'],
						'license' 	=> $data['license'],
						'item_id'   => $data['item_id'], // Product ID.
						'author' 	=> $data['author'],
						'url'       => home_url(),
					)
				);
			}
		}

		public function set_license_from_db() {
			// Retrieve our license key from the DB.
			$licenses = get_option( 'dslc_licenses', array() );

			if ( ! is_array( $licenses ) ) {
				update_option( 'dslc_licenses', array() );
				return;
			}

			foreach ( $licenses as $slug => $data) {

				if ( isset( $data['status'] ) ) {
					self::$licenses[ $slug ]['status'] = $data['status'];
				}

				if ( isset( $data['license'] ) ) {
					self::$licenses[ $slug ]['license'] = $data['license'];
				}

				if ( isset( $data['expires'] ) ) {
					self::$licenses[ $slug ]['expires'] = $data['expires'];
				}

				if ( isset( $data['updated'] ) ) {
					self::$licenses[ $slug ]['updated'] = $data['updated'];
				}
			}
		}

		public function update_license_in_db() {
			$data_to_save = array();

			foreach ( self::$licenses as $slug => $data ) {
				if ( isset( $data['status'] ) ) {
					$data_to_save[ $slug ]['status'] = $data['status'];
				}

				if ( isset( $data['license'] ) ) {
					$data_to_save[ $slug ]['license'] = $data['license'];
				}

				if ( isset( $data['expires'] ) ) {
					$data_to_save[ $slug ]['expires'] = $data['expires'];
				}

				$data_to_save[ $slug ]['updated'] = current_time( 'timestamp' );
			}

			update_option( 'dslc_licenses', $data_to_save );
		}

		public function get_license_data( $plugin_slug ) {
			if ( ! empty( $plugin_slug ) && isset( self::$licenses[ $plugin_slug ] ) ) {
				return self::$licenses[ $plugin_slug ];
			} else {
				return false;
			}
		}

		public function get_license_key( $plugin_slug ) {
			$data = $this->get_license_data( $plugin_slug );
			if ( $data && isset( $data['license'] ) ) {
				return $data['license'];
			} else {
				return false;
			}
		}

		public function get_license_status( $plugin_slug ) {
			$data = $this->get_license_data( $plugin_slug );
			if ( $data && isset( $data['status'] ) ) {
				return $data['status'];
			} else {
				return 'inactive';
			}
		}

		public function get_license_expires( $plugin_slug ) {
			$data = $this->get_license_data( $plugin_slug );
			if ( $data && isset( $data['expires'] ) ) {
				return date_i18n( get_option( 'date_format' ), strtotime( $data['expires'], current_time( 'timestamp' ) ) );
			} else {
				return false;
			}
		}

		/**
		 * Ajax call for activating license.
		 */
		public function ajax_toggle_license( $atts ) {
			// Allowed to do this?
			if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ):

				// The array we'll pass back to the AJAX call.
				$response = array();
				$plugin = false;
				$license = false;
				$action = false;

				if ( isset( $_POST['plugin'] ) ) {
					$plugin = sanitize_key( $_POST['plugin'] );
				}

				if ( isset( $_POST['license'] ) ) {
					$license = sanitize_key( $_POST['license'] );
				}

				if ( isset( $_POST['todo'] ) ) {
					$action = sanitize_key( $_POST['todo'] );
				}

				// Check Nonce.
				if ( wp_verify_nonce( sanitize_key( $_POST['security'] ), 'dslc-ajax-activate-license-for-plugin-' . $plugin ) ) {

					// Do the job.
					if ( $plugin && $license ) {
						$response = array();
						$response = $this->toggle_license( $plugin, $license, $action );
					}

				} else {
					$response['message'] = 'Error with WP authentification. Try to reload this page.';
					$response['success'] = false;
				}

				// Check if active SEOWP theme.
				if ( ( true === $response['success'] && function_exists( 'lbmn_setup' ) ) && 'valid' === $response['status'] || 'deactivated' === $response['status'] ) {
					$response['redirect'] = true;
				}

				// Encode response.
				$response_json = wp_json_encode( $response );

				// Send back the response.
				header( 'Content-Type: application/json' );
				echo $response_json;

				// Au revoir.
				wp_die();
				// exit;

			endif; // End if is_user_logged_in()...
		}

		public function toggle_license( $plugin = false, $license = false, $action = false ) {


			$status = false;
			$plugin = esc_attr( $plugin );
			$license = esc_attr( $license );
			$action = esc_attr( $action );

			if ( ! $plugin || ! $license || ! $action ) return false;

			$license = trim( $license );

			$item_id = false;

			if ( isset( self::$licenses[ $plugin ] ) &&
					isset( self::$licenses[ $plugin ]['item_id'] ) ) {
				$item_id = self::$licenses[ $plugin ]['item_id'];
			} else {
				$combined_response['message'] = 'Error: missing item_id parameter.';
				$combined_response['status'] = false;
			}

			if ( 'activate' === $action ) {
				$action = 'activate_license';
			} elseif ( 'deactivate' === $action ) {
				$action = 'deactivate_license';
			}

			// Data to send in our API request.
			$api_params = array(
				'edd_action' => $action,
				'license'    => $license,
				'item_id'    => $item_id, // Product id in EDD.
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post( self::$store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			// Make sure the response came back okay.
			if ( $response instanceof WP_Error || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				if ( $response instanceof WP_Error ) {
					$message = $response->get_error_message();
				} else {
					$message = __( 'An error occurred, please try again.' );
				}

			} else {

				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( false === $license_data->success ) {

					switch ( $license_data->error ) {

						case 'expired' :

							$message = sprintf(
								__( 'Your license key expired on %s.' ),
								date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
							);
							break;

						case 'revoked' :

							$message = __( 'Your license key has been disabled.' );
							break;

						case 'missing' :

							$message = __( 'Invalid license.' );
							break;

						case 'invalid' :
						case 'site_inactive' :

							$message = __( 'Your license is not active for this URL.' );
							break;

						case 'item_name_mismatch' :

							$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), EDD_SAMPLE_ITEM_NAME );
							break;

						case 'no_activations_left':

							$message = __( 'Your license key has reached its activation limit.' );
							break;

						default :

							$message = __( 'An error occurred, please try again.' );
							break;
					}
				}
			}

			// Success.
			if ( empty( $message ) ) {

				if ( 'activate_license' === $action ) {
					$message = __( 'License activated. Expiration date: ' ) . date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) );
					$status = true; // True - license activated successfully.
				} elseif ( 'deactivate_license' === $action ) {
					$message = __( 'License deactivated.' );
					$status = false; // True - license activated successfully.
				}
			}

			// Update license data.
			$this->set_license_key( $plugin, $license );
			$this->set_license_status( $plugin, $license_data->license ); // Will be "valid", "invalid", "deactivated".
			if ( 'valid' === $license_data->license ) {
				$this->set_license_expires( $plugin, $license_data->expires );
			} else {
				$this->set_license_expires( $plugin, false );
			}

			$combined_response['message'] = $message;
			$combined_response['status'] = $license_data->license;
			$combined_response['success'] = $license_data->success;
			return $combined_response;
		}

		public function set_license_key( $plugin, $license_key ) {
			$license_key = trim( esc_attr( $license_key ) );
			self::$licenses[ $plugin ]['license'] = $license_key;

			$this->update_license_in_db();
		}

		public function set_license_status( $plugin, $license_status ) {
			$license_status = trim( esc_attr( $license_status ) );
			self::$licenses[ $plugin ]['status'] = $license_status;

			$this->update_license_in_db();
		}

		public function set_license_expires( $plugin, $license_expires ) {
			$license_expires = trim( esc_attr( $license_expires ) );
			self::$licenses[ $plugin ]['expires'] = $license_expires;

			$this->update_license_in_db();
		}

		/**
		 * Initiate plugin license verification if user visits 
		 * plugin listings or plugin update pages.
		 * Perform one check per week max.
		 * Once lincense check per time max.
		 */
		public function initiate_license_check() {

			$screen = get_current_screen();
			// Do not proceed if it's not plugins of updates pages.
			if ( 'plugins' !== $screen->id && 'update-core' !== $screen->id ) {
				return;
			}

			$plugin_to_check = false;

			foreach ( self::$licenses as $slug => $data) {
				$check_this_plugin = true;

				// Do not continue if last checked less than 7 days ago.
				if ( ! empty( $data['updated'] ) && strtotime( $data['updated'] ) > strtotime('-7 days') ) {
					$check_this_plugin = false;
				}

				if ( $check_this_plugin || empty( $data['updated'] ) ) {
					$plugin_to_check = $slug;
					break;
				}	
			}

			if ( $plugin_to_check ) {
				$this->license_check( $plugin_to_check );
			}
		}

		/**
		 * Check if license key is valid.
		 *
		 * @access  public
		 * @return  void
		 */
		public function license_check( $plugin = false ) {

			if ( 	! $plugin ||
					! isset( self::$licenses[ $plugin ] ) ||
					! isset( self::$licenses[ $plugin ]['license'] ) ||
					! isset( self::$licenses[ $plugin ]['item_id'] ) ) {
				return;
			}

			// Data to send in our API request.
			$api_params = array(
				'edd_action'=> 'check_license',
				'license' 	=> self::$licenses[ $plugin ]['license'],
				'item_id'   => self::$licenses[ $plugin ]['item_id'],
				'url'       => home_url(),
			);

			// Call the API.
			$response = wp_remote_post(
				self::$store_url,
				array(
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => $api_params,
				)
			);

			// Verify response.
			if ( $response instanceof WP_Error ) {
				return false;
			}

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// Update local licende data.
			$this->set_license_status( $plugin, $license_data->license );

			if ( 'invalid' !== $license_data->license ) {
				$this->set_license_expires( $plugin, $license_data->expires );
			} else {
				$this->set_license_expires( $plugin, false );
			}
		}

		/**
		 * Required actions on plugin bootstrap.
		 *
		 * @return void
		 */
		public function require_files() {
			// Load EDD custom updater.
			require_once $this->abspath . '/lc-plugins-updater.class.php';
		}

		/**
		 * Setup the updater.
		 */
		public function render_license_block( $plugin ) {

			if ( empty( $plugin ) ) {
				return;
			}

			$license_status = $this->get_license_status( $plugin );
			$license_key = $this->get_license_key( $plugin );
			$license_expires = $this->get_license_expires( $plugin );

			$license_block_variants = array(
				'invalid' => array(
					'text_header' => __( 'Please enter your license to&nbsp;activate the&nbsp;plugin', 'live-composer-page-builder' ),
					'text_body' => __( 'Thanks for buying our plugin, to activate all the&nbsp;features, please enter your license&nbsp;key bellow (<a href="https://livecomposerplugin.com/your-account/license/" target="_blank">get your lincese key here</a>):', 'live-composer-page-builder' ),
					'text_button' => __( 'Activate', 'live-composer-page-builder' ),
					'button_action' => 'activate',
				),
				'valid' => array(
					'text_header' => __( 'License is active', 'live-composer-page-builder' ),
					'text_body' => __( 'Thank you for buying our product. <br />Your license is active and valid. <br />It will expire on ', 'live-composer-page-builder' ) . '<strong>' . $license_expires . '</strong>',
					'text_button' => __( 'Deactivate', 'live-composer-page-builder' ),
					'button_action' => 'deactivate',
				),
			);
			// deactivated

			foreach ( $license_block_variants as $staus => $strings ) : ?>
				<div class="dslc-panel lc-panel-license lc-divided-panels padding-medium" data-show-if-license="<?php echo $staus; ?>">
					<div class="lc-panel-half">
						<h3 class="lc-huge margin-top-half"><?php echo esc_html( $strings['text_header'] ); ?></h3>
						<p class="lc-larger-text"><?php echo $strings['text_body']; ?></p>
						<p class="lc-license-block">
							<span class="dashicons dashicons-admin-network"></span> 
							<input
								type="text"
								class="lc-license-field" 
								placeholder="Your license key here"
								value="<?php echo $license_key; ?>"
								data-plugin-id="<?php echo $plugin; ?>" />	
							<a 	href="#"
								class="button button-primary button-hero lc-toggle-license"
								data-action-type="<?php echo $strings['button_action']; ?>"
								data-action-nonce="<?php echo wp_create_nonce( 'dslc-ajax-activate-license-for-plugin-' . $plugin ) ?>"
							><?php echo esc_html( $strings['text_button'] ); ?></a>
							<span class="lc-license-status"></span>
						</p>
					</div>
					<div class="lc-panel-half lc-image-column">
						<?php if ( 'lc-extensions' === $plugin ) : ?>
							<img alt="<?php _e( 'Additional Premium Modules', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-mink-extensions.png">
						<?php elseif ( 'lc-woo-integration' === $plugin ) : ?>
							<img alt="<?php _e( 'WooCommerce Integration', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-extension-woo.png">
						<?php endif; ?>
					</div>
				</div>
			<?php
			endforeach;
		}

		/**
		 * Ajax call for activating license.
		 */
		public function activate_installed_plugin( $atts ) {
			// Allowed to do this?
			if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ):

				// The array we'll pass back to the AJAX call.
				$response =  false;
				$plugin = false;

				if ( isset( $_POST['plugin'] ) ) {
					$plugin = sanitize_key( $_POST['plugin'] );
				}

				// Check Nonce.
				if ( wp_verify_nonce( sanitize_key( $_POST['security'] ), 'dslc-ajax-activate-plugin-' . $plugin ) ) {

					$result = activate_plugin( $plugin . '/' . $plugin . '.php' );

					if ( ! is_wp_error( $result ) ) {
						$response = true;
					}

				} else {
					$response['message'] = 'Error with WP authentification. Try to reload this page.';
					$response['success'] = false;
				}

				// Return response.
				echo $response;

				// Au revoir.
				wp_die();
				// exit;

			endif; // End if is_user_logged_in()...
		}
	}

endif; // if ( ! class_exists( 'LC_License_Manager' ) ).

// Start License Manager.
$lc_license_manager = new LC_License_Manager;
