<?php
/**
 *	CSS code generation for modules/elements
 *
 * @package LiveComposer
 *
 * Table of Contents
 *
 * - dslc_generate_custom_css ( Generate module CSS )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Generate module CSS (for all devices)
 *
 * @since 1.0
 * @param array   $module_structure Array with the structure of the all module settings. Same as $dslc_options in the module.php. Do not contain any data.
 * @param array   $module_settings  Array with all data/settings for the current module.
 * @param boolean $restart          Generating code for the single module (on module settings change).
 */
function dslc_generate_custom_css( $module_structure, $module_settings, $restart = false ) {

	global $dslc_css_style;
	$css_output = '';

	/* Extract responsive settings into separate arrays. */

	$module_structure_resp_desktop = array();
	$module_structure_resp_tablet = array();
	$module_structure_resp_phone = array();

	foreach ( $module_structure as $single_option ) {

		if ( isset( $single_option['section'] ) && 'responsive' === $single_option['section'] ) {

			if ( isset( $single_option['tab'] ) && 'Phone' === $single_option['tab'] ) {

				$module_structure_resp_phone[] = $single_option;
			} elseif ( 'Tablet' === $single_option['tab'] ) {

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

	if ( isset( $module_settings['css_res_p'] ) &&  'enabled' === $module_settings['css_res_p'] ) {

		$module_structure['phone'] = $module_structure_resp_phone;
	}

	/* Go through each device group */

	foreach ( $module_structure as $device => $module_structure_resp ) {

		$device_css = dslc_generate_module_css( $module_structure_resp, $module_settings, $restart );

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

	$dslc_css_style .= $css_output;

}

/**
 * Generate module CSS
 *
 * Worker function. Used by dslc_generate_custom_css.
 *
 * @since 1.0
 */
function dslc_generate_module_css( $module_structure, $module_settings, $restart = false ) {

	$css_output = '';
	global $dslc_googlefonts_array;
	$regular_fonts = array( 'Georgia', 'Times', 'Arial', 'Lucida Sans Unicode', 'Tahoma', 'Trebuchet MS', 'Verdana', 'Helvetica' );
	$organized_array = array();

	global $dslc_css_fonts;
	global $dslc_css_style;

	$important_append = '';
	$force_important = dslc_get_option( 'lc_force_important_css', 'dslc_plugin_options' );
	if ( 'enabled' === $force_important ) {
		$important_append = ' !important';
	}

	if ( isset( $_GET['dslc'] ) ) {
		$important_append = '';
	}

	if ( true === $restart ) {

		$dslc_css_fonts = '';
		$dslc_css_style = '';
	}

	// Go through array of options.
	foreach ( $module_structure as $option_arr ) {

		// Fix for "alter_defaults" and responsive tablet state.
		if ( 'css_res_t' === $option_arr['id'] && 'enabled' === $option_arr['std'] && ! isset( $module_settings['css_res_t'] ) ) {
			$module_settings['css_res_t'] = 'enabled';
		}

		// Fix for "alter_defaults" and responsive phone state.
		if ( 'css_res_p' === $option_arr['id'] && 'enabled' === $option_arr['std'] && ! isset( $module_settings['css_res_p'] ) ) {
			$module_settings['css_res_p'] = 'enabled';
		}

		// If option type is CSS-based and option is set.
		if ( isset( $option_arr['affect_on_change_el'] ) && isset( $option_arr['affect_on_change_rule'] ) ) {

			// Default.
			if ( ! isset( $module_settings[ $option_arr['id'] ] ) ) {
				$module_settings[ $option_arr['id'] ] = $option_arr['std'];
			}

			// Extension for the input control (px, %, em...).
			$ext = ' ';
			if ( isset( $option_arr['ext'] ) ) {
				$ext = $option_arr['ext'];
			}

			// Prepend.
			$prepend = '';
			if ( isset( $option_arr['prepend'] ) ) {
				$prepend = $option_arr['prepend'];
			}

			// Append.
			$append = '';
			if ( isset( $option_arr['append'] ) ) {
				$append = $option_arr['append'];
			}

			if ( 'image' === $option_arr['type'] ) {
				$prepend = 'url("';
				$append = '")';
			}

			// Get element and CSS rule.
			$affect_rule_raw = $option_arr['affect_on_change_rule'];
			$affect_rules_arr = explode( ',', $affect_rule_raw );

			// Affect Element.
			$affect_el = '';
			$affect_els_arr = explode( ',', $option_arr['affect_on_change_el'] );
			$count = 0;
			foreach ( $affect_els_arr as $affect_el_arr ) {
				$count++;
				if ( $count > 1 ) {
					$affect_el .= ',';
				}

				// Removed #dslc-content from the line for better CSS optimization.
				$affect_el .= '#dslc-module-' . $module_settings['module_instance_id'] . ' ' . $affect_el_arr;
			}

			// Checkbox ( CSS ).
			if ( 'checkbox' === $option_arr['type'] && false === $option_arr['refresh_on_change'] ) {

				$checkbox_val = '';

				if ( '' === $module_settings[ $option_arr['id'] ] ) {

					$checkbox_val = '';

				} else {

					$checkbox_arr = explode( ' ', trim( $module_settings[ $option_arr['id'] ] ) );

					if ( in_array( 'top', $checkbox_arr, true ) ) {
						$checkbox_val .= 'solid ';
					} else {
						$checkbox_val .= 'none ';
					}

					if ( in_array( 'right', $checkbox_arr, true ) ) {
						$checkbox_val .= 'solid ';
					} else {
						$checkbox_val .= 'none ';
					}

					if ( in_array( 'bottom', $checkbox_arr, true ) ) {
						$checkbox_val .= 'solid ';
					} else {
						$checkbox_val .= 'none ';
					}

					if ( in_array( 'left', $checkbox_arr, true ) ) {
						$checkbox_val .= 'solid ';
					} else {
						$checkbox_val .= 'none ';
					}

					if ( 'none none none none ' === $checkbox_val ) {
						$checkbox_val = 'none';
					}
				}

				$module_settings[ $option_arr['id'] ] = $checkbox_val;

			}

			// Colors (transparent if empty ).
			if ( '' === $module_settings[ $option_arr['id'] ] && ( 'background' === $option_arr['affect_on_change_rule'] || 'background-color' === $option_arr['affect_on_change_rule'] ) ) {

				$module_settings[ $option_arr['id'] ] = '';
			}

			foreach ( $affect_rules_arr as $affect_rule ) {
				if ( '' !== $module_settings[ $option_arr['id'] ] ) {
					$organized_array[ $affect_el ][ $affect_rule ] = $prepend . $module_settings[ $option_arr['id'] ] . $ext . $append;
				}
			}
		}

		// If option type is font?
		if ( 'font' === $option_arr['type'] ) {

			if ( ! in_array( $module_settings[ $option_arr['id'] ], $dslc_googlefonts_array, true ) && ! in_array( $module_settings[ $option_arr['id'] ], $regular_fonts, true ) ) {
				$dslc_googlefonts_array[] = $module_settings[ $option_arr['id'] ];
			}
		}
	}

	if ( count( $organized_array ) > 0 ) {

		foreach ( $organized_array as $el => $rules ) {
			$do_css_output = false;
			$css_output_el = ''; // Var for temporary output of current el.

			$do_css_output_background = false;
			$css_output_el_background = ''; // Process background CSS properties separately.

			// Remove double spaces form css element address.
			$el = preg_replace( '/ {2,}/', ' ', $el );

			// Do not output empty CSS blocks.
			if ( count( $rules ) && strlen( $el ) > 2 ) {
				$css_output_el .= $el . '{';

				foreach ( $rules as $rule => $value ) {
					$css_output_rule = '';
					$rule = trim( $rule );
					$value = trim( $value );

					// Basic CSS rule name validation.
					if ( '' !== $value && 'url(" ")' !== $value && ! preg_match( "/([\[\];<>]+)/", $value ) && preg_match( "/([-a-z@]{3,60})/", $rule ) ) {

						// Output all the background properties only if background-image is set.
						if ( 'background-image' === $rule ) {
							$do_css_output_background = true;
						}

						// Adjust font-family output.
						if ( 'font-family' === $rule ) {

							$font_families = array();
							$font_families = explode( ',', $value );

							$value = '';

							foreach ( $font_families as $font ) {
								$font = trim( $font );
								$font = '"' . $font . '",';

								$value .= $font;
							}

							$value = rtrim( $value, ',' );
						}

						$css_output_rule .= $rule . ':' . $value . $important_append . ';';

						if ( stristr( $rule, 'background-' ) && 'background-color' !== $rule ) {
							$css_output_el_background .= $css_output_rule;
						} elseif ( 'max-width' === $rule &&  ( '0px' === $value || '0' === $value || '1400px' === $value ) ) { // Min-width = 0 is empty.
							$css_output_el .= '';
						} else {
							$css_output_el .= $css_output_rule;
						}

						$do_css_output = true;
					}
				}

				if ( $do_css_output_background ) {
					$css_output_el .= $css_output_el_background;
				}

				$css_output_el = trim( $css_output_el );

				$css_output_el .= '} ';
			}

			if ( $do_css_output ) {
				$css_output .= $css_output_el;
			}
		}
	}

	return $css_output;
}
