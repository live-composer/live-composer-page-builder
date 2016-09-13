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
 * - dslc_custom_css ( Generates Custom CSS for the show page )
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
						<a href="#" class="dslca-module-edit-save"><?php esc_attr_e( 'Confirm', 'live-composer-page-builder' ); ?></a>
						<a href="#" class="dslca-module-edit-cancel"><?php esc_attr_e( 'Cancel', 'live-composer-page-builder' ); ?></a>
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
					<a href="#" class="dslca-show-composer-hook"><span class="dslca-icon dslc-icon-arrow-up"></span><?php _e( 'Show Editor', 'live-composer-page-builder' ); ?></a>
					<a href="#" class="dslca-hide-composer-hook"><span class="dslca-icon dslc-icon-arrow-down"></span><?php _e( 'Hide Editor', 'live-composer-page-builder' ); ?></a>

					<!-- Disable -->
					<a href="<?php the_permalink( $_GET['page_id'] ); ?>" class="dslca-close-composer-hook"><span class="dslca-icon dslc-icon-remove"></span><?php _e( 'Disable Editor', 'live-composer-page-builder' ); ?></a>

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
									<?php dslc_display_modules(); ?>
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
								<span class="dslca-submit"><?php _e( 'Save', 'live-composer-page-builder' ); ?></span>
								<span class="dslca-cancel dslca-close-modal-hook" data-modal=".dslca-modal-templates-save"><?php _e( 'Cancel', 'live-composer-page-builder' ); ?></span>
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
								<span class="dslca-submit">
									<span class="dslca-modal-title"><?php _e( 'Import', 'live-composer-page-builder' ); ?></span>
									<div class="dslca-loading followingBallsGWrap">
										<div class="followingBallsG_1 followingBallsG"></div>
										<div class="followingBallsG_2 followingBallsG"></div>
										<div class="followingBallsG_3 followingBallsG"></div>
										<div class="followingBallsG_4 followingBallsG"></div>
									</div>
								</span>
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

			<div class="dslca-module-edit-field-icon-switch-sets">
				<?php
					global $dslc_var_icons;
					foreach ( $dslc_var_icons as $key => $value ) :
						?><span data-set="<?php echo $key; ?>"><?php echo $key; ?></span><?php
					endforeach;
				?>
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
					<a href="#" class="dslca-pseudo-hide-composer-hook"><span class="dslca-icon dslc-icon-arrow-down"></span>Hide Editor</a>

					<!-- Disable -->
					<a href="#" class="dslca-pseudo-close-composer-hook"><span class="dslca-icon dslc-icon-remove"></span>Disable Editor</a>

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
function dslc_display_modules() {

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

			?>
				<div class="dslca-module dslca-scroller-item dslca-origin dslca-origin-<?php echo esc_attr( $dslc_module['origin'] ); ?>" data-origin="<?php echo esc_attr( $dslc_module['origin'] ); ?>" data-id="<?php echo esc_attr( $dslc_module['id'] ); ?>">
					<span class="dslca-icon dslc-icon-<?php echo esc_attr( $dslc_module['icon'] ); ?>"></span><span class="dslca-module-title"><?php echo esc_html( $dslc_module['title'] ); ?></span>
				</div><!-- .dslc-module -->
			<?php

		}
	} else {

		esc_html_e( 'No Modules Found.', 'live-composer-page-builder' );

	}

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
	}
}


/**
 * Hooks into the_content filter to add LC elements
 *
 * @since 1.0
 */
