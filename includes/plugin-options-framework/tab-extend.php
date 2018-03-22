<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
?>

<div class="wrap lc-wrap dslc-tab-extend lc-centered-panels">

	<div class="dslc-panel lc-panel-intro padding-medium">
		<p class="lc-panel-icon-hero"><span class="dashicons dashicons-dashboard orange"></span></p>
		<h2 class="lc-huge"><?php _e( 'Unleash the power hidden in&nbsp;Live&nbsp;Composer', 'live-composer-page-builder' ); ?></h2>
		<p class="lc-description lc-align-center"><?php _e( 'Combine Live&nbsp;Composer with our <strong>official premium theme</strong>. It&nbsp;comes bundled with premium plugins and design resources to&nbsp;get your WordPress development to a&nbsp;whole new level.', 'live-composer-page-builder' ); ?></p>

		<div class="lc-premium-features">
			<a href="#woo" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-shoppingcart.png">
				</div>
				<p class="lc-premium-feature-description"><?php _e( 'WooCommerce Integration', 'live-composer-page-builder' ); ?></p>
			</a>

			<a href="#plugins" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-plugins.png">
				</div>
				<p class="lc-premium-feature-description"><?php _e( 'Ten&nbsp;Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?></p>
			</a>

			<a href="#acf" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-cpt.png">
				</div>
				<p class="lc-premium-feature-description"><?php _e( 'Custom Post Types &amp; ACF Integration', 'live-composer-page-builder' ); ?></p>
			</a>

			<a href="#slider" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-slider.png">
				</div>

				<p class="lc-premium-feature-description"><?php _e( 'Premium Slider with Pro Animations ', 'live-composer-page-builder' ); ?></p>
			</a>

			<a href="#ranking" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-graph.png">
				</div>

				<p class="lc-premium-feature-description"><?php _e( 'Automated SEO Position Tracker', 'live-composer-page-builder' ); ?></p>
			</a>

			<a href="#menu" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-menu.png">
				</div>

				<p class="lc-premium-feature-description"><?php _e( 'Responsive Mega Menu Module', 'live-composer-page-builder' ); ?></p>
			</a>

			<a href="#ninja" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-ninja.png">
				</div>

				<p class="lc-premium-feature-description"><?php _e( 'Ninja Forms Integration', 'live-composer-page-builder' ); ?></p>
			</a>

			<a href="#ninja" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-mailchimp.png">
				</div>

				<p class="lc-premium-feature-description"><?php _e( 'MailChimp Extension for Ninja Forms', 'live-composer-page-builder' ); ?></p>
			</a>

			<a href="#ninja" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-payments.png">
				</div>

				<p class="lc-premium-feature-description"><?php _e( 'PayPal Payments for Ninja Forms', 'live-composer-page-builder' ); ?></p>
			</a>


			<a href="#designs" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-designs.png">
				</div>

				<p class="lc-premium-feature-description"><?php _e( '30+ Ready-To-Use Page Designs', 'live-composer-page-builder' ); ?></p>
			</a>


			<a href="#social" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-social.png">
				</div>

				<p class="lc-premium-feature-description"><?php _e( 'Extensive Social Sharing Plugin', 'live-composer-page-builder' ); ?></p>
			</a>

			<a href="#support" class="lc-premium-feature" tabindex="0" >
				<div class="lc-premium-feature-screenshot">
					<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/icon-support.png">
				</div>

				<p class="lc-premium-feature-description"><?php _e( 'Same Day Premium Support', 'live-composer-page-builder' ); ?></p>
			</a>
		</div>

		<p class="lc-panel-cta lc-align-center"><a href="#" class="button button-primary button-hero">Get Official Live Composer Theme</a></p>
	</div>

	<a name="woo">&nbsp;</a>
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
		<!-- <div class="lc-text-center" style="width:100%;">
			<p><a href="#" class="button button-primary button-hero">Get Official Live Coposer Theme</a></p>
		</div> -->
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>


	<a name="plugins">&nbsp;</a>
	<div class="dslc-panel lc-divided-panels padding-medium">
		<div class="lc-panel-half">
			<h3 class="lc-huge margin-top-half"><?php _e( 'Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Our official theme comes bundled with premium modules to extend design &amp; development possibilities.', 'live-composer-page-builder' ); ?></p>
			<!-- <p><a href="#" class="button button-primary button-hero">Get Official Live Coposer Theme</a></p> -->
		</div>
		<div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-mink-extensions.png">
		</div>

		<ul class="lc-column-list">
			<li><span class="dashicons dashicons-video-alt3"></span> YouTube/Vimeo Video Embed</li>
			<li><span class="dashicons dashicons-images-alt2"></span> Gallery Images Grid</li>
			<li><span class="dashicons dashicons-location"></span> Google Maps Module</li>
			<li><span class="dashicons dashicons-image-flip-horizontal"></span> Before/After Image</li>
			<li><span class="dashicons dashicons-carrot"></span> Additional Icons</li>
			<li><span class="dashicons dashicons-images-alt"></span> +47 Element Animations</li>
			<li><span class="dashicons dashicons-leftright"></span> Prev./Next Post Links</li>
			<li><span class="dashicons dashicons-slides"></span> Per Page Content Width</li>
		</ul>
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin lc-border-top">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>



	<a name="acf">&nbsp;</a>
	<div class="dslc-panel lc-panel-acf lc-divided-panels padding-medium">
		<div class="lc-panel-half">
			<h3 class="lc-huge"><?php _e( 'Custom Post Types and Advanced Custom Fields Integration', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Collect PayPal payments or subscribe your visitors to MailChimp using any Ninja Form instance on your website.', 'live-composer-page-builder' ); ?><br /><br /></p>
			<!-- <p><a href="#" class="button button-primary button-hero">Get Official Live Coposer Theme</a></p> -->
		</div>
		<div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>images/lc-acf.png">
		</div>

		<ul class="lc-column-list">
			<li><span class="dashicons dashicons-video-alt3"></span> Video Embed</li>
			<li><span class="dashicons dashicons-images-alt2"></span> Gallery Images Grid</li>
			<li><span class="dashicons dashicons-location"></span> Google Maps</li>
			<li><span class="dashicons dashicons-image-flip-horizontal"></span> Before/After Image</li>
			<li><span class="dashicons dashicons-carrot"></span> Additional Icons</li>
			<li><span class="dashicons dashicons-images-alt"></span> +47 Element Animations</li>
			<li><span class="dashicons dashicons-leftright"></span> Prev./Next Post Links</li>
			<li><span class="dashicons dashicons-slides"></span> Per Page Content Width</li>
		</ul>
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>



	<a name="slider">&nbsp;</a>
	<div class="dslc-panel lc-divided-panels padding-medium">
		<div class="lc-panel-half">
			<h3 class="lc-huge"><?php _e( 'Premium&nbsp;Slider Included', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Combine Live Composer with a theme that was created form scratch speccially for Live Composer. ', 'live-composer-page-builder' ); ?></p>
			<!-- <p><a href="#" class="button button-primary button-hero">Get Official Live Coposer Theme</a></p> -->
		</div>
		<div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-slider.png">
		</div>

		<ul class="lc-column-list">
			<li><span class="dashicons dashicons-video-alt3"></span> Video Embed</li>
			<li><span class="dashicons dashicons-images-alt2"></span> Gallery Images Grid</li>
			<li><span class="dashicons dashicons-location"></span> Google Maps</li>
			<li><span class="dashicons dashicons-image-flip-horizontal"></span> Before/After Image</li>
			<li><span class="dashicons dashicons-carrot"></span> Additional Icons</li>
			<li><span class="dashicons dashicons-images-alt"></span> +47 Element Animations</li>
			<li><span class="dashicons dashicons-leftright"></span> Prev./Next Post Links</li>
			<li><span class="dashicons dashicons-slides"></span> Per Page Content Width</li>
		</ul>
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin lc-border-top">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>


	<a name="ranking">&nbsp;</a>
	<div class="dslc-panel lc-divided-panels lc-panel- padding-medium"
		style="background:#f7f7f9 no-repeat url(<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-seo.png) top center / contain" >
		<div class="lc-text-center">
			<p class="lc-panel-icon-hero"><span class="dashicons dashicons-awards"></span></p>
			<h3 class="lc-huge"><?php _e( 'Professional SEO Tools Included', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-description"><?php _e( 'Get your game to a whole new level. Combine Live Composer with a theme that was created form scratch speccially for Live&nbsp;Composer. ', 'live-composer-page-builder' ); ?></p>
		</div>
		<ul class="lc-column-list"  >
			<li><span class="dashicons dashicons-yes"></span> 30 Professionally Designed Pages</li>
			<li><span class="dashicons dashicons-yes"></span> 20 Premium Flat Design Illustrations</li>
			<li><span class="dashicons dashicons-yes"></span> Ready-To-Use SEO Content</li>
			<li><span class="dashicons dashicons-yes"></span> Premium Line Icons Set</li>
		</ul>
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>



	<a name="menu">&nbsp;</a>
	<div class="dslc-panel lc-divided-panels padding-medium">
		<div class="lc-panel-half">
			<h3 class="lc-huge"><?php _e( 'Responsive&nbsp;Mega Menu', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Combine Live Composer with a theme that was created form scratch speccially for Live Composer. ', 'live-composer-page-builder' ); ?></p>
			<!-- <p><a href="#" class="button button-primary button-hero">Get Official Live Coposer Theme</a></p> -->
		</div>
		<div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-menu.png">
		</div>

		<ul class="lc-column-list">
			<li><span class="dashicons dashicons-video-alt3"></span> Video Embed</li>
			<li><span class="dashicons dashicons-images-alt2"></span> Gallery Images Grid</li>
			<li><span class="dashicons dashicons-location"></span> Google Maps</li>
			<li><span class="dashicons dashicons-image-flip-horizontal"></span> Before/After Image</li>
			<li><span class="dashicons dashicons-carrot"></span> Additional Icons</li>
			<li><span class="dashicons dashicons-images-alt"></span> +47 Element Animations</li>
			<li><span class="dashicons dashicons-leftright"></span> Prev./Next Post Links</li>
			<li><span class="dashicons dashicons-slides"></span> Per Page Content Width</li>
		</ul>
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin lc-border-top">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>


	<a name="ninja">&nbsp;</a>
	<div class="dslc-panel lc-panel-ninjaforms lc-divided-panels padding-medium"
		style="background-image:url(<?php echo DS_LIVE_COMPOSER_URL; ?>images/lc-ninja.png);">
		<div class="lc-panel-half">
			<h3 class="lc-huge"><?php _e( 'Advanced Ninja Form Integrations ', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Collect PayPal payments or subscribe your visitors to MailChimp using any Ninja Form instance on your website.', 'live-composer-page-builder' ); ?><br /><br /></p>

			<ul class="lc-column-list">
				<li><span class="dashicons dashicons-video-alt3"></span> Video Embed</li>
				<li><span class="dashicons dashicons-images-alt2"></span> Gallery Images Grid</li>
				<li><span class="dashicons dashicons-location"></span> Google Maps</li>
			</ul>
			<!-- <p><a href="#" class="button button-primary button-hero">Get Official Live Coposer Theme</a></p> -->
		</div>
		<!-- <div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>images/lc-ninja.png">
		</div> -->
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin lc-border-top">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>



	<a name="designs">&nbsp;</a>
	<div class="dslc-panel lc-divided-panels lc-panel-designs lc-dark-panel padding-medium"
		style="background:#323750 no-repeat url(<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-designs.png) bottom center / 90%" >
		<div class="lc-text-center">
			<p class="lc-panel-icon-hero"><span class="dashicons dashicons-art"></span></p>
			<h3 class="lc-huge"><?php _e( 'Premium Design Resources', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-description"><?php _e( 'Get your game to a whole new level. Combine Live Composer with a theme that was created form scratch speccially for Live&nbsp;Composer. ', 'live-composer-page-builder' ); ?></p>
		</div>
		<ul class="lc-column-list"  >
			<li><span class="dashicons dashicons-yes"></span> 30 Professionally Designed Pages</li>
			<li><span class="dashicons dashicons-yes"></span> 20 Premium Flat Design Illustrations</li>
			<li><span class="dashicons dashicons-yes"></span> Ready-To-Use SEO Content</li>
			<li><span class="dashicons dashicons-yes"></span> Premium Line Icons Set</li>
		</ul>
		<div class="lc-text-center" style="width:100%;">
			<p><a href="#" class="button button-primary button-hero">Get Official Live Coposer Theme</a></p>
		</div>
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>

	<a name="social">&nbsp;</a>
	<div class="dslc-panel lc-panel-socialshare lc-divided-panels padding-medium"
		style="background-image:url(<?php echo DS_LIVE_COMPOSER_URL; ?>images/lc-social.png);">
		<div class="lc-panel-half">
			<h3 class="lc-huge"><?php _e( 'Social Share Plugin', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Collect PayPal payments or subscribe your visitors to MailChimp using any Ninja Form instance on your website.', 'live-composer-page-builder' ); ?><br /><br /></p>

			<ul class="lc-column-list">
				<li><span class="dashicons dashicons-video-alt3"></span> Video Embed</li>
				<li><span class="dashicons dashicons-images-alt2"></span> Gallery Images Grid</li>
				<li><span class="dashicons dashicons-location"></span> Google Maps</li>
			</ul>
			<!-- <p><a href="#" class="button button-primary button-hero">Get Official Live Coposer Theme</a></p> -->
		</div>
		<!-- <div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>images/lc-ninja.png">
		</div> -->
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin lc-border-top">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>


	<a name="support">&nbsp;</a>
	<div class="dslc-panel lc-divided-panels padding-medium">
		<div class="lc-panel-half">
			<h3 class="lc-huge"><?php _e( 'Premium Same Day Support', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Get your game to a whole new level. Combine Live Composer with a theme that was created form scratch speccially for Live Composer. ', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-support.png">
		</div>
	</div>
	<div class="dslc-panel lc-panel-cta lc-divided-panels padding-medium no-top-margin lc-border-top">
		<div class="lc-panel-half">
			<p class="lc-feature-description"><?php _e( 'This feature is part of our official premium theme package.', 'live-composer-page-builder' ); ?></p>
		</div>
		<div class="lc-panel-half">
			<p><a href="#" class="button button-primary button-hero">Get It Now</a></p>
		</div>
	</div>

</div>