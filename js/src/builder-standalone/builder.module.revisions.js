/**
 * Revisions module.
 * Includes all the functionality to power undo/redo actions.
 */

'use strict';

LCAPP.prototype.revisions = {};

LCAPP.modules.revisions = function (lcApp) {

	// 🚀 Launch revisions engine.
	lcApp.revisions.init = function () {
		if ( dslcDebug ) console.log( 'lcApp.revisions.init' );

		// Get current page code.
		var pageCodeCurrent = jQuery('#dslca-code').val();
		// Save page code into the lcApp shared object property.
		lcApp.setPageCode( pageCodeCurrent );

		// Launch functionality form SimpleUndo plugin.
		lcApp.state.pageRevisions = new SimpleUndo({
		   maxLength: 1000,
		   provider: function(done) {
				done( lcApp.getPageCode() );
			},
			onUpdate: function() {
				//onUpdate is called in constructor, making history undefined
				if (!lcApp.state.pageRevisions.stack) return;

				lcApp.revisions.updateUI();
			},
			initialItem: lcApp.getPageCode()
		});


		/**
		 * Attach listeners to UNDO/REDO icons.
		 * Bind events only if they don't exist already.
		 */

		// Hook: Undo.
		jQuery('.dslca-undo').off( 'click' ).on( 'click', function(e){

			e.preventDefault();
			if ( dslcDebug ) console.log( 'click .dslca-undo' );

			lcApp.revisions.undo();
		});

		// Hook: Redo.
		jQuery('.dslca-redo').off( 'click' ).on( 'click', function(e){

			e.preventDefault();
			if ( dslcDebug ) console.log( 'click .dslca-redo' );

			lcApp.revisions.redo();
		});
	};

	// ⌛ Save current version of the page code as new revision.
	lcApp.revisions.save = function () {
		if ( dslcDebug ) console.log( 'lcApp.revisions.save' );

		// if ( ! lcAppState.movingInHistory ) {
			// Get current page code.
			var pageCodeCurrent = jQuery('#dslca-code').val();
			// console.log( "pageCodeCurrent:" ); console.log( pageCodeCurrent );
			// Update lcApp shared object property.
			lcApp.setPageCode( pageCodeCurrent );

			// console.log( "lcApp.PageCode:" ); console.log( lcApp.state.pageCode );

			// lcApp.state.pageRevisions.save();

			// console.log( "lcApp.state.pageRevisions:" ); console.log( lcApp.state.pageRevisions );

			// Save recovery copy in the browser storage.
			localStorage.setItem( 'lcApp.ver' + lcApp.getVer() + '.revisions.recovery', pageCodeCurrent );
		// }

		// lcAppState.movingInHistory = false;
	};

	// ⏪ Undo changes: Back in revisions history.
	lcApp.revisions.undo = function () {
		if ( dslcDebug ) console.log( 'lcApp.revisions.undo' );

		// if ( lcApp.state.pageRevisions.position > 0 ) {

			// lcAppState.movingInHistory = true;

			lcApp.state.pageRevisions.undo(
				// Callback.
				function(pageCode) {
					// Update lcApp shared object property.
					lcApp.setPageCode( pageCode );
					dslc_template_import( pageCode );
				}
			);

		// }
	};

	// ⏩ Redo changes: Move forward in revisions history.
	lcApp.revisions.redo = function () {
		if ( dslcDebug ) console.log( 'lcApp.revisions.redo' );

		// lcAppState.movingInHistory = true;

		lcApp.state.pageRevisions.redo(
			// Callback.
			function(pageCode) {
				// Update lcApp shared object property.
				lcApp.setPageCode( pageCode );
				dslc_template_import( pageCode );
			}
		);
	};

	// 🚥 Update UNDO/REDO icons state.
	lcApp.revisions.updateUI = function () {
		if ( dslcDebug ) console.log( 'lcApp.revisions.updateUI' );

		// @todo: .canUndo() needs more work to make the first change reversible.
		if ( lcApp.state.pageRevisions.position > 1 ) {
			jQuery('.dslca-undo').removeClass('disabled');
		} else {
			jQuery('.dslca-undo').addClass('disabled');
		}

		if ( ! lcApp.state.pageRevisions.canRedo() ) {
			jQuery('.dslca-redo').addClass('disabled');
		} else {
			jQuery('.dslca-redo').removeClass('disabled');
		}
	};
};