function dslc_filter_content( $content ) {

	// If post pass protected and pass not supplied return original content
	if ( post_password_required( get_the_ID() ) ) {
		return $content;
	}

	// Global variables.
	global $dslc_should_filter;
	global $wp_the_query;
	global $dslc_post_types;

	// Get ID of the post in which the content filter fired.
	$curr_id = get_the_ID();

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
	// Irrelevant of the other 3 proceed if archives, search or 404 page
	if ( ( $curr_id == $real_id && in_the_loop() && $dslc_should_filter ) || ( is_archive() && $dslc_should_filter ) || is_author() || is_search() || is_404() ) {

		// Variables that are used throughout the function
		$composer_wrapper_before = '';
		$composer_wrapper_after = '';
		$composer_header_append = ''; // HTML to output after LC header HTML
		$composer_footer_append = ''; // HTML to otuput after LC footer HTML
		$composer_header = ''; // HTML for LC header
		$composer_footer = ''; // HTML for LC footer
		$composer_prepend = ''; // HTML to output before LC content
		$composer_content = ''; // HTML for LC content
		$composer_append = ''; // HTML to ouput after LC content
		$template_code = false; // LC code if current post powered by template
		$template_id = false; // ID of the template that powers current post

		// Wrapping all LC elements ( unless header/footer outputed by theme ).
		if ( ! defined( 'DS_LIVE_COMPOSER_HF_AUTO' ) || DS_LIVE_COMPOSER_HF_AUTO ) {
			$composer_wrapper_before = '<div id="dslc-content" class="dslc-content dslc-clearfix">';
			$composer_wrapper_after = '</div>';
		}

		// Get LC code of the current post.
		$composer_code = dslc_get_code( get_the_ID() );

		// Interactive Tutorials.
		$tut_page = false;
		$tut_ch_one = dslc_get_option( 'lc_tut_chapter_one', 'dslc_plugin_options_tuts' );
		$tut_ch_two = dslc_get_option( 'lc_tut_chapter_two', 'dslc_plugin_options_tuts' );
		$tut_ch_three = dslc_get_option( 'lc_tut_chapter_three', 'dslc_plugin_options_tuts' );
		$tut_ch_four = dslc_get_option( 'lc_tut_chapter_four', 'dslc_plugin_options_tuts' );

		// If current page set to be tutorial chapter one or four
		if ( get_the_ID() == $tut_ch_one || get_the_ID() == $tut_ch_four ) {
			$tut_page = true;
			$composer_code = '';

		// If current page set to be tutorial chapter two.
		} elseif ( get_the_ID() == $tut_ch_two ) {
			$tut_page = true;
			$composer_code = '[dslc_modules_section type="wrapped" columns_spacing="spacing" bg_color="rgb(242, 245, 247)" bg_image_thumb="disabled" bg_image="" bg_image_repeat="repeat" bg_image_position="left top" bg_image_attachment="scroll" bg_image_size="auto" bg_video="" bg_video_overlay_color="#000000" bg_video_overlay_opacity="0" border_color="" border_width="0" border_style="solid" border="top right bottom left" margin_h="0" margin_b="0" padding="85" padding_h="0" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [/dslc_modules_area] [/dslc_modules_section] ';

		// If current page set to be tutorial chapter three.
		} elseif ( get_the_ID() == $tut_ch_three ) {
			$tut_page = true;
			$composer_code = '[dslc_modules_section type="wrapped" columns_spacing="spacing" bg_color="rgb(242, 245, 247)" bg_image_thumb="disabled" bg_image="" bg_image_repeat="repeat" bg_image_position="left top" bg_image_attachment="scroll" bg_image_size="auto" bg_video="" bg_video_overlay_color="#000000" bg_video_overlay_opacity="0" border_color="" border_width="0" border_style="solid" border="top right bottom left" margin_h="0" margin_b="0" padding="85" padding_h="0" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [/dslc_modules_area] [/dslc_modules_section] ';
		}

		// If currently showing a singular post of a post type that supports "post templates".
		if ( is_singular( $dslc_post_types ) ) {

			// Get template ID set for currently shown post.
			$template_id = dslc_st_get_template_id( get_the_ID() );

			// If template ID exists.
			if ( $template_id ) {

				// Get LC code of the template.
				$composer_code = dslc_get_code( $template_id );

			}
		}

		// If currently showing a category archive page.
		if ( is_archive() && ! is_author() && ! is_search() ) {

			$post_type = get_post_type();

			if ( 'post' === $post_type ) {
				$post_type = 'post_archive';
			}

			// Get ID of the page set to power the category of the current post type.
			$template_id = dslc_get_option( $post_type, 'dslc_plugin_options_archives' );

			// If there is a page that powers it.
			if ( $template_id ) {

				// Get LC code of the page.
				$composer_code = dslc_get_code( $template_id );

			}
		}

		// If currently showing an author archive page
		if ( is_author() ) {

			// Get ID of the page set to power the author archives
			$template_id = dslc_get_option( 'author', 'dslc_plugin_options_archives' );

			// If there is a page that powers it
			if ( $template_id ) {

				// Get LC code of the page
				$composer_code = dslc_get_code( $template_id );

			}

		}

		// If currently showing a search results page
		if ( is_search() ) {

			// Get ID of the page set to power the search results page
			$template_id = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );

			// If there is a page that powers it
			if ( $template_id ) {

				// Get LC code of the page
				$composer_code = dslc_get_code( $template_id );

			}

		}

		// If currently showing 404 page?
		if ( is_404() ) {

			// Get ID of the page set to power the 404 page
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

		// If editor is currently active generate the LC elements and store them in composer_append var
		if ( dslc_is_editor_active( 'access' ) ) {

			// The "Add modules row" and "Import" buttons
			$composer_append = '<div class="dslca-add-modules-section">
				<a href="#" class="dslca-add-modules-section-hook"><span class="dslca-icon dslc-icon-align-justify"></span>' . __( 'Add Modules Row', 'live-composer-page-builder' ) . '</a>
				<a href="#" class="dslca-import-modules-section-hook"><span class="dslca-icon dslc-icon-download-alt"></span>' . __( 'Import', 'live-composer-page-builder' ) . '</a>
			</div>';

		}

		// If there is LC code to add to the content output
		if ( $composer_code || $template_code ) {

			// Turn the LC code into HTML code
			$composer_content = do_shortcode( $composer_code );

		// If there is header or footer LC code to add to the content output
		} elseif ( $composer_header || $composer_footer ) {

			// If editor not active
			if ( ! DS_LIVE_COMPOSER_ACTIVE ) {

				// Pass the LC header, regular content and LC footer
				return $composer_wrapper_before . $composer_header . '<div id="dslc-theme-content"><div id="dslc-theme-content-inner">' . $content . '</div></div>' . $composer_footer . $composer_wrapper_after;

			}

		} else {

			// If editor not active
			if ( ! DS_LIVE_COMPOSER_ACTIVE ) {

				// Pass back the original wrapped in a div ( in case there's a need to style it )
				return '<div id="dslc-theme-content"><div id="dslc-theme-content-inner">' . $content . '</div></div>';

			}

		}

		// If singular post shown and has a featured image
		if ( is_singular() && has_post_thumbnail( get_the_ID() ) ) {
			// Hidden input holding value of the URL of the featured image of the shown post ( used by rows for BG image )
			$composer_append .= '<input type="hidden" id="dslca-post-data-thumb" value="' . apply_filters( 'dslc_row_bg_featured_image', wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ) . '" />';
		}

		// If current page is used for a tutorial
		if ( $tut_page ) {
			// Hidden input holding value of the current post ID
			$composer_append .= '<input type="hidden" id="dslca-tut-page" value="' . get_the_ID() . '" />';
		}

		if ( dslc_is_editor_active( 'access' ) ) {
			$composer_wrapper_after .= '<div class="lc-scroll-top-area"></div><div class="lc-scroll-bottom-area"></div>';
		}
		// Pass the filtered content output.
		return $composer_wrapper_before . do_action( 'dslc_output_prepend' ) . $composer_header . '<div id="dslc-main">' . $composer_prepend . $composer_content . '</div>' . $composer_append . $composer_footer . do_action( 'dslc_output_append' ) . $composer_wrapper_after;

	// If LC should not filter the content
	} else {

		// Pass back the original wrapped in a div ( in case there's a need to style it )
		return '<div id="dslc-theme-content"><div id="dslc-theme-content-inner">' . $content . '</div></div>';

	}

} add_filter( 'the_content', 'dslc_filter_content', 101 );

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
					wp_editor( '', 'dslcawpeditor', array( 'quicktags' => false ) );
				} else {
					wp_editor( '', 'dslcawpeditor' );
				}
				?>
				<div class="dslca-wp-editor-notification">
					<?php _e( 'Module settings are being loaded. Save/Cancel actions will appear shortly.', 'live-composer-page-builder' ); ?>
				</div><!-- .dslca-wp-editor-notification -->
				<div class="dslca-wp-editor-actions">
					<span class="dslca-wp-editor-save-hook"><?php _e( 'Confirm', 'live-composer-page-builder' ); ?></span>
					<span class="dslca-wp-editor-cancel-hook"><?php _e( 'Cancel', 'live-composer-page-builder' ); ?></span>
				</div>
			</div>
		</div>
	<?php

} add_action( 'dslca_editing_screen_footer', 'dslc_editor_code' );


