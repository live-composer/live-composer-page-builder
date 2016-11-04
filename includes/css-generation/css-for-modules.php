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


	// If this module was just imported from the first generation
	// of dslc_code (shortcodes + base64) launch a special migration process.
	// In migration process we fix some issues to make sure nothing breaks
	// when we switch users to JSON code format.
	if ( isset( $settings['code_version'] ) && 1 === $settings['code_version'] ) {
		$module_settings = dslc_code_migration( $module_settings );
	}

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

		$option_id = $option_arr['id'];

		// 🔖 RAW CODE CLEANUP
		// if ( isset( $module_settings[ $option_id ] ) && ! empty( $module_settings[ $option_id ] )  ) {
		if ( isset( $module_settings[ $option_id ] ) && '' !== $module_settings[ $option_id ] && false !== $module_settings[ $option_id ]  ) {

			// Fix for "alter_defaults" and responsive tablet state.
			if ( 'css_res_t' === $option_id && 'enabled' === $option_arr['std'] && ! isset( $module_settings['css_res_t'] ) ) {
				$module_settings['css_res_t'] = 'enabled';
			}

			// Fix for "alter_defaults" and responsive phone state.
			if ( 'css_res_p' === $option_id && 'enabled' === $option_arr['std'] && ! isset( $module_settings['css_res_p'] ) ) {
				$module_settings['css_res_p'] = 'enabled';
			}

			// If option type is CSS-based and option is set.
			if ( isset( $option_arr['affect_on_change_el'] ) && isset( $option_arr['affect_on_change_rule'] ) ) {

				// Fill the missing setting with default values.
				// 🔖 RAW CODE CLEANUP
				// if ( ! isset( $module_settings[ $option_id ] ) || empty( $module_settings[ $option_id ] )  ) {
				// 	$module_settings[ $option_id ] = $option_arr['std'];
				// }

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

					if ( '' === $module_settings[ $option_id ] ) {

						$checkbox_val = '';

					} else {

						$checkbox_arr = explode( ' ', trim( $module_settings[ $option_id ] ) );

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

					$module_settings[ $option_id ] = $checkbox_val;

				}

				// Colors (transparent if empty ).
				if ( '' === $module_settings[ $option_id ] && ( 'background' === $option_arr['affect_on_change_rule'] || 'background-color' === $option_arr['affect_on_change_rule'] ) ) {

					$module_settings[ $option_id ] = '';
				}

				foreach ( $affect_rules_arr as $affect_rule ) {
					if ( '' !== $module_settings[ $option_id ] ) {
						$organized_array[ $affect_el ][ $affect_rule ] = $prepend . $module_settings[ $option_id ] . $ext . $append;
					}
				}
			}

			// If option type is font?
			if ( 'font' === $option_arr['type'] ) {

				if ( ! in_array( $module_settings[ $option_id ], $dslc_googlefonts_array, true ) && ! in_array( $module_settings[ $option_id ], $regular_fonts, true ) ) {
					$dslc_googlefonts_array[] = $module_settings[ $option_id ];
				}
			}
		} // If isset and not empty.
	}

