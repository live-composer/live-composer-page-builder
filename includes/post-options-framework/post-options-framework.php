<?php
/**
 * Table of Contents
 *
 * - dslc_setup_metaboxes ( Sets up the post options )
 * - dslc_add_metaboxes ( Adds metaboxes )
 * - DSLC_EditorInterface_post_options ( Displays options )
 * - dslc_save_metaboxes ( Saves options to post )
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
 * LC_Post_Options
 *
 * @since 1.1.4
 */
class LC_Post_Options {

	/**
	 * Holds all post options values.
	 *
	 * @var array
	 * @access private
	 * @since 1.1.4
	 */
	// private $post_options;

	/**
	 * Holds all plugin options structure.
	 *
	 * @var array
	 * @access private
	 * @since 1.1.4
	 */
	private $post_options_structure = array();

	/**
	 * Setup the class.
	 */
	public function __construct() {
/*
		// Fill the options attribute from DB.
		$this->plugin_options = get_option( 'dslc_plugin_options' );

		add_action( 'admin_menu', array( $this, 'create_plugin_options_page' ) );
		add_action( 'admin_init', array( $this, 'register_option_panels' ) );

		// Allow extension developers to add their own setting pages.
		add_action( 'init', array( $this, 'filter_options' ) );

		// Additional processing on options saving.
		add_action( 'update_option', array( $this, 'on_options_update' ), 10, 4 );
*/

		// Setup post options.
		add_action( 'load-post-new.php', array( $this, 'setup_metaboxes' ) );
		add_action( 'load-post.php', array( $this, 'setup_metaboxes' ) );

		// Create a tab 'Page Builder' on post editing screen.
		add_filter( 'the_editor', array( $this, 'post_editing_tab' ) );

		// Add button 'Open in Live Composer' in the submitbox.
		add_action( 'post_submitbox_start', array( $this, 'submitbox_add_button' ) );

		// Add button 'Open in Live Composer' next to permalink field.
		add_filter( 'get_sample_permalink_html', array( $this, 'permalinkbox_add_button' ), 10, 4 );

		// Create 'LC Templates' metabox if LC templates used for the current post type.
		add_action( 'init', array( $this, 'metabox_cpt_templates' ), 50 );

		// Allow extension developers to add their own metaboxes.
		add_action( 'init', array( $this, 'filter_metaboxes' ), 30 );
	}

	/**
	 * Return plugin options if called directly.
	 *
	 * @return array Plugin options.
	 */
	public function init() {
/*
		return $this->plugin_options;
*/
	}

