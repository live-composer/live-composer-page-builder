/**
 * The place to do all the events bindings.
 */

export const eventsInit = () =>{
	// Parent page events.
	document.addEventListener('click', function (event) {
		if ( event.target.matches( '[data-event="modal-wysiwyg-cancel"]' ) ) {
			// Create a new "Modal Cancel" event
			const modalWysiwygCancel = new CustomEvent('modalWysiwygCancel', { detail: event.target });
			document.dispatchEvent( modalWysiwygCancel );
		}

		if ( event.target.matches( '[data-event="modal-wysiwyg-confirm"]' ) ) {
			// Create a new "Modal Cancel" event
			const modalWysiwygConfirm = new CustomEvent('modalWysiwygConfirm', { detail: event.target });
			document.dispatchEvent( modalWysiwygConfirm );
		}

		if ( event.target.matches( '[data-event="module-confirm"]' ) ) {
			// Create "Module Confirm" event
			const moduleConfirm = new CustomEvent('moduleConfirm', { detail: event.target });
			document.dispatchEvent( moduleConfirm );
		}

		if ( event.target.matches( '[data-event="module-cancel"]' ) ) {
			// Create "Module Cancel" event
			const moduleCancel = new CustomEvent('moduleCancel', { detail: event.target });
			document.dispatchEvent( moduleCancel );
		}
	}, false);

	// Preview iframe events: click.
	LiveComposer.Builder.PreviewAreaWindow.document.addEventListener('click', function (event) {
		// Disable default action/event,
		// but only if the link clicked doesn't have '.dslca-link' class.
		if ( ! event.target.matches('.dslca-link') ) {
			// By default all the default click events disabled on LC editing mode.
			// .dslca-link class used to enable default browser behaviour.
			// (ex. open header/footer for editing in new tab).
			event.preventDefault();
		}

		if ( event.target.matches( '[data-event="module-edit"]' ) ) {
			// Create a new "Open Module Editing" event
			const moduleEdit = new CustomEvent('moduleEdit', { detail: event.target });
			document.dispatchEvent( moduleEdit );
		}

		if ( event.target.matches( '[data-event="module-duplicate"]' ) ) {
			// Create a new "Duplicate Module" event
			const moduleDuplicate = new CustomEvent('moduleDuplicate', { detail: event.target });
			document.dispatchEvent( moduleDuplicate );
		}

		if ( event.target.matches( '[data-event="module-delete"]' ) ) {
			// Create a new "Delete Module" event
			const moduleDelete = new CustomEvent('moduleDelete', { detail: event.target });
			document.dispatchEvent( moduleDelete );
		}

		if ( event.target.matches( '.dslca-change-width-module-options [data-size]' ) ) {
			// Create a new "Change Module Width" event
			const moduleChangeWidth = new CustomEvent('moduleChangeWidth', { detail: event.target });
			document.dispatchEvent( moduleChangeWidth );
		}

		if ( event.target.matches( '[data-event="wysiwyg-edit"]' ) ) {
			// Create a new "Module WYSIWYG Editing" event
			const wysiwygEdit = new CustomEvent('wysiwygEdit', { detail: event.target });
			document.dispatchEvent( wysiwygEdit );
		}

		if ( event.target.matches( '[data-event="module-style-copy"]' ) ) {
			// Create a new "Copy Module Style" event
			const copyStyles = new CustomEvent('copyModuleStyles', { detail: event.target });
			document.dispatchEvent( copyStyles );
		}

		if ( event.target.matches( '[data-event="module-style-paste"]' ) ) {
			// Create a new "Paste Module Style" event
			const pasteStyles = new CustomEvent('pasteModuleStyles', { detail: event.target });
			document.dispatchEvent( pasteStyles );
		}

	}, false);

	// Preview iframe events: focusout.
	LiveComposer.Builder.PreviewAreaWindow.document.addEventListener('focusout', function (event) {
		// This event gets dispatched when the contenteditable element loses focus.
		// Useful when you need to save data when element text edited.
		if ( event.target.matches( '[contenteditable="true"]' ) ) {
			const contentEditableFocusOut = new CustomEvent('contentEditableFocusOut', { detail: event.target });
			document.dispatchEvent( contentEditableFocusOut );
		}
	}, false);
}