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
		<span class="dslc-panel-header">
			<h2>Live Composer updated</h2>
			<h4>New updates every 2 weeks</h4>
		</span>
		<p class="about-description">We update the Live Composer biweekly. If you find a bug please report it to our team via GitHub and we will try to fix it in the next update.</p>
		<a href="https://github.com/live-composer/live-composer-page-builder" class="button button-primary button-hero" target="_blank"><span class="dashicons dashicons-media-text"></span> Report a bug</a>
	</div>
</div>

<div class="dslc-panel" id="extend-livecomposer">
	<div class="dslc-panel-content">
		<h2><?php _e( 'Documentation &amp; Support', 'live-composer-page-builder' ); ?></h2>
		<p class="about-description"><?php _e( 'Find answer to your question in our knowledge base', 'live-composer-page-builder' ); ?></p>

		<form autocomplete="off" class="docs-search-form" id="dslc-docssearch" method="GET" action="//livecomposer.help/search"  target="_blank">
			<input type="hidden" value="" name="collectionId">
			<input type="text" value="" placeholder="Search the knowledge base" class="search-query" title="search-query" name="query">
			<button type="submit" class="hssearch button button-hero button-primary"><span class="dashicons dashicons-search"></span> Search</button>
		</form>

		<div class="dslc-panel-column-container">
			<div class="dslc-panel-column">
				<h3><a href="//livecomposer.help/" target="_blank"><span class="dashicons dashicons-editor-help"></span> <?php _e( 'User Documentation', 'live-composer-page-builder' ); ?></a></h3>
				<p><?php _e( 'The usage documentation is available online. We have great search functionality and add new articles weekly.', 'live-composer-page-builder' ); ?></p>
			</div>
			<div class="dslc-panel-column">
				<h3><a href="//livecomposerplugin.com/support/support-request/" target="_blank"><span class="dashicons dashicons-admin-generic"></span> <?php _e( "Premium User Support", 'live-composer-page-builder' ); ?></a></h3>
				<p><?php _e( 'Live Composer is a free plugin and supported by the community via Facebook Group. Users who buy a paid extension or theme package can get a premium support from the plugin developers for the first 6 month from the date of sale with a possiblity to extend the support coverage.', 'live-composer-page-builder' ); ?></p>
				<ul>
					<li><a class="dslc-panel-icon dslc-panel-facebook" href="//www.facebook.com/groups/livecomposer/" traget="_blank"><?php _e( 'Get Support from Other LC Users', 'live-composer-page-builder' ); ?></a></li>
					<li><a class="dslc-panel-icon dslc-panel-heart" href="//livecomposerplugin.com/support/support-request/" traget="_blank"><?php _e( 'Premium Support for Buyers', 'live-composer-page-builder' ); ?></a></li>
				</ul>
			</div>
			<div class="dslc-panel-column dslc-panel-last">
				<h2><span class="dashicons dashicons-lock"></span> <?php _e( 'Keep Your Website Secure', 'live-composer-page-builder' ); ?></h2>
				<p class="about-description"><?php _e( 'Security updates', 'live-composer-page-builder' ); ?> &#8226; <?php _e( 'New features', 'live-composer-page-builder' ); ?> &#8226;  <?php _e( 'Extension releases', 'live-composer-page-builder' ); ?></p>
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
		</div>
	</div>
</div>

</div>