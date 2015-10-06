<?php
/**
 * Welcome Page Class
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DSLC_Welcome Class
 *
 * @since 1.0
 */
class DSLC_Welcome {

	public $minimum_capability = 'manage_options';

	/**
	 * Get things started
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome'    ) );
	}

	/**
	 * Register dashboard pages
	 *
	 * @since 1.0
	 */
	public function admin_menus() {

		// Getting Started Page
		add_dashboard_page(
			__( 'Getting started with Live Composer', 'live-composer-page-builder' ),
			__( 'Getting started with Live Composer', 'live-composer-page-builder' ),
			$this->minimum_capability,
			'dslc-getting-started',
			array( $this, 'getting_started_screen' )
		);

	}

	/**
	 * Hide dashboard pages and add some CSS
	 *
	 * @since 1.0
	 */
	public function admin_head() {

		remove_submenu_page( 'index.php', 'dslc-getting-started' );
		
		?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/

		.about-wrap .dslc-badge {
			position: absolute;
			top: 20px;
			right: 0;
			width: 100px;
		}

		.about-wrap .feature-section {
			margin-top: 20px;
		}

		/*]]>*/
		</style>
		<?php
	}

	/**
	 * Navigation
	 *
	 * @since 1.0
	 */
	public function tabs() {

		$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'dslc-about';
		?>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo $selected == 'dslc-getting-started' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'dslc-getting-started' ), 'index.php' ) ) ); ?>">
				<?php _e( 'Getting Started', 'live-composer-page-builder' ); ?>
			</a>
		</h2>
		<?php

	}

	/**
	 * Getting started page
	 *
	 * @since 1.0
	 */
	public function getting_started_screen() {

		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Live Composer %s', 'live-composer-page-builder' ), DS_LIVE_COMPOSER_VER ); ?></h1>

			<div class="about-text"><?php _e( 'Thank you for using Live Composer! We hope you will enjoy it and build awesome stuff with it.', 'live-composer-page-builder' ); ?></div>
			<div class="dslc-badge"><img src="<?php echo DS_LIVE_COMPOSER_URL . 'images/lc-logo.png'; ?>" / ></div>

			<?php $this->tabs(); ?>

			<div class="changelog">

				<h3><?php _e( 'Documentation &amp; Support', 'live-composer-page-builder' );?></h3>

				<div class="feature-section">

					<h4><?php _e( 'Usage Documentation', 'live-composer-page-builder' );?></h4>
					<p><?php _e( 'The usage documentation is available online. Make sure you check out those interactive tutorials, they\'ll give you a jump start at using Live Composer.<br><a target="_blank" href="http://livecomposerplugin.com/docs/installation">Go To Usage Documentation &rarr;</a>', 'live-composer-page-builder' );?></p>

					<h4><?php _e( 'Developer Documentation', 'live-composer-page-builder' );?></h4>
					<p><?php _e( 'If you\'re a developer who is interested in building custom modules for Live Composer give a check at the developer documentation.<br><a target="_blank" href="http://livecomposerplugin.com/docs/building-a-module-the-basics/">Go To Developer Documentation &rarr;</a>', 'live-composer-page-builder' );?></p>					

					<h4><?php _e( 'Support', 'live-composer-page-builder' );?></h4>
					<p><?php _e( 'If you run into any bugs or issues do let us know.<br><a target="_blank" href="http://livecomposerplugin.com/support/">Go To Support &rarr;</a>', 'live-composer-page-builder' );?></p>

				</div><!-- .feature-section -->

			</div><!-- .changelog -->

			<div class="changelog">

				<h3><?php _e( 'Themes &amp; Add-Ons', 'live-composer-page-builder' );?></h3>

				<div class="feature-section">

					<h4><?php _e( 'Themes', 'live-composer-page-builder' );?></h4>
					<p><?php _e( 'There are a lot of free and premium themes powered by Live Composer.<br><a target="_blank" href="http://livecomposerplugin.com/themes">Check Out The Themes &rarr;</a>', 'live-composer-page-builder' );?></p>

					<h4><?php _e( 'Add-Ons', 'live-composer-page-builder' );?></h4>
					<p><?php _e( 'If you are looking for some extra functionality ( features, modules... ) there are free and premium add-ons.<br><a target="_blank" href="http://livecomposerplugin.com/add-ons">Check Out The Add-Ons &rarr;</a>', 'live-composer-page-builder' );?></p>					

				</div><!-- .feature-section -->

			</div><!-- .changelog -->

		</div>
		<?php
	}

	/**
	 * Redirect the user to the welcome screen
	 *
	 * @since 1.0
	 */
	public function welcome() {

		// Bail if no activation redirect
		if ( ! get_transient( '_dslc_activation_redirect_1' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_dslc_activation_redirect_1' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		wp_safe_redirect( admin_url( 'index.php?page=dslc-getting-started' ) ); exit;

	}

}

new DSLC_Welcome();
