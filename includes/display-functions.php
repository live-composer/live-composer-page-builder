<?php
/**
 * Table of Contents
 *
 * - dslc_display_composer ( Displays the composer code in the front-end )
 * - dslc_get_modules ( Returns an array of active modules )
 * - dslc_display_modules ( Displays a list of active modules )
 * - dslc_display_templates ( Displays a list of active templates )
 * - dslc_filter_content ( Filters the_content() to show composer output )
 * - dslc_module_front ( Returns front-end output of a specific module )
 * – dslc_modules_section_front ( HTML output for the sections )
 * – dslc_module_front ( HTML output for the modules/elements )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Display the composer panels in active editing mode
 *
 * @since 1.0
 */
function dslc_display_composer() {

	global $dslc_active;

	$screen = get_current_screen();

	if ( ! is_object( $screen ) ) {
		return;
	}

	if ( $screen->id != 'toplevel_page_livecomposer_editor' ) {

		return;
	}

	// Reset the query ( because some devs leave their queries non-reseted ).
	wp_reset_query();

	// Show the composer to users who are allowed to view it.
	// $dslc_active &&
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) :

		$default_section = dslc_get_option( 'lc_default_opts_section', 'dslc_plugin_options_other' );

		if ( empty( $default_section ) ) {

			$default_section = 'functionality';
		}

		if ( isset( $_GET['preview_id'] ) ) {
			$url_id = intval( $_GET['preview_id'] );
		} else {
			$url_id = intval( $_GET['page_id'] );
		}

		if ( get_post_type( $url_id ) ) {
			$link = get_permalink( $url_id );
		} else {
			$link = get_term_link( $url_id ); // Is_tax when get_post_type empty
		}

		?>

			<div class="dslca-container dslca-state-off" data-post-id="<?php echo intval( $_GET['page_id'] ); ?>">

				<div class="dslca-header dslc-clearfix" data-default-section="<?php echo $default_section; ?>">

					<!-- Currently Editing -->
					<span class="dslca-currently-editing"><span class="dslca-icon dslc-icon-info"></span>You Are Editing: <strong></strong></span>

					<!-- Tabs -->
					<a href="#" class="dslca-go-to-section-hook dslca-go-to-section-modules dslca-active" data-section=".dslca-modules"><span class="dslca-icon dslc-icon-th-large"></span></a>
					<a href="#" class="dslca-go-to-section-hook dslca-go-to-section-templates" data-section=".dslca-templates"><span class="dslca-icon dslc-icon-cloud"></span></a>

					<!-- Module Option filters -->
					<span class="dslca-options-filter-hook" data-section="functionality"><span class="dslca-icon dslc-icon-cog"></span> <?php esc_attr_e( 'Functionality', 'live-composer-page-builder' ); ?></span>
					<span class="dslca-options-filter-hook" data-section="styling"><span class="dslca-icon dslc-icon-tint"></span> <?php esc_attr_e( 'Styling', 'live-composer-page-builder' ); ?></span>
					<span class="dslca-options-filter-hook" data-section="responsive"><span class="dslca-icon dslc-icon-mobile-phone"></span> <?php esc_attr_e( 'Responsive', 'live-composer-page-builder' ); ?></span>

					<!-- Module Options Actions -->
					<div class="dslca-module-edit-actions">
						<a href="#" class="dslca-module-edit-save" data-event="module-confirm"><?php esc_attr_e( 'Confirm', 'live-composer-page-builder' ); ?></a>
						<a href="#" class="dslca-module-edit-cancel" data-event="module-cancel"><?php esc_attr_e( 'Cancel', 'live-composer-page-builder' ); ?></a>
					</div><!-- .dslca-module-edit-actions -->

					<!-- Row Options Filters -->
					<?php /*
					<span class="dslca-row-options-filter-hook" data-section="styling"><span class="dslca-icon dslc-icon-tint"></span> <?php _e( 'STYLING', 'live-composer-page-builder' ); ?></span>
					<span class="dslca-row-options-filter-hook" data-section="responsive"><span class="dslca-icon dslc-icon-mobile-phone"></span> <?php _e( 'RESPONSIVE', 'live-composer-page-builder' ); ?></span>
					*/ ?>

					<!-- Row Options Actions -->
					<div class="dslca-row-edit-actions">
						<span class="dslca-row-edit-save"><?php _e( 'Confirm', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-row-edit-cancel"><?php _e( 'Cancel', 'live-composer-page-builder' ); ?></span>
					</div><!-- .dslca-row-edit-actions -->

					<a href="#" class="dslca-show-js-error-hook" ><span class="dslca-icon dslc-icon-bug"></span><?php esc_attr_e( 'Error Detected', 'live-composer-page-builder' ); ?></a>
				</div><!-- .dslca-header -->

				<div class="dslca-actions">

					<!-- Save Composer -->
					<a href="#" class="dslca-save-composer dslca-save-composer-hook">
						<span class="dslca-save-composer-helptext"><?php _e( 'Publish Changes', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-save-composer-icon"><span class="dslca-icon dslc-icon-ok"></span></span>
					</a><!-- .dslca-save-composer -->

					<a href="#" class="dslca-save-draft-composer dslca-save-draft-composer-hook">
						<span class="dslca-save-draft-composer-helptext"><?php _e( 'Save As Draft', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-save-draft-composer-icon"><span class="dslca-icon dslc-icon-save"></span></span>
					</a><!-- .dslca-save-draft-composer -->

					<!-- Hide/Show -->
					<a href="#" class="dslca-show-composer-hook"><span class="dslca-icon dslc-icon-arrow-up"></span><?php _e( 'Show', 'live-composer-page-builder' ); ?></a>
					<a href="#" class="dslca-hide-composer-hook"><span class="dslca-icon dslc-icon-arrow-down"></span><?php _e( 'Hide', 'live-composer-page-builder' ); ?></a>

					<!-- Disable -->
					<a href="<?php echo esc_attr( $link ); ?>" class="dslca-close-composer-hook"><span class="dslca-icon dslc-icon-remove"></span><?php _e( 'Close', 'live-composer-page-builder' ); ?></a>

					<div class="dslc-clear"></div>

				</div><!-- .dslca-actions -->

				<div class="dslca-sections">

					<!-- Modules Listing -->
					<div class="dslca-section dslca-modules" data-bg="#4A7AC3">

						<div class="dslca-section-title">
							<div class="dslca-section-title-filter">
								<span class="dslca-section-title-filter-curr"><?php _e( 'Elements', 'live-composer-page-builder' ); ?></span>
								<span class="dslca-icon dslc-icon-angle-up"></span>
								<div class="dslca-section-title-filter-options"></div>
							</div><!-- .dslca-section-title-filter -->
						</div><!-- .dslca-section-title -->

						<div class="dslca-section-scroller">
							<div class="dslca-section-scroller-inner">
								<div class="dslca-section-scroller-content">
									<?php dslc_display_modules( $_GET['page_id'] ); ?>
								</div><!-- .dslca-section-scroller-content -->
							</div><!-- .dslca-section-scroller-inner -->
						</div><!-- .dslca-section-scroller-content -->

						<div class="dslca-section-scroller-fade"></div>

						<div class="dslca-section-scroller-nav">
							<a href="#" class="dslca-section-scroller-prev"><span class="dslca-icon dslc-icon-angle-left"></span></a>
							<a href="#" class="dslca-section-scroller-next"><span class="dslca-icon dslc-icon-angle-right"></span></a>
						</div><!-- .dslca-section-scroller -->

					</div><!-- .dslca-modules -->

					<!-- Module Edit -->

					<div class="dslca-section dslca-module-edit" data-bg="#5890e5">

						<form class="dslca-module-edit-form">
							<?php do_action( 'dslc_options_prepend' ); ?>
							<div class="dslca-module-edit-options dslc-clearfix">
								<div class="dslca-module-edit-options-tabs dslc-clearfix"></div>
								<?php
								/*
								<!-- Add clear styling button -->
								<span class="dslca-clear-styling-button">Clear Styling</span>
								*/
								?>

								<div class="dslca-module-edit-options-inner"></div>
							</div>
							<?php do_action( 'dslc_options_append' ); ?>
						</form>

					</div><!-- .dslca-module-edit -->

					<!-- Module Section Edit -->

					<div class="dslca-section dslca-modules-section-edit" data-bg="#5890e5">
						<form class="dslca-modules-section-edit-form">
							<div class="dslca-modules-section-edit-options dslc-clearfix">
								<div class="dslca-modules-section-edit-options-inner">
									<div class="dslca-modules-section-edit-options-wrapper dslc-clearfix">

										<?php dslc_row_display_options(); ?>

									</div><!-- .dslca-modules-section-edit-options-wrapper -->
								</div><!-- .dslca-modules-section-edit-options-inner -->
							</div><!-- .dslca-modules-section-edit-options -->
						</form><!-- .dslca-modules-section-edit-form -->
					</div><!-- .dslca-module-section-edit -->

					<!-- Module Templates -->

					<div class="dslca-section dslca-templates dslc-clearfix">

						<div class="dslca-section-title">
							<?php _e( 'Designs', 'live-composer-page-builder' ); ?>
						</div><!-- .dslca-section-title -->

						<a href="#" class="dslca-go-to-section-hook" data-section=".dslca-templates-load"><span class="dslca-icon dslc-icon-circle-arrow-down"></span><?php _e( 'Load Page Design', 'live-composer-page-builder' ); ?></a>
						<a href="#" class="dslca-open-modal-hook" data-modal=".dslca-modal-templates-save"><span class="dslca-icon dslc-icon-save"></span><?php _e( 'Save Page Design', 'live-composer-page-builder' ); ?></a>
						<a href="#" class="dslca-open-modal-hook" data-modal=".dslca-modal-templates-import"><span class="dslca-icon dslc-icon-download-alt"></span><?php _e( 'Import Page Code', 'live-composer-page-builder' ); ?></a>
						<a href="#" class="dslca-open-modal-hook" data-modal=".dslca-modal-templates-export"><span class="dslca-icon dslc-icon-upload-alt"></span><?php _e( 'Export Page Code', 'live-composer-page-builder' ); ?></a>

						<div class="dslca-modal dslca-modal-templates-save">
							<form class="dslca-template-save-form">
								<input type="text" id="dslca-save-template-title" placeholder="<?php _e( 'Name of the template', 'live-composer-page-builder' ); ?>">
								<div class="dslca-submit"><?php _e( 'Save', 'live-composer-page-builder' ); ?></div>
								<div class="dslca-cancel dslca-close-modal-hook" data-modal=".dslca-modal-templates-save"><?php _e( 'Cancel', 'live-composer-page-builder' ); ?></div>
							</form>
						</div><!-- .dslca-modal -->

						<div class="dslca-modal dslca-modal-templates-export">

							<form class="dslca-template-export-form">
								<textarea id="dslca-export-code"></textarea>
								<span class="dslca-cancel dslca-close-modal-hook" data-modal=".dslca-modal-templates-export"><?php _e( 'Close', 'live-composer-page-builder' ); ?></span>
							</form>

						</div><!-- .dslca-modal -->

						<div class="dslca-modal dslca-modal-templates-import">

							<form class="dslca-template-import-form">
								<textarea id="dslca-import-code" placeholder="<?php _e( 'Enter the exported code heree', 'live-composer-page-builder' ); ?>"></textarea>
								<div class="dslca-submit">
									<div class="dslca-modal-title"><?php _e( 'Import', 'live-composer-page-builder' ); ?></div>
									<div class="dslca-loading followingBallsGWrap">
										<div class="followingBallsG_1 followingBallsG"></div>
										<div class="followingBallsG_2 followingBallsG"></div>
										<div class="followingBallsG_3 followingBallsG"></div>
										<div class="followingBallsG_4 followingBallsG"></div>
									</div>
								</div>
								<span class="dslca-cancel dslca-close-modal-hook" data-modal=".dslca-modal-templates-import"><?php _e( 'Cancel', 'live-composer-page-builder' ); ?></span>
							</form>

						</div><!-- .dslca-modal -->

					</div><!-- .dslca-section-templates -->

					<!-- Module Template Load -->

					<div class="dslca-section dslca-templates-load dslc-clearfix">

						<a href="#" class="dslca-go-to-section-hook dslca-section-back" data-section=".dslca-templates"><span class="dslca-icon dslc-icon-reply"></span></a>

						<div class="dslca-section-title">
							<div class="dslca-section-title-filter">
								<span class="dslca-section-title-filter-curr"><?php _e( 'All Templates', 'live-composer-page-builder' ); ?></span>
								<span class="dslca-icon dslc-icon-angle-up"></span>
								<div class="dslca-section-title-filter-options"></div>
							</div><!-- .dslca-section-title-filter -->
						</div><!-- .dslca-section-title -->

						<div class="dslca-section-scroller">
							<div class="dslca-section-scroller-inner">
								<div class="dslca-section-scroller-content">
									<?php dslc_display_templates(); ?>
								</div>
							</div>
						</div>

						<div class="dslca-section-scroller-nav">
							<a href="#" class="dslca-section-scroller-prev"><span class="dslca-icon dslc-icon-angle-left"></span></a>
							<a href="#" class="dslca-section-scroller-next"><span class="dslca-icon dslc-icon-angle-right"></span></a>
						</div><!-- .dslca-section-scroller -->

					</div><!-- .dslca-templates-load -->

				</div><!-- .dslca-sections -->

				<!-- Module Template Export -->
				<textarea id="dslca-code"></textarea>
				<textarea id="dslca-content-for-search"></textarea>
				<textarea id="dslca-js-errors-report"></textarea>

				<div class="dslca-container-loader">
					<div class="dslca-container-loader-inner followingBallsGWrap">
						<div class="followingBallsG_1 followingBallsG"></div>
						<div class="followingBallsG_2 followingBallsG"></div>
						<div class="followingBallsG_3 followingBallsG"></div>
						<div class="followingBallsG_4 followingBallsG"></div>
					</div>
				</div>

			</div><!-- .dscla-container -->

			<div class="dslca-prompt-modal">

				<div class="dslca-prompt-modal-content">

					<div class="dslca-prompt-modal-msg">

						Message goes here

					</div><!-- .dslca-prompt-modal-msg -->

					<div class="dslca-prompt-modal-actions">

						<a href="#" class="dslca-prompt-modal-confirm-hook"><span class="dslc-icon dslc-icon-ok"></span><?php _e( 'Confirm', 'live-composer-page-builder' ); ?></a>
						<a href="#" class="dslca-prompt-modal-cancel-hook"><span class="dslc-icon dslc-icon-remove"></span><?php _e( 'Cancel', 'live-composer-page-builder' ); ?></a>

					</div>

				</div><!-- .dslca-prompt-modal-content -->

			</div><!-- .dslca-prompt-modal -->

			<div class="dslca-module-edit-field-icon-ttip">
				<?php echo __( 'Icons used by default are from "Font Awesome" set.', 'live-composer-page-builder' ) . '<br>' . '<a href="https://livecomposerplugin.com/downloads/linecons-icons-add-on/?utm_source=lc-ui&utm_medium=module-options&utm_campaign=more_icons" class="dslca-link" target="_blank">You can add more icons.</a>'; ?>
				<span class="dslca-module-edit-field-ttip-close"><span class="dslc-icon dslc-icon-remove"></span></span>
			</div>

			<div class="dslca-module-edit-field-ttip">
				<span class="dslca-module-edit-field-ttip-close"><span class="dslc-icon dslc-icon-remove"></span></span>
				<div class="dslca-module-edit-field-ttip-inner"></div>
			</div>

			<div class="dslca-invisible-overlay"></div>
			<div id="scroller-stopper"></div>
			<script id="pseudo-panel" type="template">
				<div class="dslca-pseudo-panel">
					<div class="dslca-pseudo-header dslc-clearfix">

						<!-- Tabs -->
						<!-- Module Option filters -->
						<span class="dslca-pseudo-options-filter-hook dslca-active" data-section="functionality" style="display: block;"><span class="dslca-icon dslc-icon-cog"></span> Functionality</span>
						<span class="dslca-pseudo-options-filter-hook" data-section="styling" style="display: block;"><span class="dslca-icon dslc-icon-tint"></span> Styling</span>
						<span class="dslca-pseudo-options-filter-hook" data-section="responsive" style="display: block;"><span class="dslca-icon dslc-icon-mobile-phone"></span> Responsive</span>

						<!-- Module Options Actions -->
						<div class="dslca-pseudo-module-edit-actions" style="display: block;">
							<a href="#" class="dslca-pseudo-module-edit-save">Confirm</a>
							<a href="#" class="dslca-pseudo-module-edit-cancel">Cancel</a>
						</div>
						<!-- Row Options Actions -->

					</div><!-- .dslca-header -->

					<div class="dslca-pseudo-actions">

						<!-- Hide/Show -->
						<a href="#" class="dslca-pseudo-hide-composer-hook"><span class="dslca-icon dslc-icon-arrow-down"></span>Hide</a>

						<!-- Disable -->
						<a href="#" class="dslca-pseudo-close-composer-hook"><span class="dslca-icon dslc-icon-remove"></span>Close</a>

						<div class="dslc-clear"></div>

					</div><!-- .dslca-actions -->



					<!-- Modules Listing -->
					<!-- .dslca-modules -->

					<!-- Module Edit -->

					<div class="dslca-pseudo-section" data-bg="#5890e5" style="display: block;">

						<div class="dslca-pseudo-module-edit-options dslc-clearfix">
							<div class="dslca-pseudo-module-edit-options-tabs dslc-clearfix" style="display: none;">
								<a href="#" class="dslca-pseudo-module-edit-options-tab-hook">General</a>
								<a href="#" class="dslca-pseudo-module-edit-options-tab-hook">Settigns</a>
								<a href="#" class="dslca-pseudo-module-edit-options-tab-hook">Content</a>
							</div>

							<div class="dslca-pseudo-module-edit-options-wrapper dslc-clearfix">
								<div class="dslca-pseudo-module-edit-option" style="display: table-cell;">
									<span class="dslca-pseudo-module-edit-label">&nbsp;</span>
									<div class="dslca-pseudo-module-edit-field">&nbsp;</div>
								</div><!-- .dslc-module-edit-option -->
								<div class="dslca-pseudo-module-edit-option" style="display: table-cell;">
									<span class="dslca-pseudo-module-edit-label">&nbsp;</span>
									<div class="dslca-pseudo-module-edit-field">&nbsp;</div>
								</div><!-- .dslc-module-edit-option -->
								<div class="dslca-pseudo-module-edit-option" style="display: table-cell;">
									<span class="dslca-pseudo-module-edit-label">&nbsp;</span>
									<div class="dslca-pseudo-module-edit-field">&nbsp;</div>
								</div><!-- .dslc-module-edit-option -->
								<div class="dslca-pseudo-module-edit-option" style="display: table-cell;">
									<span class="dslca-pseudo-module-edit-label">&nbsp;</span>
									<div class="dslca-pseudo-module-edit-field">&nbsp;</div>
								</div><!-- .dslc-module-edit-option -->
								<div class="dslca-pseudo-module-edit-option" style="display: table-cell;">
									<span class="dslca-pseudo-module-edit-label">&nbsp;</span>
									<div class="dslca-pseudo-module-edit-field">&nbsp;</div>
								</div><!-- .dslc-module-edit-option -->
							</div>
						</div>
					</div>
				</div>
			</script>
		<?php

		// Output editor messages.
		/* $editor_messages = new LC_Editor_Messages();

		if ( ! $editor_messages->get_hidden() ) {
			echo $editor_messages->print_messages();
		} */

	endif;

} add_action( 'admin_footer', 'dslc_display_composer' );

/**
 * Returns array of active modules (false if none)
 *
 * @since 1.0
 */
function dslc_get_modules() {

	global $dslc_var_modules;

	if ( empty( $dslc_var_modules ) ) {
		return false;
	} else {
		return $dslc_var_modules;
	}

}

/**
 * Displays list of all modules in modules panel (for drag & drop)
 * – Modules order defined in dslc_register_modules() function.
 *
 * @since 1.0
 */
function dslc_display_modules( $page_id ) {

	$dslc_modules = dslc_get_modules();

	if ( $dslc_modules ) {

		?>

		<div class="dslca-module dslca-scroller-item dslca-origin" data-origin="General" data-id="DSLC_M_A">
			<span class="dslca-icon dslc-icon-th-large"></span><span class="dslca-module-title"><?php esc_html_e( 'Container', 'live-composer-page-builder' ); ?></span>
		</div><!-- .dslc-module -->

		<?php

		foreach ( $dslc_modules as $dslc_module ) {

			if ( empty( $dslc_module['icon'] ) ) {
				$dslc_module['icon'] = 'circle';
			}

			if ( empty( $dslc_module['origin'] ) ) {
				$dslc_module['origin'] = 'lc';
			}

			$module_id = $dslc_module['id'];
			$module_active = true;
			$module_active = apply_filters( 'dslc_modules_panel_item_class', $module_active, $page_id, $module_id );

			if ( ! $module_active ) {
				$module_non_active = 'dslca-module-non-active';
			} else {
				$module_non_active = '';
			}

			?><div class="dslca-module dslca-scroller-item dslca-origin dslca-origin-<?php echo esc_attr( $dslc_module['origin'] ); ?> <?php if ( isset( $dslc_module['exclude'] ) ) { echo 'dslca-exclude'; } ?> <?php echo $module_non_active; ?>" data-origin="<?php echo esc_attr( $dslc_module['origin'] ); ?>" data-id="<?php echo esc_attr( $dslc_module['id'] ); ?>">
					<span class="dslca-icon dslc-icon-<?php echo esc_attr( $dslc_module['icon'] ); ?>"></span><span class="dslca-module-title"><?php echo esc_html( $dslc_module['title'] ); ?></span>
				</div><?php

		}
	} else {

		esc_html_e( 'No Modules Found.', 'live-composer-page-builder' );

	}// End if().
}

/**
 * Displays a list of templates
 *
 * @since 1.0
 */
function dslc_display_templates() {

	// Get all the templates. Original data.
	$templates = dslc_get_templates();

	// Modified array to store templates by section.
	$templates_arr = array();

	// If there are active templates?
	if ( $templates ) {

		// Go through all templates, populate array.
		foreach ( $templates as $template ) {

			$section_title = $template['section'];
			$template['section'] = strtolower( str_replace( ' ', '_', $template['section'] ) );

			$templates_arr[ $template['section'] ][ $template['id'] ] = $template;
			$templates_arr[ $template['section'] ][ $template['id'] ]['section_title'] = $section_title;
		}

		// If there are templates?
		if ( ! empty( $templates_arr ) ) {

			// Go through each section.
			foreach ( $templates_arr as $template_section_id => $template_section_tpls ) {

				// Go through each template in a section.
				foreach ( $template_section_tpls as $template ) { ?>

					<a href="#" class="dslca-template dslca-scroller-item dslca-origin dslca-template-origin-<?php echo esc_attr( $template_section_id ); ?>" data-origin="<?php echo esc_attr( $template['section_title'] ); ?>" data-id="<?php echo esc_attr( $template['id'] ); ?>">
						<span class="dslca-template-title"><?php echo esc_html( $template['title'] ); ?></span>
						<?php if ( 'user' === $template_section_id ) : ?>
							<span class="dslca-delete-template-hook" data-id="<?php echo esc_attr( $template['id'] ); ?>">
								<span class="dslca-icon dslc-icon-trash"></span>
							</span>
						<?php endif; ?>
					</a><!-- .dslc-template -->

					<?php
				}
			}
		} else {

			echo 'No Templates Found';
		}
	}// End if().
}

/**
 * Hooks into the_content filter to add LC elements
 *
 * @since 1.0
 */
function dslc_filter_content( $content ) {
	// Uses 50% of the page loading time when not cached or in editing mode.
	// Get ID of the post in which the content filter fired.
	$curr_id = get_the_ID();

	// If post pass protected and pass not supplied return original content.
	if ( post_password_required( $curr_id ) ) {
		return $content;
	}

	// Initiate simple html rendering cache.
	$cache = new DSLC_Cache( 'html' );
	$cache_id = $curr_id;

	if ( is_archive() || is_front_page() && ! get_option( 'page_on_front' ) ) {
		$post_type_slug = get_post_type();
		$template_id = dslc_get_archive_template_by_pt( $post_type_slug );
		$cache_id = $template_id;
	}

	if ( is_search() ) {
		$template_id = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );
		$cache_id = $template_id;
	}

	// Check if we have html for this code cached?
	if ( ! dslc_is_editor_active() && $cache->enabled() && $cache->cached( $cache_id ) ) {
		// Check if any dynamic content included before caching.
		$cached_page_html = $cache->get_cache( $cache_id );
		// We need double do_shortcode as our module shortcodes can contain encoded 3-rd party shortcodes.
		return do_shortcode( do_shortcode( $cached_page_html ) );
	}

	// Global variables.
	global $dslc_should_filter;
	global $wp_the_query;
	global $dslc_post_types;
	global $post;
	global $wp_query;

	// Get ID of the post from the main query.
	if ( isset( $wp_the_query->queried_object_id ) ) {
		$real_id = $wp_the_query->queried_object_id;
	} else {
		$real_id = 'nope';
	}

	// Check if we should we filtering the content
	// 1) Proceed if ID of the post in which content filter fired is same as the post ID from the main query
	// 2) Proceed if in a WordPress loop ( https://codex.wordpress.org/Function_Reference/in_the_loop )
	// 3) Proceed if global var $dslc_should_filter is true
	// Irrelevant of the other 3 proceed if archives, search or 404 page.
	if ( ( $curr_id == $real_id && in_the_loop() && $dslc_should_filter ) || ( is_archive() && $dslc_should_filter ) || is_author() || is_search() || is_404() || is_front_page() && ! get_option( 'page_on_front' ) ) {

		// Variables that are used throughout the function.
		$composer_wrapper_before = '';
		$composer_wrapper_after = '';
		$composer_header_append = ''; // HTML to output after LC header HTML.
		$composer_footer_append = ''; // HTML to otuput after LC footer HTML.
		$composer_header = ''; // HTML for LC header.
		$composer_footer = ''; // HTML for LC footer.
		$composer_prepend = ''; // HTML to output before LC content.
		$composer_content = ''; // HTML for LC content.
		$composer_append = ''; // HTML to ouput after LC content.
		$template_code = false; // LC code if current post powered by template.
		$template_id = false; // ID of the template that powers current post.

		// Wrapping all LC elements ( unless header/footer outputed by the theme ).
		// Class .dslc-content needed to have all the elements properly styled.
		// When DS_LIVE_COMPOSER_HF_AUTO = true LC outputs header and footer,
		// automatically adding div .dslc-content before header
		// and closing it after the footer.
		if ( dslc_is_editor_active() || ! defined( 'DS_LIVE_COMPOSER_HF_AUTO' ) || DS_LIVE_COMPOSER_HF_AUTO ) {
			$composer_wrapper_before = '<div id="dslc-content" class="dslc-content dslc-clearfix">';
			$composer_wrapper_after = '</div>';
		}

		// Get LC code of the current post.
		$composer_code = dslc_get_code( $curr_id );

		// If currently showing a singular post of a post type that supports "post templates".
		if ( is_singular( $dslc_post_types ) ) {

			// Get template ID set for currently shown post.
			$template_id = dslc_st_get_template_id( $curr_id );

			// If template ID exists.
			if ( $template_id ) {
				// Get LC code of the template.
				$composer_code = dslc_get_code( $template_id );
			}
		}

		$showing_404_page = dslc_postid_is_404_template( $post->ID );

		// If currently showing a category archive page.
		if ( is_archive() && ! $showing_404_page && ! is_author() && ! is_search() || is_front_page() && ! get_option( 'page_on_front' ) ) {

			$post_type_slug = get_post_type();
			$post_id = $post->ID;

			// Get ID of the page set to power the category of the current post type.
			$template_id = dslc_get_archive_template_by_pt( $post_type_slug );

			// If there is a page that powers it.
			if ( $template_id ) {
				// Get LC code of the page.
				$composer_code = dslc_get_code( $template_id );
			}
		}

		// If currently showing an author archive page.
		if ( is_author() && ! $showing_404_page ) {

			// Get ID of the page set to power the author archives.
			$template_id = dslc_get_option( 'author', 'dslc_plugin_options_archives' );

			// If there is a page that powers it.
			if ( $template_id ) {
				// Get LC code of the page.
				$composer_code = dslc_get_code( $template_id );
			}
		}

		// If currently showing a search results page.
		if ( is_search() && ! $showing_404_page ) {

			// Get ID of the page set to power the search results page.
			if ( is_search() && ( 0 == $wp_query->found_posts ) ) {
				$template_id = dslc_get_option( 'page_not_found', 'dslc_plugin_options_archives' );
			} else {
				$template_id = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );
			}

			// If there is a page that powers it.
			if ( $template_id ) {
				// Get LC code of the page.
				$composer_code = dslc_get_code( $template_id );
			}
		}

		// If currently showing 404 page?
		if ( is_404() ||
			( is_archive() && $showing_404_page ) ||
			( is_search() && $showing_404_page ) ||
			( is_author() && $showing_404_page ) ) {

			// Get ID of the page set to power the 404 page.
			$template_id = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );

			// If there is a page that powers it?
			if ( $template_id ) {
				// Get LC code of the page.
				$composer_code = dslc_get_code( $template_id );
			}
		}

		// If currently showing a singular post of a post type which is not "dslc_hf" ( used for header/footer )
		// And the constant DS_LIVE_COMPOSER_HF_AUTO is not defined or is set to false
		if ( ! is_singular( 'dslc_hf' ) && ( ! defined( 'DS_LIVE_COMPOSER_HF_AUTO' ) || DS_LIVE_COMPOSER_HF_AUTO ) ) {
			$composer_header = dslc_hf_get_header();
			$composer_footer = dslc_hf_get_footer();
		}

		// If editor is currently active clear the composer_prepend var.
		if ( dslc_is_editor_active( 'access' ) ) {
			$composer_prepend = '';
		}

		// If editor is currently active generate the LC elements and store them in composer_append var.
		if ( dslc_is_editor_active( 'access' ) ) {

			// The "Add modules row" and "Import" buttons
			$composer_append = '<div class="dslca-add-modules-section">
				<a href="#" class="dslca-add-modules-section-hook"><span class="dslca-icon dslc-icon-align-justify"></span>' . __( 'Add Modules Row', 'live-composer-page-builder' ) . '</a>
				<a href="#" class="dslca-import-modules-section-hook"><span class="dslca-icon dslc-icon-download-alt"></span>' . __( 'Import', 'live-composer-page-builder' ) . '</a>
			</div>';
		}

		// If editor is currently active generate add section dividers svg code.
		if ( dslc_is_editor_active( 'access' ) ) {

			// The "Add modules row" and "Import" buttons
			$composer_append .= '<div id="dslc-section-dividers">' . dslc_section_dividers( 'all', '', 'code' ) . '</div>';
		}

		if ( ! empty( $composer_code ) || ! empty( $template_code ) ) {
			// If there is LC code to add to the content output.
			// Turn the LC code into HTML code.
			$composer_content = dslc_render_content( $composer_code );

		} elseif ( ! empty( $composer_header ) || ! empty( $composer_footer ) ) {
			// If there is header or footer LC code to add to the content output.
			// If editor not active.
			if ( ! dslc_is_editor_active() ) {

				$rendered_header_footer = $composer_wrapper_before . $composer_header . '<div id="dslc-theme-content"><div id="dslc-theme-content-inner">' . $content . '</div></div>' . $composer_footer . $composer_wrapper_after;
				$cache->set_cache( $rendered_header_footer, $cache_id );

				// Pass the LC header, regular content and LC footer
				// We need double do_shortcode as our module shortcodes can contain encoded 3-rd party shortcodes.
				return do_shortcode( do_shortcode( $rendered_header_footer ) );
			}
		} else {

			// If editor not active
			if ( ! dslc_is_editor_active() ) {

				// Nothing to render.
				// Pass back the original wrapped in a div ( in case there's a need to style it )
				return '<div id="dslc-theme-content"><div id="dslc-theme-content-inner">' . $content . '</div></div>';
			}
		}

		// If singular post shown and has a featured image
		if ( is_singular() && has_post_thumbnail( $curr_id ) ) {
			// Hidden input holding value of the URL of the featured image of the shown post ( used by rows for BG image )
			$composer_append .= '<input type="hidden" id="dslca-post-data-thumb" value="' . apply_filters( 'dslc_row_bg_featured_image', wp_get_attachment_url( get_post_thumbnail_id( $curr_id ) ) ) . '" />';
		}

		if ( dslc_is_editor_active( 'access' ) ) {
			$composer_wrapper_after .= '<div class="lc-scroll-top-area"></div><div class="lc-scroll-bottom-area"></div>';
		}

		// Before Content.
		$content_before = '';
		$dslc_content_before = apply_filters( 'dslc_content_before', $content_before );

		// After Content.
		$content_after = '';
		$dslc_content_after = apply_filters( 'dslc_content_after', $content_after );
		$rendered_page = $dslc_content_before . $composer_wrapper_before . do_action( 'dslc_output_prepend' ) . $composer_header . '<div id="dslc-main">' . $composer_prepend . $composer_content . '</div>' . $composer_append . $composer_footer . do_action( 'dslc_output_append' ) . $composer_wrapper_after . $dslc_content_after;

		if ( ! dslc_is_editor_active() && ! is_singular( 'dslc_hf' ) ) {
			
			$cache->set_cache( $rendered_page, $cache_id );
			
		}

		// We need double do_shortcode as our module shortcodes can contain encoded 3-rd party shortcodes.
		return do_shortcode( do_shortcode( $rendered_page ) );

	} else {
		// If LC should not filter the content (full content posts output in the blog/posts modules ).
		// Pass back the original wrapped in a div ( in case there's a need to style it )
		return '<div id="dslc-theme-content"><div id="dslc-theme-content-inner">' . $content . '</div></div>';
	} // End if().

} add_filter( 'the_content', 'dslc_filter_content', 101 );



