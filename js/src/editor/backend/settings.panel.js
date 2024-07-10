/**
 * Builder settings panel functions providing work with modules
 */
import { showSection } from './uigeneral.js';
import { moduleOutputAltered } from './module.js';
import { updatePreset } from "./presets.js";
import { hideModal } from "./modalwindow.js";

var dslcRegularFontsArray = window.DSLCFonts.regular;
var dslcGoogleFontsArray = window.DSLCFonts.google;
var dslcAllFontsArray = dslcRegularFontsArray.concat( dslcGoogleFontsArray );

// Set current/default icons set
var dslcIconsCurrentSet = window.DSLCIcons.fontawesome;

/**
 * Modules - Document Ready
 */

jQuery(document).ready(function($){
	dslc_module_options_tooltip();
	window.dslc_module_options_font();
	dslc_module_options_icon();
	dslc_module_options_icon_returnid()
	dslc_module_options_text_align();
	dslc_module_options_checkbox();
	dslc_module_options_box_shadow();
	dslc_module_options_text_shadow();

	/* Initiate all the color picker controls on the module/section options panel. */
	var dslca_options_with_colorpicker = '';
	dslca_options_with_colorpicker += '.dslca-module-edit-field-colorpicker';
	dslca_options_with_colorpicker += ', .dslca-modules-section-edit-field-colorpicker';
	dslca_options_with_colorpicker += ', .dslca-module-edit-option-box-shadow-color';
	dslca_options_with_colorpicker += ', .dslca-module-edit-option-text-shadow-color';

	// Init color picker on click only to not polute DOM with unwanted elements.
	// It will fire only once (first time) as color picker then put it's own listeners.
	jQuery(document).on('click', dslca_options_with_colorpicker, function() {

		// Call the color picker init function.
		dslc_module_options_color( this );

		// Make sure the color picker popup appears in the right place.
		var wrapper = jQuery( this ).closest('.dslca-color-option');
		var optionsPanel = jQuery( '.dslca-module-edit-options-inner');
		var colorpicker = wrapper.find('.wp-picker-holder');
		var offset = wrapper.offset();
		var offsetPopup = offset.left + 15;
		var windoWidth = window.innerWidth;
		var popupWidth = 260;

		if ( windoWidth < offsetPopup + popupWidth ) {
			offsetPopup = windoWidth - popupWidth;
		}

		// Set the right position for the color picker popup on first click.
		colorpicker.css('left', offsetPopup + 'px' );

		// Update position left for the color picker on options scroll.
		jQuery(optionsPanel).on('scroll', function(event) {
			offset = wrapper.offset();
			var offsetPopup = offset.left + 15;
			var windoWidth = window.innerWidth;
			var popupWidth = 260;

			if ( windoWidth < offsetPopup + popupWidth ) {
				offsetPopup = windoWidth - popupWidth;
			}

			colorpicker.css('left', offsetPopup + 'px' );
		});
	});

	/* Initiate all the slider controls on the module options panel. */
	jQuery('.dslca-container').on('mouseenter', '.dslca-module-edit-option-slider', function() {

		// Fixed: https://github.com/live-composer/live-composer-page-builder/issues/740
		if ( ! jQuery(this).hasClass( 'dslca-module-edit-option-select' ) ) {
        	dslc_module_options_numeric( this );
		}
	});

	/* Initiate all the slider controls on the row options panel. */
	jQuery('.dslca-container').on('mouseenter', '.dslca-modules-section-edit-option-slider', function() {

		dslc_module_options_numeric( this );
	});

	/**
	 * Hook - Submit
	 */
	jQuery('.dslca-module-edit-form').submit( function(e){
		e.preventDefault();
		moduleOutputAltered();
	});

	/**
	 * Hook - Tab Switch
	 */
	jQuery(document).on( 'click', '.dslca-module-edit-options-tab-hook', function(e){
		e.preventDefault();
		elementOptionsTabs( jQuery(this) );
	});

	/**
	 * Hook - Reset Responsive Settings
	 */
	 jQuery(document).on( 'click', '.dslca-clear-responsive-options', function(e){
		e.preventDefault();
		resetResponsiveOptions();
	});

	/**
	 * Hook - Option Section Switch
	 */
	jQuery(document).on( 'click', '.dslca-options-filter-hook', function(e){

		e.preventDefault();

		var dslcPrev = jQuery('.dslca-options-filter-hook.dslca-active').data('section');
		var currentSection = jQuery(this).data('section');

		jQuery('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');
		jQuery(this).addClass('dslca-active');

		jQuery('.dslca-container-loader')
		document.querySelector( '.dslca-container' ).dataset.currentSection = currentSection;

		dslc_module_options_section_filter( currentSection );

		// If previous was responsive reload module
		if ( dslcPrev == 'responsive' ) {
			// Show the loader
			jQuery('.dslca-container-loader').show();

			// Reset the responsive classes
			window.LiveComposer.Builder.PreviewAreaWindow.dslc_responsive_classes();

			// Reload Module
			moduleOutputAltered(function(){
				// Hide the loader
				jQuery('.dslca-container-loader').hide();
			});

			/**
			 * Destroy resizable preview functionality
			 * when leaving Responsive view.
			 */
			jQuery('#page-builder-preview-area').resizable('destroy').attr('style','');
		}

		/**
		 * Make the preview area resizable
		 * when entering Responsive view.
		 */
		if ( currentSection == 'responsive' ) {
			jQuery('#page-builder-preview-area').resizable();
		}
	});

	/**
	 * Hook - Confirm Changes
	 */
	jQuery(document).on( 'click', '.dslca-module-edit-save', function(e){
		e.preventDefault();

		dslc_module_options_confirm_changes(function(){

			// window.LiveComposer.Builder.UI.initInlineEditors({withRemove:true});
			window.LiveComposer.Builder.UI.unloadOptionsDeps();
			window.LiveComposer.Builder.Flags.panelOpened = false;

			jQuery("body", window.LiveComposer.Builder.PreviewAreaDocument).removeClass('module-editing-in-progress');

		});

		jQuery('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');

		dslc_disable_responsive_view();

	});

	/**
	 * Hook - Cancel Changes
	 */
	jQuery(document).on( 'click', '.dslca-module-edit-cancel', function(e){

		e.preventDefault();

		dslc_module_options_cancel_changes(function(){

			// window.LiveComposer.Builder.UI.initInlineEditors({withRemove:true});
			window.LiveComposer.Builder.UI.unloadOptionsDeps();
			window.LiveComposer.Builder.Flags.panelOpened = false;

			jQuery("body", window.LiveComposer.Builder.PreviewAreaDocument).removeClass('module-editing-in-progress');

		});

		jQuery('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');

		dslc_disable_responsive_view();
	});
});

