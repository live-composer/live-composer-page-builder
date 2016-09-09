/**
 * Builder settings panel functions providing work with modules
 */

'use strict';

/**
 * Modules - Document Ready
 */

jQuery(document).ready(function($){

	dslc_module_options_tooltip();
	dslc_module_options_font();
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
	jQuery(document).on('click', dslca_options_with_colorpicker, function() {
		dslc_module_options_color( this );
		jQuery( this ).next().click();
	});

	/* Initiate all the slider controls on the module options panel. */
	jQuery('.dslca-container').on('hover', '.dslca-module-edit-option-slider .dslca-module-edit-field-numeric', function() {

		dslc_module_options_numeric( this );
	});

	/* Initiate all the slider controls on the row options panel. */
	jQuery('.dslca-container').on('hover', '.dslca-modules-section-edit-option-slider .dslca-modules-section-edit-field', function() {

		dslc_module_options_numeric( this );
	});

	/**
	 * Hook - Submit
	 */
	jQuery('.dslca-module-edit-form').submit( function(e){

		e.preventDefault();
		dslc_module_output_altered();
	});

	/**
	 * Hook - Tab Switch
	 */
	$(document).on( 'click', '.dslca-module-edit-options-tab-hook', function(e){

		e.preventDefault();
		dslc_module_options_tab_filter( $(this) );
	});

	/**
	 * Hook - Option Section Switch
	 */
	$(document).on( 'click', '.dslca-options-filter-hook', function(e){

		e.preventDefault();

		var dslcPrev = jQuery('.dslca-options-filter-hook.dslca-active').data('section');
		var currentSection = jQuery(this).data('section');

		$('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');
		$(this).addClass('dslca-active');


		dslc_module_options_section_filter( currentSection );

		// If previous was responsive reload module
		if ( dslcPrev == 'responsive' ) {

			// Show the loader
			jQuery('.dslca-container-loader').show();

			// Reset the responsive classes
			LiveComposer.Builder.PreviewAreaWindow.dslc_responsive_classes();

			// Reload Module
			dslc_module_output_altered(function(){

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

			LiveComposer.Builder.UI.initInlineEditors({withRemove:true});
			LiveComposer.Builder.UI.unloadOptionsDeps();
			LiveComposer.Builder.Flags.panelOpened = false;

			jQuery("body", LiveComposer.Builder.PreviewAreaDocument).removeClass('module-editing-in-progress');

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

			LiveComposer.Builder.UI.initInlineEditors({withRemove:true});
			LiveComposer.Builder.UI.unloadOptionsDeps();
			LiveComposer.Builder.Flags.panelOpened = false;

			jQuery("body", LiveComposer.Builder.PreviewAreaDocument).removeClass('module-editing-in-progress');

		});

		jQuery('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');

		dslc_disable_responsive_view();
	});

	/**
	 * Hook - Show/Hide Icon Set Switch
	 */
	jQuery(document).on( 'click', '.dslca-module-edit-field-icon-switch-set', function(){

		var dslcTtip = jQuery('.dslca-module-edit-field-icon-switch-sets');
		var dslcHook = jQuery(this);

		// Add/Remo active classes
		jQuery('.dslca-module-edit-field-icon-switch-set.dslca-active').removeClass('dslca-active');
		dslcHook.addClass('dslca-active');

		if ( dslcTtip.is(':visible') ) {

			jQuery('.dslca-module-edit-field-icon-switch-sets').hide();
		} else {

			// Icon vars
			var currIconSet = dslcHook.find('.dslca-module-edit-field-icon-curr-set').text();

			jQuery('.dslca-module-edit-field-icon-switch-sets span.dslca-active').removeClass('dslca-active');
			jQuery('.dslca-module-edit-field-icon-switch-sets span[data-set="' + currIconSet + '"]').addClass('dslca-active');

			// Positioning vars
			var dslcOffset = dslcHook.offset(),
			dslcTtipHeight = dslcTtip.outerHeight(),
			dslcTtipWidth = dslcTtip.outerWidth(),
			dslcTtipLeft = dslcOffset.left - ( dslcTtipWidth / 2 ) + 6,
			dslcTtipArrLeft = '50%';

			if ( dslcTtipLeft < 0 ) {
				dslcTtipArrLeft = ( dslcTtipWidth / 2 ) + dslcTtipLeft + 'px';
				dslcTtipLeft = 0;
			}

			jQuery('.dslca-module-edit-field-icon-switch-sets').show().css({
				top : dslcOffset.top - dslcTtipHeight - 20,
				left: dslcTtipLeft
			});

			jQuery("head").append(jQuery('<style>.dslca-module-edit-field-icon-switch-sets:after, .dslca-module-edit-field-icon-switch-sets:before { left: ' + dslcTtipArrLeft + ' }</style>'));
		}
	});

	/**
	 * Hook - Switch Icon Set
	 */
	jQuery(document).on( 'click', '.dslca-module-edit-field-icon-switch-sets span', function(){

		var iconSet = $(this).data('set');

		// Change current icon set
		dslcIconsCurrentSet = DSLCIcons[iconSet];

		// Update 'icons grid' button data-modal attribute with selected set
		$('.dslca-open-modal-hook[data-modal^=".dslc-list-icons"]').data('modal', '.dslc-list-icons-' + iconSet );


		// Change active states
		$(this).addClass('dslca-active').siblings('.dslca-active').removeClass('dslca-active');

		// Change current text
		$('.dslca-module-edit-field-icon-switch-set.dslca-active .dslca-module-edit-field-icon-curr-set').text( iconSet );

		// Go to next icon
		$('.dslca-module-edit-field-icon-switch-set.dslca-active').closest('.dslca-module-edit-option').find('.dslca-module-edit-field-icon-next').trigger('click');

		// Hide sets
		$('.dslca-module-edit-field-icon-switch-sets').hide();
	});

	/**
	 * Action - Change current set on mouse enter of icon option
	 */
	jQuery(document).on( 'mouseenter', '.dslca-module-edit-option-icon', function(){

		var iconSet = $(this).find('.dslca-module-edit-field-icon-curr-set').text();

		// Change current icon set
		dslcIconsCurrentSet = DSLCIcons[iconSet];

		// Update 'icons grid' button data-modal attribute with selected set
		$('.dslca-open-modal-hook[data-modal^=".dslc-list-icons"]').data('modal', '.dslc-list-icons-' + iconSet );
	});
});

/* Editor scripts */
(function() {

	var $ = jQuery;

	var self = LiveComposer.Builder;

	LiveComposer.Builder.Helpers.colorpickers = [];

	LiveComposer.Builder.UI.initInlineEditors = function(params){

		params = params || {};

		if ( params.withRemove == true ) {

			LiveComposer.Builder.PreviewAreaWindow.tinyMCE.remove();
		}

		LiveComposer.Builder.PreviewAreaWindow.tinyMCE.init({
			selector: '.inline-editor.dslca-editable-content',
			editor_deselector: 'mce-content-body',
			menubar: false,
		  	inline: true,
		  	plugins: ['link lists paste'],
		  	style_formats: [
			      {title: 'Paragraph', format: 'p'},
			      {title: 'Header 2', format: 'h2'},
			      {title: 'Header 3', format: 'h3'},
			      {title: 'Header 4', format: 'h4'},
			      {title: 'Header 5', format: 'h5'},
			      {title: 'Header 6', format: 'h6'},
			  ],
		  	toolbar: 'styleselect | bold italic blockquote | removeformat | link unlink | bullist numlist '
		});
	}

	/* Destroy instanced of sliders, color pickers and other temporary elements */
	LiveComposer.Builder.UI.clearUtils = function() {

		if( Array.isArray(self.Helpers.colorpickers ) ) {

			self.Helpers.colorpickers.forEach(function(item){

				item.spectrum('destroy');
			});

			self.Helpers.colorpickers = [];
		}

		jQuery('.temp-styles-for-module', LiveComposer.Builder.PreviewAreaDocument).remove();
		jQuery('.sp-container').remove();

		// Hide inline editor panel if on [Confirm] or [Cancel] button click.
		jQuery('.mce-tinymce', LiveComposer.Builder.PreviewAreaDocument).hide();
	}

	/** Options dependencies */
	LiveComposer.Builder.Helpers.depsHandlers = [];

	LiveComposer.Builder.UI.loadOptionsDeps = function() {

		var self = this;

		$(".dslca-module-edit-option").each(function(){

			var elem = this;
			var parsed = true;

			try {

				var dep = JSON.parse( LiveComposer.Utils.b64_to_utf8( $(this).data('dep') ) );

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

							var opt_wrap = $(".dslca-module-edit-option-" + item.trim()).closest('.dslca-module-edit-option');
							var checkedCheckbox = true;

							if ( optElem.type == 'radio' || optElem.type == 'checkbox' ) {

								checkedCheckbox = $(optElem).is(":checked");
							}

							if ( optElem.value == opt_val && checkedCheckbox ) {

								opt_wrap.show();
							} else {

								opt_wrap.hide();
							}
						});
					});
				}

				$(document).on('change dslc-init-deps', '.dslca-module-edit-option *[data-id="' + $(this).data('id') + '"]', handler);
				self.Helpers.depsHandlers.push( handler );
			}
		});

		$(".dslca-module-edit-option input, .dslca-module-edit-option select").trigger('dslc-init-deps');
	}

	LiveComposer.Builder.UI.unloadOptionsDeps = function() {

		self.Helpers.depsHandlers.forEach(function(handler){

			$(document).unbind( 'change', handler );
			$(document).unbind( 'dslc-init-deps', handler );
		});

		self.Helpers.depsHandlers = [];
	}

	/**
	 * Creates inline style tag when editing WYSWIG
	 *
	 * @param  {object} params
	 *    params.rule
	 *    params.elems
	 *    params.module_id
	 */
	LiveComposer.Builder.Helpers.processInlineStyleTag = function( params ) {

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

		if ( LiveComposer.Builder.PreviewAreaDocument[0].getElementById(id) == null ) {

			var styleTag = document.createElement('style');
			styleTag.innerHTML = params.styleContent;
			styleTag.id = id;
			styleTag.className = "temp-styles-for-module";

			LiveComposer.Builder.PreviewAreaDocument[0].body.appendChild(styleTag);
		} else {

			LiveComposer.Builder.PreviewAreaDocument[0].getElementById(id).innerHTML = params.styleContent;
		}
	}

	LiveComposer.Builder.UI.shakePanelConfirmButton = function() {

		jQuery('.dslca-module-edit-save').addClass('lc-shake-effect active');

		setTimeout(function(){

			jQuery('.dslca-module-edit-save').removeClass('lc-shake-effect active');
		}, 1000);
	};
}());