/**
 * Check if provided id is template for the custom 404 page.
 *
 * @param  int $post_id Post to check.
 * @return bool         True post id = 404 template id, otherwise false.
 */
function dslc_postid_is_404_template( $post_id ) {
	$template_404_id = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );

	if ( intval( $post_id ) === intval( $template_404_id ) ) {
		return true;
	}

	return false;
}

/**
 * Alternative to do_shortcode used before.
 * This function converts JSON/serialize input into HTML output.
 * It also supports the old code format: shortcodes.
 *
 * @param bool $update_ids Require module unique id regeneration (on row import).
 */
function dslc_render_content( $page_code, $update_ids = false, $is_header_footer = false ) {
	// Transform JSON or old base64 encoded code into serialized array.
	$page_code_array = dslc_json_decode( $page_code );

	/**
	 * If legacy (shortcodes) code.
	 *
	 * Function dslc_json_decode returns FALSE
	 * if can't transform data into array.
	 */
	if ( ! is_array( $page_code_array ) ) {
		// Brute-force disable inner shortcodes.
		// To optimize the code rendering times.
		$page_code = str_replace( '[dslc_modules_area ', '{dslc_modules_area ', $page_code );
		$page_code = str_replace( '[dslc_modules_area]', '{dslc_modules_area}', $page_code );
		$page_code = str_replace( '[/dslc_modules_area]', '{/dslc_modules_area}', $page_code );

		$page_code = str_replace( '[dslc_module ', '{dslc_module ', $page_code );
		$page_code = str_replace( '[dslc_module]', '{dslc_module}', $page_code );
		$page_code = str_replace( '[/dslc_module]', '{/dslc_module}', $page_code );

		return do_shortcode( $page_code );
	}

	$page_html = ''; // Final content part rendering.

	// If new (JSON) code format go through elements of the page.
	foreach ( $page_code_array as $element ) {

		if ( 'row' === $element['element_type'] ) {

			$row_atts = $element;

			// If we import code, then it's required to update element ids
			// to make it unique.
			if ( $update_ids ) {
				$row_atts['give_new_id'] = 'true';
			}

			$page_html .= dslc_modules_section_front( $row_atts, $element['content'], 2, $is_header_footer );

		} elseif ( 'module_area' === $element['element_type'] ) {

			$modulearea_atts = $element;

			// If we import code, then it's required to update element ids
			// to make it unique.
			if ( $update_ids ) {
				$modulearea_atts['give_new_id'] = 'true';
			}

			$page_html .= dslc_modules_area_front( $modulearea_atts, $element['content'], 2, $is_header_footer );

		} elseif ( 'module' === $element['element_type'] ) {

			$module_atts = $element;

			// If we import code, then it's required to update module ids
			// to make it unique.
			if ( $update_ids ) {
				$module_atts['give_new_id'] = 'true';
			}

			$page_html .= dslc_module_front( $module_atts, $element, $is_header_footer  );
		} // End if().
	} // End foreach().

	return $page_html;
}