/* Editor scripts */
export const settingsPanelInit = () => {
	var self = window.LiveComposer.Builder;
	window.LiveComposer.Builder.Helpers.colorpickers = [];
/*
	window.LiveComposer.Builder.UI.initInlineEditors = function(params){
		params = params || {};

		if ( params.withRemove == true ) {
			try {
				window.LiveComposer.Builder.PreviewAreaWindow.tinyMCE.remove();
			} catch(err) {
				console.info( 'No tinyMCE code found. Error code: 10181116.' );
			}
		}

		window.LiveComposer.Builder.PreviewAreaWindow.tinyMCE.init({
			selector: '.inline-editor.dslca-editable-content',
			editor_deselector: 'mce-content-body',
			menubar: false,
			inline: true,
			plugins: 'wordpress wplink lists paste',
			paste_as_text: true, // Paste styled text as plain text only. Requires 'paste' in plugins.
			paste_block_drop: true, // Disabled drop action for inline editor to prevent js errors in the console. http://archive.tinymce.com/wiki.php/Plugin3x:paste
			style_formats: [
					{title: 'Paragraph', format: 'p'},
					{title: 'Header 1', format: 'h1'},
					{title: 'Header 2', format: 'h2'},
					{title: 'Header 3', format: 'h3'},
					{title: 'Header 4', format: 'h4'},
					{title: 'Header 5', format: 'h5'},
					{title: 'Header 6', format: 'h6'},
			  ],
			toolbar: 'styleselect | bold italic blockquote | removeformat | bullist numlist '
		});
	}
*/
	/* Destroy instanced of sliders, color pickers and other temporary elements */
	window.LiveComposer.Builder.UI.clearUtils = function() {

		if ( window.dslcDebug ) console.log( 'window.LiveComposer.Builder.UI.clearUtils' );

		// Destroy all Color Pickers
		window.LiveComposer.Builder.UI.clearColorPickers();

		// Delete module backups form memory.
		if ( undefined !== window.LiveComposer.Builder.moduleBackup ) {
			window.LiveComposer.Builder.moduleBackup.remove();
		}

		jQuery('.temp-styles-for-module', window.LiveComposer.Builder.PreviewAreaDocument).remove();

		// Hide inline editor panel if on [Confirm] or [Cancel] button click.
		jQuery('.mce-tinymce', window.LiveComposer.Builder.PreviewAreaDocument).hide();
	}

	window.LiveComposer.Builder.UI.clearColorPickers = function() {

		if ( Array.isArray(self.Helpers.colorpickers ) ) {

			self.Helpers.colorpickers.forEach(function(item){
				// Do not delete color picker instance from row settings panel,
				// as it stays on page and not get loaded via Ajax.
				if ( ! jQuery(item).hasClass('dslca-modules-section-edit-field') ) {
					// Destroy color picker instance.
					jQuery(item).remove();
				}
			});

			self.Helpers.colorpickers = [];
		}

		// Delete the color picker events.
		jQuery( 'body' ).off( 'click.wpcolorpicker' );
	}

	/** Options dependencies */
	window.LiveComposer.Builder.Helpers.depsHandlers = [];

	window.LiveComposer.Builder.UI.loadOptionsDeps = function() {
		var self = this;

		jQuery(".dslca-module-edit-option").each(function(){

			var elem = this;
			var parsed = true;

			try {
				var dep = JSON.parse( LiveComposer.Utils.b64_to_utf8( jQuery(this).data('dep') ) );
			} catch(e){
				parsed = false;
			}

			if ( parsed ) {
				var handler = function(){
					var optElem = this;
					var localDep = {};

					if ( ( optElem.type == 'radio' || optElem.type == 'checkbox' ) && dep[ optElem.value ] == undefined ) {
						return false;
					}

					if ( optElem.type == 'checkbox' && dep[ optElem.value ] != undefined ) {
						localDep[ optElem.value ] = dep[ optElem.value ];
					} else {
						localDep = dep;
					}

					Object.keys(localDep).forEach(function(opt_val){
						localDep[ opt_val ].split(',').forEach(function(item){
							var opt_wrap = jQuery(".dslca-module-edit-option-" + item.trim()).closest('.dslca-module-edit-option');
							var checkedCheckbox = true;

							if ( optElem.type == 'radio' || optElem.type == 'checkbox' ) {
								checkedCheckbox = jQuery(optElem).is(":checked");
							}

							var section_tab = jQuery('.dslca-module-edit-options-tab-hook.dslca-active').data('id');

							if ( optElem.value == opt_val && checkedCheckbox ) {
								if ( opt_wrap.not( ".dependent" ) ) {
									opt_wrap.addClass('dependent');
								}

								if ( opt_wrap.hasClass('dep-hide') ) {
									opt_wrap.removeClass('dep-hide');
									opt_wrap.addClass('dep-show');
								} else {
									opt_wrap.addClass('dep-show');
								}

								if ( section_tab == opt_wrap.data('tab') ) {
									opt_wrap.show();
								}
							} else {
								if ( opt_wrap.not( ".dependent" ) ) {
									opt_wrap.addClass('dependent');
								}

								if ( opt_wrap.hasClass('dep-show') ) {
									opt_wrap.removeClass('dep-show');
									opt_wrap.addClass('dep-hide');
								} else {
									opt_wrap.addClass('dep-hide');
								}

								opt_wrap.hide();
							}
						});
					});
				}

				jQuery(document).on('change dslc-init-deps', '.dslca-module-edit-option > *[data-id="' + jQuery(this).data('id') + '"]', handler);
				window.LiveComposer.Builder.Helpers.depsHandlers.push( handler );
			}
		});

		jQuery(".dslca-module-edit-option input, .dslca-module-edit-option select").trigger('dslc-init-deps');
	}

	window.LiveComposer.Builder.UI.unloadOptionsDeps = function() {

		window.LiveComposer.Builder.Helpers.depsHandlers.forEach(function(handler){

			jQuery(document).unbind( 'change', handler );
			jQuery(document).unbind( 'dslc-init-deps', handler );
		});

		window.LiveComposer.Builder.Helpers.depsHandlers = [];
	}

	/**
	 * Creates inline style tag when editing WYSWIG
	 *
	 * @param  {object} params
	 *    params.rule
	 *    params.elems
	 *    params.module_id
	 */
	window.LiveComposer.Builder.Helpers.processInlineStyleTag = function( params ) {

		if ( typeof params != 'object' ) return false;

		var resp_prefix = '', resp_postfix = '';

		if ( params.context.closest(".dslca-module-edit-option").data('tab') == 'tablet_responsive' ) {

			resp_prefix = '@media only screen and (max-width: 1024px) and (min-width: 768px) {';
			resp_postfix = '}';
		} else if ( params.context.closest(".dslca-module-edit-option").data('tab') == 'phone_responsive' ) {

			resp_prefix = '@media only screen and (max-width: 767px) {';
			resp_postfix = '}';
		}

		params.styleContent = resp_prefix + params.styleContent + resp_postfix;

		var id = resp_prefix + params.rule + params.elems;
		id = id.replace(/ /gi, '');

		if ( window.LiveComposer.Builder.PreviewAreaDocument[0].getElementById(id) == null ) {

			var styleTag = document.createElement('style');
			styleTag.innerHTML = params.styleContent;
			styleTag.id = id;
			styleTag.className = "temp-styles-for-module";

			window.LiveComposer.Builder.PreviewAreaDocument[0].body.appendChild(styleTag);
		} else {

			window.LiveComposer.Builder.PreviewAreaDocument[0].getElementById(id).innerHTML = params.styleContent;
		}
	}

	window.LiveComposer.Builder.UI.shakePanelConfirmButton = function() {

		jQuery('.dslca-module-edit-save').addClass('lc-shake-effect active');

		setTimeout(function(){

			jQuery('.dslca-module-edit-save').removeClass('lc-shake-effect active');
		}, 1000);
	};

	onModuleOptionsChange();
	onSectionOptionsChange();
	onFileUploadOptionsChange();
};

const onModuleOptionsChange = () => {
	// Live Preview for Module Settings Change
	jQuery(document).on( 'change', '.dslca-module-edit-field', function(){
		if ( window.dslcDebug ) console.log( 'on change event for .dslca-module-edit-field' );

		var dslcOptionValue = '',
			dslcOptionValueOrig = '',
			dslcOption = jQuery(this),
			dslcOptionID = dslcOption.data('id'),
			dslcOptionWrap = dslcOption.closest('.dslca-module-edit-option'),
			dslcModule = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument),
			dslcModuleID = dslcModule.data('module'),
			dslcModuleOptions = jQuery.find( '.dslca-module-options-front textarea', dslcModule );

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
					if ( jQuery(this).prop('checked') ) {
						dslcOptionValue = dslcOptionValue + jQuery(this).val() + ' ';
					}
				});
			} else if ( dslcOption.hasClass('dslca-module-edit-option-radio') ) {
				var dslcOptionValue = jQuery.find('.dslca-module-edit-field:checked', dslcOption).val();
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

			if ( undefined !== dslcOptionValue && null !== dslcOptionValue ) {
				dslcOptionValue = dslcOptionValue.trim().replace(/<textarea/g, '<lctextarea').replace(/<\/textarea/g, '</lctextarea');
			}

			if ( null === dslcOptionValue ) {
				dslcOptionValue = '';
			}

			jQuery( '.dslca-module-options-front textarea[data-id="' + dslcOptionID + '"]', dslcModule ).val(dslcOptionValue);
			jQuery('.dslca-container-loader').show();

			moduleOutputAltered( function(){

				jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).addClass('dslca-module-change-made');

				if ( dslcOptionID == 'css_load_preset' && ! jQuery('body').hasClass('dslca-new-preset-added') ) {

					window.dslc_module_options_show( dslcModuleID );
					jQuery('.dslca-container-loader').hide();
				} else {

					jQuery('.dslca-container-loader').hide();
				}

				jQuery('body').removeClass('dslca-new-preset-added');


				// Trigger 'LC.moduleChange' event.
				// This event can be used by 3-rd party developers to re-init
				// some of the JavaScript code on modure re-rendering.
				LiveComposer.Utils.publish( 'LC.moduleChange', {
					moduleId: dslcModuleID,
					optionID: dslcOptionID,
					optionVal: dslcOption.val()
				});
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
				var module = jQuery(".dslca-module-being-edited", LiveComposer.Builder.PreviewAreaDocument);

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

								var elems = dslcAffectOnChangeEl.split(',');
								var styleContent = "#" + module[0].id + " " + elems.join(", #" + module[0].id + " ") + " {" + dslcAffectOnChangeRule + ": " + dslcAffectOnChangeVal + "}";

								LiveComposer.Builder.Helpers.processInlineStyleTag({

									context: dslcOption,
									rule: dslcAffectOnChangeRule,
									elems: dslcAffectOnChangeEl,
									styleContent: styleContent
								});
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

						var elems = dslcAffectOnChangeEl.split(',');
						var styleContent = "#" + module[0].id + " " + elems.join(", #" + module[0].id + " ") + " {" + dslcAffectOnChangeRule + ": " + dslcAffectOnChangeVal + "}";

						LiveComposer.Builder.Helpers.processInlineStyleTag({

							context: dslcOption,
							rule: dslcAffectOnChangeRule,
							elems: dslcAffectOnChangeEl,
							styleContent: styleContent
						});
					}, 100);
				}

			/**
			 * Checkbox
			 */
			} else if ( dslcOption.hasClass('dslca-module-edit-field-checkbox') ) {

				var dslcOptionChoices = jQuery('input[type="checkbox"]', dslcOptionWrap);

				dslcOptionChoices.each(function(){

					/*
					@todo This function is specific to borders. Needs review.
					 */

					if ( jQuery(this).prop('checked') ) {

						dslcOptionValue = dslcOptionValue + 'solid ';
						dslcOptionValueOrig = dslcOptionValueOrig + jQuery(this).val() + ' ';
					} else {

						dslcOptionValue = dslcOptionValue + 'none ';
					}
				});

				// Here dslcOptionValue will look like: none none none solid.
			}

			/**
			 * All other option types
			 */
			if ( ! dslcOption.hasClass('dslca-module-edit-field-font') &&
					dslcOption.data('affect-on-change-el') != null &&
					dslcOption.data('affect-on-change-rule') != null
					 ) {

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

					var module = jQuery(".dslca-module-being-edited", LiveComposer.Builder.PreviewAreaDocument);

					var elems = dslcAffectOnChangeEl.split(',');
					var styleContent = "#" + module[0].id + " " + elems.join(", #" + module[0].id + " ") + " {" + rule + ": " + dslcAffectOnChangeVal + dslcExt + "}";

					LiveComposer.Builder.Helpers.processInlineStyleTag({

						context: dslcOption,
						rule: rule,
						elems: dslcAffectOnChangeEl,
						styleContent: styleContent
					});
				});
			}

			/**
			 * Update option
			 */

			var dslcOptionToApply = '';

			// Do we work with CSS control or module property?
			if ( dslcOptionID.indexOf('css_') !== -1 ) {
				// Apply CSS property.
				dslcOptionToApply = dslcAffectOnChangeValOrig;
			} else {
				// Apply module property.
				dslcOptionToApply = dslcOption.val();
			}

			jQuery( '.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule ).val( dslcOptionToApply );

			// Trigger 'LC.moduleChange' event.
			// This event can be used by 3-rd party developers to re-init
			// some of the JavaScript code on modure re-rendering.
			LiveComposer.Utils.publish( 'LC.moduleChange', {

				moduleId: dslcModule[0].id,
				optionID: dslcOptionID,
				optionVal: dslcAffectOnChangeValOrig || dslcOption.val()
			});
		}
	});
}

