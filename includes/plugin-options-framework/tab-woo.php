<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
?>
<div class="wrap lc-wrap lc-centered-panels lc-wider-panel lc-tab-woo">

	<div class="dslc-panel lc-divided-panels lc-panel-woo lc-dark-panel padding-medium"
		style="background-image:url(<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-woo-bg.png)" >
		<div class="lc-text-center">
			<p class="lc-panel-icon-hero"><span class="dashicons dashicons-cart"></span></p>
			<h3 class="lc-huge"><?php _e( 'WooCommerce Integration', 'lbmn' ); ?></h3>
			<p class="lc-description"><?php _e( 'Now you can fully customize your WooCommerce website without any coding. Visually adjust designs or create from scratch product&nbsp;pages using our drag &amp; drop builder.' , 'lbmn'); ?></p>
		</div>
		<ul class="lc-column-list"  style="padding-left:10%;">
			<li><span class="dashicons dashicons-yes"></span> +22 Woo Modules</li>
			<li><span class="dashicons dashicons-yes"></span> Design Product Pages</li>
			<li><span class="dashicons dashicons-yes"></span> Design Product Listings</li>
			<li><span class="dashicons dashicons-yes"></span> Customize Shopping Cart</li>
			<li><span class="dashicons dashicons-yes"></span> Customize Checkout Form</li>
			<li><span class="dashicons dashicons-yes"></span> Customize Account Section</li>
		</ul>
		<!-- <div class="lc-text-center" style="width:100%;">
			<p><a href="#" class="button button-primary button-hero">Get Official Live Coposer Theme</a></p>
		</div> -->
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels no-top-margin">
		<div class="lc-panel-third">
			<p><?php _e( '30 Days Money Back Guarantee' , 'lbmn'); ?></p>
		</div>
		<div class="lc-panel-third">
			<p><a href="#" class="button button-primary button-hero">Buy Now For 20% OFF</a></p>
		</div>

		<div class="lc-panel-third lc-text-right">
			<p><span class="promo-code">Promo code: <strong>HAPPY-<?php echo $today_day; ?></strong></span></p>
		</div>
	</div>


</div>