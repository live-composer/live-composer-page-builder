<?php
/**
 * CSS generation functions.
 *
 * @package LiveComposer
 * @since 1.2
 *
 * Table of Contents
 *
 * - dslc_dynamic_css_hook ( Were to output generated CSS. )
 * - dslc_custom_css ( Generates all the Custom CSS )
 * - dslc_render_css ( Render CSS code based on provided raw code of the page )
 * - dslc_shortcodes_add_suffix_css ( Rename shortcodes in the dslc_code for CSS generation. )
 * - dslc_modules_section_gen_css ( Generate CSS - Modules Section. )
 * - dslc_modules_area_gen_css ( Generate CSS - Modules Area. )
 * - dslc_module_gen_css ( Generate CSS - Modules. )
 * - dslc_generate_custom_css ( Generate module CSS (for all devices) )
 * - dslc_generate_module_css ( Worker function used by dslc_generate_custom_css. )
 * - dslc_helper_is_border_radius ( Check if string provided is variation of the border radius property in CSS. )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Indicates were to output generated CSS for this page content.
 * In the <head> or before </body> ?
 *
 * @return void
 */
function dslc_dynamic_css_hook() {

	if ( is_admin() ) {
		return; // Do not call this function form wp-admin parent page.
	}

	$dynamic_css_location = dslc_get_option( 'lc_css_position', 'dslc_plugin_options' );

	if ( ! $dynamic_css_location ) {
		$dynamic_css_location = 'head';
	}

	if ( 'head' === $dynamic_css_location ) {
		add_action( 'wp_head', 'dslc_custom_css' );
	} else {
		add_action( 'wp_footer', 'dslc_custom_css' );
	}

} add_action( 'wp_loaded', 'dslc_dynamic_css_hook' );

/**
 * Custom CSS
 * Generates all the Custom CSS.
 *
 * @since 1.0
 */
function dslc_custom_css( $dslc_code = '' ) {

	// Allow theme developers to output CSS for non-standard custom post types.
	$dslc_custom_css_ignore_check = false;
	$dslc_custom_css_ignore_check = apply_filters( 'dslc_generate_custom_css', $dslc_custom_css_ignore_check );

	if ( $dslc_code ) {
		$dslc_custom_css_ignore_check = true;
	}

	if ( ! is_singular() &&
		 ! is_archive() &&
		 ! is_author() &&
		 ! is_search() &&
		 ! is_404() &&
		 ! is_home() &&
		 ! $dslc_custom_css_ignore_check
	) {
		return;
	}

	global $dslc_active;
	global $dslc_css_style;
	global $content_width;
	global $dslc_post_types;

	$code = '';
	$template_code = '';

	$lc_width = dslc_get_option( 'lc_max_width', 'dslc_plugin_options' );

	if ( empty( $lc_width ) ) {

		$lc_width = $content_width . 'px';

	} else {

		if ( false === strpos( $lc_width, 'px' ) && false === strpos( $lc_width, '%' ) ) {
			$lc_width = $lc_width . 'px';
		}
	}

	// Filter $lc_width ( for devs ).
	$lc_width = apply_filters( 'dslc_content_width', $lc_width );

	if ( ! $dslc_code ) {

		$template_id = false;

		global $post;

		// If single, load template?
		if ( is_singular( $dslc_post_types ) ) {
			$template_id = dslc_st_get_template_id( get_the_ID() );
		}

		// If archive, load template?
		if ( is_archive() && $post && ! is_author() && ! is_search() ) {
			$post_type = get_post_type();

			$template_id = dslc_get_archive_template_by_pt( $post_type );
		}

		if ( is_author() && $post ) {
			$template_id = dslc_get_archive_template_by_pt( 'author' );
		}

		if ( is_search() && $post ) {
			$template_id = dslc_get_archive_template_by_pt( 'search_results' );
		}

		if ( is_404() ||
			( is_archive() && ! $post ) ||
			( is_search() && ! $post ) ||
			( is_author() && ! $post ) ) {
			$template_id = dslc_get_archive_template_by_pt( '404_page' );
		}

		// Header/Footer.
		if ( $template_id ) {

			$header_footer = dslc_hf_get_ID( $template_id );

		} elseif ( is_singular( $dslc_post_types ) ) {

			$template_id = dslc_st_get_template_id( get_the_ID() );
			$header_footer = dslc_hf_get_ID( $template_id );

		} else {

			$header_footer = dslc_hf_get_ID( get_the_ID() );
		}

		// Header.
		if ( $header_footer['header'] ) {
			$header_code = get_post_meta( $header_footer['header'], 'dslc_code', true );
		}

		// Footer.
		if ( $header_footer['footer'] ) {
			$footer_code = get_post_meta( $header_footer['footer'], 'dslc_code', true );
		}

		// Template content.
		if ( $template_id ) {
			$template_code = get_post_meta( $template_id, 'dslc_code', true );
		}

		// Post/Page content.
		$post_id = get_the_ID();
		$code = get_post_meta( $post_id, 'dslc_code', true );

	} else { // End of ! $dslc_code check.

		$code = $dslc_code;
	}

	echo '<style type="text/css">';

	$output_css = false;

	// Generate CSS if page code is set.
	// Genrated code added into $dslc_css_style global var.
	if ( isset( $code ) && $code ) {
		dslc_render_css( $code );
		$output_css = true;
	}

	// Generate CSS if template code is set.
	// Genrated code added into $dslc_css_style global var.
	if ( isset( $template_code ) && $template_code ) {
		dslc_render_css( $template_code );
		$output_css = true;
	}

	// Generate CSS if header code is set.
	// Genrated code added into $dslc_css_style global var.
	if ( isset( $header_code ) && $header_code ) {
		dslc_render_css( $header_code );
		$output_css = true;
	}

	// Generate CSS if footer code is set.
	// Genrated code added into $dslc_css_style global var.
	if ( isset( $footer_code ) && $footer_code ) {
		dslc_render_css( $footer_code );
		$output_css = true;
	}

	dslc_render_gfonts();

	// Wrapper width.
	echo '.dslc-modules-section-wrapper, .dslca-add-modules-section { width : ' . $lc_width . '; } ';

	// Add horizontal padding to the secitons (set in the plugins settings).
	$section_padding_hor = dslc_get_option( 'lc_section_paddings', 'dslc_plugin_options' );

	if ( ! empty( $section_padding_hor ) ) {
		echo '.dslc-modules-section:not(.dslc-full) { padding-left: ' . $section_padding_hor . ';  padding-right: ' . $section_padding_hor . '; } ';
	}

	// Initial ( default ) row CSS.
	echo dslc_row_get_initial_style();

	// Echo CSS style.
	if ( ! $dslc_active ) {
		if ( $dslc_custom_css_ignore_check || $output_css ) {
			echo $dslc_css_style;
		}
	}

	echo '</style>';
}

