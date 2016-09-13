/**
 * Modules row class
 */

'use strict';

/**
 * Builder row class
 */

LiveComposer.Builder.Elements.CRow = function(elem) {

	var self = this;
	this.elem = elem;


	var sortableContainer = jQuery( elem ).find('.dslc-modules-section-wrapper .dslc-modules-section-inner').eq(0)[0];

	jQuery( elem ).droppable({
		drop: function( event, ui ) {
			var modulesSection = jQuery(this).find('.dslc-modules-section-inner');
			var moduleID = ui.draggable.data( 'id' );
			if ( moduleID == 'DSLC_M_A' ) {

				dslc_modules_area_add( modulesSection );
			}
		}
	});

	this.sortable = jQuery( sortableContainer ).sortable({
		connectWith: '.dslc-modules-section-inner',
		items: ".dslc-modules-area",
		handle: '.dslca-move-modules-area-hook:not(".dslca-action-disabled")',
		placeholder: 'dslca-modules-area-placeholder',
		cursorAt: { top: 0, left: 0 },
		tolerance : 'intersect',
		scroll: true,
		scrollSensitivity: 100,
		scrollSpeed : 15,
		sort: function() {

			jQuery( this ).removeClass( "ui-state-default" );
		},
		over: function (e, ui) {

			var dslcSection = ui.placeholder.closest('.dslc-modules-section');

			jQuery(dslcSection).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');

			dslcSection.siblings('.dslc-modules-section').each( function(){
				if ( jQuery('.dslc-modules-area:not(.ui-sortable-helper)', jQuery(this)).length ) {
					jQuery(this).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');
				} else {
					jQuery(this).removeClass('dslc-modules-section-not-empty').addClass('dslc-modules-section-empty');
				}
			});
		},
		remove: function() {

			(jQuery(self.elem).find('.dslc-modules-area').length == 0) && dslc_modules_area_add(jQuery(sortableContainer));
		},
		update: function (e, ui) {

			dslc_generate_code();
			dslc_show_publish_button();
		},
		start: function(e, ui){

			// Placeholder
			ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + DSLCString.str_area_helper_text + '</span></span>');
			if ( ! jQuery(ui.item).hasClass('dslc-12-col') ) {
				ui.placeholder.width(ui.item.width() - 10)
			} else {
				ui.placeholder.width(ui.item.width()).css({ margin : 0 });
			}

			// Add drag in progress class
			jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress dslca-modules-area-drag-in-progress');

			// Refresh positions
			jQuery( '.dslc-modules-section-inner' ).sortable( "refreshPositions" );

		},
		stop: function(e, ui){

			LiveComposer.Builder.UI.stopScroller();
			jQuery('body').removeClass('dslca-drag-in-progress dslca-modules-area-drag-in-progress').addClass('dslca-drag-not-in-progress');
			jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');
		},
		change: function( e, ui ) {

		}
	});

	// Mark section as initialized
	jQuery( elem ).attr('data-jsinit', 'initialized');

	/** Sort option setter */
	jQuery(document).on('LC.sortableOff', function(){
		if ( undefined !== self.sortable.sortable( "instance" ) ) {
			self.sortable.sortable('option','disabled', true);
		}
	});

	jQuery(document).on('LC.sortableOn', function(){
		if ( undefined !== self.sortable.sortable( "instance" ) ) {
			self.sortable.sortable('option','disabled', false);
		}
	});
}