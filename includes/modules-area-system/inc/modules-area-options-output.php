<?php
/**
 * MODULES AREA settings/controls functions.
 *
 * Table of Contents
 *
 * - dslc_modules_area_render_tabs ( Output Modules Area tabs. )
 * - dslc_modules_area_display_options ( Output Modules Area settings/controls. )
 * - dslc_modules_area_get_options_fields ( Output hidden text input elements that will be used as data storage. )
 * - dslc_modules_area_get_style ( Generate CSS styles for the Modules Area )
 * - dslc_modules_area_get_initial_style ( Get initial ( default ) Modules Area style )
 * - dslc_get_modules_area_help ( Get control help )
 *
 * @package LiveComposer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}
function dslc_modules_area_render_tabs() {

	global $dslc_var_modules_area_options;

	if ( empty( $dslc_var_modules_area_options ) ) {
		return '';
	}

	$tabs = array();

	foreach ( $dslc_var_modules_area_options as $option ) {

		$section = isset( $option['section'] )
			? $option['section']
			: 'functionality';

		// Determine tab title + id
		if ( isset( $option['tab'] ) ) {
			$title = $option['tab'];
			$id    = str_replace( ' ', '_', strtolower( $title ) ) . '_' . $section;
		} else {
			$title = __( 'General', 'live-composer-page-builder' );
			$id    = 'general_' . $section;
		}

		// Avoid duplicates
		if ( ! isset( $tabs[ $id ] ) ) {
			$tabs[ $id ] = array(
				'id'      => $id,
				'title'   => $title,
				'section' => $section,
			);
		}
	}

	// ---- Render HTML ----
	$output = '';

	foreach ( $tabs as $tab ) {

		$output .= '<a href="#" class="dslca-modules-area-edit-options-tab-hook"';
		$output .= ' data-section="' . esc_attr( $tab['section'] ) . '"';
		$output .= ' data-id="' . esc_attr( $tab['id'] ) . '">';
		$output .= esc_html( $tab['title'] );
		$output .= '</a>';

		// Responsive reset icon (phone tab only)
		if ( 'phone_responsive' === $tab['id'] ) {
			$output .= '<a href="#" class="dslca-modules-area-clear-responsive-options" title="'
				. esc_attr__( 'Reset responsive options', 'live-composer-page-builder' )
				. '"><span class="dslca-icon dslc-icon-trash"></span></a>';
		}
	}

	return $output;
}


/**
 * Output Modules Area settings/controls.
 */