/**
 * Render CSS code based on provided raw code of the page.
 * Works with both old (shortcodes) and new verion (JSON) of dslc_code.
 *
 * @param  string/json $code Code to render CSS for. Can be shortcode based string or JSON.
 * @return string            Generated CSS output.
 */
function dslc_render_css( $code ) {

	$code_array = dslc_json_decode( $code );

	if ( is_array( $code_array ) ) {
		// JSON based code version.
		// Go though ROWs.
		foreach ( $code_array as $row ) {
			// Go through each Module Area.
			foreach ( $row['content'] as $module_area ) {
				// Go through each Module.
				foreach ( $module_area['content'] as $module ) {

					dslc_module_gen_css( array(), $module );
				}
			}
		}
	} else {
		// Old (shortcodes based) code version.
		// Replace shortcode names.
		$code = dslc_shortcodes_add_suffix_css( $code );

		// Do CSS shortcode.
		$css_output = do_shortcode( $code );

		return $css_output;
	}
}

/**
 * Rename shortcodes in the dslc_code for CSS generation.
 * Not used in new version of dslc_code (JSON based).
 *
 * @param  string $code String with shortcode-based page code.
 * @return string       String with modified shortcodes.
 */
function dslc_shortcodes_add_suffix_css( $code ) {

	// Replace shortcode names.
	$code = str_replace( 'dslc_modules_section', 'dslc_modules_section_gen_css', $code );
	$code = str_replace( 'dslc_modules_area', 'dslc_modules_area_gen_css', $code );
	$code = str_replace( '[dslc_module]', '[dslc_module_gen_css]', $code );
	$code = str_replace( '[dslc_module ', '[dslc_module_gen_css ', $code );
	$code = str_replace( '[/dslc_module]', '[/dslc_module_gen_css]', $code );

	return $code;
}

/**
 * Generate CSS - Modules Section
 */
function dslc_modules_section_gen_css( $atts, $content = null ) {

	return do_shortcode( $content );

} add_shortcode( 'dslc_modules_section_gen_css', 'dslc_modules_section_gen_css' );

/**
 * Generate CSS - Modules Area
 */
function dslc_modules_area_gen_css( $atts, $content = null ) {

	return do_shortcode( $content );

} add_shortcode( 'dslc_modules_area_gen_css', 'dslc_modules_area_gen_css' );

/**
 * Generate CSS - Module
 */
