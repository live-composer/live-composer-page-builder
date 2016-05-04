<?php
/**
 * DSLC Separator
 */

/**
 * Class DSLC_Separator
 */
class DSLC_Separator extends DSLC_Module{

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	/**
	 * @inherited
	 */
	function __construct()
	{
		$this->module_ver = 2;
		$this->module_id = __CLASS__;
		$this->module_title = __( 'Separator', 'live-composer-page-builder' );
		$this->module_icon = 'minus';
		$this->module_category = 'elements';
	}

	/**
	 * @inherited
	 */
	function options()
	{

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
				'label' => __( 'BG Color', 'live-composer-page-builder' ) ,
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'BG Image', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img',
				'std' => '',
				'type' => 'image',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'background-image',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'BG Image Repeat', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img_repeat',
				'std' => 'repeat',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Repeat', 'live-composer-page-builder' ),
						'value' => 'repeat',
					 ),
					array(
						'label' => __( 'Repeat Horizontal', 'live-composer-page-builder' ),
						'value' => 'repeat-x',
					 ),
					array(
						'label' => __( 'Repeat Vertical', 'live-composer-page-builder' ),
						'value' => 'repeat-y',
					 ),
					array(
						'label' => __( 'Do NOT Repeat', 'live-composer-page-builder' ),
						'value' => 'no-repeat',
					 ),
				 ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'background-repeat',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'BG Image Attachment', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img_attch',
				'std' => 'scroll',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Scroll', 'live-composer-page-builder' ),
						'value' => 'scroll',
					 ),
					array(
						'label' => __( 'Fixed', 'live-composer-page-builder' ),
						'value' => 'fixed',
					 ),
				 ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'background-attachment',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'BG Image Position', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_img_pos',
				'std' => 'top left',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Top Left', 'live-composer-page-builder' ),
						'value' => 'left top',
					 ),
					array(
						'label' => __( 'Top Right', 'live-composer-page-builder' ),
						'value' => 'right top',
					 ),
					array(
						'label' => __( 'Top Center', 'live-composer-page-builder' ),
						'value' => 'Center Top',
					 ),
					array(
						'label' => __( 'Center Left', 'live-composer-page-builder' ),
						'value' => 'left center',
					 ),
					array(
						'label' => __( 'Center Right', 'live-composer-page-builder' ),
						'value' => 'right center',
					 ),
					array(
						'label' => __( 'Center', 'live-composer-page-builder' ),
						'value' => 'center center',
					 ),
					array(
						'label' => __( 'Bottom Left', 'live-composer-page-builder' ),
						'value' => 'left bottom',
					 ),
					array(
						'label' => __( 'Bottom Right', 'live-composer-page-builder' ),
						'value' => 'right bottom',
					 ),
					array(
						'label' => __( 'Bottom Center', 'live-composer-page-builder' ),
						'value' => 'center bottom',
					 ),
				 ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'background-position',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_main_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_main_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			 ),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_main_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top'
					 ),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					 ),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom'
					 ),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					 ),
				 ),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			 ),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator-wrapper',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			 ),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ) ,
				'id' => 'css_border_color',
				'std' => '#ededed',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Height', 'live-composer-page-builder' ) ,
				'id' => 'height',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 1,
				'max' => 300,
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Style', 'live-composer-page-builder' ) ,
				'id' => 'style',
				'std' => 'solid',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Invisible', 'live-composer-page-builder' ) ,
						'value' => 'invisible'
					 ),
					array(
						'label' => __( 'Solid', 'live-composer-page-builder' ) ,
						'value' => 'solid'
					 ),
					array(
						'label' => __( 'Dashed', 'live-composer-page-builder' ) ,
						'value' => 'dashed'
					 ),
					array(
						'label' => __( 'Dotted', 'live-composer-page-builder' ) ,
						'value' => 'dotted'
					 ),
				 ),
				'section' => 'styling',
			 ),
			array(
				'label' => __( 'Thickness', 'live-composer-page-builder' ) ,
				'id' => 'thickness',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator',
				'affect_on_change_rule' => 'border-width',
				'ext' => 'px',
				'min' => 1,
				'max' => 50,
				'section' => 'styling',
			 ),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ) ,
				'id' => 'css_res_t',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ) ,
						'value' => 'disabled'
					 ),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ) ,
						'value' => 'enabled'
					 ),
				 ),
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Height', 'live-composer-page-builder' ) ,
				'id' => 'css_res_t_height',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 1,
				'max' => 300,
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			 ),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ) ,
				'id' => 'css_res_p',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ) ,
						'value' => 'disabled'
					 ),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ) ,
						'value' => 'enabled'
					 ),
				 ),
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			 ),
			array(
				'label' => __( 'Height', 'live-composer-page-builder' ) ,
				'id' => 'css_res_p_height',
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-separator',
				'affect_on_change_rule' => 'margin-bottom,padding-bottom',
				'ext' => 'px',
				'min' => 1,
				'max' => 300,
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			 ),

		 );

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		$options['user_logged_in'] = is_user_logged_in();
		$options['current_user_can'] = current_user_can( DS_LIVE_COMPOSER_CAPABILITY );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	/**
	 * @inherited
	 */
	function output( $options )
	{
		$this->module_start( $options );

		/* Module output stars here */
		echo $this->renderModule( __DIR__, $options );
		/* Module output ends here */

		$this->module_end( $options );
	}

}

/// Register
( new DSLC_Separator )->register();