function dslc_modules_area_display_options() {

	// Global var containing options.
	global $dslc_var_modules_area_options;

	// If empty return?
	if ( empty( $dslc_var_modules_area_options ) ) {
		return;
	}

	foreach ( $dslc_var_modules_area_options as $modules_area_option ) {
        // 1. Logic Replication: Default Section
        $section = isset( $modules_area_option['section'] ) ? $modules_area_option['section'] : 'functionality';

        // 2. Logic Replication: Default Tab ID
        $tab_id = '';
        if ( isset( $modules_area_option['tab'] ) ) {
            $tab_id = str_replace( ' ', '_', strtolower( $modules_area_option['tab'] ) ) . '_' . $section;
        } else {
            $tab_id = 'general_' . $section;
        }

		if ( 'group' !== $modules_area_option['type'] ) {

			$css_rule_output = '';

			if ( isset( $modules_area_option['affect_on_change_rule'] ) ) {

				$css_rule_output = $modules_area_option['affect_on_change_rule'];
			}

			$css_element_output = '';
			if ( isset( $modules_area_option['affect_on_change_el'] ) ) {

				$css_element_output = $modules_area_option['affect_on_change_el'];
			}

			$extra_class = '';

			if ( 'border_checkbox' === $modules_area_option['type'] || 'checkbox' === $modules_area_option['type'] ) {

				$extra_class = 'dslca-modules-area-edit-option-checkbox';
			}

			if ( ! isset( $modules_area_option['ext'] ) ) {

				$modules_area_option['ext'] = '';
			}

			if ( ! isset( $modules_area_option['min'] ) ) {

				$modules_area_option['min'] = 0;
			}

			if ( ! isset( $modules_area_option['max'] ) ) {

				$modules_area_option['max'] = 100;
			}

			if ( ! isset( $modules_area_option['increment'] ) ) {

				$modules_area_option['increment'] = 1;
			}

			$option_type_class = 'dslca-modules-area-edit-option-' . $modules_area_option['type'] . ' ';

			if ( 'color' === $modules_area_option['type'] ) {
				$option_type_class = 'dslca-modules-area-edit-option-color dslca-color-option';
			}

		}

		?>

		<?php if ( 'group' === $modules_area_option['type'] ) : ?>

			<?php if ( 'open' === $modules_area_option['action'] ) : ?>
				<div class="dslca-modules-area-control-group dslca-modules-area-edit-option" data-section="<?php echo esc_attr( $section ); ?>" 
             data-tab="<?php echo esc_attr( $tab_id ); ?>">
					<?php 
					$wrapper_class = '';
					if(strtolower($modules_area_option['label']) == 'margin'){
						$wrapper_class = 'controls-group-margin';
					}else if(strtolower($modules_area_option['label']) == 'padding'){
						$wrapper_class = 'controls-group-padding';
					}
					?>
				<div class="controls-group-inner <?php echo $wrapper_class ?>">
				<span class="dslca-modules-area-edit-label"><?php echo $modules_area_option['label'] ?></span>
			<?php endif; ?>

		<?php else : ?>

		<div class="dslca-modules-area-edit-option <?php echo esc_attr( $option_type_class ) . esc_attr( $extra_class ); ?> dslca-modules-area-edit-option-<?php echo esc_attr( $modules_area_option['id'] ); ?>" data-id="<?php echo esc_attr( $modules_area_option['id'] ); ?>" data-section="<?php echo esc_attr( $section ); ?>" 
             data-tab="<?php echo esc_attr( $tab_id ); ?>">

				<?php if ( isset( $modules_area_option['help'] ) ) : ?>
					<div class="dslca-module-edit-field-ttip-content"><?php echo $modules_area_option['help']; ?></div>
					<span class="dslca-module-edit-label"><?php echo esc_html( $modules_area_option['label'] ); echo dslc_get_modules_area_help(); ?></span>
				<?php else : ?>
					<span class="dslca-module-edit-label"><?php echo esc_html( $modules_area_option['label'] ); ?></span>
				<?php endif; ?>

				<?php if ( 'text' === $modules_area_option['type'] ) : ?>

					<input type="text" class="dslca-modules-area-edit-field" data-id="<?php echo esc_attr( $modules_area_option['id'] ); ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>" />

				<?php elseif ( 'select' === $modules_area_option['type'] ) : ?>

					<select type="text" class="dslca-modules-area-edit-field dslca-modules-area-edit-field-select" data-id="<?php echo esc_attr( $modules_area_option['id'] ); ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>" >
						<?php foreach ( $modules_area_option['choices'] as $choice ) : ?>
							<option value="<?php echo esc_attr( $choice['value'] ); ?>"><?php echo esc_attr( $choice['label'] ); ?></option>
						<?php endforeach; ?>
					</select>

				<?php elseif ( 'color' === $modules_area_option['type'] ) : 

					$style = '';

					if ( isset( $curr_value ) && '' !== $curr_value ) {

						$text_color_value = $curr_value;

						$style = ' style="background: ' . $curr_value . ';"';
					}?>

					<input type="text" class="dslca-modules-area-edit-field dslca-module-edit-field-colorpicker" data-alpha="true" data-id="<?php echo esc_attr( $modules_area_option['id'] ); ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>"  data-affect-on-change-el="<?php echo esc_attr( '.dslca-modules-area-being-edited' ); ?>" data-affect-on-change-rule="<?php echo esc_attr( $css_rule_output ); ?>" />

				<?php elseif ( 'slider' === $modules_area_option['type'] ) : ?>

					<?php
						$slider_min = $modules_area_option['min'];
						$slider_max = $modules_area_option['max'];
						$slider_increment = $modules_area_option['increment'];
						$ext = $modules_area_option['ext'];
						$curr_value = $modules_area_option['std'];

					?>
					<div class="dslca-module-area-edit-field-numeric-wrap">
						<input type="number" class="dslca-modules-area-edit-field dslca-modules-area-edit-field-slider-numeric" data-id="<?php echo esc_attr( $modules_area_option['id'] ); ?>" value="<?php echo $curr_value; ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>" data-min="<?php echo $slider_min; ?>" data-max="<?php echo $slider_max; ?>" data-ext="<?php echo $ext; ?>" data-increment="<?php echo esc_attr( $modules_area_option['increment'] ); ?>" data-ext="<?php echo esc_attr( $modules_area_option['ext'] ); ?>"/>
					</div>

				<?php elseif ( 'border_checkbox' === $modules_area_option['type'] ) : ?>

					<div class="dslca-modules-area-edit-option-checkbox-wrapper">
						<div class="dslca-modules-area-edit-option-checkbox-single">
							<span class="dslca-modules-area-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php esc_html_e( 'Top', 'live-composer-page-builder' ); ?></span>
							<input type="checkbox" class="dslca-modules-area-edit-field dslca-modules-area-edit-field-checkbox" data-id="border-top" data-css-rule="border-width">
						</div>
						<div class="dslca-modules-area-edit-option-checkbox-single">
							<span class="dslca-modules-area-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php esc_html_e( 'Right', 'live-composer-page-builder' ); ?></span>
							<input type="checkbox" class="dslca-modules-area-edit-field dslca-modules-area-edit-field-checkbox" data-id="border-right" data-css-rule="border-width">
						</div>
						<div class="dslca-modules-area-edit-option-checkbox-single">
							<span class="dslca-modules-area-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php esc_html_e( 'Bottom', 'live-composer-page-builder' ); ?></span>
							<input type="checkbox" class="dslca-modules-area-edit-field dslca-modules-area-edit-field-checkbox" data-id="border-bottom" data-css-rule="border-width">
						</div>
						<div class="dslca-modules-area-edit-option-checkbox-single">
							<span class="dslca-modules-area-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php esc_html_e( 'Left', 'live-composer-page-builder' ); ?></span>
							<input type="checkbox" class="dslca-modules-area-edit-field dslca-modules-area-edit-field-checkbox" data-id="border-left" data-css-rule="border-width">
						</div>
					</div>

				<?php elseif ( 'checkbox' === $modules_area_option['type'] ) : ?>

					<div class="dslca-modules-area-edit-option-checkbox-wrapper">
						<?php foreach ( $modules_area_option['choices'] as $choices ) : ?>
							<div class="dslca-modules-area-edit-option-checkbox-single">
								<span class="dslca-modules-area-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php echo esc_attr( $choices['label'] ); ?></span>
								<input type="checkbox" class="dslca-modules-area-edit-field dslca-modules-area-edit-field-checkbox" data-val="<?php echo esc_attr( $choices['value'] ); ?>" data-id="<?php echo esc_attr( $modules_area_option['id'] ); ?>">
							</div>
						<?php endforeach; ?>
					</div>

				<?php endif; ?>
			</div><!-- .dslca-modules-area-edit-option -->

		<?php endif; ?>
		<?php

		if ( 'group' === $modules_area_option['type'] ) {
			if ( 'close' === $modules_area_option['action'] ) {
				echo '</div></div>';
			}
		}
	}
}

