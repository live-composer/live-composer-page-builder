/** Builder editor frame scripts */

;jQuery(function($){

	//After frame loaded
	jQuery("#page-builder-frame").on('load', function(){

		var self = this;
		DSLC.Editor.frame = jQuery(this).contents();
		/**
		 * Action - Automatically Add a Row if Empty
		 */

		if ( ! jQuery( '#dslc-main .dslc-modules-section' ).length && ! jQuery( '#dslca-tut-page' ).length ) {

			dslc_row_add().then(function(row){

				jQuery(row).find('.dslc-modules-area').addClass('dslc-modules-area-empty dslc-last-col');
				var pagebuilder_iframe = jQuery(self).contents();
				var el = jQuery('.dslc-modules-area', pagebuilder_iframe[0]); // Groups that can hold modules

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

			if ( ! $(this).hasClass('dslca-action-disabled') ) {

				dslc_js_confirm( 'delete_module', '<span class="dslca-prompt-modal-title">' +
					DSLCString.str_del_module_title +
					'</span><span class="dslca-prompt-modal-descr">' +
					DSLCString.str_del_module_descr + '</span>', $(this) );
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

				// If another module being edited and has changes
				if ( $('.dslca-module-being-edited.dslca-module-change-made').length ) {

					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' +
						DSLCString.str_module_curr_edit_title +
						'</span><span class="dslca-prompt-modal-descr">' +
						DSLCString.str_module_curr_edit_descr + '</span>', $(this) );

				// If a section is being edited and has changes
				} else if ( $('.dslca-modules-section-being-edited.dslca-modules-section-change-made').length ) {

					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' +
						DSLCString.str_row_curr_edit_title +
						'</span><span class="dslca-prompt-modal-descr">' +
						DSLCString.str_row_curr_edit_descr + '</span>', $(this) );

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
	});
});