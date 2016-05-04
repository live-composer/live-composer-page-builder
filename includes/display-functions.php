<?php

/**
 * Table of Contents
 *
 * - dslc_display_composer (Displays the composer code in the front-end)
 * - dslc_get_modules (Returns an array of active modules)
 * - dslc_sort_alphabetically (Sorts an array alphabetically)
 * - dslc_display_modules (Displays a list of active modules)
 * - dslc_display_templates (Displays a list of active templates)
 * - dslc_filter_content (Filters the_content() to show composer output)
 * - dslc_module_front (Returns front-end output of a specific module)
 * - dslc_custom_css (Generates Custom CSS for the show page)
 */


/**
 * Display the composer panels in active editing mode
 *
 * @since 1.0
 */

function dslc_display_composer() {

	if ( ! is_user_logged_in() ) {

		return false;
	}

	global $LC_Registry;
	global $dslc_active;
	global $dslc_var_modules;

	// Reset the query (because some devs leave their queries non-reseted)
	wp_reset_query();

	// Show the composer to users who are allowed to view it
	if ( $dslc_active && is_user_logged_in() && current_user_can(DS_LIVE_COMPOSER_CAPABILITY ) ) :

		$default_section = dslc_get_option( 'lc_default_opts_section', 'dslc_plugin_options_other' );

		if ( empty( $default_section ) ){

			$default_section = 'functionality';
		}

		?>

			<div class="dslca-container dslca-state-off" data-post-id="<?php the_ID(); ?>">

				<div class="dslca-header dslc-clearfix" data-default-section="<?php echo $default_section; ?>">

					<!-- Currently Editing -->
					<span class="dslca-currently-editing"><span class="dslca-icon dslc-icon-info"></span>Currently Editing: <strong></strong></span>

					<!-- Tabs -->
					<span class="dslca-go-to-section-hook dslca-go-to-section-modules dslca-active" data-section=".dslca-modules"><span class="dslca-icon dslc-icon-list"></span></span>
					<span class="dslca-go-to-section-hook dslca-go-to-section-templates" data-section=".dslca-templates"><span class="dslca-icon dslc-icon-bookmark"></span></span>

					<!-- Module Option filters -->
					<span class="dslca-options-filter-hook" data-section="functionality"><span class="dslca-icon dslc-icon-cog"></span> <?php _e('FUNCTIONALITY', 'live-composer-page-builder'); ?></span>
					<span class="dslca-options-filter-hook" data-section="styling"><span class="dslca-icon dslc-icon-tint"></span> <?php _e('STYLING', 'live-composer-page-builder'); ?></span>
					<span class="dslca-options-filter-hook" data-section="responsive"><span class="dslca-icon dslc-icon-mobile-phone"></span> <?php _e('RESPONSIVE', 'live-composer-page-builder'); ?></span>

					<!-- Module Options Actions -->
					<div class="dslca-module-edit-actions">
						<span class="dslca-module-edit-save"><?php _e( 'CONFIRM', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-module-edit-cancel"><?php _e( 'CANCEL', 'live-composer-page-builder' ); ?></span>
					</div><!-- .dslca-module-edit-actions -->

					<!-- Row Options Filters -->
					<?php /*
					<span class="dslca-row-options-filter-hook" data-section="styling"><span class="dslca-icon dslc-icon-tint"></span> <?php _e('STYLING', 'live-composer-page-builder'); ?></span>
					<span class="dslca-row-options-filter-hook" data-section="responsive"><span class="dslca-icon dslc-icon-mobile-phone"></span> <?php _e('RESPONSIVE', 'live-composer-page-builder'); ?></span>
					*/ ?>

					<!-- Row Options Actions -->
					<div class="dslca-row-edit-actions">
						<span class="dslca-row-edit-save"><?php _e( 'CONFIRM', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-row-edit-cancel"><?php _e( 'CANCEL', 'live-composer-page-builder' ); ?></span>
					</div><!-- .dslca-row-edit-actions -->

				</div><!-- .dslca-header -->

				<div class="dslca-actions">

					<!-- Save Composer -->
					<div class="dslca-save-composer dslca-save-composer-hook">
						<span class="dslca-save-composer-helptext"><?php _e( 'PUBLISH CHANGES', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-save-composer-icon"><span class="dslca-icon dslc-icon-ok"></span></span>
					</div><!-- .dslca-save-composer -->

					<div class="dslca-save-draft-composer dslca-save-draft-composer-hook">
						<span class="dslca-save-draft-composer-helptext"><?php _e( 'SAVE AS DRAFT', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-save-draft-composer-icon"><span class="dslca-icon dslc-icon-save"></span></span>
					</div><!-- .dslca-save-draft-composer -->

					<!-- Hide/Show -->
					<span class="dslca-show-composer-hook"><span class="dslca-icon dslc-icon-arrow-up"></span><?php _e( 'SHOW EDITOR', 'live-composer-page-builder' ); ?></span>
					<span class="dslca-hide-composer-hook"><span class="dslca-icon dslc-icon-arrow-down"></span><?php _e( 'HIDE EDITOR', 'live-composer-page-builder' ); ?></span>

					<!-- Disable -->
					<a href="<?php the_permalink(); ?>" class="dslca-close-composer-hook"><span class="dslca-icon dslc-icon-remove"></span><?php _e( 'DISABLE EDITOR', 'live-composer-page-builder' ); ?></a>

					<div class="dslc-clear"></div>

				</div><!-- .dslca-actions -->

				<div class="dslca-sections">

					<!-- Modules Listing -->
					<div class="dslca-section dslca-modules" data-bg="#5890e5">

						<div class="dslca-section-title">
							<div class="dslca-section-title-filter">
								<span class="dslca-section-title-filter-curr"><?php _e( 'ALL MODULES', 'live-composer-page-builder' ); ?></span>
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
								<div class="dslca-module-edit-options-tabs"></div>
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

					<div class="dslca-section dslca-templates dslc-clearfix" data-bg="#ca564f">

						<div class="dslca-section-title">
							<?php _e( 'TEMPLATES', 'live-composer-page-builder' ); ?>
						</div><!-- .dslca-section-title -->

						<span class="dslca-go-to-section-hook" data-section=".dslca-templates-load"><span class="dslca-icon dslc-icon-circle-arrow-down"></span><?php _e( 'Load', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-open-modal-hook" data-modal=".dslca-modal-templates-save"><span class="dslca-icon dslc-icon-save"></span><?php _e( 'Save', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-open-modal-hook" data-modal=".dslca-modal-templates-import"><span class="dslca-icon dslc-icon-download-alt"></span><?php _e( 'Import', 'live-composer-page-builder' ); ?></span>
						<span class="dslca-open-modal-hook dslca-modal-template-export"><span class="dslca-icon dslc-icon-upload-alt"></span><?php _e( 'Export', 'live-composer-page-builder' ); ?></span>

						<div class="dslca-modal dslca-modal-templates-save" data-bg="#ca564f">

							<form class="dslca-template-save-form">
								<input type="text" id="dslca-save-template-title" placeholder="<?php _e('Name of the template', 'live-composer-page-builder'); ?>">
								<span class="dslca-submit"><?php _e('SAVE', 'live-composer-page-builder'); ?></span>
								<span class="dslca-cancel dslca-close-modal-hook" data-modal=".dslca-modal-templates-save"><?php _e( 'CANCEL', 'live-composer-page-builder' ); ?></span>
							</form>

						</div><!-- .dslca-modal -->

						<div class="dslca-modal dslca-modal-templates-export" data-bg="#ca564f">

							<form class="dslca-template-export-form">
								<textarea id="dslca-export-code"></textarea>
								<span class="dslca-cancel dslca-close-modal-hook" data-modal=".dslca-modal-templates-export"><?php _e( 'CLOSE', 'live-composer-page-builder' ); ?></span>
							</form>

						</div><!-- .dslca-modal -->

						<div class="dslca-modal dslca-modal-templates-import" data-bg="#ca564f">

							<form class="dslca-template-import-form">
								<textarea id="dslca-import-code" placeholder="<?php _e( 'Enter the exported code heree', 'live-composer-page-builder' ); ?>"></textarea>
								<span class="dslca-submit">
									<span class="dslca-modal-title"><?php _e( 'IMPORT', 'live-composer-page-builder' ); ?></span>
									<div class="dslca-loading followingBallsGWrap">
										<div class="followingBallsG_1 followingBallsG"></div>
										<div class="followingBallsG_2 followingBallsG"></div>
										<div class="followingBallsG_3 followingBallsG"></div>
										<div class="followingBallsG_4 followingBallsG"></div>
									</div>
								</span>
								<span class="dslca-cancel dslca-close-modal-hook" data-modal=".dslca-modal-templates-import"><?php _e( 'CANCEL', 'live-composer-page-builder' ); ?></span>
							</form>

						</div><!-- .dslca-modal -->

					</div><!-- .dslca-section-templates -->

					<!-- Module Template Load -->

					<div class="dslca-section dslca-templates-load dslc-clearfix" data-bg="#ca564f">

						<span class="dslca-go-to-section-hook dslca-section-back" data-section=".dslca-templates"><span class="dslca-icon dslc-icon-reply"></span></span>

						<div class="dslca-section-title">
							<div class="dslca-section-title-filter">
								<span class="dslca-section-title-filter-curr"><?php _e( 'ALL TEMPLATES', 'live-composer-page-builder' ); ?></span>
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
							<span class="dslca-section-scroller-prev"><span class="dslca-icon dslc-icon-angle-left"></span></span>
							<span class="dslca-section-scroller-next"><span class="dslca-icon dslc-icon-angle-right"></span></span>
						</div><!-- .dslca-section-scroller -->

					</div><!-- .dslca-templates-load -->

				</div><!-- .dslca-sections -->

				<!-- Module Template Export -->

				<textarea id="dslca-code"></textarea>
				<div class="dslca-module-options-front-backup"></div>

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
						<span class="dslca-prompt-modal-cancel-hook"><span class="dslc-icon dslc-icon-remove"></span><?php _e( 'Cancel', 'live-composer-page-builder' ); ?></span>

					</div>

				</div><!-- .dslca-prompt-modal-content -->

			</div><!-- .dslca-prompt-modal -->

			<div class="dslca-module-edit-field-icon-ttip">
				<?php _e('Icons used in this plugin are from "Font Awesome".<br><a href="http://livecomposerplugin.com/icons-listing/" class="dslca-link" target="_blank">View full list of icons.</a>', 'live-composer-page-builder'); ?>
				<span class="dslca-module-edit-field-ttip-close"><span class="dslc-icon dslc-icon-remove"></span></span>
			</div>

			<div class="dslca-module-edit-field-ttip">
				<span class="dslca-module-edit-field-ttip-close"><span class="dslc-icon dslc-icon-remove"></span></span>
				<div class="dslca-module-edit-field-ttip-inner"></div>
			</div>

			<div class="dslca-module-edit-field-icon-switch-sets">
				<?php
					global $dslc_var_icons;
					$count = 0;
					foreach ( $dslc_var_icons as $key => $value ) :
						$count++;
						?><span class="<?php echo $count == 1 ? 'dslca-active' : ''?>" data-set="<?php echo $key; ?>"><?php echo $key; ?></span><?php
					endforeach;
				?>
			</div>

			<div class="dslca-invisible-overlay"></div>

		<?php

	endif;

	global $dslc_var_templates_pt;

	// Get the position of the activation button
	$activate_button_position = dslc_get_option( 'lc_module_activate_button_pos', 'dslc_plugin_options_other' );

	if ( empty( $activate_button_position ) ){

		$activate_button_position = 'right';
	}

	// LC and WP Customizer do not work well together, don't proceed if customizer active
	if ( ( ! function_exists( 'is_customize_preview' ) || ! is_customize_preview() ) ) :

		// If editor not active and user can access the editor
		if ( ! DS_LIVE_COMPOSER_ACTIVE && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) :

			// If a singular page (posts and pages)
			if ( is_singular() ) {

				// If a page or a template go ahead normally

				if ( is_page() || get_post_type() == 'dslc_templates' || ! isset( $dslc_var_templates_pt[get_post_type()] ) ) {

					?><a href="<?php echo add_query_arg( array( 'dslc' => 'active' ), get_permalink() ); ?>" class="dslca-activate-composer-hook dslca-position-<?php echo $activate_button_position; ?>"><?php _e( 'ACTIVATE EDITOR', 'live-composer-page-builder' ); ?></a><?php

				// If not a page or a template post type
				} else {

					// Check if it has a template attached to it
					$template = dslc_st_get_template_ID( get_the_ID() );


					if ( $template ) {

						?><a target="_blank" href="<?php echo add_query_arg(array('dslc' => 'active'), get_permalink($template)); ?>" class="dslca-activate-composer-hook"><?php _e( 'EDIT TEMPLATE', 'live-composer-page-builder' ); ?></a><?php

					} else {

						?><a target="_blank" href="<?php echo admin_url( 'post-new.php?post_type=dslc_templates' ); ?>" class="dslca-activate-composer-hook"><?php _e( 'CREATE TEMPLATE', 'live-composer-page-builder' ); ?></a><?php

					}

				}

			// If a 404 page
			} elseif ( is_404() ) {

				// Get ID of the page set to power the 404 page
				$template_ID = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );

				// If there is a page that powers it
				if ( $template_ID != 'none' ) {

					// Output the button
					?><a href="<?php echo add_query_arg( array( 'dslc' => 'active' ), get_permalink( $template_ID) ); ?>" class="dslca-activate-composer-hook dslca-position-<?php echo $activate_button_position; ?>"><?php _e( 'ACTIVATE EDITOR', 'live-composer-page-builder' ); ?></a><?php

				}

			// If a search results page
			} elseif ( is_search() ) {

				// Get ID of the page set to power the search results page
				$template_ID = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );

				// If there is a page that powers it
				if ( $template_ID != 'none' ) {

					// Output the button
					?><a href="<?php echo add_query_arg( array( 'dslc' => 'active' ), get_permalink( $template_ID) ); ?>"
					 class="dslca-activate-composer-hook dslca-position-<?php echo $activate_button_position; ?>">
					 <?php _e( 'ACTIVATE EDITOR', 'live-composer-page-builder' ); ?></a><?php

				}

			// If authors archives page
			} elseif ( is_author() ) {

				// Get ID of the page set to power the author archives
				$template_ID = dslc_get_option( 'author', 'dslc_plugin_options_archives' );

				// If there is a page that powers it
				if ( $template_ID != 'none' ) {

					// Output the button
					?><a href="<?php echo add_query_arg( array( 'dslc' => 'active' ), get_permalink( $template_ID ) ); ?>"
					 class="dslca-activate-composer-hook dslca-position-<?php echo $activate_button_position; ?>">
					 <?php _e( 'ACTIVATE EDITOR', 'live-composer-page-builder' ); ?></a><?php

				}

			// If other archives (not author)
			} elseif ( is_archive() ) {

				// Get ID of the page set to power the archives of the shown post type
				$template_ID = dslc_get_option( get_post_type(), 'dslc_plugin_options_archives' );

				// If there is a page that powers it
				if ( $template_ID != 'none' ) {

					// Output the button
					?><a href="<?php echo add_query_arg(array('dslc' => 'active'), get_permalink($template_ID)); ?>" 
					class="dslca-activate-composer-hook dslca-position-<?php echo $activate_button_position; ?>">
					<?php _e( 'ACTIVATE EDITOR', 'live-composer-page-builder' ); ?></a><?php
				}
			}

		endif;

	endif;

	/// Render option templates including its files from options-templates forlder.
	/// Name of template is name of file. Accuratly.
	?>
	<?php if ( $dslc_active ) {?>
	<div class="dslc-options-templates">
	<?php
		$files = glob( DS_LIVE_COMPOSER_ABS . "/includes/options-templates/*.html" );

		foreach ( $files as $file ) {

				$type_part = explode( "/", $file );
				$type_part = array_pop( $type_part );
				$type_part = explode( ".", $type_part );

				$option_type = array_shift( $type_part );
			?>

			<script type="text/template" id="option-type-<?php echo $option_type?>">
			<?php

			if ( file_exists( $file ) ) {
				require_once $file;
			}?>
			</script>
			<?php
		}
	?>
	</div>
	<div class="dslc-modules-templates">
	<?php
		foreach ( $dslc_var_modules as $availModule ) {

			$module_front_info = array(
				'id' => $availModule['id'],
				'title' => $availModule['title'],
				'options' => $availModule['options'],
				'version' => $availModule['version'],
				'dynamic_module' => $availModule['dynamic_module']
			);
			?>
		<script>

			jQuery(document).on('DSLC_init_modules_classes', function(){

				var availModuleInfo = jQuery(".dslc-module-info-<?php echo $module_front_info['id'] ?>").html();
				var moduleInfo = DSLC.ModulesManager.ModulesInfo['<?php echo $availModule["id"]?>'] = JSON.parse(Util.b64_to_utf8(availModuleInfo));

				var <?php echo $availModule["id"]?> = function(settings){

					DSLC.BasicModule.apply(this, arguments);
				};

				extendClass(DSLC.BasicModule, <?php echo $availModule["id"]?>);
				<?php echo $availModule["id"]?>.prototype.moduleInfo = moduleInfo;


				<?php echo $availModule["id"]?>.prototype.moduleTemplate = jQuery('#module-template-<?php echo $availModule['id']?>').html();
				DSLC.ModulesManager.AvailModules['<?php echo $availModule["id"]?>'] = <?php echo $availModule["id"]?>;

				/// Remove odd code blocks
				setTimeout(function(){
					jQuery("#module-template-<?php echo $availModule['id']?>").remove();
					jQuery(".dslc-module-info-<?php echo $module_front_info['id'] ?>").remove();
				});
			});
		</script>
		<div class="dslc-module-info-block dslc-module-info-<?php echo $module_front_info['id'] ?>"><?php echo base64_encode(json_encode($module_front_info)); ?></div>
		<?php
			if(!empty($availModule['template_path']) && file_exists($availModule['template_path'])){?>

				<script type="text/template" id="module-template-<?php echo $availModule['id']?>">
					<?php
						include($availModule['template_path']);
					?>
				</script><?php
			}
		}
	?></div>

<?php
		global $dslc_googlefonts_array;
		?>
		<div class="dslc-common-options">

			<script>
			DSLC.currPostId = <?php echo get_the_ID();?>;
			DSLC.commonOptions.lc_numeric_opt_type__dslc_plugin_options_other = JSON.parse(Util.b64_to_utf8('<?php echo base64_encode(json_encode(dslc_get_option('lc_numeric_opt_type', 'dslc_plugin_options_other')))?>'));
			DSLC.commonOptions.dslc_googlefonts_array = JSON.parse(Util.b64_to_utf8('<?php echo base64_encode(json_encode($dslc_googlefonts_array))?>'));
			</script>
		</div>
		<?php
	}

} add_action('wp_footer', 'dslc_display_composer');

/**
 * Returns array of active modules (false if none)
 *
 * @since 1.0
 */

function dslc_get_modules()
{

	global $dslc_var_modules;

	if(empty($dslc_var_modules))
		return false;
	else
		return $dslc_var_modules;

}

/**
 * Sorting Function
 *
 * @since 1.0
 */

function dslc_sort_alphabetically($a, $b)
{
	return strcmp($a['title'], $b['title']);
}

/**
 * Displays a list of modules (for drag&drop)
 *
 * @since 1.0
 */

function dslc_display_modules()
{

	$dslc_modules = dslc_get_modules();

	// Get value of module listing order option
	$module_listing_order = dslc_get_option('lc_module_listing_order', 'dslc_plugin_options_other');
	if(empty($module_listing_order))
		$module_listing_order = 'original';

	// Order alphabetically if needed
	if($module_listing_order == 'alphabetic') {
		usort($dslc_modules, 'dslc_sort_alphabetically');
	}

	if($dslc_modules) {

		?>


		<div class="dslca-module dslca-scroller-item dslca-origin" data-origin="general" data-id="DSLC_M_A">
			<span class="dslca-icon dslc-icon-th-large"></span><span class="dslca-module-title"><?php _e('MODULES AREA', 'live-composer-page-builder'); ?></span>
		</div><!-- .dslc-module -->

		<?php

		foreach ( $dslc_modules as $dslc_module ) {

			if ( empty( $dslc_module['icon'] ) )
				$dslc_module['icon'] = 'circle';

			if(empty ($dslc_module['origin']))
				$dslc_module['origin'] = 'lc'

			?>
				<div class="dslca-module dslca-scroller-item dslca-origin dslca-origin-<?php echo $dslc_module['origin']; ?>" data-origin="<?php echo $dslc_module['origin']; ?>" data-id="<?php echo $dslc_module['id']; ?>">
					<span class="dslca-icon dslc-icon-<?php echo $dslc_module['icon']; ?>"></span><span class="dslca-module-title"><?php echo $dslc_module['title']; ?></span>
				</div><!-- .dslc-module -->
			<?php
		}
	} else {

		echo 'No Modules Found.';
	}
}

/**
 * Displays a list of templates
 *
 * @since 1.0
 */

function dslc_display_templates()
{
	// Get all the templates
	$templates = dslc_get_templates();

	// Array to store different types of templates
	$templates_arr = array();

	// If there are active templates
	if($templates)
	{
		// Go through all templates, popular array
		foreach ($templates as $template)
		{

			$template['section'] = strtolower( str_replace( ' ', '_', $template['section'] ) );
			$templates_arr[$template['section']][$template['id']] = $template;
		}


		// If there are templates
		if(!empty ($templates_arr))
		{

			// Go through each section
			foreach ($templates_arr as $template_section_id => $template_section_tpls) {

				// Go through each template of a section
				foreach ($templates_arr[$template_section_id] as $template) {

					?>
					<div class="dslca-template dslca-scroller-item dslca-origin dslca-template-origin-<?php echo $template_section_id; ?>" data-origin="<?php echo $template_section_id; ?>" data-id="<?php echo $template['id']; ?>">
						<span class="dslca-template-title"><?php echo $template['title']; ?></span>
						<?php if($template_section_id == 'user') : ?>
							<span class="dslca-delete-template-hook" data-id="<?php echo $template['id']; ?>">
								<span class="dslca-icon dslc-icon-trash"></span>
							</span>
						<?php endif; ?>
					</div><!-- .dslc-template -->
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
function dslc_filter_content( $content )
{
	// If post pass protected and pass not supplied return original content
	if ( post_password_required( get_the_ID() ) ) {
		return $content;
	}

	// Global variables
	global $dslc_should_filter;
	global $wp_the_query;
	global $dslc_post_types;

	// Get ID of the post in which the content filter fired
	$currID = get_the_ID();


	// Get ID of the post from the main query
	if ( isset( $wp_the_query->queried_object_id ) ) {

		$realID = $wp_the_query->queried_object_id;
	} else {

		$realID = 'nope';
	}

	// Check if we should we filtering the content
	// 1) Proceed if ID of the post in which content filter fired is same as the post ID from the main query
	// 2) Proceed if in a WordPress loop (https://codex.wordpress.org/Function_Reference/in_the_loop)
	// 3) Proceed if global var $dslc_should_filter is true
	// Irrelevant of the other 3 proceed if archives, search or 404 page
	if ( ( $currID == $realID && in_the_loop() && $dslc_should_filter ) || is_archive() || is_author() || is_search() || is_404() ) {

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
		$template_ID = false; // ID of the template that powers current post

		// Wrapping all LC elements ( unless header/footer outputed by theme )
		if ( ! defined( 'DS_LIVE_COMPOSER_HF_AUTO' ) || DS_LIVE_COMPOSER_HF_AUTO ) {
			$composer_wrapper_before = '<div id="dslc-content" class="dslc-content dslc-clearfix">';
			$composer_wrapper_after = '</div>';
		}

		// Get LC code of the current post
		$composer_code = dslc_get_code( get_the_ID() );

		// Interactive Tutorials
		$tut_page = false;
		$tut_ch_one = dslc_get_option('lc_tut_chapter_one', 'dslc_plugin_options_tuts');
		$tut_ch_two = dslc_get_option('lc_tut_chapter_two', 'dslc_plugin_options_tuts');
		$tut_ch_three = dslc_get_option('lc_tut_chapter_three', 'dslc_plugin_options_tuts');
		$tut_ch_four = dslc_get_option('lc_tut_chapter_four', 'dslc_plugin_options_tuts');

		// If current page set to be tutorial chapter one or four
		if ( get_the_ID() == $tut_ch_one || get_the_ID() == $tut_ch_four ) {

			$tut_page = true;
			$composer_code = '';

		// If current page set to be tutorial chapter two
		} elseif ( get_the_ID() == $tut_ch_two ) {
			$tut_page = true;
			$composer_code = '[dslc_modules_section type="wrapped" columns_spacing="spacing" bg_color="rgb(242, 245, 247)" bg_image_thumb="disabled" bg_image="" bg_image_repeat="repeat" bg_image_position="left top" bg_image_attachment="scroll" bg_image_size="auto" bg_video="" bg_video_overlay_color="#000000" bg_video_overlay_opacity="0" border_color="" border_width="0" border_style="solid" border="top right bottom left" margin_h="0" margin_b="0" padding="85" padding_h="0" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [/dslc_modules_area] [/dslc_modules_section] ';

		// If current page set to be tutorial chapter three
		} elseif ( get_the_ID() == $tut_ch_three ) {
			$tut_page = true;
			$composer_code = '[dslc_modules_section type="wrapped" columns_spacing="spacing" bg_color="rgb(242, 245, 247)" bg_image_thumb="disabled" bg_image="" bg_image_repeat="repeat" bg_image_position="left top" bg_image_attachment="scroll" bg_image_size="auto" bg_video="" bg_video_overlay_color="#000000" bg_video_overlay_opacity="0" border_color="" border_width="0" border_style="solid" border="top right bottom left" margin_h="0" margin_b="0" padding="85" padding_h="0" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [/dslc_modules_area] [/dslc_modules_section] ';
		}

		// If currently showing a singular post of a post type that supports "post templates"
		if ( is_singular( $dslc_post_types ) ) {

			// Get template ID set for currently shown post
			$template_ID = dslc_st_get_template_ID( get_the_ID() );

			// If template ID exists
			if ( $template_ID ) {

				// Get LC code of the template
				$composer_code = dslc_get_code( $template_ID );
			}
		}

		// If currently showing a category archive page
		if ( is_archive() && !is_author() && !is_search() ) {

			// Get ID of the page set to power the category of the current post type
			$template_ID = dslc_get_option( get_post_type(), 'dslc_plugin_options_archives' );

			// If there is a page that powers it
			if ( $template_ID ) {

				// Get LC code of the page
				$composer_code = dslc_get_code( $template_ID );
			}
		}

		// If currently showing an author archive page
		if ( is_author() ) {

			// Get ID of the page set to power the author archives
			$template_ID = dslc_get_option( 'author', 'dslc_plugin_options_archives' );

			// If there is a page that powers it
			if ( $template_ID ) {

				// Get LC code of the page
				$composer_code = dslc_get_code( $template_ID );
			}
		}

		// If currently showing a search results page
		if ( is_search() ) {

			// Get ID of the page set to power the search results page
			$template_ID = dslc_get_option('search_results', 'dslc_plugin_options_archives');

			// If there is a page that powers it
			if ( $template_ID ) {

				// Get LC code of the page
				$composer_code = dslc_get_code( $template_ID );
			}
		}

		// If currently showina 404 page
		if ( is_404() ) {

			// Get ID of the page set to power the 404 page
			$template_ID = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );

			// If there is a page that powers it
			if ( $template_ID ) {

				// Get LC code of the page
				$composer_code = dslc_get_code( $template_ID );
			}
		}

		// If currently showing a singular post of a post type which is not "dslc_hf" (used for header/footer)
		// And the constant DS_LIVE_COMPOSER_HF_AUTO is not defined or is set to false
		if ( ! is_singular( 'dslc_hf' ) && ( ! defined( 'DS_LIVE_COMPOSER_HF_AUTO' ) || DS_LIVE_COMPOSER_HF_AUTO ) ) {

			$composer_header = dslc_hf_get_header();
			$composer_footer = dslc_hf_get_footer();
		}

		// If editor is currently active clear the composer_prepend var
		if ( dslc_is_editor_active( 'access' ) ) {
			$composer_prepend = '';
		}

		// If editor is currently active generate the LC elements and store them in composer_append var
		if ( dslc_is_editor_active( 'access' ) ) {

			// Get the editor type from the settings
			$editor_type = dslc_get_option( 'lc_editor_type', 'dslc_plugin_options_other' );

			// If no editor type set in settings
			if ( empty( $editor_type ) ) {

				// Default to "both" (Visual and HTML)
				$editor_type = 'both';
			}

			// The "Add modules row" and "Import" buttons
			$composer_append = '<div class="dslca-add-modules-section">
				<span class="dslca-add-modules-section-hook"><span class="dslca-icon dslc-icon-align-justify"></span>' . __('Add Modules Row', 'live-composer-page-builder') . '</span>
				<span class="dslca-import-modules-section-hook"><span class="dslca-icon dslc-icon-download-alt"></span>' . __('Import', 'live-composer-page-builder') . '</span>
			</div>';

			// Start output fetching
			ob_start();

			?>
				<div class="dslca-wp-editor">
					<div class="dslca-wp-editor-inner">
						<?php

							if ( $editor_type == 'visual' )
								wp_editor( '', 'dslcawpeditor', array( 'quicktags' => false ) );
							else
								wp_editor( '', 'dslcawpeditor' );
						?>
						<div class="dslca-wp-editor-notification">
							<?php _e( 'Module settings are being loaded. Save/Cancel actions will appear shortly.', 'live-composer-page-builder' ); ?>
						</div><!-- .dslca-wp-editor-notification -->
						<div class="dslca-wp-editor-actions">
							<span class="dslca-wp-editor-save-hook"><?php _e( 'CONFIRM', 'live-composer-page-builder' ); ?></span>
							<span class="dslca-wp-editor-cancel-hook"><?php _e( 'CANCEL', 'live-composer-page-builder' ); ?></span>
						</div>
					</div>
				</div>
			<?php

			// Stop output fetching
			$composer_append .= ob_get_contents();
			ob_end_clean();
		}

		// If there is LC code to add to the content output
		if ( $composer_code || $template_code ) {

			// Turn the LC code into HTML code
			$composer_content = do_shortcode( $composer_code );

		// If there is header or footer LC code to add to the content output
		} elseif ( $composer_header || $composer_footer ) {

			// If editor not active
			if(!DS_LIVE_COMPOSER_ACTIVE) {

				// Pass the LC header, regular content and LC footer
				return $composer_wrapper_before . $composer_header . '<div id="dslc-theme-content"><div id="dslc-theme-content-inner">' . $content . '</div></div>' . $composer_footer . $composer_wrapper_after;

			}

		} else {

			// If editor not active
			if(!DS_LIVE_COMPOSER_ACTIVE) {

				// Pass back the original wrapped in a div (in case there's a need to style it)
				return '<div id="dslc-theme-content"><div id="dslc-theme-content-inner">' . $content . '</div></div>';
			}

		}

		// If singular post shown and has a featured image
		if(is_singular() && has_post_thumbnail(get_the_ID())) {
			// Hidden input holding value of the URL of the featured image of the shown post (used by rows for BG image)
			$composer_append .= '<input type="hidden" id="dslca-post-data-thumb" value="' . apply_filters('dslc_row_bg_featured_image', wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()))) . '" />';
		}

		// If current page is used for a tutorial
		if ( $tut_page ) {
			// Hidden input holding value of the current post ID
			$composer_append .= '<input type="hidden" id="dslca-tut-page" value="' . get_the_ID() . '" />';
		}

		// Get readable representation of the LC modules output (textual output)
		$content_for_search = '';

		if ( get_post_meta( get_the_ID(), 'dslc_content_for_search', true ) ) {

			$content_for_search = get_post_meta( get_the_ID(), 'dslc_content_for_search', true );
		}

		// If editor active include a textarea that holds readable representation of the output
		if ( DS_LIVE_COMPOSER_ACTIVE ) {
			$composer_append .= '<textarea id="dslca-content-for-search">' . $content_for_search . '</textarea>';
		}

		// Pass the filtered content output
		return $composer_wrapper_before . do_action( 'dslc_output_prepend' ) .
		$composer_header . '<div id="dslc-main">' . $composer_prepend . $composer_content . '</div>' .
		 $composer_append . $composer_footer . do_action( 'dslc_output_append' ) . $composer_wrapper_after;

	// If LC should not filter the content
	} else {

		// Pass back the original wrapped in a div (in case there's a need to style it)
		return '<div id="dslc-theme-content"><div id="dslc-theme-content-inner">' . $content . '</div></div>';

	}

} add_filter( 'the_content', 'dslc_filter_content', 101 );


/**
 * Output front end module content
 *
 * @since 1.0
 */

function dslc_module_front( $atts, $settings_raw = null )
{

	$phpSerializedSettings = true;
	$settings = maybe_unserialize( base64_decode( $settings_raw ) );
	$legSettings = $settings;


	/** LC Ferrum 1.5 start */
	if ( ! is_array( $settings ) ) {

		$settings = json_decode( base64_decode( $settings_raw ), true );
		$phpSerializedSettings = false;
	}
	/** LC Ferrum 1.5 end */


	if ( is_array( $settings ) ) {

		// The ID of the module
		$module_id = $settings['module_id'];

		// Check if active
		if ( ! dslc_is_module_active( $module_id ) )
			return;

		// If class does not exists
		if ( ! class_exists( $module_id ) )
			return;

		$class_info = new $module_id;


		/** LC Ferrum 1.5 start */
		if ( isset( $class_info->module_ver ) && $class_info->module_ver > 1 ) {

			$tempSettings = array();

			if( $phpSerializedSettings ) {

				$tempSettings['version'] = 2;
				$tempSettings['module_id'] = $settings['module_id'];
				$tempSettings['module_instance_id'] = $settings['module_instance_id'];
				$tempSettings['post_id'] = $settings['post_id'];

				unset( $settings['version'] );
				unset( $settings['module_instance_id'] );
				unset( $settings['module_id'] );
				unset( $settings['post_id'] );

				$tempSettings['propValues'] = $settings;

				$settings = $tempSettings;
				unset( $tempSettings );
			}

			if ( isset( $atts['last'] ) && $atts['last'] == 'yes' ) {
				$settings['dslc_m_size_last'] = 'yes';
			} else {
				$settings['dslc_m_size_last'] = 'no';
			}


			$cacheReset = @get_option( 'dslc_module_cache' )[$settings['module_id']] || 0;

			if ( intval( $cacheReset ) == 0 ) {

				$cacheReset = date( 'U' );
				$cacheObj = get_option( 'dslc_module_cache' );
				$cacheObj[$settings['module_id']] = $cacheReset;

				update_option( 'dslc_module_cache', $cacheObj );
			}


			if ( ! isset( $settings['cacheLastReset'] ) || $settings['cacheLastReset'] != $cacheReset ) {

				$renderSettings = $settings;
				$renderSettings['cacheLastReset'] = $cacheReset;

				$currPageCode = get_post_meta( get_the_ID(), 'dslc_code' )[0];
				$newPageCode = str_replace( $settings_raw, base64_encode( json_encode( $renderSettings) ), $currPageCode );
				update_post_meta( get_the_ID(), 'dslc_code', $newPageCode, $currPageCode );
			}

			$module_instance = new $module_id();

			/// Set image from atts
			if ( is_array ( $atts ) ) {

				$modOptions = $module_instance->options();
				$modOptsSort = [];

				foreach( $modOptions as $mod ) {

					$modOptsSort[$mod['id']] = $mod;
				}

				foreach ( $atts as $key => $attr ) {

					if ( @$modOptsSort[$key]['type'] == 'image' && @is_array( $settings['propValues'][$key] ) ) {

						$settings['propValues'][$key]['url'] = $attr;
					}
				}
			}


			/// Temporary hack for DSLC_Image
			if ( $module_id == 'DSLC_Image' && isset( $settings['propValues']['image'] ) && ! is_array( $settings['propValues']['image'] ) && intval( $settings['propValues']['image'] > 0 ) ) {

				$imgUrl = wp_get_attachment_image_src( $settings['propValues']['image'], 'full' );
				$width = @intval( $settings['propValues']['resize_width'] ) > 0 ? $settings['propValues']['resize_width'] : null;
				$height = @intval( $settings['propValues']['resize_height'] ) > 0 ? $settings['propValues']['resize_height'] : null;

				$settings['propValues']['image'] = ['id' => $settings['propValues']['image'], 'url' => dslc_aq_resize( $imgUrl[0], $width, $height, true )];
			}


			if ( DS_LIVE_COMPOSER_ACTIVE ) {

				return $module_instance->renderEditModeModule( $settings );
			}else{

				ob_start();
				$module_instance->output( $settings );
				// End output fetching
				$output = ob_get_contents();
				ob_end_clean();
				return $output;
			}
		}
		/** LC Ferrum 1.5 end */

	}else{

		return '<script>console.error(\'A module broke\');</script>';
	}

} add_shortcode( 'dslc_module', 'dslc_module_front' );

/**
 * Output front end modules area content
 *
 * @since 1.0
 */

function dslc_modules_section_front( $atts, $content = null ) {

	global $dslc_active;
	$section_style = dslc_row_get_style( $atts );
	$section_class = '';
	$overlay_style = '';

	// Columns spacing
	if ( ! isset( $atts['columns_spacing'] ) ){

		$atts['columns_spacing'] = 'spacing';
	}

	// Custom Class
	if ( ! isset($atts['custom_class'] ) ){

		$atts['custom_class'] = '';
	}

	// Show On
	if ( ! isset($atts['show_on'] ) ) {

		$atts['show_on'] = 'desktop tablet phone';
	}

	// Custom ID
	if ( ! isset($atts['custom_id'] ) ) {

		$atts['custom_id'] = '';
	}

	// Full/Wrapped
	if ( isset($atts['type'] ) && ! empty( $atts['type'] ) && $atts['type'] == 'full' ) {

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
	$bg_video = '<div class="dslc-bg-video dslc-force-show"><div class="dslc-bg-video-inner"></div><div class="dslc-bg-video-overlay" style="'. $overlay_style .'"></div></div>';

	// BG Video
	if ( isset( $atts['bg_video'] ) && $atts['bg_video'] !== '' && $atts['bg_video'] !== 'disabled' ) {

		// If it's numeric ( in the media library )
		if ( is_numeric( $atts['bg_video'] ) )
			$atts['bg_video'] = wp_get_attachment_url( $atts['bg_video'] );

		// Remove the file type extension
		$atts['bg_video'] = str_replace('.mp4', '', $atts['bg_video']);
		$atts['bg_video'] = str_replace('.webm', '', $atts['bg_video']);

		// The HTML
		$bg_video = '
		<div class="dslc-bg-video">
			<div class="dslc-bg-video-inner">
				<video>
					<source type="video/mp4" src="' . $atts['bg_video'] . '.mp4" />
					<source type="video/webm" src="' . $atts['bg_video'] . '.webm" />
				</video>
			</div>
			<div class="dslc-bg-video-overlay" style="'. $overlay_style .'"></div>
		</div>';

	}

	// No video HTML if builder innactive or no video
	if ( ! $dslc_active && $atts['bg_video'] == '' && $atts['bg_image'] == '' && isset( $atts['bg_image_thumb'] ) && $atts['bg_image_thumb'] == 'disabled' ) {
		$bg_video = '';
	}

	/**
	 * Admin Classes
	 */

	$a_container_class = '';
	$a_prepend = '';
	$a_append = '';

	if($dslc_active) {
		$a_container_class .= 'dslc-modules-section-empty ';
		$a_prepend = '<div class="dslc-modules-section-inner dslc-clearfix">';
		$a_append = '</div>';
	}

	// Columns spacing
	if($atts['columns_spacing'] == 'nospacing')
		$section_class .= 'dslc-no-columns-spacing ';

	// Custom Class
	if($atts['custom_class'] != '')
		$section_class .=  $atts['custom_class'] . ' ';

	// Show on Class
	if($atts['show_on'] != '') {

		$show_on = explode(' ', trim($atts['show_on']));

		if(!in_array('desktop', $show_on)) {
			$section_class .= 'dslc-hide-on-desktop ';
		}

		if(!in_array('tablet', $show_on)) {
			$section_class .= 'dslc-hide-on-tablet ';
		}

		if(!in_array('phone', $show_on)) {
			$section_class .= 'dslc-hide-on-phone ';
		}

	}

	// Allows devs to add classes
	$filter_classes = array();
	$filter_classes = apply_filters('dslc_row_class', $filter_classes);
	$extra_classes = '';
	if(count($filter_classes) > 0) {
		foreach ($filter_classes as $filter_class) {
			$extra_classes .= $filter_class . ' ';
		}
	}

	// Custom ID
	$section_id = false;
	if($atts['custom_id'] != '')
		$section_id =  $atts['custom_id'];

	// Custom ID - Output
	$section_id_output = '';
	if($section_id)
		$section_id_output = 'id="' . $section_id . '"';

	$output = '
		<div ' . $section_id_output . ' class="dslc-modules-section ' . $a_container_class . $parallax_class . $section_class . $extra_classes .'" style="' . dslc_row_get_style($atts) . '">

				'.$bg_video.'

				<div class="dslc-modules-section-wrapper dslc-clearfix">'
					. $a_prepend. do_shortcode( $content ) . $a_append
					. '</div>';

		if($dslc_active && is_user_logged_in() && current_user_can(DS_LIVE_COMPOSER_CAPABILITY)) {

			// Management
			$output .= '
				<div class="dslca-modules-section-manage">
					<div class="dslca-modules-section-manage-inner">
						<span class="dslca-manage-action dslca-edit-modules-section-hook"><span class="dslca-icon dslc-icon-cog"></span></span>
						<span class="dslca-manage-action dslca-copy-modules-section-hook"><span class="dslca-icon dslc-icon-copy"></span></span>
						<span class="dslca-manage-action dslca-move-modules-section-hook"><span class="dslca-icon dslc-icon-move"></span></span>
						<span class="dslca-manage-action dslca-export-modules-section-hook"><span class="dslca-icon dslc-icon-upload-alt"></span></span>
						<span class="dslca-manage-action dslca-delete-modules-section-hook"><span class="dslca-icon dslc-icon-remove"></span></span>
					</div>
				</div>
				<div class="dslca-modules-section-settings">' . dslc_row_get_options_fields($atts) . '</div>' ;

			// Loading
			$output .= '<div class="dslca-module-loading dslca-modules-area-loading"><div class="dslca-module-loading-inner"></div></div>';

		}

	$output .= '</div>';

	// Return the output
	return $output;

} add_shortcode('dslc_modules_section', 'dslc_modules_section_front');

/**
 * Output front end modules area content
 *
 * @since 1.0
 */

function dslc_modules_area_front($atts, $content = null) {

	global $dslc_active;

	$pos_class = '';
	$module_area_size = $atts['size'];

	if($atts['last'] == 'yes')
		$pos_class = 'dslc-last-col';

	if(isset($atts['first']) && $atts['first'] == 'yes')
		$pos_class = 'dslc-first-col';

	$output = '<div class="dslc-modules-area dslc-col dslc-' . $atts['size'] . '-col '. $pos_class .'" data-size="' . $atts['size'] . '">';

		if($dslc_active && is_user_logged_in() && current_user_can(DS_LIVE_COMPOSER_CAPABILITY)) {

			// Management
			$output .= '<div class="dslca-modules-area-manage">
				<span class="dslca-modules-area-manage-line"></span>
				<div class="dslca-modules-area-manage-inner">
					<span class="dslca-manage-action dslca-copy-modules-area-hook"><span class="dslca-icon dslc-icon-copy"></span></span>
					<span class="dslca-manage-action dslca-move-modules-area-hook"><span class="dslca-icon dslc-icon-move"></span></span>
					<span class="dslca-manage-action dslca-change-width-modules-area-hook">
						<span class="dslca-icon dslc-icon-columns"></span>
						<div class="dslca-change-width-modules-area-options">
							<span data-size="1">1/12</span><span data-size="2">2/12</span>
							<span data-size="3">3/12</span><span data-size="4">4/12</span>
							<span data-size="5">5/12</span><span data-size="6">6/12</span>
							<span data-size="7">7/12</span><span data-size="8">8/12</span>
							<span data-size="9">9/12</span><span data-size="10">10/12</span>
							<span data-size="11">11/12</span><span data-size="12">12/12</span>
						</div>
					</span>
					<span class="dslca-manage-action dslca-delete-modules-area-hook"><span class="dslca-icon dslc-icon-remove"></span></span>
				</div>
			</div>';

			// No content info
			$output .= '<div class="dslca-no-content">
				<span class="dslca-no-content-primary"><span class="dslca-icon dslc-icon-download-alt"></span><span class="dslca-no-content-help-text">' . __('Drop modules here', 'live-composer-page-builder') . '</span></span>
			</div>';

			// Loading
			$output .= '<div class="dslca-module-loading"><div class="dslca-module-loading-inner"></div></div>';

		}

		// Modules output
		if ( empty( $content ) || $content == ' ' )
			$output .= '&nbsp;';
		else
			$output .= do_shortcode($content);

	$output .= '</div>';

	// Return the output
	return $output;

} add_shortcode('dslc_modules_area', 'dslc_modules_area_front');

/**
 * Loads a template part
 *
 * @since 1.0
 */
function dslc_load_template( $filename, $default = '' ) {

	$template = '';

	// If filename supplied
	if($filename) {

		// Look for template in the theme
		$template = locate_template(array ($filename));

		// If not found in theme load default
		if(!$template)
			$template = DS_LIVE_COMPOSER_ABS . $default;

		load_template($template, false);

	}

}

/**
 * Custom CSS
 *
 * @since 1.0
 */

function dslc_custom_css() {



	if(!is_singular() && !is_archive() && !is_author() && !is_search() && !is_404() && !is_home())
		return;

	global $dslc_active;
	global $dslc_css_style;
	global $content_width;
	global $dslc_googlefonts_array;
	global $dslc_all_googlefonts_array;
	global $dslc_post_types;

	$composer_code = '';
	$template_code = '';

	$lc_width = dslc_get_option('lc_max_width', 'dslc_plugin_options');

	if(empty($lc_width)) {
		$lc_width = $content_width . 'px';
	} else {

		if ( strpos( $lc_width, 'px' ) === false && strpos( $lc_width, '%' ) === false ){

			$lc_width = $lc_width . 'px';
		}

	}

	// Filter $lc_width (for devs)
	$lc_width = apply_filters('dslc_content_width', $lc_width);

	$template_ID = false;

	// If single, load template
	if(is_singular($dslc_post_types)) {
		$template_ID = dslc_st_get_template_ID(get_the_ID());
	}

	// If archive, load template
	if(is_archive() && !is_author() && !is_search()) {
		$template_ID = dslc_get_option(get_post_type(), 'dslc_plugin_options_archives');
	}

	if(is_author()) {
		$template_ID = dslc_get_option('author', 'dslc_plugin_options_archives');
	}

	if(is_search()) {
		$template_ID = dslc_get_option('search_results', 'dslc_plugin_options_archives');
	}

	if(is_404()) {
		$template_ID = dslc_get_option('404_page', 'dslc_plugin_options_archives');
	}

	// Header/Footer
	if ( $template_ID ) {
		$header_footer = dslc_hf_get_ID( $template_ID );
	} else if ( is_singular( $dslc_post_types ) ) {
		$template_ID = dslc_st_get_template_ID( get_the_ID() );
		$header_footer = dslc_hf_get_ID( $template_ID );
	} else {
		$header_footer = dslc_hf_get_ID(get_the_ID());
	}

	// Header
	if($header_footer['header']) {
		$header_code = get_post_meta($header_footer['header'], 'dslc_code', true);
		$composer_code .= $header_code;
	}

	// Footer
	if($header_footer['footer']) {
		$footer_code = get_post_meta($header_footer['footer'], 'dslc_code', true);
		$composer_code .= $footer_code;
	}

	// Template content
	if($template_ID) {
		$composer_code .= get_post_meta($template_ID, 'dslc_code', true);
	}

	// Post/Page content
	$post_id = get_the_ID();
	$composer_code .= get_post_meta($post_id, 'dslc_code', true);

	echo '<style type="text/css">';

		// If composer not used on this page stop execution
		if($composer_code != ''){


			// Replace shortcode names
			$composer_code = str_replace('dslc_modules_section', 'dslc_modules_section_gen_css', $composer_code);
			$composer_code = str_replace('dslc_modules_area', 'dslc_modules_area_gen_css', $composer_code);
			$composer_code = str_replace('[dslc_module]', '[dslc_module_gen_css]', $composer_code);
			$composer_code = str_replace('[dslc_module ', '[dslc_module_gen_css ', $composer_code);
			$composer_code = str_replace('[/dslc_module]', '[/dslc_module_gen_css]', $composer_code);

			// Do CSS shortcode
			do_shortcode($composer_code);

			// Google Fonts Import

			$gfonts_output_subsets = '';
			$gfonts_subsets_arr = dslc_get_option('lc_gfont_subsets', 'dslc_plugin_options_performance');
			if(!$gfonts_subsets_arr) $gfonts_subsets_arr = array('latin', 'latin-ext', 'cyrillic', 'cyrillic-ext');
			foreach ($gfonts_subsets_arr as $gfonts_subset) {
				if($gfonts_output_subsets == '') {
					$gfonts_output_subsets .= $gfonts_subset;
				} else {
					$gfonts_output_subsets .= ',' . $gfonts_subset;
				}
			}

			if ( ! defined( 'DS_LIVE_COMPOSER_GFONTS' ) || DS_LIVE_COMPOSER_GFONTS ) {

				$gfonts_output_prepend = '@import url("//fonts.googleapis.com/css?family=';
				$gfonts_output_append = '&subset=' . $gfonts_output_subsets . '"); ';
				$gfonts_ouput_inner = '';
				foreach ($dslc_googlefonts_array as $gfont) {
					if(in_array($gfont, $dslc_all_googlefonts_array)) {
						$gfont = str_replace(' ', '+', $gfont);
						if($gfont != '') {
							if($gfonts_ouput_inner == '') {
								$gfonts_ouput_inner .= $gfont . ':100,200,300,400,500,600,700,800,900';
							} else {
								$gfonts_ouput_inner .= '|' . $gfont . ':100,200,300,400,500,600,700,800,900';
							}
						}
					}
				}
				$gfonts_output = $gfonts_output_prepend . $gfonts_ouput_inner . $gfonts_output_append;
				if($gfonts_ouput_inner != '') echo $gfonts_output;

			}

		}

		// Wrapper width
		echo '.dslc-modules-section-wrapper, .dslca-add-modules-section { width : ' . $lc_width . '; } ';

		// Initial (default) row CSS
		echo dslc_row_get_initial_style();

		// Echo CSS style
		if ( ! $dslc_active && $composer_code )
			echo $dslc_css_style;

	echo '</style>';


}

function dslc_dynamic_css_hook() {

	$dynamic_css_location = dslc_get_option( 'lc_css_position', 'dslc_plugin_options' );
	if ( ! $dynamic_css_location ) $dynamic_css_location = 'head';
	if ( $dynamic_css_location == 'head' )
		add_action( 'wp_head', 'dslc_custom_css' );
	else
		add_action( 'wp_footer', 'dslc_custom_css' );

} add_action('init', 'dslc_dynamic_css_hook');

/**
 * Generate CSS - Modules Section
 */

function dslc_modules_section_gen_css($atts, $content = null) {

	return do_shortcode($content);

} add_shortcode('dslc_modules_section_gen_css', 'dslc_modules_section_gen_css');

/**
 * Generate CSS - Modules Area
 */

function dslc_modules_area_gen_css($atts, $content = null) {

	return do_shortcode($content);

} add_shortcode('dslc_modules_area_gen_css', 'dslc_modules_area_gen_css');

/**
 * Generate CSS - Module
 */

function dslc_module_gen_css($atts, $settings_raw) {

	$settings = maybe_unserialize(base64_decode($settings_raw));

	/** LC Ferrum 1.5 start */
	if(!is_array($settings)){

		$settings = json_decode(base64_decode($settings_raw), true);
		$settings = array_merge($settings, $settings['propValues']);
	}
	/** LC Ferrum 1.5 end */

	// If it's an array
	if ( is_array( $settings ) ) {

		// The ID of the module
		$module_id = $settings['module_id'];

		// Check if module exists
		if(!dslc_is_module_active($module_id))
			return;

		// If class does not exists
		if(!class_exists($module_id))
			return;

		// Instanciate the module class
		$module_instance = new $module_id();

		// Get array of options
		$options_arr = $module_instance->options();

		// Load preset options if preset supplied
		$settings = apply_filters('dslc_filter_settings', $settings);

		// Transform image ID to URL
		global $dslc_var_image_option_bckp;
		$dslc_var_image_option_bckp = array();
		foreach ($options_arr as $option_arr) {

			if($option_arr['type'] == 'image') {
				if(isset($settings[$option_arr['id']]) && !empty($settings[$option_arr['id']]) && is_numeric($settings[$option_arr['id']])) {
					$dslc_var_image_option_bckp[$option_arr['id']] = $settings[$option_arr['id']];
					$image_info = wp_get_attachment_image_src($settings[$option_arr['id']], 'full');
					$settings[$option_arr['id']] = $image_info[0];
				}
			}

			// Fix css_custom value (issue when default changed programmatically)
			if($option_arr['id'] == 'css_custom' && $module_id == 'DSLC_Text_Simple' && !isset($settings['css_custom'])) {
				$settings['css_custom'] = $option_arr['std'];
			}

		}

		// Generate custom CSS
		if(($module_id == 'DSLC_TP_Content' || $module_id == 'DSLC_Html') && !isset($settings['css_custom']))
			$css_output = '';
		elseif(isset($settings['css_custom']) && $settings['css_custom'] == 'disabled')
			$css_output = '';
		else{
			dslc_generate_custom_css( $options_arr, $settings );
		}

	}

} add_shortcode('dslc_module_gen_css', 'dslc_module_gen_css');

/**
 * Pagination for modules
 */

function dslc_post_pagination( $atts ) {

	if( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

	if(!isset($atts['force_number'])) $force_number = false; else $force_number = $atts['force_number'];
	if(!isset($atts['pages'])) $pages = false; else $pages = $atts['pages'];
	if(!isset($atts['type'])) $type = 'numbered'; else $type = $atts['type'];
	$range = 2;

	$showitems = ($range * 2)+1;

	if(empty ($paged)) { $paged = 1; }

	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages) {
			$pages = 1;
		}
	}

	if(1 != $pages) {

		?>
		<div class="dslc-pagination dslc-pagination-type-<?php echo $type; ?>">
			<ul class="dslc-clearfix">
				<?php

					if($type == 'numbered') {

						if($paged > 2 && $paged > $range+1 && $showitems < $pages) { echo "<li class='dslc-inactive'><a href='".get_pagenum_link(1)."'>&laquo;</a></li>"; }
						if($paged > 1 && $showitems < $pages) { echo "<li class='dslc-inactive'><a href='".get_pagenum_link($paged - 1)."' >&lsaquo;</a></li>"; }

						for ($i=1; $i <= $pages; $i++){
							if(1 != $pages &&(!($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems)){
								echo ($paged == $i)? "<li class='dslc-active'><a href='".get_pagenum_link($i)."'>".$i."</a></li>":"<li class='dslc-inactive'><a class='inactive' href='".get_pagenum_link($i)."'>".$i."</a></li>";
							}
						}

						if ($paged < $pages && $showitems < $pages) { echo "<li class='dslc-inactive'><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>"; }
						if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) { echo "<li class='dslc-inactive'><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>"; }

					} elseif($type == 'prevnext') {

						if($paged > 1 ) { echo "<li class='dslc-inactive dslc-fl'><a href='".get_pagenum_link($paged - 1)."' >" . __( 'Newer', 'live-composer-page-builder' ) . "</a></li>"; }
						if ($paged < $pages ) { echo "<li class='dslc-inactive dslc-fr'><a href='".get_pagenum_link($paged + 1)."'>" . __( 'Older', 'live-composer-page-builder' ) . "</a></li>"; }

					}

					if ( $type == 'loadmore' ) {
						if ($paged < $pages ) {
							echo "<li class='dslc-pagination-load-more dslc-active'><a href='".get_pagenum_link($paged + 1)."'><span class='dslc-icon dslc-icon-refresh'></span>" . __( 'LOAD MORE ITEMS', 'live-composer-page-builder' ) . "</a></li>";
						} else {
							echo "<li class='dslc-pagination-load-more dslc-inactive'><a href='#'><span class='dslc-icon dslc-icon-refresh'></span>" . __('LOAD MORE ITEMS', 'live-composer-page-builder') . "</a></li>";
						}
					}

				?>
			</ul>

			<?php if($type == 'loadmore') : ?>
				<div class="dslc-load-more-temp"></div>
			<?php endif; ?>

		</div><!-- .dslc-pagination --><?php
	}

}