/**
 * Output hidden text input elements that will be used as data storage.
 *
 * @param  array $atts   Array with data to fill in.
 * @return string        String with HTML code.
 */
function dslc_modules_area_get_options_fields( $atts = false ) {

	$output = '';

	// Global var containing options.
	global $dslc_var_modules_area_options;

	// If empty return.
	if ( empty( $dslc_var_modules_area_options ) ) {

		return;
	}

	// Go through each option and append HTML.
	if ( $atts ) { // If there is data to fill?

		foreach ( $dslc_var_modules_area_options as $modules_area_option ) {

			if ( 'group' !== $modules_area_option['type'] ) {
				
				if ( ! isset( $modules_area_option['std'] ) ) {

					$modules_area_option['std'] = '';
				}

				// Don't move this line! 'dslca-img-url' should go before 'bg_image'.
				if ( isset( $atts[ $modules_area_option['id'] ] ) && 'bg_image' === $modules_area_option['id'] ) {

					$output .= '<input type="text" data-id="dslca-img-url" value="' . wp_get_attachment_url( $atts[ $modules_area_option['id'] ] ) . '" data-def="' . wp_get_attachment_url( $atts[ $modules_area_option['id'] ] ) . '">';
				}

				if ( isset( $atts[ $modules_area_option['id'] ] ) ) {

					$output .= '<input type="text" data-id="' . $modules_area_option['id'] . '" value="' . $atts[ $modules_area_option['id'] ] . '" data-def="' . $atts[ $modules_area_option['id'] ] . '">';
				} else {

					$output .= '<input type="text" data-id="' . $modules_area_option['id'] . '" value="' . $modules_area_option['std'] . '" data-def="' . $modules_area_option['std'] . '">';
				}
			}
		}
	} else { // If it's a new Module Area?

		foreach ( $dslc_var_modules_area_options as $modules_area_option ) {

			if ( 'group' !== $modules_area_option['type'] ) {

				if ( ! isset( $modules_area_option['std'] ) ) {

					$modules_area_option['std'] = '';
				}

				// Don't move this line! 'dslca-img-url' should go before 'bg_image'.
				if ( isset( $modules_area_option['id'] ) && 'bg_image' === $modules_area_option['id'] ) {

					$output .= '<input type="text" data-id="dslca-img-url" value="' . wp_get_attachment_url( $modules_area_option['std'] ) . '" data-def="' . wp_get_attachment_url( $modules_area_option['std'] ) . '">';
				}

				$output .= '<input type="text" data-id="' . $modules_area_option['id'] . '" value="' . $modules_area_option['std'] . '">';
			}
		}
	}

	return $output;

}