/**
 * MODULES SETTINGS PANEL - Filter Module Options
 */
function dslc_module_options_section_filter( sectionID ) {

	if ( dslcDebug ) console.log( 'dslc_module_options_section_filter' );

	// Hide all options
	jQuery('.dslca-module-edit-option').hide();

	// Show options for current section
	jQuery('.dslca-module-edit-option[data-section="' + sectionID + '"]').show();

	// Recall module options tab
	dslc_module_options_tab_filter();
}

/**
 * MODULES SETTINGS PANEL - Show module options tab
 */
function dslc_module_options_tab_filter( dslcTab ) {

	if ( dslcDebug ) console.log( 'dslc_module_options_tab_filter' );

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
			dslc_module_output_altered(function(){

				// Hide the loader
				jQuery('.dslca-container-loader').hide();
			});
		}
	}

	// Scroll horizontally options panel to the left (not ready)
	// jQuery('.dslca-module-edit-options-wrapper').offset({ left: 20 });
}

/**
 * MODULES SETTINGS PANEL - Hide show tabs based on option choices
 */
function dslc_module_options_hideshow_tabs() {

	if ( dslcDebug ) console.log( 'dslc_module_options_hideshow_tabs' );

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
		dslcElAuthorPos = true;


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

	}

	/**
	 * Check 'Enable/Disable Custom CSS' control
	 */

	if ( jQuery('.dslca-options-filter-hook[data-section="styling"]').hasClass('dslca-active') ) {

		if ( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).data('dslc-module-id') == 'DSLC_Text_Simple' ||
			  jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).data('dslc-module-id') == 'DSLC_TP_Content' || 
			  jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).data('dslc-module-id') == 'DSLC_Html' ) {

			var dslcCustomCSS = jQuery('.dslca-module-edit-option[data-id="css_custom"]'),
			dslcCustomCSSVal = dslcCustomCSS.find('select').val();

			if ( dslcCustomCSSVal == 'enabled' ) {

				jQuery('.dslca-module-edit-option[data-section="styling"]').css({ visibility : 'visible' });
				jQuery('.dslca-module-edit-options-tabs').show();
			} else {
				jQuery('.dslca-module-edit-option[data-section="styling"]').css({ visibility : 'hidden' });
				jQuery('.dslca-module-edit-options-tabs').hide();
				dslcCustomCSS.css({ visibility : 'visible' });
			}

		}

	} else {
		jQuery('.dslca-module-edit-options-tabs').show();
	}

	if ( jQuery('select.dslca-module-edit-field[data-id="css_res_t"]').val() == 'disabled' ) {
		jQuery('.dslca-module-edit-option[data-id*="css_res_t"]').css( 'visibility', 'hidden' );
	} else {
		jQuery('.dslca-module-edit-option[data-id*="css_res_t"]').css( 'visibility', 'visible' );
	}

	if ( jQuery('select.dslca-module-edit-field[data-id="css_res_p"]').val() == 'disabled' ) {
		jQuery('.dslca-module-edit-option[data-id*="css_res_p"]').css( 'visibility', 'hidden' );
	} else {
		jQuery('.dslca-module-edit-option[data-id*="css_res_p"]').css( 'visibility', 'visible' );
	}

	jQuery('.dslca-module-edit-option[data-id="css_res_p"], .dslca-module-edit-option[data-id="css_res_t"]').css( 'visibility', 'visible' );
}

