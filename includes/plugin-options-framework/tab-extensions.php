<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

function dslc_sort_by_rank($a, $b) {
	$a_rank = 0;
	$b_rank = 0;

	if ( isset( $a['rank'] ) ) {
		$a_rank = $a['rank'];
	}

	if ( isset( $b['rank'] ) ) {
		$b_rank = $b['rank'];
	}

	return $a_rank - $b_rank;
}

$extensions = array();
$extensions = apply_filters( 'dslc_extensions_meta', $extensions );

$today_day = strtoupper( strftime( "%A",time() ) );

?>
<div class="wrap lc-admin-tab-content lc-wrap lc-centered-panels lc-wider-panel lc-tab-extensions">

	<!-- <h2 class="dslc-tab-heading">Extend Live Composer with <a href="https://livecomposerplugin.com/downloads/extensions/?utm_source=wp-admin&utm_medium=extension-tab&utm_campaign=section-title" target="_blank">Free Extensions</a></h2> -->

<?php
// Get list of all plugin (active and inactive).
$all_plugins = get_plugins();

// ACTIVATE NOTICE: Check if plugin is already installed but not active.
if ( array_key_exists( 'lc-extensions/lc-extensions.php', $all_plugins ) && is_plugin_inactive( 'lc-extensions/lc-extensions.php' ) ) : ?>
	<div class="dslc-panel lc-panel-non-active-plugin">
		<span class="dashicons dashicons-warning" style="color:#D76D50; margin-right:8px;"></span> <?php _e( 'Looks like <strong>Live Composer – Premium Extensions</strong> plugin installed, but not active.', 'live-composer-page-builder' ); ?>
		<a href="#" class="button button-primary lc-activate-plugin" data-plugin="lc-extensions" data-action-nonce="<?php echo wp_create_nonce( 'dslc-ajax-activate-plugin-lc-extensions' ) ?>">Activate It Now</a>
	</div>
<?php endif;

