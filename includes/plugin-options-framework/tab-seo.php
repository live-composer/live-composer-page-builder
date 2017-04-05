<?php
/**
 * Editor Messages
 *
 * @package LiveComposer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Main Tab_Seo Class.
 */
class LC_Settings_Tab_Seo {

	/**
	 * Premium user
	 *
	 * @var bool
	 */
	public $premium_user = false;

	/**
	 * Construct
	 */
	public function __construct() {

		if ( $this->is_premium_user() ) {
			$this->premium_user = true;
		}

		add_action( 'wp_ajax_dslc-set-hidden-tab-seo', array( $this, 'ajax_set_hidden_tab_seo' ) );
	}

	/**
	 * Our addon active
	 */
	public function is_addon_active() {

		if ( function_exists( 'lc_gallery_grid_module_init' ) ||
			function_exists( 'lcgooglemaps_plugin_init' ) ||
			function_exists( 'sklc_linecons_alter_icons' ) ||
			function_exists( 'sklc_addon_anim_filter' ) ||
			function_exists( 'lc_video_embed_module_init' ) ||
			function_exists( 'sklc_addon_prnep_register_module' ) ||
			function_exists( 'sklc_ppcw_options' ) ||
			function_exists( 'lcwoo_plugin_init' ) ||
			class_exists( 'LC_Before_After_Image' )
		) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Premium User
	 */
	public function is_premium_user() {

		if ( true == get_option( 'dslc_premium_user' ) ) {
			return true;
		} else {
			if ( true == $this->is_addon_active() ) {
				update_option( 'dslc_premium_user', true );
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * Get hidden ( panel )
	 */
	public function get_hidden() {
		return get_option( 'dslc_tab_seo_hidden', false );
	}

	/**
	 * Display the tab of seo
	 */
	public function print_tab_seo() {
	?>
	    <div class="wrap lc-wrap">
		    <div class="dslc-panel dslc-panel-seo">
		    	<a href="#" data-can-hide="<?php echo $this->premium_user; ?>" class="dslc-tab-seo-hide"><?php echo __( 'Hide this', 'live-composer-page-builder' ); ?></a>
		    	<div class="dslc-panel-content">
		    		<h2><?php _e( "Do you want more traffic?", 'live-composer-page-builder' ); ?></h2>
		    		<p class="about-description"><?php _e( "Don't pay SEO, pay only for results! <br>Enter your domain to see exactly how you can start ranking your site today", 'live-composer-page-builder' ); ?></p>
		    		<form id="dslc-seo-search" action="https://www.rankpay.com/keywords" method="post"  target="_blank">
		    			<input type="hidden" value="2579" name="pid">
		    			<label>Your domain:</label><br>
		    			<input type="text" value="<?php echo get_home_url(); ?>" name="preload_domain"><br>
		    			<label>Target keyword:</label><br>
		    			<input type="text" value="" name="preload_keyword"><br>
		    			<button type="submit">Get Pricing</button>
		    		</form>
		    	</div>
		    </div>
	    </div>
	<?php
	}
}
