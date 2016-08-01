
/*********************************
 *
 * = UTIL =
 *
 * - dslc_dm_get_defaults ( Get Alter Module Defaults Code )
 * - dslca_draggable_calc_center ( Recalculate drag and drop centering )
 * - dslc_editable_content_gen_code ( Generate code of editable content )
 *
 ***********************************/

/**
 * Other - Get Alter Module Defaults Code
 */
function dslc_dm_get_defaults( module ) {

	if ( dslcDebug ) console.log( 'dslc_dm_get_defaults' );

	// The module code value
	var optionsCode = module.find('.dslca-module-code').val();

	// Ajax call to get the plain PHP code
	jQuery.post(
		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-dm-module-defaults',
			dslc : 'active',
			dslc_modules_options : optionsCode
		},
		function( response ) {

			// Apply the plain PHP code to the textarea
			jQuery('.dslca-prompt-modal textarea').val( response.output );
		}
	);
}

/**
 * Other - Recalculate drag and drop centering
 */
/*
function dslca_draggable_calc_center( dslcArea ) {

	if ( dslcDebug ) console.log( 'dslca_draggable_calc_center' );

	jQuery( ".dslc-modules-section-inner" ).sortable( "option", "cursorAt", { top: dslcArea.outerHeight() / 2, left: dslcArea.outerWidth() / 2 } );
}
*/

/**
 * Other - Generate code of editable content
 */
function dslc_editable_content_gen_code( dslcField ) {

	if ( dslcDebug ) console.log( 'dslc_editable_content_gen_code' );

	var dslcModule, dslcContent, dslcFieldID;

	dslcModule = dslcField.closest('.dslc-module-front');
	dslcContent = dslcField.html().trim().replace(/<textarea/g, '<lctextarea').replace(/<\/textarea/g, '</lctextarea');
	dslcFieldID = dslcField.data('id');

	jQuery('.dslca-module-option-front[data-id="' + dslcFieldID + '"]', dslcModule).val( dslcContent );

	dslc_show_publish_button();
}

/**
 * Other - Document Ready
 */
