<?php
/**
 * Table of Contents
 *
 * - dslc_setup_post_options ( Sets up the post options )
 * - dslc_add_post_options ( Adds metaboxes )
 * - DSLC_EditorInterface_post_options ( Displays options )
 * - dslc_save_post_options ( Saves options to post )
 * - dslc_page_add_row_action ( Adds action in row )
 * - dslc_post_add_row_action ( Adds action in row )
 * - dslc_add_button_permalink ( Adds button in permalink )
 * - dslc_post_submitbox_add_button ( Adds button in submitbox )
 *
 * @package LiveComposer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Get array of custom post types that use LC templating system
 *
 * @return void
 */
function dslc_get_cpt_templates() {

	$templates_array = array();
	global $dslc_var_post_options;

	$args = array(
		'post_type' => 'dslc_templates',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'order' => 'DESC',
	);

	$templates = get_posts( $args );

	global $dslc_var_templates_pt;

	foreach ( $dslc_var_templates_pt as $pt_id => $pt_label ) {

		$templates_array[ $pt_id ][] = array(
			'label' => __( 'Default', 'live-composer-page-builder' ),
			'value' => 'default',
		);
	}

	if ( $templates ) {

		foreach ( $templates as $template ) {
			$template_for = get_post_meta( $template->ID, 'dslc_template_for', true );
			$templates_array[ $template_for ][] = array(
				'label' => $template->post_title,
				'value' => $template->ID,
			);
		}

		foreach ( $dslc_var_templates_pt as $pt_id => $pt_label ) {

			$mb_id = 'dslc-' . $pt_id . '-tpl-options';

			$dslc_var_post_options[$mb_id] = array(
				'title' => __( 'LC Template', 'live-composer-page-builder' ),
				'show_on' => $pt_id,
				'context' => 'side',
				'options' => array(
					array(
						'label' => __( 'Template', 'live-composer-page-builder' ),
						'std' => '',
						'id' => 'dslc_post_template',
						'type' => 'select',
						'choices' => $templates_array[ $pt_id ],
					),
				),
			);
		}
	}
}

add_action( 'init', 'dslc_get_cpt_templates', 50 );

/**
 * Setup post options
 *
 * @since 1.0
 */
function dslc_setup_post_options() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'dslc_add_post_options' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'dslc_save_post_options', 10, 2 );

}
add_action( 'load-post-new.php', 'dslc_setup_post_options' );
add_action( 'load-post.php', 'dslc_setup_post_options' );

/**
 * Add post options (add metaboxes)
 */
function dslc_add_post_options() {

	global $dslc_var_post_options;

	// If there are post options.
	if ( ! empty( $dslc_var_post_options ) ) {

		// Loop through all post options.
		foreach ( $dslc_var_post_options as $dslc_post_option_key => $dslc_post_option ) {

			if ( ! isset( $dslc_post_option['context'] ) ) {

				$dslc_post_option['context'] = 'normal';
			}

			// If post options shown on multiple post types.
			if ( is_array( $dslc_post_option['show_on'] ) ) {

				// Loop through all post types.
				foreach ( $dslc_post_option['show_on'] as $dslc_post_option_show_on ) {

					// Add meta box for post type.
					add_meta_box(
						$dslc_post_option_key,
						$dslc_post_option['title'],
						'DSLC_EditorInterface_post_options',
						$dslc_post_option_show_on,
						$dslc_post_option['context'],
						'high'
					);
				}
			// If post options shown on single post type.
			} else {

				// Add meta box to post type.
				add_meta_box(
					$dslc_post_option_key,
					$dslc_post_option['title'],
					'DSLC_EditorInterface_post_options',
					$dslc_post_option['show_on'],
					$dslc_post_option['context'],
					'high'
				);
			}
		}
	}
}

/**
 * Display post options
 *
 * @since 1.0
 */
