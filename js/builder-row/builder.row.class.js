/**
 * Modules row class
 */

'use strict';

;jQuery(document).on('editorFrameLoaded', function(){

	var $ = jQuery;

	/**
	 * Hook - Delete Row
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-delete-modules-section-hook', function(e){

		e.preventDefault();
		var self = this;

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			DSLC.Editor.ModalWindow({
				title: DSLCString.str_del_row_title,
				content: DSLCString.str_del_row_descr,
				confirm: function() {

					dslc_row_delete( $(self).closest('.dslc-modules-section') );
				}
			})

		/*	dslc_js_confirm( 'delete_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_row_title +
				'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_row_descr + '</span>', $(this) );*/
		}
	});

	/**
	 * Hook - Import Row
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-import-modules-section-hook', function(e) {

		e.preventDefault();

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			DSLC.Editor.ModalWindow({
				title: DSLCString.str_import_row_title,
				content: DSLCString.str_import_row_descr + '<br><br><textarea></textarea>',
				confirm: function(){

					dslc_row_import( $('.dslca-prompt-modal textarea').val() );
					$('.dslca-prompt-modal-confirm-hook span').css({ opacity : 0 });
					$('.dslca-prompt-modal-confirm-hook .dslca-loading').show();
				},
				confirm_title: DSLCString.str_import
			});

			/*$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span><span>' + DSLCString.str_import +
				'</span><div class="dslca-loading followingBallsGWrap"><div class="followingBallsG_1 followingBallsG"></div>'+
				'<div class="followingBallsG_2 followingBallsG"></div><div class="followingBallsG_3 followingBallsG"></div><div class="followingBallsG_4 followingBallsG"></div></div>');

			dslc_js_confirm( 'import_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_import_row_title +
				'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_import_row_descr + ' <br><br><textarea></textarea></span>', $(this) );*/
		}
	});

	/**
	 * Hook - Export Row
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-export-modules-section-hook', function(e) {

		e.preventDefault();

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			$('.dslca-prompt-modal-cancel-hook').hide();
			$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>' + DSLCString.str_ok);

			dslc_js_confirm( 'export_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_export_row_title +
				'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_export_row_descr + ' <br><br><textarea></textarea></span>', $(this) );
			$('.dslca-prompt-modal textarea').val( dslc_generate_section_code( $(this).closest('.dslc-modules-section') ) );
		}
	});

	/**
	 * Hook - Copy Row
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-copy-modules-section-hook', function() {

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			dslc_row_copy( $(this).closest('.dslc-modules-section') );
		}
	});

	/**
	 * Hook - Add Row
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-add-modules-section-hook', function(){

		var button = $(this);

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			// Add a loading animation
			button.find('.dslca-icon').removeClass('dslc-icon-align-justify').addClass('dslc-icon-spinner dslc-icon-spin');

			// Add a row
			dslc_row_add( function(){
				button.find('.dslca-icon').removeClass('dslc-icon-spinner dslc-icon-spin').addClass('dslc-icon-align-justify');
			});
		}
	});

	/**
	 * Hook - Edit Row
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-edit-modules-section-hook', function(){

		var self = this;

		// If not disabled ( disabling used for tutorial )
		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			// If a module is being edited
			if ( jQuery('.dslca-module-being-edited.dslca-module-change-made', DSLC.Editor.frame).length ) {

				DSLC.Editor.ModalWindow({
					title: DSLCString.str_module_curr_edit_title,
					content: DSLCString.str_module_curr_edit_descr,
					confirm: function() {

						dslc_module_options_confirm_changes( function(){
							$(self).trigger('click');
						});
					},
					cancel: function() {

						dslc_module_options_cancel_changes( function(){
							$(self).trigger('click');
						});
					}
				});

				// Ask to confirm or cancel
				/*dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_module_curr_edit_title +
					'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_module_curr_edit_descr + '</span>', jQuery(this) );*/
			// If another section is being edited
			} else if ( jQuery('.dslca-modules-section-being-edited.dslca-modules-section-change-made', DSLC.Editor.frame).length ) {

				DSLC.Editor.ModalWindow({
					title: DSLCString.str_row_curr_edit_title,
					content: DSLCString.str_row_curr_edit_descr,
					confirm: function() {

						dslc_module_options_confirm_changes( function(){
							$(self).trigger('click');
						});
					},
					cancel: function() {

						dslc_module_options_cancel_changes( function(){
							$(self).trigger('click');
						});
					}
				});

				// Ask to confirm or cancel
				/*dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_row_curr_edit_title +
					'</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_row_curr_edit_descr + '</span>', jQuery(this) );*/
			// All good to proceed
			} else {

				// Trigger the function to edit
				dslc_row_edit( $(this).closest('.dslc-modules-section') );
			}
		}
	});
});