/**
 * MODULES SETTINGS PANEL - Confirm module options changes
 */
function dslc_module_options_confirm_changes( callback ) {

	if ( dslcDebug ) console.log( 'dslc_module_options_confirm_changes' );

	// Callback
	callback = typeof callback !== 'undefined' ? callback : false;

	// If slider module
	if ( jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).hasClass('dslc-module-DSLC_Sliders') ) {

		jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');
	// If not slider module
	} else {

		// Add class so we know saving is in progress
		jQuery('body').addClass('dslca-module-saving-in-progress');

		// Reload module with new settings
		dslc_module_output_altered( function(){

			// Update preset
			dslc_update_preset();

			dslc_generate_code();

			jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');

			// Remove classes so we know saving finished
			jQuery('body').removeClass('dslca-module-saving-in-progress');
			// Clean up options container
			if ( ! jQuery('body').hasClass('rtl') ) {

				jQuery('.dslca-module-edit-options-inner').html('');
			} else {

				jQuery('.dslca-module-edit-options-inner').html('');
			}

			jQuery('.dslca-module-edit-options-tabs').html('');

			// Callback if there's one
			if ( callback ) { callback(); }
		});
	}

	// Show modules listing
	dslc_show_section('.dslca-modules');

	// Hide the filter hooks
	jQuery('.dslca-header .dslca-options-filter-hook').hide();

	// Hide the save/cancel actions
	jQuery('.dslca-module-edit-actions').hide();

	// Show the section hooks
	jQuery('.dslca-header .dslca-go-to-section-hook').show();

	// dslc_generate_code();
	// Show the publish button
	dslc_show_publish_button();
}

