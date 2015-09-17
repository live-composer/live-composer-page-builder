<?php

class DSLC_Social extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Social';
		$this->module_title = __( 'Social', 'dslc_string' );
		$this->module_icon = 'twitter';
		$this->module_category = 'elements';

	}

	function options() {	

		$dslc_options = array(
			
			/**
			 * General
			 */
			array(
				'label' => __( 'Show On', 'dslc_string' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'dslc_string' ),
						'value' => 'desktop'
					),
					array(
						'label' => __( 'Tablet', 'dslc_string' ),
						'value' => 'tablet'
					),
					array(
						'label' => __( 'Phone', 'dslc_string' ),
						'value' => 'phone'
					),
				),
			),
			array(
				'label' => __( 'Show Labels', 'dslc_string' ),
				'id' => 'show_labels',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'enabled'
					),
				),
			),
			array(
				'label' => __( 'Twitter', 'dslc_string' ),
				'id' => 'twitter',
				'std' => '#',
				'type' => 'text',
			),
			array(
				'label' => __( 'Facebook', 'dslc_string' ),
				'id' => 'facebook',
				'std' => '#',
				'type' => 'text',
			),
			array(
				'label' => __( 'Youtube', 'dslc_string' ),
				'id' => 'youtube',
				'std' => '#',
				'type' => 'text',
			),
			array(
				'label' => __( 'Vimeo', 'dslc_string' ),
				'id' => 'vimeo',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Tumblr', 'dslc_string' ),
				'id' => 'tumblr',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Pinterest', 'dslc_string' ),
				'id' => 'pinterest',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'LinkedIn', 'dslc_string' ),
				'id' => 'linkedin',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Instagram', 'dslc_string' ),
				'id' => 'instagram',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'GitHub', 'dslc_string' ),
				'id' => 'github',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Google Plus', 'dslc_string' ),
				'id' => 'googleplus',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Dribbble', 'dslc_string' ),
				'id' => 'dribbble',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Dropbox', 'dslc_string' ),
				'id' => 'dropbox',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Flickr', 'dslc_string' ),
				'id' => 'flickr',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'FourSquare', 'dslc_string' ),
				'id' => 'foursquare',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Behance', 'dslc_string' ),
				'id' => 'behance',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'RSS', 'dslc_string' ),
				'id' => 'rss',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Yelp', 'dslc_string' ),
				'id' => 'yelp',
				'std' => '',
				'type' => 'text',
			),

			/**
			 * Styling
			 */

			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_border_color',
				'std' => '#000000',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color - Hover', 'dslc_string' ),
				'id' => 'css_border_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon:hover',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_border_radius',
				'std' => '50',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_bg_color',
				'std' => '#40bde6',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => ' ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Color - Hover', 'dslc_string' ),
				'id' => 'css_bg_color_hover',
				'std' => '#40bde6',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => ' ul.dslc-social a.dslc-social-icon:hover',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'dslc_string' ),
				'id' => 'css_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.ul.dslc-social',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			),
			array(
				'label' => __( 'Margin Top', 'dslc_string' ),
				'id' => 'css_margin_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Left', 'dslc_string' ),
				'id' => 'css_padding_left',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'padding-left',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Right', 'dslc_string' ),
				'id' => 'css_padding_right',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Top', 'dslc_string' ),
				'id' => 'css_padding_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'padding-top',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Bottom', 'dslc_string' ),
				'id' => 'css_padding_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size', 'dslc_string' ),
				'id' => 'css_size',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Spacing', 'dslc_string' ),
				'id' => 'css_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social li',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px'
			),

			/* Icon */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_icon_color',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => ' ul.dslc-social .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'icon', 'dslc_string' ),
			),
			array(
				'label' => __( 'Color - Hover', 'dslc_string' ),
				'id' => 'css_icon_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => ' ul.dslc-social a.dslc-social-icon:hover .dslc-icon',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'icon', 'dslc_string' ),
			),
			array(
				'label' => __( 'Size', 'dslc_string' ),
				'id' => 'css_icon_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'icon', 'dslc_string' ),
				'ext' => 'px'
			),

			/* Label */

			array(
				'label' => __( 'Color', 'dslc_string' ),
				'id' => 'css_label_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'labels', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Size', 'dslc_string' ),
				'id' => 'css_label_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'labels', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'dslc_string' ),
				'id' => 'css_label_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'labels', 'dslc_string' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'dslc_string' ),
				'id' => 'css_label_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'labels', 'dslc_string' ),
			),
			array(
				'label' => __( 'Font Style', 'dslc_string' ),
				'id' => 'css_label_font_style',
				'std' => 'normal',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'font-style',
				'section' => 'styling',
				'tab' => __( 'labels', 'dslc_string' ),
				'choices' => array(
					array(
						'label' => __( 'Normal', 'dslc_string' ),
						'value' => 'normal',
					),
					array(
						'label' => __( 'Italic', 'dslc_string' ),
						'value' => 'italic',
					),
				)
			),
			array(
				'label' => __( 'Letter Spacing', 'dslc_string' ),
				'id' => 'css_label_letter_spacing',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'letter-spacing',
				'section' => 'styling',
				'tab' => __( 'labels', 'dslc_string' ),
				'ext' => 'px',
				'min' => -50,
				'max' => 50
			),
			array(
				'label' => __( 'Line Height', 'dslc_string' ),
				'id' => 'css_label_line_height',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'labels', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Left', 'dslc_string' ),
				'id' => 'css_label_mleft',
				'std' => '7',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'margin-left',
				'section' => 'styling',
				'tab' => __( 'labels', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Transform', 'dslc_string' ),
				'id' => 'css_label_text_transform',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => 'none'
					),
					array(
						'label' => __( 'Capitalize', 'dslc_string' ),
						'value' => 'capitalize'
					),
					array(
						'label' => __( 'Uppercase', 'dslc_string' ),
						'value' => 'uppercase'
					),
					array(
						'label' => __( 'Lowercase', 'dslc_string' ),
						'value' => 'lowercase'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-social-label',
				'affect_on_change_rule' => 'text-transform',
				'section' => 'styling',
				'tab' => __( 'labels', 'dslc_string' ),
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => __( 'Responsive Styling', 'dslc_string' ),
				'id' => 'css_res_t',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size ( Wrapper )', 'dslc_string' ),
				'id' => 'css_res_t_size',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Size ( Icon )', 'dslc_string' ),
				'id' => 'css_res_t_icon_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Spacing', 'dslc_string' ),
				'id' => 'css_res_t_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social li',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'dslc_string' ),
				'ext' => 'px'
			),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => __( 'Responsive Styling', 'dslc_string' ),
				'id' => 'css_res_p',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Size ( Wrapper )', 'dslc_string' ),
				'id' => 'css_res_p_size',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'width,height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Size ( Icon )', 'dslc_string' ),
				'id' => 'css_res_p_icon_font_size',
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social a.dslc-social-icon',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Spacing', 'dslc_string' ),
				'id' => 'css_res_p_spacing',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'ul.dslc-social li',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'dslc_string' ),
				'ext' => 'px'
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {		

		$this->module_start( $options );

		/* Module output starts here */
			
			?>

			<div class="dslc-social-wrap">

				<ul class="dslc-social">
					<?php if ( isset( $options['twitter'] ) && $options['twitter'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['twitter']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-twitter"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['twitter']; ?>"><span><?php _e( 'Twitter', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['facebook'] ) && $options['facebook'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['facebook']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-facebook"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['facebook']; ?>"><span><?php _e( 'Facebook', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['youtube'] ) && $options['youtube'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['youtube']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-youtube-play"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['youtube']; ?>"><span><?php _e( 'Youtube', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['vimeo'] ) && $options['vimeo'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['vimeo']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-vimeo-square"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['vimeo']; ?>"><span><?php _e( 'Vimeo', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['tumblr'] ) && $options['tumblr'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['tumblr']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-tumblr"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['tumblr']; ?>"><span><?php _e( 'Tumblr', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['pinterest'] ) && $options['pinterest'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['pinterest']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-pinterest"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['pinterest']; ?>"><span><?php _e( 'Pinterest', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['linkedin'] ) && $options['linkedin'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['linkedin']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-linkedin"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['linkedin']; ?>"><span><?php _e( 'LinkedIn', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['instagram'] ) && $options['instagram'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['instagram']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-instagram"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['instagram']; ?>"><span><?php _e( 'Instagram', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['github'] ) && $options['github'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['github']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-github-alt"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['github']; ?>"><span><?php _e( 'Github', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['googleplus'] ) && $options['googleplus'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['googleplus']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-google-plus"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['googleplus']; ?>"><span><?php _e( 'Google+', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['dribbble'] ) && $options['dribbble'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['dribbble']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-dribbble"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['dribbble']; ?>"><span><?php _e( 'Dribbble', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['dropbox'] ) && $options['dropbox'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['dropbox']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-dropbox"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['dropbox']; ?>"><span><?php _e( 'Dropbox', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['flickr'] ) && $options['flickr'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['flickr']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-flickr"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['flickr']; ?>"><span><?php _e( 'Flickr', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['foursquare'] ) && $options['foursquare'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['foursquare']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-foursquare"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['foursquare']; ?>"><span><?php _e( 'Foursquare', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['behance'] ) && $options['behance'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['behance']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-behance"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['behance']; ?>"><span><?php _e( 'Behance', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['rss'] ) && $options['rss'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['rss']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-rss"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['rss']; ?>"><span><?php _e( 'RSS', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( isset( $options['yelp'] ) && $options['yelp'] != '' ) : ?>
						<li>
							<a class="dslc-social-icon" target="_blank" href="<?php echo $options['yelp']; ?>"><span class="dslc-icon dslc-init-center dslc-icon-yelp"></span></a>
							<?php if ( $options['show_labels'] == 'enabled' ) : ?>
								<a class="dslc-social-label" target="_blank" href="<?php echo $options['yelp']; ?>"><span><?php _e( 'Yelp', 'dslc_string' ); ?></span></a>
							<?php endif; ?>
						</li>
					<?php endif; ?>
				</ul>

			</div><!-- .dslc-social-wrap -->

			<?php

		/* Module output ends here */

		$this->module_end( $options );

	}

}