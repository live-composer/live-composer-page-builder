<?php

/**
 * Table of contents
 *
 * -
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Module Options Panel
 */
class LC_Module_Options_Panel {

	protected $tabs = array();

	// function __construct() {
	// # code...
	// }
	public function add_tab( $id, $title, $section ) {

		$tabs = $this->get_tabs();

		if ( ! in_array( $id, $tabs, true ) ) {
			// Add new tab to the tabs array.
			$tabs[ $id ] = array(
				'title' => $title,
				'id' => $id,
				'section' => $section,
			);
		}

		$this->tabs = $tabs;
	}

	public function get_tabs() {
		return $this->tabs;
	}

	public function get_tabs_render() {
		// Output Tabs.
		$tabs_render = '';

		foreach ( $this->get_tabs() as $tab ) {
			$tabs_render .= '<a href="#" class="dslca-module-edit-options-tab-hook" data-section="' . $tab['section'] . '" data-id="' . $tab['id'] . '">' . $tab['title'] . '</a>';
		}
		return $tabs_render;
	}
}


class LC_Control {

	private $options_panel; // Object of Class LC_Module_Options_Panel.
	private $_module_control = array();

	private $_option_id;
	private $_curr_value;
	private $_starting_value;
	private $_visibility;
	private $_refresh_on_change;
	private $_section;
	private $_control_with_toggle;
	private $_tab_id;
	private $_advanced_action;


	function __construct( $options_panel_obj ) {
		$this->options_panel = $options_panel_obj;
	}

	public function set_control_options( $module_control ) {
		$this->_module_control = $module_control;

		$this->_option_id           = $module_control['id'];
		$this->_section             = $this->get_section();
		$this->_curr_value          = $this->get_curr_value();
		$this->_starting_value      = $this->get_starting_value();
		$this->_visibility          = $this->get_visibility();
		$this->_refresh_on_change   = $this->get_refresh_on_change();
		$this->_control_with_toggle = $this->get_toggle_classes();
		$this->_tab_id              = $this->get_tab_id();
		$this->_advanced_action     = $this->get_advanced_action();
	}


	public function output_option_control() {

		$module_type = $this->_module_control['type'];

		if ( 'group' === $module_type ) {
			// It's not a control but group openner/closer.
			$action = $this->_module_control['action'];
			if ( 'open' === $action ) {
				echo '<div class="dslca-module-control-group dslca-module-edit-option" data-tab="' . esc_attr( $this->_tab_id ) . '">';
				echo '<div class="controls-group-inner">';
				echo $this->get_label();
			} else {
				echo '</div></div>';
			}
		} else {
			// Render the control.
			$this->output_control();
		}
	}

