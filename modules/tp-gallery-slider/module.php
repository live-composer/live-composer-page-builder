<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_TP_Gallery_Slider extends DSLC_Module {

	public $module_id;
	public $module_title;
	public $module_icon;
	public $module_category;

	function __construct() {

		$this->module_id = 'DSLC_TP_Gallery_Slider';
		$this->module_title = __( 'Gallery Slider', 'live-composer-page-builder' );
		$this->module_icon = 'picture';
		$this->module_category = 'For Templates';

	}

	public function galleries_posts_list() {
		$posts_list = array(
			array(
				'label' => __( 'Current Gallery', 'live-composer-page-builder' ),
				'value' => '0',
			),
		);

		$posts_galleries = get_posts( array(
			'numberposts' => -1,
			'post_type' => 'dslc_galleries',
		) );

		foreach ( $posts_galleries as $post ) {

			$posts_list[] = array(
				'label' => $post->post_title,
				'value' => $post->ID,
			);
		}

		return $posts_list;
	}

	/**
	 * Module options.
	 * Function build array with all the module functionality and styling options.
	 * Based on this array Live Composer builds module settings panel.
	 * – Every array inside $dslc_options means one option = one control.
	 * – Every option should have unique (for this module) id.
	 * – Options divides on "Functionality" and "Styling".
	 * – Styling options start with css_XXXXXXX
	 * – Responsive options start with css_res_t_ (Tablet) or css_res_p_ (Phone)
	 * – Options can be hidden.
	 * – Options can have a default value.
	 * – Options can request refresh from server on change or do live refresh via CSS.
	 *
	 * @return array All the module options in array.
	 */
	function options() {

		// Check if we have this module options already calculated
		// and cached in WP Object Cache.
		$cached_dslc_options = wp_cache_get( 'dslc_options_' . $this->module_id, 'dslc_modules' );
		if ( $cached_dslc_options ) {
			return apply_filters( 'dslc_module_options', $cached_dslc_options, $this->module_id );
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
						'value' => 'desktop',
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet',
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone',
					),
				),
			),
			array(
				'label' => __( 'Display Pictures From', 'live-composer-page-builder' ),
				'id' => 'gallery_post_id',
				'std' => '0',
				'type' => 'select',
				'choices' => $this->galleries_posts_list(),
			),
			array(
				'label' => __( 'Animation', 'live-composer-page-builder' ),
				'id' => 'animation',
				'std' => 'fade',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Fade', 'live-composer-page-builder' ),
						'value' => 'fade',
					),
					array(
						'label' => __( 'Fade Up Slide', 'live-composer-page-builder' ),
						'value' => 'fadeUp',
					),
					array(
						'label' => __( 'Slide', 'live-composer-page-builder' ),
						'value' => 'false',
					),
					array(
						'label' => __( 'Back Slide', 'live-composer-page-builder' ),
						'value' => 'backSlide',
					),
					array(
						'label' => __( 'Go Down', 'live-composer-page-builder' ),
						'value' => 'goDown',
					),
				),
			),
			array(
				'label' => __( 'Animation Speed (ms)', 'live-composer-page-builder' ),
				'id' => 'animation_speed',
				'std' => '800',
				'type' => 'text',
			),
			array(
				'label' => __( 'Autoplay Speed (ms)', 'live-composer-page-builder' ),
				'id' => 'autoplay',
				'std' => '0',
				'type' => 'text',
			),
			array(
				'label' => __( 'Flexible Height', 'live-composer-page-builder' ),
				'id' => 'flexible_height',
				'std' => 'true',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'true',
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'false',
					),
				),
			),
			array(
				'label' => __( 'Lightbox', 'live-composer-page-builder' ),
				'help' => __( 'Enabling will make clicking an image open up the image in a lightbox.', 'live-composer-page-builder' ),
				'id' => 'lightbox_state',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
				),
			),

			/**
			 * General Styling
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_border_width',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'increment' => 5,
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/**
			 * Slider
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_slider_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Slider', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_slider_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Slider', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_slider_border_width',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_slider_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Slider', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_slider_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_slider_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_slider_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_slider_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_slider_align',
				'std' => '',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider .dslc-slider-item',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'slider', 'live-composer-page-builder' ),
			),

			/**
			 * Slides
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_slider_item_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Slider - item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_slider_item_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Slider - item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_slider_item_border_width',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider - item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_slider_item_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Slider - item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_slider_item_border_radius_top',
				'onlypositive' => true, // Value can't be negative.
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item,.dslc-tp-gallery-slider-main .dslc-slider-item img',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider - item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_slider_item_border_radius_bottom',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item,.dslc-tp-gallery-slider-main .dslc-slider-item img',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider - item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_slider_item_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider - item', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_slider_item_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Slider - item', 'live-composer-page-builder' ),
			),

			/**
			 * Navigation
			 */

			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_circles_bradius',
				'onlypositive' => true, // Value can't be negative.
				'std' => '50',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Navigation', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_circles_color',
				'std' => '#b9b9b9',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Active', 'live-composer-page-builder' ),
				'id' => 'css_circles_color_active',
				'std' => '#5890e5',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page.active span',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Vertical', 'live-composer-page-builder' ),
				'id' => 'css_circles_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-controls',
				'affect_on_change_rule' => 'margin',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size', 'live-composer-page-builder' ),
				'id' => 'css_circles_size',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Spacing', 'live-composer-page-builder' ),
				'id' => 'css_circles_spacing',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'styling',
				'tab' => __( 'Navigation', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
				'id' => 'css_res_t',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Slider - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_slider_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Slider - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_slider_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Slider Item - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_slider_item_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Slider Item - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_slider_item_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Nav - Margin Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_circles_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-controls',
				'affect_on_change_rule' => 'margin',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_circles_size',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Spacing', 'live-composer-page-builder' ),
				'id' => 'css_res_t_circles_spacing',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/**
			 * Responsive phone
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
				'id' => 'css_res_p',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Slider - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_slider_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Slider - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_slider_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Slider Item - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_slider_item_padding_vertical',
				'onlypositive' => true, // Value can't be negative.
				'max' => 600,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Slider Item - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_slider_item_padding_horizontal',
				'onlypositive' => true, // Value can't be negative.
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-gallery-slider-main .dslc-slider-item',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'ext' => 'px',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Nav - Margin Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_circles_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-controls',
				'affect_on_change_rule' => 'margin',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_circles_size',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page span',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Nav - Spacing', 'live-composer-page-builder' ),
				'id' => 'css_res_p_circles_spacing',
				'std' => '3',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.owl-pagination .owl-page',
				'affect_on_change_rule' => 'margin-left,margin-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array(
			'hover_opts' => false,
		) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		// Cache calculated array in WP Object Cache.
		wp_cache_add( 'dslc_options_' . $this->module_id, $dslc_options, 'dslc_modules' );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}
	/**
	 * Module HTML output.
	 *
	 * @param  array $options Module options to fill the module template.
	 * @return void
	 */
	function output( $options ) {

		global $dslc_active;

		$show_placeholder = true;
		$show_real = false;

		if ( is_singular() && get_post_type() !== 'dslc_templates' ) {

			if ( intval( $options['gallery_post_id'] ) > 0 ) {

				$gallery_images = get_post_meta( intval( $options['gallery_post_id'] ), 'dslc_gallery_images', true );

			} else {

				$gallery_images = get_post_meta( get_the_ID(), 'dslc_gallery_images', true );

			}

			if ( ! empty( $gallery_images ) ) {
				$show_real = true;
				$show_placeholder = false;

				$gallery_images = explode( ' ', trim( $gallery_images ) );
			} else {
				$gallery_images = array();
			}
		}

		/* Module output starts here */

		if ( $show_placeholder || $show_real ) {

			$img_class = '';
			if ( $options['lightbox_state'] == 'enabled' ) {
				$img_class = 'dslc-trigger-lightbox-gallery';
			}

			?>

			<div class="dslc-tp-gallery-slider">

				<div class="dslc-tp-gallery-slider-main">

					<div class="dslc-loader"></div>

					<div class="dslc-slider"  data-animation="<?php echo $options['animation']; ?>" data-animation-speed="<?php echo $options['animation_speed']; ?>" data-autoplay="<?php echo $options['autoplay']; ?>" data-flexible-height="<?php echo $options['flexible_height']; ?>">

						<?php

						if ( $show_placeholder ) {

							for ( $i = 0; $i < 15; $i++ ) {
								?><div class="dslc-slider-item"><img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/placeholders/big-placeholder.png" /></div><?php
							}
						} else {

							foreach ( $gallery_images as $gallery_image ) {

								$gallery_image_src = wp_get_attachment_image_src( $gallery_image, 'full' );
								$gallery_image_src = $gallery_image_src[0];

								$thumb_alt = get_post_meta( $gallery_image, '_wp_attachment_image_alt', true );
								if ( ! $thumb_alt ) { $thumb_alt = '';
								}

								?><div class="dslc-slider-item"><img class="<?php echo $img_class; ?>" src="<?php echo $gallery_image_src; ?>" alt="<?php echo $thumb_alt; ?>" /></div><?php

							}
						}

							?>

							</div><!-- .dslc-slider -->

							<?php if ( ! $show_placeholder && $options['lightbox_state'] == 'enabled' ) : ?>

								<div class="dslc-lightbox-gallery">

									<?php foreach ( $gallery_images as $gallery_image ) : ?>

										<?php
											$gallery_image_src = wp_get_attachment_image_src( $gallery_image, 'full' );
											$gallery_image_src = $gallery_image_src[0];

											$gallery_image_title = get_post_meta( $gallery_image, '_wp_attachment_image_alt', true );
										if ( ! $gallery_image_title ) { $gallery_image_title = '';
										}
										?>

										<a href="<?php echo $gallery_image_src; ?>" title="<?php echo esc_attr( $gallery_image_title ); ?>"></a>

									<?php endforeach; ?>

								</div><!-- .dslc-gallery-lightbox -->

							<?php endif; ?>

						</div><!-- .dslc-tp-gallery-slider-main -->

					</div><!-- .dslc-tp-gallery-slider -->

				<?php

		}// End if().

	}

}