function DSLC_EditorInterface_post_options( $object, $metabox ) {

	global $dslc_var_post_options;

	$post_options_id = $metabox['id'];
	$post_options = $dslc_var_post_options[ $post_options_id ]['options'];

	?>

	<div class="dslca-post-options">

		<?php foreach ( $post_options as $post_option ) : ?>

			<?php
			$curr_value_no_esc = get_post_meta( $object->ID, $post_option['id'], true );

			if ( ! isset( $curr_value_no_esc ) || '' === $curr_value_no_esc ) {

				$curr_value_no_esc = $post_option['std'];
			}

			$curr_value = esc_attr( $curr_value_no_esc );
			?>

			<div class="dslca-post-option" id="post-option-<?php echo esc_attr( $post_option['id'] ); ?>" >

				<?php if ( isset( $post_option['label'] ) && '' !== $post_option['label'] ) : ?>

					<div class="dslca-post-option-label">
						<span><?php echo esc_html( $post_option['label'] ); ?></span>
					</div><!-- .dslca-post-option-label -->

				<?php endif; ?>

				<?php if ( isset( $post_option['descr'] ) && '' !== $post_option['descr'] ) : ?>

					<div class="dslca-post-option-description">
						<?php
						$allowed_html = array(
							'a' => array(),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						);
						echo wp_kses( $post_option['descr'], $allowed_html );
						?>
					</div><!-- .dslca-post-option-description -->

				<?php endif; ?>

				<div class="dslca-post-option-field dslca-post-option-field-<?php echo $post_option['type']; ?>">

					<?php if ( $post_option['type'] == 'text' ) : ?>

						<input type="text" name="<?php echo $post_option['id']; ?>" id="<?php echo $post_option['id']; ?>" value="<?php echo $curr_value; ?>" size="30" />

					<?php elseif ( $post_option['type'] == 'textarea' ) : ?>

						<textarea name="<?php echo $post_option['id']; ?>" id="<?php echo $post_option['id']; ?>"><?php echo $curr_value; ?></textarea>

					<?php elseif ( $post_option['type'] == 'select' ) : ?>

						<select type="text" name="<?php echo $post_option['id']; ?>" id="<?php echo $post_option['id']; ?>">
							<?php foreach ( $post_option['choices'] as $choice ) : ?>
								<option value="<?php echo $choice['value']; ?>" <?php if ( $curr_value == $choice['value'] ) echo 'selected="selected"'; ?>><?php echo $choice['label']; ?></option>
							<?php endforeach; ?>
						</select>

						<?php

						global $current_screen;

						if ( 'add' !== $current_screen->action && 'dslc_templates' !== $object->post_type && 'dslc_hf' !== $object->post_type && 'dslc_header' !== $post_option['id'] && 'dslc_footer' !== $post_option['id'] ) {
							echo '<a class="button" href="' . admin_url( 'edit.php?post_type=dslc_templates' ) . '">' . __( 'Edit Templates', 'live-composer-page-builder' ) . '</a>';
						}

						?>

					<?php elseif ( 'checkbox' === $post_option['type'] ) : ?>

						<?php
						$curr_value_array = maybe_unserialize( $curr_value_no_esc );
						if ( ! is_array( $curr_value_array ) ) {
							$curr_value_array = array();
						}

						if ( '' !== $curr_value && empty( $curr_value_array ) ) {
							$curr_value_array = explode( ' ', $curr_value );
						}
						?>
						<?php foreach ( $post_option['choices'] as $key => $choice ) : ?>
								<div class="dslca-post-option-field-choice">
									<input type="checkbox" name="<?php echo $post_option['id']; ?>[]" id="<?php echo $post_option['id'] . $key; ?>" value="<?php echo $choice['value']; ?>" <?php if ( in_array( $choice['value'], $curr_value_array ) ) echo 'checked="checked"'; ?> /> <label for="<?php echo $post_option['id'] . $key; ?>"><?php echo $choice['label']; ?></label>
								</div><!-- .dslca-post-option-field-choice -->
						<?php endforeach; ?>

					<?php elseif ( $post_option['type'] == 'radio' ) : ?>

						<?php foreach ( $post_option['choices'] as $key => $choice ) : ?>
							<div class="dslca-post-option-field-choice">
								<input type="radio" name="<?php echo $post_option['id']; ?>" id="<?php echo $post_option['id']; ?>" value="<?php echo $choice['value']; ?>" <?php if ( $choice['value'] == $curr_value ) echo 'checked="checked"'; ?> /> <label for="<?php echo $post_option['id'] . $key; ?>"><?php echo $choice['label']; ?></label>
							</div><!-- .dslca-post-option-field-choice -->
						<?php endforeach; ?>

					<?php elseif ( $post_option['type'] == 'file' ) : ?>

						<span class="dslca-post-option-add-file-hook">Choose File</span><br>

						<?php if ( $curr_value ) : ?>

							<div class="dslca-post-options-images dslca-clearfix">

								<div class="dslca-post-option-image">

									<div class="dslca-post-option-image-inner">

										<?php if ( wp_attachment_is_image( $curr_value ) ) : ?>

											<?php $image = wp_get_attachment_image_src( $curr_value, 'full' ); ?>
											<img src="<?php echo $image[0]; ?>" />

										<?php else : ?>

											<strong><?php echo basename( get_attached_file( $curr_value ) ); ?></strong>

										<?php endif; ?>

									</div><!-- .dslca-post-option-image-inner -->

									<span class="dslca-post-option-image-remove">x</span>

								</div><!-- .dslca-post-option-image -->

							</div><!-- .dslca-post-options-images -->
						<?php else: ?>
							<div class="dslca-post-options-images dslca-clearfix"></div>
						<?php endif; ?>

						<input type="hidden" class="dslca-post-options-field-file" name="<?php echo $post_option['id']; ?>" id="<?php echo $post_option['id']; ?>" value="<?php echo $curr_value; ?>" />

					<?php elseif ( $post_option['type'] == 'files' ) : ?>

						<span class="dslca-post-option-add-file-hook" data-multiple="true">Add Files</span><br>

						<?php if ( $curr_value ) : ?>
							<div class="dslca-post-options-images dslca-clearfix">
								<?php
									$images = explode( ' ', trim( $curr_value ) );
									foreach ( $images as $image_ID ) {
										$image = wp_get_attachment_image_src( $image_ID, 'full' );
										?>
										<div class="dslca-post-option-image" data-id="<?php echo $image_ID; ?>">
											<div class="dslca-post-option-image-inner">
												<img src="<?php echo $image[0]; ?>" />
												<span class="dslca-post-option-image-remove">x</span>
											</div>
										</div>
										<?php
									}
								?>
							</div><!-- .dslca-post-options-images -->
						<?php else : ?>
							<div class="dslca-post-options-images dslca-clearfix"></div>
						<?php endif; ?>

						<input type="hidden" class="dslca-post-options-field-file" name="<?php echo $post_option['id']; ?>" id="<?php echo $post_option['id']; ?>" value="<?php echo $curr_value; ?>" />

					<?php elseif ( $post_option['type'] == 'date' ) : ?>

						<input class="dslca-post-options-field-datepicker" type="text" name="<?php echo $post_option['id']; ?>" id="<?php echo $post_option['id']; ?>" value="<?php echo $curr_value; ?>" size="30" />

					<?php endif; ?>

				</div><!-- .dslca-post-option-field -->

			</div><!-- .dslca-post-options -->

		<?php endforeach; ?>

		<input type="hidden" name="dslc_post_options[]" value="<?php echo $post_options_id; ?>" />

	</div><!-- .dslca-post-options -->

	<?php

}