	public function output_control() {

		$module_control = $this->_module_control;

		$ext = ' ';
		if ( isset( $module_control['ext'] ) ) {
			$ext = $module_control['ext'];
		}

		$affect_on_change_append = '';
		if ( isset( $module_control['affect_on_change_el'] ) && isset( $module_control['affect_on_change_rule'] ) ) {
			$affect_on_change_append = 'data-affect-on-change-el="' . $module_control['affect_on_change_el'] . '" data-affect-on-change-rule="' . $module_control['affect_on_change_rule'] . '"';
		}

		$dep = '';

		// Show/hide option controls that depend on current option.
		if ( isset( $module_control['dependent_controls'] ) ) {
			$dep = ' data-dep="' . base64_encode( wp_json_encode( $module_control['dependent_controls'] ) ) . '"';
		}

		$additional_class = '';
		if ( 'color' === $module_control['type'] ) {
			$additional_class = 'dslca-module-edit-option-color dslca-color-option';
		}

		?>

			<div class="dslca-module-edit-option dslca-module-edit-option-<?php echo esc_attr( $module_control['type'] ) . ' ' . $additional_class; ?> dslca-module-edit-option-<?php echo esc_attr( $module_control['id'] ); ?> <?php if ( ! $this->_visibility ) { echo 'dslca-module-edit-option-hidden'; } ?> <?php echo esc_attr( $this->_control_with_toggle ); ?>"
				data-id="<?php echo esc_attr( $module_control['id'] ); ?>"
				<?php echo $dep; /* Base64 code. */ ?>
				data-refresh-on-change="<?php echo esc_attr( $this->_refresh_on_change ); ?>"
				data-section="<?php echo esc_attr( $this->_section ); ?>"
				data-tab="<?php echo esc_attr( $this->_tab_id ); ?>">

				<?php if ( isset( $module_control['help'] ) ) : ?>
					<div class="dslca-module-edit-field-ttip-content"><?php echo $module_control['help']; ?></div>
				<?php endif; ?>

				<?php echo $this->get_label( $module_control ); ?>

				<?php if ( 'text' === $module_control['type'] ) : ?>

					<input type="text" class="dslca-module-edit-field" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo esc_attr( stripslashes( $this->_curr_value ) ); ?>" data-val-bckp="<?php echo esc_attr( stripslashes( $this->_curr_value ) ); ?>" <?php echo $affect_on_change_append ?> />

				<?php elseif ( 'textarea' === $module_control['type'] ) : ?>

					<textarea class="dslca-module-edit-field" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" <?php echo $affect_on_change_append ?>><?php echo stripslashes( $this->_curr_value ); ?></textarea>

				<?php elseif ( 'select' === $module_control['type'] ) :

					$curr_value = $this->get_starting_value();
				?>

					<select class="dslca-module-edit-field" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" <?php echo $affect_on_change_append ?> >
						<?php foreach ( $module_control['choices'] as $select_option ) : ?>
							<option value="<?php echo $select_option['value']; ?>" <?php if ( $curr_value == $select_option['value'] ) { echo 'selected="selected"';} ?>><?php echo $select_option['label']; ?></option>
						<?php endforeach; ?>
					</select>

				<?php elseif ( 'checkbox' === $module_control['type'] ) : ?>

					<?php

					$curr_value = $this->get_starting_value();

					// Current Value Array.
					if ( empty( $curr_value ) ) {

						$curr_value = array();
					} else {

						$curr_value = explode( ' ', trim( $curr_value ) );
					}

					?>

					<div class="dslca-module-edit-option-checkbox-wrapper">

						<?php foreach ( $module_control['choices'] as  $checkbox_option ) : ?>
							<div class="dslca-module-edit-option-checkbox-single">
								<span class="dslca-module-edit-option-checkbox-hook"><span class="dslca-icon <?php if ( in_array( $checkbox_option['value'], $curr_value ) ) { echo 'dslc-icon-check';
} else { echo 'dslc-icon-check-empty';
} ?>"></span><?php echo $checkbox_option['label']; ?></span>
								<input type="checkbox" class="dslca-module-edit-field dslca-module-edit-field-checkbox" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" name="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo $checkbox_option['value']; ?>" <?php if ( in_array( $checkbox_option['value'], $curr_value ) ) { echo 'checked="checked"';} ?> <?php echo $affect_on_change_append ?> />
							</div><!-- .dslca-module-edit-option-checkbox-single -->
						<?php endforeach; ?>

					</div><!-- .dslca-module-edit-option-checkbox-wrapper -->

				<?php elseif ( 'radio' === $module_control['type'] ) : ?>

					<div class="dslca-module-edit-option-radio-wrapper">
						<?php foreach ( $module_control['choices'] as  $checkbox_option ) : ?>
							<div class="dslca-module-edit-option-radio-single">
								<input type="radio" class="dslca-module-edit-field" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" name="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo $checkbox_option['value']; ?>" /> <?php echo $checkbox_option['label']; ?><br>
							</div><!-- .dslca-module-edit-option-radio-single -->
						<?php endforeach; ?>
					</div><!-- .dslca-module-edit-option-radio-wrapper -->

				<?php elseif ( 'color' === $module_control['type'] ) :

					$default_value = false;

	if ( isset( $module_control['std'] ) ) {

		$default_value = $module_control['std'];
	}

					$style = '';

	if ( '' !== $this->_curr_value ) {

		$style = ' style="background: ' . $this->_curr_value . '; "';
	}
					?>

					<input type="text" class="dslca-module-edit-field dslca-module-edit-field-colorpicker" data-alpha="true" <?php echo wp_kses( $style, array(), array() );?> name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo esc_attr( $this->_curr_value ); ?>" data-affect-on-change-el="<?php echo $module_control['affect_on_change_el']; ?>" data-affect-on-change-rule="<?php echo $module_control['affect_on_change_rule']; ?>" <?php if ( $default_value ) : ?> data-val-bckp="<?php echo $default_value; ?>" <?php endif; ?> />

				<?php elseif ( 'slider' === $module_control['type'] ) :

