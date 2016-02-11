<?php
/**
 * Second generation module with. 
 * Represents abstract architecture of future module in Live Composer 2.0
 *
 * @inherited  $module_id
 * @inherited  $module_title
 * @inherited  $module_icon
 * @inherited  $module_category
 */

/// Register module
DSLC_speedybutton::register();

/**
 * Class Speedy Button
 */
class DSLC_speedybutton extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	/**
	 * @inherit
	 */
	function __construct()
	{
		$this->module_id = __CLASS__;
		$this->module_title = __( 'Speedy Button', 'live-composer-page-builder' );
		$this->module_icon = 'link';
		$this->module_category = 'single';
	}

	/**
	 * @inherited
	 *
	 * @return bool apply_filters result
	 */
	function options() {	

			// The options array
		$options = array(
	 
			// A simple text input option
			array(
				'label' => 'Text Input',
				'id' => 'text_input',
				'std' => 'Default value',
				'type' => 'text',
			),
			array(
				'label' => 'OLOLO',
				'id' => 'some_thing',
				'std' => 'Default',
				'type' => 'front_renderer'
			)
	 
		);
	 
		// Return the array
		return apply_filters( 'dslc_module_options', $options, $this->module_id ); 
	}

	/**
	 * Outputs html
	 * 
	 * @inherited
	 */
	function output($options)
	{
		global $dslc_active;

		$post_id = $options['post_id'];

		if ( is_singular() ) {
			$post_id = get_the_ID();
		}



		$this->module_start( $options );

			?>
			<p style="font-size:20px">
			<?=$options['text_input'];?>	
			</p>
			<?php

		/* Module output ends here */

		$this->module_end( $options );
	}

}