/**
 * Save post options
 *
 * @since 1.0
 */
function dslc_save_post_options( $post_id, $post ) {

	global $dslc_var_post_options;

	if ( isset( $_POST['dslc_post_options'] ) ) {

		$post_options_ids = $_POST['dslc_post_options'];

		foreach ( $post_options_ids as $post_options_id ) {

			$post_options = $dslc_var_post_options[ $post_options_id ];

			foreach ( $post_options['options'] as $post_option ) {

				// Get option info.
				$meta_key = $post_option['id'];
				$new_option_value = ( isset( $_POST[ $post_option['id'] ] ) ? $_POST[ $post_option['id'] ] : '' );
				$curr_option_value = get_post_meta( $post_id, $meta_key, true );

				if ( is_array( $new_option_value ) ) {
					$new_option_value = serialize( $new_option_value );
				}

				// Save, Update, Delete option.
				if ( isset( $new_option_value ) ) {

					update_post_meta( $post_id, $meta_key, $new_option_value );
				} elseif ( '' === $new_option_value && isset( $curr_option_value ) ) {

					delete_post_meta( $post_id, $meta_key, $curr_option_value );
				}
			}
		}
	}

}

/**
 * Adds action in row
 */
function dslc_page_add_row_action( $actions, $page_object ) {

	$screen = get_current_screen();
	$dslc_admin_interface_on = apply_filters( 'dslc_admin_interface_on', $screen->post_type );
	$page_status = $page_object->post_status;
	$id = $page_object->ID;

	if ( true === $dslc_admin_interface_on && $page_status != 'trash' ) {

		$url = DSLC_EditorInterface::get_editor_link( $id );

		$actions = array('edit-in-live-composer' => '<a href="' . $url . '">' . __( 'Edit in Live Composer', 'live-composer-page-builder' ) . '</a>') + $actions;
	}

	return $actions;
}
add_filter( 'page_row_actions', 'dslc_page_add_row_action', 10, 2 );

