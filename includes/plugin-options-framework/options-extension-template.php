<div class="wp-clearfix" id="dslc-settings-frame">

	<ul class="nav-subtabs wp-clearfix widget-inside" id="dslc-settings-column">
		<?php foreach( $extension['sections'] as $section ) :?>
		<li class="dslc-submenu-section">
			<a href="#<?php echo $section['id']; ?>"  data-nav-to="tab-1" class="nav-subtab">

				<?php if ( isset( $section['icon'] ) ) { ?>
					<span class="dashicons dashicons-<?php echo $section['icon'];?>"></span>
				<?php } ?>

				<?php _e( $section['title'], 'live-composer-page-builder' ); ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>

	<div id="dslc-setings-liquid">

		<form method="post" action="options.php" class="dslc-settings-form">
		<?php echo settings_fields( 'dslc_custom_options_' . $extension['extensionId'] ); ?>

			<?php foreach( $extension['sections'] as $section ) { ?>

				<a name="general"></a>
				<div class="dslc-panel">
						<?php echo 'dslc_' . $extension['extensionId'] . '_' . $section['id'] ?>
						<?php do_settings_sections( 'dslc_' . $extension['extensionId'] . '_' . $section['id'] ); ?>
						<?php submit_button(); ?>
				</div>
			<?php } ?>
		</form>
	</div>
</div>