/**
 * Output hidden TinyMCE editor popup.
 *
 * @return void
 */
function dslc_editor_code() {

	// Get the editor type from the settings.
	$editor_type = dslc_get_option( 'lc_editor_type', 'dslc_plugin_options_other' );

	// If no editor type set in settings.
	if ( empty( $editor_type ) ) {

		// Default to "both" ( Visual and HTML ).
		$editor_type = 'both';

	}

	?>
		<div class="dslca-wp-editor">
			<div class="dslca-wp-editor-inner">
				<?php
				if ( 'visual' === $editor_type ) {
					wp_editor( '', 'dslcawpeditor', array(
						'quicktags' => false,
					) );
				} else {
					wp_editor( '', 'dslcawpeditor' );
				}
				?>
				<div class="dslca-wp-editor-notification">
					<?php _e( 'Module settings are being loaded. Save/Cancel actions will appear shortly.', 'live-composer-page-builder' ); ?>
				</div><!-- .dslca-wp-editor-notification -->
				<div class="dslca-wp-editor-actions">
					<span class="dslca-wp-editor-save-hook" data-event="modal-wysiwyg-confirm"><?php _e( 'Confirm', 'live-composer-page-builder' ); ?></span>
					<span class="dslca-wp-editor-cancel-hook" data-event="modal-wysiwyg-cancel"><?php _e( 'Cancel', 'live-composer-page-builder' ); ?></span>
				</div>
			</div>
		</div>
	<?php

} add_action( 'dslca_editing_screen_footer', 'dslc_editor_code' );


