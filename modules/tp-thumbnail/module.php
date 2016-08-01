<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_TP_Thumbnail extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_TP_Thumbnail';
		$this->module_title = __( 'Thumbnail', 'live-composer-page-builder' );
		$this->module_icon = 'picture';
		$this->module_category = 'For Templates';

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
				'label' => __( 'Align', 'live-composer-page-builder' ),
				'id' => 'css_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			),
			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_border_width',
				'min' => 0,
				'max' => 10,
				'increment' => 1,

				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
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
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_border_radius_top',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'border-top-left-radius,border-top-right-radius',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Border Radius - Bottom', 'live-composer-page-builder' ),
				'id' => 'css_border_radius_bottom',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'border-bottom-left-radius,border-bottom-right-radius',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Lightbox', 'live-composer-page-builder' ),
				'id' => 'lightbox_state',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled'
					),
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled'
					),
				),
				'section' => 'styling',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
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
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
 				'label' => __( 'Resize - Width', 'live-composer-page-builder' ),
 				'id' => 'resize_width',
 				'std' => '',
 				'type' => 'text',
 				'section' => 'styling',
 			),
 			array(
 				'label' => __( 'Resize - Height', 'live-composer-page-builder' ),
 				'id' => 'resize_height',
 				'std' => '',
 				'type' => 'text',
 				'section' => 'styling',
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
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
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
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-thumbnail',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array('hover_opts' => false) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active;

		$post_id = $options['post_id'];

		$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );

		if ( ! $thumb_url && ! $dslc_active ) {
			return; // Don't output module if no thumbnail set.
		}

		$thumb_url = $thumb_url[0];

		$this->module_start( $options );

		if ( is_singular() ) {
			$post_id = get_the_ID();
		}

		/* Module output starts here */

			$manual_resize = false;
			if ( ! empty( $options['resize_width'] ) || ! empty( $options['resize_height'] ) ) {

				$manual_resize = true;
				$resize_width = false;
				$resize_height = false;

				if ( isset( $options['resize_width'] ) && ! empty( $options['resize_width'] ) ) {
					$resize_width = $options['resize_width'];
				}

				if ( isset( $options['resize_height'] ) && ! empty( $options['resize_height'] ) ) {
					$resize_height = $options['resize_height'];
				}

			}

			if ( get_post_type( $post_id ) == 'dslc_templates' || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) :
				if ( has_post_thumbnail( $post_id ) ) :
					?><div class="dslc-tp-thumbnail"><?php
						if ( $manual_resize ) : ?>
							<img src="<?php $res_img = dslc_aq_resize( $thumb_url, $resize_width, $resize_height, true ); echo $res_img; ?>" />
						<?php else : ?>
							<?php echo get_the_post_thumbnail( $post_id, 'full' ); ?>
						<?php endif;
					?></div>
				<?php
				else :

					$placeholder_inline_style = 'style="';

					if ( $resize_width ) {
						$placeholder_inline_style .= 'width:' . $resize_width . 'px;';
					}

					if ( $resize_height ) {
						$placeholder_inline_style .= 'height:' . $resize_height . 'px;';
					}

					$placeholder_inline_style .= '"';
				?>
					<div class="dslc-tp-thumbnail dslc-tp-thumbnail-fake"><img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/placeholders/tpl-thumb-placeholder.png" <?php echo $placeholder_inline_style; ?> /></div>
					<?php
				endif;
			else :
				?><div class="dslc-tp-thumbnail">
					<?php if ( isset( $options['lightbox_state'] ) && $options['lightbox_state'] == 'enabled' ) : ?>
						<a href="<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); echo $thumb[0]; ?>" class="dslc-lightbox-image">
					<?php endif; ?>
						<?php if ( $manual_resize ) : ?>
							<img src="<?php $res_img = dslc_aq_resize( $thumb_url, $resize_width, $resize_height, true ); echo $res_img; ?>" alt="<?php echo dslc_get_attachment_alt( get_post_thumbnail_id() ); ?>" />
						<?php else : ?>
							<?php the_post_thumbnail( 'full' ); ?>
						<?php endif; ?>
					<?php if ( isset( $options['lightbox_state'] ) && $options['lightbox_state'] == 'enabled' ) : ?>
						</a>
					<?php endif; ?>
				</div><?php
			endif;

		/* Module output ends here. */

		$this->module_end( $options );

	}
}
