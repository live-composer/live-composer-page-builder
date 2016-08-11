<?php
/**
 * Class-container for custom options in settings panel
 */
class LC_Custom_Settings_Fields {

	/**
	 * Init actions.
	 * Filters methods with preg pattern, so future util
	 * functions won't mess up with custom fields output.
	 */
	static public function init() {

		$methods_list = get_class_methods( __CLASS__ );

		foreach ( $methods_list as $method ) {

			if ( preg_match( '/lc_c_field_(.*)/', $method, $matches ) > 0 ) {

				add_action( 'dslc_custom_option_type_' . $matches[1], [ __CLASS__, $method ] );
			}
		}
	}

	/**
	 * Live Composer Custom Field group margin
	 */
	static public function lc_c_field_group_margin() {

		$box_shadow_hor_val = 0;
		$box_shadow_ver_val = 0;
		$box_shadow_blur_val = 0;
		$box_shadow_spread_val = 0;
		$box_shadow_color_val = 'transparent';
		$box_shadow_inset_val = 'outset';
		$box_shadow_val = false;

		if ( '' !== $curr_value ) {
			$box_shadow_val = explode( ' ', $curr_value );
		}

		if ( is_array( $box_shadow_val ) ) {
			$box_shadow_hor_val = str_replace( 'px', '', $box_shadow_val[0] );
			$box_shadow_ver_val = str_replace( 'px', '', $box_shadow_val[1] );
			$box_shadow_blur_val = str_replace( 'px', '', $box_shadow_val[2] );
			$box_shadow_spread_val = str_replace( 'px', '', $box_shadow_val[3] );
			$box_shadow_color_val = str_replace( 'px', '', $box_shadow_val[4] );

			if ( isset( $box_shadow_val[5] ) ) {
				$box_shadow_inset_val = $box_shadow_val[5];
			}
		}
		?>

		<div class="dslca-module-edit-option-box-shadow-wrapper">←↑→↓

			<div class="dslca-module-edit-option-box-shadow-single">
				<span>←</span><input class="dslca-module-edit-option-box-shadow-hor" step="1" type="number" value="<?php echo $box_shadow_hor_val; ?>" />
			</div>
			<div class="dslca-module-edit-option-box-shadow-single">
				<span><?php esc_html_e( 'Ver', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-box-shadow-ver" step="0.1" type="number" value="<?php echo $box_shadow_ver_val; ?>" />
			</div>
			<div class="dslca-module-edit-option-box-shadow-single">
				<span><?php esc_html_e( 'Blur', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-box-shadow-blur" step="0.1" type="number" value="<?php echo $box_shadow_blur_val; ?>" />
			</div>
			<div class="dslca-module-edit-option-box-shadow-single">
				<span><?php esc_html_e( 'Spread', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-box-shadow-spread" step="0.1" type="number" value="<?php echo $box_shadow_spread_val; ?>" />
			</div>
			<div class="dslca-module-edit-option-box-shadow-single">
				<span><?php esc_html_e( 'Color', 'live-composer-page-builder' ); ?></span><input type="text" class="dslca-module-edit-option-box-shadow-color" value="<?php echo $box_shadow_color_val; ?>" />
			</div>

			<input type="hidden" class="dslca-module-edit-field dslca-module-edit-field-box-shadow" name="<?php echo esc_attr( $module_option['id'] ); ?>" data-id="<?php echo esc_attr( $module_option['id'] ); ?>" value="<?php echo esc_attr( $curr_value ); ?>" <?php echo $affect_on_change_append ?> />

		</div><!-- .dslca-module-edit-option-box-shadow-wrapper --><?php
	}

	/**
	 * Update custom fields values with old ones
	 *
	 * @param  $_POST
	 */
	public static function update_custom_fields() {

	}
}

LC_Custom_Settings_Fields::init();
