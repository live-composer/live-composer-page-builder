'use strict';

// Keyboard work
window.onkeydown = function( e ) {
	var event = e || window.event;
	var code = event.which || event.keyCode;

	// console.log( code );

	switch ( code ) {
		case 27: // ESC: close Panel
			lcps.panelShow( 0 );
			break;
	}
};

var lcps_drag = {

};



var lcps = {
	// Scroll bottom
	scrollBottom: function () {
		// jQuery(  'html, body' ).animate( { scrollTop: jQuery(  '.dslca-add-modules-section' ).offset().top }, 'slow' );
	},

	getJson: function ( str ) {
		if ( 'object' === typeof( str ) )
			return str;

		if ( !str || '' === str || 'string' !== typeof( str ) )
			return false;

		var jData = jQuery.parseJSON( str );

		if ( !is_object( jData ) )
			return false;

		return jData;
	},

	// Panel position/visibility
	panelShow: function ( show ) {
		if ( 'undefined' === typeof( show ) ) {
			show = ( jQuery(  '#lcps-panel' ).css( 'left' ) === '0px' ) ? 0 : 1;
		}

		if ( 1 === show ) {

			jQuery(  '#lcps-panel' ).addClass( 'lcps-panel--open' );
			// Show
			jQuery(  '#lcps-activate-butt span.dslca-icon' )
					.removeClass( 'dslc-icon-windows' )
					.addClass( 'dslc-icon-cog dslc-icon-spin' );
			jQuery(  '#lcps-panel' ).css( 'display', 'block' );
			jQuery(  '#lcps-panel' ).animate( {
				left: '0px'
			}, 250, 'swing', function() {
				jQuery(  '#lcps-activate-butt span.dslca-icon' )
						.removeClass( 'dslc-icon-spin dslc-icon-cog' )
						.addClass( 'dslc-icon-arrow-up' );
			});

			// Hide LC menu
			dslc_hide_composer();
		}
		else {
			jQuery(  '#lcps-panel' ).removeClass( 'lcps-panel--open' );
			// Hide
			var leftPx = '-' + jQuery(  '#lcps-panel' ).css( 'width' );
			jQuery(  '#lcps-activate-butt span.dslca-icon' )
					.removeClass( 'dslc-icon-arrow-up' )
					.addClass( 'dslc-icon-cog dslc-icon-spin' );
			jQuery(  '#lcps-panel' ).animate( {
				left: leftPx // this number in css file to
			}, 250, 'swing', function() {
				jQuery(  '#lcps-activate-butt span.dslca-icon' )
						.removeClass( 'dslc-icon-spin dslc-icon-cog' )
						.addClass( 'dslc-icon-windows' );
				lcps.scrollBottom();
			});

			// Show LC menu
			dslc_show_composer();
			// Hide category selection
			lcps.groupSelectHide();
			// Hide elements options
			lcps.elementOptionsHide();
		}
	},

	groupSelectHide: function () {
		jQuery(  '#lcps-panel > .body > .menu' ).css( 'display', 'none' );
	},

	groupSelectShow: function () {
		// Show/hide select
		if ( jQuery(  '#lcps-panel > .body > .menu' ).css( 'display' ) !== 'block' )
			jQuery(  '#lcps-panel > .body > .menu' ).css( 'display', 'block' );
		else
			lcps.groupSelectHide();

		jQuery(  '#lcps-panel > .body > .menu li' ).on( 'click', function() {

			// hide all groups
			jQuery(  '#lcps-panel > .body ul.elements' ).each( function() { jQuery( this ).removeClass( 'active' ); });

			// show current group
			var me = '#lcps-panel > .body #' + jQuery( this ).attr( 'rel' );
			jQuery(  me ).addClass( 'active' );

			// change title
			jQuery(  '#lcps-panel .groupTitle span.title' ).text( jQuery( this ).text() );

			// hide select after click
			lcps.groupSelectHide();
		});
	},

	groupMouseIn: function ( category ) {
		console.log( 'groupMouseIn' );

		jQuery('.lcps-designs__category').hide();

		jQuery('.lcps-designs').addClass('lcps-designs--open');
		console.log( "jQuery('.lcps-designs__category .' + category ):" ); console.log( jQuery('.lcps-designs__category .' + category ) );
		jQuery('.lcps-designs__category.' + category ).show();
	},

	panelMouseOut: function ( category ) {
		console.log( 'groupMouseOut' );
		jQuery('.lcps-designs').removeClass('lcps-designs--open');
		jQuery('.lcps-designs__category').hide();
	},

	elementOptionsHide: function () {
		jQuery(  '#lcps-panel ul.elements li .dropdown-menu' )
			.css( 'display', 'none' );
	},

	elementOptionsShow: function ( el ) {
		lcps.elementOptionsHide();
		lcps.groupSelectHide();

		el.closest( 'li' ).find( '.dropdown-menu' ).css( 'display', 'block' );

		jQuery(  '#lcps-panel' ).on( 'mouseleave', function() {
			jQuery(  '#lcps-panel' ).off( 'mouseleave');
			lcps.elementOptionsHide();
		});
		jQuery(  '#lcps-panel' ).on( 'click', function() {
			lcps.elementOptionsHide();
		});
	},

	addSection: function ( el ) {
		console.log( "addSection: function :" );
		console.log( "el:" ); console.log( el );
		var dslc_modules_section_code = el.find( '.shortcode' ).html();

		console.log( "dslc_modules_section_code:" ); console.log( dslc_modules_section_code );

		if ( !dslc_modules_section_code )
			return;

		// Add section
		dslc_import_modules_section( dslc_modules_section_code );

		// Scroll bottom
		setTimeout( function() {
			lcps.panelShow( 0 );
			lcps.scrollBottom();
		}, 500 );
	}
};