/**
 * HTML output for the modules/elements
 *
 * @since 1.0
 */

function dslc_module_front( $atts, $settings_raw = null ) {

	$settings = maybe_unserialize( base64_decode( $settings_raw ) );

	if ( is_array( $settings ) ) {

		// The ID of the module
		$module_id = $settings['module_id'];

		// Check if active
		if ( ! dslc_is_module_active( $module_id ) ) {
					return;
		}

		// If class does not exists
		if ( ! class_exists( $module_id ) ) {
					return;
		}

		// Apply new instance ID if needed
		if ( isset( $atts['give_new_id'] ) ) {
			$settings['module_instance_id'] = dslc_get_new_module_id();
		}

		if ( isset( $atts['last'] ) && $atts['last'] == 'yes' ) {
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

		// Start output fetching
		ob_start();

		// Fixing the options array
		global $dslc_var_image_option_bckp;
		$dslc_var_image_option_bckp = array();
		$all_opts = $module_instance->options();

		foreach ( $all_opts as $all_opt ) {

			// Fix settings when a new option added after a module is used
			if ( ! isset( $settings[$all_opt['id']] ) ) {

				if ( isset( $all_opt['std'] ) && $all_opt['std'] !== '' ) {
					$settings[$all_opt['id']] = $all_opt['std'];
				} else {
					$settings[$all_opt['id']] = false;
				}
			}
		}

		// Load preset options if preset supplied
		$settings = apply_filters( 'dslc_filter_settings', $settings );

		// Transform image ID to URL
		foreach ( $all_opts as $all_opt ) {

			if ( $all_opt['type'] == 'image' ) {

				if ( isset( $settings[$all_opt['id']] ) && ! empty( $settings[$all_opt['id']] ) && is_numeric( $settings[$all_opt['id']] ) ) {

					$dslc_var_image_option_bckp[$all_opt['id']] = $settings[$all_opt['id']];
					$image_info = wp_get_attachment_image_src( $settings[$all_opt['id']], 'full' );
					$settings[$all_opt['id']] = $image_info[0];
				}
			}
		}

		// Module output
		$module_instance->output( $settings );

		// End output fetching
		$output = ob_get_contents();
		ob_end_clean();

		// Return the output
		return $output;

	} elseif ( dslc_current_user_can( 'access' ) ) {

		return __( 'A module broke', 'live-composer-page-builder' );

	}

} add_shortcode( 'dslc_module', 'dslc_module_front' );

/**
 * HTML output for the sections.
 *
 * @since 1.0
 */
function dslc_modules_section_front( $atts, $content = null ) {

	global $dslc_active;
	$section_style = dslc_row_get_style( $atts );
	$section_class = '';
	$overlay_style = '';

	// Columns spacing
	if ( ! isset( $atts['columns_spacing'] ) ) {
			$atts['columns_spacing'] = 'spacing';
	}

	// Custom Class
	if ( ! isset( $atts['custom_class'] ) ) {
			$atts['custom_class'] = '';
	}

	// Show On
	if ( ! isset( $atts['show_on'] ) ) {
			$atts['show_on'] = 'desktop tablet phone';
	}

	// Custom ID
	if ( ! isset( $atts['custom_id'] ) ) {
			$atts['custom_id'] = '';
	}

	// Full/Wrapped
	if ( isset( $atts['type'] ) && ! empty( $atts['type'] ) && $atts['type'] == 'full' ) {
			$section_class .= 'dslc-full ';
	}

	// Parallax
	$parallax_class = '';
	if ( isset( $atts['bg_image_attachment'] ) && ! empty( $atts['bg_image_attachment'] ) && $atts['bg_image_attachment'] == 'parallax' ) {
			$parallax_class = ' dslc-init-parallax ';
	}

	// Overlay Color
	if ( isset( $atts['bg_video_overlay_color'] ) && ! empty( $atts['bg_video_overlay_color'] ) ) {
			$overlay_style .= 'background-color:' . $atts['bg_video_overlay_color'] . '; ';
	}

	// Overlay Opacity
	if ( isset( $atts['bg_video_overlay_opacity'] ) && ! empty( $atts['bg_video_overlay_opacity'] ) ) {
			$overlay_style .= 'opacity:' . $atts['bg_video_overlay_opacity'] . '; ';
	}

	/**
	 * BG Video
	 */

	// Overlay
	$bg_video = '<div class="dslc-bg-video dslc-force-show"><div class="dslc-bg-video-overlay" style="' . $overlay_style . '"></div></div>';

	// BG Video
	if ( isset( $atts['bg_video'] ) && $atts['bg_video'] !== '' && $atts['bg_video'] !== 'disabled' ) {

		// If it's numeric ( in the media library )
		if ( is_numeric( $atts['bg_video'] ) ) {
					$atts['bg_video'] = wp_get_attachment_url( $atts['bg_video'] );
		}

		// Remove the file type extension
		$atts['bg_video'] = str_replace( '.mp4', '', $atts['bg_video'] );
		$atts['bg_video'] = str_replace( '.webm', '', $atts['bg_video'] );

		// The HTML
		$bg_video = '
		<div class="dslc-bg-video">
			<div class="dslc-bg-video-inner">
				<video>
					<source type="video/mp4" src="' . $atts['bg_video'] . '.mp4" />
					<source type="video/webm" src="' . $atts['bg_video'] . '.webm" />
				</video>
			</div>
			<div class="dslc-bg-video-overlay" style="'. $overlay_style . '"></div>
		</div>';

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

	if ( '' !== $atts['bg_video'] ) {
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

	if ( $dslc_active ) {
		$a_container_class .= 'dslc-modules-section-empty ';
		$a_prepend = '<div class="dslc-modules-section-inner dslc-clearfix">';
		$a_append = '</div>';
	}

	// Columns spacing
	if ( $atts['columns_spacing'] == 'nospacing' ) {
			$section_class .= 'dslc-no-columns-spacing ';
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
	// if ( '' !== $atts['show_on']  ) {
	$show_on = explode( ' ', trim( $atts['show_on'] ) );

	if ( ! in_array( 'desktop', $show_on, true ) ) {
		$section_class .= 'dslc-hide-on-desktop ';
	}

	if ( ! in_array( 'tablet', $show_on, true ) ) {
		$section_class .= 'dslc-hide-on-tablet ';
	}

	if ( ! in_array( 'phone', $show_on, true ) ) {
		$section_class .= 'dslc-hide-on-phone ';
	}
	// }
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

	$output = '
		<div ' . $section_id_output . ' class="dslc-modules-section ' . $a_container_class . $parallax_class . $section_class . $extra_classes . '" style="' . dslc_row_get_style( $atts ) . '">

				'.$bg_video . '

				<div class="dslc-modules-section-wrapper dslc-clearfix">'

					. $a_prepend . do_shortcode( $content ) . $a_append

					. '</div>';

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

			// Management
			$output .= '
				<div class="dslca-modules-section-manage">
					<div class="dslca-modules-section-manage-inner">
						<span class="dslca-manage-action dslca-edit-modules-section-hook" title="Edit options" ><span class="dslca-icon dslc-icon-cog"></span></span>
						<span class="dslca-manage-action dslca-copy-modules-section-hook" title="Duplicate" ><span class="dslca-icon dslc-icon-copy"></span></span>
						<span class="dslca-manage-action dslca-move-modules-section-hook" title="Drag to move" ><span class="dslca-icon dslc-icon-move"></span></span>
						<span class="dslca-manage-action dslca-export-modules-section-hook" title="Export section code" ><span class="dslca-icon dslc-icon-upload-alt"></span></span>
						<span class="dslca-manage-action dslca-delete-modules-section-hook" title="Delete" ><span class="dslca-icon dslc-icon-remove"></span></span>
					</div>
				</div>
				<div class="dslca-modules-section-settings">' . dslc_row_get_options_fields( $atts ) . '</div>';
		}

	$output .= '</div>';

	// Return the output
	return $output;

} add_shortcode( 'dslc_modules_section', 'dslc_modules_section_front' );

/**
 * Output front end modules area content
 *
 * @since 1.0
 */

function dslc_modules_area_front( $atts, $content = null ) {

	global $dslc_active;

	$pos_class = '';
	$module_area_size = $atts['size'];

	if ( $atts['last'] == 'yes' ) {
			$pos_class = 'dslc-last-col';
	}

	if ( isset( $atts['first'] ) && $atts['first'] == 'yes' ) {
			$pos_class = 'dslc-first-col';
	}

	$output = '<div class="dslc-modules-area dslc-col dslc-' . $atts['size'] . '-col ' . $pos_class . '" data-size="' . $atts['size'] . '">';

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

			// Management
			$output .= '<div class="dslca-modules-area-manage">
				<span class="dslca-modules-area-manage-line"></span>
				<div class="dslca-modules-area-manage-inner">
					<span class="dslca-manage-action dslca-copy-modules-area-hook" title="Duplicate" ><span class="dslca-icon dslc-icon-copy"></span></span>
					<span class="dslca-manage-action dslca-move-modules-area-hook" title="Drag to move" ><span class="dslca-icon dslc-icon-move"></span></span>
					<span class="dslca-manage-action dslca-change-width-modules-area-hook" title="Change width" >
						<span class="dslca-icon dslc-icon-columns"></span>
						<div class="dslca-change-width-modules-area-options">';
			$output .= '<span>' . __( 'Container Width', 'live-composer-page-builder' ) . '</span>';
			$output .= '<span data-size="1">1/12</span><span data-size="2">2/12</span>
							<span data-size="3">3/12</span><span data-size="4">4/12</span>
							<span data-size="5">5/12</span><span data-size="6">6/12</span>
							<span data-size="7">7/12</span><span data-size="8">8/12</span>
							<span data-size="9">9/12</span><span data-size="10">10/12</span>
							<span data-size="11">11/12</span><span data-size="12">12/12</span>
						</div>
					</span>
					<span class="dslca-manage-action dslca-delete-modules-area-hook" title="Delete" ><span class="dslca-icon dslc-icon-remove"></span></span>
				</div>
			</div>';
		}

		// Modules output
		if ( empty( $content ) || $content == ' ' ) {
					$output .= ''; //'&nbsp;';
		} else {
					$output .= do_shortcode( $content );
		}

	$output .= '</div>';

	// Return the output
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
		$template = locate_template( array($filename) );

		// If not found in theme load default
		if ( ! $template ) {
					$template = DS_LIVE_COMPOSER_ABS . $default;
		}

		load_template( $template, false );

	}

}

/**
 * Custom CSS
 *
 * @since 1.0
 */
function dslc_custom_css( $dslc_code = '' ) {

	// Allow theme developers to output CSS for non-standard custom post types.
	$dslc_custom_css_ignore_check = false;
	$dslc_custom_css_ignore_check = apply_filters( 'dslc_generate_custom_css', $dslc_custom_css_ignore_check );

	if ( $dslc_code ) {

		$dslc_custom_css_ignore_check = true;
	}

	if ( ! is_singular() &&
		 ! is_archive() &&
		 ! is_author() &&
		 ! is_search() &&
		 ! is_404() &&
		 ! is_home() &&
		 ! $dslc_custom_css_ignore_check
	) {

		return;
	}

	global $dslc_active;
	global $dslc_css_style;
	global $content_width;
	global $dslc_googlefonts_array;
	global $dslc_all_googlefonts_array;
	global $dslc_post_types;

	$composer_code = '';
	$template_code = '';

	$lc_width = dslc_get_option( 'lc_max_width', 'dslc_plugin_options' );

	if ( empty( $lc_width ) ) {

		$lc_width = $content_width . 'px';
	} else {

		if ( false === strpos( $lc_width, 'px' ) && false === strpos( $lc_width, '%' ) ) {

			$lc_width = $lc_width . 'px';
		}
	}

	// Filter $lc_width ( for devs ).
	$lc_width = apply_filters( 'dslc_content_width', $lc_width );

	if ( ! $dslc_code ) {

		$template_id = false;

		// If single, load template?
		if ( is_singular( $dslc_post_types ) ) {
			$template_id = dslc_st_get_template_id( get_the_ID() );
		}

		// If archive, load template?
		if ( is_archive() && ! is_author() && ! is_search() ) {
			$post_type = get_post_type();

			if ( $post_type && 'post' === $post_type ) {
				$post_type = 'post_archive';
			}

			$template_id = dslc_get_option( $post_type, 'dslc_plugin_options_archives' );
		}

		if ( is_author() ) {
			$template_id = dslc_get_option( 'author', 'dslc_plugin_options_archives' );
		}

		if ( is_search() ) {
			$template_id = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );
		}

		if ( is_404() ) {
			$template_id = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );
		}

		// Header/Footer.
		if ( $template_id ) {
			$header_footer = dslc_hf_get_ID( $template_id );
		} else if ( is_singular( $dslc_post_types ) ) {
			$template_id = dslc_st_get_template_id( get_the_ID() );
			$header_footer = dslc_hf_get_ID( $template_id );
		} else {
			$header_footer = dslc_hf_get_ID( get_the_ID() );
		}

		// Header.
		if ( $header_footer['header'] ) {
			$header_code = get_post_meta( $header_footer['header'], 'dslc_code', true );
			$composer_code .= $header_code;
		}

		// Footer.
		if ( $header_footer['footer'] ) {
			$footer_code = get_post_meta( $header_footer['footer'], 'dslc_code', true );
			$composer_code .= $footer_code;
		}

		// Template content.
		if ( $template_id ) {
			$composer_code .= get_post_meta( $template_id, 'dslc_code', true );
		}

		// Post/Page content.
		$post_id = get_the_ID();
		$composer_code .= get_post_meta( $post_id, 'dslc_code', true );

	} else { // ! $dslc_code.

		$composer_code = $dslc_code;
	}

	echo '<style type="text/css">';

	// If composer not used on this page stop execution?
	if ( $composer_code ) {

		// Replace shortcode names.
		$composer_code = str_replace( 'dslc_modules_section', 'dslc_modules_section_gen_css', $composer_code );
		$composer_code = str_replace( 'dslc_modules_area', 'dslc_modules_area_gen_css', $composer_code );
		$composer_code = str_replace( '[dslc_module]', '[dslc_module_gen_css]', $composer_code );
		$composer_code = str_replace( '[dslc_module ', '[dslc_module_gen_css ', $composer_code );
		$composer_code = str_replace( '[/dslc_module]', '[/dslc_module_gen_css]', $composer_code );

		// Do CSS shortcode.
		do_shortcode( $composer_code );

		// Google Fonts Import.

		$gfonts_output_subsets = '';
		$gfonts_subsets_arr = dslc_get_option( 'lc_gfont_subsets', 'dslc_plugin_options_performance' );
		if ( ! $gfonts_subsets_arr ) {
			$gfonts_subsets_arr = array('latin', 'latin-ext', 'cyrillic', 'cyrillic-ext');
		}
		foreach ( $gfonts_subsets_arr as $gfonts_subset ) {
			if ( $gfonts_output_subsets == '' ) {
				$gfonts_output_subsets .= $gfonts_subset;
			} else {
				$gfonts_output_subsets .= ',' . $gfonts_subset;
			}
		}

		if ( ! defined( 'DS_LIVE_COMPOSER_GFONTS' ) || DS_LIVE_COMPOSER_GFONTS ) {

			$gfonts_output_prepend = '@import url("//fonts.googleapis.com/css?family=';
			$gfonts_output_append = '&subset=' . $gfonts_output_subsets . '"); ';
			$gfonts_ouput_inner = '';

			$gfonts_do_output = true;

			if ( count( $dslc_googlefonts_array ) == 1 && $dslc_googlefonts_array[0] == '' ) {
				$gfonts_do_output = false;
			}

			foreach ( $dslc_googlefonts_array as $gfont ) {
				if ( in_array( $gfont, $dslc_all_googlefonts_array ) ) {
					$gfont = str_replace( ' ', '+', $gfont );
					if ( $gfont != '' ) {
						if ( $gfonts_ouput_inner == '' ) {
							$gfonts_ouput_inner .= $gfont . ':100,200,300,400,500,600,700,800,900';
						} else {
							$gfonts_ouput_inner .= '|' . $gfont . ':100,200,300,400,500,600,700,800,900';
						}
					}
				}
			}

			// Do not output empty Google font calls (when font set to an empty string)
			if ( $gfonts_do_output ) {
				$gfonts_output = $gfonts_output_prepend . $gfonts_ouput_inner . $gfonts_output_append;
				if ( $gfonts_ouput_inner != '' ) {
					echo $gfonts_output;
				}
			}
		}
	}

	// Wrapper width.
	echo '.dslc-modules-section-wrapper, .dslca-add-modules-section { width : ' . $lc_width . '; } ';

	// Initial ( default ) row CSS.
	echo dslc_row_get_initial_style();

	// Echo CSS style.
	if ( ! $dslc_active && $composer_code || ! $dslc_active && $dslc_custom_css_ignore_check ) {
		echo $dslc_css_style;
	}

	echo '</style>';

}