const onSectionOptionsChange = () => {
	// ROW styling option changes
	jQuery(document).on( 'change', '.dslca-modules-section-edit-field', function() {
		var dslcField, dslcFieldID, dslcEl, dslcModulesSection, dslcVal, dslcValReal, dslcValExt, dslcRule, dslcSetting, dslcTargetEl, dslcImgURL;

		dslcField = jQuery(this);
		dslcFieldID = dslcField.data('id');
		dslcVal = dslcField.val();
		dslcValReal = dslcVal;
		dslcValExt = dslcVal + dslcField.data('ext');
		dslcRule = dslcField.data('css-rule');

		dslcEl = jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument); // Currently editing element
		dslcTargetEl = dslcEl;
		dslcSetting = jQuery('.dslca-modules-section-settings input[data-id="' + dslcFieldID + '"]', dslcEl );

		dslcEl.addClass('dslca-modules-section-change-made');

		// If image/upload field alter the value ( use from data )
		if ( dslcField.hasClass('dslca-modules-section-edit-field-upload') ) {

			if ( dslcVal && dslcVal.length ) {

				// dslcVal = dslcField.data('dslca-img-url');
				dslcVal = jQuery.find('.dslca-modules-section-settings input[data-id="dslca-img-url"]', dslcEl ).val();
			}
		}

		if ( dslcRule == 'background-image' ) {

			dslcVal = 'url("' + dslcVal + '")';
			LiveComposer.Builder.PreviewAreaWindow.dslc_bg_video();
		}

		if ( dslcFieldID == 'bg_image_attachment' ) {

			dslcEl.removeClass('dslc-init-parallax');
		}

		if ( dslcFieldID == 'border-top' ||
			dslcFieldID == 'border-right' ||
			dslcFieldID == 'border-bottom' ||
			dslcFieldID == 'border-left' ) {

			var dslcBorderStyle = jQuery('.dslca-modules-section-settings input[data-id="border_style"]').val();
			dslcSetting = jQuery('.dslca-modules-section-settings input[data-id="border"]', dslcEl );

			dslcValReal = '';

			var dslcChecboxesWrap = dslcField.closest('.dslca-modules-section-edit-option-checkbox-wrapper');
			dslcChecboxesWrap.find('.dslca-modules-section-edit-field-checkbox').each(function(){

				if ( jQuery(this).is(':checked') ) {

					if ( jQuery(this).data('id') == 'border-top' ) {

						dslcValReal += 'top ';
					} else if ( jQuery(this).data('id') == 'border-right' ) {

						dslcValReal += 'right ';
					} else if ( jQuery(this).data('id') == 'border-bottom' ) {

						dslcValReal += 'bottom ';
					} else if ( jQuery(this).data('id') == 'border-left' ) {

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

			var checkboxes = jQuery(this).closest('.dslca-modules-section-edit-option-checkbox-wrapper').find('.dslca-modules-section-edit-field-checkbox');
			var checkboxesVal = '';
			checkboxes.each(function(){

				if ( jQuery(this).prop('checked') ) {

					checkboxesVal += jQuery(this).data('val') + ' ';
				}
			});

			var dslcValReal = checkboxesVal;

			/* Show On */
			if ( dslcField.data('id') == 'show_on' ) {

				if ( checkboxesVal.indexOf( 'desktop' ) !== -1 ) {

					jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslc-hide-on-desktop');
				} else {

					jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).addClass('dslc-hide-on-desktop');
				}

				if ( checkboxesVal.indexOf( 'tablet' ) !== -1 ) {

					jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslc-hide-on-tablet');
				} else {

					jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).addClass('dslc-hide-on-tablet');
				}

				if ( checkboxesVal.indexOf( 'phone' ) !== -1 ) {

					jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslc-hide-on-phone');
				} else {

					jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).addClass('dslc-hide-on-phone');
				}

			}

			// Section divider flip.
			if ( dslcField.data('id') == 'section_divider_bottom_flip' ) {
				if ( dslcValReal.indexOf( 'horizontally' ) === -1 ) {
					jQuery('.dslc-section-divider[data-divider-pos="bottom"]', dslcEl).removeClass('dslc-flip-hor');
				} else {
					jQuery('.dslc-section-divider[data-divider-pos="bottom"]', dslcEl).addClass('dslc-flip-hor');
				}

				if ( dslcValReal.indexOf( 'vertically' ) === -1 ) {
					jQuery('.dslc-section-divider[data-divider-pos="bottom"]', dslcEl).removeClass('dslc-flip-vert');
				} else {
					jQuery('.dslc-section-divider[data-divider-pos="bottom"]', dslcEl).addClass('dslc-flip-vert');
				}

			}

			if ( dslcField.data('id') == 'section_divider_top_flip' ) {
				if ( dslcValReal.indexOf( 'horizontally' ) === -1 ) {
					jQuery('.dslc-section-divider[data-divider-pos="top"]', dslcEl).removeClass('dslc-flip-hor');
				} else {
					jQuery('.dslc-section-divider[data-divider-pos="top"]', dslcEl).addClass('dslc-flip-hor');
				}

				if ( dslcValReal.indexOf( 'vertically' ) === -1 ) {
					jQuery('.dslc-section-divider[data-divider-pos="top"]', dslcEl).removeClass('dslc-flip-vert');
				} else {
					jQuery('.dslc-section-divider[data-divider-pos="top"]', dslcEl).addClass('dslc-flip-vert');
				}

			}

		} else if ( dslcFieldID == 'bg_image_attachment' && dslcVal == 'parallax' ) {
			dslcEl.addClass( 'dslc-init-parallax' );
			LiveComposer.Builder.PreviewAreaWindow.dslc_parallax();
		} else if ( dslcFieldID == 'type' ) {
			if ( dslcVal == 'full' ) {
				dslcEl.addClass('dslc-full');
			} else {
				dslcEl.removeClass('dslc-full');
			}
			LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();
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
				jQuery.find('.dslc-bg-video-inner', dslcEl).text('<video><source type="video/mp4" src="' + dslcVideoVal + '.mp4" /><source type="video/webm" src="' + dslcVideoVal + '.webm" /></video>');
				LiveComposer.Builder.PreviewAreaWindow.dslc_bg_video();
			}

		} else if ( dslcFieldID == 'section_divider_top_style' || dslcFieldID == 'section_divider_bottom_style' ) {
			let dividerPosition = 'top';
			if ( dslcFieldID == 'section_divider_bottom_style' ) {
				dividerPosition = 'bottom';
			}
			// Remove previous divider SVG.
			let inlineStyles = jQuery( '.dslc-section-divider[data-divider-pos="' + dividerPosition + '"] svg', dslcEl ).attr('style');
			jQuery( '.dslc-section-divider[data-divider-pos="' + dividerPosition + '"]', dslcEl ).html('');

			if ( dslcVal && dslcVal.length ) {
				const divider = jQuery('#dslc-section-dividers', LiveComposer.Builder.PreviewAreaWindow.document).find( 'svg#' + dslcVal ).clone();
				// Insert new divider SVG.
				jQuery( '.dslc-section-divider[data-divider-pos="' + dividerPosition + '"]', dslcEl ).html( divider[0] );
				if ( undefined !== inlineStyles ) {
					jQuery( '.dslc-section-divider[data-divider-pos="' + dividerPosition + '"] svg', dslcEl ).attr('style', inlineStyles);
				}
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

		if ( ! LiveComposer.Builder.Flags.generate_code_after_row_changed ) return false;

		// window.dslc_generate_code();
		// window.dslc_show_publish_button();
	});
}

const onFileUploadOptionsChange = () => {
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

			var dataId = hook.parent().attr("data-id");

			/*
			Save alt as value of the image input.
			 */
			if ( attachment.alt != '' && dataId == 'image' ) {
				jQuery('.dslca-module-edit-option-image_alt input[data-id="image_alt"]').val( attachment.alt );
			}

			/*
			Save alt as value of the image input.
			 */
			if ( attachment.title != '' && dataId == 'image' ) {
				jQuery('.dslca-module-edit-option-image_title input[data-id="image_title"]').val( attachment.title );
			}

			/*
			Save image URL as data attribute of input in dslca-modules-section-settings set
			We need URL in 'dslca-img-url' for live preview
			 */
			jQuery('.dslca-modules-section-being-edited', LiveComposer.Builder.PreviewAreaDocument).find('.dslca-modules-section-settings input[data-id="dslca-img-url"]').val( attachment.url );
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

		/*
		Delete alt and title value.
		 */
		var dataId = hook.parent().attr("data-id");

		if ( dataId == 'image' ) {
			jQuery('.dslca-module-edit-option-image_alt input').attr('value', '').trigger( 'change' );
			jQuery('.dslca-module-edit-option-image_alt input').attr('data-val-bckp', '').trigger( 'change' );
			jQuery('.dslca-module-edit-option-image_title input').attr('value', '').trigger( 'change' );
			jQuery('.dslca-module-edit-option-image_title input').attr('data-val-bckp', '').trigger( 'change' );
		}
		hook.hide();
		addHook.show();
	});
}



/**
 * MODULES SETTINGS PANEL - Filter Module Options
 */
function dslc_module_options_section_filter( sectionID ) {

	if ( window.dslcDebug ) console.log( 'dslc_module_options_section_filter' );

	// Hide all options
	jQuery('.dslca-module-edit-option').hide();

	// Show options for current section
	jQuery('.dslca-module-edit-option[data-section="' + sectionID + '"]').show();

	// Recall module options tab
	elementOptionsTabs();
}

