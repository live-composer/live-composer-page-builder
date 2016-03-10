<div class="wrap lc-wrap">

	<?php $dslc_getting_started = get_option( 'dslc_user' ); ?>

	<?php if ( $dslc_getting_started['email'] == '' ) { ?>

		<div class="lc-subscribe">

			<h3><?php _e( 'Keep Your Website Secure', 'live-composer-page-builder' );?></h3>
			<p><?php _e( 'Get email notifications on Live Composer development', 'live-composer-page-builder' );?><br>
			<strong><?php _e( 'Security updates', 'live-composer-page-builder' ); ?></strong> &#8226; <strong><?php _e( 'New features', 'live-composer-page-builder' ); ?></strong> &#8226;  <strong><?php _e( 'Extension releases', 'live-composer-page-builder' ); ?></strong></p>

			<form method="POST" action="https://lumbermandesigns.activehosted.com/proc.php" id="_form_11_" class="activecampaign_form" novalidate>
				<input type="hidden" name="u" value="11" />
				<input type="hidden" name="f" value="11" />
				<input type="hidden" name="s" />
				<input type="hidden" name="c" value="0" />
				<input type="hidden" name="m" value="0" />
				<input type="hidden" name="act" value="sub" />
				<input type="hidden" name="v" value="2" />
				<div class="_form-content">
					<div>
						<input type="text" name="email" id="dslc_activecampaign_email" placeholder="Email" value="<?php echo $dslc_getting_started['email']; ?>" required/>
					</div>
					<br/>
					<div>
						<input type="text" name="firstname" id="dslc_activecampaign_name" placeholder="First Name" required value="<?php echo $dslc_getting_started['name']; ?>" />
					</div>
					<br/>
					<br/>
						<button id="_form_11_submit" class="button button-primary" type="submit">Submit</button>
				</div>
			  	<div class="_form-thank-you"></div>
			</form>

		</div>

	<?php } ?>

	<div class="lc-social">

		<h3><?php _e( 'We are social', 'live-composer-page-builder' );?></h3>

		<div id="share-buttons">

		    <div class="dslc_twitter">
			    <a href="https://twitter.com/livecomposerwp" class="twitter-follow-button" data-show-count="false">Follow @livecomposerwp</a>
			    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			    <span class="dslc_social_text">&mdash; <?php _e( 'plugin development insights', 'live-composer-page-builder' ); ?></span>
			</div>
			<div class="dslc_facebook">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
		    	<div class="fb-follow" data-href="https://www.facebook.com/livecomposer" data-layout="button" data-show-faces="true"></div>
		    	<span class="dslc_social_text">&mdash; <?php _e( 'important update notifications', 'live-composer-page-builder' ); ?></span>
		    </div>
		    <div class="dslc_facebook_group">
		    	<a href="https://www.facebook.com/groups/livecomposer/" target="_blank">LC Facebook Group</a>
		    	<span class="dslc_social_text">&mdash; <?php _e( 'friendly community of plugin users', 'live-composer-page-builder' ); ?></span>
		    </div>

		</div>

	</div>

	<div class="clear"></div>

	<div class="changelog">

		<h3><?php _e( 'Documentation &amp; Support', 'live-composer-page-builder' );?></h3>

		<div class="feature-section">

			<h4><?php _e( 'Usage Documentation', 'live-composer-page-builder' );?></h4>
			<p><?php _e( 'The usage documentation is available online. We have great search functionality and add new articles weekly.<br><a target="_blank" href="http://livecomposerplugin.com/documentation">Go To Usage Documentation &rarr;</a>', 'live-composer-page-builder' );?></p>

			<h4><?php _e( 'Developer Documentation', 'live-composer-page-builder' );?></h4>
			<p><?php _e( 'If you\'re a developer who is interested in building custom modules for Live Composer give a check at the developer documentation.<br><a target="_blank" href="http://livecomposerplugin.com/dev-docs">Go To Developer Documentation &rarr;</a>', 'live-composer-page-builder' );?></p>

			<h4><?php _e( 'Support', 'live-composer-page-builder' );?></h4>
			<p><?php _e( 'If you run into any bugs or issues do let us know.<br><a target="_blank" href="http://livecomposerplugin.com/support/">Go To Support &rarr;</a>', 'live-composer-page-builder' );?></p>

		</div><!-- .feature-section -->

	</div><!-- .changelog -->

	<div class="changelog">

		<h3><?php _e( 'Themes &amp; Add-Ons', 'live-composer-page-builder' );?></h3>

		<div class="feature-section">

			<h4><?php _e( 'Themes', 'live-composer-page-builder' );?></h4>
			<p><?php _e( 'There are a lot of free and premium themes powered by Live Composer.<br><a target="_blank" href="http://livecomposerplugin.com/themes">Check Out The Themes &rarr;</a>', 'live-composer-page-builder' );?></p>

			<h4><?php _e( 'Add-Ons', 'live-composer-page-builder' );?></h4>
			<p><?php _e( 'If you are looking for some extra functionality ( features, modules... ) there are free and premium add-ons.<br><a target="_blank" href="http://livecomposerplugin.com/add-ons">Check Out The Add-Ons &rarr;</a>', 'live-composer-page-builder' );?></p>

		</div><!-- .feature-section -->

	</div><!-- .changelog -->

</div>