<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
?>
<div class="wrap lc-wrap">

<?php
		/**
		 * We need help form translators to make Live Composer
		 * accesible on major World languages
		 */

		$dslc_user_locale = get_locale();

		if ( stristr($dslc_user_locale, 'fr_') ) : //17% ?>
			<div class="dslc-settigns-notice red">
			<span class="dashicons dashicons-translation"></span> <strong class="dslc-settigns-notice-heading">Parle français?</strong>
			Aidez notre équipe. <a href="https://translate.wordpress.org/projects/wp-plugins/live-composer-page-builder/stable/fr/default?filters[status]=untranslated&sort[by]=priority&sort[how]=desc" target="_blank">Traduire quelques lignes de texte</a> en français pour nous.
			</div>
<?php elseif ( stristr($dslc_user_locale, 'es_') ) : //7% ?>
			<div class="dslc-settigns-notice red">
			<span class="dashicons dashicons-translation"></span> <strong class="dslc-settigns-notice-heading">¿Habla español?</strong>
			Ayudar a nuestro equipo. <a href="https://translate.wordpress.org/projects/wp-plugins/live-composer-page-builder/stable/es/default?filters[status]=untranslated&sort[by]=priority&sort[how]=desc" target="_blank">Traducir unas pocas líneas de texto</a> en español para nosotros.
			</div>
<?php elseif ( stristr($dslc_user_locale, 'pt_PT') ) : //8% ?>
			<div class="dslc-settigns-notice red">
			<span class="dashicons dashicons-translation"></span> <strong class="dslc-settigns-notice-heading">¿Hablar portugués?</strong>
			Ayudar a nuestro equipo. <a href="https://translate.wordpress.org/projects/wp-plugins/live-composer-page-builder/stable/pt/default?filters[status]=untranslated&sort[by]=priority&sort[how]=desc" target="_blank">Traducir unas pocas líneas de texto</a> al portugués para nosotros.
			</div>
<?php elseif ( stristr($dslc_user_locale, 'pt_BR') ) : //7% ?>
			<div class="dslc-settigns-notice red">
			<span class="dashicons dashicons-translation"></span> <strong class="dslc-settigns-notice-heading">¿Hablar portugués?</strong>
			Ayudar a nuestro equipo. <a href="https://translate.wordpress.org/projects/wp-plugins/live-composer-page-builder/stable/pt-br/default?filters[status]=untranslated&sort[by]=priority&sort[how]=desc" target="_blank">Traducir unas pocas líneas de texto</a> al portugués para nosotros.
			</div>
<?php elseif ( stristr($dslc_user_locale, 'it_') ) : //7% ?>
			<div class="dslc-settigns-notice red">
			<span class="dashicons dashicons-translation"></span> <strong class="dslc-settigns-notice-heading">Parla italiano?</strong>
			Aiuta la nostra squadra. <a href="https://translate.wordpress.org/projects/wp-plugins/live-composer-page-builder/stable/it/default?filters[status]=untranslated&sort[by]=priority&sort[how]=desc" target="_blank">Tradurre un paio di righe di testo</a> in italiano per noi.
			</div>
<?php elseif ( stristr($dslc_user_locale, 'pl_') ) : //3% ?>
			<div class="dslc-settigns-notice red">
			<span class="dashicons dashicons-translation"></span> <strong class="dslc-settigns-notice-heading">Mów po polsku?</strong>
			Pomoc nasz zespół. <a href="https://translate.wordpress.org/projects/wp-plugins/live-composer-page-builder/stable/pl/default?filters[status]=untranslated&sort[by]=priority&sort[how]=desc" target="_blank">Przekłada się kilka linijek tekstu</a> na język polski dla nas.
			</div>
<?php elseif ( stristr($dslc_user_locale, 'de_') ) : //7% ?>
			<div class="dslc-settigns-notice red">
			<span class="dashicons dashicons-translation"></span> <strong class="dslc-settigns-notice-heading">Sprechen Sie Deutsch?</strong>
			Hilfe unseres Teams. <a href="https://translate.wordpress.org/projects/wp-plugins/live-composer-page-builder/stable/de/formal?filters[status]=untranslated&sort[by]=priority&sort[how]=desc" target="_blank">Übersetzen ein paar Zeilen Text</a> in Deutsch für uns.
			</div>
<?php elseif ( stristr($dslc_user_locale, 'ru_') ) : //7% ?>
			<div class="dslc-settigns-notice red">
			<span class="dashicons dashicons-translation"></span> <strong class="dslc-settigns-notice-heading">Говоришь по-русски?</strong>
			Помоги нам перевести плагин. <a href="https://translate.wordpress.org/projects/wp-plugins/live-composer-page-builder/stable/ru/default?filters[status]=untranslated&sort[by]=priority&sort[how]=desc" target="_blank">Переведи пару строчек</a> на русский.
			</div>
<?php endif;?>


<div class="dslc-panel" id="new-products-coming">
	<div class="dslc-panel-content">
		<h2>Live Composer updated</h2>
		<p class="about-description">We changed the code format used to store your pages. Amazing new features are coming soon.</p>
		<a href="https://livecomposerplugin.com/blog/live-composer-1-2/?utm_source=wp-admin&utm_medium=welcome-promo-block-herobutton&utm_campaign=lc-update-1.2" class="button button-primary button-hero" target="_blank"><span class="dashicons dashicons-media-text"></span> See release notes</a>
