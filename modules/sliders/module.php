<?php
/**
 * Sliders module class
 */

/**
 * Class DSLC_Sliders
 */
class DSLC_Sliders extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	/**
	 * @inherited
	 */
	function __construct( $settings = [], $atts = [] ) {

		$this->module_ver = 2;
		$this->module_id = __CLASS__;
		$this->module_title = __( 'Slider (Revolution)', 'live-composer-page-builder' );
		$this->module_icon = 'picture';
		$this->module_category = 'elements';

		parent::__construct( $settings, $atts );
	}

	/**
	 * @inherited
	 */
	function options() {

		// Get Rev Sliders
		global $wpdb;
		$slider_choices = array();
		$slider_choices[] = array(
			'label' => __( '-- Select --', 'live-composer-page-builder' ),
			'value' => 'not_set',
		);

		$table_name = $wpdb->prefix . 'revslider_sliders';

		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name){
			$sliders = $wpdb->get_results( "SELECT id, title, alias, type FROM $table_name" );
			if ( ! empty( $sliders ) ) {

				foreach ( $sliders as $slider ) {
					if( $slider->type == ''){
						$slider_choices[] = array(
							'label' => $slider->title,
							'value' => $slider->alias
						);
					}
				}

			}
		}

		$dslc_options = array(
			array(
				'label' => __( 'Show On', 'live-composer-page-builder' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'live-composer-page-builder' ),
						'value' => 'desktop'
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet'
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone'
					),
				),
			),
			array(
				'label' => __( 'Revolution Slider', 'live-composer-page-builder' ),
				'id' => 'slider',
				'std' => 'not_set',
				'type' => 'select',
				'choices' => $slider_choices
			)
		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	/**
	 * @inherited
	 */
	function output( $options = [] ) {

		$this->module_start();

		/* Module output stars here */
		echo $this->renderModule();
		/* Module output ends here */

		$this->module_end();

	}

}

/// Register module
( new DSLC_Sliders )->register();