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

$today_day = strtoupper( strftime("%A",time()) );

?>
<div class="wrap lc-wrap lc-centered-panels lc-wider-panel lc-tab-extensions">

	<!-- <h2 class="dslc-tab-heading">Extend Live Composer with <a href="https://livecomposerplugin.com/add-ons/?utm_source=wp-admin&utm_medium=extension-tab&utm_campaign=section-title" target="_blank">Free Extensions</a></h2> -->

<?php if ( empty( $extensions ) ) : ?>
	<div class="dslc-panel lc-divided-panels padding-medium">
		<div class="lc-panel-half">
			<h3 class="lc-huge margin-top-half"><?php _e( 'Advanced, time-saving features for professional website developers', 'lbmn' ); ?></h3>
			<p class="lc-larger-text"><?php _e( 'Build feature-reach websites faster with our premium extensions. All add-ons are packed into a single plugin for easy management and updates.' , 'lbmn'); ?></p>
			<p><a href="#" class="button button-primary button-hero">Buy Now For 20% OFF</a> <br /><span class="promo-code">Promo code: <strong>HAPPY-<?php echo $today_day; ?></strong></span></p>
		</div>
		<div class="lc-panel-half lc-image-column">
			<img alt="<?php _e( 'Additional Premium&nbsp;Modules', 'lbmn' ); ?>" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-mink-extensions.png">
		</div>
	</div>
<?php endif; ?>

	<div class="extension-browser rendered">
		<div class="extensions wp-clearfix">
			<?php
				if ( empty( $extensions ) ) :
				$extensions = array(
					'acfsupport' => array(
							'title' => 'ACF Support',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/acfsupport/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/#',
							'description' => 'Advanced Custom Fields integration',
							'rank' => 10,
							'demo' => true,
						),
					'animations' => array(
							'title' => 'Additinal Animations',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/animations/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/#',
							'description' => 'Adds additional animations for modules ( Styling > Animation ).',
							'rank' => 38,
							'demo' => true,
						),
					'beforeafter' => array(
							'title' => 'Before/After Image',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/beforeafter/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/#',
							'description' => 'Before/after image slider module for Live Composer plugin.',
							'rank' => 40,
							'demo' => true,
						),
					'contentwidth' => array(
							'title' => 'Custom Page Content Width',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/contentwidth/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/#',
							'description' => 'Allows you to set different content width ( max width ) on per page basis and per post template basis.',
							'rank' => 48,
							'demo' => true,
						),
					'cptsupport' => array(
							'title' => 'CPT Support',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/cptsupport/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/#',
							'description' => 'Templates for CPT.',
							'rank' => 11,
							'demo' => true,
						),
					'gallery' => array(
							'title' => 'Image Gallery Grid',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/gallery/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/',
							'description' => 'Adds a new module for showing gallery images ( the galleries post type ) in grid/masonry layout. Also works for the project images ( the projects post type ).',
							'rank' => 30,
							'demo' => true,
						),
					'googlemaps' => array(
							'title' => 'Google Maps Module',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/googlemaps/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/google-maps-add-on/',
							'description' => '',
							'rank' => 20,
							'demo' => true,
						),
					'lineicons' => array(
							'title' => 'Linecons Icons',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/lineicons/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/downloads/linecons-icons-add-on/',
							'description' => 'Additional icons for the icon options in Live Composer.',
							'rank' => 35,
							'demo' => true,
						),
					'menu' => array(
							'title' => 'Mega Menu',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/menu/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/#',
							'description' => 'Adds advanced Mega Menu module.',
							'rank' => 15,
							'demo' => true,
						),
					'prevnextpost' => array(
							'title' => 'Previous & Next Posts Links',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/prevnextpost/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/#',
							'description' => 'Adds a new module to be used on single post templates. Shows links to previous and next post ( adjacent to the currently shown one ).',
							'rank' => 45,
							'demo' => true,
						),
					'sliders' => array(
							'title' => 'Sliders Integration',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/sliders/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/#',
							'description' => 'Creates a module for third-party slider plugins.',
							'rank' => 25,
							'demo' => true,
						),
					'video' => array(
							'title' => 'Video Embed Module',
							'thumbnail' => DS_LIVE_COMPOSER_URL . 'images/extensions/video/thumbnail.png',
							'details' => 'https://livecomposerplugin.com/#',
							'description' => '',
							'rank' => 28,
							'demo' => true,
						),
					);
				endif; // If empty.

				// Sort extensions by the rank field. 100 - last / 0 - first.
				usort( $extensions, 'dslc_sort_by_rank' );

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

								<a href="#" target="_blank" class="button button-primary lc-toggle-extension" data-show-if="active" data-id="<?php echo $extension_id; ?>">Deactivate</a>
								<a href="#" target="_blank" class="button button-primary lc-toggle-extension" data-show-if="inactive" data-id="<?php echo $extension_id; ?>">Activate</a>
								<a href="#" target="_blank" class="button button-primary lc-toggle-extension" data-show-if="demo" data-id="<?php echo $extension_id; ?>">Buy to activate</a>

								<a href="#" target="_blank" class="button button-primary lc-toggle-extension" data-show-if="pending" data-id="<?php echo $extension_id; ?>"><span class="dashicons dashicons-update"></span></a>
							</div>
						</div>
					<?php
				}
			?>

			<!-- <div class="extension add-new-extension"><a href="//livecomposerplugin.com/add-ons/?utm_source=wp-admin&utm_medium=extension-tab&utm_campaign=more-addons" target="_blank"><div class="extension-screenshot"><span></span></div><h2 class="extension-name">More Add-Ons Available</h2></a></div></div> -->
		</div>
	</div><?php /* extensions browser */ ?>
</div>