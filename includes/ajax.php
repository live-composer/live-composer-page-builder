<?php

/**
 * Table of contents
 *
 * - dslc_ajax_add_modules_section ( Echo new modules section HTML )
 * - dslc_ajax_add_module ( Load the module's front ened output)
 * - dslc_ajax_display_module_options ( Display options for a specific module )
 * - dslc_ajax_save_composer ( Save the composer code )
 * - dslc_ajax_save_draft_composer ( Save changes as draft )
 * - dslc_ajax_load_template ( Loads front end output of a specific template )
 * - dslc_ajax_import_template ( Loads front ened output of an exported template )
 * - dslc_ajax_save_template ( Save template for future use )
 * - dslc_ajax_delete_template ( Deletes a saved template )
 * - dslc_ajax_get_new_module_id ( Returns a new unique ID, similar to post ID )
 * - dslc_ajax_import_modules_section ( Loads front-end output for exported section )
 * - dslc_ajax_dm_module_defaults_code ( Returns the code to alter the defaults for the module options )
 * - dslc_ajax_save_preset ( Save module styling preset )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Add/display a new module section
 *
 * @since 1.0
 */
function dslc_ajax_add_modules_section( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// Allows devs to add classes.
		$filter_classes = array();
		$filter_classes = apply_filters( 'dslc_row_class', $filter_classes );
		$extra_classes = '';
		if ( count( $filter_classes ) > 0 ) {
			foreach ( $filter_classes as $filter_class ) {
				$extra_classes .= $filter_class . ' ';
			}
		}

		// The output.
		$output = '<div class="dslc-modules-section dslc-modules-section-empty ' . $extra_classes . '" style="' . dslc_row_get_style() . '">
			<div class="dslc-bg-video dslc-force-show"><div class="dslc-bg-video-inner"></div><div class="dslc-bg-video-overlay"></div></div>
			<div class="dslc-modules-section-wrapper">
				<div class="dslc-modules-section-inner dslc-clearfix">
					<div class="dslc-modules-area dslc-col dslc-12-col" data-size="12">
						<div class="dslc-modules-area-inner">
							<div class="dslca-modules-area-manage">
								<div class="dslca-modules-area-manage-inner">
									<span class="dslca-manage-action dslca-copy-modules-area-hook" title="Duplicate" ><span class="dslca-icon dslc-icon-copy"></span></span>
									<span class="dslca-manage-action dslca-move-modules-area-hook" title="Drag to move" ><span class="dslca-icon dslc-icon-move"></span></span>
									<span class="dslca-manage-action dslca-change-width-modules-area-hook" title="Change width" >
										<span class="dslca-icon dslc-icon-columns"></span>
										<div class="dslca-change-width-modules-area-options">';
											$output .= '<span>' . __( 'Container Width', 'live-composer-page-builder' ) . '</span>';
											$output .= '<span data-size="1">1/12</span><span data-size="2">2/12</span>
											<span data-size="3">3/12</span><span data-size="4">4/12</span>
											<span data-size="5">5/12</span><span data-size="6">6/12</span>
											<span data-size="7">7/12</span><span data-size="8">8/12</span>
											<span data-size="9">9/12</span><span data-size="10">10/12</span>
											<span data-size="11">11/12</span><span data-size="12">12/12</span>
										</div>
									</span>
									<span class="dslca-manage-action dslca-delete-modules-area-hook" title="Delete" ><span class="dslca-icon dslc-icon-remove"></span></span>
								</div>
							</div>
						</div>
					</div>
				</div><!-- .dslc-module-section-inner -->
				<div class="dslca-modules-section-manage">
					<div class="dslca-modules-section-manage-inner">
						<span class="dslca-manage-action dslca-edit-modules-section-hook" title="Edit options" ><span class="dslca-icon dslc-icon-cog"></span></span>
						<span class="dslca-manage-action dslca-copy-modules-section-hook" title="Duplicate" ><span class="dslca-icon dslc-icon-copy"></span></span>
						<span class="dslca-manage-action dslca-move-modules-section-hook" title="Drag to move" ><span class="dslca-icon dslc-icon-move"></span></span>
						<span class="dslca-manage-action dslca-export-modules-section-hook" title="Export section code" ><span class="dslca-icon dslc-icon-upload-alt"></span></span>
						<span class="dslca-manage-action dslca-delete-modules-section-hook" title="Delete" ><span class="dslca-icon dslc-icon-remove"></span></span>
					</div>
				</div>
				<div class="dslca-modules-section-settings">' . dslc_row_get_options_fields() . '</div><!-- .dslca-module-section-settings -->
			</div><!-- .dslc-module-section-wrapper -->
		</div>';

		// Set the output.
		$response['output'] = $output;

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Good night.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-add-modules-section', 'dslc_ajax_add_modules_section' );

/**
 * Add a new module
 *
 * @since 1.0
 */
function dslc_ajax_add_module( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The ID of the module to add.
		$module_id = $_POST['dslc_module_id'];
		$post_id = $_POST['dslc_post_id'];
		if ( isset( $_POST['dslc_preload_preset'] ) && $_POST['dslc_preload_preset'] == 'enabled' ) {

			$preload_preset = 'enabled';
		} else {

			$preload_preset = 'disabled';
		}

		/**
		 * The instance ID for this specific module
		 */

		// If it is not a new module ( already has ID )?
		if ( isset( $_POST['dslc_module_instance_id'] ) ) {

			$module_instance_id = $_POST['dslc_module_instance_id'];

		// If it is a new module ( no ID )?
		} else {

			// Get current count.
			$module_id_count = get_option( 'dslc_module_id_count' );

			// If not the first one?
			if ( $module_id_count ) {

				// Increment by one.
				$module_instance_id = $module_id_count + 1;

				// Update the count.
				update_option( 'dslc_module_id_count', $module_instance_id );

			// If it is the first one?
			} else {

				// Set 1 as the ID.
				$module_instance_id = 1;

				// Update the count.
				update_option( 'dslc_module_id_count', $module_instance_id );

			}
		}

		// If module instance ID not numeric stop execution?
		/*
		if ( ! is_numeric( $module_instance_id ) ) {
			return;
		}
		*/

		// Instanciate the module class.
		$module_instance = new $module_id();

		// Generate settings.
		// Array $all_opts - has a structure of the module setting (not actual data).
		$all_opts = $module_instance->options();

		/**
		 * Array $module_settings - has all the module settings (actual data).
		 * Ex.: [css_bg_color] => rgb(184, 61, 61).
		 *
		 * Function dslc_module_settings form the module settings array
		 * based on default settings + current settings.
		 *
		 * Function dslc_module_settings get current module settings
		 * form $_POST[ $option['id'] ].
		 */
		$module_settings = dslc_module_settings( $all_opts );

		// Append ID to settings.
		$module_settings['module_instance_id'] = $module_instance_id;

		// Append post ID to settings.
		$module_settings['post_id'] = $post_id;

		// Start output fetching.
		ob_start();

		// Load preset if there was no preset before.
		if ( $preload_preset == 'enabled' ) {

			$module_settings = apply_filters( 'dslc_filter_settings', $module_settings );
		}

		// Transform image ID to URL.
		global $dslc_var_image_option_bckp;
		$dslc_var_image_option_bckp = array();

		foreach ( $all_opts as $all_opt ) {

			if ( $all_opt['type'] == 'image' ) {

				if ( isset( $module_settings[$all_opt['id']] ) && ! empty( $module_settings[$all_opt['id']] ) && is_numeric( $module_settings[$all_opt['id']] ) ) {

					$dslc_var_image_option_bckp[$all_opt['id']] = $module_settings[$all_opt['id']];
					$image_info = wp_get_attachment_image_src( $module_settings[$all_opt['id']], 'full' );
					$module_settings[$all_opt['id']] = $image_info[0];
				}
			}
		}

		// Module size.
		if ( isset( $_POST['dslc_m_size'] ) ) {

			$module_settings['dslc_m_size'] = $_POST['dslc_m_size'];
		} else {

			$module_settings['dslc_m_size'] = '12';
		}

		// Output.
		$module_instance->output( $module_settings );

		// Get the output and stop fetching.
		$output = ob_get_contents();
		ob_end_clean();

		// Set the output.
		$response['output'] = $output;

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Good night.
		exit;

	}

} add_action( 'wp_ajax_dslc-ajax-add-module', 'dslc_ajax_add_module' );


