<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
?>
<div class="wrap lc-wrap lc-centered-panels lc-wider-panel lc-tab-woo lc-admin-tab-content">

<?php 
// Get list of all plugin (active and inactive).
$all_plugins = get_plugins();

// ACTIVATE NOTICE: Check if plugin is already installed but not active.
if ( array_key_exists( 'lc-woo-integration/lc-woo-integration.php', $all_plugins ) && is_plugin_inactive( 'lc-woo-integration/lc-woo-integration.php' ) ) : ?>
	<div class="dslc-panel lc-panel-non-active-plugin">
		<span class="dashicons dashicons-warning" style="color:#D76D50; margin-right:8px;"></span> <?php _e( 'Looks like <strong>WooCommerce Integration for Live Composer</strong> plugin installed, but not active.', 'live-composer-page-builder' ); ?>
		<a href="#" class="button button-primary lc-activate-plugin" data-plugin="lc-woo-integration" data-action-nonce="<?php echo wp_create_nonce( 'dslc-ajax-activate-plugin-lc-woo-integration' ) ?>">Activate It Now</a>
	</div>
<?php endif;

// AD PANEL: If WooIntegration is inactive.
if ( is_plugin_inactive( 'lc-woo-integration/lc-woo-integration.php' ) ) : ?>
	<div class="dslc-panel lc-divided-panels lc-panel-woo lc-dark-panel padding-medium"
		style="background-image:url(<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-woo-bg.png)" >
		<div class="lc-text-center">
			<p class="lc-panel-icon-hero"><span class="dashicons dashicons-cart"></span></p>
			<h3 class="lc-huge"><?php _e( 'WooCommerce Integration', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-description"><?php _e( 'Now you can fully customize your WooCommerce website without any coding. Visually adjust designs or create from scratch product&nbsp;pages using our drag &amp; drop builder.', 'live-composer-page-builder' ); ?></p>
		</div>
		<ul class="lc-column-list"  style="padding-left:10%;">
			<li><span class="dashicons dashicons-yes"></span> +22 Woo Modules</li>
			<li><span class="dashicons dashicons-yes"></span> Design Product Pages</li>
			<li><span class="dashicons dashicons-yes"></span> Design Product Listings</li>
			<li><span class="dashicons dashicons-yes"></span> Customize Shopping Cart</li>
			<li><span class="dashicons dashicons-yes"></span> Customize Checkout Form</li>
			<li><span class="dashicons dashicons-yes"></span> Customize Account Section</li>
		</ul>
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels no-top-margin">
		<div class="lc-panel-third">
			<p><?php _e( '30 Days Money Back Guarantee', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-third">
			<p><a href="https://livecomposerplugin.com/downloads/woocommerce-page-builder/?utm_source=wp-admin&utm_medium=woo-tab&utm_campaign=intro-block" class="button button-primary button-hero" target="_blank">Buy Today For 15% OFF</a></p>
		</div>

		<div class="lc-panel-third lc-text-right">
			<p><span class="promo-code">Promo code: <strong>HAPPY-<?php echo $today_day; ?></strong></span></p>
		</div>
	</div>
<?php endif;

// LICENSE PANEL: If extension is active.
if ( is_plugin_active( 'lc-woo-integration/lc-woo-integration.php' ) ) {
	$license_manager = new LC_License_Manager;
	$license_status = $license_manager->get_license_status( 'lc-woo-integration' );

	if ( 'valid' !== $license_status ) {
		$license_status = 'invalid';
	}

	echo '<div data-license-status="' . $license_status . '">';
		// Top license block (shows when issues or no license set).
		// echo '<div data-show-if-license="invalid">';
			echo $license_manager->render_license_block( 'lc-woo-integration' );
		// echo '</div>';	

		// Tab heading (shows only when there is no problem with license).
		// echo '<div class="lc-tab-heading" data-show-if-license="valid">';
		// echo '<h1 class="wp-heading-inline">' . __('Premium Extensions', 'live-composer-page-builder') . ' <span class="title-count theme-count">' . count( $extensions ) . '</span> </h1>';
		// echo '<a href="#lc-license-block" class="button lc-license-status-button"><span class="dashicons dashicons-yes"></span> License is acitve</a>';
		// echo '</div>';
	echo '</div>';

}
?>

</div>