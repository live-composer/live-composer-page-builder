'use strict';

// const debug = process.env.NODE_ENV !== 'production';

module.exports = store => {
	// called when the store is initialized
	store.subscribe((mutation, state) => {
		// called after every mutation.
		// The mutation comes in the format of { type, payload }.
		if ( mutation.type === 'savePage' ) {
			// console.log('STORE > PLUGIN > SAVE PAGE')

			// Generate content for search
			// @todo: dslca_gen_content_for_search();

			// Vars
			var composerCode = JSON.stringify(state.pageCode),
			contentForSearch = jQuery('#dslca-content-for-search').val(),
			postID = state.postID;

			// Ajax call to save the new content
			jQuery.ajax({
				method: 'POST',
				type: 'POST',
				url: DSLCAjax.ajaxurl,
				data: {
					action : 'dslc-ajax-save-composer',
					dslc : 'active',
					dslc_post_id : postID,
					dslc_code : composerCode,
					dslc_content_for_search : contentForSearch
				},
				timeout: 10000
			}).done(function( response ) {

				// On success hide the publish button
				if ( response.status == 'success' ) {

					store.commit('pageSaved');

					// jQuery('.dslca-save-draft-composer').fadeOut(250);

				// On fail show an alert message
				} else {
					store.commit('pageSaveFailed');
					alert( 'Something went wrong, please try to save again. Are you sure to make any changes? Error Code: ' + response.status);
				}
			}).fail(function( response ) {

				if ( response.statusText == 'timeout' ) {
					store.commit('pageSaveFailed');
					alert( 'The request timed out after 10 seconds. Server do not respond in time. Please try again.' );
				} else {
					store.commit('pageSaveFailed');
					alert( 'Something went wrong. Please try again. Error Code: ' + response.statusText  );
				}
			}).always(function( reseponse ) {

				// Remove the class previously added so we know saving is finished
				// jQuery('body').removeClass('dslca-saving-in-progress');
			});
		}
	})
}

