<?php
/**
 * LC editor interface class
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * DSLC_EditorInterface class
 */
class DSLC_EditorInterface {

	/**
	 * Init all hooks
	 */
	static function init() {

		add_action( 'wp_footer', array( __CLASS__, 'show_lc_button_on_front' ) );
	}

	/**
	 * Returns editor link URL
	 *
	 * @return string
	 */
	static function get_editor_link_url( $page_id, $preview_id = '' ) {

		$additional_vars = '';
		$additional_vars = apply_filters( 'lc_edit_url_vars', $additional_vars, $page_id );

		if ( '' !== $preview_id ) {

			$additional_vars .= '&preview_id=' . $preview_id;
		}

		return admin_url( 'admin.php?page=livecomposer_editor&page_id=' . $page_id . $additional_vars );
	}

	/**
	 * Print prepared editor link
	 *
	 * @return void
	 */
	static function the_editor_link( $link_url, $link_text ) {

		// Get the position of the activation button.
		$activate_button_position = dslc_get_option( 'lc_module_activate_button_pos', 'dslc_plugin_options_other' );

		if ( empty( $activate_button_position ) ) {

			$activate_button_position = 'right';
		}

		?>
		<a href="<?php echo esc_url( $link_url ); ?>" class="dslca-position-<?php echo esc_attr( $activate_button_position ); ?> dslca-activate-composer-hook">
			<?php echo esc_html( $link_text ); ?>
		</a>
		<?php
	}

	static function the_edit_singular_link() {

		$string_open_lc    = __( 'Edit in Live Composer', 'live-composer-page-builder' );
		$string_create_tpl = __( 'Create Template', 'live-composer-page-builder' );
		$string_edit_tpl   = __( 'Edit Template', 'live-composer-page-builder' );
		$preview_id        = '';

		// If on a LC template post preview.
		if ( 'dslc_templates' === get_post_type() ) {

			self::the_editor_link( self::get_editor_link_url( get_the_ID() ), $string_edit_tpl );

			// If a page or CPT like page – go ahead normally.
		} elseif ( is_page() || ! dslc_cpt_use_templates( get_post_type() ) ) {

			self::the_editor_link( self::get_editor_link_url( get_the_ID() ), $string_open_lc );

			// If a post of the CPT managed by LC templates.
		} elseif ( dslc_can_edit_in_lc( get_post_type() ) ) {

			// Check if it has a template attached to it.
			$template = dslc_st_get_template_id( get_the_ID() );

			if ( $template ) {

				// Output the button.
				self::the_editor_link( self::get_editor_link_url( $template, get_the_ID() ), $string_edit_tpl );

			} else {

				// Output the button.
				self::the_editor_link( admin_url( 'post-new.php?post_type=dslc_templates&for=' . get_post_type() ), $string_create_tpl );

			}
		}
	}

	static function the_edit_template_link( $page_data, $with_preivew_id = false ) {

		$string_edit_tpl   = __( 'Edit Template', 'live-composer-page-builder' );
		$string_create_tpl = __( 'Create Template', 'live-composer-page-builder' );
		$preview_id        = '';

		/**
		 * Prepare 'preview_id' to be included in URL variables.
		 * Preview id is needed for modules that rely on post ID.
		 */
		if ( $with_preivew_id ) {
			$preview_id = get_queried_object_id();
		}

		if ( is_int( $page_data ) ) {
			/**
			 * Page ID provided with method call.
			 *
			 * We need to find a proper template that powers post with this ID,
			 * or propose to create a template if nothing found.
			 */

			$post_id = $page_data;
			$page_data = get_post_type(); // Needed for new template creation request.

			// Check if it has a template attached to it.
			$template_id = dslc_st_get_template_id( $post_id );

		} else {
			/**
			 * Post type provided with method call.
			 *
			 * We need to find a proper template that powers post with this type,
			 * or propose to create a template if nothing found.
			 */

			// Get ID of the template that powering current page/post.
			$template_id = dslc_get_archive_template_by_pt( $page_data );

		}

		// If there is a page that powers it.
		if ( $template_id ) {

			// Output 'Edit Template' button.
			self::the_editor_link( self::get_editor_link_url( $template_id, $preview_id ), $string_edit_tpl );

		} else {

			// Output 'Create Template' button.
			self::the_editor_link( admin_url( 'post-new.php?post_type=dslc_templates&for=' . $page_data ), $string_create_tpl );

		}
	}

	/**
	 * Shows button on front
	 *
	 * @echoes string{HTML}
	 */
	static function show_lc_button_on_front() {

		// Get the position of the activation button.
		$activate_button_position = dslc_get_option( 'lc_module_activate_button_pos', 'dslc_plugin_options_other' );

		if ( empty( $activate_button_position ) ) {

			$activate_button_position = 'right';
		}

		// LC and WP Customizer do not work well together, don't proceed if customizer active.
		if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) {
			return;
		}

		// If editor not active and user can access the editor.
		if ( DS_LIVE_COMPOSER_ACTIVE || ! is_user_logged_in() || ! current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
			return;
		}

		// Hide LC button on front.
		if ( ! dslc_can_edit_in_lc( get_post_type() ) ) {
			return;
		}

		/**
		 * Is current post type using LC templates system?
		 */
		$use_lc_templates = true;

		if ( dslc_can_edit_in_lc( get_post_type() ) &&
				! dslc_cpt_use_templates( get_post_type() ) ) {

			$use_lc_templates = false;
		}

		/**
		 * Is current post is LC template?
		 */
		$is_lc_template = false;

		if ( 'dslc_templates' === get_post_type() ) {
			$is_lc_template = true;
		}

		if ( is_singular() && ! $use_lc_templates || $is_lc_template ) {
			// If a singular page ( posts and pages ) and NOT using LC templates.
			self::the_edit_singular_link();

		} elseif ( is_singular() && $use_lc_templates ) {
			// If a singular page ( posts and pages ) and IS using LC templates.
			self::the_edit_template_link( get_the_ID(), true );

		} elseif ( is_404() ) {
			// If it's a 404 page.
			self::the_edit_template_link( '404_page' );

		} elseif ( is_author() ) {
			// If authors archives page?
			self::the_edit_template_link( 'author' );

		} elseif ( is_archive() && dslc_can_edit_in_lc( get_post_type() ) ) {
			// If other archives ( not author )?
			// $count = $GLOBALS['wp_query']->post_count;
			/**
			 * Function get_post_type() returns type of the posts
			 * in the current listing. We use it to decide what template to load.
			 */
			$listing_pt_slug = get_post_type();
			self::the_edit_template_link( $listing_pt_slug, true );

			// If a search results page (keep this check last!!).
		} elseif ( is_search() ) {

			self::the_edit_template_link( 'search_results' );
		}

		if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) :

			?><div class="dslca-container dslca-state-off" data-post-id="<?php the_ID(); ?>"></div><?php
		endif;
	}
}

DSLC_EditorInterface::init();
