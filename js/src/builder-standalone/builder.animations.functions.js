/*********************************
 *
 * = UI - ANIMATIONS =
 *
 * - dslc_ui_animations ( Animations for the UI )
 *
 ***********************************/

'use strict';

	/**
	 * ANIMATIONS - Initiate
	 */

	function dslc_ui_animations() {

		if ( dslcDebug ) console.log( 'dslc_ui_animations' );

		// Mouse Enter/Leave - Module

		jQuery(document).on( 'mouseenter', '.dslca-modules-area-manage', function(){

			jQuery(this).closest('.dslc-modules-area').addClass('dslca-options-hovered');

			// dslca_draggable_calc_center( jQuery(this).closest('.dslc-modules-area') );

		}).on( 'mouseleave', '.dslca-modules-area-manage', function(){

			jQuery(this).closest('.dslc-modules-area').removeClass('dslca-options-hovered');

		});

		// Mouse Enter/Leave - Module

		jQuery(document).on( 'mouseenter', '.dslca-drag-not-in-progress .dslc-module-front', function(e){

			 if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				if ( jQuery(this).height() < 190 )
					jQuery('.dslca-module-manage', this).addClass('dslca-horizontal');
				else
					jQuery('.dslca-module-manage', this).removeClass('dslca-horizontal');

			}

		}).on( 'mouseleave', '.dslca-drag-not-in-progress .dslc-module-front', function(e){

			if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				// jQuery(this).find('.dslca-change-width-module-options').hide();

			}
		});

		// Mouse Enter/Leave - Modules Area

		jQuery(document).on( 'mouseenter', '.dslca-drag-not-in-progress .dslc-modules-area', function(e){

			var _this = jQuery(this);

			 if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				// jQuery('#dslc-header').addClass('dslca-header-low-z-index');

				if ( jQuery(this).height() < 130 )
					jQuery('.dslca-modules-area-manage', this).addClass('dslca-horizontal');
				else
					jQuery('.dslca-modules-area-manage', this).removeClass('dslca-horizontal');

			}

		}).on( 'mouseleave', '.dslca-drag-not-in-progress .dslc-modules-area', function(e){

			var _this = jQuery(this);

			if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				// jQuery('#dslc-header').removeClass('dslca-header-low-z-index');

			}

		});

	}

	/**
	 * ANIMATIONS - Document Ready
	 */

	jQuery(document).ready(function(){

		dslc_ui_animations();

	});