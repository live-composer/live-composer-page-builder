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
			const self = this;

			// Add toolbar button.
			this.toolbar = d.querySelector( '#editor .edit-post-header-toolbar' );
			this.toolbar.insertAdjacentHTML(
				'beforeend',
				`<button id="lc-open-live-composer-button" type="button" class="button button-large">
					<img src="` + data.toolbarIconPath + `" aria-hidden="true" />
					` + data.editButtonText + `
				</button>`
			);

			this.toolbar.querySelector( '#lc-open-live-composer-button' ).addEventListener("click", event => {
				self.onClick(event);
			});

			// Add dismissible info notce.
			// @docs: https://github.com/WordPress/gutenberg/tree/master/packages/components/src/notice
			wp.data.dispatch( 'core/notices' ).createNotice(
				'info',
				data.noticeText,
				{
					// isDismissible: false,
					actions: [
						{
							label: data.noticeAction,
							onClick: self.onClick.bind(self),
							className: 'is-link',
							noDefaultClasses: true
						}
					],
				}
			)
		},

		onClick: function( event ) {
			event.preventDefault();

			const wpEditor = wp.data.dispatch( 'core/editor' );

			/**
			 * If no title set, generate a temporary one based on current date.
			 * Gutenberg won't save page properly without a title.
			 */
			const documentTitle = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'title' );
			if ( ! documentTitle ) {
				let today = new Date();
				const dd = String(today.getDate()).padStart(2, '0');
				const mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
				const yyyy = today.getFullYear();

				today = mm + '/' + dd + '/' + yyyy;
				wpEditor.editPost( { title: 'New post created on ' + today } );
			}

			this.redirectNow();
			wpEditor.savePost();
		},

		redirectNow: function() {
			var self = this;

			setTimeout( function() {
				if ( wp.data.select( 'core/editor' ).isSavingPost() ) {
					self.redirectNow();
				} else {
					location.href = data.editAction;
				}
			}, 300 );
		},

		init: function() {
			const self = this;

			wp.domReady( function() {
				// Timeout needed for React to render toolbar...
				setTimeout( function() {
					self.addEditorElements();
				}, 1 );
			} );
		},
	};

	( function() {
		GutenbergIntegrationForLC.init();
	} )();

} (window, document, window.wp, lcAdminData) );
