/**
 * Soft scroll on "License is active" button.
 */
jQuery(document).on('click', '.lc-license-status-button', function (e) {
	e.preventDefault();

	jQuery('html, body').animate({
		scrollTop: jQuery('a[name="lc-license-block"]').offset().top
	}, 1000);
});

/**
 * Activate plugin license.
 */
jQuery(document).on('click', '.lc-toggle-license', function (e) {
	e.preventDefault();

	let buttonLabelBackup = jQuery(e.target).html();
	let actionType = e.target.getAttribute('data-action-type');
	let lincenseField = jQuery(e.target).closest('.lc-license-block').find('.lc-license-field');
	
	jQuery(e.target).html('<span class="dashicons dashicons-update"></span>');

	if ( 'activate' !== actionType && 'deactivate' !== actionType ) {
		return;
	}

	if ( lincenseField[0] !== undefined ) {
		lincenseField = lincenseField[0];
	} else {
		console.error('Can\'t find extension parent for the clicked element.')
		return false;
	}

	let pluginId = lincenseField.getAttribute('data-plugin-id');
	let licenseKey = lincenseField.value;

	jQuery.ajax({
		type: "POST",
		data: {
			security: e.target.getAttribute('data-action-nonce'),
			action: 'dslc-ajax-toggle-license',
			plugin: pluginId,
			license: licenseKey,
			todo: actionType,
		},
		url: ajaxurl,
	}).done(function (response) {

		jQuery(e.target).html(buttonLabelBackup);

		let messageStyle = '';
		if (response.success === false) {
			messageStyle = 'warning';
		}
		
		showPopupMessage( response['message'], messageStyle );

		// Softly scroll to the top.
		jQuery('html, body').animate({
			scrollTop: 0
		}, 700);

		if (response.status === "valid") {
			jQuery('[data-license-status]').attr('data-license-status', 'valid');
		} else {
			jQuery('[data-license-status]').attr('data-license-status', 'invalid');
		}
	})

});

/**
 * A very simple message popup. Used to show updated status of the license.
 */
var showPopupMessage = function( message, style, delay ) {

	console.log( 'showPopupMessage' );

	if ( undefined === message ) return;
	if ( undefined === style || '' === style ) var style = 'normal';
	if ( undefined === delay ) var delay = 4000;


	var icon = '<span class="dashicons dashicons-info"></span>';

	if ( 'warning' === style ) {
		icon = '<span class="dashicons dashicons-warning" style="color:#D96F53"></span>';
	}
	
	jQuery('body').append('<div class="lc-admin-message" style="display:none">' + icon + message + '</div>');
		jQuery(".lc-admin-message").slideDown("slow", function () {
			// Animation complete.
		});
	
	var hide_message = function () {
		jQuery(".lc-admin-message").slideUp("slow", function () {
			// Animation complete.
			jQuery(".lc-admin-message").remove();
		});	
	};

	window.setTimeout(hide_message, delay);
}