/**
 * Indicates were to output generated CSS for this page content.
 *
 * @return void
 */
function dslc_dynamic_css_hook() {

	$dynamic_css_location = dslc_get_option( 'lc_css_position', 'dslc_plugin_options' );
	if ( ! $dynamic_css_location ) {
		$dynamic_css_location = 'head';
	}
	if ( 'head' === $dynamic_css_location ) {
			add_action( 'wp_head', 'dslc_custom_css' );
	} else {
			add_action( 'wp_footer', 'dslc_custom_css' );
	}

} add_action( 'init', 'dslc_dynamic_css_hook' );

/**
 * Generate CSS - Modules Section
 */
function dslc_modules_section_gen_css( $atts, $content = null ) {

	return do_shortcode( $content );

} add_shortcode( 'dslc_modules_section_gen_css', 'dslc_modules_section_gen_css' );

/**
 * Generate CSS - Modules Area
 */

function dslc_modules_area_gen_css( $atts, $content = null ) {

	return do_shortcode( $content );

} add_shortcode( 'dslc_modules_area_gen_css', 'dslc_modules_area_gen_css' );

/**
 * Generate CSS - Module
 */

function dslc_module_gen_css( $atts, $settings_raw ) {

	$settings = maybe_unserialize( base64_decode( $settings_raw ) );

	// If it's an array
	if ( is_array( $settings ) ) {

		// The ID of the module
		$module_id = $settings['module_id'];

		// Check if module exists
		if ( ! dslc_is_module_active( $module_id ) ) {
					return;
		}

		// If class does not exists
		if ( ! class_exists( $module_id ) ) {
					return;
		}

		// Instanciate the module class
		$module_instance = new $module_id();

		// Get array of options
		$options_arr = $module_instance->options();

		// Load preset options if preset supplied
		$settings = apply_filters( 'dslc_filter_settings', $settings );

		// Transform image ID to URL
		global $dslc_var_image_option_bckp;
		$dslc_var_image_option_bckp = array();
		foreach ( $options_arr as $option_arr ) {

			if ( $option_arr['type'] == 'image' ) {
				if ( isset( $settings[$option_arr['id']] ) && ! empty( $settings[$option_arr['id']] ) && is_numeric( $settings[$option_arr['id']] ) ) {
					$dslc_var_image_option_bckp[$option_arr['id']] = $settings[$option_arr['id']];
					$image_info = wp_get_attachment_image_src( $settings[$option_arr['id']], 'full' );
					$settings[$option_arr['id']] = $image_info[0];
				}
			}

			// Fix css_custom value ( issue when default changed programmatically )
			if ( $option_arr['id'] == 'css_custom' && $module_id == 'DSLC_Text_Simple' && ! isset( $settings['css_custom'] ) ) {
				$settings['css_custom'] = $option_arr['std'];
			}
		}

		// Generate custom CSS
		/*
		* Changed from the next line in ver.1.0.8
		* if ( ( $module_id == 'DSLC_TP_Content' || $module_id == 'DSLC_Html' ) && ! isset( $settings['css_custom'] ) )
		* Line above was breaking styling for DSLC_TP_Content modules when used in template
		*/
		if ( $module_id == 'DSLC_Html' && ! isset( $settings['css_custom'] ) ) {
					$css_output = '';
		} elseif ( isset( $settings['css_custom'] ) && $settings['css_custom'] == 'disabled' ) {
					$css_output = '';
		} else {
					$css_output = dslc_generate_custom_css( $options_arr, $settings );
		}
	}

} add_shortcode( 'dslc_module_gen_css', 'dslc_module_gen_css' );