/**
 * MODULES SETTINGS PANEL - Cancel module options changes
 */
function dslc_module_options_cancel_changes( callback ) {

	if ( dslcDebug ) console.log( 'dslc_module_options_cancel_changes' );

	// Callback
	callback = typeof callback !== 'undefined' ? callback : false;

	// Vars
	var editedModule = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument);

	// Add backup option values
	jQuery('.dslca-module-options-front', editedModule).html('').append(LiveComposer.Builder.moduleBackup);
	LiveComposer.Builder.moduleBackup = false;

	// Reload module
	dslc_module_output_altered( function(){

		dslc_generate_code();

		jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-module-being-edited');

		// Clean up options container
		if ( ! jQuery('body').hasClass('rtl') ) {

			jQuery('.dslca-module-edit-options-inner').html('');
		} else {

			jQuery('.dslca-module-edit-options-inner').html('');
		}

		jQuery('.dslca-module-edit-options-tabs').html('');
		if ( callback ) { callback(); }
	});

	// Show modules listing
	dslc_show_section('.dslca-modules');

	// Hide the filter hooks
	jQuery('.dslca-header .dslca-options-filter-hook').hide();

	// Hide the save/cancel actions
	jQuery('.dslca-module-edit-actions').hide();

	// Show the section hooks
	jQuery('.dslca-header .dslca-go-to-section-hook').show();

	// Show the publish button
	dslc_show_publish_button();
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
		dslcTtipContent = dslcHook.closest('.dslca-module-edit-option').find('.dslca-module-edit-field-ttip-content').html();

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
function dslc_module_options_font() {

	// Next Font
	jQuery(document).on( 'click', '.dslca-module-edit-field-font-next',  function(e){

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
	});

	// Previous Font
	jQuery(document).on( 'click', '.dslca-module-edit-field-font-prev',  function(e){

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
	});

	// Keyup ( left arrow, right arrow, else )
	jQuery(document).on( 'keyup', '.dslca-module-edit-field-font', function(e) {

		var dslcField, dslcOption, dslcVal, dslcMatchingFont = false, dslcFont;

		dslcField = jQuery(this);
		dslcOption = dslcField.closest('.dslca-module-edit-option');

		if ( e.which == 38 ) {
			jQuery('.dslca-module-edit-field-font-prev', dslcOption).click();
		}

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
			} else {

				dslcFont = dslcMatchingFont;
				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).show();
			}

			jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text( dslcFont );

			if ( dslcFont.length ){

				dslcField.val( dslcFont.substring( 0 , dslcField.val().length ) );
			}
		}
	});

	// Key press ( enter )
	jQuery(document).on( 'keypress', '.dslca-module-edit-field-font', function(e) {

		if ( e.which == 13 ) {

			e.preventDefault();

			var dslcField, dslcOption, dslcVal, dslcMatchingFont, dslcFont;

			dslcField = jQuery(this);
			dslcOption = dslcField.closest('.dslca-module-edit-option');

			jQuery(this).val( jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text() ).trigger('change');

			jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');
		}
	});
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
		dslc_hide_modal( '', jQuery('.dslca-modal:visible') );
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

	if ( dslcDebug ) console.log( 'dslc_module_options_box_shadow' );

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

	if ( dslcDebug ) console.log( 'dslc_module_options_text_shadow' );

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

	if ( dslcDebug ) console.log( 'dslc_module_options_color' );

	var dslcColorField,
	dslcAffectOnChangeEl,
	dslcAffectOnChangeRule,
	dslcColorFieldVal,
	dslcModule,
	dslcOptionID,
	dslcCurrColor;

	/**
	 * Color Pallete
	 */

	var dslcColorPallete = [],
	currStorage,
	index;

	dslcColorPallete[0] = [];
	dslcColorPallete[1] = [];
	dslcColorPallete[2] = [];
	dslcColorPallete[3] = [];

	if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
	} else {

		currStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );

		for	( index = 0; index < currStorage.length; index++ ) {

			var key = Math.floor( index / 3 );

			if ( key < 4 ) {

				dslcColorPallete[key].push( currStorage[index] );
			}
		}
	}

	var query = field;

	jQuery(query).each( function(){

		dslcCurrColor = jQuery(this).val();

		jQuery(this).spectrum({
			color: dslcCurrColor,
			showInput: true,
			allowEmpty: true,
			showAlpha: true,
			// showInitial: true,
			clickoutFiresChange: true,
			cancelText: '',
			chooseText: '',
			preferredFormat: 'rgb',
			showPalette: true,
			palette: dslcColorPallete,
			move: function( color ) {

				// The option field
				dslcColorField = jQuery(this);

				// The new color
				if ( color == null ) {

					dslcColorFieldVal = '';
					// dslcColorFieldVal = 'transparent';
				} else {

					dslcColorFieldVal = color.toRgbString().replace(/ /g,'');
				}

				// Change current value of option
				dslcColorField.val( dslcColorFieldVal ).trigger('change');
				dslcColorField.css('background', dslcColorFieldVal);

				// Live change
				dslcAffectOnChangeEl = dslcColorField.data('affect-on-change-el');
				dslcAffectOnChangeRule = dslcColorField.data('affect-on-change-rule');

				// ROWs doesn't have 'dslcAffectOnChangeEl' defined
				if ( null != dslcAffectOnChangeEl ) {
					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcColorFieldVal );
				}

				// Update option
				dslcModule = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument);
				dslcOptionID = dslcColorField.data('id');
				jQuery('.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule).val( dslcColorFieldVal );

				// Add changed class
				dslcModule.addClass('dslca-module-change-made');
			},
			change: function( color ) {

				// The option field
				dslcColorField = jQuery(this);

				// The new color
				if ( color == null ) {

					dslcColorFieldVal = '';
					// dslcColorFieldVal = 'transparent';
				} else {

					dslcColorFieldVal = color.toRgbString().replace(/ /g,'');
				}

				// Change current value of option
				dslcColorField.val( dslcColorFieldVal ).trigger('change');

				// Live change
				dslcAffectOnChangeEl = dslcColorField.data('affect-on-change-el');
				dslcAffectOnChangeRule = dslcColorField.data('affect-on-change-rule');

				// ROWs doesn't have 'dslcAffectOnChangeEl' defined
				if ( null != dslcAffectOnChangeEl ) {
					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcColorFieldVal );
				}

				// Update option
				dslcModule = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument);
				dslcOptionID = dslcColorField.data('id');
				jQuery('.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule).val( dslcColorFieldVal );

				// Add changed class
				dslcModule.addClass('dslca-module-change-made');

				// Update pallete local storage
				if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {

					var newStorage = [ dslcColorFieldVal ];
					localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
				} else {

					var newStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );

					if ( newStorage.indexOf( dslcColorFieldVal ) == -1 ) {

						newStorage.unshift( dslcColorFieldVal );
					}

					localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
				}

			},
			show: function( color ) {
				jQuery('body').addClass('dslca-disable-selection');
			},
			hide: function() {
				jQuery('body').removeClass('dslca-disable-selection');
			}
		});

		// Save this element to destroy on panel closed.
		LiveComposer.Builder.Helpers.colorpickers.push( jQuery(this) );
	});

	// Revert to default
	jQuery('.dslca-sp-revert').click(function(){

		var defValue = jQuery('.sp-replacer.sp-active').closest('.dslca-module-edit-option').find('.dslca-module-edit-field').data('default');

		jQuery(this).closest('.sp-container').find('.sp-input').val( defValue ).trigger('change');
	});
}

