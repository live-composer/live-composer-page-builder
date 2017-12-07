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
		jQuery( '#page-builder-frame' ).contents().find( 'html, body' ).animate( { scrollTop: jQuery( '#page-builder-frame' ).contents().find( '.dslca-add-modules-section' ).offset().top }, 'slow' );
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
			show = ( jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel' ).css( 'left' ) === '0px' ) ? 0 : 1;
		}

		if ( 1 === show ) {
			// Show
			jQuery( '#page-builder-frame' ).contents().find( '#lcps-activate-butt span.dslca-icon' )
					.removeClass( 'dslc-icon-windows' )
					.addClass( 'dslc-icon-cog dslc-icon-spin' );
			jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel' ).css( 'display', 'block' );
			jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel' ).animate( {
				left: '0px'
			}, 500, 'linear', function() {
				jQuery( '#page-builder-frame' ).contents().find( '#lcps-activate-butt span.dslca-icon' )
						.removeClass( 'dslc-icon-spin dslc-icon-cog' )
						.addClass( 'dslc-icon-arrow-up' );
			});

			// Hide LC menu
			dslc_hide_composer();
		}
		else {
			// Hide
			var leftPx = '-' + jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel' ).css( 'width' );
			jQuery( '#page-builder-frame' ).contents().find( '#lcps-activate-butt span.dslca-icon' )
					.removeClass( 'dslc-icon-arrow-up' )
					.addClass( 'dslc-icon-cog dslc-icon-spin' );
			jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel' ).animate( {
				left: leftPx // this number in css file to
			}, 250, 'linear', function() {
				jQuery( '#page-builder-frame' ).contents().find( '#lcps-activate-butt span.dslca-icon' )
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
		jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel > .body > .menu' ).css( 'display', 'none' );
	},

	groupSelectShow: function () {
		// Show/hide select
		if ( jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel > .body > .menu' ).css( 'display' ) !== 'block' )
			jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel > .body > .menu' ).css( 'display', 'block' );
		else
			lcps.groupSelectHide();

		jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel > .body > .menu li' ).on( 'click', function() {

			// hide all groups
			jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel > .body ul.elements' ).each( function() { jQuery( this ).removeClass( 'active' ); });

			// show current group
			var me = '#lcps-panel > .body #' + jQuery( this ).attr( 'rel' );
			jQuery( '#page-builder-frame' ).contents().find( me ).addClass( 'active' );

			// change title
			jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel .groupTitle span.title' ).text( jQuery( this ).text() );

			// hide select after click
			lcps.groupSelectHide();
		});
	},

	elementOptionsHide: function () {
		jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel ul.elements li .dropdown-menu' )
			.css( 'display', 'none' );
	},

	elementOptionsShow: function ( el ) {
		lcps.elementOptionsHide();
		lcps.groupSelectHide();

		el.closest( 'li' ).find( '.dropdown-menu' ).css( 'display', 'block' );

		jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel' ).on( 'mouseleave', function() {
			jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel' ).off( 'mouseleave');
			lcps.elementOptionsHide();
		});
		jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel' ).on( 'click', function() {
			lcps.elementOptionsHide();
		});
	},

	addSection: function ( el ) {
		var dslc_modules_section_code = el.find( '.shortcode' ).text();

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


	jQuery( '#page-builder-frame' ).contents().find('#lcps-panel').fadeIn( 450 );
	jQuery( '#lcps-panel' ).fadeIn( 450 );

	// Show group selector
	jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel .groupTitle' ).off();
	jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel .groupTitle' ).on( 'click', function( e ) {
		lcps.groupSelectShow();

		e.stopPropagation();
		lcps.elementOptionsHide();

		// Hide group selector if click everywhere
		jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel' ).on( 'click', function() {
			lcps.groupSelectHide();
		});
	});

	// Panel view
	jQuery( '#page-builder-frame' ).contents().find( '#lcps-activate-butt' ).off();
	jQuery( '#page-builder-frame' ).contents().find( '#lcps-activate-butt' ).on( 'click', function( event ) {
		lcps.panelShow();

		// Close panel after body click
		event.stopPropagation();
		jQuery( '#page-builder-frame' ).contents().find( '#dslc-main' ).on( 'click', function() {
			lcps.panelShow( 0 );
			jQuery( this ).off( 'click' );
			jQuery( '#page-builder-frame' ).contents().find( '.dslca-show-composer-hook' ).off( 'click' );
		});
		jQuery( '#page-builder-frame' ).contents().find( '.dslca-show-composer-hook' ).on( 'click', function() {
			lcps.panelShow( 0 );
			jQuery( this ).off( 'click' );
			jQuery( '#page-builder-frame' ).contents().find( '#dslc-main' ).off( 'click' );
		});
	});

	// Show element options
	jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel ul.elements li .options' ).off( 'click' );
	jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel ul.elements li .options' ).on( 'click', function( e ) {
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
	jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel ul.elements li' ).off( 'click' );
	jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel ul.elements li' ).on( 'click', function() {
		lcps.addSection( jQuery( this ) );
	});

	// Delete ps
	jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel ul.elements li .deleteElement' ).on( 'click', function() {
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

	/*jQuery( '#page-builder-frame' ).contents().find( '#lcps-panel ul.elements li .img-form' ).draggable({
		revert: true,
		helper: 'clone',
		stop: function() {
			lcps.addSection( jQuery( this ).closest('li.ps') );
		},
		appendTo: 'body',
		containment: 'window',
		scroll: false
	});*/
});