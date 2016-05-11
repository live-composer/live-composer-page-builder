<div class="wrap lc-wrap">

<div class="dslc-panel" id="keep-it-secure">
	<div class="dslc-panel-content">
		<h2><?php _e( 'Keep Your Website Secure', 'live-composer-page-builder' ); ?></h2>
		<p class="about-description"><?php _e( 'Security updates', 'live-composer-page-builder' ); ?> &#8226; <?php _e( 'New features', 'live-composer-page-builder' ); ?> &#8226;  <?php _e( 'Extension releases', 'live-composer-page-builder' ); ?></p>

		<div class="dslc-panel-column-container">
			<div class="dslc-panel-column">
				<h3><?php _e( 'Email Notifications', 'live-composer-page-builder' ); ?></h3>
				<p><?php _e( 'Get notifications on Live Composer development, security updates, and relevant WordPress resources.', 'live-composer-page-builder' ); ?></p>
				<form method="POST" action="https://lumbermandesigns.activehosted.com/proc.php" id="_form_11_" class="activecampaign_form" novalidate>
					<input type="hidden" name="u" value="11" />
					<input type="hidden" name="f" value="11" />
					<input type="hidden" name="s" />
					<input type="hidden" name="c" value="0" />
					<input type="hidden" name="m" value="0" />
					<input type="hidden" name="act" value="sub" />
					<input type="hidden" name="v" value="2" />
					<div class="_form-content">
					<?php
						$current_user = wp_get_current_user();

						if ( ! ( $current_user instanceof WP_User ) )
							return;

						$current_user_email = $current_user->user_email;
						$current_user_name = $current_user->user_firstname;
					?>
						<div>
							<input type="text" name="email" id="dslc_activecampaign_email" placeholder="Email" value="<?php esc_attr_e( $current_user_email ); ?>" required/>
						</div>
						<div>
							<input type="text" name="firstname" id="dslc_activecampaign_name" placeholder="First Name" required value="<?php esc_attr_e( $current_user_name ); ?>" />
						</div>
						<button id="_form_11_submit" class="button button-primary" type="submit">Submit</button>
					</div>
				  	<div class="_form-thank-you"></div>
				  	<br>
				</form>
			</div>
			<div class="dslc-panel-column">
				<h3><?php _e( "Let's be Friends", 'live-composer-page-builder' ); ?></h3>
				<p><?php _e( 'We share our story of the page builder development, what works well and where we failed.', 'live-composer-page-builder' ); ?></p>
				<ul>
					<li><a class="dslc-panel-icon dslc-panel-facebook-page" href="//www.facebook.com/livecomposer" traget="_blank"><?php _e( 'Notifications on Facebook', 'live-composer-page-builder' ); ?></a></li>
					<li><a class="dslc-panel-icon dslc-panel-twitter" href="//twitter.com/intent/user?screen_name=LiveComposerWP" traget="_blank"><?php _e( 'Team Updates on Twitter', 'live-composer-page-builder' ); ?></a></li>
					<li><a class="dslc-panel-icon dslc-panel-show-work" href="//livecomposerplugin.com/support/support-request/?utm_source=wp-admin&utm_medium=lc-intro&utm_campaign=ShowUsYourWork" traget="_blank"><?php _e( 'Show Us Your Work', 'live-composer-page-builder' ); ?></a></li>
				</ul>
			</div>
			<div class="dslc-panel-column dslc-panel-last">
				<h3><?php _e( "You're not alone", 'live-composer-page-builder' ); ?></h3>
				<p><?php _e( 'There are 20,000+ of Live Composer users. What to see what others do with it or share your work?', 'live-composer-page-builder' ); ?></p>
				<ul>
					<li><a class="dslc-panel-icon dslc-panel-facebook" href="//www.facebook.com/groups/livecomposer/" traget="_blank"><?php _e( 'Join Private Users Group', 'live-composer-page-builder' ); ?></a></li>
					<li><span class="dashicons dashicons-heart"></span> <?php _e( 'Share your project', 'live-composer-page-builder' ); ?></li>
					<li><span class="dashicons dashicons-nametag"></span> <?php _e( 'Meet other creators', 'live-composer-page-builder' ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="dslc-panel" id="new-lc-coming">
	<div class="dslc-panel-content">
		<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/livecomposer-mink-curious.png" class="mink-illustration">
		<h2><?php _e( 'All New Live Composer is Coming!', 'live-composer-page-builder' ); ?></h2>
		<p class="about-description"><?php _e( 'We\'re releasing soon our all new page builder and you\'ll love it.', 'live-composer-page-builder' ); ?></p>
		<a href="//livecomposerplugin.com/live-composer-2-coming/?utm_source=wp-admin&utm_medium=lc2-iscoming-block&utm_campaign=bethefirsttogetit" class="button button-primary button-hero load-customize hide-if-no-customize" target="_blank"><span class="dashicons dashicons-tickets"></span> Be the First to Get It</a>

		<hr>

		<div class="dslc-panel-column-container">
			<div class="dslc-panel-column">
				<h3><span class="dashicons dashicons-dashboard"></span> <?php _e( 'Extremely Fast', 'live-composer-page-builder' ); ?></h3>
				<p><?php _e( 'New Live Composer is completely rewritten using JavaScript. It\'s fast and reliable on any server delivering a great user experience and faster site loading times.', 'live-composer-page-builder' ); ?></p>
			</div>
			<div class="dslc-panel-column">
				<h3><span class="dashicons dashicons-update"></span> <?php _e( "Better Integrated", 'live-composer-page-builder' ); ?></h3>
				<p><?php _e( 'We redesigned user interface from scratch. The new version is better integrated with WordPress UI making it more effective for both advacned and new users.', 'live-composer-page-builder' ); ?></p>
			</div>
			<div class="dslc-panel-column dslc-panel-last">
				<h3><span class="dashicons dashicons-unlock"></span> <?php _e( "100% Open Source", 'live-composer-page-builder' ); ?></h3>
				<p><?php _e( 'Unlike other popular page builders, Live Composer remains to be 100% open source plugin. Build premium theme business with our page builder. ', 'live-composer-page-builder' ); ?></p>
			</div>
		</div>
	</div>
</div>

<br>
<hr>
<h2 class="dslc-subsection-title">Extend Live Composer with <a href="https://livecomposerplugin.com/add-ons/?utm_source=wp-admin&utm_medium=extension-block&utm_campaign=section-title" target="_blank">Free Add-Ons</a></h2>

<div class="extension-browser rendered">
	<div class="extensions wp-clearfix">

		<div class="extension" tabindex="0" >
			<div class="extension-screenshot">
				<img alt="" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-extension-videoembed.png">
			</div>

			<a href="//livecomposerplugin.com/add-ons/?utm_source=wp-admin&utm_medium=extension-block&utm_campaign=video-embed" target="_blank" class="more-details">More Details</a>

			<h2 class="extension-name"><em>Add-On:</em> Video Embed <span class="price"><span class="dashicons dashicons-cart"></span> Free</span></h2>
			<div class="extension-actions">
				<a href="//livecomposerplugin.com/add-ons/?utm_source=wp-admin&utm_medium=extension-block&utm_campaign=video-embed" target="_blank" class="button button-secondary activate">Details</a>
				<a href="//livecomposerplugin.com/downloads/video-embed/?utm_source=wp-admin&utm_medium=extension-block&utm_campaign=video-embed" target="_blank" class="button button-primary load-customize hide-if-no-customize">Free Download</a>
			</div>

			<!-- <div class="extension-update">Update Available</div> -->
		</div>

		<div class="extension" tabindex="0" >
			<div class="extension-screenshot">
				<img alt="" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-extension-animations.png">
			</div>

			<a href="//livecomposerplugin.com/add-ons/?utm_source=wp-admin&utm_medium=extension-block&utm_campaign=animations" target="_blank" class="more-details">More Details</a>

			<h2 class="extension-name"><em>Add-On:</em> Animations+ <span class="price"><span class="dashicons dashicons-cart"></span> Free</span></h2>
			<div class="extension-actions">
				<a href="//livecomposerplugin.com/add-ons/?utm_source=wp-admin&utm_medium=extension-block&utm_campaign=animations" target="_blank" class="button button-secondary activate">Details</a>
				<a href="//livecomposerplugin.com/downloads/additional-animations/?utm_source=wp-admin&utm_medium=extension-block&utm_campaign=animations" target="_blank" class="button button-primary load-customize hide-if-no-customize">Free Download</a>
			</div>

			<!-- <div class="extension-update">Update Available</div> -->
		</div>

		<div class="extension add-new-extension"><a href="//livecomposerplugin.com/add-ons/?utm_source=wp-admin&utm_medium=extension-block&utm_campaign=more-addons" target="_blank"><div class="extension-screenshot"><span></span></div><h2 class="extension-name">More Add-Ons Available</h2></a></div></div>

</div><?php /* extensions browser */ ?>

<?php
/**
 * ----------------------------------------------------------------------
 * Themes Section
 */
?>

<hr>
<h2 class="dslc-subsection-title">Customize Everything With Our <a href="https://livecomposerplugin.com/themes/?utm_source=wp-admin&utm_medium=theme-block&utm_campaign=section-title" target="_blank">Free Themes</a></h2>

<div class="extension-browser rendered">
	<div class="extensions wp-clearfix">

		<div class="extension" tabindex="0" >
			<div class="extension-screenshot">
				<img alt="" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-theme-blank.png">
			</div>

			<a href="//livecomposerplugin.com/themes/?utm_source=wp-admin&utm_medium=theme-block&utm_campaign=blank" target="_blank" class="more-details">More Details</a>

			<h2 class="extension-name"><em>Theme:</em> BLANK Theme <span class="price"><span class="dashicons dashicons-cart"></span> Free</span></h2>
			<div class="extension-actions">
				<a href="//livecomposerplugin.com/themes/?utm_source=wp-admin&utm_medium=theme-block&utm_campaign=blank" target="_blank" class="button button-secondary activate">Details</a>
				<a href="//livecomposerplugin.com/themes/?utm_source=wp-admin&utm_medium=theme-block&utm_campaign=blank" target="_blank" class="button button-primary load-customize hide-if-no-customize">Free Download</a>
			</div>

			<!-- <div class="extension-update">Update Available</div> -->
		</div>

		<div class="extension" tabindex="0" >
			<div class="extension-screenshot">
				<img alt="" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-theme-orao.png">
			</div>

			<a href="//livecomposerplugin.com/themes/?utm_source=wp-admin&utm_medium=theme-block&utm_campaign=orao" target="_blank" class="more-details">More Details</a>

			<h2 class="extension-name"><em>Theme:</em> Orao Creative <span class="price"><span class="dashicons dashicons-cart"></span> Free</span></h2>
			<div class="extension-actions">
				<a href="//livecomposerplugin.com/themes/?utm_source=wp-admin&utm_medium=theme-block&utm_campaign=orao" target="_blank" class="button button-secondary activate">Details</a>
				<a href="//livecomposerplugin.com/themes/?utm_source=wp-admin&utm_medium=theme-block&utm_campaign=orao" target="_blank" class="button button-primary load-customize hide-if-no-customize">Free Download</a>
			</div>

			<!-- <div class="extension-update">Update Available</div> -->
		</div>

		<div class="extension add-new-extension add-new-theme"><a href="//livecomposerplugin.com/themes/?utm_source=wp-admin&utm_medium=theme-block&utm_campaign=more-themes" target="_blank"><div class="extension-screenshot"><span></span></div><h2 class="extension-name">More Themes Available</h2></a></div></div>

</div><?php /* extensions browser */ ?>



</div>