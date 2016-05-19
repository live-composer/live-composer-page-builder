<div class="wrap">
	<?php echo dslc_get_c_option( 'lc_max_width1', 'cool_stuff' ); ?>

	<h2 id="dslc-main-title"><?php echo $extension['title'] ?></h2>
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

				<?php $cnt = 0; foreach( $extension['sections'] as $section ) {  $cnt++;?>

					<a name="<?php echo $section['id'] ?>"></a>

					<?php if ( $cnt > 1 ){?>
						<a href="#dslc-top" class="dslc-scroll-back"><span class="dashicons dashicons-arrow-up-alt"></span> Top</a>
					<?php }?>

					<div class="dslc-panel">
							<?php do_settings_sections( 'dslc_' . $extension['extensionId'] . '_' . $section['id'] ); ?>
							<?php submit_button(); ?>
					</div>
				<?php } ?>
			</form>
		</div>
	</div>
</div>