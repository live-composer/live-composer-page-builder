<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
?>
<div class="wp-clearfix" id="dslc-settings-frame">

	<ul class="nav-subtabs wp-clearfix widget-inside" id="dslc-settings-column">
		<li class="dslc-submenu-section">
			<a href="#general"  data-nav-to="<?php echo 'tab-1' ?>" class="nav-subtab <?php echo $anchor == 'tab-1' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-admin-settings"></span> <?php _e( 'General Options', 'live-composer-page-builder' ) ?>
			</a>
		</li>
		<li class="dslc-submenu-section">
			<a href="#performance"  data-nav-to="<?php echo 'tab-1' ?>" class="nav-subtab <?php echo $anchor == 'tab-1' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-dashboard"></span> <?php _e( 'Performance', 'live-composer-page-builder' ) ?>
			</a>
		</li>
		<li class="dslc-submenu-section">
			<a href="#other"  data-nav-to="<?php echo 'tab-1' ?>" class="nav-subtab <?php echo $anchor == 'tab-1' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-admin-tools"></span> <?php _e( 'Other', 'live-composer-page-builder' ) ?>
			</a>
		</li>
		<li class="dslc-submenu-section">
			<a href="#navigation"  data-nav-to="<?php echo 'tab-1' ?>" class="nav-subtab <?php echo $anchor == 'tab-1' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-menu"></span> <?php _e( 'Navigation Module', 'live-composer-page-builder' ) ?>
			</a>
		</li>
		<li class="dslc-submenu-section">
			<a href="#widgets"  data-nav-to="<?php echo 'tab-1' ?>" class="nav-subtab <?php echo $anchor == 'tab-1' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-welcome-widgets-menus"></span> <?php _e( 'Widgets Module', 'live-composer-page-builder' ) ?>
			</a>
		</li>
		<li class="dslc-submenu-section">
			<a href="#access-control"  data-nav-to="<?php echo 'tab-1' ?>" class="nav-subtab <?php echo $anchor == 'tab-1' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-admin-network"></span> <?php _e( 'Access Control', 'live-composer-page-builder' ) ?>
			</a>
		</li>
		<li class="dslc-submenu-section">
			<a href="#features-control"  data-nav-to="<?php echo 'tab-1' ?>" class="nav-subtab <?php echo $anchor == 'tab-1' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-forms"></span> <?php _e( 'Features Control', 'live-composer-page-builder' ) ?>
			</a>
		</li>
		<li class="dslc-submenu-section">
			<a href="#cpt-slugs"  data-nav-to="<?php echo 'tab-1' ?>" class="nav-subtab <?php echo $anchor == 'tab-1' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-index-card"></span> <?php _e( 'Post Types', 'live-composer-page-builder' ) ?>
			</a>
		</li>
	</ul>

	<div id="dslc-setings-liquid">

		<form method="post" action="options.php" class="dslc-settings-form">
		<?php echo settings_fields( 'dslc_plugin_options' ); ?>

			<!-- <div class="tab" <?php echo $anchor == 'tab-1' ? 'style="display: block"' : ''?> id="tab-for-tab-1"> -->
			<a name="general"></a>
			<div class="dslc-panel">
					<?php do_settings_sections( 'dslc_plugin_options' ); ?>
					<?php submit_button(); ?>
			</div>
			<a name="performance"></a>
			<a href="#dslc-top" class="dslc-scroll-back"><span class="dashicons dashicons-arrow-up-alt"></span> Top</a>
			<div class="dslc-panel">
					<?php do_settings_sections( 'dslc_plugin_options_performance' ); ?>
					<?php submit_button(); ?>
			</div>
			<a name="other"></a>
			<a href="#dslc-top" class="dslc-scroll-back"><span class="dashicons dashicons-arrow-up-alt"></span> Top</a>
			<div class="dslc-panel">
					<?php do_settings_sections( 'dslc_plugin_options_other' ); ?>
					<?php submit_button(); ?>
			</div>
			<a name="navigation"></a>
			<a href="#dslc-top" class="dslc-scroll-back"><span class="dashicons dashicons-arrow-up-alt"></span> Top</a>
			<div class="dslc-panel">
					<?php do_settings_sections( 'dslc_plugin_options_navigation_m' ); ?>
					<?php submit_button(); ?>
			</div>
			<a name="widgets"></a>
			<a href="#dslc-top" class="dslc-scroll-back"><span class="dashicons dashicons-arrow-up-alt"></span> Top</a>
			<div class="dslc-panel">
					<?php do_settings_sections( 'dslc_plugin_options_widgets_m' ); ?>
					<?php submit_button(); ?>
			</div>
			<a name="access-control"></a>
			<a href="#dslc-top" class="dslc-scroll-back"><span class="dashicons dashicons-arrow-up-alt"></span> Top</a>
			<div class="dslc-panel">
					<?php do_settings_sections( 'dslc_plugin_options_access_control' ); ?>
					<?php submit_button(); ?>
			</div>
			<a name="features-control"></a>
			<a href="#dslc-top" class="dslc-scroll-back"><span class="dashicons dashicons-arrow-up-alt"></span> Top</a>
			<div class="dslc-panel">
					<?php do_settings_sections( 'dslc_plugin_options_features' ); ?>
					<?php submit_button(); ?>
			</div>
			<a name="cpt-slugs"></a>
			<a href="#dslc-top" class="dslc-scroll-back"><span class="dashicons dashicons-arrow-up-alt"></span> Top</a>
			<div class="dslc-panel">
					<?php do_settings_sections( 'dslc_plugin_options_cpt_slugs' ); ?>
					<?php submit_button(); ?>
			</div>
			<!-- </div> -->


		
		</form>
	</div>
</div>