export const resetResponsiveOptions = () => {
	// Get active tab (Tablet/Phone)
	const currentTab = document.querySelector('.dslca-module-edit-options-tab-hook.dslca-active').dataset.id;

	if ( 'tablet_responsive' === currentTab || 'phone_responsive' === currentTab ) {
		// Hide/Show options
		const activeSettings =  document.querySelectorAll('.dslca-module-edit-option[data-tab="' + currentTab + '"]');

		activeSettings.forEach( ( element )=> {
			const optionId =  element.querySelector( '.dslca-module-edit-field' ).dataset.id;

			// Don't want to reset value of the breakpoint enabler.
			if ( 'css_res_t' === optionId || 'css_res_p' === optionId ) {
				return;
			}

			var control         = jQuery('.dslca-module-edit-option-' + optionId );
			var control_storage = control.find('.dslca-module-edit-field');

			/* // Get the element we are editing
			var module = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument);

			// Get the element id
			var module_id = module[0].id;

			var responsive_prefix = '';

			if ( 'tablet_responsive' === control.data('tab') ) {
				responsive_prefix = 'body.dslc-res-tablet ';
			} else if ( 'phone_responsive' === control.data('tab') ) {
				responsive_prefix = 'body.dslc-res-phone ';
			}

			var affect_on_change_el = control_storage.data('affect-on-change-el');

			if ( affect_on_change_el === undefined) return;

			var affect_on_change_elmts = affect_on_change_el.split( ',' );

			affect_on_change_el = '';

			// Loop through elements (useful when there are multiple elements)
			for ( var i = 0; i < affect_on_change_elmts.length; i++ ) {

				if ( i > 0 ) {

					affect_on_change_el += ', ';
				}

				affect_on_change_el += responsive_prefix + '#' + module_id + ' ' + affect_on_change_elmts[i];
			}

			var affect_on_change_rule  = control_storage.data('affect-on-change-rule').replace(/ /g,'');
			var affect_on_change_rules = affect_on_change_rule.split( ',' );

			var control_value;
			var control_data_ext = control_storage.data('ext');


			// Disable

			control_value = dslc_get_control_value(control_id);
			// Temporary backup the current value as data attribute
			control_storage.data( 'val-bckp', control_value );

			// Loop through rules (useful when there are multiple rules)
			for ( var i = 0; i < affect_on_change_rules.length; i++ ) {

				// remove css rule in element inline style
				jQuery( affect_on_change_el, LiveComposer.Builder.PreviewAreaDocument ).css( affect_on_change_rules[i] , '' );
				// remove css rule in css block
				disable_css_rule ( affect_on_change_el, affect_on_change_rules[i], module_id);
				// PROBLEM do not work with multiply rules ex.: .dslc-text-module-content,.dslc-text-module-content p
			}
 */
			control_storage.val('').trigger('change');
		} )
	}
}



/**
 * MODULES SETTINGS PANEL - Show module options tab
 */
export const elementOptionsTabs = ( dslcTab ) => {

	if ( window.dslcDebug ) console.log( 'elementOptionsTabs' );

	// Get currently active section
	var dslcSectionID = jQuery('.dslca-options-filter-hook.dslca-active').data('section');

	// If tab not supplied set to first
	dslcTab = typeof dslcTab !== 'undefined' ? dslcTab : jQuery('.dslca-module-edit-options-tab-hook[data-section="' + dslcSectionID + '"]:first');

	// Get the tab ID
	var dslcTabID = dslcTab.data('id');

	// Set active class on tab
	jQuery('.dslca-module-edit-options-tab-hook').removeClass('dslca-active');
	dslcTab.addClass('dslca-active');

	// Show tabs container
	jQuery('.dslca-module-edit-options-tabs').show();

	// Hide/Show tabs hooks
	jQuery('.dslca-module-edit-options-tab-hook').hide();
	jQuery('.dslca-module-edit-options-tab-hook[data-section="' + dslcSectionID + '"]').show();

	if ( dslcTabID ) {

		// Hide/Show options
		jQuery('.dslca-module-edit-option').hide();
		jQuery('.dslca-module-edit-option[data-tab="' + dslcTabID + '"]').show();

		// Hide/Show Tabs
		dslc_module_options_hideshow_tabs();

		// If only one tab hide the tabs container
		if ( jQuery('.dslca-module-edit-options-tab-hook:visible').length < 2 ) {

			jQuery('.dslca-module-edit-options-tabs').hide();
		} else {

			jQuery('.dslca-module-edit-options-tabs').show();
		}

		/**
		 * If responsive tab, change the width of the dslc-content div
		 */

		dslc_disable_responsive_view();

		// Tablet
		if ( dslcTabID == DSLCString.str_res_tablet.toLowerCase() + '_responsive' ) {

			jQuery('body').removeClass('dslc-res-big dslc-res-smaller-monitor dslc-res-phone dslc-res-tablet');
			jQuery('body').addClass('dslc-res-tablet');
			jQuery('html').addClass('dslc-responsive-preview');
		}

		// Phone
		if ( dslcTabID == DSLCString.str_res_phone.toLowerCase() + '_responsive' ) {

			jQuery('body').removeClass('dslc-res-big dslc-res-smaller-monitor dslc-res-phone dslc-res-tablet');
			jQuery('body').addClass('dslc-res-phone');
			jQuery('html').addClass('dslc-responsive-preview');
		}

		// If responsive reload module
		if ( dslcTabID == DSLCString.str_res_tablet.toLowerCase() + '_responsive' || dslcTabID == DSLCString.str_res_phone.toLowerCase() + '_responsive' ) {

			// Show the loader
			jQuery('.dslca-container-loader').show();

			// Reload Module
			moduleOutputAltered(function(){

				// Hide the loader
				jQuery('.dslca-container-loader').hide();
			});
		}
	}

	// Scroll horizontally options panel to the left (not ready)
	if ( jQuery('body').hasClass('rtl') ) {
		var totalWidthOption = 0;
		var totalWidthGroup = 0;
		var totalWidth = 0;

		jQuery('.dslca-module-edit-options-wrapper > .dslca-module-edit-option:visible').each(function(index) {
			if ( ! jQuery(this).hasClass('dslca-module-edit-option-hidden') && ! jQuery(this).hasClass('dslca-module-control-group') ) {
				totalWidthOption += parseInt(jQuery(this).outerWidth(), 10);
			}
		});

		jQuery('.dslca-module-edit-options-wrapper > .dslca-module-control-group:visible').each(function(index) {
			totalWidthGroup += parseInt(jQuery(this).outerWidth(), 10);
		});

		totalWidth = parseInt(totalWidthOption) + parseInt(totalWidthGroup) + 10;

		jQuery('.dslca-module-edit-options-wrapper').css({
			'width': totalWidth + 'px',
		});
	}
}

/**
 * MODULES SETTINGS PANEL - Hide show tabs based on option choices
 */