/**
 * Generate CSS styles for the Modules Area
 *
 * @param  array $atts set of Modules Area attributes.
 * @return string      CSS styles for the Modules Area.
 */
function dslc_modules_area_generate_css( $module_settings = false, $options_to_process = array() ) {
    
    global $dslc_var_modules_area_options;
    $instance_id = isset( $module_settings['modules_area_instance_id'] ) ? $module_settings['modules_area_instance_id'] : false;
    $style = '';

    if ( empty( $module_settings ) || empty( $options_to_process ) ) {
        return '';
    }

    foreach ( $options_to_process as $option_definition ) {
        
        $option_id = $option_definition['id'];
        
        if ( ! isset( $option_definition['affect_on_change_el'] ) || $option_definition['affect_on_change_el'] === '' ) {

            $rules = isset( $option_definition['affect_on_change_rule'] ) ? explode( ',', $option_definition['affect_on_change_rule'] ) : false;

            $value = isset( $module_settings[ $option_id ] ) ? $module_settings[ $option_id ] : (isset($option_definition['std']) ? $option_definition['std'] : false);

            if ( $value === false || $value === '' ) continue;

            $orig_value = $value;
            
            $resolved_ext = isset( $option_definition['ext'] ) ? $option_definition['ext'] : '';
            
            if ( strpos($option_id, 'padding') !== false && isset($module_settings['padding_unit']) ) {
                $resolved_ext = $module_settings['padding_unit'];
            } elseif ( strpos($option_id, 'margin') !== false && isset($module_settings['margin_unit']) ) {
                $resolved_ext = $module_settings['margin_unit'];
            }
            
            // Only apply units to numeric values
            if ( is_numeric($value) ) {
                $value = $value . $resolved_ext;
            }

            if ( 'border' === $option_id ) {
                $checkbox_arr = explode( ' ', trim( $orig_value ) );
                if ( ! in_array( 'top', $checkbox_arr, true ) ) { $style .= 'border-top-width: 0; '; }
                if ( ! in_array( 'right', $checkbox_arr, true ) ) { $style .= 'border-right-width: 0; '; }
                if ( ! in_array( 'bottom', $checkbox_arr, true ) ) { $style .= 'border-bottom-width: 0; '; }
                if ( ! in_array( 'left', $checkbox_arr, true ) ) { $style .= 'border-left-width: 0; '; }                
            }

            if ( $rules ) {
                foreach ( $rules as $rule ) {                                        
					$style .= $rule . ':' . $value . ';';
                }
            }
        }
    }

    if ( $style && $instance_id ) {
        return '.dslc-modules-area[data-modules-area-id="' . esc_attr( $instance_id ) .'"] {' . $style . '}';
    }

    return '';
}
/**
 * Get initial ( default ) Modules Area style
 *
 * @since 2.1.4
 */
