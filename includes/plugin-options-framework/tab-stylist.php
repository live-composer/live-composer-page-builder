<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
?>

<div class="wrap lc-admin-tab-content lc-wrap lc-centered-panels lc-wider-panel lc-tab-extensions">

	<div class="dslc-panel lc-divided-panels padding-medium">
		<div class="lc-panel-half">
			<h3 class="lc-huge margin-top-half"><?php _e( 'Style and website element with +60 extra design controls', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Check out a new free plugin for WordPress allowing you to customize any element on your page with easy to use design panel.', 'live-composer-page-builder' ); ?></p>
			<p><a href="https://livecomposerplugin.com/stylist" class="button button-primary button-hero" target="_blank">Download Free</a></p>
		</div>
		<div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Stylist', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/stylist.png">
		</div>
	</div>

</div>