					$slider_min = 0;
					$slider_max = 100;
					$slider_increment = 1;
					$onlypositive = false;

	if ( isset( $module_control['min'] ) ) {
		$slider_min = $module_control['min'];
	}

	if ( isset( $module_control['max'] ) ) {
		$slider_max = $module_control['max'];
	}

	if ( isset( $module_control['increment'] ) ) {
		$slider_increment = $module_control['increment'];
	}

	if ( isset( $module_control['onlypositive'] ) ) {
		$onlypositive = $module_control['onlypositive'];
	}
					?>

					<div class="dslca-module-edit-field-numeric-wrap">
						<input type="number" 
							class="dslca-module-edit-field dslca-module-edit-field-numeric"
							name="<?php echo esc_attr( $module_control['id'] ); ?>"
							value="<?php echo esc_attr( $this->_curr_value ); ?>"
							data-val-bckp="<?php echo esc_attr( $this->_starting_value ); ?>"
							data-id="<?php echo esc_attr( $module_control['id'] ); ?>"
							data-min="<?php echo esc_attr( $slider_min ); ?>"
							data-max="<?php echo esc_attr( $slider_max ); ?>"
							data-increment="<?php echo esc_attr( $slider_increment ); ?>"
							data-onlypositive="<?php echo esc_attr( $onlypositive ); ?>"
							data-ext="<?php echo esc_attr( $ext ); ?>" <?php echo $affect_on_change_append; ?> />
						<span class="dslca-module-edit-field-numeric-ext"><?php echo $module_control['ext']; ?></span>

					</div>

				<?php elseif ( 'font' === $module_control['type'] ) : ?>

					<div class="dslca-module-edit-field-font-wrapper">
						<input type="text" class="dslca-module-edit-field dslca-module-edit-field-font" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo esc_attr( $this->_curr_value ); ?>" <?php echo $affect_on_change_append ?> />
						<span class="dslca-module-edit-field-font-suggest"></span>
					</div>
					<span class="dslca-options-iconbutton dslca-module-edit-field-font-prev"><span class="dslca-icon dslc-icon-chevron-left"></span></span>
					<span class="dslca-options-iconbutton dslca-module-edit-field-font-next"><span class="dslca-icon dslc-icon-chevron-right"></span></span>

				<?php elseif ( 'icon' === $module_control['type'] ) : ?>

					<div class="dslca-module-edit-field-icon-wrapper">
						<input type="text" class="dslca-module-edit-field dslca-module-edit-field-icon" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo esc_attr( $this->_curr_value ); ?>" <?php echo $affect_on_change_append ?> />
						<span class="dslca-module-edit-field-icon-suggest"></span>
					</div>
					<span class="dslca-options-iconbutton dslca-open-modal-hook" data-modal=".dslc-list-icons"><span class="dslca-icon dslc-icon-th"></span></span>

				<?php elseif ( 'image' === $module_control['type'] ) : ?>

					<?php $this->output_image_control( $module_control, $this->_curr_value, $affect_on_change_append ); ?>

				<?php elseif ( 'text_align' === $module_control['type'] ) : ?>

