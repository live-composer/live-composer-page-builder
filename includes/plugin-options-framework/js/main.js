jQuery(document).ready(function(){

	// Add a link 'Clear cache' in the performance section.
	jQuery('#lc_caching_engine').after(' <a href="#" class="dslc-clear-cache" onclick="dslc_clear_cache(event)"><span class="dashicons dashicons-trash"></span> clear cache</a>');

	function dslc_plugin_opts_generate_list_code( dslcTarget ) {

		// Vars
		var dslcTitle,
		dslcCodeInput = jQuery( '.dslca-plugin-opts-list-code', dslcTarget ),
		dslcCode = '',
		duplicateFound = false;


		// Populate array with all the names in the list
		var names = [];
		jQuery( '.dslca-plugin-opts-list-item', dslcTarget ).each( function(){
			if ( jQuery.inArray( jQuery(this).find('.dslca-plugin-opts-list-title').text(), names ) !== -1 ) {
				duplicateFound = true;
			} else {
				names.push( jQuery(this).find('.dslca-plugin-opts-list-title').text() );
			}
		});

		// If there are duplicates show the error message, otherwise hide
		if ( duplicateFound ) {
			jQuery('.dslca-plugin-opts-list-error').show();
		} else {
			jQuery('.dslca-plugin-opts-list-error').hide();
		}

		// Go through each
		jQuery( '.dslca-plugin-opts-list-item', dslcTarget ).each( function(){

			dslcTitle = jQuery(this).find('.dslca-plugin-opts-list-title').text();
			dslcTitle = dslcTitle.replace(/([^a-z0-9 ]+)/gi, ''); // Clean string leaving only letters and numbers
			jQuery(this).find('.dslca-plugin-opts-list-title').text(dslcTitle);
			dslcCode += dslcTitle.trim() + ','

		});

		dslcCodeInput.val( dslcCode );

	}

	jQuery('.dslca-plugin-opts-list-add-hook').click( function(e){

		e.preventDefault();

		var dslcWrapper = jQuery(this).closest('.dslca-plugin-opts-list-wrap');
		var dslcTarget = dslcWrapper.find('.dslca-plugin-opts-list');

		jQuery('<div class="dslca-plugin-opts-list-item"><span class="dslca-plugin-opts-list-title" contenteditable="true">Click to edit</span><a href="#" class="dslca-plugin-opts-list-delete-hook">delete</a></div>').appendTo( dslcTarget );

		dslc_plugin_opts_generate_list_code( dslcWrapper );

	});

	jQuery(document).on( 'click', '.dslca-plugin-opts-list-delete-hook', function(e){

		e.preventDefault();

		var dslcWrapper = jQuery(this).closest('.dslca-plugin-opts-list-wrap');
		var dslcTarget = jQuery(this).closest('.dslca-plugin-opts-list-item');

		dslcTarget.remove();

		dslc_plugin_opts_generate_list_code( dslcWrapper );

	});

	jQuery(document).on( 'blur', '.dslca-plugin-opts-list-title', function() {

		var dslcWrapper = jQuery(this).closest('.dslca-plugin-opts-list-wrap');
		dslc_plugin_opts_generate_list_code( dslcWrapper );

	});

	jQuery(document).on( 'keypress', '.dslca-plugin-opts-list-title', function(e) {

		if(e.keyCode==13){
			jQuery(this).trigger('blur');
			e.preventDefault();
		}

	});

	/**
	 * Enable/Disable premium extension via AJAX call.
	 */
	jQuery(document).on('click', '.lc-toggle-extension', function (e) {
		e.preventDefault();
		$extensionId = e.target.getAttribute('data-id');

		var parentEl = jQuery(e.target).closest('.extension');

		if (parentEl[0] !== undefined) {
			parentEl = parentEl[0];
		} else {
			console.error('Can\'t find extension parent for the clicked ellement.')
			return false;
		}

		var extensionStatus = parentEl.getAttribute('data-extension-status');

		parentEl.setAttribute('data-extension-status', 'pending');

		jQuery.ajax({
			type: "POST",
			data: {
				security: dslcajax,
				action: 'dslc-ajax-toggle-extension',
				extension: $extensionId
			},
			url: ajaxurl,
		}).done(function (response) {
			if (response) {
				// Update DIV attribute with a new status.
				parentEl.setAttribute('data-extension-status', response);
			} else {
				// Get back initial status on error.
				parentEl.setAttribute('data-extension-status', extensionStatus);
			}
		}).fail(function (response) {
			// Get back initial status on error.
			parentEl.setAttribute('data-extension-status', extensionStatus);
		})

	});

});



function dslc_clear_cache(e) {
	e.preventDefault();

	jQuery('.dslc-clear-cache .dashicons').removeClass('dashicons-trash').addClass('dashicons-update dashicon-spin');

	jQuery.ajax({
		type: "POST",
		data: {
			security: dslcajax,
			action: 'dslc_ajax_clear_cache',
		},
		url: ajaxurl,
	}).done(function() {
		jQuery('.dslc-clear-cache').css('color','green');
		jQuery('.dslc-clear-cache').text( 'done' );
		jQuery('.dslc-clear-cache').prepend('<span class="dashicons dashicons-yes"></span> ');
	});
}