function dslc_post_add_row_action( $actions, $post ) {

	global $dslc_var_templates_pt;

	$post_status = $post->post_status;
	$post_type = $post->post_type;
	$dslc_admin_interface_on = apply_filters( 'dslc_admin_interface_on_listing', true );

	if ( true === $dslc_admin_interface_on && $post_status != 'trash' ) {

		if ( array_key_exists( $post_type, $dslc_var_templates_pt ) ) {

			$template_id = dslc_st_get_template_ID( $post->ID );
			$url = DSLC_EditorInterface::get_editor_link( $template_id, $post->ID );

			$actions = array('edit-in-live-composer' => '<a href="'. $url . '">'. __( 'Edit Template', 'live-composer-page-builder' ) .'</a>') + $actions;
		} else {

			$url = DSLC_EditorInterface::get_editor_link( $post->ID );

			$actions = array('edit-in-live-composer' => '<a href="'. $url . '">'. __( 'Edit in Live Composer', 'live-composer-page-builder' ) .'</a>') + $actions;
		}
	}

    return $actions;
}
add_filter( 'post_row_actions', 'dslc_post_add_row_action', 10, 2 );

/**
 * Adds button in permalink
 *
 * @return  string
 */
function dslc_add_button_permalink( $return, $id, $new_title, $new_slug ) {

	global $dslc_var_templates_pt;

	$current_post_type = get_post_type( $id );
	$dslc_admin_interface_on = apply_filters( 'dslc_admin_interface_on_slug_box', true );

	if ( true === $dslc_admin_interface_on &&
		 ! array_key_exists( $current_post_type, $dslc_var_templates_pt ) &&
		 $current_post_type != 'dslc_testimonials' ) {

		$url = DSLC_EditorInterface::get_editor_link( $id );

		$return .= '<a class="button button-small" target="_blank" href="' . $url . '">' . __( 'Open in Live Composer', 'live-composer-page-builder' ) . '</a>';
	}

	return $return;
}
add_filter( 'get_sample_permalink_html', 'dslc_add_button_permalink', 10, 4 );

/**
 * Adds button in submitbox
 */
function dslc_post_submitbox_add_button() {

	global $post, $current_screen, $dslc_var_templates_pt;
	$current_post_type = $post->post_type;
	$dslc_admin_interface_on = apply_filters( 'dslc_admin_interface_on_submitdiv', $current_post_type );


	if ( true === $dslc_admin_interface_on && $current_screen->action != 'add' && ! array_key_exists( $current_post_type, $dslc_var_templates_pt ) && $current_post_type != 'dslc_testimonials' ) {

		$url = DSLC_EditorInterface::get_editor_link( get_the_ID() );

		echo '<a class="button button-hero" target="_blank" href="' . $url . '">' . __( 'Open in Live Composer', 'live-composer-page-builder' ) . '</a>';
	}

}
add_action( 'post_submitbox_start', 'dslc_post_submitbox_add_button' );

/**
 * Creates a tab for pages and different post types
 */
function dslc_tab_content( $content ) {

	if ( get_post_type( get_the_ID() ) == 'page' && is_admin() ) {

		$url = DSLC_EditorInterface::get_editor_link( get_the_ID() );
		?>
		<div id="lc_content_wrap">
				<h2> <?php _e( 'Edit this page in Live Composer', 'live-composer-page-builder' ); ?></h2>
				<div class="description"><?php _e( 'Page builder stores content in a compressed way <br>(better for speed, security and user experience)', 'live-composer-page-builder' ); ?></div>
				<p><a class="button button-primary button-hero" target="_blank" href="<?php echo $url; ?>"><?php echo __( 'Open in Live Composer', 'live-composer-page-builder' ); ?></a></p>
		</div>
	<?php }

	return $content;
}
add_filter( 'the_editor', 'dslc_tab_content' );