					<div class="dslca-module-edit-option-text-align-wrapper">
						<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $this->_curr_value == 'inherit' ) { echo 'dslca-active';} ?>" data-val="inherit">
							<span class="dslca-icon dslc-icon-remove"></span>
						</div>
						<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $this->_curr_value == 'left' ) { echo 'dslca-active';} ?>" data-val="left">
							<span class="dslca-icon dslc-icon-align-left"></span>
						</div>
						<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $this->_curr_value == 'center' ) { echo 'dslca-active';} ?>" data-val="center">
							<span class="dslca-icon dslc-icon-align-center"></span>
						</div>
						<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $this->_curr_value == 'right' ) { echo 'dslca-active';} ?>" data-val="right">
							<span class="dslca-icon dslc-icon-align-right"></span>
						</div>
						<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $this->_curr_value == 'justify' ) { echo 'dslca-active';} ?>" data-val="justify">
							<span class="dslca-icon dslc-icon-align-justify"></span>
						</div>
					</div>

					<input type="hidden" class="dslca-module-edit-field dslca-module-edit-field-text-align" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo esc_attr( $this->_curr_value ); ?>" <?php echo $affect_on_change_append ?> />

				<?php elseif ( 'box_shadow' === $module_control['type'] ) : ?>

					<?php
					$box_shadow_hor_val = 0;
					$box_shadow_ver_val = 0;
					$box_shadow_blur_val = 0;
					$box_shadow_spread_val = 0;
					$box_shadow_color_val = 'transparent';
					$box_shadow_inset_val = 'outset';
					$box_shadow_val = false;

					if ( '' !== $this->_curr_value ) {
						$box_shadow_val = explode( ' ', $this->_curr_value );
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

					<div class="dslca-module-edit-option-box-shadow-wrapper">

						<?php

						$show_inner_shadow = true;

						if ( isset( $module_control['wihtout_inner_shadow'] ) && true === $module_control['wihtout_inner_shadow'] ) {
							$show_inner_shadow = false;
						}

						if ( $show_inner_shadow ) : ?>
						<div class="dslca-module-edit-option-box-shadow-single">
							<span class="dslca-module-edit-option-checkbox-hook"><?php esc_html_e( 'Inner', 'live-composer-page-builder' ); ?><span class="dslca-icon <?php if ( $box_shadow_inset_val == 'inset' ) { echo 'dslc-icon-check';
} else { echo 'dslc-icon-check-empty';
} ?>"></span></span>
							<input type="checkbox" class="dslca-module-edit-field-checkbox dslca-module-edit-option-box-shadow-inset" <?php if ( $box_shadow_inset_val == 'inset' ) { echo 'checked="checked"';} ?> />
						</div>
						<?php endif; ?>
						<div class="dslca-module-edit-option-box-shadow-single">
							<span><?php esc_html_e( 'Hor', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-box-shadow-hor" step="0.1" type="number" value="<?php echo $box_shadow_hor_val; ?>" />
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
						<div class="dslca-module-edit-option-box-shadow-single dslca-color-option">
							<span><?php esc_html_e( 'Color', 'live-composer-page-builder' ); ?></span><input type="text" class="dslca-module-edit-option-box-shadow-color" data-alpha="true" value="<?php echo $box_shadow_color_val; ?>" />
						</div>

						<input type="hidden" class="dslca-module-edit-field dslca-module-edit-field-box-shadow" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo esc_attr( $this->_curr_value ); ?>" <?php echo $affect_on_change_append ?> />

					</div><!-- .dslca-module-edit-option-box-shadow-wrapper -->

				<?php elseif ( $module_control['type'] == 'text_shadow' ) : ?>

					<?php
					$text_shadow_hor_val = 0;
					$text_shadow_ver_val = 0;
					$text_shadow_blur_val = 0;
					$text_shadow_color_val = 'transparent';

					$text_shadow_val = false;
					if ( '' !== $this->_curr_value ) {
						$text_shadow_val = explode( ' ', $this->_curr_value );
					}

					if ( is_array( $text_shadow_val ) ) {
						$text_shadow_hor_val = str_replace( 'px', '', $text_shadow_val[0] );
						$text_shadow_ver_val = str_replace( 'px', '', $text_shadow_val[1] );
						$text_shadow_blur_val = str_replace( 'px', '', $text_shadow_val[2] );
						$text_shadow_color_val = str_replace( 'px', '', $text_shadow_val[3] );
					}
					?>

					<div class="dslca-module-edit-option-text-shadow-wrapper">

						<div class="dslca-module-edit-option-text-shadow-single">
							<span><?php esc_html_e( 'Hor', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-text-shadow-hor" step="0.1" type="number" value="<?php echo $text_shadow_hor_val; ?>" />
						</div>
						<div class="dslca-module-edit-option-text-shadow-single">
							<span><?php esc_html_e( 'Ver', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-text-shadow-ver" step="0.1" type="number" value="<?php echo $text_shadow_ver_val; ?>" />
						</div>
						<div class="dslca-module-edit-option-text-shadow-single">
							<span><?php esc_html_e( 'Blur', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-text-shadow-blur" step="0.1" type="number" value="<?php echo $text_shadow_blur_val; ?>" />
						</div>
						<div class="dslca-module-edit-option-text-shadow-single dslca-color-option">
							<span><?php esc_html_e( 'Color', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-text-shadow-color" data-alpha="true" type="text" value="<?php echo $text_shadow_color_val; ?>" />
						</div>

						<input type="hidden" class="dslca-module-edit-field dslca-module-edit-field-text-shadow" data-alpha="true" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo esc_attr( $this->_curr_value ); ?>" <?php echo $affect_on_change_append ?> />

					</div><!-- .dslca-module-edit-option-text-shadow-wrapper -->

				<?php elseif ( 'button' === $module_control['type'] ) : ?>

					<?php
						$this->output_button_control( $module_control, $this->_curr_value, $this->get_advanced_action() );

						?>

				<?php else : ?>

					<?php if ( has_action( 'dslc_custom_option_type_' . $module_control['type'] ) ) : ?>

						<?php do_action( 'dslc_custom_option_type_' . $module_control['type'], $module_control, $this->_curr_value, $affect_on_change_append ); ?>

					<?php else : ?>

						<input type="text" class="dslca-module-edit-field" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo esc_attr( $this->_curr_value ); ?>" data-val-bckp="<?php echo $this->_curr_value; ?>" <?php echo $affect_on_change_append ?> />

					<?php endif; ?>

				<?php endif; ?>

			</div><!-- .dslc-module-edit-option -->

		<?php
	}

	/**
	 * Get current value of the option sent via AJAX.
	 *
	 * @param  String $option_id Unique option ID
	 * @return Mixed             Value for this option.
	 */
	private function get_curr_value() {

		$option_id = $this->_option_id;

		if ( isset( $_POST[ $option_id ] ) ) {
			return esc_attr( $_POST[ $option_id ] );
		} else {
			return false;
		}
	}

	private function get_starting_value() {

		$module_control = $this->_module_control;

		/**
		 * If no current value set, the control is disabled.
		 * In this case when you enable the control using toggle
		 * it will be filled with an empty value. That's not right.
		 * Even if the control disable it still has some default value.
		 * This is what $this->_starting_value variable is about –
		 * to set a standard value as a starting point.
		 *
		 * 🔖 RAW CODE CLEANUP
		 */
		$starting_value = '';
		$curr_value = $this->get_curr_value();

		if ( '' === $curr_value && isset( $module_control['std'] ) ) {
			return $module_control['std'];
		} else {
			return $curr_value;
		}
	}

	private function get_visibility() {

		$module_control = $this->_module_control;
		$visibility = true;

		if ( isset( $module_control['visibility'] ) ) {
			$visibility = false;
		}

		if ( 'checkbox' === $module_control['type'] && count( $module_control['choices'] ) < 1 ) {
			$visibility = false;
		}

		return $visibility;
	}

	private function get_advanced_action() {
		$module_control = $this->_module_control;
		$action = '';

		if ( isset( $module_control['advanced_action'] ) ) {
			$action = $module_control['advanced_action'];
		}
		return $action;
	}

	private function get_refresh_on_change() {

		$module_control = $this->_module_control;
		/**
		 * Refresh on change
		 */

		$refresh_on_change = 'active';

		if ( isset( $module_control['refresh_on_change'] ) && ! $module_control['refresh_on_change'] ) {
			$refresh_on_change = 'inactive';
		}

		// Force refresh on change for images ( due to the URL -> ID change ).
		if ( 'image' === $module_control['type'] ) {
			$refresh_on_change = 'active';
		}

		return $refresh_on_change;
	}

	public function get_tab_id() {

		$module_control = $this->_module_control;
		$section        = $this->get_section();

		$tab_id = '';

		if ( isset( $module_control['tab'] ) ) {

			// Lowercase it.
			$tab_id = strtolower( $module_control['tab'] );

			// Replace spaces with _ .
			$tab_id = str_replace( ' ', '_', $tab_id );

			// Add section ID append.
			$tab_id .= '_' . $section;

			$this->options_panel->add_tab( $tab_id, $module_control['tab'], $section );

		} else {

			if ( 'functionality' === $section ) {

				$tab_id = 'general_functionality';
				$control_title = __( 'General', 'live-composer-page-builder' );
				$section = 'functionality';

				$this->options_panel->add_tab( $tab_id, $control_title, $section );

			} else {

				$tab_id = 'general_styling';
				$control_title = __( 'General', 'live-composer-page-builder' );
				$section = 'styling';

				$this->options_panel->add_tab( $tab_id, $control_title, $section );
			}

			$tab_id = 'general_' . $section;
		}

		return $tab_id;
	}

	private function get_section() {

		$module_control = $this->_module_control;
		/**
		 * Section (functionality and styling)
		 */

		if ( isset( $module_control['section'] ) ) {
			return $module_control['section'];
		} else {
			return 'functionality';
		}
	}

	private function get_toggle_classes() {

		$module_control = $this->_module_control;
		/**
		 * List of options that need not toggle
		 * – Enable/Disable Custom CSS
		 * – Show On
		 * – Presets controls
		 * – Animation controls
		 *
		 * 🔖 RAW CODE CLEANUP
		 */
		$controls_without_toggle = array(
			'css_custom',
			'css_show_on',
			'css_save_preset',
			'css_load_preset',
			'css_anim',
			'css_anim_delay',
			'css_anim_duration',
			'css_anim_easing',
			'css_toggle_dropdown',
			'css_toggle_menu',
			'content',
			'css_res_t',
			'css_res_p',
			'image',
			'image_alt',
			'image_alt_link_url',
			'elements',
			'post_elements',
			'carousel_elements',
			'thumb_resize_height',
			'thumb_resize_width',
			'thumb_resize_width_manual',
			'button_icon_id',
			'icon_pos',
			'button_state',
			'resize_width',
			'resize_height',
		);

		$controls_without_toggle = apply_filters( 'dslc_controls_without_toggle', $controls_without_toggle );

		$control_with_toggle = false;

		$sections_with_toggle = array(
			'styling',
			'responsive',
		);

		$curr_value = $this->_curr_value;
		$section = $this->get_section();

		/**
		 * Display styling control toggle [On/Off]
		 */
		if ( ! in_array( $module_control['id'], $controls_without_toggle, true ) && in_array( $section, $sections_with_toggle, true ) && ! stristr( $module_control['id'], 'css_res_' ) ) {
			$control_with_toggle = 'dslca-option-with-toggle';

			if ( '' === stripslashes( $curr_value ) ) {
				$control_with_toggle .= ' dslca-option-off';
			}
		}

		return $control_with_toggle;
	}

	private function get_label() {

		$module_control = $this->_module_control;
		$output = '';
		$output .= '<span class="dslca-module-edit-label">';

		if ( isset( $module_control['label'] ) ) {
			$output .= esc_html( $module_control['label'] );
		}

		/**
		 * Display styling control toggle [On/Off]
		 */
		$control_with_toggle = $this->get_toggle_classes();

		if ( $control_with_toggle ) {
			$output .= '<span class="dslc-control-toggle dslc-icon dslc-icon-"></span>';
		}

		if ( 'icon' === $module_control['type'] ) {
			$output .= '<span class="dslca-module-edit-field-icon-ttip-hook"><span class="dslca-icon dslc-icon-info"></span></span>';
		}

		if ( isset( $module_control['help'] ) ) {
			$output .= '<span class="dslca-module-edit-field-ttip-hook"><span class="dslca-icon dslc-icon-info"></span></span>';
		}

		$output .= '</span>';

		return $output;
	}

	private function output_image_control( $module_control, $curr_value = '', $affect_on_change_append = '' ) {
		?>
		<span class="dslca-module-edit-field-image-add-hook" <?php if ( $this->_curr_value != '' ) { echo 'style="display: none;"';} ?>><span class="dslca-icon dslc-icon-cloud-upload"></span><?php esc_html_e( 'Upload Image', 'live-composer-page-builder' ); ?></span>
		<span class="dslca-module-edit-field-image-remove-hook" <?php if ( $this->_curr_value == '' ) { echo 'style="display: none;"';} ?>><span class="dslca-icon dslc-icon-remove"></span><?php esc_html_e( 'Remove Image', 'live-composer-page-builder' ); ?></span>
		<input type="hidden" class="dslca-module-edit-field dslca-module-edit-field-image" name="<?php echo esc_attr( $module_control['id'] ); ?>" data-id="<?php echo esc_attr( $module_control['id'] ); ?>" value="<?php echo esc_attr( $this->_curr_value ); ?>" <?php echo $affect_on_change_append ?> />
		<?php
	}

	private function output_button_control( $module_control, $curr_value = '', $action = '' ) {
		?>
		<span class="dslca-module-edit-field-button-hook" <?php echo 'onclick="' . esc_attr( $action ) . '"'; ?>><span class="dslca-icon dslc-icon-ok"></span> <?php echo esc_attr( $module_control['label_alt'] ) ?></span>
		<?php
	}

	// private function get_ ( $module_control ) {
	// }
}

