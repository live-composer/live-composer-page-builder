<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
?>
<div class="wp-clearfix" id="dslc-settings-frame">

	<ul class="nav-subtabs wp-clearfix widget-inside" id="dslc-settings-column">
		<?php
		$lc = Live_Composer();
		$settings_sections = $lc->plugin_options->plugin_options_structure;

		// Output links to the plugin settings sections.
		foreach ( $settings_sections as $key => $value ) {

			$icon = 'admin-settings';

			if ( isset( $value['icon'] ) ) {
				$icon = $value['icon'];
			}

			echo '<li class="dslc-submenu-section">';
				echo '<a href="#' . esc_attr($key) . '">';
					echo '<span class="dashicons dashicons-' . esc_attr( $icon ) . '"></span>';
					echo esc_attr( $value['title'] );
				echo '</a>';
			echo '</li>';
		}
		?>
	</ul>

	<div id="dslc-setings-liquid">

		<form method="post" action="options.php" class="dslc-settings-form">
		<?php echo settings_fields( 'dslc_plugin_options' ); ?>

		<?php
		$lc = Live_Composer();
		$settings_sections = $lc->plugin_options->plugin_options_structure;

		$i = 0;
		// Output plugin settings sections.
		foreach ( $settings_sections as $key => $value ) {
			echo '<a name="' . esc_attr( $key ) . '"></a>';

			// Show 'back to the top' link (unless it's the first section).
			if ( 0 !== $i ) {
				echo '<a href="#dslc-top" class="dslc-scroll-back"><span class="dashicons dashicons-arrow-up-alt"></span> Top</a>';
			}

			echo '<div class="dslc-panel">';
				do_settings_sections( $key );
				submit_button();
			echo '</div>';

			$i++;
		}
		?>
		</form>
	</div>
</div>