/**
 * Display module options
 *
 * @since 1.0
 */

function dslc_ajax_display_module_options( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call
		$response = array();

		// This will hold the output
		$response['output'] = '';
		$response['output_tabs'] = '';

		// The ID of the module
		$module_id = $_POST['dslc_module_id'];

		// Instanciate the module class
		$module_instance = new $module_id();

		// Get the module options
		$module_options = $module_instance->options();

		// Tabs
		$tabs = array();

		ob_start();

		// Go through each option, generate the option HTML and append to output
		foreach ( $module_options as $module_option ) {

			$curr_value = $module_option['std'];

			if ( isset( $_POST[$module_option['id']] ) ) {
							$curr_value = $_POST[$module_option['id']];
			}

			/**
			 * Visibility
			 */

			if ( isset( $module_option['visibility'] ) ) {
							$visibility = false;
			} else {
							$visibility = true;
			}

			if ( $module_option['type'] == 'checkbox' && count( $module_option['choices'] ) < 1 ) {
							$visibility = false;
			}

			/**
			 * Refresh on change
			 */

			if ( isset( $module_option['refresh_on_change'] ) ) {

				if ( $module_option['refresh_on_change'] ) {
									$refresh_on_change = 'active';
				} else {
									$refresh_on_change = 'inactive';
				}

			} else {
				$refresh_on_change = 'active';
			}

			// Force refresh on change for images ( due to the URL -> ID change )
			if ( $module_option['type'] == 'image' ) {
							$refresh_on_change = 'active';
			}

			/**
			 * Section (functionality and styling)
			 */

			if ( isset( $module_option['section'] ) ) {
							$section = $module_option['section'];
			} else {
							$section = 'functionality';
			}

			/**
			 * Tab
			 */

			if ( ! isset( $module_option['tab'] ) ) {

				if ( $section == 'functionality' ) {
					$tabs['general_functionality'] = array(
						'title' => __( 'General', 'live-composer-page-builder' ),
						'id' => 'general_functionality',
						'section' => 'functionality'
					);
				} else {
					$tabs['general_styling'] = array(
						'title' => __( 'General', 'live-composer-page-builder' ),
						'id' => 'general_styling',
						'section' => 'styling'
					);
				}

				$tab_ID = 'general_' . $section;

			}

			if ( isset( $module_option['tab'] ) ) {

				// Lowercase it
				$tab_ID = strtolower( $module_option['tab'] );

				// Replace spaces with _
				$tab_ID = str_replace( ' ', '_', $tab_ID );

				// Add section ID append
				$tab_ID .= '_' . $section;

				// If not already in the tabs array
				if ( ! in_array( $tab_ID, $tabs ) ) {

					// Add it to the tabs array
					$tabs[$tab_ID] = array(
						'title' => $module_option['tab'],
						'id' => $tab_ID,
						'section' => $section
					);

				}

			}

			$ext = ' ';
			if ( isset( $module_option['ext'] ) ) {
				$ext = $module_option['ext'];
			}

			$affect_on_change_append = '';
			if ( isset( $module_option['affect_on_change_el'] ) && isset( $module_option['affect_on_change_rule'] ) ) {
				$affect_on_change_append = 'data-affect-on-change-el="' . $module_option['affect_on_change_el'] . '" data-affect-on-change-rule="' . $module_option['affect_on_change_rule'] . '"';
			}

			/**
			 * List of options that need not toggle
			 * – Enable/Disable Custom CSS
			 * – Show On
			 * – Presets controls
			 * – Animation controls
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
				'content',
				'css_res_t',
				'css_res_p',
				'image',
				'elements',
				'post_elements',
				'carousel_elements',
				'thumb_resize_width',
				'thumb_resize_width_manual',
				'button_icon_id',
				'icon_pos',
				'button_state',
				'resize_width',
				'resize_height',
			);

			$control_with_toggle = '';

			$sections_with_toggle = array(
				'styling',
				'responsive',
			);

			$module_option['section'] = isset( $module_option['section'] ) ? $module_option['section'] : 'functionality';

			/**
			 * Display styling control toggle [On/Off]
			 */
			if ( ! in_array( $module_option['id'], $controls_without_toggle, true ) && in_array( $module_option['section'], $sections_with_toggle, true ) ) {
				$control_with_toggle = 'dslca-option-with-toggle';

				if ( '' === stripslashes( $curr_value ) ) {
					$control_with_toggle .= ' dslca-option-off';
				}
			}

			$dep = '';

			// Show/hide option controls that depend on current option.
			if ( isset( $module_option['dependent_controls'] ) ) {

				$dep = ' data-dep="' . base64_encode( json_encode( $module_option['dependent_controls'] ) ) . '"';
			}

			?>

				<div class="dslca-module-edit-option dslca-module-edit-option-<?php echo $module_option['type']; ?> dslca-module-edit-option-<?php echo $module_option['id']; ?> <?php if ( ! $visibility ) echo 'dslca-module-edit-option-hidden'; ?> <?php echo $control_with_toggle; ?>" data-id="<?php echo $module_option['id']; ?>" <?php echo $dep?> data-refresh-on-change="<?php echo $refresh_on_change; ?>" data-section="<?php echo $section; ?>" data-tab="<?php echo $tab_ID; ?>">

					<?php if ( isset( $module_option['help'] ) ) : ?>
						<div class="dslca-module-edit-field-ttip-content"><?php echo $module_option['help']; ?></div>
					<?php endif; ?>

					<span class="dslca-module-edit-label">
						<?php if ( isset ( $module_option['label'] ) ) { echo $module_option['label']; } ?>
						<?php
							/**
							 * Display styling control toggle [On/Off]
							 */
							if ( ! in_array( $module_option['id'], $controls_without_toggle, true ) && in_array( $module_option['section'], $sections_with_toggle, true ) && ! stristr($module_option['id'], 'css_res_') ) {
								echo'<span class="dslc-control-toggle dslc-icon dslc-icon-"></span>';
							}
						?>
						<?php if ( $module_option['type'] == 'icon' ): ?>
							<span class="dslca-module-edit-field-icon-ttip-hook"><span class="dslca-icon dslc-icon-info"></span></span>
						<?php endif; ?>
						<?php if ( isset( $module_option['help'] ) ) : ?>
							<span class="dslca-module-edit-field-ttip-hook"><span class="dslca-icon dslc-icon-info"></span></span>
						<?php endif; ?>
					</span>

					<?php if ( $module_option['type'] == 'text' ) : ?>

						<input type="text" class="dslca-module-edit-field" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo esc_attr( stripslashes( $curr_value ) ); ?>" data-starting-val="<?php echo esc_attr( stripslashes( $curr_value ) ); ?>" <?php echo $affect_on_change_append ?> />

					<?php elseif ( $module_option['type'] == 'textarea' ) : ?>

						<textarea class="dslca-module-edit-field" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" <?php echo $affect_on_change_append ?>><?php echo stripslashes( $curr_value ); ?></textarea>

					<?php elseif ( $module_option['type'] == 'select' ) : ?>

						<select class="dslca-module-edit-field" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" <?php echo $affect_on_change_append ?> >
							<?php foreach ( $module_option['choices'] as $select_option ) : ?>
								<option value="<?php echo $select_option['value']; ?>" <?php if ( $curr_value == $select_option['value'] ) echo 'selected="selected"'; ?>><?php echo $select_option['label']; ?></option>
							<?php endforeach; ?>
						</select>
						<span class="dslca-icon dslc-icon-caret-down"></span>

					<?php elseif ( $module_option['type'] == 'checkbox' ) : ?>

						<?php

						// Current Value Array
						if ( empty( $curr_value ) ) {

							$curr_value = array();
						} else {

							$curr_value = explode( ' ', trim( $curr_value ) );
						}

						?>

						<div class="dslca-module-edit-option-checkbox-wrapper">
							<?php foreach ( $module_option['choices'] as  $checkbox_option ) : ?>
								<div class="dslca-module-edit-option-checkbox-single">
									<span class="dslca-module-edit-option-checkbox-hook"><span class="dslca-icon <?php if ( in_array( $checkbox_option['value'], $curr_value ) ) echo 'dslc-icon-check'; else echo 'dslc-icon-check-empty'; ?>"></span><?php echo $checkbox_option['label']; ?></span>
									<input type="checkbox" class="dslca-module-edit-field dslca-module-edit-field-checkbox" data-id="<?php echo $module_option['id']; ?>" name="<?php echo $module_option['id']; ?>" value="<?php echo $checkbox_option['value']; ?>" <?php if ( in_array( $checkbox_option['value'], $curr_value ) ) echo 'checked="checked"'; ?> <?php echo $affect_on_change_append ?> />
								</div><!-- .dslca-module-edit-option-checkbox-single -->
							<?php endforeach; ?>
						</div><!-- .dslca-module-edit-option-checkbox-wrapper -->

					<?php elseif ( $module_option['type'] == 'radio' ) : ?>

						<div class="dslca-module-edit-option-radio-wrapper">
							<?php foreach ( $module_option['choices'] as  $checkbox_option ) : ?>
								<div class="dslca-module-edit-option-radio-single">
									<input type="radio" class="dslca-module-edit-field" data-id="<?php echo $module_option['id']; ?>" name="<?php echo $module_option['id']; ?>" value="<?php echo $checkbox_option['value']; ?>" /> <?php echo $checkbox_option['label']; ?><br>
								</div><!-- .dslca-module-edit-option-radio-single -->
							<?php endforeach; ?>
						</div><!-- .dslca-module-edit-option-radio-wrapper -->

					<?php elseif ( $module_option['type'] == 'color' ) : ?>

						<?php
							$default_value = false;
							if ( isset( $module_option['std'] ) ) {

								$default_value = $module_option['std'];
							}

							$style = '';

							if ( '' != $curr_value ) {

								$text_color_value = $curr_value;

								if ( ! strpos( $curr_value, '#' ) ) {

									$text_color_value =dslc_rgbtohex( $text_color_value );
								}

								$color = dslc_get_contrast_bw( $text_color_value );

								$style = ' style="background: ' . $curr_value . '; color: ' . $color . '"';
							}
						?>

						<input type="text" class="dslca-module-edit-field dslca-module-edit-field-colorpicker" <?php echo $style;?> name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo $curr_value; ?>" data-affect-on-change-el="<?php echo $module_option['affect_on_change_el']; ?>" data-affect-on-change-rule="<?php echo $module_option['affect_on_change_rule']; ?>" <?php if ( $default_value ) : ?> data-default="<?php echo $default_value; ?>" <?php endif; ?> />

					<?php elseif ( $module_option['type'] == 'slider' ) : ?>

						<?php

						$slider_min = 0;
						$slider_max = 100;
						$slider_increment = 1;

						if ( isset( $module_option['min'] ) ) {
							$slider_min = $module_option['min'];
						}

						if ( isset( $module_option['max'] ) ) {
							$slider_max = $module_option['max'];
						}

						if ( isset( $module_option['increment'] ) ) {
							$slider_increment = $module_option['increment'];
						}

						?>

						<div class="dslca-module-edit-field-numeric-wrap">
							<input type="number" class="dslca-module-edit-field dslca-module-edit-field-numeric" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo $curr_value; ?>" data-starting-val="<?php echo $curr_value; ?>" data-min="<?php echo $slider_min; ?>" data-max="<?php echo $slider_max; ?>"  data-increment="<?php echo $slider_increment; ?>" data-ext="<?php echo $ext; ?>" <?php echo $affect_on_change_append; ?> />
							<span class="dslca-module-edit-field-numeric-ext"><?php echo $module_option['ext']; ?></span>
						</div>

					<?php elseif ( $module_option['type'] == 'font' ) : ?>

						<div class="dslca-module-edit-field-font-wrapper">
							<input type="text" class="dslca-module-edit-field dslca-module-edit-field-font" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo $curr_value; ?>" <?php echo $affect_on_change_append ?> />
							<span class="dslca-module-edit-field-font-suggest"></span>
						</div>
						<span class="dslca-options-iconbutton dslca-module-edit-field-font-prev"><span class="dslca-icon dslc-icon-chevron-left"></span></span>
						<span class="dslca-options-iconbutton dslca-module-edit-field-font-next"><span class="dslca-icon dslc-icon-chevron-right"></span></span>

					<?php elseif ( $module_option['type'] == 'icon' ) : ?>

						<div class="dslca-module-edit-field-icon-wrapper">
							<input type="text" class="dslca-module-edit-field dslca-module-edit-field-icon" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo $curr_value; ?>" <?php echo $affect_on_change_append ?> />
							<span class="dslca-module-edit-field-icon-suggest"></span>
						</div>
						<span class="dslca-options-iconbutton dslca-open-modal-hook" data-modal=".dslc-list-icons-fontawesome"><span class="dslca-icon dslc-icon-th"></span></span>
						<span class="dslca-module-edit-field-icon-switch-set"><span class="dslca-icon dslc-icon-cog"></span> <span class="dslca-module-edit-field-icon-curr-set"><?php echo dslc_icons_current_set( $curr_value ); ?></span></span>


					<?php elseif ( $module_option['type'] == 'image' ) : ?>

						<span class="dslca-module-edit-field-image-add-hook" <?php if ( $curr_value != '' ) echo 'style="display: none;"'; ?>><span class="dslca-icon dslc-icon-cloud-upload"></span><?php _e( 'Upload Image', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-module-edit-field-image-remove-hook" <?php if ( $curr_value == '' ) echo 'style="display: none;"'; ?>><span class="dslca-icon dslc-icon-remove"></span><?php _e( 'Remove Image', 'live-composer-page-builder' ); ?></span>
						<input type="hidden" class="dslca-module-edit-field dslca-module-edit-field-image" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo $curr_value; ?>" <?php echo $affect_on_change_append ?> />

					<?php elseif ( $module_option['type'] == 'text_align' ) : ?>

						<div class="dslca-module-edit-option-text-align-wrapper">
							<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $curr_value == 'inherit' ) echo 'dslca-active'; ?>" data-val="inherit">
								<span class="dslca-icon dslc-icon-remove"></span>
							</div>
							<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $curr_value == 'left' ) echo 'dslca-active'; ?>" data-val="left">
								<span class="dslca-icon dslc-icon-align-left"></span>
							</div>
							<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $curr_value == 'center' ) echo 'dslca-active'; ?>" data-val="center">
								<span class="dslca-icon dslc-icon-align-center"></span>
							</div>
							<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $curr_value == 'right' ) echo 'dslca-active'; ?>" data-val="right">
								<span class="dslca-icon dslc-icon-align-right"></span>
							</div>
							<div class="dslca-module-edit-option-text-align-single dslca-module-edit-option-text-align-hook <?php if ( $curr_value == 'justify' ) echo 'dslca-active'; ?>" data-val="justify">
								<span class="dslca-icon dslc-icon-align-justify"></span>
							</div>
						</div>

						<input type="hidden" class="dslca-module-edit-field dslca-module-edit-field-text-align" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo $curr_value; ?>" <?php echo $affect_on_change_append ?> />

					<?php elseif ( $module_option['type'] == 'box_shadow' ) : ?>

						<?php
							$box_shadow_hor_val = 0;
							$box_shadow_ver_val = 0;
							$box_shadow_blur_val = 0;
							$box_shadow_spread_val = 0;
							$box_shadow_color_val = 'transparent';
							$box_shadow_inset_val = 'outset';
							$box_shadow_val = false;
							if ( $curr_value !== '' ) {
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

						<div class="dslca-module-edit-option-box-shadow-wrapper">

							<div class="dslca-module-edit-option-box-shadow-single">
								<span class="dslca-module-edit-option-checkbox-hook"><?php _e( 'Inner', 'live-composer-page-builder' ); ?><span class="dslca-icon <?php if ( $box_shadow_inset_val == 'inset' ) echo 'dslc-icon-check'; else echo 'dslc-icon-check-empty'; ?>"></span></span>
								<input type="checkbox" class="dslca-module-edit-field-checkbox dslca-module-edit-option-box-shadow-inset" <?php if ( $box_shadow_inset_val == 'inset' ) echo 'checked="checked"'; ?> />
							</div>
							<div class="dslca-module-edit-option-box-shadow-single">
								<span><?php _e( 'Hor', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-box-shadow-hor" step="0.1" type="number" value="<?php echo $box_shadow_hor_val; ?>" />
							</div>
							<div class="dslca-module-edit-option-box-shadow-single">
								<span><?php _e( 'Ver', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-box-shadow-ver" step="0.1" type="number" value="<?php echo $box_shadow_ver_val; ?>" />
							</div>
							<div class="dslca-module-edit-option-box-shadow-single">
								<span><?php _e( 'Blur', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-box-shadow-blur" step="0.1" type="number" value="<?php echo $box_shadow_blur_val; ?>" />
							</div>
							<div class="dslca-module-edit-option-box-shadow-single">
								<span><?php _e( 'Spread', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-box-shadow-spread" step="0.1" type="number" value="<?php echo $box_shadow_spread_val; ?>" />
							</div>
							<div class="dslca-module-edit-option-box-shadow-single">
								<span><?php _e( 'Color', 'live-composer-page-builder' ); ?></span><input type="text" class="dslca-module-edit-option-box-shadow-color" value="<?php echo $box_shadow_color_val; ?>" />
							</div>

							<input type="hidden" class="dslca-module-edit-field dslca-module-edit-field-box-shadow" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo $curr_value; ?>" <?php echo $affect_on_change_append ?> />

						</div><!-- .dslca-module-edit-option-box-shadow-wrapper -->

					<?php elseif ( $module_option['type'] == 'text_shadow' ) : ?>

						<?php
							$text_shadow_hor_val = 0;
							$text_shadow_ver_val = 0;
							$text_shadow_blur_val = 0;
							$text_shadow_color_val = 'transparent';

							$text_shadow_val = false;
							if ( $curr_value !== '' ) {
								$text_shadow_val = explode( ' ', $curr_value );
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
								<span><?php _e( 'Hor', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-text-shadow-hor" step="0.1" type="number" value="<?php echo $text_shadow_hor_val; ?>" />
							</div>
							<div class="dslca-module-edit-option-text-shadow-single">
								<span><?php _e( 'Ver', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-text-shadow-ver" step="0.1" type="number" value="<?php echo $text_shadow_ver_val; ?>" />
							</div>
							<div class="dslca-module-edit-option-text-shadow-single">
								<span><?php _e( 'Blur', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-text-shadow-blur" step="0.1" type="number" value="<?php echo $text_shadow_blur_val; ?>" />
							</div>
							<div class="dslca-module-edit-option-text-shadow-single">
								<span><?php _e( 'Color', 'live-composer-page-builder' ); ?></span><input class="dslca-module-edit-option-text-shadow-color" type="text" value="<?php echo $text_shadow_color_val; ?>" />
							</div>

							<input type="hidden" class="dslca-module-edit-field dslca-module-edit-field-text-shadow" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo $curr_value; ?>" <?php echo $affect_on_change_append ?> />

						</div><!-- .dslca-module-edit-option-text-shadow-wrapper -->

					<?php else : ?>

						<?php if ( has_action( 'dslc_custom_option_type_' . $module_option['type'] ) ) : ?>

							<?php do_action( 'dslc_custom_option_type_' . $module_option['type'], $module_option, $curr_value, $affect_on_change_append ); ?>

						<?php else : ?>

							<input type="text" class="dslca-module-edit-field" name="<?php echo $module_option['id']; ?>" data-id="<?php echo $module_option['id']; ?>" value="<?php echo $curr_value; ?>" data-starting-val="<?php echo $curr_value; ?>" <?php echo $affect_on_change_append ?> />

						<?php endif; ?>

					<?php endif; ?>

				</div><!-- .dslc-module-edit-option -->

			<?php

		}

		$output_fields = ob_get_contents();
		ob_end_clean();

		// Output Start.
		$output_start = '<div class="dslca-module-edit-options-wrapper dslc-clearfix">';

		// Output End.
		$output_end = '</div>';

		// Output Tabs.
		$output_tabs = '';
		foreach ( $tabs as $tab ) {
			$output_tabs .= '<span class="dslca-module-edit-options-tab-hook" data-section="' . $tab['section'] . '" data-id="' . $tab['id'] . '">' . $tab['title'] . '</span>';
		}

		// Combine output.
		$response['output_tabs'] .= $output_tabs;
		$response['output'] .= $output_start;
		$response['output'] .= $output_fields;
		$response['output'] .= $output_end;

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Auf wiedersehen.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-display-module-options', 'dslc_ajax_display_module_options' );


/**
 * Save composer code
 *
 * @since 1.0
 */
function dslc_ajax_save_composer( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		$composer_code = '';
		$content_for_search = '';

		// The composer code.
		if ( isset( $_POST['dslc_code'] ) ) {
			$composer_code = $_POST['dslc_code'];
		}

		// The content for search.
		if ( isset( $_POST['dslc_content_for_search'] ) ) {
			$content_for_search = $_POST['dslc_content_for_search'];
		}

		// The ID of the post/page.
		$post_id = $_POST['dslc_post_id'];

		/**
		 * WordPress return false your try to update identical code.
		 * This problem cause frustration for the users, so we delete
		 * 'dslc_code' meta completely before saving it again
		 * to solve this problem.
		 */
		delete_post_meta( $post_id, 'dslc_code' );

		// Add/update the post/page with the composer code
		if ( update_post_meta( $post_id, 'dslc_code', $composer_code ) ) {
			$response['status'] = 'success';
		} else {
			$response['status'] = 'failed';
		}

		// Add/update the post/page with the content for search
		// wp_kses_post – Sanitize content for allowed HTML tags for post content.
		update_post_meta( $post_id, 'dslc_content_for_search', wp_kses_post( $content_for_search ) );

		// Delete draft code.
		delete_post_meta( $post_id, 'dslc_code_draft' );

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Refresh cache.
		if ( function_exists( 'wp_cache_post_change' ) ) {
			$GLOBALS['super_cache_enabled'] = 1;
			wp_cache_post_change( $post_id );
		}

		// Au revoir.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-save-composer', 'dslc_ajax_save_composer' );

/**
 * Save composer code
 *
 * @since 1.0
 */
function dslc_ajax_save_draft_composer( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The composer code.
		$composer_code = $_POST['dslc_code'];

		// The ID of the post/page.
		$post_id = $_POST['dslc_post_id'];

		// Add/update the post/page with the composer code.
		if ( update_post_meta( $post_id, 'dslc_code_draft', $composer_code ) ) {
					$response['status'] = 'success';
		} else {
					$response['status'] = 'failed';
		}

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Refresh cache.
		if ( function_exists( 'wp_cache_post_change' ) ) {
			$GLOBALS['super_cache_enabled'] = 1;
			wp_cache_post_change( $post_id );
		}

		// Au revoir.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-save-draft-composer', 'dslc_ajax_save_draft_composer' );

/**
 * Load a template
 *
 * @since 1.0
 */

function dslc_ajax_load_template( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array that holds active templates.
		$templates = dslc_get_templates();

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The ID of the template to load.
		$template_id = $_POST['dslc_template_id'];

		// The code of the template to load.
		$template_code = $templates[$template_id]['code'];

		// Apply for new ID.
		$template_code = str_replace( '[dslc_module ', '[dslc_module give_new_id="true" ', $template_code );
		$template_code = str_replace( '[dslc_module]', '[dslc_module give_new_id="true"]', $template_code );

		// Get the front-end output.
		$response['output'] = do_shortcode( $template_code );

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Cheers.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-load-template', 'dslc_ajax_load_template' );



/**
 * Import a template
 *
 * @since 1.0
 */
function dslc_ajax_import_template( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The code of the template.
		$template_code = stripslashes( $_POST['dslc_template_code'] );

		// Apply for new ID.
		$template_code = str_replace( '[dslc_module ', '[dslc_module give_new_id="true" ', $template_code );
		$template_code = str_replace( '[dslc_module]', '[dslc_module give_new_id="true"]', $template_code );

		// Get the front-end output.
		$response['output'] = do_shortcode( $template_code );

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Bye bye.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-import-template', 'dslc_ajax_import_template' );


/**
 * Save a custom template
 *
 * @since 1.0
 */
function dslc_ajax_save_template( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		// Response to the AJAX call.
		$response = array();

		// To let the AJAX know how it went (all good for now).
		$response['status'] = 'success';

		// Get new template data.
		$template_title = stripslashes( $_POST['dslc_template_title'] );
		$template_id = strtolower( str_replace( ' ', '-', $template_title ) );
		$template_code = stripslashes( $_POST['dslc_template_code'] );

		// Get current templates.
		$templates = get_option( 'dslc_templates' );

		// No templates = make empty array OR templates found = unserialize.
		if ( $templates === false ) {
					$templates = array();
		} else {
					$templates = maybe_unserialize( $templates );
		}

		// Append new template to templates array.
		$templates[$template_id] = array(
			'title' => $template_title,
			'id' => $template_id,
			'code' => $template_code,
			'section' => 'user'
		);

		// Save new templates array to db.
		update_option( 'dslc_templates', maybe_serialize( $templates ) );

		// Generate response.
		$response['output'] = $templates;

		// Encode response.
		$response_json = json_encode( $response );

		// AJAX phone home.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Asta la vista.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-save-template', 'dslc_ajax_save_template' );

/**
 * Delete a custom template
 *
 * @since 1.0
 */
function dslc_ajax_delete_template( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		$response = array();
		$response['status'] = 'success';

		// ID of the template to delete.
		$template_id = $_POST['dslc_template_id'];

		// Get all templates.
		$templates = maybe_unserialize( get_option( 'dslc_templates' ) );

		// Remove the template.
		unset( $templates[$template_id] );

		// Save new templates array to db.
		update_option( 'dslc_templates', maybe_serialize( $templates ) );

		// Generate response.
		$response['output'] = $templates;

		// Encode response.
		$response_json = json_encode( $response );

		// AJAX phone home.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Asta la vista.
		exit;

	}

} add_action( 'wp_ajax_dslc-ajax-delete-template', 'dslc_ajax_delete_template' );

/**
 * Get new module ID
 *
 * @since 1.0
 */
function dslc_ajax_get_new_module_id() {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		$response = array();
		$response['status'] = 'success';

		// Get current count.
		$module_id_count = get_option( 'dslc_module_id_count' );

		// Increment by one.
		$module_instance_id = $module_id_count + 1;

		// Update the count.
		update_option( 'dslc_module_id_count', $module_instance_id );

		// Generate response.
		$response['output'] = $module_instance_id;

		// Encode response.
		$response_json = json_encode( $response );

		// AJAX phone home.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Asta la vista
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-get-new-module-id', 'dslc_ajax_get_new_module_id' );

/**
 * Import a modules section
 *
 * @since 1.0
 */
function dslc_ajax_import_modules_section( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The code of the modules section.
		$modules_code = stripslashes( $_POST['dslc_modules_section_code'] );

		// Apply for new ID.
		$modules_code = str_replace( '[dslc_module ', '[dslc_module give_new_id="true" ', $modules_code );
		$modules_code = str_replace( '[dslc_module]', '[dslc_module give_new_id="true"]', $modules_code );

		// Get the front-end output.
		$response['output'] = do_shortcode( $modules_code );

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Bye bye.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-import-modules-section', 'dslc_ajax_import_modules_section' );

/**
 * Return the code to alter defaults for a module
 *
 * @since 1.0
 */
function dslc_ajax_dm_module_defaults_code( $atts ) {
	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		$code = '';

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The options serialized array.
		$modules_code = stripslashes( $_POST['dslc_modules_options'] );

		// Turn the string of settings into an array.
		$settings_new = maybe_unserialize( base64_decode( $modules_code ) );

		if ( is_array( $settings_new ) ) {

			// The ID of the module.
			$module_id = $settings_new['module_id'];

			// Instanciate the module class.
			$module_instance = new $module_id();

			// Module output.
			$settings = $module_instance->options();

			$code .= "if ( " . '$id' . " == '" . $module_id . "' ) {
	". '$new_defaults = array(' . "
";

			// Fix settings when a new option added after a module is used.
			foreach ( $settings as $key => $setting ) {

				if ( isset( $settings_new[$setting['id']] ) ) {

					if ( $settings_new[$setting['id']] != $settings[$key]['std'] ) {
						$code .= "		'" . $setting['id'] . "' => '" . $settings_new[$setting['id']] . "',
";
					}
				}
			}

			$code .= '	);
}';

		}

		// Get the front-end output.
		$response['output'] = $code;

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Bye bye.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-dm-module-defaults', 'dslc_ajax_dm_module_defaults_code' );

/**
 * Save module styling preset
 * dslc_save_preset is located in functions.php
 *
 * @since 1.0
 */
function dslc_ajax_save_preset() {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// Get the preset data.
		$preset_name = stripslashes( $_POST['dslc_preset_name'] );
		$preset_code_raw = stripslashes( $_POST['dslc_preset_code'] );
		$module_id = stripslashes( $_POST['dslc_module_id'] );

		// Save.
		if ( dslc_save_preset( $preset_name, $preset_code_raw, $module_id ) ) {
					$response['status'] = 'success';
		} else {
					$response['status'] = 'error';
		}

		// Encode response.
		$response_json = json_encode( $response );

		// Send the response.
		header( "Content-Type: application/json" );
		echo $response_json;

		// Bye bye.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-save-preset', 'dslc_ajax_save_preset' );