/**
 * Pagination for modules
 */

function dslc_post_pagination( $atts ) {

	if ( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

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

	if ( empty ( $paged ) ) { $paged = 1; }

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
								echo ( $paged == $i ) ? "<li class='dslc-active'><a href='" . get_pagenum_link( $i ) . "'>" . $i . "</a></li>" : "<li class='dslc-inactive'><a class='inactive' href='" . get_pagenum_link( $i ) . "'>" . $i . "</a></li>";
							}
						}

						if ( $paged < $pages && $showitems < $pages ) { echo "<li class='dslc-inactive'><a href='" . get_pagenum_link( $paged + 1 ) . "'>&rsaquo;</a></li>"; }
						if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) { echo "<li class='dslc-inactive'><a href='" . get_pagenum_link( $pages ) . "'>&raquo;</a></li>"; }

					} elseif ( $type == 'prevnext' ) {

						if ( $paged > 1 ) { echo "<li class='dslc-inactive dslc-fl'><a href='" . get_pagenum_link( $paged - 1 ) . "' >" . __( 'Newer', 'live-composer-page-builder' ) . "</a></li>"; }
						if ( $paged < $pages ) { echo "<li class='dslc-inactive dslc-fr'><a href='" . get_pagenum_link( $paged + 1 ) . "'>" . __( 'Older', 'live-composer-page-builder' ) . "</a></li>"; }

					}

					if ( $type == 'loadmore' ) {
						if ( $paged < $pages ) {
							echo "<li class='dslc-pagination-load-more dslc-active'><a href='" . get_pagenum_link( $paged + 1 ) . "'><span class='dslc-icon dslc-icon-refresh'></span>" . __( 'Load More Items', 'live-composer-page-builder' ) . "</a></li>";
						} else {
							echo "<li class='dslc-pagination-load-more dslc-inactive'><a href='#'><span class='dslc-icon dslc-icon-refresh'></span>" . __( 'Load More Items', 'live-composer-page-builder' ) . "</a></li>";
						}
					}

				?>
			</ul>

			<?php if ( $type == 'loadmore' ) : ?>
				<div class="dslc-load-more-temp"></div>
			<?php endif; ?>

		</div><!-- .dslc-pagination --><?php
	}

}