/**
 * Checks if the code provided in $string attribute is JSON.
 *
 * @param  String $string Code to validate.
 * @return Bool           True if JSON, false otherwise.
 */
function dslc_is_json( $string ) {
    	
	try {
		json_decode( $string );
	} catch (\Throwable $th) {
		return false;
	}

	return ( function_exists( 'json_last_error' ) && json_last_error() == JSON_ERROR_NONE );
}

/**
 * Transform JSON or old base64 encoded serialized code
 * into unpacked ready to use un-serialized array.
 *
 * @param  String $raw_code Can be JSON, base64+serialized array, or serialized array.
 * @return Array/Bool       Code as array or FALSE if not posible to decode.
 */
function dslc_json_decode( $raw_code, $ignore_migration = false ) {
	$decoded = false;
    
	if (!is_array($raw_code) && dslc_is_json( $raw_code ) ) {
	    $decoded = json_decode( $raw_code, true );
	  
	}
	else{
		if(is_serialized($raw_code))
		{
			$raw_code = unserialize($raw_code,['allowed_classes' => false]);
			// $raw_code = unserialize( maybe_serialize($raw_code));
		}
		// Array already provided. Do nothing.
		if ( is_array( $raw_code ) ) {
			return $raw_code;
		}

		// Is it JSON?
		if ( ! dslc_is_json( $raw_code ) ) {
			// If it's not JSON then:
			// 1. it's old code of the module settings serialized + base64.
			// 2. it's old code containing both shortocodes + base64.
			/**
			 * Is it's valid base64?
			 *
			 * Function base64_decode returns FALSE if input contains
			 * character from outside the base64 alphabet.
			 */

			$decoded_base64 = base64_decode( $raw_code );

			// Base64 successfull?
			if ( ! $decoded_base64 ) {
				// 2. it's old code containing both shortocodes + base64
				// We can do nothing with it, so return FALSE.
				return false;
			} else {
				// 1. it's old code of the module settings serialized + base64.
				// Get array out of it.
				// $decoded = unserialize( $decoded_base64,['allowed_classes' => false] );
				if(is_serialized($decoded_base64))
				{
					$decoded = unserialize( $decoded_base64,['allowed_classes' => false] );
				}
				// $decoded = unserialize( $decoded_base64);
				
				// Add a marker indicating that this module
				// was imported from shortcode format.
				if ( is_array( $decoded ) ) {
					$decoded['code_version'] = 1;
				}

				// Preset is always being stored in base64 format,
				// so we need to ignore code version parameter as it's not relevant.
				if ( $ignore_migration ) {
					unset( $decoded['code_version'] );
				}
			}
		} else {
			// Decode JSON.
			$decoded = json_decode( $raw_code, true );
		} // End if().

	}

	
	return $decoded;
}


/**
 * HTML output for the modules/elements
 *
 * @since 1.0
 */