function dslc_module_gen_css( $atts, $settings_raw ) {

	// Check if it's JSON or base64 code. No matter what return array.
	$settings = dslc_json_decode( $settings_raw );

	// If it's an array?
	if ( is_array( $settings ) ) {

		// The ID of the module.
		$module_id = $settings['module_id'];

		// Check if module exists.
		if ( ! dslc_is_module_active( $module_id ) ) {
			return;
		}

		// If class does not exists.
		if ( ! class_exists( $module_id ) ) {
			return;
		}

		// Instanciate the module class.
		$module_instance = new $module_id();

		// Get array of options.
		$options_arr = $module_instance->options();

		// Load preset options if preset supplied.
		$settings = apply_filters( 'dslc_filter_settings', $settings );

		// Transform image ID to URL.
		global $dslc_var_image_option_bckp;
		$dslc_var_image_option_bckp = array();

		foreach ( $options_arr as $option_arr ) {

			if ( 'image' === $option_arr['type'] ) {
				if ( isset( $settings[ $option_arr['id'] ] ) && ! empty( $settings[ $option_arr['id'] ] ) && is_numeric( $settings[ $option_arr['id'] ] ) ) {
					$dslc_var_image_option_bckp[ $option_arr['id'] ] = $settings[ $option_arr['id'] ];
					$image_info = wp_get_attachment_image_src( $settings[ $option_arr['id'] ], 'full' );
					$settings[ $option_arr['id'] ] = $image_info[0];
				}
			}

			// Fix css_custom value ( issue when default changed programmatically ).
			if ( 'css_custom' === $option_arr['id'] && 'DSLC_Text_Simple' === $module_id && ! isset( $settings['css_custom'] ) ) {
				$settings['css_custom'] = $option_arr['std'];
			}
		}

		// Generate custom CSS.
		/*
		* Changed from the next line in ver.1.0.8
		* if ( ( $module_id == 'DSLC_TP_Content' || $module_id == 'DSLC_Html' ) && ! isset( $settings['css_custom'] ) )
		* Line above was breaking styling for DSLC_TP_Content modules when used in template
		*/

		$css_output = '';

		if ( 'DSLC_Html' === $module_id && ! isset( $settings['css_custom'] ) ) {
			$css_output = '';
		} elseif ( isset( $settings['css_custom'] ) && 'disabled' === $settings['css_custom'] ) {
			$css_output = '';
		} else {
			$css_output = dslc_generate_custom_css( $options_arr, $settings );
		}

		return $css_output;
	}

} add_shortcode( 'dslc_module_gen_css', 'dslc_module_gen_css' );

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
	if ( isset( $module_settings['code_version'] ) && 1 === $module_settings['code_version'] ) {
		$module_settings = dslc_code_migration( $module_settings );
	}

	$css_output = '';
	global $dslc_googlefonts_array;
	$regular_fonts = array( 'Georgia', 'Times', 'Arial', 'Lucida Sans Unicode', 'Tahoma', 'Trebuchet MS', 'Verdana', 'Helvetica' );
	$organized_array = array();

	global $dslc_css_fonts;
	global $dslc_css_style;
	global $dslc_active;

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

			// Never strip responsive enable/disable property.
			// Fix for "alter_defaults" and responsive tablet state.
			if ( 'css_res_t' === $option_id && 'enabled' === $option_arr['std'] && ! isset( $module_settings['css_res_t'] ) ) {
				$module_settings['css_res_t'] = 'enabled';
			}

			// Never strip responsive enable/disable property.
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
				if ( stristr( $css_property, 'border-' ) &&
						! dslc_helper_is_border_radius( $css_property ) ) {
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

			if ( isset( $css_declaration_borders['border-width'] ) ) {

				$border_width = $css_declaration_borders['border-width'];
				if ( ! empty( $border_width ) && '0px' !== $border_width ) {
					$output_border_declaration = true;
				}

			// The code below fix the bug with posts grid and separator property.
			} elseif ( isset( $css_declaration_borders['border-top-width'] ) ||
					isset( $css_declaration_borders['border-right-width'] ) ||
					isset( $css_declaration_borders['border-bottom-width'] ) ||
					isset( $css_declaration_borders['border-left-width'] ) ) {
				$output_border_declaration = true;
			}

			// Always output all the border properties when:
			// – LC in the editing mode.
			// – CSS rules are for :hover or active state
			// – CSS rules are for inactive state or current item ( Module Navigation )
			// Otherwise it breaks live preview for border properties.
			if ( $dslc_active || stristr( $css_selector, ':hover' ) ||
					stristr( $css_selector, '.dslc-active' ) ||
					stristr( $css_selector, '.dslc-inactive' ) ||
					stristr( $css_selector, '.current-menu-item' ) ) {
				$output_border_declaration = true;
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