// ------- SPLIT INTO SEPARATE FUNCTION ------------------------------------
	if ( count( $organized_array ) > 0 ) {

		foreach ( $organized_array as $el => $rules ) {

			/**
			 * Anatomy of CSS rule:
			 *
			 * #selector { declaration }
			 *
			 * #selector {
			 * 	property: value;
			 * }
			 *
			 */

			$css_selector = $el;
			$css_declaration = $rules;
			$css_element_output = array();

			$do_css_output = true; // Flag to skip current css block output.

			// Clear css selector from double spaces.
			$css_selector = preg_replace( '/ {2,}/', ' ', $css_selector );

			// Do not output empty CSS blocks.
			if ( ! count( $css_declaration ) || strlen( $css_selector ) < 2 ) {
				$do_css_output = false;
			}

			$css_element_output[ $css_selector ] = array();

			// ------- SPLIT INTO SEPARATE FUNCTION ------------------------------------
			// Argument: $css_declaration and $important_append (or decalre it inside)
			// Output: array with css property:value pairs.
			// Go through each propery to compose css declaration block.

			$css_declaration_backgrounds = array();
			$css_declaration_borders = array();

			foreach ( $css_declaration as $css_property => $css_value ) {
				// Clean property and value from extra spaces.
				$css_property = trim( $css_property );
				$css_value = trim( $css_value );

				// Do not output properties with empty value.
				if ( '' === $css_value || 'url(" ")' === $css_value ) {
					unset( $css_declaration[ $css_property ] );
				}

				// Do not output properties with restricted characters in value.
				if ( preg_match( "/([\[\];<>]+)/", $css_value ) ) {
					unset( $css_declaration[ $css_property ] );
				}

				// Do not output properties if it's not in allowed characters set.
				if ( ! preg_match( "/([-a-z@]{3,60})/", $css_property ) ) {
					unset( $css_declaration[ $css_property ] );
				}

				// Do not output max-width = 0 property.
				if ( 'max-width' === $css_property &&  ( '0px' === $css_value || '0' === $css_value ) ) { // Min-width = 0 is empty.
					unset( $css_declaration[ $css_property ] );
				}

				// -------- SPLIT INTO A SEPARATE FUNCTION -------------

				// Separate all the backgroud properties (beside 'background-color') into a new array.
				/*
				if ( 'background-color' !== $css_property && stristr( $css_property, 'background-' ) ) {
					$css_declaration_backgrounds[ $css_property ] = $css_value;
					unset( $css_declaration[ $css_property ] );
				}
				*/


				// Separate all the boder properties (beside 'border-radius') into a new array.
				if ( stristr( $css_property, 'border-' ) && ! dslc_helper_is_border_radius( $css_property ) ) {
					$css_declaration_borders[ $css_property ] = $css_value;
					unset( $css_declaration[ $css_property ] );
				}

				// Adjust font-family output (wrap in quotes each font).
				if ( 'font-family' === $css_property ) {

					$font_families = array();
					$font_families = explode( ',', $css_value );

					$css_value = '';

					foreach ( $font_families as $font ) {
						$font = trim( $font );
						$font = str_replace('"', '', $font);
						$font = str_replace('\'', '', $font);
						$font = '"' . $font . '",';

						$css_value .= $font;
					}

					$css_value = rtrim( $css_value, ',' ); // Remove trailing comma.
					$css_declaration[ $css_property ] = $css_value;
				}

			}

			/**
			 * Add $css_declaration_borders to the main css block
			 * only if border-width property is set and is not 0.
			 */

			$output_border_declaration = false;

			if ( isset( $css_declaration_borders['border-width'] )  ) {
				$border_width = $css_declaration_borders['border-width'];
				if ( ! empty( $border_width ) && '0px' !== $border_width ) {
					$output_border_declaration = true;
				}
			}
			/*
			if ( $output_border_declaration && isset( $css_declaration_borders['border-style'] )  ) {
				$border_style = $css_declaration_borders['border-style'];
				if ( ! empty( $border_style ) ) {
					$output_border_declaration = true;
				} else {
					$output_border_declaration = false;
				}
			}
			*/

			if ( $output_border_declaration ) {
				$css_declaration = array_merge( $css_declaration, $css_declaration_borders );
			} else {
				// $css_declaration['border'] = 'none'; // Causing issues
			}
			

			//---------

			$css_output_el = ''; // Var for temporary output of current el.
			$css_output_el .= $css_selector . '{';

			foreach ( $css_declaration as $css_property => $css_value ) {
				$css_output_el .= $css_property . ':' . $css_value . ';';
			}

			$css_output_el .= '} ';

			if ( $do_css_output ) {
				$css_output .= $css_output_el;
			}

			// @todo: dont' forget about . $important_append after each value;

		}
	}
// ------- SPLIT INTO SEPARATE FUNCTION ------------------------------------
	return $css_output;
}


/**
 * Check if string provided is variation of the border radius property in CSS.
 * @param  string $property_name Property name to chek.
 * @return bool                  True if it's variation of the border radius property.
 */
function dslc_helper_is_border_radius ( $property_name ) {
	// Remove empty spaces.
	$property_name = trim( $property_name );

	if ( stristr( $property_name, 'border-') && stristr( $property_name, '-radius') ) {
		return true;
	} else {
		return false;
	}
}