function dslc_module_front( $atts, $settings_raw = null, $is_header_footer = false ) {

	global $dslc_active;

	// Settings RAW can be a serialized array (old version of dslc_code)
	// or json array (new generation).
	$settings = dslc_json_decode( $settings_raw );

	// If this module was just imported from the first generation
	// of dslc_code (shortcodes + base64) launch a special migration process.
	// In migration process we fix some issues to make sure nothing breaks
	// when we switch users to JSON code format.
	if ( isset( $settings['code_version'] ) && 1 === $settings['code_version'] ) {
		$settings = dslc_code_migration( $settings );
	}

	if ( is_array( $settings ) ) {

		// The ID of the module.
		$module_id = $settings['module_id'];

		// Check if active.
		if ( ! dslc_is_module_active( $module_id ) ) {
			return;
		}

		// If class does not exists.
		if ( ! class_exists( $module_id ) ) {
			return;
		}

		$module_instance_id = $settings['module_instance_id'];

		// Apply new instance ID if needed.
		if ( isset( $atts['give_new_id'] ) ) {
			$settings['module_instance_id'] = dslc_get_new_module_id();
		}

		if ( isset( $atts['last'] ) && 'yes' === $atts['last'] ) {
			$settings['dslc_m_size_last'] = 'yes';
		} else {
			$settings['dslc_m_size_last'] = 'no';
		}

		// Instanciate the module class
		$module_instance = new $module_id();

		// Append marker indicating that the module
		// was displayed during the regular page rendering
		// not as ajax repsonse on creation/editing
		$settings['module_render_nonajax'] = true;

		// Fixing the options array
		global $dslc_var_image_option_bckp;
		$dslc_var_image_option_bckp = array();
		$module_struct = $module_instance->options();

		// 🔖 RAW CODE CLEANUP
		/*
		 Previous version.
		foreach ( $module_struct as $option ) {

			// Fix settings when a new option added after a module is used
			if ( ! isset( $settings[$option['id']] ) ) {

				// if ( isset( $option['std'] ) && $option['std'] !== '' ) {
				// 	$settings[$option['id']] = $option['std'];
				// } else {
					$settings[$option['id']] = false;
				// }
			}
		}
		*/

		// 🔖 RAW CODE CLEANUP
		foreach ( $module_struct as $option ) {
			// Fix 'Undefined index' notices.
			if ( isset( $option['id'] ) && ! isset( $settings[ $option['id'] ] ) ) {
				$settings[ $option['id'] ] = false;
			}
		}

		// Load preset options if preset supplied
		$settings = apply_filters( 'dslc_filter_settings', $settings );

		// Transform image ID to URL
		foreach ( $module_struct as $option ) {

			if ( isset( $option['type'] ) && 'image' === $option['type'] ) {
				if ( isset( $settings[ $option['id'] ] ) && ! empty( $settings[ $option['id'] ] ) && is_numeric( $settings[ $option['id'] ] ) ) {

					$dslc_var_image_option_bckp[ $option['id'] ] = $settings[ $option['id'] ];
					$image_info = wp_get_attachment_image_src( $settings[ $option['id'] ], 'full' );
					if( isset( $image_info[0] ) ){
						$settings[ $option['id'] ] = $image_info[0];
					}
				}
			}
		}

		// Code before module output.
		ob_start();
			$module_instance->module_before( $settings );
			$output_start = ob_get_contents();
		ob_end_clean();

		// Module output.
		ob_start();
			if ( did_action( $module_id . '_output' ) > 0 ) {
                do_action( $module_id . '_output', $settings, $module_instance, $dslc_active );
            } else {
                $module_instance->output( $settings );
			}

			$output_body = ob_get_contents();
		ob_end_clean();

		// Code after module output.
		ob_start();
			$module_instance->module_after( $settings );
			$output_end = ob_get_contents();
		ob_end_clean();

		$output_body = dslc_decode_shortcodes( $output_body ); // , 'storage' );

		return $output_start . $output_body . $output_end;

	} elseif ( dslc_current_user_can( 'access' ) ) {

		return __( 'A module broke', 'live-composer-page-builder' );

	} // End if().

} add_shortcode( 'dslc_module', 'dslc_module_front' );

/**
 * Return section divider SVG by id
 *
 * @param boolean $id Section design id to return. Returns all if false.
 * @return string Svg code of the selected section or all the svgs.
 */
function dslc_section_dividers( $id = 'all', $css = '', $return = 'code' ) {

	$result = '';
	$sections = array(
		'skewed' => array(
			'title' => __( 'Skewed', 'live-composer-page-builder' ),
			'code' => '
				<svg id="skewed" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<polygon class="divider-color"  points="0 0 1442 0 0 100"></polygon>
				</svg>',
		),
		'arched' => array(
			'title' => __( 'Arched', 'live-composer-page-builder' ),
			'code' => '
				<svg id="arched" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 144" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,14.287108 L682.266,129.122 C621.756612,138.267588 517.026832,143.977138 423.629338,144 L422.504016,144 C396.685569,143.99367 371.751899,143.551232 348.88,142.625 L0,128.495459 L0,0 L1442,0 L1442,14.287108 Z" id="Combined-Shape"></path>
				</svg>',
		),
		'peak-side-rounded' => array(
			'title' => __( 'Peak - Rounded', 'live-composer-page-builder' ),
			'code' => '
				<svg id="peak-side-rounded" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1441.06801,100 L1407.63747,27.0792242 C1394.82277,2.5154943 1381.02633,6.49587567 1339.28857,8.67214151 L0,99.5001069 L0,0 L1442,0 L1442,100 L1441.06801,100 Z" id="peak-side-rounded"></path>
				</svg>',
		),
		'peak-side-rounded-off' => array(
			'title' => __( 'Peak - Rounded', 'live-composer-page-builder' ) . ' [-]',
			'code' => '
				<svg id="peak-side-rounded-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<path class="divider-color" d="M1442,100.222604 L0,100.222604 L0,97.5568966 L1339.28857,1.96300711 C1381.02633,-0.327451731 1394.82277,-4.51669164 1407.63747,21.3359461 L1442,100.222604 Z" transform="translate(721.000000, 50.222604) scale(1, -1) translate(-721.000000, -50.222604) "></path>
				</svg>',
		),
		'peak-side-soft' => array(
			'title' => __( 'Peak - Soft', 'live-composer-page-builder' ),
			'code' => '
				<svg id="peak-side-soft" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,59.372452 L1125.5394,15.1254357 C1103.82558,12.0894429 1081.84294,11.4599306 1059.99096,13.2483382 L0,100 L0,0 L1442,0 L1442,59.372452 Z" id="peak-side-soft"></path>
				</svg>',
		),
		'peak-side-soft-off' => array(
			'title' => __( 'Peak - Soft', 'live-composer-page-builder' ) . ' [-]',
			'code' => '
				<svg id="peak-side-soft-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,47.3616382 C1262.80953,82.5125498 1141.46481,99.9117234 1077.96583,99.5591592 C1014.46685,99.2065949 655.144907,66.3377422 -6.82121026e-13,0.952601072 L1442,0.952601072 L1442,47.3616382 Z" id="peak-side-soft-off"></path>
				</svg>',
		),
		'peak-side' => array(
			'title' => __( 'Peak', 'live-composer-page-builder' ),
			'code' => '
				<svg id="peak-side" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,43.5779721 C1231.27873,18.8205998 1113.46252,6.44191365 1088.55136,6.44191365 C1044.1269,6.44191365 681.276445,37.2946093 3.86535248e-12,99.0000005 L0,0.894641095 L1442,0.894641095 L1442,43.5779721 Z" id="Combined-Shape-Copy-8"></path>
				</svg>',
		),
		'peak-side-off' => array(
			'title' => __( 'Peak', 'live-composer-page-builder' ) . ' [-]',
			'code' => '
				<svg id="peak-side-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,39.8643569 L1442,100.547273 L0,100.547273 L0,98.5413585 C681.276445,33.2119679 1044.1269,0.547272552 1088.55136,0.547272552 C1113.46252,0.547272552 1231.27873,13.6529673 1442,39.8643569 Z" id="peak-side-off" transform="translate(721.000000, 50.547273) scale(1, -1) translate(-721.000000, -50.547273) "></path>
				</svg>',
		),
		'peak-center-sharp' => array(
			'title' => __( 'Peak - Center', 'live-composer-page-builder' ),
			'code' => '
				<svg id="peak-center-sharp" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,100.777057 L720.647978,17.0144305 L-5.68434189e-14,100.695305 L0,0.777057299 L1442,0.777057299 L1442,100.777057 Z"></path>
				</svg>',
		),
		'peak-center-sharp-off' => array(
			'title' => __( 'Peak - Center', 'live-composer-page-builder' ) . ' [-]',
			'code' => '
				<svg id="peak-center-sharp-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,100.237373 L0,100.237373 L0,100.139773 L720.647978,0.237373199 L1442,100.237373 Z" id="peak-center-sharp-off" transform="translate(721.000000, 50.237373) scale(1, -1) translate(-721.000000, -50.237373) "></path>
				</svg>',
		),
		'peak-center-soft' => array(
			'title' => __( 'Peak - Center - Soft', 'live-composer-page-builder' ),
			'code' => '
				<svg id="peak-center-soft" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1437.37922,100.277057 L823.4576,26.0907362 C785.104953,21.2174623 750.835079,18.7808253 720.647978,18.7808253 C690.460878,18.7808253 657.029922,21.1301388 620.355113,25.8287658 L4.0317179,100.277057 L0,100.277057 L0,0.277057299 L1442,0.277057299 L1442,100.277057 L1437.37922,100.277057 Z"></path>
				</svg>',
		),
		'peak-center-soft-off' => array(
			'title' => __( 'Peak - Center - Soft', 'live-composer-page-builder' ) . '[-]',
			'code' => '
				<svg id="peak-center-soft-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1433.37922,100.503768 L0.031717897,100.503768 L616.355113,9.15194761 C653.029922,3.38649457 686.460878,0.50376805 716.647978,0.50376805 C746.835079,0.50376805 781.104953,3.49364485 819.4576,9.47339846 L1433.37922,100.503768 Z" id="peak-center-soft-off" transform="translate(716.705471, 50.503768) scale(1, -1) translate(-716.705471, -50.503768) "></path>
				</svg>',
		),
		'hill-side-soft' => array(
			'title' => __( 'Hill - Soft', 'live-composer-page-builder' ),
			'code' => '
				<svg id="hill-side-soft" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,33.8142136 C1280.56278,15.0410066 1162.74657,5.65440317 1088.55136,5.65440317 C935.145886,5.65440317 572.295431,37.1029354 3.86535248e-12,100 L0,0 L1442,0 L1442,33.8142136 Z"></path>
				</svg>',
		),
		'hill-side-soft-off' => array(
			'title' => __( 'Hill - Soft', 'live-composer-page-builder' ) . '[-]',
			'code' => '
				<svg id="hill-side-soft-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,30.5019121 L1442,100.654403 L0,100.654403 C572.295431,33.9877365 935.145886,0.654403168 1088.55136,0.654403168 C1162.74657,0.654403168 1280.56278,10.6035728 1442,30.5019121 Z" id="hill-side-soft-off" transform="translate(721.000000, 50.654403) scale(1, -1) translate(-721.000000, -50.654403) "></path>
				</svg>',
		),
		'hill-side-round' => array(
			'title' => __( 'Hill - Round', 'live-composer-page-builder' ),
			'code' => '
				<svg id="hill-side-round" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,34.6187945 C1315.02765,14.2772114 1160.84924,2.89696087 977.282647,2.89696087 C645.766901,2.89696087 281.275997,40.0139604 0,100 L0,0 L1442,0 L1442,34.6187945 Z"></path>
				</svg>',
		),
		'hill-side-round-off' => array(
			'title' => __( 'Hill - Round', 'live-composer-page-builder' ) . '[-]',
			'code' => '
				<svg id="hill-side-round-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,33.5651801 L1442,100.896961 L0,100.896961 C281.275997,39.1213047 645.766901,0.896960872 977.282647,0.896960872 C1160.84924,0.896960872 1315.02765,12.6167284 1442,33.5651801 Z" id="hill-side-round-off" transform="translate(721.000000, 50.896961) scale(1, -1) translate(-721.000000, -50.896961) "></path>
				</svg>',
		),
		'hill-center-round' => array(
			'title' => __( 'Hill - Center - Round', 'live-composer-page-builder' ),
			'code' => '
				<svg id="hill-center-round" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,99.9999995 C1241.28259,39.8431566 991.38636,4.17007947 720.5,4.17007947 C450.063321,4.17007947 200.547143,39.7248178 -5.68434189e-14,99.7006146 L0,-5.37426331e-07 L1442,-5.37426331e-07 L1442,99.9999995 Z"></path>
				</svg>',
		),
		'hill-center-round-off' => array(
			'title' => __( 'Hill - Center - Round', 'live-composer-page-builder' ) . '[-]',
			'code' => '
				<svg id="hill-center-round-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,100.17008 L0,100.17008 L0,99.8576673 C200.547143,37.271998 450.063321,0.17008001 720.5,0.17008001 C991.38636,0.17008001 1241.28259,37.3954863 1442,100.17008 Z" id="hill-center-round-off" transform="translate(721.000000, 50.170080) scale(1, -1) translate(-721.000000, -50.170080) "></path>
				</svg>',
		),
		'wave' => array(
			'title' => __( 'Wave', 'live-composer-page-builder' ),
			'code' => '
				<svg id="wave" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,68.0981233 C1208.93089,-11.3822297 920.961252,-17.4990636 578.091093,49.7476217 C332.207693,97.9724181 139.510662,81.7891119 0,1.19770302 L0,5.37426445e-07 L1442,5.37426445e-07 L1442,68.0981223 Z"></path>
				</svg>',
		),
		'wave-off' => array(
			'title' => __( 'Wave', 'live-composer-page-builder' ) . '[-]',
			'code' => '
				<svg id="wave-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,100.114928 L1442,101 C1441.26026,100.704161 1440.51992,100.409129 1439.77899,100.114904 L0,100.114928 L0,32.3561645 C135.2357,99.751738 316.345496,110.920533 543.329388,65.8625497 C903.44127,-5.62232566 1202.2578,5.79512581 1439.77899,100.114904 L1442,100.114928 Z M1442,0.114927948 L0,0.114927948 L1442,0.114928486 Z" id="wave-off" transform="translate(721.000000, 50.557464) scale(1, -1) translate(-721.000000, -50.557464) "></path>
				</svg>',
		),
		'deepening' => array(
			'title' => __( 'Deeping', 'live-composer-page-builder' ),
			'code' => '
				<svg id="deepening" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M1442,2.03149588 C1200.33333,4.31314746 914.749946,31.7033182 585.249837,84.202008 C353.733926,121.089043 158.650643,93.3798956 -1.21069334e-05,1.07456613 L-8.52651283e-14,5.37426445e-07 L1442,5.37426445e-07 L1442,2.03149588 Z"></path>
				</svg>',
		),
		'deepening-off' => array(
			'title' => __( 'Deeping', 'live-composer-page-builder' ) . '[-]',
			'code' => '
				<svg id="deepening-off" style="' . esc_attr( $css ) . '" preserveAspectRatio="none" viewBox="0 0 1442 100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<path class="divider-color" d="M394.85237,100 L-1,100 L-1,0 L-1,1.07456559 C157.650655,93.379895 352.733938,121.089042 584.249849,84.2020074 C913.749958,31.7033176 1199.33335,4.31314693 1441.00001,2.03149535 L1441.00001,0 L-0.999987893,0 L1441,0 L-0.999987893,0 L1441,0 L1441,100 L-1,100 L-1,0 L-1,1.07456559 C112.35263,67.0248254 244.303421,99.9999702 394.85237,100 Z" id="deepening-off" transform="translate(720.000006, 50.000000) scale(1, -1) translate(-720.000006, -50.000000) "></path>
				</svg>',
		),
	);

	if ( 'all' === $id ) {
		if ( 'code' === $return ) {
			$sections_code = array();
			foreach ( $sections as $id => $section) {
				$sections_code[] = $section['code'];
			}
			$result = implode( ' ', $sections_code ); // Return all the sections code if no id set.

		} elseif ( 'title' === $return ) {
			$section_titles = array();
			foreach ( $sections as $id => $section) {
				$section_titles[ $id ] = $section['title'];
			}

			$result = $section_titles; // Return all the section ids and titles.
		} else {
			$result = $sections;
		}
	} elseif ( ! empty( $id ) && array_key_exists( $id, $sections ) ) {
		if ( 'code' === $return ) {
			$result = $sections[ $id ]['code'];
		} elseif ( 'title' === $return ) {
			$result = $sections[ $id ]['title'];
		} else {
			$result = $sections[ $id ];
		}
	} else {
		$result = '';
	}

	return $result;
}

