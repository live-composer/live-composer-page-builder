<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
?>
<div class="wrap lc-wrap">

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
				<h3><a href="//livecomposer.help/collection/96-extensions-development" target="_blank"><span class="dashicons dashicons-admin-generic"></span> <?php _e( "Developer Docs", 'live-composer-page-builder' ); ?></a></h3>
				<p><?php _e( 'If you\'re a developer who is interested in building custom modules for Live Composer give a check at the developer documentation.', 'live-composer-page-builder' ); ?></p>
				<?php /*
				<ul>
					<li><a href="//livecomposer.help/article/135-how-to-copy-a-page-section-to-another-page/?utm_source=wp-admin&utm_medium=documentation-block&utm_campaign=doc-listing" traget="_blank"><span class="dashicons dashicons-info"></span> Copy/pasting page sections</a></li>
					<li><a href="//livecomposer.help/article/127-post-templates/?utm_source=wp-admin&utm_medium=documentation-block&utm_campaign=doc-listing" traget="_blank"><span class="dashicons dashicons-info"></span> Post templates usage</a></li>
				</ul>
				*/
				?>
			</div>
			<div class="dslc-panel-column dslc-panel-last">
				<h3><a href="//livecomposerplugin.com/support/support-request/?utm_source=wp-admin&utm_medium=documentation-block&utm_campaign=free-support-header" target="_blank"><span class="dashicons dashicons-format-chat"></span> <?php _e( " Support &amp; Community", 'live-composer-page-builder' ); ?></a></h3>
				<p><?php _e( 'If you run into any bugs or issues do let us know.', 'live-composer-page-builder' ); ?></p>
				<ul>
					<li><a class="dslc-panel-icon dslc-panel-github" href="https://github.com/live-composer/live-composer-page-builder/issues" traget="_blank"><?php _e( 'Report a bug (not support!)', 'live-composer-page-builder' ); ?></a></li>	
					<li><a class="dslc-panel-icon dslc-panel-facebook" href="//www.facebook.com/groups/livecomposer/" traget="_blank"><?php _e( 'Free advice from other users', 'live-composer-page-builder' ); ?></a></li>
					<li><a class="dslc-panel-icon dslc-panel-show-work" href="//livecomposerplugin.com/support/?utm_source=wp-admin&utm_medium=documentation-block&utm_campaign=support-info" traget="_blank"><?php _e( 'Get Support Info', 'live-composer-page-builder' ); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>



</div>