<!--
		<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/livecomposer-mink-curious.png" class="mink-illustration">

		<div style="text-align:center;">
			<a href="//livecomposerplugin.com/live-composer-2-coming/?utm_source=wp-admin&utm_medium=lc2-iscoming-block&utm_campaign=bethefirsttogetit" class="button button-primary button-hero load-customize hide-if-no-customize" target="_blank"><span class="dashicons dashicons-tickets"></span> Generate 50% OFF coupon</a>
		</div>
-->

	</div>
</div>

<div class="dslc-panel" id="keep-it-secure">
	<div class="dslc-panel-content">
		<h2><span class="dashicons dashicons-lock"></span> <?php _e( 'Keep Your Website Secure', 'live-composer-page-builder' ); ?></h2>
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
				<p><?php _e( 'There are 40,000+ of Live Composer users. What to see what others do with it or share your work?', 'live-composer-page-builder' ); ?></p>
				<ul>
					<li><a class="dslc-panel-icon dslc-panel-facebook" href="//www.facebook.com/groups/livecomposer/" traget="_blank"><?php _e( 'Join Private Users Group', 'live-composer-page-builder' ); ?></a></li>
					<li><span class="dashicons dashicons-heart"></span> <?php _e( 'Share your project', 'live-composer-page-builder' ); ?></li>
					<li><span class="dashicons dashicons-nametag"></span> <?php _e( 'Meet other creators', 'live-composer-page-builder' ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php /* extensions browser */ ?>

<?php
/**
 * ----------------------------------------------------------------------
 * New Releases Section
 */
?>

<!-- <hr> -->
<h2 class="dslc-subsection-title">New Releases From Third-Party Authors <span style="float:right"><a href="mailto:livecomposer@gmail.com" target="_blank" class="button button-secondary activate">Sell Your Stuff to 40K+ WP users</a></span></h2>

<div class="extension-browser rendered">
	<div class="extensions wp-clearfix">

		<!-- Gravity Forms Add-On -->
		<div class="extension" tabindex="0" >
			<div class="extension-screenshot">
				<img alt="gravity-forms Icons" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-extension-gravityforms.png">
			</div>

			<a href="//livecomposerplugin.com/downloads/gravity-forms-module/?utm_source=wp-admin&utm_medium=extension-tab&utm_campaign=gravity-forms" target="_blank" class="more-details">More Details</a>

			<h2 class="extension-name"><em>Add-On:</em> Gravity Forms Module</h2>
			<div class="extension-actions">
				<a href="//livecomposerplugin.com/downloads/gravity-forms-module/?utm_source=wp-admin&utm_medium=extension-tab&utm_campaign=gravity-forms" target="_blank" class="button button-secondary activate">Details</a>
				<a href="//livecomposerplugin.com/downloads/gravity-forms-module/?utm_source=wp-admin&utm_medium=extension-tab&utm_campaign=gravity-forms" target="_blank" class="button button-primary load-customize hide-if-no-customize">Download</a>
			</div>
			<!-- <div class="extension-update">Update Available</div> -->
		</div>

		<!-- Header/Footer Design -->
		<div class="extension" tabindex="0" >
			<div class="extension-screenshot">
				<img alt="Linecons Icons" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-design-header-footer.png">
			</div>

			<a href="//livecomposerplugin.com/downloads/collection-55-ready-use-headerfooter-designs/?utm_source=wp-admin&utm_medium=designs-tab&utm_campaign=design-victor" target="_blank" class="more-details">More Details</a>

			<h2 class="extension-name"><em>Design:</em> Collection of 55 ready to use header/footer designs</h2>
			<div class="extension-actions">
				<a href="//livecomposerplugin.com/downloads/collection-55-ready-use-headerfooter-designs/?utm_source=wp-admin&utm_medium=designs-tab&utm_campaign=design-victor" target="_blank" class="button button-secondary activate">Details</a>
				<a href="//livecomposerplugin.com/downloads/collection-55-ready-use-headerfooter-designs/?utm_source=wp-admin&utm_medium=designs-tab&utm_campaign=design-victor" target="_blank" class="button button-primary load-customize hide-if-no-customize">Download</a>
			</div>
			<!-- <div class="extension-update">Update Available</div> -->
		</div>

		<!-- SEO Video Design -->
		<div class="extension" tabindex="0" >
			<div class="extension-screenshot">
				<img alt="Linecons Icons" src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/lc-design-video-seo.png">
			</div>

			<a href="//livecomposerplugin.com/downloads/linecons-icons-add-on/?utm_source=wp-admin&utm_medium=designs-tab&utm_campaign=video-oleg" target="_blank" class="more-details">More Details</a>

			<h2 class="extension-name"><em>Video:</em> Digital Marketing Agency Video Explainer</h2>
			<div class="extension-actions">
				<a href="//livecomposerplugin.com/downloads/digital-marketing-services/?utm_source=wp-admin&utm_medium=designs-tab&utm_campaign=video-oleg" target="_blank" class="button button-secondary activate">Details</a>
				<a href="//livecomposerplugin.com/downloads/digital-marketing-services/?utm_source=wp-admin&utm_medium=designs-tab&utm_campaign=video-oleg" target="_blank" class="button button-primary load-customize hide-if-no-customize">Download</a>
			</div>
			<!-- <div class="extension-update">Update Available</div> -->
		</div>
	</div>
</div><?php /* extensions browser */ ?>



</div>