function dslc_module_options_hideshow_tabs() {

	if ( window.dslcDebug ) console.log( 'dslc_module_options_hideshow_tabs' );

	var dslcSectionID = jQuery('.dslca-options-filter-hook.dslca-active').data('section');

	if ( dslcSectionID == 'styling' ) {

		// Vars
		var dslcContainer = jQuery('.dslca-module-edit'),
		dslcHeading = true,
		dslcFilters = true,
		dslcCarArrows = true,
		dslcCarCircles = true,
		dslcPagination = true,
		dslcElThumb = true,
		dslcElTitle = true,
		dslcElExcerpt = true,
		dslcElMeta = true,
		dslcElButton = true,
		dslcElCats = true,
		dslcElCount = true,
		dslcElSeparator = true,
		dslcElTags = true,
		dslcElSocial = true,
		dslcElPosition = true,
		dslcElIcon = true,
		dslcElContent = true,
		dslcElPrice = true,
		dslcElPriceSec = true,
		dslcElAddCart = true,
		dslcElDetails = true,
		dslcElQuote = true,
		dslcElAuthorName = true,
		dslcElAuthorPos = true,
		dslcElImage = true,
		dslcElLogo = true;


		// Is heading selected?
		if ( ! jQuery('.dslca-module-edit-field[value="main_heading"]').is(':checked') )
			dslcHeading = false;

		// Are filters selected?
		if ( ! jQuery('.dslca-module-edit-field[value="filters"]').is(':checked') )
			dslcFilters = false;

		// Are arrows selected?
		if ( ! jQuery('.dslca-module-edit-field[value="arrows"]').is(':checked') )
			dslcCarArrows = false;

		// Are circles selected?
		if ( ! jQuery('.dslca-module-edit-field[value="circles"]').is(':checked') )
			dslcCarCircles = false;

		// Is it a carousel?
		if ( jQuery('.dslca-module-edit-field[data-id="type"]').val() != 'carousel' ) {
			dslcCarArrows = false;
			dslcCarCircles = false;
		}

		// Is pagination enabled?
		if ( jQuery('.dslca-module-edit-field[data-id="pagination_type"]').val() == 'disabled' ) {
			dslcPagination = false;
		}

		// Is thumb enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="thumbnail"]').is(':checked') ) {
			dslcElThumb = false;
		}

		// Is title enabled?
		if ( jQuery('.dslca-module-edit-field[data-id*="elements"][value="content"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="title"]').is(':checked') ) {
			dslcElTitle = false;
		}

		// Is excerpt enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="excerpt"]').is(':checked') ) {
			dslcElExcerpt = false;
		}

		// Is meta enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="meta"]').is(':checked') ) {
			dslcElMeta = false;
		}

		// Is button enabled?
		if ( jQuery('.dslca-module-edit-field[data-id*="elements"][value="button"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="button"]').is(':checked') ) {
			dslcElButton = false;
		}

		// Are cats enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="categories"]').is(':checked') ) {
			dslcElCats = false;
		}

		// Is separator enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="separator"]').is(':checked') ) {
			dslcElSeparator = false;
		}

		// Is count enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="count"]').is(':checked') ) {
			dslcElCount = false;
		}

		// Are tags enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="tags"]').is(':checked') ) {
			dslcElTags = false;
		}

		// Are social link enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="social"]').is(':checked') ) {
			dslcElSocial = false;
		}

		// Is position enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="position"]').is(':checked') ) {
			dslcElPosition = false;
		}

		// Is icon enabled?
		if ( jQuery('.dslca-module-edit-field[data-id*="elements"][value="icon"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="icon"]').is(':checked') ) {
			dslcElIcon = false;
		}

		// Is content enabled?
		if (  jQuery('.dslca-module-edit-field[data-id*="elements"][value="content"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="content"]').is(':checked') ) {
			dslcElContent = false;
		}

		// Is price enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="price"]').is(':checked') ) {
			dslcElPrice = false;
		}

		// Is price secondary enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="price_2"]').is(':checked') ) {
			dslcElPriceSec = false;
		}

		// Is add to cart enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="addtocart"]').is(':checked') ) {
			dslcElAddCart = false;
		}

		// Is add to cart enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="details"]').is(':checked') ) {
			dslcElDetails = false;
		}

		// Is quote enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="quote"]').is(':checked') ) {
			dslcElQuote = false;
		}

		// Is author name enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="author_name"]').is(':checked') ) {
			dslcElAuthorName = false;
		}

		// Is author position enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="author_position"]').is(':checked') ) {
			dslcElAuthorPos = false;
		}

		// Is image enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="image"]').is(':checked') ) {
			dslcElImage = false;
		}

		// Is logo enabled?
		if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="logo"]').is(':checked') ) {
			dslcElLogo = false;
		}


		// Show/Hide Heading
		if ( dslcHeading )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="heading_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="heading_styling"]').hide();

		// Show/Hide Filters
		if ( dslcFilters )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="filters_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="filters_styling"]').hide();

		// Show/Hide Carousel Arrows
		if ( dslcCarArrows )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_arrows_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_arrows_styling"]').hide();

		// Show/Hide Carousel Circles
		if ( dslcCarCircles )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_circles_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_circles_styling"]').hide();

		// Show/Hide Pagination
		if ( dslcPagination )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="pagination_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="pagination_styling"]').hide();

		// Show/Hide Thumb
		if ( dslcElThumb )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="thumbnail_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="thumbnail_styling"]').hide();

		// Show/Hide Title
		if ( dslcElTitle )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="title_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="title_styling"]').hide();

		// Show/Hide Excerpt
		if ( dslcElExcerpt )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="excerpt_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="excerpt_styling"]').hide();

		// Show/Hide Meta
		if ( dslcElMeta )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="meta_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="meta_styling"]').hide();

		// Show/Hide Button
		if ( dslcElButton )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="button_styling"], .dslca-module-edit-options-tab-hook[data-id="primary_button_styling"],'+
				' .dslca-module-edit-options-tab-hook[data-id="secondary_button_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="button_styling"], .dslca-module-edit-options-tab-hook[data-id="primary_button_styling"],'+
				' .dslca-module-edit-options-tab-hook[data-id="secondary_button_styling"]').hide();

		// Show/Hide Cats
		if ( dslcElCats )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="categories_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="categories_styling"]').hide();

		// Show/Hide Separator
		if ( dslcElSeparator )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="separator_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="separator_styling"]').hide();

		// Show/Hide Count
		if ( dslcElCount )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="count_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="count_styling"]').hide();

		// Show/Hide Tags
		if ( dslcElTags )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="tags_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="tags_styling"]').hide();

		// Show/Hide Tags
		if ( dslcElPosition )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="position_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="position_styling"]').hide();

		// Show/Hide Tags
		if ( dslcElSocial )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="social_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="social_styling"]').hide();

		// Show/Hide Icon
		if ( dslcElIcon )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="icon_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="icon_styling"]').hide();

		// Show/Hide Content
		if ( dslcElContent )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="content_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="content_styling"]').hide();

		// Show/Hide Price
		if ( dslcElPrice )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="price_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="price_styling"]').hide();

		// Show/Hide Price Sec
		if ( dslcElPriceSec )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="price_secondary_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="price_secondary_styling"]').hide();

		// Show/Hide Add to Cart
		if ( dslcElAddCart || dslcElDetails )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="other_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="other_styling"]').hide();

		// Show/Hide Quote
		if ( dslcElQuote )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="quote_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="quote_styling"]').hide();

		// Show/Hide Author Name
		if ( dslcElAuthorName )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="author_name_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="author_name_styling"]').hide();

		// Show/Hide Author Position
		if ( dslcElAuthorPos )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="author_position_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="author_position_styling"]').hide();

		// Show/Hide Image
		if ( dslcElImage )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="image_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="image_styling"]').hide();

		// Show/Hide Quote
		if ( dslcElLogo )
			jQuery('.dslca-module-edit-options-tab-hook[data-id="logo_styling"]').show();
		else
			jQuery('.dslca-module-edit-options-tab-hook[data-id="logo_styling"]').hide();

	}

	/**
	 * Check 'Enable/Disable Custom CSS' control
	 */

	if ( jQuery('.dslca-options-filter-hook[data-section="styling"]').hasClass('dslca-active') ) {

		var dslcCustomCSS = jQuery('.dslca-module-edit-option[data-id="css_custom"]'),
		dslcCustomCSSVal = dslcCustomCSS.find('select').val();

		if ( dslcCustomCSSVal == 'enabled' ) {

			jQuery('.dslca-module-edit-option[data-section="styling"]').css({ visibility : 'visible' });
			jQuery('.dslca-module-edit-option[data-tab]').css( 'visibility', 'visible' );
			jQuery('.dslca-module-edit-options-tabs').show();
		} else {
			jQuery('.dslca-module-edit-option[data-section="styling"]').css({ visibility : 'hidden' });
			jQuery('.dslca-module-control-group.dslca-module-edit-option').css( 'visibility', 'hidden' );
			jQuery('.dslca-module-edit-options-tabs').hide();
			dslcCustomCSS.css({ visibility : 'visible' });
		}

	} else {
		jQuery('.dslca-module-edit-options-tabs').show();
	}

	if ( jQuery('select.dslca-module-edit-field[data-id="css_res_t"]').val() == 'disabled' ) {
		jQuery('.dslca-module-edit-option[data-id*="css_res_t"]').css( 'visibility', 'hidden' );
		jQuery('.dslca-module-edit-option[data-tab="tablet_responsive"]').css( 'visibility', 'hidden' );
	} else {
		jQuery('.dslca-module-edit-option[data-id*="css_res_t"]').css( 'visibility', 'visible' );
		jQuery('.dslca-module-edit-option[data-tab="tablet_responsive"]').css( 'visibility', 'visible' );
	}

	if ( jQuery('select.dslca-module-edit-field[data-id="css_res_p"]').val() == 'disabled' ) {
		jQuery('.dslca-module-edit-option[data-id*="css_res_p"]').css( 'visibility', 'hidden' );
		jQuery('.dslca-module-edit-option[data-tab="phone_responsive"]').css( 'visibility', 'hidden' );
	} else {
		jQuery('.dslca-module-edit-option[data-id*="css_res_p"]').css( 'visibility', 'visible' );
		jQuery('.dslca-module-edit-option[data-tab="phone_responsive"]').css( 'visibility', 'visible' );
	}

	jQuery('.dslca-module-edit-option[data-id="css_res_p"], .dslca-module-edit-option[data-id="css_res_t"]').css( 'visibility', 'visible' );


	if ( jQuery('.dslca-options-filter-hook').hasClass('dslca-active') ) {
		var section_tab = jQuery('.dslca-options-filter-hook.dslca-active').data('section');

		if ( jQuery('.dslca-module-edit-option[data-section="' + section_tab + '"]').hasClass('dep-show') ) {
			jQuery('.dslca-module-edit-option.dep-show').show();
		}

		if ( jQuery('.dslca-module-edit-option[data-section="' + section_tab + '"]').hasClass('dep-hide') ) {
			jQuery('.dslca-module-edit-option.dep-hide').hide();
		}
	}

	if ( jQuery('.dslca-module-edit-options-tab-hook').hasClass('dslca-active') ) {
		var data_tab = jQuery('.dslca-module-edit-options-tab-hook.dslca-active').data('id');

		if ( jQuery('.dslca-module-edit-option[data-tab="' + data_tab + '"]').hasClass('dependent') ) {

			jQuery('.dslca-module-edit-option.dependent').hide();
			jQuery('.dslca-module-edit-option[data-tab="' + data_tab + '"].dep-show').show();
			jQuery('.dslca-module-edit-option[data-tab="' + data_tab + '"].dep-hide').hide();
		} else {

			jQuery('.dslca-module-edit-option.dependent').hide();
		}
	}
}

/**
 * MODULES SETTINGS PANEL - Confirm module options changes
 */