jQuery(document).ready(function($){

	/**
	 * Action - Show code for altering module's defaults
	 */
	$(document).on( 'click', '.dslca-module-get-defaults-hook', function(){

		// Vars
		var module = jQuery(this).closest('.dslc-module-front');
		var code = dslc_dm_get_defaults( module );

		// Generate modal's text
		var message = '<span class="dslca-prompt-modal-title">Module Defaults</span>'
			+ '<span class="dslca-prompt-modal-descr">The code bellow is used to alter the defaults.</span>'
			+ '<textarea></textarea><br><br>';

		// Hide modal's cancel button
		$('.dslca-prompt-modal-cancel-hook').hide();

		// Show confirm button and change it to "OK"
		$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>OK');

		// Show the modal prompt
		dslc_js_confirm( 'dev_mode_get_default', message, module );
	});

	/**
	 * Action - Prevent backspace from navigating back
	 */
	$(document).unbind('keydown').bind('keydown', function (event) {

		var doPrevent = false;

		if (event.keyCode === 8) {

			var d = event.srcElement || event.target;

			if ( (d.tagName.toUpperCase() === 'INPUT' && (
					d.type.toUpperCase() === 'TEXT' ||
					d.type.toUpperCase() === 'PASSWORD' ||
					d.type.toUpperCase() === 'NUMBER' ||
					d.type.toUpperCase() === 'FILE')
				  )
				 || d.tagName.toUpperCase() === 'TEXTAREA'
				 || $(d).hasClass('dslca-editable-content')
				 || $(d).hasClass('dslc-tabs-nav-hook-title')
				 || $(d).hasClass('dslc-accordion-title') ) {

				doPrevent = d.readOnly || d.disabled;
			} else {

				doPrevent = true;
			}
		}

		if (doPrevent) {
			event.preventDefault();
		}

	});

	/**
	 * Actions - Prompt Modal on F5
	 *
	 * 116 – F5
	 * 81 + event.metaKey = CMD + R
	 */

	$(document).on( 'keydown', function(e){

		if ( e.which == 116 || ( e.which === 82 && event.metaKey ) ) {
			if ( jQuery('.dslca-save-composer-hook').offsetParent !== null || jQuery('.dslca-module-edit-save').offsetParent !== null ) {
				e.preventDefault();
				dslc_js_confirm( 'disable_lc', '<span class="dslca-prompt-modal-title">' + DSLCString.str_refresh_title +
				 '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_refresh_descr + '</span>', document.URL );
			}
		}
	});

	/**
	 * Hook - Refresh Module
	 */
	$(document).on( 'click', '.dslca-refresh-module-hook', function(e){

		jQuery(this).css({
			'-webkit-animation-name' : 'dslcRotate',
			'-moz-animation-name' : 'dslcRotate',
			'animation-name' : 'dslcRotate',
			'animation-duration' : '0.6s',
			'-webkit-animation-duration' : '0.6s',
			'animation-iteration-count' : 'infinite',
			'-webkit-animation-iteration-count' : 'infinite'
		});
		jQuery(this).closest('.dslc-module-front').addClass('dslca-module-being-edited');
		dslc_module_output_altered( function() {

			jQuery('.dslca-module-being-edited', DSLC.Editor.frame).removeClass('dslca-module-being-edited');
		});
	});
});

// Disable the prompt ( are you sure ) on refresh
window.onbeforeunload = function () { return; };

/*********************************
*
* = PENDING CLEANUP
*
*********************************/

jQuery(document).ready(function($) {

	// ROW styling option changes

	jQuery(document).on( 'change', '.dslca-modules-section-edit-field', function() {

		var dslcField, dslcFieldID, dslcEl, dslcModulesSection, dslcVal, dslcValReal, dslcValExt, dslcRule, dslcSetting, dslcTargetEl, dslcImgURL;

		dslcField = $(this);
		dslcFieldID = dslcField.data('id');
		dslcVal = dslcField.val();
		dslcValReal = dslcVal;
		dslcValExt = dslcVal + dslcField.data('ext');
		dslcRule = dslcField.data('css-rule');

		dslcEl = $('.dslca-modules-section-being-edited', DSLC.Editor.frame); // Currently editing element
		dslcTargetEl = dslcEl;
		dslcSetting = $('.dslca-modules-section-settings input[data-id="' + dslcFieldID + '"]', dslcEl );

		dslcEl.addClass('dslca-modules-section-change-made');

		// If image/upload field alter the value ( use from data )
		if ( dslcField.hasClass('dslca-modules-section-edit-field-upload') ) {

			if ( dslcVal && dslcVal.length ) {

				// dslcVal = dslcField.data('dslca-img-url');
				dslcVal = $('.dslca-modules-section-settings input[data-id="dslca-img-url"]', dslcEl ).val();
			}
		}

		if ( dslcRule == 'background-image' ) {

			dslcVal = 'url("' + dslcVal + '")';
			DSLC.Editor.frameContext.dslc_bg_video();
		}

		if ( dslcFieldID == 'bg_image_attachment' ) {

			dslcEl.removeClass('dslc-init-parallax');
		}

		if ( dslcFieldID == 'border-top' || dslcFieldID == 'border-right' || dslcFieldID == 'border-bottom' || dslcFieldID == 'border-left' ) {

			var dslcBorderStyle = $('.dslca-modules-section-settings input[data-id="border_style"]').val();
			dslcSetting = $('.dslca-modules-section-settings input[data-id="border"]', dslcEl );

			dslcValReal = '';

			var dslcChecboxesWrap = dslcField.closest('.dslca-modules-section-edit-option-checkbox-wrapper');
			dslcChecboxesWrap.find('.dslca-modules-section-edit-field-checkbox').each(function(){

				if ( $(this).is(':checked') ) {

					if ( $(this).data('id') == 'border-top' ) {

						dslcValReal += 'top ';
					} else if ( $(this).data('id') == 'border-right' ) {

						dslcValReal += 'right ';
					} else if ( $(this).data('id') == 'border-bottom' ) {

						dslcValReal += 'bottom ';
					} else if ( $(this).data('id') == 'border-left' ) {

						dslcValReal += 'left ';
					}
				}
			});

			if ( dslcField.is(':checked') ) {

				if ( dslcField.data('id') == 'border-top' ) {

					dslcEl.css({ 'border-top-style' : dslcBorderStyle });
				} else if ( dslcField.data('id') == 'border-right' ) {

					dslcEl.css({ 'border-right-style' : dslcBorderStyle });
				} else if ( dslcField.data('id') == 'border-bottom' ) {

					dslcEl.css({ 'border-bottom-style' : dslcBorderStyle });
				} else if ( dslcField.data('id') == 'border-left' ) {

					dslcEl.css({ 'border-left-style' : dslcBorderStyle });
				}

			} else {

				if ( dslcField.data('id') == 'border-top' ) {

					dslcEl.css({ 'border-top-style' : 'hidden' });
				} else if ( dslcField.data('id') == 'border-right' ) {

					dslcEl.css({ 'border-right-style' : 'hidden' });
				} else if ( dslcField.data('id') == 'border-bottom' ) {

					dslcEl.css({ 'border-bottom-style' : 'hidden' });
				} else if ( dslcField.data('id') == 'border-left' ) {

					dslcEl.css({ 'border-left-style' : 'hidden' });
				}
			}
		} else if ( dslcField.hasClass( 'dslca-modules-section-edit-field-checkbox' ) ) {

			var checkboxes = $(this).closest('.dslca-modules-section-edit-option-checkbox-wrapper').find('.dslca-modules-section-edit-field-checkbox');
			var checkboxesVal = '';
			checkboxes.each(function(){

				if ( $(this).prop('checked') ) {

					checkboxesVal += $(this).data('val') + ' ';
				}
			});

			var dslcValReal = checkboxesVal;

			/* Show On */
			if ( dslcField.data('id') == 'show_on' ) {

				if ( checkboxesVal.indexOf( 'desktop' ) !== -1 ) {

					$('.dslca-modules-section-being-edited', DSLC.Editor.frame).removeClass('dslc-hide-on-desktop');
				} else {

					$('.dslca-modules-section-being-edited', DSLC.Editor.frame).addClass('dslc-hide-on-desktop');
				}

				if ( checkboxesVal.indexOf( 'tablet' ) !== -1 ) {

					$('.dslca-modules-section-being-edited', DSLC.Editor.frame).removeClass('dslc-hide-on-tablet');
				} else {

					$('.dslca-modules-section-being-edited', DSLC.Editor.frame).addClass('dslc-hide-on-tablet');
				}

				if ( checkboxesVal.indexOf( 'phone' ) !== -1 ) {

					$('.dslca-modules-section-being-edited', DSLC.Editor.frame).removeClass('dslc-hide-on-phone');
				} else {

					$('.dslca-modules-section-being-edited', DSLC.Editor.frame).addClass('dslc-hide-on-phone');
				}

			}

		} else if ( ( dslcFieldID == 'bg_image_attachment' && dslcVal == 'parallax' ) || dslcFieldID == 'type' ) {

			if ( dslcFieldID == 'bg_image_attachment' ) {

				dslcEl.addClass( 'dslc-init-parallax' );
				DSLC.Editor.frameContext.dslc_parallax();
			} else if ( dslcFieldID == 'type' ) {

				if ( dslcVal == 'full' ) {

					dslcEl.addClass('dslc-full');
				} else {

					dslcEl.removeClass('dslc-full');
				}

				DSLC.Editor.frameContext.dslc_masonry();
			}
		} else if ( dslcFieldID == 'columns_spacing' ) {

			if ( dslcVal == 'nospacing' ) {

				dslcEl.addClass('dslc-no-columns-spacing');
			} else {

				dslcEl.removeClass('dslc-no-columns-spacing');
			}
		} else if ( dslcFieldID == 'custom_class' ) {

		} else if ( dslcFieldID == 'custom_id' ) {

		} else if ( dslcFieldID == 'bg_video' ) {

			jQuery('.dslc-bg-video video', dslcEl).remove();

			if ( dslcVal && dslcVal.length ) {

				var dslcVideoVal = dslcVal;
				dslcVideoVal = dslcVideoVal.replace( '.webm', '' );
				dslcVideoVal = dslcVideoVal.replace( '.mp4', '' );
				jQuery('.dslc-bg-video-inner', dslcEl).html('<video><source type="video/mp4" src="' + dslcVideoVal + '.mp4" /><source type="video/webm" src="' + dslcVideoVal + '.webm" /></video>');
				DSLC.Editor.frameContext.dslc_bg_video();
			}

		} else if ( dslcFieldID == 'bg_image_thumb' ) {

			if ( dslcValReal == 'enabled' ) {

				if ( jQuery('#dslca-post-data-thumb').length ) {

					var dslcThumbURL = "url('" + jQuery('#dslca-post-data-thumb').val() + "')";
					dslcTargetEl.css(dslcRule, dslcThumbURL );
				}

			} else if ( dslcValReal == 'disabled' ) {

				dslcTargetEl.css(dslcRule, 'none' );
			}
		} else {

			if ( dslcField.data('css-element') ) {

				dslcTargetEl = jQuery( dslcField.data('css-element'), dslcEl );
			}

			dslcRule = dslcRule.replace(/ /g,'').split( ',' );

			var dslcValToApply;

			if ( null != dslcField.data('ext') ) {
				dslcValToApply = dslcValExt;
			} else {
				dslcValToApply = dslcVal;
			}

			// Loop through rules (useful when there are multiple rules)
			for ( var i = 0; i < dslcRule.length; i++ ) {
				dslcTargetEl.css(dslcRule[i], dslcValToApply);
			}
		}

		// Update hidden input with new value
		dslcSetting.val( dslcValReal );

		if ( ! DSLC.Editor.flags.generate_code_after_row_changed ) return false;

		// dslc_generate_code();
		// dslc_show_publish_button();
	});


	jQuery(document).on( 'blur', '.dslc-editable-area', function(e){

		var module = $(this).closest('.dslc-module-front');
		var optionID = $(this).data('dslc-option-id');
		var optionVal = $(this).html();

		jQuery( '.dslca-module-options-front textarea[data-id="' + optionID + '"]', module ).val(optionVal);

		dslc_module_output_altered();
	});

	// Live Preview for Module Settings Change
	jQuery(document).on( 'change', '.dslca-module-edit-field', function(){

		if ( dslcDebug ) console.log( 'on change event for .dslca-module-edit-field' );

		var dslcOptionValue = '',
			dslcOptionValueOrig = '',
			dslcOption = jQuery(this),
			dslcOptionID = dslcOption.data('id'),
			dslcOptionWrap = dslcOption.closest('.dslca-module-edit-option'),
			dslcModule = jQuery('.dslca-module-being-edited', DSLC.Editor.frame),
			dslcModuleID = dslcModule.data('dslc-module-id'),
			dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule );

		// Add changed class
		dslcModule.addClass('dslca-module-change-made');

		// Hide/Show tabs in the module options panel.
		// Required to show/hide particular options tabs based on the current selection.
		// Active only for dropdowns and checkboxes.
		if ( dslcOptionWrap.hasClass('dslca-module-edit-option-select') ||
		dslcOptionWrap.hasClass('dslca-module-edit-option-checkbox') ) {

			dslc_module_options_hideshow_tabs();

		}

		/**
		 * Refresh on change = true
		 *
		 * Refresh module HTML from the server on every field value change
		 */
		if ( jQuery(this).closest('.dslca-module-edit-option').data('refresh-on-change') == 'active' ) {

			/**
			 * Get the new value
			 */

			if ( dslcOptionWrap.find('.dslca-module-edit-option-checkbox-wrapper').length ) {

				var dslcOptionChoices = jQuery('input[type="checkbox"]', dslcOptionWrap);

				dslcOptionChoices.each(function(){

					if ( $(this).prop('checked') ) {

						dslcOptionValue = dslcOptionValue + jQuery(this).val() + ' ';
					}

				});

			} else if ( dslcOption.hasClass('dslca-module-edit-option-radio') ) {

				var dslcOptionValue = jQuery('.dslca-module-edit-field:checked', dslcOption).val();
			} else {

				var dslcOptionValue = dslcOption.val();

				// Post Grid > Thumbnail: Orientation change.
				// Need to change thumbnail width to get it work as expected
				if ( dslcOptionID == 'orientation' && dslcOptionValue == 'horizontal' ) {

					var dslcSliderEl = jQuery('.dslca-module-edit-option-thumb_width .dslca-module-edit-field');
					dslcSliderEl.val('40').trigger('change');
				} else if ( dslcOptionID == 'orientation' && dslcOptionValue == 'vertical' ) {

					var dslcSliderEl = jQuery('.dslca-module-edit-option-thumb_width .dslca-module-edit-field');
					dslcSliderEl.val('100').trigger('change');
				}
			}

			/**
			 * Change old value with new value
			 */

			jQuery( '.dslca-module-options-front textarea[data-id="' + dslcOptionID + '"]', dslcModule ).val(dslcOptionValue);

			jQuery('.dslca-container-loader').show();

			dslc_module_output_altered( function(){

				jQuery('.dslca-module-being-edited', DSLC.Editor.frame).addClass('dslca-module-change-made');

				if ( dslcOptionID == 'css_load_preset' && ! jQuery('body').hasClass('dslca-new-preset-added') ) {

					dslc_module_options_show( dslcModuleID );
					jQuery('.dslca-container-loader').hide();
				} else {

					jQuery('.dslca-container-loader').hide();
				}

				jQuery('body').removeClass('dslca-new-preset-added');
			});

		/**
		 * Refresh on change = false
		 *
		 * Do not refresh from the server, but using JS
		 */
		} else {

			/**
			 * Live Preview
			 */

			if ( dslcOption.hasClass('dslca-module-edit-field-font') ) {

				var dslcFontsToLoad = dslcOption.val();
				dslcFontsToLoad = dslcFontsToLoad + ':400,100,200,300,500,600,700,800,900';

				var dslcAffectOnChangeEl = dslcOption.data('affect-on-change-el');
				var dslcAffectOnChangeRule = dslcOption.data('affect-on-change-rule');
				var dslcAffectOnChangeVal = dslcOption.val();
				var dslcAffectOnChangeValOrig = dslcAffectOnChangeVal;
				var module = jQuery(".dslca-module-being-edited", DSLC.Editor.frame);

				if ( dslcOption.val().length && dslcGoogleFontsArray.indexOf( dslcOption.val() ) !== -1  ) {

					// Call WebFont function from the iframe
					document.getElementById('page-builder-frame').contentWindow.WebFont.load({
							google: {
								families: [ dslcFontsToLoad ]
							},
							active : function(familyName, fvd) {

								if ( jQuery( '.dslca-font-loading' ).closest('.dslca-module-edit-field-font-next').length ) {

									jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-right');
								} else {

									jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-left');
								}

								jQuery( dslcAffectOnChangeEl, module).css( dslcAffectOnChangeRule , dslcAffectOnChangeVal );
							},
							inactive : function ( familyName, fvd ) {

								if ( jQuery( '.dslca-font-loading' ).closest('.dslca-module-edit-field-font-next').length ) {

									jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-right');
								} else {

									jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-left');
								}
							}
						}
					);

				} else {

					setTimeout( function(){

						if ( jQuery( '.dslca-font-loading.dslca-module-edit-field-font-next' ).length ) {

							jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-right');
						} else {

							jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-left');
						}

						jQuery( dslcAffectOnChangeEl, module ).css( dslcAffectOnChangeRule , dslcAffectOnChangeVal );
					}, 100);
				}

			/**
			 * Checkbox
			 */
			} else if ( dslcOption.hasClass('dslca-module-edit-field-checkbox') ) {

				var dslcOptionChoices = jQuery('input[type="checkbox"]', dslcOptionWrap);

				dslcOptionChoices.each(function(){

					if ( jQuery(this).prop('checked') ) {

						dslcOptionValue = dslcOptionValue + 'solid ';
						dslcOptionValueOrig = dslcOptionValueOrig + $(this).val() + ' ';
					} else {

						dslcOptionValue = dslcOptionValue + 'none ';
					}
				});
			}

			/**
			 * All other option types
			 */
			if ( ! dslcOption.hasClass('dslca-module-edit-field-font')  ) {

				var dslcExt = dslcOption.data('ext') || '';
				var dslcAffectOnChangeEl = dslcOption.data('affect-on-change-el');
				var dslcAffectOnChangeRule = dslcOption.data('affect-on-change-rule');
				var dslcAffectOnChangeVal = dslcOption.val();
				var dslcAffectOnChangeValOrig = dslcAffectOnChangeVal;

				if ( dslcOption.hasClass('dslca-module-edit-field-checkbox') ) {

					dslcAffectOnChangeVal = dslcOptionValue;
					dslcAffectOnChangeValOrig = dslcOptionValueOrig;
				}

				if ( dslcOption.hasClass('dslca-module-edit-field-image') ) {

					dslcAffectOnChangeVal = 'url("' + dslcAffectOnChangeVal + '")';
				}

				if ( ( null !== dslcAffectOnChangeVal && dslcAffectOnChangeVal.length < 1 ) && ( dslcAffectOnChangeRule == 'background-color' || dslcAffectOnChangeRule == 'background' ) ) {

					dslcAffectOnChangeVal = 'transparent';
				}

				dslcAffectOnChangeRule.split(',').forEach(function(rule){

					rule = rule.replace(/\s+/g, '');

					var module = jQuery(".dslca-module-being-edited", DSLC.Editor.frame);

					jQuery( dslcAffectOnChangeEl, module ).css( rule , dslcAffectOnChangeVal + dslcExt );
				});
			}

			/**
			 * Update option
			 */

			jQuery( '.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule ).val( dslcAffectOnChangeValOrig );
		}
	});


	// Preview Module Opt Change - Numeric
	$(document).on( 'keyup, blur', '.dslca-module-edit-field-numeric', function(){

		var dslcOptionValue = '',
			dslcOption = $(this),
			dslcOptionID = dslcOption.data('id'),
			dslcOptionWrap = dslcOption.closest('.dslca-module-edit-option'),
			dslcModule = $('.dslca-module-being-edited', DSLC.Editor.frame),
			dslcModuleID = dslcModule.data('dslc-module-id'),
			dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
			dslcAffectOnChangeEl = dslcOption.data('affect-on-change-el'),
			dslcAffectOnChangeRule = dslcOption.data('affect-on-change-rule'),
			dslcAffectOnChangeValOrig = dslcOption.val(),
			dslcAffectOnChangeVal = dslcAffectOnChangeValOrig + dslcOption.data('ext'),
			dslcAffectOnChangeRules;

		// Add changed class
		dslcModule.addClass('dslca-module-change-made');

		if ( jQuery(this).closest('.dslca-module-edit-option').data('refresh-on-change') != 'active' ) {

			/**
			 * Live Preview
			 */
			dslcAffectOnChangeRules = dslcAffectOnChangeRule.replace(/ /g,'').split( ',' );

			// Loop through rules (useful when there are multiple rules)
			for ( var i = 0; i < dslcAffectOnChangeRules.length; i++ ) {

				var module = $(".dslca-module-being-edited", DSLC.Editor.frame);
				jQuery( dslcAffectOnChangeEl, module ).css( dslcAffectOnChangeRules[i] , dslcAffectOnChangeVal );
			}

			/**
			 * Update option
			 */
			jQuery( '.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule ).val( dslcAffectOnChangeValOrig );
		}
	});

});


jQuery(document).ready(function($){

	// Uploading files
	var file_frame;

	jQuery(document).on('click', '.dslca-module-edit-field-image-add-hook, .dslca-modules-section-edit-field-image-add-hook', function(){

		var hook = jQuery(this);

		if ( hook.hasClass( 'dslca-module-edit-field-image-add-hook' ) ) {

			var field = hook.siblings('.dslca-module-edit-field-image');
			var removeHook = hook.siblings('.dslca-module-edit-field-image-remove-hook');
		} else {

			var field = hook.siblings('.dslca-modules-section-edit-field-upload');
			var removeHook = hook.siblings('.dslca-modules-section-edit-field-image-remove-hook');
		}

		// Whether or not multiple files are allowed
		var multiple = false;

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Confirm',
			},
			multiple: multiple
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {

			var attachment = file_frame.state().get('selection').first().toJSON();
			/*
			Save image ID as value of the image input.
			 */
			// field.val( attachment.id ).data( 'dslca-img-url', attachment.url ).trigger('change'); - previous version
			field.val( attachment.id );

			/*
			Save image URL as data attribute of input in dslca-modules-section-settings set
			We need URL in 'dslca-img-url' for live preview
			 */
			jQuery('.dslca-modules-section-being-edited', DSLC.Editor.frame).find('.dslca-modules-section-settings input[data-id="dslca-img-url"]').val( attachment.url );
			field.trigger('change'); // trigger change only after 'dslca-img-url' is set

			hook.hide();
			removeHook.show();
		});

		// Finally, open the modal
		file_frame.open();
	});

	jQuery(document).on('click', '.dslca-module-edit-field-image-remove-hook, .dslca-modules-section-edit-field-image-remove-hook', function(){

		var hook = jQuery(this);

		if ( hook.hasClass( 'dslca-module-edit-field-image-remove-hook' ) ) {

			var field = hook.siblings('.dslca-module-edit-field-image');
			var addHook = hook.siblings('.dslca-module-edit-field-image-add-hook');
		} else {

			var field = hook.siblings('.dslca-modules-section-edit-field-upload');
			var addHook = hook.siblings('.dslca-modules-section-edit-field-image-add-hook');
		}

		field.val('').trigger('change'); // .dslca-modules-section-edit-field
		hook.hide();
		addHook.show();
	});

	/**
	 * Confirm changes in standard WP Editor (TinyMCE) WYSIWYG
	 */

	jQuery(document).on( 'click', '.dslca-wp-editor-save-hook', function(){

		var module = jQuery('.dslca-wysiwyg-active', DSLC.Editor.frame ).closest('.dslc-module-front');

		if( typeof tinymce != "undefined" ) {

			if ( jQuery('#wp-dslcawpeditor-wrap').hasClass('tmce-active') ) {

				var editor = tinymce.get( 'dslcawpeditor' );
				var content = editor.getContent();
			} else {

				var content = jQuery('#dslcawpeditor').val();
			}

			jQuery('.dslca-wp-editor').hide();
			jQuery('.dslca-wysiwyg-active', DSLC.Editor.frame ).html( content );

			if ( module.hasClass('dslc-module-handle-like-accordion') ) {

				jQuery('.dslca-wysiwyg-active', DSLC.Editor.frame ).siblings('.dslca-accordion-plain-content').val( content );
				var dslcAccordion = module.find('.dslc-accordion');
				dslc_accordion_generate_code( dslcAccordion );
			} else if ( module.hasClass('dslc-module-handle-like-tabs') ) {

				jQuery('.dslca-wysiwyg-active', DSLC.Editor.frame ).siblings('.dslca-tab-plain-content').val( content );
				var dslcTabs = module.find('.dslc-tabs');
				dslc_tabs_generate_code( dslcTabs );
			}

			dslc_editable_content_gen_code( jQuery('.dslca-wysiwyg-active', DSLC.Editor.frame ) );
			jQuery('.dslca-wysiwyg-active', DSLC.Editor.frame ).removeClass('dslca-wysiwyg-active');
		} else {
			console.info( 'Live Composer: TinyMCE is undefined.' );
		}
	});

	/**
	 * Cancel WYSIWYG
	 */

	jQuery(document).on( 'click', '.dslca-wp-editor-cancel-hook', function(){

		$('.dslca-wp-editor').hide();
		$('.dslca-wysiwyg-active', DSLC.Editor.frame ).removeClass('dslca-wysiwyg-active');
	});
});