/**
 *  Basic Module class
 */

'use strict';

;jQuery(document).on('editorFrameLoaded', function(){

	var $ = jQuery;

	/**
	 * Action - Automatically Add a Row if Empty
	 */
	if ( ! jQuery( '#dslc-main .dslc-modules-section' ).length && ! jQuery( '#dslca-tut-page' ).length ) {

		dslc_row_add().then(function(row){

			var el = jQuery('.dslc-modules-area', DSLC.Editor.frame); // Groups that can hold modules

			jQuery(el).each(function (i,e) {

				new DSLC_ModuleArea(e);
			});
		});
	}

	/**
	 * Hook - Copy Module
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-copy-module-hook', function(e){

		e.preventDefault();

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			dslc_module_copy( $(this).closest('.dslc-module-front') );
		}
	});

	/**
	 * Hook - Module Delete
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-delete-module-hook', function(e){

		e.preventDefault();
		var self = this;

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			DSLC.Editor.ModalWindow({
				title: DSLCString.str_del_module_title,
				content: DSLCString.str_del_module_descr,
				confirm: function() {

					var module = jQuery(self).closest('.dslc-module-front');
					dslc_delete_module( module );
				}
			});

			/*dslc_js_confirm( 'delete_module', '<span class="dslca-prompt-modal-title">' +
				DSLCString.str_del_module_title +
				'</span><span class="dslca-prompt-modal-descr">' +
				DSLCString.str_del_module_descr + '</span>', $(this) );*/
		}
	});

	/**
	 * Hook - Edit Module On Click ( Display Options Panel )
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-module-edit-hook, .dslc-module-front > div:not(.dslca-module-manage)', function(e){

		e.preventDefault();
		var curr_module_edited = $('.dslca-module-being-edited').length;

		// If composer not hidden & not clicked on editable element
		if ( curr_module_edited == 0 && ! $('body').hasClass( 'dslca-composer-hidden' ) && ! $(e.target).hasClass( 'dslca-editable-content' ) ) {

			if(dslcDebug) console.log('dslca-module-edit-hook');

			var title = '';
			var content = '';

			// If another module being edited and has changes
			if ( $('.dslca-module-being-edited.dslca-module-change-made').length ) {

				DSLC.Editor.ModalWindow({
					title: DSLCString.str_module_curr_edit_title,
					content: DSLCString.str_module_curr_edit_descr,
					confirm: function() {

						dslc_module_options_confirm_changes( function(){
							dslcTarget.trigger('click');
						});
					},
					cancel: function() {

						dslc_module_options_cancel_changes( function(){
							$(self).trigger('click');
						});
					}
				});

				/*dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' +
					DSLCString.str_module_curr_edit_title +
					'</span><span class="dslca-prompt-modal-descr">' +
					DSLCString.str_module_curr_edit_descr + '</span>', $(this) );*/

			// If a section is being edited and has changes
			} else if ( $('.dslca-modules-section-being-edited.dslca-modules-section-change-made').length ) {

				DSLC.Editor.ModalWindow({
					title: DSLCString.str_row_curr_edit_title,
					content: DSLCString.str_row_curr_edit_descr,
					confirm: function() {

						dslc_module_options_confirm_changes( function(){
							dslcTarget.trigger('click');
						});
					},
					cancel: function() {

						dslc_module_options_cancel_changes( function(){
							$(self).trigger('click');
						});
					}
				});

				/*
				dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' +
					DSLCString.str_row_curr_edit_title +
					'</span><span class="dslca-prompt-modal-descr">' +
					DSLCString.str_row_curr_edit_descr + '</span>', $(this) );*/

			// All good, proceed
			} else {

				// If a module section is being edited but has no changes, cancel it
				if ( $('.dslca-modules-section-being-edited').length ) {
					$('.dslca-module-edit-cancel').trigger('click');
				}

				// Vars
				var dslcModule = $(this).closest('.dslc-module-front'),
				dslcModuleID = dslcModule.data('dslc-module-id'),
				dslcModuleCurrCode = dslcModule.find('.dslca-module-code').val();

				// If a module is bening edited remove the "being edited" class from it
				$('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

				// Add the "being edited" class to current module
				dslcModule.addClass('dslca-module-being-edited');

				// Call the function to display options
				dslc_module_options_show( dslcModuleID );
			}
		}
	});

	/**
	 * Action - Show/Hide Width Options
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-change-width-module-hook', function(e){

		e.preventDefault();

		if ( ! $(this).hasClass('dslca-action-disabled') ) {

			$('.dslca-change-width-module-options', this).toggle();
			$(this).closest('.dslca-module-manage').toggleClass('dslca-module-manage-change-width-active');
		}
	});

	/**
	 * Hook - Set Module Width
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-change-width-module-options span', function(){

		dslc_module_width_set( jQuery(this).closest('.dslc-module-front'), jQuery(this).data('size') );
	});

	/**
	 * Show WYSIWYG
	 */
	DSLC.Editor.frame.on( 'click', '.dslca-wysiwyg-actions-edit-hook', function(){

		var editable = jQuery(this).parent().siblings('.dslca-editable-content');
		var module = editable.closest('.dslc-module-front');

		if ( module.hasClass('dslc-module-handle-like-accordion') ) {

			dslc_accordion_generate_code( module.find('.dslc-accordion') );
			var full_content = module.find( '.dslca-module-option-front[data-id="accordion_content"]' ).val();
			var full_content_arr = full_content.split('(dslc_sep)');
			var key_value = editable.closest('.dslc-accordion-item').index();
			var content = full_content_arr[key_value].trim().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');

		} else if ( module.hasClass('dslc-module-handle-like-tabs') ) {

			dslc_tabs_generate_code( module.find('.dslc-tabs') );
			var full_content = module.find( '.dslca-module-option-front[data-id="tabs_content"]' ).val();
			var full_content_arr = full_content.split('(dslc_sep)');
			var key_value = editable.closest('.dslc-tabs-tab-content').index();
			var content = full_content_arr[key_value].trim().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');
		} else {

			var content = module.find( '.dslca-module-option-front[data-id="' + editable.data('id') + '"]' ).val().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');
		}

		if ( typeof tinymce != "undefined" ) {

			var editor = tinymce.get( 'dslcawpeditor' );

			if ( jQuery('#wp-dslcawpeditor-wrap').hasClass('tmce-active') ) {

				editor.setContent( content, {format : 'html'} );
			} else {

				jQuery('textarea#dslcawpeditor').val( content );
			}

			if ( ! module.hasClass('dslca-module-being-edited') ) {

				module.find('.dslca-module-edit-hook').trigger('click');
			}

			jQuery('.dslca-wp-editor').show();
			editable.addClass('dslca-wysiwyg-active');

			jQuery('#dslcawpeditor_ifr, #dslcawpeditor').css({ height : jQuery('.dslca-wp-editor').height() - 300 });
		}
	});

	// Editable Content
	DSLC.Editor.frame.on('blur', '.dslca-editable-content', function() {

		if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' ) && jQuery(this).data('type') == 'simple' ) {

			dslc_editable_content_gen_code( jQuery(this) );
		}
	}).on( 'paste', '.dslca-editable-content', function(){

		if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' )  && jQuery(this).data('type') == 'simple' ) {

			var dslcRealInput = jQuery(this);

			setTimeout(function(){

				if ( dslcRealInput.data('type') == 'simple' ) {
					dslcRealInput.html( dslcRealInput.text() );
				}

				dslc_editable_content_gen_code( jQuery(this) );
			}, 1);
		}
	}).on('focus', '.dslca-editable-content', function() {

		if (  jQuery(this).data('type') == 'simple' ) {

			if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' ) ) {

				if ( ! jQuery(this).closest('.dslc-module-front').hasClass('dslca-module-being-edited') ) {
					jQuery(this).closest('.dslc-module-front').find('.dslca-module-edit-hook').trigger('click');
				}
			} else {

				jQuery(this).trigger('blur');
			}
		}
	}).on('keyup', '.dslca-editable-content', function(){

		if ( jQuery(this).data('type') == 'simple' ) {
			jQuery(this).closest('.dslc-module-front').addClass('dslca-module-change-made');
		}
	});
});