function dslc_divider_css( $atts, $pos = 'top' ) {
	$styles = '';

	// CSS for SVG fill color.
	$color_id = 'section_divider_' . $pos . '_color';

	if ( ! empty( $atts[ $color_id ] ) ) {
		$styles .= 'fill:' . esc_attr( $atts[ $color_id ] ) . ';';
	}

	// CSS for SVG height.
	$height_id = 'section_divider_' . $pos . '_height';

	if ( ! empty( $atts[ $height_id ] ) ) {
		$styles .= ' height:' . esc_attr( $atts[ $height_id ] ) . 'px;';
	}

	return $styles;


}

function dslc_render_divider( $atts, $pos = 'top' ) {
	$id = 'section_divider_' . $pos . '_style';
	$flip_id = 'section_divider_' . $pos . '_flip';

	if ( dslc_is_editor_active() || ! empty( $atts[ $id ] ) && 'none' !== trim( $atts[ $id ] ) ) {
		$divider_style = trim( $atts[ $id ] );
		$css_classes = '';
		if ( ! empty( $atts[ $flip_id ] ) ) { 
			if ( 'horizontally' === trim( $atts[ $flip_id ] ) ) {
				$css_classes .= ' dslc-flip-hor';
			} elseif ( 'vertically' === trim( $atts[ $flip_id ] ) ) {
				$css_classes .= ' dslc-flip-vert';
			}
		}
		$output =
			'<div class="dslc-section-divider' . esc_attr( $css_classes ) . '"
					data-divider-pos="' . esc_attr( $pos ) .  '"
					data-divider-style="' . esc_attr( $divider_style ) . '">' .
				dslc_section_dividers( esc_attr( $divider_style ), dslc_divider_css( $atts, $pos ) ) .
			'</div>';

		return $output;
	}

	return '';
}

/**
 * HTML output for the sections.
 *
 * @param  array   $atts    Module settings as array.
 * @param  string  $content Used when running from shortcode. Innder shortcode cotent.
 * @param  integer $version Use version = 2 to parse $content as JSON based code, otherwise it will render $content as shortcodes.
 * @return string           Rendered code (Not always! Needs refactoring).
 * @since 1.0
 */
