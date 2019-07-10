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
	}, false);

	// Preview iframe events.
	LiveComposer.Builder.PreviewAreaWindow.document.addEventListener('click', function (event) {
		event.preventDefault();

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

	}, false);
}