// AD PANEL: If there is no extensions, show ad panel.
if ( empty( $extensions ) ) : ?>
	<div class="dslc-panel lc-divided-panels padding-medium">
		<div class="lc-panel-half">
			<h3 class="lc-huge margin-top-half"><?php _e( 'Advanced, time-saving features for professional website development', 'live-composer-page-builder' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Build feature-reach websites faster with our premium extensions. All add-ons are packed into a single plugin for easy management and updates.' , 'live-composer-page-builder'); ?></p>
			<p><a href="https://livecomposerplugin.com/downloads/extensions/?utm_source=wp-admin&utm_medium=extension-tab&utm_campaign=intro-block" class="button button-primary button-hero" target="_blank">Buy Today For 15% OFF</a> <br /><span class="promo-code">Promo code: <strong>HAPPY-<?php echo $today_day; ?></strong></span></p>
		</div>
		<div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Additional Premium&nbsp;Modules', 'live-composer-page-builder' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-mink-extensions.png">
		</div>
	</div>
<?php endif;

// LICENSE PANEL: If extension is active.
if ( $extensions && is_plugin_active( 'lc-extensions/lc-extensions.php' ) ) {
	$license_manager = new LC_License_Manager;
	$license_status = $license_manager->get_license_status('lc-extensions');

	if ( 'valid' !== $license_status ) {
		$license_status = 'invalid';
	}

	echo '<div data-license-status="' . $license_status . '">';
		// Top license block (shows when issues or no license set).
		echo '<div data-show-if-license="invalid">';
			echo $license_manager->render_license_block('lc-extensions');
		echo '</div>';

		// Tab heading (shows only when there is no problem with license).
		echo '<div class="lc-tab-heading" data-show-if-license="valid">';
		echo '<h1 class="wp-heading-inline">' . __('Premium Extensions', 'live-composer-page-builder') . ' <span class="title-count theme-count">' . count( $extensions ) . '</span> </h1>';
		echo '<a href="#lc-license-block" class="button lc-license-status-button"><span class="dashicons dashicons-yes"></span> License is acitve</a>';
		echo '</div>';
	echo '</div>';

}
?>

	<div class="extension-browser rendered">
		<div class="extensions wp-clearfix">
			<?php
				if ( empty( $extensions ) ) :
				$extensions = array(
					'acfsupport' => array(
							'title' => 'ACF Support',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/acfsupport/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/acf-support/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=acf-support',
							'description' => 'Output any content from custom fields on pages, posts or templates created with Live Composer page builder.',
							'rank' => 10,
							'demo' => true,
						),
					'animations' => array(
							'title' => 'Additinal Animations',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/animations/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/additional-animations/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=aditional-animations',
							'description' => '47 additional animations for Live Composer modules. Extension adds new options into Styling > Animation > On Load Animation. Animate any module with advanced effects when a page gets loaded.',
							'rank' => 38,
							'demo' => true,
						),
					'beforeafter' => array(
							'title' => 'Before/After Image',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/beforeafter/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/beforeafter-image-slider-add-on/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=before-after-slider',
							'description' => 'The best way to highlight visual differences between two images/photos. Useful for redesign projects and architects.',
							'rank' => 40,
							'demo' => true,
						),
					'contentwidth' => array(
							'title' => 'Custom Page Content Width',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/contentwidth/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/per-page-content-width-add-on/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=content-width',
							'description' => 'Allows different widths of the Live Composer content area to be set on different pages/templates.',
							'rank' => 48,
							'demo' => true,
						),
					'cptsupport' => array(
							'title' => 'CPT Support',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/cptsupport/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/cpt-support/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=cpt-support',
							'description' => 'This extension adds full support for Custom Post Types. You can create shared LC templates for any CPT or disable page builder completely for any Custom Post Type on your website.',
							'rank' => 11,
							'demo' => true,
						),
					'gallery' => array(
							'title' => 'Image Gallery Grid',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/gallery/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/gallery-images-grid/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=gallery-module',
							'description' => 'Display the images from your galleries and projects on any page (as images grid or carousel). The extension adds a new module.',
							'rank' => 30,
							'demo' => true,
						),
					'googlemaps' => array(
							'title' => 'Google Maps Module',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/googlemaps/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/google-maps-add-on/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=google-maps',
							'description' => 'Fast and easy way to display a Google map on your Live Composer powered website. The extension adds a new module.',
							'rank' => 20,
							'demo' => true,
						),
					'lineicons' => array(
							'title' => 'Linecons Icons',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/lineicons/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/linecons-icons-add-on/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=lineicons',
							'description' => 'This add-on adds 48 additional icons that will be available in the icon options for all modules that have icons option.',
							'rank' => 35,
							'demo' => true,
						),
					'menu' => array(
							'title' => 'Mega Menu',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/menu/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/mega-menu/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=mega-menu',
							'description' => 'Adds Mega Menu module with advanced and fully customizable design options. Now you can create multicolumn menus with custom icons and responsive mobile menu.',
							'rank' => 15,
							'demo' => true,
						),
					'prevnextpost' => array(
							'title' => 'Previous & Next Posts Links',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/prevnextpost/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/previousnext-post-links-add-on/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=prev-next-links',
							'description' => 'This add-on for Live Composer is a new module that shows links to previous and next post (adjacent to the currently shown one). It works for the custom post types as well, not just blog posts.',
							'rank' => 45,
							'demo' => true,
						),
					'sliders' => array(
							'title' => 'Sliders Integration',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/sliders/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/sliders-integration/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=sliders-integration',
							'description' => 'Creates modules for third-party slider plugins. Drag and drop slider module on the page instead of dealing with shortcodes.',
							'rank' => 25,
							'demo' => true,
						),
					'video' => array(
							'title' => 'Video Embed Module',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/video/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/video-embed/?utm_source=lcproext&utm_medium=extensions-list&utm_campaign=video-module',
							'description' => 'Easily embed videos from various sources ( YouTube, Vimeo, Hulu, Vine... ) using drag and drop. The extension adds a new module. No need to mess with shortcodes or iframes to place video on your page.',
							'rank' => 28,
							'demo' => true,
						),
					);
				endif; // If empty.

				// Sort extensions by the rank field. 100 - last / 0 - first.
				uasort( $extensions, 'dslc_sort_by_rank' );

				foreach ( $extensions as $extension_id => $extension ) {

					$extension_thumbnail = DS_LIVE_COMPOSER_URL . 'images/lc-placeholder.png';
					if ( isset( $extension['thumbnail'] ) && !empty( $extension['thumbnail'] ) ) {
						$extension_thumbnail = $extension['thumbnail'];
					}

					$extensions_status_att = 'inactive';

					if ( isset( $extension['active'] ) && $extension['active'] ) {
						$extensions_status_att = 'active';
					}

					if ( isset( $extension['demo'] ) && $extension['demo'] ) {
						$extensions_status_att = 'demo';
					}
					?>
						<div class="extension <?php echo 'extension-' . $extension_id?>" data-extension-status="<?php echo $extensions_status_att; ?>" tabindex="0" >
							<div class="extension-screenshot">
								<img alt="<?php echo $extension['title']; ?>" src="<?php echo $extension_thumbnail; ?>">
								<p class="more-details"><?php echo $extension['description']; ?></p>
							</div>

							<h2 class="extension-name"><?php echo $extension['title']; ?>
								<span class="status" data-show-if="active"><span class="dashicons dashicons-yes"></span> active</span>
								<span class="status" data-show-if="inactive"><span class="dashicons dashicons-no-alt"></span> inactive</span>
								<span class="status" data-show-if="pending"><span class="dashicons dashicons-update"></span></span>
							</h2>

							<div class="extension-actions">
								<a href="<?php echo $extension['details']; ?>?utm_source=wp-admin&utm_medium=extension-tab&utm_campaign=<?php echo $extension_id; ?>" target="_blank" class="button button-secondary activate">More Details</a>

								<a href="#" class="button button-primary lc-toggle-extension" data-show-if="active" data-id="<?php echo $extension_id; ?>">Deactivate</a>
								<a href="#" class="button button-primary lc-toggle-extension" data-show-if="inactive" data-id="<?php echo $extension_id; ?>">Activate</a>
								<a href="#" class="button button-primary" data-show-if="pending" onclick="return false;"><span class="dashicons dashicons-update"></span></a>

								<a href="//livecomposerplugin.com/downloads/extensions/?utm_source=wp-admin&utm_medium=extension-tab&utm_campaign=<?php echo $extension_id; ?>" target="_blank" class="button button-primary" data-show-if="demo">Buy to activate</a>
							</div>
						</div>
					<?php
				}
			?>
		</div>
	</div><?php /* extensions browser */ ?>

<?php
// LICENSE PANEL: If extension is active.
if ( $extensions && is_plugin_active( 'lc-extensions/lc-extensions.php' ) ) {
	$license_manager = new LC_License_Manager;
	$license_status = $license_manager->get_license_status('lc-extensions');

	if ( 'valid' !== $license_status ) {
		$license_status = 'invalid';
	}

	// Bottom license block.
	echo '<div data-license-status="' . $license_status . '">';
		echo '<a name="lc-license-block"></a>';
		// Output license block on the bottom when no issues with license detected.
		echo '<div data-show-if-license="valid">';
			echo $license_manager->render_license_block('lc-extensions');
		echo '</div>';
	echo '</div>';
}
?>
</div>