function dslc_modules_section_front( $atts, $content = null, $version = 1, $is_header_footer = false ) {

	global $dslc_active;
	$section_style = dslc_row_get_style( $atts );
	$section_class = '';
	$overlay_style = '';

	$atts['element_type'] = 'row';

	// Columns spacing.
	if ( ! isset( $atts['columns_spacing'] ) ) {
			$atts['columns_spacing'] = 'spacing';
	}

	// Custom Class.
	if ( ! isset( $atts['custom_class'] ) ) {
			$atts['custom_class'] = '';
	}

	// Show On.
	if ( ! isset( $atts['show_on'] ) ) {
			$atts['show_on'] = 'desktop tablet phone';
	}

	// Unique section ID.
	if ( ! isset( $atts['section_instance_id'] ) ) {
		$atts['section_instance_id'] = dslc_get_new_module_id();
	}

	// Apply new instance ID if needed.
	if ( isset( $atts['give_new_id'] ) ) {
		$atts['section_instance_id'] = dslc_get_new_module_id();
	}

	// Custom ID.
	if ( ! isset( $atts['custom_id'] ) ) {
			$atts['custom_id'] = '';
	}

	// Full/Wrapped.
	if ( isset( $atts['type'] ) && ! empty( $atts['type'] ) && $atts['type'] == 'full' ) {
			$section_class .= ' dslc-full ';
	}

	// Parallax.
	$parallax_class = '';
	if ( isset( $atts['bg_image_attachment'] ) && ! empty( $atts['bg_image_attachment'] ) && $atts['bg_image_attachment'] == 'parallax' ) {
			$parallax_class = ' dslc-init-parallax ';
	}

	// Overlay Color.
	if ( isset( $atts['bg_video_overlay_color'] ) && ! empty( $atts['bg_video_overlay_color'] ) ) {
			$overlay_style .= 'background-color:' . esc_attr($atts['bg_video_overlay_color']) . '; ';
	}

	// Overlay Opacity.
	if ( isset( $atts['bg_video_overlay_opacity'] ) && ! empty( $atts['bg_video_overlay_opacity'] ) ) {
			$overlay_style .= 'opacity:' . esc_attr($atts['bg_video_overlay_opacity']) . '; ';
	}

	/**
	 * BG Video
	 */

	// Overlay.
	$bg_video = '<div class="dslc-bg-video dslc-force-show"><div class="dslc-bg-video-overlay" style="' . $overlay_style . '"></div></div>';

	// BG Video.
	if ( isset( $atts['bg_video'] ) && '' !== $atts['bg_video'] && 'disabled' !== $atts['bg_video'] ) {

		// If it's numeric (in the media library).
		if ( is_numeric( $atts['bg_video'] ) ) {
					$atts['bg_video'] = wp_get_attachment_url( $atts['bg_video'] );
		}

		

		
		$current_site_url = home_url();
        
        // Get the URL to check
        $url_to_check = $atts['bg_video'];
        
        // Parse the URLs to get their host/domain
        $current_site_host = parse_url($current_site_url, PHP_URL_HOST);
        $url_to_check_host = parse_url($url_to_check, PHP_URL_HOST);
        
        // Check if the hosts are the same
        if ($current_site_host === $url_to_check_host) {
//             		$atts['bg_video'] = str_replace( '.mp4', '', $atts['bg_video'] );
// 		$atts['bg_video'] = str_replace( '.webm', '', $atts['bg_video'] );
        $bg_video = '
           
            		<div class="dslc-bg-video">
			<div class="dslc-bg-video-inner">
	
		
        
        <video autoplay loop muted playsinline id="video-background">
    <source src="'.$atts['bg_video'].'" type="video/mp4">
    	<source type="video/webm" src="' . $atts['bg_video'] . '.webm" />
</video>
            	</div>
			<div class="dslc-bg-video-overlay" style="' . $overlay_style . '"></div>
		</div>
       
        ';
//        

        } else {            
            	// The HTML.
            		$bg_video = '
            	<div class="dslc-bg-video">
            		<div class="dslc-bg-video-inner">
            	                <div class="hp-hero" style="backgroundz-index: 0;   "></div>
            		</div>
            		<div class="dslc-bg-video-overlay" style="' . $overlay_style . '"></div>
            	</div>
            	
            	
                <div class="bgndVideo player mb_YTPlayer isMuted" data-property="{videoURL:\'' . $atts['bg_video'] . '\',containment:\'.hp-hero\',autoPlay:true,mobileFallbackImage:\'https://demo.flawlessthemes.com/hotelinn-pro2/wp-content/uploads/2021/04/la-pota-4096087_1280.jpg\' ,showControls:false, mute:true, startAt:0, opacity:1}"></div>
            
            	
            <script src="https://code.jquery.com/jquery-3.6.0.miny.js"></script>
            
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mb.YTPlayer/3.3.9/jquery.mb.YTPlayer.js" integrity="sha512-QEsEUG6vCJ4YMCLGNXn9zScVK2FYKyMSntIS5s3P8h1c5kz5320OE5nij835WZqfTt3JrfyyoOTm0JhVWoqJPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
            jQuery(document).ready(function(){
            jQuery(".bgndVideo").YTPlayer();
            });
            </script>
            <style>
            .hp-hero {
            position: initial !important;
            }
            </style>
            	
            	';

        }
		



	}

	$output_bgoverlay = false;

	/**
	 * Always output bg overlay:
	 * – if opacity property is set;
	 * – if LC is in editing mode;
	 * – if bg_video is set.
	 */

	if ( stristr( $overlay_style, 'opacity' ) ) {
		$output_bgoverlay = true;
	}

	if ( DS_LIVE_COMPOSER_ACTIVE ) {
		$output_bgoverlay = true;
	}

	if ( isset( $atts['bg_video'] ) && '' !== $atts['bg_video'] ) {
		$output_bgoverlay = true;
	}

	// Do not output video HTML code when not needed.
	if ( ! $output_bgoverlay ) {
		$bg_video = '';
	}

	/**
	 * Admin Classes
	 */

	$a_container_class = '';
	$a_prepend = '';
	$a_append = '';

	if ( $dslc_active && ! $is_header_footer ) {
		$a_container_class .= ' dslc-modules-section-empty dslc-modules-section-dnd ';
		$a_prepend = '<div class="dslc-modules-section-inner dslc-clearfix">';
		$a_append = '</div>';
	}

	// Columns spacing
	if ( $atts['columns_spacing'] == 'nospacing' ) {
		$section_class .= ' dslc-no-columns-spacing ';
	}

	// Custom Class.
	if ( $atts['custom_class'] != '' ) {

		// Process all class definitions.
			$custom_class = preg_replace( '/,/', ' ', $atts['custom_class'] );
			$custom_class = preg_replace( '/\b\.\b/', ' ', $custom_class );
			$custom_class = preg_replace( '/\./', '', $custom_class );
			$custom_class = preg_replace( '/\s{2,}/', ' ', $custom_class );
			$custom_class = trim( $custom_class );

		$section_class .= $custom_class . ' ';
	}

	// Show on Class.
	$show_on = explode( ' ', trim( $atts['show_on'] ) );

	if ( ! in_array( 'desktop', $show_on, true ) ) {
		$section_class .= ' dslc-hide-on-desktop ';
	}

	if ( ! in_array( 'tablet', $show_on, true ) ) {
		$section_class .= ' dslc-hide-on-tablet ';
	}

	if ( ! in_array( 'phone', $show_on, true ) ) {
		$section_class .= ' dslc-hide-on-phone ';
	}

	// Sticky Class.
	if ( ! empty( $atts['sticky_row'] ) && 'enabled' === trim( $atts['sticky_row'] ) ) {
		$section_class .= ' dslc-sticky-row ';
		$sticky_style   = '<style type="text/css">';
		$sticky_style  .= '.dslc-sticky-row[data-section-id="' . $atts['section_instance_id'] . '"].dslc-sticky-section-fixed {';
		$sticky_style  .= 'padding-top: ' . $atts['sticky_row_padding_vertical'] . 'px !important; ';
		$sticky_style  .= 'padding-bottom: ' . $atts['sticky_row_padding_vertical'] . 'px !important;';
		$sticky_style  .= '}';
		$sticky_style  .= '</style>';
	} else {
		$section_class .= '';
		$sticky_style = '';
	}

	// ============================================================
	// Section dividers.
	if ( ! isset( $atts['section_divider_top_style'] ) ) {
		$atts['section_divider_top_style'] = '';
	}

	$section_divider_top = dslc_render_divider( $atts, 'top' );

	if ( ! isset( $atts['section_divider_bottom_style'] ) ) {
		$atts['section_divider_bottom_style'] = '';
	}

	$section_divider_bottom = dslc_render_divider( $atts, 'bottom' );

	// Allow other developers to add classes.
	$filter_classes = array();
	$filter_classes = apply_filters( 'dslc_row_class', $filter_classes, $atts );
	$extra_classes = '';
	if ( count( $filter_classes ) > 0 ) {
		foreach ( $filter_classes as $filter_class ) {
			$extra_classes .= $filter_class . ' ';
		}
	}

	// Custom ID.
	$section_id = false;
	if ( $atts['custom_id'] != '' ) {
			$section_id = $atts['custom_id'];
	}

	// Custom ID - Output
	$section_id_output = '';
	if ( $section_id ) {
		$section_id_output = 'id="' . $section_id . '"';
	}

	$content_render = '';

	if ( 2 !== $version ) {
		// Back-compatibility for shortcode-based dslc_code.
		// OLD: $content_render = do_shortcode( $content );
		$content = str_replace( '{dslc_modules_area ', '[dslc_modules_area ', $content );
		$content = str_replace( '{dslc_modules_area}', '[dslc_modules_area]', $content );
		$content = str_replace( '{/dslc_modules_area}', '[/dslc_modules_area]', $content );

		$content_render = do_shortcode( $content );

	} elseif ( 2 === $version ) {

		// New JSON-based dslc_code.
		if ( isset( $atts['give_new_id'] ) && 'true' === $atts['give_new_id'] ) {
			// Udpdate ids of the elements inside.
			$content_render = dslc_render_content( $content, true );
		} else {
			$content_render = dslc_render_content( $content );
		}
	}

	$output = '';

	if ( ! $dslc_active ) {
		$dslc_section_before = '';
		$output .= dslc_decode_shortcodes( apply_filters( 'dslc_section_before', $dslc_section_before, $atts ) );
	}
	if(isset($atts['bg_video']) && !empty($atts['bg_video'])){
		$atts['bg_video'] = sanitize_key(esc_attr($atts['bg_video']));
	}
	$output .= '
		<div ' . $section_id_output . ' class="dslc-modules-section ' . $a_container_class . $parallax_class . $section_class . $extra_classes . '" style="' . dslc_row_get_style( $atts ) . '" data-section-id="' . $atts['section_instance_id'] . '">
				' . $bg_video . '
				' . $section_divider_top . $section_divider_bottom . '
				<div class="dslc-modules-section-wrapper dslc-clearfix">'
					. $a_prepend . $content_render . $a_append
					. '</div>' . $sticky_style;

	if ( $dslc_active && ! $is_header_footer && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		$atts = dslc_encode_shortcodes_in_array( $atts );
		$ui_icons_url = DS_LIVE_COMPOSER_URL . 'css/icons';

		// Management
		$output .= '
				<div class="dslca-modules-section-manage">
					<div class="dslca-modules-section-manage-inner">
						<span class="dslca-manage-action dslca-edit-modules-section-hook" title="Edit options" >
							<svg class="feather">
								<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#sliders"/>
							</svg>
						</span>
						<span class="dslca-manage-action dslca-copy-modules-section-hook" title="Duplicate" >
							<svg class="feather">
								<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#copy"/>
							</svg>
						</span>
						<span class="dslca-manage-action dslca-move-modules-section-hook" title="Drag to move" >
							<svg class="feather">
								<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#move"/>
							</svg>
						</span>
						<span class="dslca-manage-action dslca-export-modules-section-hook" title="Export section code" >
							<svg class="feather">
								<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#download"/>
							</svg>
						</span>
						<span class="dslca-manage-action dslca-delete-modules-section-hook" title="Delete" >
							<svg class="feather">
								<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#x"/>
							</svg>
						</span>
					</div>
				</div>
				<div class="dslca-modules-section-settings">' . dslc_encode_shortcodes( dslc_row_get_options_fields( $atts ) ) . '</div>';

		$output .= '<textarea class="dslca-section-code">' . json_encode( $atts ) . '</textarea>';
	}

	$output .= '</div>';

	if ( ! $dslc_active ) {
		$dslc_section_after = '';
		$output .= dslc_decode_shortcodes( apply_filters( 'dslc_section_after', $dslc_section_after, $atts ) );
	}

	return $output; // To make caching work we do shortcodes in dslc_filter_content only.

} add_shortcode( 'dslc_modules_section', 'dslc_modules_section_front' );

/**
 * Output front end modules area content
 *
 * @param  array   $atts    Module settings as array.
 * @param  string  $content Used when running from shortcode. Innder shortcode cotent.
 * @param  integer $version Use version = 2 to parse $content as JSON based code, otherwise it will render $content as shortcodes.
 * @return string           Rendered code (Not always! Needs refactoring).
 * @since 1.0
 */