/**
 * MODULES SETTINGS PANEL - Numeric Option Type
 */
function dslc_module_options_numeric( field ) {

	var $ = jQuery;

	if ( dslcDebug ) console.log( 'dslc_module_options_numeric' );

	var query = field || '.dslca-module-edit-option-slider .dslca-module-edit-field-numeric';

	jQuery(query).each(function(){

		if( this.classList.contains('slider-initiated') ) return;

		var handle = false;
		var pseudoelement = false;
		var temp = 0;
		var sliderInput = this;
		var prev_pos = 0;


		/*
		var max = 2000;
		var min = -2000;
		var inc = 1;
		*/

		var max = parseFloat(jQuery(this).data('max')) > 0 ? parseFloat($(this).data('max')) : 2000;
		var min = parseFloat(jQuery(this).data('min')) > -2000 ? parseFloat($(this).data('min')) : 0;
		var inc = parseFloat(jQuery(this).data('increment')) > 0 ? parseFloat($(this).data('increment')) : 1;

		var dslcSlider, dslcSliderField, dslcSliderInput, dslcSliderVal, dslcAffectOnChangeRule, dslcAffectOnChangeEl,
		dslcSliderTooltip, dslcSliderTooltipOffset, dslcSliderTooltipPos, dslcModule, dslcOptionID, dslcSliderExt,
		dslcAffectOnChangeRules;

		sliderInput.classList.add("slider-initiated");

		jQuery(sliderInput).keyup(function(e){

			// In some rare cases we have the next error:
			// TypeError: undefined is not an object (evaluating 'a.key.match')
			if (undefined === e) {

				return false;
			}

			// Shift + Up/Down
			if( e.shiftKey ) {

				if( e.keyCode == 38 ) {

					this.value = ( parseInt(this.value) || 0 ) + 9;
					jQuery(this).trigger('change');
				}

				if( e.keyCode == 40 ) {

					this.value = ( parseInt(this.value) + 0 ) - 9;
					jQuery(this).trigger('change');
				}
			}

			// Backspace, "-"
			if( e.keyCode == 8 || e.keyCode == 45 ) {
				jQuery(this).trigger('change');
			}

			// If number key pressed
			if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105)) {
				jQuery(this).trigger('change');
			}


			if( ! e.key.match(/\d/) && e.keyCode != 8 && e.keyCode != 39 && e.keyCode != 37 && e.keyCode != 46 ) {

				return false;
			}
		});

		jQuery(sliderInput).unbind('change');
		jQuery(sliderInput).change(function(e){

			if( this.value > max ) {

				this.value = max;
			}

			if( this.value < min ) {

				this.value = min;
			}

			dslcModule = jQuery('.dslca-module-being-edited', LiveComposer.Builder.PreviewAreaDocument);

			// Add changed class
			dslcModule.addClass('dslca-module-change-made');
		});

		jQuery(document).mouseup(function(){

			handle = false;
		});

		jQuery(sliderInput).mousedown(function(e){

			// Set handle to the point were we started to drag mouse from
			handle = parseFloat(e.pageX);
			temp = parseFloat(sliderInput.value && sliderInput.value != '' ? sliderInput.value : 0);
			prev_pos = 0;

		});

		jQuery('.dslca-section').mousemove(function(e){

			// Process only if we dragging slider handle, not just move mouse over
			if( handle !== false ) {
				e = e || window.event;

				var x = e.clientX;

				var this_move = x - prev_pos;

				if ( 0 < this_move ) {

					sliderInput.value = Math.round( ( parseFloat(sliderInput.value) + inc ) * 100) / 100;
				} else {

					sliderInput.value = Math.round( ( parseFloat(sliderInput.value) - inc ) * 100) / 100;
				}

				prev_pos = x;

				jQuery(sliderInput).trigger('change');
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
function dslc_show_module_options_tab( tab ) { dslc_module_options_tab_filter( tab ); }
function dslc_confirm_changes( callback ) { dslc_module_options_confirm_changes( callback ); }
function dslc_cancel_changes( callback ) { dslc_module_options_cancel_changes( callback ); }
function dslc_init_colorpicker() { dslc_module_options_color(); }
function dslc_init_options_slider() { dslc_module_options_numeric(); }
function dslc_module_edit_options_hideshow_tabs() { dslc_module_options_hideshow_tabs(); }