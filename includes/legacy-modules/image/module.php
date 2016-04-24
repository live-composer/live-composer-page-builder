<?php

class __DSLC_Image extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = __CLASS__;
		$this->module_title = __( 'Image', 'live-composer-page-builder' );
		$this->module_icon = 'picture';
		$this->module_category = 'elements';

	}

	function options() {

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
				'label' => __( 'CT', 'live-composer-page-builder' ),
				'id' => 'custom_text',
				'std' => __( 'This is just some placeholder text. Click to edit it.', 'live-composer-page-builder' ),
				'type' => 'textarea',
				'visibility' => 'hidden'
			),

			array(
				'label' => __( 'Image - File', 'live-composer-page-builder' ),
				'id' => 'image',
				'std' => '',
				'type' => 'image',
			),
			array(
				'label' => __( 'Image - URL', 'live-composer-page-builder' ),
				'help' => __( 'Will be used as a fallback if file ( previous option ) not supplied.', 'live-composer-page-builder' ),
				'id' => 'image_url',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Link Type', 'live-composer-page-builder' ),
				'id' => 'link_type',
				'std' => 'none',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'live-composer-page-builder' ),
						'value' => 'none',
					),
					array(
						'label' => __( 'URL - Same Tab', 'live-composer-page-builder' ),
						'value' => 'url_same',
					),
					array(
						'label' => __( 'URL - New Tab', 'live-composer-page-builder' ),
						'value' => 'url_new',
					),
					array(
						'label' => __( 'Lightbox', 'live-composer-page-builder' ),
						'value' => 'lightbox',
					),
				)
			),
			array(
				'label' => __( 'Link - URL', 'live-composer-page-builder' ),
				'id' => 'link_url',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Link - Lightbox Image', 'live-composer-page-builder' ),
				'id' => 'link_lb_image',
				'std' => '',
				'type' => 'image',
			),
			array(
				'label' => __( 'Custom Text', 'live-composer-page-builder' ),
				'id' => 'custom_text_state',
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
				)
			),
			array(
				'label' => __( 'Resize - Height', 'live-composer-page-builder' ),
				'id' => 'resize_height',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
				'id' => 'resize_width',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Image - ALT attribute', 'live-composer-page-builder' ),
				'id' => 'image_alt',
				'std' => '',
				'type' => 'text',
			),

			array(
				'label' => __( 'Image - TITLE attribute', 'live-composer-page-builder' ),
				'id' => 'image_title',
				'std' => '',
				'type' => 'text',
			),


			/**
			 * Styling
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
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
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_border_radius',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image, .dslc-image img',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'min' => -150,
				'max' => 150
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Force 100% Width', 'live-composer-page-builder' ),
				'id' => 'css_force_width',
				'std' => 'auto',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => '100%'
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'auto'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image img',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
			),

			/**
			 * Custom Text
			 */

			array(
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_ct_text_align',
				'std' => 'center',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'custom text', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_ct_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'custom text', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_ct_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'custom text', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_ct_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'custom text', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_ct_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'custom text', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_ct_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'custom text', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_ct_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'custom text', 'live-composer-page-builder' ),
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
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_ct_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_ct_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text - Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_res_t_ct_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/**
			 * Responsive Phone
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
				'id' => 'css_res_p',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
				),
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_ct_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_ct_line_height',
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text - Margin Top', 'live-composer-page-builder' ),
				'id' => 'css_res_p_ct_margin_top',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-image-caption',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'responsive',
				'tab' => __( 'phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),


		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		/* Module output starts here */

			global $dslc_active;

			if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
				$dslc_is_admin = true;
			else
				$dslc_is_admin = false;

			$anchor_class = '';
			$anchor_target = '_self';
			$anchor_href = '#';

			if ( isset($options['link_type']) && $options['link_type'] == 'url_new' )
				$anchor_target = '_blank';

			if ( isset($options['link_url']) && $options['link_url'] !== '' )
				$anchor_href = do_shortcode( $options['link_url'] );

			if ( isset($options['link_type']) && $options['link_type'] == 'lightbox' && $options['link_lb_image'] !== '' ) {
				$anchor_class .= 'dslc-lightbox-image ';
				$anchor_href = $options['link_lb_image'];
			}


			?>

			<div class="dslc-image">

				<?php if ( empty( $options['image'] ) && empty( $options['image_url'] ) ) : ?>

					<div class="dslc-notification dslc-red"><?php _e( 'No image has been set yet, edit the module to set one.', 'live-composer-page-builder' ); ?></div>

				<?php else : ?>

					<?php

						$resize = false;
						$the_image = $options['image'];

						if ( empty( $options['image'] ) ) {

							$the_image = do_shortcode( $options['image_url'] );

						} else {

							if ( $options['resize_width'] != '' || $options['resize_height'] != '' ) {

								$resize = true;
								$resize_width = false;
								$resize_height = false;

								if ( $options['resize_width'] != '' )
									$resize_width = $options['resize_width'];

								if ( $options['resize_height'] != '' )
									$resize_height = $options['resize_height'];

								$the_image = dslc_aq_resize( $options['image'], $resize_width, $resize_height, true );

							}

						}

					?>

					<?php if ( $options['link_type'] !== 'none' ) : ?>
						<a class="<?php echo $anchor_class; ?>" href="<?php echo $anchor_href; ?>" target="<?php echo $anchor_target; ?>">
					<?php endif; ?>
						<img src="<?php echo $the_image ?>" alt="<?php echo $options['image_alt']; ?>" title="<?php echo $options['image_title']; ?>" />
					<?php if ( $options['link_type'] !== 'none' ) : ?>
						</a>
					<?php endif; ?>

					<?php if ( $options['custom_text_state'] == 'enabled' ) : ?>

						<div class="dslc-image-caption">

							<?php if ( $dslc_is_admin ) : ?>
								<div class="dslca-editable-content" data-id="custom_text" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes( $options['custom_text'] ); ?></div>
							<?php else : ?>
								<?php echo stripslashes( $options['custom_text'] ); ?>
							<?php endif; ?>

						</div>

					<?php endif; ?>

				<?php endif; ?>

			</div><!-- .dslc-image -->

			<?php

		/* Module output ends here */

	}

}