/**
 * Iframe builder main scripts
 */

var DSLC_Iframe = {};

/**
 * Action - Disable links from going anywhere in editing mode.
 */
jQuery(document).on( 'click', 'a:not(.dslca-link)', function(e){

	e.preventDefault();
});