function dslc_modules_area_front( $atts, $content = null, $version = 1, $is_header_footer = false ) {

	global $dslc_active;
	$ui_icons_url = DS_LIVE_COMPOSER_URL . 'css/icons';

	$pos_class = '';
	$admin_class = '';

	// Set default module area size.
	if ( ! isset( $atts['size'] ) ) {
			$atts['size'] = '12';
	}

	$module_area_size = $atts['size'];

	if ( isset( $atts['last'] ) && 'yes' === $atts['last'] ) {
			$pos_class = 'dslc-last-col';
	}

	if ( isset( $atts['first'] ) && 'yes' === $atts['first'] ) {
			$pos_class = 'dslc-first-col';
	}

	if ( $dslc_active && ! $is_header_footer ) {
		$admin_class = ' dslc-modules-area-dnd';
	}

	$valign_class = '';
	if ( isset( $atts['valign'] ) ) {
		$valign_class = ' dslc-valign-' . esc_attr($atts['valign']) . ' ';
	} else {
		$atts['valign'] = '';
	}

	$output = '<div class="dslc-modules-area dslc-col dslc-' . $atts['size'] . '-col ' . $pos_class . $valign_class . $admin_class . '" data-size="' . $atts['size'] . '" data-valign="' . esc_attr($atts['valign']) . '">';

	if ( $dslc_active && ! $is_header_footer && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// Management.
		$output .= '<div class="dslca-modules-area-manage">
			<span class="dslca-modules-area-manage-line"></span>
			<div class="dslca-modules-area-manage-inner">
				<span class="dslca-manage-action dslca-copy-modules-area-hook" title="Duplicate" >
					<svg class="feather">
						<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#copy"/>
					</svg>
				</span>
				<span class="dslca-manage-action dslca-move-modules-area-hook" title="Drag to move" >
					<svg class="feather">
						<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#move"/>
					</svg>
				</span>
				<span class="dslca-manage-action dslca-change-width-modules-area-hook" title="Change width" >
					<svg class="feather">
						<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#columns"/>
					</svg>
					<div class="dslca-change-width-modules-area-options">
						<span>' . __( 'Container Width', 'live-composer-page-builder' ) . '</span>
						<span data-size="1">1/12</span><span data-size="2">2/12</span>
						<span data-size="3">3/12</span><span data-size="4">4/12</span>
						<span data-size="5">5/12</span><span data-size="6">6/12</span>
						<span data-size="7">7/12</span><span data-size="8">8/12</span>
						<span data-size="9">9/12</span><span data-size="10">10/12</span>
						<span data-size="11">11/12</span><span data-size="12">12/12</span>
					</div>
				</span>
				<span class="dslca-manage-action dslca-change-vertial-align-module-area-hook" title="Change vertical align" >
					<svg class="feather">
						<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#git-commit"/>
					</svg>
					<div class="dslca-change-vertial-align-module-area-options">
						<span>' . __( 'Vertical Align', 'live-composer-page-builder' ) . '</span>
						<span data-valign="top" class="dslc-popup-option">⬆️ Top</span>
						<span data-valign="middle" class="dslc-popup-option">↕️ Middle</span>
						<span data-valign="bottom" class="dslc-popup-option">⬇️ Bottom</span>
					</div>
				</span>
				<span class="dslca-manage-action dslca-delete-modules-area-hook" title="Delete" >
					<svg class="feather">
						<use xlink:href="' . esc_url( $ui_icons_url ) . '/feather-sprite.svg#x"/>
					</svg>
				</span>
			</div>
		</div>';
	}

	$content_render = '';

	if ( 2 !== $version ) {
		// Back-compatibility for shortcode-based dslc_code.
		// OLD: $content_render = do_shortcode( $content );
		// Restore module shortcodes.
		$content = str_replace( '{dslc_module ', '[dslc_module ', $content );
		$content = str_replace( '{dslc_module}', '[dslc_module]', $content );
		$content = str_replace( '{/dslc_module}', '[/dslc_module]', $content );

		$modules = explode( '[/dslc_module]', trim( $content ) );

		foreach ( $modules as $module ) {
			if ( trim( $module ) ) {
				$module_settings_encoded = preg_replace( "/(?:\[dslc_module[A-Za-z=\"' 0-9\-_]*\])/", '', $module );
				$content_render .= dslc_module_front( false, $module_settings_encoded );
			}
		}
	} elseif ( 2 === $version ) {

		// New JSON-based dslc_code.
		if ( isset( $atts['give_new_id'] ) && 'true' === $atts['give_new_id'] ) {
			// Update ids of the elements inside.
			$content_render = dslc_render_content( $content, true );
		} else {
			$content_render = dslc_render_content( $content );
		}
	}

	// Modules output.
	if ( empty( $content ) || ' ' === $content ) {
		$output .= ''; // '&nbsp;';
	} else {
		$output .= $content_render;
	}

	$output .= '</div>';

	// Return the output.
	return $output;

} add_shortcode( 'dslc_modules_area', 'dslc_modules_area_front' );

/**
 * Loads a template part
 *
 * @since 1.0
 */
function dslc_load_template( $filename, $default = '' ) {

	$template = '';

	// If filename supplied
	if ( $filename ) {

		// Look for template in the theme
		$template = locate_template( array( $filename ) );

		// If not found in theme load default
		if ( ! $template ) {
					$template = DS_LIVE_COMPOSER_ABS . $default;
		}

		load_template( $template, false );

	}

}

function dslc_get_gfonts() {

	/* This array gets filled with fonts used on the page (temporary storage) */
	global $dslc_googlefonts_array;

	global $dslc_available_fonts;
	$dslc_all_googlefonts_array = $dslc_available_fonts['google'];

	if ( ! defined( 'DS_LIVE_COMPOSER_GFONTS' ) || DS_LIVE_COMPOSER_GFONTS ) {

		$gfonts_output_prepend = '';// '@import url("//fonts.googleapis.com/css?family=';
		$gfonts_output_append = ''; // '&subset=' . $gfonts_output_subsets . '"); ';
		$gfonts_ouput_inner = array();

		$gfonts_do_output = true;

		if ( count( $dslc_googlefonts_array ) == 1 && $dslc_googlefonts_array[0] == '' ) {
			$gfonts_do_output = false;
		}

		foreach ( $dslc_googlefonts_array as $gfont ) {
			if ( in_array( $gfont, $dslc_all_googlefonts_array ) ) {
				$gfont = str_replace( ' ', '+', $gfont );
				if ( $gfont != '' ) {
					$gfonts_ouput_inner[] = $gfont . ':100,200,300,400,500,600,700,800,900';
				}
			}
		}

		// Do not output empty Google font calls (when font set to an empty string)
		if ( $gfonts_do_output && count( $gfonts_ouput_inner ) ) {
			// $gfonts_output = $gfonts_output_prepend . $gfonts_ouput_inner . $gfonts_output_append;
			// if ( '' !== $gfonts_ouput_inner ) {
				return $gfonts_ouput_inner;
			// }
		}
	}
}

function dslc_render_gfonts( $fonts_array ) {

	if ( is_array( $fonts_array ) && ! empty( $fonts_array ) ) {

		// Google Fonts Import.
		$gfonts_output = '';
		$gfonts_output_subsets = '';
		$gfonts_subsets_arr = dslc_get_option( 'lc_gfont_subsets', 'dslc_plugin_options_performance' );
		if ( ! $gfonts_subsets_arr ) {
			$gfonts_subsets_arr = array( 'latin', 'latin-ext', 'cyrillic', 'cyrillic-ext' );
		}

		foreach ( $gfonts_subsets_arr as $gfonts_subset ) {
			if ( '' === $gfonts_output_subsets ) {
				$gfonts_output_subsets .= $gfonts_subset;
			} else {
				$gfonts_output_subsets .= ',' . $gfonts_subset;
			}
		}

		$gfonts_output .= '<link href="//fonts.googleapis.com/css?family=';
		$fonts_array = array_unique( $fonts_array );
		foreach ( $fonts_array as $key => $font ) {
			if ( 0 < $key ) {
				$gfonts_output .= '|';
			}
			$gfonts_output .= $font;
		}

		$gfonts_output .= '&amp;subset=' . $gfonts_output_subsets;
		$gfonts_output .= '" rel="stylesheet">';

		echo $gfonts_output;
	}
}

/**
 * Pagination for modules
 */

function dslc_post_pagination( $atts ) {

	if ( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	} else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

	if ( ! isset( $atts['force_number'] ) ) {
		$force_number = false;
	} else {
		$force_number = $atts['force_number'];
	}
	if ( ! isset( $atts['pages'] ) ) {
		$pages = false;
	} else {
		$pages = $atts['pages'];
	}
	if ( ! isset( $atts['type'] ) ) {
		$type = 'numbered';
	} else {
		$type = $atts['type'];
	}
	$range = 2;

	$showitems = ( $range * 2 ) + 1;

	if ( empty( $paged ) ) { $paged = 1; }

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}

	if ( 1 != $pages ) {

		?>
		<div class="dslc-pagination dslc-pagination-type-<?php echo $type; ?>">
			<ul class="dslc-clearfix">
				<?php

				if ( $type == 'numbered' ) {

					if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) { echo "<li class='dslc-inactive'><a href='" . get_pagenum_link( 1 ) . "'>&laquo;</a></li>"; }
					if ( $paged > 1 && $showitems < $pages ) { echo "<li class='dslc-inactive'><a href='" . get_pagenum_link( $paged - 1 ) . "' >&lsaquo;</a></li>"; }

					for ( $i = 1; $i <= $pages; $i++ ) {
						if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
							echo ( $paged == $i ) ? "<li class='dslc-active'><a href='" . get_pagenum_link( $i ) . "'>" . $i . '</a></li>' : "<li class='dslc-inactive'><a class='inactive' href='" . get_pagenum_link( $i ) . "'>" . $i . '</a></li>';
						}
					}

					if ( $paged < $pages && $showitems < $pages ) { echo "<li class='dslc-inactive'><a href='" . get_pagenum_link( $paged + 1 ) . "'>&rsaquo;</a></li>"; }
					if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) { echo "<li class='dslc-inactive'><a href='" . get_pagenum_link( $pages ) . "'>&raquo;</a></li>"; }
				} elseif ( $type == 'prevnext' ) {

					if ( $paged > 1 ) { echo "<li class='dslc-inactive dslc-fl'><a href='" . get_pagenum_link( $paged - 1 ) . "' >" . __( 'Newer', 'live-composer-page-builder' ) . '</a></li>'; }
					if ( $paged < $pages ) { echo "<li class='dslc-inactive dslc-fr'><a href='" . get_pagenum_link( $paged + 1 ) . "'>" . __( 'Older', 'live-composer-page-builder' ) . '</a></li>'; }
				}

				if ( $type == 'loadmore' ) {
					if ( $paged < $pages ) {
						echo "<li class='dslc-pagination-load-more dslc-active'><a href='" . get_pagenum_link( $paged + 1 ) . "'><span class='dslc-icon dslc-icon-refresh'></span>" . $atts['pagination_text'] . '</a></li>';
					} else {
						echo "<li class='dslc-pagination-load-more dslc-inactive'><a href='#'><span class='dslc-icon dslc-icon-refresh'></span>" . $atts['pagination_text'] . '</a></li>';
					}
				}

				?>
			</ul>

			<?php if ( $type == 'loadmore' ) : ?>
				<div class="dslc-load-more-temp"></div>
			<?php endif; ?>

		</div><!-- .dslc-pagination --><?php
	}// End if().
}

/**
 * Disable shortcode rendering for the string provided by replacing
 * all WordPress shortcode brackets as follow: [ -> %(%  |  ] -> %)%.
 *
 * @param  string $code String with code to filter.
 * @return string       Filtered code.
 */
function dslc_encode_shortcodes( $code ) {
	$braket_open = '%(%';
	$braket_close = '%)%';

	// if ( 'storage' === $mode ) {
	// $braket_open =  '%((%';
	// $braket_close =  '%))%';
	// }
		$code = str_replace( '[',   $braket_open,  $code );
	$code = str_replace( '%{%', $braket_open,  $code );
	$code = str_replace( ']',   $braket_close, $code );
	$code = str_replace( '%}%', $braket_close, $code );

	return $code;
}

function dslc_encode_protected_shortcodes( $code ) {

	$braket_open = '%((%';
	$braket_close = '%))%';

		$code = str_replace( '[',   $braket_open,  $code );
	$code = str_replace( '%(%', $braket_open,  $code );
	$code = str_replace( ']',   $braket_close, $code );
	$code = str_replace( '%)%', $braket_close, $code );

	return $code;
}

function dslc_decode_shortcodes( $code, $mode = 'display' ) {
	$braket_open = '%(%';
	$braket_close = '%)%';

	if ( 'storage' === $mode ) {
		$braket_open =  '%((%';
		$braket_close =  '%))%';
	}
	$code = str_replace( $braket_open,  '[', $code );
	$code = str_replace( $braket_close, ']', $code );

	return $code;
}

function dslc_encode_shortcodes_in_array( $atts ) {
	if ( is_array( $atts ) ) {
		foreach ( $atts as $key => $value ) {
			$atts[ $key ] = dslc_encode_shortcodes_in_array( $value );
		}
	} else {
		return dslc_encode_shortcodes( $atts );
	}

	return $atts;
}
