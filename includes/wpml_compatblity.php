<?php
/**
 * Table of Contents
 *
 * dslc_convert_to_translation_array ( run on dslc_save_post hook to save the content for translation )
 * update_dslc_code_meta ( run on wpml_pro_translation_completed hook to update the translated dslc_code with translated content )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

// run on dslc_save_post hook to save the content for translation
add_action( 'dslc_save_post', 'dslc_convert_to_translation_array',10,1);

function dslc_convert_to_translation_array($post_id) {
	$content_for_translation = [];

	// Define the keys to extract for each module_id
	$module_keys_array = [
        'DSLC_Text_Simple' => ['content'],
        'DSLC_Shortcode' => [],
        'DSLC_Image' => ['custom_text','image_title'],
        'DSLC_Accordion' => ['accordion_nav','accordion_content'],
        'DSLC_Separator' => [],
        'DSLC_Button' => ['button_text'],
        'DSLC_Info_Box' => ['title','content','button_title','button_2_title'],
        'DSLC_Partners' => ['main_heading_title','pagination_text','main_filter_title_all','main_heading_link_title'],
        'DSLC_Testimonials'=> ['pagination_text','main_heading_title','main_heading_link_title','main_filter_title_all'],
        'DSLC_Projects' => ['button_text','main_heading_title','main_heading_link_title','main_filter_title_all','pagination_text'],
        'LBMN_MasterSlider' => [],
        'DSLC_Icon' => [],
        'DSLC_Social' => [],
        'DSLC_Tabs' => ['tabs_content','tabs_nav'],
        'DSLC_Progress_Bars' => [],
        'DSLC_Notification' => ['content'],
        'DSLC_Blog' => ['button_text','main_heading_title','main_heading_link_title','main_filter_title_all'],
        'DSLC_Posts' => ['button_text','main_heading_title','main_heading_link_title','main_filter_title_all'],
        'DSLC_Galleries' => [],
        'DSLC_Downloads' => ['button_text','main_heading_title','main_heading_link_title','main_filter_title_all'],
        'DSLC_Staff'=> ['main_heading_title','main_heading_link_title','main_filter_title_all'],
        'DSLC_Widgets' => [],
        'DSLC_Navigation' => [],
        'DSLC_Logo' => [],
        'DSLC_TP_Thumbnail' => [],
        'DSLC_TP_Title' => [],
        'DSLC_TP_Excerpt' => [],
        'DSLC_TP_Meta' => [],
        'DSLC_TP_Content' => [],
        'DSLC_TP_Downloads_Button' => ['button_text'],
        'DSLC_TP_Gallery_Slider' => [],
        'DSLC_TP_Project_Slider' => [],
        'DSLC_TP_Comments' => [],
        'DSLC_TP_Comments_Form' => ['txt_leave_comment','txt_name','txt_email','txt_website','txt_comment','txt_submit_comment','txt_url'],
        'DSLC_TP_Staff_Social' => [],
        'LBMN_Ninja_Forms' => [],
        'LCPROEXT_Contact_Form_7' => [],
        'DSLC_Menu_Pro' => [], 
        'OpenSteetMap' => [],
        'SKLC_GMaps_Module' => [],
		'DSLC_Html' => ['content'],
    ];
	$dslc_code = get_post_meta( $post_id, 'dslc_code', true );
	$dslc_array = json_decode($dslc_code);

	foreach ($dslc_array as $row_index => $row) {
		if (!isset($row->element_type) || $row->element_type !== 'row') {
			// Skipping row index as it is not a row Module.
			continue;
		}

		$row_content = $row->content ?? [];
		foreach ($row_content as $module_area_index => $module_area) 
		{
			if (!isset($module_area->element_type) || $module_area->element_type !== 'module_area') {
				// Skipping module_area index as it is not a module_area.
				continue;
			}
			
			$modules = $module_area->content ?? [];

			foreach ($modules as $module_index => $module) 
			{
				if (!isset($module->element_type) || $module->element_type !== 'module') {
					// Skipping module index as it is not a module.
					continue;
				}
				$module_id = $module->module_id ?? null;

				if (!$module_id || !isset($module_keys_array[$module_id])) {
					// Skipping module index as module_id is invalid or not in the keys mapping.
					continue;
				}

				$keys_to_extract = $module_keys_array[$module_id];

				foreach ($keys_to_extract as $key) {
					if (isset($module->$key) && is_string($module->$key)) 
					{
						if($module_id == 'DSLC_Accordion' && ($key == 'accordion_nav' || $key == 'accordion_content'))
						{
							$module_content = explode('(dslc_sep)',$module->$key);
							$path = "{$row_index}.content.{$module_area_index}.content.{$module_index}.{$key}";
							$content_for_translation[] = [
								$path => $module_content
							];
						}
						elseif($module_id == 'DSLC_Tabs' && ($key == 'tabs_nav' || $key == 'tabs_content'))
						{
							$module_content = explode('(dslc_sep)',$module->$key);
							$path = "{$row_index}.content.{$module_area_index}.content.{$module_index}.{$key}";
							$content_for_translation[] = [
								$path => $module_content
							];
						}
						else
						{
							$path = "{$row_index}.content.{$module_area_index}.content.{$module_index}.{$key}";
							$content_for_translation[] = [
								$path => $module->$key
							];
						}
					}
				}

			}
		}
	}
	// Update the post meta with the extracted content_for_translation
    update_post_meta( $post_id, 'dslc_content_for_translation', $content_for_translation);
}

// wpml_pro_translation_completed hook to update the dslc_code meta after translation
// This hook is triggered when a translation is completed in WPML

add_action( 'wpml_pro_translation_completed', 'update_dslc_code_meta');

function update_dslc_code_meta( $post_id ) 
{
	$original_post_id = apply_filters('wpml_object_id', $post_id, get_post_type($post_id), true, wpml_get_default_language());
	$dslc_code_meta = get_post_meta($original_post_id, 'dslc_code', true);
	$dslc_code_array = json_decode($dslc_code_meta);
	$translated_meta = get_post_meta($post_id, 'dslc_content_for_translation', true);

	if (!empty($translated_meta) && is_array($translated_meta))
	{
		foreach ($translated_meta as $value)
		{
			foreach ($value as $k => $v) 
			{
				$pathParts = explode('.', $k);
				setValueByPath($dslc_code_array, $pathParts, $v);
			}
		}
	}

	$encoded_json = json_encode($dslc_code_array,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	$trimmed_json = trim($encoded_json);
	$unescaped_json = wp_slash($trimmed_json);
	delete_post_meta( $post_id, 'dslc_code' );
	update_post_meta( $post_id, 'dslc_code', $unescaped_json);
}

// updates the dslc_code key value in the post meta with the translated content

function setValueByPath(&$obj, $pathParts, $newValue) 
{
	$currentPart = array_shift($pathParts);
	$isLast = empty($pathParts);

	// Determine if we're working with an object or array
	$key = is_numeric($currentPart) ? (int)$currentPart : $currentPart;


	// ✅ LAST STEP: Set the value
	if ($isLast)
	{
		if (is_array($obj)) 
		{
			if(is_array($newValue) && in_array($key, ['accordion_nav','accordion_content','tabs_nav','tabs_content']))
			{
				$obj[$key] = implode('(dslc_sep)',$newValue);
			}
			else
			{
				$obj[$key] = $newValue;
			}
		}
		elseif (is_object($obj)) 
		{
			if(is_array($newValue) && in_array($key, ['accordion_nav','accordion_content','tabs_nav','tabs_content']))
			{
				$obj->$key = implode('(dslc_sep)',$newValue);
			}
			else
			{
				$obj->$key = $newValue;
			}			
		}
		return;
	}

	// ✅ NEXT LEVEL: Ensure the target exists before recursing
	if (is_array($obj))
	{
		if (!isset($obj[$key])) {
			$obj[$key] = is_numeric($pathParts[0]) ? [] : new stdClass();
		}
		setValueByPath($obj[$key], $pathParts, $newValue);

	}
	elseif (is_object($obj))
	{
		if (!isset($obj->$key)) {
			$obj->$key = is_numeric($pathParts[0]) ? [] : new stdClass();
		}
		setValueByPath($obj->$key, $pathParts, $newValue);
	}
}

?>