function dslc_module_options_confirm_changes( callback ) {

	if ( window.dslcDebug ) console.log( 'dslc_module_options_confirm_changes' );

	// Callback
	callback = typeof callback !== 'undefined' ? callback : false;

	// If slider module
	if ( jQuery('.dslca-module-being-edited', window.LiveComposer.Builder.PreviewAreaDocument).hasClass('dslc-module-DSLC_Sliders') ) {

		jQuery('.dslca-module-being-edited', window.LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');
	// If not slider module
	} else {

		// Add class so we know saving is in progress
		jQuery('body').addClass('dslca-module-saving-in-progress');

		// Reload module with new settings
		moduleOutputAltered( function(){

			// Update preset
			updatePreset();

			window.dslc_generate_code();

			jQuery('.dslca-module-being-edited', window.LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');

			// Remove classes so we know saving finished
			jQuery('body').removeClass('dslca-module-saving-in-progress');

			// Clean up options container
			jQuery('.dslca-module-edit-options-inner').html('');
			jQuery('.dslca-module-edit-options-tabs').html('');

			window.LiveComposer.Builder.UI.clearUtils();

			// Callback if there's one
			if ( callback ) { callback(); }
		});
	}

	// Show modules listing
	showSection('.dslca-modules');

	// Hide the filter hooks
	jQuery('.dslca-header .dslca-options-filter-hook').hide();

	// Hide the save/cancel actions
	jQuery('.dslca-module-edit-actions').hide();

	// Show the section hooks
	jQuery('.dslca-header .dslca-go-to-section-hook').show();

	// window.dslc_generate_code();
	// Show the publish button
	window.dslc_show_publish_button();
}

/**
 * MODULES SETTINGS PANEL - Cancel module options changes
 */
function dslc_module_options_cancel_changes( callback ) {

	if ( window.dslcDebug ) console.log( 'dslc_module_options_cancel_changes' );

	// Callback
	callback = typeof callback !== 'undefined' ? callback : false;

	// Vars
	var editedModule = jQuery('.dslca-module-being-edited', window.LiveComposer.Builder.PreviewAreaDocument);

	// Add backup option values
	jQuery('.dslca-module-options-front', editedModule).html('').append(window.LiveComposer.Builder.moduleBackup);
	// window.LiveComposer.Builder.moduleBackup = false;

	// Reload module
	moduleOutputAltered( function(){
		window.dslc_generate_code();

		jQuery('.dslca-module-being-edited', window.LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');

		// Clean up options container
		jQuery('.dslca-module-edit-options-inner').html('');
		jQuery('.dslca-module-edit-options-tabs').html('');

		window.LiveComposer.Builder.UI.clearUtils();

		if ( callback ) { callback(); }
	});

	// Show modules listing
	showSection('.dslca-modules');

	// Hide the filter hooks
	jQuery('.dslca-header .dslca-options-filter-hook').hide();

	// Hide the save/cancel actions
	jQuery('.dslca-module-edit-actions').hide();

	// Show the section hooks
	jQuery('.dslca-header .dslca-go-to-section-hook').show();

	// Show the publish button
	window.dslc_show_publish_button();

	window.LiveComposer.Builder.UI.clearUtils();
}

/**
 * MODULES SETTINGS PANEL - Option Tooltips
 */
function dslc_module_options_tooltip() {

	// Close Tooltip
	jQuery(document).on( 'click', '.dslca-module-edit-field-ttip-close', function(){
		jQuery('.dslca-module-edit-field-ttip, .dslca-module-edit-field-icon-ttip').hide();
	});

	// Show Tooltip
	jQuery(document).on( 'click', '.dslca-module-edit-field-ttip-hook', function(){

		var dslcTtip = jQuery('.dslca-module-edit-field-ttip'),
		dslcTtipInner = dslcTtip.find('.dslca-module-edit-field-ttip-inner'),
		dslcHook = jQuery(this),
		dslcTtipContent,
		dslcLabel;

		dslcLabel = dslcHook.parent();

		if ( dslcLabel.parent().hasClass('dslca-modules-section-edit-option') ) {
			dslcTtipContent = dslcHook.closest('.dslca-modules-section-edit-option').find('.dslca-module-edit-field-ttip-content').html();
		} else {
			dslcTtipContent = dslcHook.closest('.dslca-module-edit-option').find('.dslca-module-edit-field-ttip-content').html();
		}

		if ( dslcTtip.is(':visible') ) {

			jQuery('.dslca-module-edit-field-ttip').hide();
		} else {

			dslcTtipInner.html( dslcTtipContent );

			var dslcOffset = dslcHook.offset();
			var dslcTtipHeight = dslcTtip.outerHeight();
			var dslcTtipWidth = dslcTtip.outerWidth();
			var dslcTtipLeft = dslcOffset.left - ( dslcTtipWidth / 2 ) + 6;
			var dslcTtipArrLeft = '50%';

			if ( dslcTtipLeft < 0 ) {

				dslcTtipArrLeft = ( dslcTtipWidth / 2 ) + dslcTtipLeft + 'px';
				dslcTtipLeft = 0;
			}

			jQuery('.dslca-module-edit-field-ttip').show().css({
				top : dslcOffset.top - dslcTtipHeight - 20,
				left: dslcTtipLeft
			});

			jQuery("head").append(jQuery('<style>.dslca-module-edit-field-ttip:after, .dslca-module-edit-field-ttip:before { left: ' + dslcTtipArrLeft + ' }</style>'));
		}
	});

	// Show Tooltip ( Icon Options )
	jQuery(document).on( 'click', '.dslca-module-edit-field-icon-ttip-hook', function(){

		var dslcTtip = jQuery('.dslca-module-edit-field-icon-ttip');
		var dslcHook = jQuery(this);

		if ( dslcTtip.is(':visible') ) {

			jQuery('.dslca-module-edit-field-icon-ttip').hide();
		} else {

			var dslcOffset = dslcHook.offset();
			var dslcTtipHeight = dslcTtip.outerHeight();
			var dslcTtipWidth = dslcTtip.outerWidth();
			var dslcTtipLeft = dslcOffset.left - ( dslcTtipWidth / 2 ) + 6;
			var dslcTtipArrLeft = '50%';

			if ( dslcTtipLeft < 0 ) {

				dslcTtipArrLeft = ( dslcTtipWidth / 2 ) + dslcTtipLeft + 'px';
				dslcTtipLeft = 0;
			}

			jQuery('.dslca-module-edit-field-icon-ttip').show().css({
				top : dslcOffset.top - dslcTtipHeight - 20,
				left: dslcTtipLeft
			});

			jQuery("head").append(jQuery('<style>.dslca-module-edit-field-icon-ttip:after, .dslca-module-edit-field-icon-ttip:before { left: ' + dslcTtipArrLeft + ' }</style>'));
		}
	});
}

/**
 * MODULES SETTINGS PANEL - Font option type
 */
window.dslc_module_options_font = function () {
	// Next Font
	jQuery(document).off( 'click', '.dslca-module-edit-field-font-next' ).on( 'click', '.dslca-module-edit-field-font-next', nextFont );
	function nextFont(e){
		e.preventDefault();

		if ( ! jQuery(this).hasClass('dslca-font-loading') && ! jQuery(this).siblings('.dslca-font-loading').length ) {

			var dslcOption = jQuery(this).closest('.dslca-module-edit-option-font');
			var dslcField = jQuery( '.dslca-module-edit-field-font', dslcOption );
			var dslcCurrIndex = dslcAllFontsArray.indexOf( dslcField.val() );
			var dslcNewIndex = dslcCurrIndex + 1;

			jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');

			dslcField.val( dslcAllFontsArray[dslcNewIndex] ).trigger('change');

			jQuery(this).addClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-chevron-right').addClass('dslc-icon-refresh dslc-icon-spin');
		}
	};

	// Previous Font
	jQuery(document).off( 'click', '.dslca-module-edit-field-font-prev' ).on( 'click', '.dslca-module-edit-field-font-prev', prevFont );
	function prevFont(e){

		e.preventDefault();

		if ( ! jQuery(this).hasClass('dslca-font-loading') && ! jQuery(this).siblings('.dslca-font-loading').length ) {

			var dslcOption = jQuery(this).closest('.dslca-module-edit-option-font');
			var dslcField = jQuery( '.dslca-module-edit-field-font', dslcOption );
			var dslcCurrIndex = dslcAllFontsArray.indexOf( dslcField.val() );
			var dslcNewIndex = dslcCurrIndex - 1;

			jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');

			if ( dslcNewIndex < 0 ) {

				dslcNewIndex = dslcAllFontsArray.length - 1
			}

			dslcField.val( dslcAllFontsArray[dslcNewIndex] ).trigger('change');

			jQuery(this).addClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-chevron-left').addClass('dslc-icon-refresh dslc-icon-spin');
		}
	};

	jQuery(document).off( 'blur', '.dslca-module-edit-field-font' ).on( 'blur', '.dslca-module-edit-field-font', onFieldBlur );
	function onFieldBlur(e) {
		var dslcOption = jQuery(this).closest('.dslca-module-edit-option');
		jQuery('.dslca-module-edit-field-font-suggest', dslcOption).hide();
	}

	jQuery(document).off( 'keyup', '.dslca-module-edit-field-font' ).on( 'keyup', '.dslca-module-edit-field-font', onKeyUp );
	// Keyup ( left arrow, right arrow, else )
	function onKeyUp(e) {
		var dslcField, dslcOption, dslcVal, dslcMatchingFont = false, dslcFont;

		dslcField = jQuery(this);
		dslcOption = dslcField.closest('.dslca-module-edit-option');

		// Arrow Up.
		if ( e.which == 38 ) {
			jQuery('.dslca-module-edit-field-font-prev', dslcOption).click();
		}

		// Arrow Down.
		if ( e.which == 40 ) {
			jQuery('.dslca-module-edit-field-font-next', dslcOption).click();
		}

		if ( e.which != 13 && e.which != 38 && e.which != 40 ) {

			dslcVal = dslcField.val();

			var search = [];
			var re = new RegExp('^' + dslcVal, 'i');
			var dslcFontsAmount = dslcAllFontsArray.length;
			var i = 0;

			do {
				if (re.test(dslcAllFontsArray[i])) {
					if ( ! dslcMatchingFont ) {
						var dslcMatchingFont = dslcAllFontsArray[i];
					}
				}
			i++; } while (i < dslcFontsAmount);

			if ( ! dslcMatchingFont ) {
				dslcFont = dslcVal;
				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).hide();
			} else if ( dslcVal !== dslcMatchingFont ) {
				dslcFont = dslcMatchingFont;
				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).show();
			}

			jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text( dslcFont );

			if ( dslcFont.length ){
				dslcField.val( dslcFont.substring( 0 , dslcField.val().length ) );
			}
		}
	};

	jQuery(document).off( 'keydown', '.dslca-module-edit-field-font' ).on( 'keydown', '.dslca-module-edit-field-font', onPushEnter );
	// Key press ( enter = 13 and tab = 9 )
	function onPushEnter(e) {
		if ( e.which == 13 || e.which == 9 ) {
			var dslcField, dslcOption, dslcVal, dslcMatchingFont, dslcFont;

			dslcField = jQuery(this);
			dslcOption = dslcField.closest('.dslca-module-edit-option');

			var suggestedFont = jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text();

			if ( suggestedFont.length ) {
				jQuery(this).val( jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text() ).trigger('change');
				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');
			}
		}
	};
}

/*
 * MODULES SETTINGS PANEL - Change icon code based on direction (next/previous)
 */
function dslc_list_icon( object, direction ) {

	var dslcOption = jQuery(object).closest('.dslca-module-edit-option-icon');
	var dslcField = jQuery( '.dslca-module-edit-field-icon', dslcOption );
	var dslcCurrIndex = dslcIconsCurrentSet.indexOf( dslcField.val() );

	if ( direction == 'previous' ) {

		var dslcNewIndex = dslcCurrIndex - 1;
	} else {

		var dslcNewIndex = dslcCurrIndex + 1;
	}

	jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text('');

	if ( dslcNewIndex < 0 ) {

		dslcNewIndex = dslcIconsCurrentSet.length - 1
	}

	dslcField.val( dslcIconsCurrentSet[dslcNewIndex] ).trigger('change');
}

/**
 * MODULES SETTINGS PANEL - Icon option type
 */
function dslc_module_options_icon() {

	// Key Up ( arrow up, arrow down, else )

	jQuery(document).on( 'keyup', '.dslca-module-edit-field-icon', function(e) {

		var dslcField, dslcOption, dslcVal, dslcIconsArrayGrep, dslcIcon;

		dslcField = jQuery(this);
		dslcOption = dslcField.closest('.dslca-module-edit-option');

		// Key pressed: arrow up
		if ( e.which == 38 ) {

			dslc_list_icon(dslcField,'previous');
		}

		// Key pressed: arrow down
		if ( e.which == 40 ) {

			dslc_list_icon(dslcField,'next');
		}

		if ( e.which != 13 && e.which != 38 && e.which != 40 ) {

			dslcVal = dslcField.val().toLowerCase();
			dslcField.val( dslcVal );

			dslcIconsArrayGrep = jQuery.grep(dslcIconsCurrentSet, function(value, i) {
				return ( value.indexOf( dslcVal ) == 0 );
			});

			dslcIcon = dslcIconsArrayGrep[0];

			jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text( dslcIcon );
		}
	});

	// Key Press ( Enter )

	jQuery(document).on( 'keypress', '.dslca-module-edit-field-icon', function(e) {

		if ( e.which == 13 ) {

			e.preventDefault();

			var dslcField, dslcOption, dslcVal, dslcIconsArrayGrep, dslcIcon;

			dslcField = jQuery(this);
			dslcOption = dslcField.closest('.dslca-module-edit-option');

			jQuery(this).val( jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text() ).trigger('change');

			jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text('');
		}
	});
}

/**
 * MODULES SETTINGS PANEL - return options id
 */
function dslc_module_options_icon_returnid() {

	jQuery(document).on('click', '.dslca-open-modal-hook[data-modal^=".dslc-list-icons"]', function(el) {
		jQuery(this).closest('.dslca-module-edit-option-icon').find('input').addClass('icon-modal-active');
	});

	jQuery(document).on('click', '.dslca-modal-icons .icon-item', function(el) {

		// Get selected item code
		var selectedIconCode = jQuery(this).find('.icon-item_name').text();
		jQuery('input.icon-modal-active').val(selectedIconCode).change();

		// Close modal window
		hideModal( '', jQuery('.dslca-modal:visible') );
		jQuery('input.icon-modal-active').removeClass('icon-modal-active');
	});
}

/**
 * MODULES SETTINGS PANEL - Text align option type
 */
function dslc_module_options_text_align() {

	jQuery(document).on( 'click', '.dslca-module-edit-option-text-align-hook', function(){

		var newOpt = jQuery(this),
		otherOpt = jQuery(this).closest('.dslca-module-edit-option-text-align-wrapper').find('.dslca-module-edit-option-text-align-hook'),
		newVal = newOpt.data('val'),
		realOpt = jQuery(this).closest('.dslca-module-edit-option-text-align-wrapper').siblings('input.dslca-module-edit-field');

		otherOpt.removeClass('dslca-active');
		newOpt.addClass('dslca-active');

		realOpt.val( newVal ).trigger('change');
	});
}

/**
 * MODULES SETTINGS PANEL - Checkbox Option Type
 */
function dslc_module_options_checkbox() {

	jQuery(document).on( 'click', '.dslca-module-edit-option-checkbox-hook, .dslca-modules-section-edit-option-checkbox-hook', function(){

		var checkFake = jQuery(this);
		var checkReal = checkFake.siblings('input[type="checkbox"]');

		if ( checkReal.prop('checked') ) {
			checkReal.prop('checked', false);
			checkFake.find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
		} else {
			checkReal.prop('checked', true);
			checkFake.find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
		}

		checkReal.change();
	});
}

/**
 * MODULES SETTINGS PANEL - Box Shadow Option Type
 */
function dslc_module_options_box_shadow() {

	if ( window.dslcDebug ) console.log( 'dslc_module_options_box_shadow' );

	/**
	 * Value Change
	 */

	jQuery(document).on( 'change', '.dslca-module-edit-option-box-shadow-hor, '+
		'.dslca-module-edit-option-box-shadow-ver, .dslca-module-edit-option-box-shadow-blur, .dslca-module-edit-option-box-shadow-spread,'+
		' .dslca-module-edit-option-box-shadow-color, .dslca-module-edit-option-box-shadow-inset', function(){

		var boxShadowWrapper = jQuery(this).closest('.dslca-module-edit-option'),
		boxShadowInput = boxShadowWrapper.find('.dslca-module-edit-field'),
		boxShadowHor = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-hor').val(),
		boxShadowVer = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-ver').val(),
		boxShadowBlur = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-blur').val(),
		boxShadowSpread = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-spread').val(),
		boxShadowColor = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-color').val(),
		boxShadowInset = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-inset').is(':checked');

		if ( boxShadowInset ) { boxShadowInset = ' inset'; } else { boxShadowInset = ''; }

		var boxShadowVal = boxShadowHor + 'px ' + boxShadowVer + 'px ' + boxShadowBlur + 'px ' + boxShadowSpread + 'px ' + boxShadowColor + boxShadowInset;

		boxShadowInput.val( boxShadowVal ).trigger('change');
	});
}

/**
 * MODULES SETTINGS PANEL - Text Shadow Option Type
 */
function dslc_module_options_text_shadow() {

	if ( window.dslcDebug ) console.log( 'dslc_module_options_text_shadow' );

	/**
	 * Value Change
	 */

	jQuery(document).on( 'change', '.dslca-module-edit-option-text-shadow-hor, .dslca-module-edit-option-text-shadow-ver,'+
		'.dslca-module-edit-option-text-shadow-blur, .dslca-module-edit-option-text-shadow-color', function(){

		var textShadowWrapper = jQuery(this).closest('.dslca-module-edit-option'),
		textShadowInput = textShadowWrapper.find('.dslca-module-edit-field'),
		textShadowHor = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-hor').val(),
		textShadowVer = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-ver').val(),
		textShadowBlur = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-blur').val(),
		textShadowColor = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-color').val();

		var textShadowVal = textShadowHor + 'px ' + textShadowVer + 'px ' + textShadowBlur + 'px ' + textShadowColor;

		textShadowInput.val( textShadowVal ).trigger('change');
	});
}

/**
 * MODULES SETTINGS PANEL - Color Option Type
 */
function dslc_module_options_color( field ) {

	if ( window.dslcDebug ) console.log( 'dslc_module_options_color' );

	var dslcColorField,
	dslcAffectOnChangeEl,
	dslcAffectOnChangeRule,
	dslcColorFieldVal,
	dslcModule,
	dslcOptionID,
	dslcCurrColor;

	/**
	 * Color Pallete.
	 *
	 * Last three selected colors get stored in the local storage
	 * of the browser under the key 'dslcColors-example.com'.
	 *
	 * Beside latest three custom colors, color palette includes
	 * three predefined/fixed colors: white, black and transparent.
	 */

	var dslcColorPallete = [],
	currStorage,
	index;

	var palleteCurrentDommain = 'dslcColors-' + document.domain

	// Get three recent colors from the local storage.
	if ( undefined !== localStorage[ palleteCurrentDommain ] ) {
		currStorage = JSON.parse( localStorage[ palleteCurrentDommain ] );
		dslcColorPallete = currStorage;
	}

	// Set default colors if not enough custom colors. Should be six.
	if ( 1 > dslcColorPallete.length ) {
		dslcColorPallete.push( '#78b' );
	}

	if ( 2 > dslcColorPallete.length ) {
		dslcColorPallete.push( '#ab0' );
	}

	if ( 3 > dslcColorPallete.length ) {
		dslcColorPallete.push( '#de3' );
	}

	// Add the next "fixed" colors to the end of the pallete.
	dslcColorPallete.push( '#fff' );
	dslcColorPallete.push( '#000' );
	dslcColorPallete.push( 'rgba(0,0,0,0)' );

	var query = field;

	// For each color picker input field.
	jQuery(query).each( function(){

		// Set setting the conotrol wrapper.
		var wrapper = jQuery(this).closest('.dslca-color-option');
		var input = jQuery(this);

		dslcCurrColor = jQuery(this).val();

		/**
		 * Init standard WP color pickers (Iris).
		 *
		 * See: http://automattic.github.io/Iris/
		 * See: https://github.com/23r9i0/wp-color-picker-alpha
		 */
		input.wpColorPicker({
			mode: 'hsl',
			palettes: dslcColorPallete,
			change: function(event, ui) {
				// @todo: get the code below into a separate function!
				// The option field
				dslcColorField = input;

				var color = input.wpColorPicker('color');

				// The new color
				if ( color == null ) {
					dslcColorFieldVal = '';
				} else {
					dslcColorFieldVal = color;
				}

				// Change current value of option
				dslcColorField.val( dslcColorFieldVal ).trigger('change');

				// Change input field background.
				dslcColorField.css('background', dslcColorFieldVal);

				// Live change
				dslcAffectOnChangeEl = dslcColorField.data('affect-on-change-el');
				dslcAffectOnChangeRule = dslcColorField.data('affect-on-change-rule');

				// ROWs doesn't have 'dslcAffectOnChangeEl' defined
				if ( null != dslcAffectOnChangeEl && '.dslca-modules-section-being-edited' !== dslcAffectOnChangeEl ) {
					jQuery( dslcAffectOnChangeEl , window.LiveComposer.Builder.PreviewAreaDocument.find('.dslca-module-being-edited') ).css( dslcAffectOnChangeRule , dslcColorFieldVal );
				}
				// Update option
				dslcModule = jQuery('.dslca-module-being-edited', window.LiveComposer.Builder.PreviewAreaDocument);
				dslcOptionID = dslcColorField.data('id');
				jQuery('.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule).val( dslcColorFieldVal );

				// Add changed class
				dslcModule.addClass('dslca-module-change-made');
			}
		});

		var colorPickerPopup = wrapper.find('.wp-picker-holder .iris-picker');
		colorPickerPopup.append('<button type="button" class="dslca-colorpicker-apply">Apply</button>');

		var apply = wrapper.find('.dslca-colorpicker-apply');

		input.wpColorPicker( 'open' );

		// If [APPLY] button clicked...
		jQuery(apply).on('click', function() {

			// If new color is not one of the "fixed" colors...
			if ( '#fff' !== dslcColorFieldVal &&
				  '#ffffff' !== dslcColorFieldVal &&
				  '#000' !== dslcColorFieldVal &&
				  '#000000' !== dslcColorFieldVal &&
				  'rgba(0,0,0,0)' !== dslcColorFieldVal ) {

				// Update pallete colors in the local storage.
				if ( undefined === localStorage[ palleteCurrentDommain ] ) {

					// Create new record if no local storage found.
					var newStorage = [ dslcColorFieldVal ];
					localStorage[ palleteCurrentDommain ] = JSON.stringify(newStorage);

				} else {

					// Update existing record in the local storage.
					var newStorage = JSON.parse( localStorage[ palleteCurrentDommain ] );

					if ( newStorage.indexOf( dslcColorFieldVal ) == -1 ) {

						// Add new color to the head of the pallete array.
						newStorage.unshift( dslcColorFieldVal );

						if ( 3 < newStorage.length ) {
							// Remove the last color from the pallete.
							newStorage.pop();
						}
					}

					localStorage[ palleteCurrentDommain ] = JSON.stringify(newStorage);
				}
			}

			input.wpColorPicker( 'close' );
		});

		// Save this element to destroy on panel closed.
		window.LiveComposer.Builder.Helpers.colorpickers.push( jQuery(this) );
	});
}

/**
 * MODULES SETTINGS PANEL - Numeric Option Type
 */
function dslc_module_options_numeric( fieldWrapper ) {
	if ( window.dslcDebug ) console.log( 'dslc_module_options_numeric' );

	var query = fieldWrapper; // || '.dslca-module-edit-option-slider';

	jQuery(query).each(function(){

		var controlWrapper = jQuery(this);

		/* Create an empty div to be uses by jQuery as the slider container. */
		if ( 0 === jQuery('.dslca-module-edit-field-slider', controlWrapper).length ) {
			controlWrapper.append('<div class="dslca-module-edit-field-slider"></div>');
		}

		var workingWithModule = true;

		/* Is the control part of the module setting panel or section settings? */
		if ( controlWrapper.hasClass('dslca-modules-section-edit-option') ) {
			// We are working with seciton.
			workingWithModule = false;
		} else {
			// We are working with module.
			workingWithModule = true;
		}

		if ( workingWithModule ) {
			var sliderInput = controlWrapper.find('.dslca-module-edit-field');
		} else {
			var sliderInput = controlWrapper.find('.dslca-modules-section-edit-field');
		}

		/* Is the control part of the module setting panel or section settings? */
		if ( controlWrapper.hasClass('dslca-modules-section-edit-option') ) {
			// We are working with seciton.
			var sliderInput = controlWrapper.find('.dslca-modules-section-edit-field');
		} else {
			// We are working with module.
			var sliderInput = controlWrapper.find('.dslca-module-edit-field');
		}

		var sliderExt = '',
		sliderControl = controlWrapper.find('.dslca-module-edit-field-slider'),
		currentVal    = parseFloat( sliderInput.val() ),

		// Max value. By default max is 100.
		max = parseFloat( sliderInput.data('max') ),
		// Min value. By default min is 0.
		min = parseFloat( sliderInput.data('min') ),
		// Increment value. By default increment is 1.
		inc = parseFloat( sliderInput.data('increment') ),
		// Backup values.
		max_orig = max,
		min_orig = min;

		/**
		 * Check if value can't be negative according to module settings.
		 */
		var onlypositive = false;

		if ( undefined !== sliderInput.data('onlypositive') && 1 === sliderInput.data('onlypositive')  ) {
			onlypositive = true;
		}

		/**
		 * If the current slider value gets to the max or min,
		 * we set new 'wider' max/min values.
		 *
		 * This way slider has no fixed top or bottom limit one one hand
		 * and works precise enough for both small and big values.
		 */
		if ( currentVal >= max ) {
			max = currentVal * 2;
		}

		if ( ! onlypositive && currentVal <= min ) {
			min = currentVal * 2;
		}

		sliderControl.slider({
			min : min,
			max : max,
			step: inc,
			value: sliderInput.val(),

			slide: function(event, ui) {
				sliderInput.val( ui.value + sliderExt );
				sliderInput.trigger('change');
			},

			change: function(event, ui) {
				/**
				 * If the current slider value gets to the max or min,
				 * we reset the slider (destroy/call again) so script above
				 * set new bigger max/min values.
				 *
				 * This way slider has no top or bottom limit one one hand
				 * and precise enough for both small and big values.
				 */
				if ( ui.value >= max || ui.value <= min ) {
					sliderControl.slider( "destroy" );
					dslc_module_options_numeric( controlWrapper );
				}
			},
			/*
			stop: function( event, ui ) {
			},
			start: function( event, ui ) {
			}
			*/
		});

		/**
		 * Once the slider initiated, show it in HTML.
		 * Slider control is hidden by default. We show it on hover only.
		 */
		sliderControl.show();

		/* On mouse leave: Remove empty DIV and destroy the slider. */
		jQuery(controlWrapper).on('mouseleave', function() {

			if ( undefined !== sliderControl.slider( 'instance' ) ) {
				jQuery(sliderControl).slider( 'destroy' );
			}

			sliderControl.remove();
		});


		if( sliderInput[0].classList.contains('slider-initiated') ) return;
		sliderInput[0].classList.add("slider-initiated");

		sliderInput.on('keyup', function(e){

			// In some rare cases we have the next error:
			// TypeError: undefined is not an object (evaluating 'a.key.match')
			if (undefined === e) {
				return false;
			}

			// Shift + Up/Down
			if( e.shiftKey ) {

				if( e.keyCode == 38 ) {
					this.value = ( parseInt(this.value) || 0 ) + 9;
					sliderInput.trigger('change');
				}

				if( e.keyCode == 40 ) {
					this.value = ( parseInt(this.value) + 0 ) - 9;
					sliderInput.trigger('change');
				}
			}

			// Backspace, "-"
			if( e.keyCode == 8 || e.keyCode == 45 ) {
				sliderInput.trigger('change');
			}

			// If number key pressed
			if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105)) {
				sliderInput.trigger('change');
			}

			var charCode = (e.which) ? e.which : e.keyCode;

			//@todo more work here
			if( ( (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) ) && e.keyCode != 8 && e.keyCode != 39 && e.keyCode != 37 && e.keyCode != 46 ) {
				return false;
			}
		});

		// sliderInput.unbind('change');
		sliderInput.on('change', function(e){

			if ( onlypositive && this.value < 0 ) {
				this.value = 0;
			}

			var containerWrapper;

			if ( workingWithModule ) {
				containerWrapper = jQuery( e.target.closest('.dslca-module-edit-option-slider') );
			} else {
				containerWrapper = jQuery( e.target.closest('.dslca-modules-section-edit-option-slider') );
			}

			/**
			 * Move the slider needle to reflect the value changes
			 * made via direct input of via keyboard arrow keys.
			 */
			var currentSliderInstance = containerWrapper.find('.dslca-module-edit-field-slider');
			if ( undefined !== currentSliderInstance.slider( 'instance' ) ) {
				currentSliderInstance.slider( 'value', this.value );
			}

			if ( workingWithModule ) {
				// Add changed class to the module.
				var module = jQuery('.dslca-module-being-edited', window.LiveComposer.Builder.PreviewAreaDocument);
				module.addClass('dslca-module-change-made');
			}
		});

		return false;
	}); // .each
}

function dslc_disable_responsive_view () {
	jQuery('html').removeClass('dslc-responsive-preview');
	jQuery('body').removeClass('dslc-res-big dslc-res-smaller-monitor dslc-res-phone dslc-res-tablet');

}


function dslc_filter_module_options( sectionID ) { dslc_module_options_section_filter( sectionID ); }
function dslc_confirm_changes( callback ) { dslc_module_options_confirm_changes( callback ); }
function dslc_cancel_changes( callback ) { dslc_module_options_cancel_changes( callback ); }
function dslc_init_colorpicker() { dslc_module_options_color(); }
function dslc_init_options_slider() { dslc_module_options_numeric(); }
function dslc_module_edit_options_hideshow_tabs() { dslc_module_options_hideshow_tabs(); }