// Load after LC ready
jQuery( window ).load( function() {

	jQuery( 'iframe#page-builder-frame' ).contents().find('#dslc-content').css( 'padding-bottom: 50px;' );

	// Show panel/button
	jQuery( '#lcps-panel' ).fadeIn( 450 );
	jQuery( '#lcps-panel' ).fadeIn( 450 );

	jQuery(  '#lcps-panel .lcps_cat' ).hoverIntent({
		over: function( e ) {
			var category = e.target.dataset.designCategory;

			jQuery('.lcps_cat--selected').each( function(index, element) {
				element.classList.remove('lcps_cat--selected');
			});

			e.target.classList.add('lcps_cat--selected');
			lcps.groupMouseIn( category );
		},
		out: jQuery.noop, // empty function required by hoverIntent if 'out' not used.
		// sensitivity: 1,
		timeout: 0 //200
	});

	jQuery(  '.lcps-designs' ).on( 'mouseleave', function( e ) {
		// Don't close panel if going back to categories selector.
		if ( e.toElement !== null && e.toElement.classList.contains('lcps_cat') ) {
			return;
		}
		lcps.panelMouseOut();
	});

	// Show group selector
	jQuery(  '#lcps-panel .groupTitle' ).off();
	jQuery(  '#lcps-panel .groupTitle' ).on( 'click', function( e ) {
		lcps.groupSelectShow();

		e.stopPropagation();
		lcps.elementOptionsHide();

		// Hide group selector if click everywhere
		jQuery(  '#lcps-panel' ).on( 'click', function() {
			lcps.groupSelectHide();
		});
	});

	// Panel view
	jQuery(  '#lcps-activate-butt' ).off();
	jQuery(  '#lcps-activate-butt' ).on( 'click', function( event ) {
		lcps.panelShow();

		// Close panel after body click
		event.stopPropagation();
		jQuery(  '#dslc-main' ).on( 'click', function() {
			lcps.panelShow( 0 );
			jQuery( this ).off( 'click' );
			jQuery(  '.dslca-show-composer-hook' ).off( 'click' );
		});
		jQuery(  '.dslca-show-composer-hook' ).on( 'click', function() {
			lcps.panelShow( 0 );
			jQuery( this ).off( 'click' );
			jQuery(  '#dslc-main' ).off( 'click' );
		});
	});

	// Show element options
	jQuery(  '#lcps-panel ul.elements li .options' ).off( 'click' );
	jQuery(  '#lcps-panel ul.elements li .options' ).on( 'click', function( e ) {
		e.stopPropagation();

		var menu = jQuery( this )
					.closest( 'li' )
					.find( '.dropdown-menu' );

		if ( 'block' === menu.css( 'display' ) )
			lcps.elementOptionsHide();
		else
			lcps.elementOptionsShow( jQuery( this ) );
	});

	// Add Predisegned section
	jQuery(  '#lcps-panel ul.elements li' ).off( 'click' );
	jQuery(  '.lcps-designs .lcps-designs__single' ).on( 'click', function() {
		console.log('tttt');
		console.log( "jQuery( this ):" ); console.log( jQuery( this ) );
		lcps.addSection( jQuery( this ) );
	});

	// Delete ps
	jQuery(  '#lcps-panel ul.elements li .deleteElement' ).on( 'click', function() {
		lcps.elementOptionsHide();

		if ( !confirm( 'Are you sure you want to delete the record?' ) )
			return;

		var el = this;
		jQuery.post('', { 'delete_ps': jQuery( this ).attr( 'rel' ) }, function( data ) {
			if ( data !== "" ) {
				// var parsed = jQuery('<div/>').append( data );
				// panel_html = parsed.find( '#lcps-panel' ).html();
				// Replace panel HTML
				jQuery( el ).closest('li.ps').fadeOut(300, function() {
					//jQuery( this ).remove();
				});
			}
		});
	});
});