	/**
	 * Setup post options
	 *
	 * @since  1.1.4
	 * @return void
	 */
	public function setup_metaboxes() {

		/* Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ) );

		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', array( $this, 'save_metaboxes' ), 10, 2 );
	}

	/**
	 * Allow extension developers to add their own setting pages.
	 *
	 * @return void
	 */
	public function filter_metaboxes() {
		// Allow developers to add their own metaboxes via our plugin framework.
		// Use it only if you create CPT for your modules or LC extensions.
		$this->post_options_structure = apply_filters( 'dslc_filter_metaboxes', $this->post_options_structure );
	}

	/**
	 * Add post options (add metaboxes)
	 */
	public function add_metaboxes() {

		$dslc_var_post_options = $this->post_options_structure;

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
							array( $this, 'display_metabox' ),
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
						array( $this, 'display_metabox' ),
						$dslc_post_option['show_on'],
						$dslc_post_option['context'],
						'high'
					);
				}
			}
		}
	}

	/**
	 * Save post options
	 *
	 * @since 1.0
	 */
	public function save_metaboxes( $post_id, $post ) {

		$dslc_var_post_options = $this->post_options_structure;

		if ( isset( $_POST['dslc_post_options'] ) ) {

			$post_options_ids = $_POST['dslc_post_options'];

			foreach ( $post_options_ids as $post_options_id ) {

				$post_options = $dslc_var_post_options[ $post_options_id ];

				foreach ( $post_options['options'] as $post_option ) {

					// Get option info.
					$meta_key = $post_option['id'];
					$new_option_value = ( isset( $_POST[ $post_option['id'] ] ) ? $_POST[ $post_option['id'] ] : '' );
					$curr_option_value = get_post_meta( $post_id, $meta_key, true );

					// Serialize array. (Deleted as WP serialize arrays on it's own)
					// if ( is_array( $new_option_value ) ) {
					// 	$new_option_value = serialize( $new_option_value );
					// }

					// Save, Update, Delete option.
					// DON'T CHANGE IT TO udpate_post_meta!
					// We don't want to struggle with serialized arrays.
					if ( isset( $new_option_value ) ) {
						delete_post_meta( $post_id, $meta_key );
						if ( is_array( $new_option_value ) ) {
							foreach ( $new_option_value as $value ) {
								add_post_meta( $post_id, $meta_key, $value );
							}
						} else {
							add_post_meta( $post_id, $meta_key, $new_option_value );
						}
					} elseif ( '' === $new_option_value && isset( $curr_option_value ) ) {

						delete_post_meta( $post_id, $meta_key, $curr_option_value );
					}
				}
			}
		}
	}

	/**
	 * Display post options
	 *
	 * @since 1.0
	 */
	public function display_metabox( $object, $metabox ) {

		$dslc_var_post_options = $this->post_options_structure;

		$post_options_id = $metabox['id'];
		$post_options = $dslc_var_post_options[ $post_options_id ]['options'];

		?>
		<div class="dslca-post-options">

			<?php foreach ( $post_options as $post_option ) : ?>

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

					<div class="dslca-post-option-field dslca-post-option-field-<?php echo esc_attr( $post_option['type'] ); ?>">

						<?php $this->display_metabox_field( $post_option, $object ); ?>

					</div><!-- .dslca-post-option-field -->

				</div><!-- .dslca-post-options -->

			<?php endforeach; ?>

			<input type="hidden" name="dslc_post_options[]" value="<?php echo $post_options_id; ?>" />

		</div><!-- .dslca-post-options -->

		<?php

	}

	/**
	 * Display field in the metabox
	 *
	 * @since 1.1.4
	 * @param   string $field_type  Type of the field to display.
	 * @return  void                Prints directly.
	 */
	public function display_metabox_field( $post_option, $object ) {

		$field_type = $post_option['type'];
		$option_id = $post_option['id'];

		// Get current value as array.
		$curr_value_no_esc = get_post_meta( $object->ID, $option_id );

		// If there is only one value in array – transform it into the string.
		if ( 1 === count( $curr_value_no_esc ) && is_string( $curr_value_no_esc[0] ) ) {
			$curr_value = esc_attr( $curr_value_no_esc[0] );
		}

		if ( empty( $curr_value_no_esc ) ) {
			// $curr_value_no_esc[] = $post_option['std'];
			$curr_value  = esc_attr( $post_option['std'] );
		}

		?>

		<?php if ( 'text' === $field_type ) : ?>

			<input type="text" name="<?php echo esc_attr( $option_id ); ?>" id="<?php echo esc_attr( $option_id ); ?>" value="<?php echo $curr_value; ?>" size="30" />

		<?php elseif ( 'textarea' === $field_type ) : ?>

			<textarea name="<?php echo esc_attr( $option_id ); ?>" id="<?php echo esc_attr( $option_id ); ?>"><?php echo $curr_value; ?></textarea>

		<?php elseif ( 'select' === $field_type ) : ?>

			<select type="text" name="<?php echo esc_attr( $option_id ); ?>" id="<?php echo esc_attr( $option_id ); ?>">
				<?php foreach ( $post_option['choices'] as $choice ) : ?>
					<option value="<?php echo $choice['value']; ?>" <?php if ( $curr_value == $choice['value'] ) echo 'selected="selected"'; ?>><?php echo $choice['label']; ?></option>
				<?php endforeach; ?>
			</select>

			<?php

			global $current_screen;

			if ( 'add' !== $current_screen->action && 'dslc_templates' !== $object->post_type && 'dslc_hf' !== $object->post_type && 'dslc_header' !== $option_id && 'dslc_footer' !== $option_id ) {
				echo '<a class="button" href="' . admin_url( 'edit.php?post_type=dslc_templates' ) . '">' . __( 'Edit Templates', 'live-composer-page-builder' ) . '</a>';
			}

			?>

		<?php elseif ( 'checkbox' === $field_type ) : ?>

			<div class="dslca-post-option-field-inner-wrapper">

				<?php
				$curr_value_array = maybe_unserialize( $curr_value_no_esc );
				if ( ! is_array( $curr_value_array ) ) {
					$curr_value_array = array();
				}

				if ( isset( $curr_value ) && '' !== $curr_value && empty( $curr_value_array ) ) {
					$curr_value_array = explode( ' ', $curr_value );
				}

				?>
				<?php foreach ( $post_option['choices'] as $key => $choice ) : ?>

					<?php if ( 'list-heading' !== esc_attr( $choice['value'] ) ): ?>

						<div class="dslca-post-option-field-choice">
							<input type="checkbox" name="<?php echo esc_attr( $option_id ); ?>[]" id="<?php echo esc_attr( $option_id . $key ); ?>" value="<?php echo esc_attr( $choice['value'] ); ?>" <?php if ( in_array(  esc_attr( $choice['value'] ),  $curr_value_array ) ) echo 'checked="checked"'; ?> /> <label for="<?php echo  esc_attr( $option_id . $key ); ?>"><?php echo  esc_html( $choice['label'] ); ?></label>
						</div><!-- .dslca-post-option-field-choice -->

					<?php else: ?>

						<?php if ( 0 !== $key ) : ?>
							</div>
							<div class="dslca-post-option-field-inner-wrapper">
						<?php endif;?>

							<p>
							<strong><?php echo  esc_html( $choice['label'] ); ?></strong>
							</p>
							<?php
							if ( isset( $choice['description'] ) ) {
								echo  '<p class="control-description">' . esc_html( $choice['description'] ) . '</p>';
							}
							?>


					<?php endif; ?>
				<?php endforeach; ?>

			</div>

		<?php elseif ( 'radio' === $field_type ) : ?>

			<?php foreach ( $post_option['choices'] as $key => $choice ) : ?>
				<div class="dslca-post-option-field-choice">
					<input type="radio" name="<?php echo esc_attr( $option_id ); ?>" id="<?php echo esc_attr( $option_id . $key ); ?>" value="<?php echo esc_attr( $choice['value'] ); ?>" <?php if ( $choice['value'] === $curr_value ) { echo 'checked="checked"'; } ?> /> 
					<label for="<?php echo esc_attr( $option_id . $key ); ?>">
						<?php echo $choice['label']; ?>
					</label>
				</div><!-- .dslca-post-option-field-choice -->
			<?php endforeach; ?>

		<?php elseif ( 'file' === $field_type ) : ?>

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

			<input type="hidden" class="dslca-post-options-field-file" name="<?php echo $option_id; ?>" id="<?php echo $option_id; ?>" value="<?php echo $curr_value; ?>" />

		<?php elseif ( 'files' === $field_type ) : ?>

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

			<input type="hidden" class="dslca-post-options-field-file" name="<?php echo $option_id; ?>" id="<?php echo $option_id; ?>" value="<?php echo $curr_value; ?>" />

		<?php elseif ( 'date' === $field_type ) : ?>

			<input class="dslca-post-options-field-datepicker" type="text" name="<?php echo $option_id; ?>" id="<?php echo $option_id; ?>" value="<?php echo $curr_value; ?>" size="30" />

		<?php endif;

	}

	/**
	 * Create a tab 'Page Builder' on post editing screen.
	 */
	public function post_editing_tab( $content ) {

		if ( get_post_type( get_the_ID() ) == 'page' && is_admin() ) {

			$url = DSLC_EditorInterface::get_editor_link_url( get_the_ID() );
			?>
			<div id="lc_content_wrap">
					<h2> <?php _e( 'Edit this page in Live Composer', 'live-composer-page-builder' ); ?></h2>
					<div class="description"><?php _e( 'Page builder stores content in a compressed way <br>(better for speed, security and user experience)', 'live-composer-page-builder' ); ?></div>
					<p><a class="button button-primary button-hero" target="_blank" href="<?php echo $url; ?>"><?php echo __( 'Open in Live Composer', 'live-composer-page-builder' ); ?></a></p>
			</div>
		<?php }

		return $content;
	}

	/**
	 * Add button 'Open in Live Composer' in the submitbox.
	 */
	public function submitbox_add_button() {

		global $post, $current_screen;

		$lc = Live_Composer();
		$dslc_var_templates_pt = $lc->cpt_templates->get_posttypes_with_templates( true );

		$current_post_type = $post->post_type;
		$dslc_admin_interface_on = apply_filters( 'dslc_admin_interface_on_submitdiv', $current_post_type );


		if ( true === $dslc_admin_interface_on && $current_screen->action != 'add' && ! array_key_exists( $current_post_type, $dslc_var_templates_pt ) && $current_post_type != 'dslc_testimonials' ) {

			$url = DSLC_EditorInterface::get_editor_link_url( get_the_ID() );

			echo '<a class="button button-hero" target="_blank" href="' . $url . '">' . __( 'Open in Live Composer', 'live-composer-page-builder' ) . '</a>';
		}

	}

	/**
	 * Add button 'Open in Live Composer' next to permalink field.
	 *
	 * @return  string
	 */
	public function permalinkbox_add_button( $return, $id, $new_title, $new_slug ) {

		// global $dslc_var_templates_pt;
		$lc = Live_Composer();
		$dslc_var_templates_pt = $lc->cpt_templates->get_posttypes_with_templates( true );


		$current_post_type = get_post_type( $id );
		$dslc_admin_interface_on = apply_filters( 'dslc_admin_interface_on_slug_box', true );

		if ( true === $dslc_admin_interface_on &&
			 ! array_key_exists( $current_post_type, $dslc_var_templates_pt ) &&
			 $current_post_type != 'dslc_testimonials' ) {

			$url = DSLC_EditorInterface::get_editor_link_url( $id );

			$return .= '<a class="button button-small" target="_blank" href="' . $url . '">' . __( 'Open in Live Composer', 'live-composer-page-builder' ) . '</a>';
		}

		return $return;
	}

	/**
	 * Create 'LC Templates' metabox if LC templates used for the current post type.
	 *
	 * @return void
	 */
	public function metabox_cpt_templates() {

		$templates_array = array();

		$dslc_var_post_options = $this->post_options_structure;

		$args = array(
			'post_type' => 'dslc_templates',
			'post_status' => 'publish',
			'posts_per_page' => 99, // changed from -1 for better performance
			'order' => 'DESC',
		);

		$templates = get_posts( $args );

		// global $dslc_var_templates_pt;
		$lc = Live_Composer();
		$dslc_var_templates_pt = $lc->cpt_templates->get_posttypes_with_templates( true );

		foreach ( $dslc_var_templates_pt as $pt_id => $pt_label ) {

			$templates_array[ $pt_id ][] = array(
				'label' => __( 'Default', 'live-composer-page-builder' ),
				'value' => 'default',
			);
		}

		if ( $templates ) {

			foreach ( $templates as $template ) {
				// Get array with CPT names this template assigned for.
				$template_for = get_post_meta( $template->ID, 'dslc_template_for' );

				if ( ! empty( $template_for ) ) {

					foreach ( $template_for as $template_cpt ) {
						// Go through each CPT to fill templates_array array.
						if ( is_string( $template_cpt ) ) {
							$templates_array[ $template_cpt ][] = array(
								'label' => $template->post_title,
								'value' => $template->ID,
							);
						}
					}
				}
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

}

