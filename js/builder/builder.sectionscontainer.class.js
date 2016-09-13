/**
 * Sections container class
 */

'use strict';

LiveComposer.Builder.Elements.CSectionsContainer = function(elem) {

	var self = this;

	this.sortable = jQuery(elem).sortable({
		items: ".dslc-modules-section",
		handle: '.dslca-move-modules-section-hook:not(".dslca-action-disabled")',
		placeholder: 'dslca-modules-section-placeholder',
		tolerance : 'intersect',
		cursorAt: { bottom: 10 },
		axis: 'y',
		scroll: true,
		scrollSensitivity: 140,
		scrollSpeed : 5,
		sort: function() {

			jQuery( this ).removeClass( "ui-state-default" );
		},
		update: function (e, ui) {

			dslc_show_publish_button();
		},
		start: function(e, ui){

			jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');
			jQuery('body', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');
			ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + DSLCString.str_row_helper_text + '</span></span>');
			jQuery( '.dslc-content' ).sortable( "refreshPositions" );
		},
		stop: function(e, ui){

			dslc_generate_code();

			LiveComposer.Builder.UI.stopScroller();
			jQuery('body', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
			jQuery('body').removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
			jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');
		}
	});


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