function dslc_modules_area_get_initial_style() {

	global $dslc_var_modules_area_options;
	$instance_id = isset( $atts['modules_area_instance_id'] ) ? $atts['modules_area_instance_id'] : false;
	$style = '';

	// If empty return.
	if ( empty( $dslc_var_modules_area_options ) ) {
		return;
	}

	// Loop through all options.
	foreach ( $dslc_var_modules_area_options as $modules_area_option ) {

		// If there's an el then it's not for the section div.
		if ( ! isset( $modules_area_option['affect_on_change_el'] ) ) {

			// The CSS rules.
			$rules = false;
			if ( isset( $modules_area_option['affect_on_change_rule'] ) ) {

				$rules = explode( ',', $modules_area_option['affect_on_change_rule'] );
			}

			// The CSS value.
			$value = false;
			if ( isset( $modules_area_option['std'] ) ) {
				$value = $modules_area_option['std'];
			}

			$orig_value = $value;

			// The CSS value extension.
			if ( isset( $modules_area_option['ext'] ) ) {

				$value = $value . $modules_area_option['ext'];
			}

			// Border.
			if ( 'border' === $modules_area_option['id'] ) {

				$checkbox_arr = explode( ' ', trim( $value ) );

				if ( ! in_array( 'top', $checkbox_arr, true ) ) {

					$style .= 'border-top-style: hidden; ';
				}

				if ( ! in_array( 'right', $checkbox_arr, true ) ) {

					$style .= 'border-right-style: hidden; ';
				}

				if ( ! in_array( 'bottom', $checkbox_arr, true ) ) {

					$style .= 'border-bottom-style: hidden; ';
				}

				if ( ! in_array( 'left', $checkbox_arr, true ) ) {

					$style .= 'border-left-style: hidden; ';
				}
			}

			if ( $value && $rules ) {

				foreach ( $rules as $rule ) {

					$style .= $rule . ':' . $value . ';';

				}
			}
		}
	}

	return '.dslc-modules-area { ' . $style . ' }';
}

/**
 * Get control help
 */
function dslc_get_modules_area_help() {

	$output = '<span class="dslca-module-edit-field-ttip-hook"><span class="dslca-icon dslc-icon-info"></span></span>';

	return $output;
}

function dslc_modules_area_get_style($module_settings = false ) {

	global $dslc_css_style;
	global $dslc_var_modules_area_options;
	$css_output = '';

	/* Extract responsive settings into separate arrays. */

	$module_structure_resp_desktop = array();
	$module_structure_resp_tablet = array();
	$module_structure_resp_phone = array();

	foreach ( $dslc_var_modules_area_options as $single_option ) {

		// Make sure our function do not break when setting case is wrong.
		if ( isset( $single_option['tab'] ) ) {
			$single_option['tab'] = strtolower( $single_option['tab'] );
		}

		if ( isset( $single_option['section'] ) ) {
			$single_option['section'] = strtolower( $single_option['section'] );
		}

		if ( isset( $single_option['section'] ) && 'responsive' === $single_option['section'] ) {

			if ( isset( $single_option['tab'] ) && 'phone' === $single_option['tab'] ) {

				$module_structure_resp_phone[] = $single_option;
			} elseif ( 'tablet' === $single_option['tab'] ) {

				$module_structure_resp_tablet[] = $single_option;
			}
		} else {

			$module_structure_resp_desktop[] = $single_option;
		}
	}

	$module_structure = array(); // Reset array.

	$module_structure['desktop'] = $module_structure_resp_desktop;

	if ( isset( $module_settings['css_res_t'] ) && 'enabled' === $module_settings['css_res_t'] ) {

		$module_structure['tablet'] = $module_structure_resp_tablet;
	}

	if ( isset( $module_settings['css_res_p'] ) && 'enabled' === $module_settings['css_res_p'] ) {

		$module_structure['phone'] = $module_structure_resp_phone;
	}

	/* Go through each device group */

	foreach ( $module_structure as $device => $module_structure_resp ) {

		$device_css = dslc_modules_area_generate_css($module_settings, $module_structure_resp );

		if ( '' !== $device_css ) {

			if ( 'tablet' === $device ) {

				$css_output .= '@media only screen and (min-width : 768px) and (max-width : 1024px)  {';
			} elseif ( 'phone' === $device ) {

				$css_output .= '@media only screen and ( max-width: 767px ) {';
			}

			$css_output .= $device_css;

			if ( 'desktop' !== $device ) {

				$css_output .= '}';
			}
		}
	}

	$modules_area_instance_id = $module_settings['modules_area_instance_id'];

	return $css_output;
}