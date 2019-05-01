/**
 * UI integration: Gutenberg + Live Composer.
 * - Add 'Open in Live Composer' button in the Gutenberg toolbar.
 * - Add 'Edit this page in the front-end page builder' notce in the Gutenberg.
 */

'use strict';

( function( w, d, wp, data ) {
	'use strict';

	var GutenbergIntegrationForLC = {
		addEditorElements: function() {
			// Add toolbar button.
			this.toolbar = d.querySelector( '#editor .edit-post-header-toolbar' );
			this.toolbar.insertAdjacentHTML(
				'beforeend',
				`<a id="lc-open-live-composer-button" class="button button-large" href="` + data.editAction + `">
					<img src="` + data.toolbarIconPath + `" aria-hidden="true" />
					` + data.editButtonText + `
				</a>`
			);

			// Add dismissible info notce.
			wp.data.dispatch( 'core/notices' ).createNotice(
				'info',
				data.noticeText,
				{
					// isDismissible: false,
					actions: [
						{
							url: data.editAction,
							label: data.noticeAction
						}
					]
				}
			)
		},

		init: function() {
			var self = this;

			wp.domReady( function() {
				// Timeout needed for React to render toolbar...
				setTimeout( function() {
					self.addEditorElements();
					// self.bindEvents();

				}, 1 );
			} );
		},
	};

	( function() {
		GutenbergIntegrationForLC.init();
	} )();
} (window, document, window.wp, lcAdminData) );
