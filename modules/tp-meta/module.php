<?php

class DSLC_TP_Meta extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_TP_Meta';
		$this->module_title = 'Meta';
		$this->module_icon = 'info';
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
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Elements', 'live-composer-page-builder' ),
				'id' => 'tp_elements',
				'std' => 'date avatar author category tags comments',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Date', 'live-composer-page-builder' ),
						'value' => 'date'
					),
					array(
						'label' => __( 'Avatar', 'live-composer-page-builder' ),
						'value' => 'avatar'
					),
					array(
						'label' => __( 'Author', 'live-composer-page-builder' ),
						'value' => 'author'
					),
					array(
						'label' => __( 'Category', 'live-composer-page-builder' ),
						'value' => 'category'
					),
					array(
						'label' => __( 'Tags', 'live-composer-page-builder' ),
						'value' => 'tags'
					),
					array(
						'label' => __( 'Comments', 'live-composer-page-builder' ),
						'value' => 'comments'
					),
				),
				'section' => 'styling'
			),
			array(
				'label' => __( 'Format', 'live-composer-page-builder' ),
				'id' => 'format',
				'std' => 'horizontal',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Horizontal', 'live-composer-page-builder' ),
						'value' => 'horizontal'
					),
					array(
						'label' => __( 'Vertical', 'live-composer-page-builder' ),
						'value' => 'vertical'
					),
				),
				'section' => 'styling',
			),
			array(
				'label' => __( 'Spacing', 'live-composer-page-builder' ),
				'id' => 'margin',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li',
				'affect_on_change_rule' => 'margin',
				'section' => 'styling',
				'ext' => 'px'
			),

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_main_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_main_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_main_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
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
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius - Top', 'live-composer-page-builder' ),
				'id' => 'css_main_border_radius_top',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
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
				'affect_on_change_el' => '.dslc-tp-meta',
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
				'affect_on_change_el' => '.dslc-tp-meta',
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
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 1000,
				'increment' => 5
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_main_padding_vertical',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_main_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),

			/**
			 * Avatar
			 */

			array(
				'label' => __( 'Avatar - Border Radius', 'live-composer-page-builder' ),
				'id' => 'css_meta_avatar_border_radius',
				'std' => '100',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta-avatar img',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Avatar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Avatar - Margin Right', 'live-composer-page-builder' ),
				'id' => 'css_meta_avatar_margin_right',
				'std' => '10',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta-avatar',
				'affect_on_change_rule' => 'margin-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Avatar', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Avatar - Size', 'live-composer-page-builder' ),
				'id' => 'css_meta_avatar_size',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta-avatar',
				'affect_on_change_rule' => 'width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Avatar', 'live-composer-page-builder' ),
			),

			/**
			 * Typography
			 */

			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'color',
				'std' => '#4d4d4d',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Color - Hover', 'live-composer-page-builder' ),
				'id' => 'color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li, li a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_font_weight',
				'std' => '400',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li, li a',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'ext' => '',
				'min' => 100,
				'max' => 900,
				'increment' => 100
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li, li a',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_line_height',
				'std' => '30',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li, li a',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Text Shadow', 'live-composer-page-builder' ),
				'id' => 'css_text_shadow',
				'std' => '',
				'type' => 'text_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li',
				'affect_on_change_rule' => 'text-shadow',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Link - Color', 'live-composer-page-builder' ),
				'id' => 'link_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li a',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Link - Color - Hover', 'live-composer-page-builder' ),
				'id' => 'link_color_hover',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li a:hover',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Link - Text Shadow', 'live-composer-page-builder' ),
				'id' => 'css_link_text_shadow',
				'std' => '',
				'type' => 'text_shadow',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li a',
				'affect_on_change_rule' => 'text-shadow',
				'section' => 'styling',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
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
				'id' => 'css_res_t_main_padding_vertical',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_main_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li, li a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px'
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
				'id' => 'css_res_p_main_padding_vertical',
				'std' => '5',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_main_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-tp-meta',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_font_size',
				'std' => '13',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => 'li, li a',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array('hover_opts' => false) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active;

		$post_id = $options['post_id'];
		$show_fake = true;

		if ( is_singular() ) {
			$post_id = get_the_ID();
			$show_fake = false;
		}

		if ( get_post_type( $post_id ) == 'dslc_templates' ) {
			$show_fake = true;
		}

		$this->module_start( $options );

		/* Module output starts here */

		$the_post = get_post( $post_id );

		$num_comments = get_comments_number( $post_id );
		$comments_output = '';

		if ( comments_open( $post_id ) ) {

			if ( $num_comments == 0 )
				$comments = __( 'No Comments' );
			elseif ( $num_comments > 1 )
				$comments = $num_comments . __( ' Comments' );
			else
				$comments = __( '1 Comment' );

			$comments_output = '<a href="#dslc-comments">' . $comments . '</a>';

		}

		$tp_elements = $options['tp_elements'];
		if ( ! empty( $tp_elements ) )
			$tp_elements = explode( ' ', trim( $tp_elements ) );
		else
			$tp_elements = 'all';

		if ( ! $show_fake ) {
			$post_type_taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
		}

			?>

				<div class="dslc-tp-meta dslc-tp-meta-<?php echo $options['format']; ?>">
					<ul class="dslc-clearfix">

						<?php if ( in_array( 'date', $tp_elements ) ) : ?>
							<li><?php echo get_the_time( get_option( 'date_format' ), $post_id ); ?></li>
						<?php endif; ?>

						<?php if ( in_array( 'author', $tp_elements ) ) : ?>
							<?php if ( $show_fake ) : ?>
								<li>
									<?php if ( in_array( 'avatar', $tp_elements ) ) : ?>
										<span class="dslc-tp-meta-avatar">
											<img src="<?php echo DS_LIVE_COMPOSER_URL; ?>/images/placeholders/small-placeholder.png" />
										</span>
									<?php endif; ?>
									<a href="#"><?php _e( 'John Doe', 'live-composer-page-builder' ); ?></a>
								</li>
							<?php else : ?>
								<li>
									<?php if ( in_array( 'avatar', $tp_elements ) ) : ?>
										<span class="dslc-tp-meta-avatar">
											<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
										</span>
									<?php endif; ?>
									<a href="<?php echo get_author_posts_url( $the_post->post_author ); ?>"><?php the_author_meta( 'display_name' ); ?></a>
								</li>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ( in_array( 'category', $tp_elements ) ) : ?>
							<?php if ( $show_fake ) : ?>
								<li><a href="#"><?php _e( 'Category One', 'live-composer-page-builder' ); ?></a>, <a href="#"><?php _e( 'Category Two', 'live-composer-page-builder' ); ?></a></li>
							<?php else : ?>
								<?php
									foreach ( $post_type_taxonomies as $taxonomy ) {
										if ( $taxonomy->hierarchical == true ) {

											$cats = get_the_terms( get_the_ID(), $taxonomy->name );
											$cats_count = 0;
											if ( $cats ) {
												echo '<li>';
													foreach ( $cats as $cat ) {
														$cats_count++;
														if ( $cats_count > 1 ) {
															echo ', ';
														}
														echo '<a href="' . get_term_link( $cat, $taxonomy->name ) . '">' . $cat->name . '</a>';
													}
												echo '</li>';
											}
										}
									}
								?>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ( in_array( 'tags', $tp_elements ) ) : ?>
							<?php if ( $show_fake ) : ?>
								<li><a href="#"><?php _e( 'One', 'live-composer-page-builder' ); ?></a>, <a href="#"><?php _e( 'Two', 'live-composer-page-builder' ); ?></a>, <a href="#"><?php _e( 'Three', 'live-composer-page-builder' ); ?></a></li>
							<?php else : ?>
								<?php
									foreach ( $post_type_taxonomies as $taxonomy ) {
										if ( $taxonomy->hierarchical == false ) {

											$cats = get_the_terms( get_the_ID(), $taxonomy->name );
											$tags_count = 0;
											if ( $cats ) {
												echo '<li>';
													foreach ( $cats as $cat ) {
														$tags_count++;
														if ( $tags_count > 1 ) {
															echo ', ';
														}
														echo '<a href="' . get_term_link( $cat, $taxonomy->name ) . '">' . $cat->name . '</a>';
													}
												echo '</li>';
											}
										}
									}
								?>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ( in_array( 'comments', $tp_elements ) && ( $comments_output != '' || $show_fake ) ) : ?>
							<?php if ( $show_fake ) : ?>
								<li><?php _e( '10 Comments', 'live-composer-page-builder' ); ?></li>
							<?php else : ?>
								<li><?php echo $comments_output; ?></li>
							<?php endif; ?>
						<?php endif; ?>

					</ul>
				</div>

			<?php

		/* Module output ends here */

		$this->module_end( $options );

	}

}