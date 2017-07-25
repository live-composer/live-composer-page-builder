/*********************************
 *
 * = CODE GENERATION =
 *
 * - dslc_save_composer ( Save the Page Changes )
 * - dslc_save_draft_composer ( Save the changes as draft, not publish )
 * - dslc_generate_code ( Generates Page's LC data )
 * - dslc_generate_section_code ( Generate LC data for a specific row/section )
 * - dslca_gen_content_for_search ( Generate Readable Content For Search )
 *
 ***********************************/

'use strict';

/**
 * CODE GENERATION - Save Page Changes
 */
function dslc_save_composer() {

	if ( dslcDebug ) console.log( 'dslc_save_composer' );

	/**
	 * Before saving code via ajax
	 * refresh the page source in a hidden #dslca-code
	 */
	dslc_generate_code();

	// Generate content for search
	dslca_gen_content_for_search();

	// Vars
	var composerCode = jQuery('#dslca-code').val(),
	contentForSearch = jQuery('#dslca-content-for-search').val(),
	postID = jQuery('.dslca-container').data('post-id');

	// Apply class to body to know saving is in progress
	jQuery('body').addClass('dslca-saving-in-progress');

	// Replace the check in publish button with a loading animation
	jQuery('.dslca-save-composer .dslca-icon').removeClass('dslc-icon-ok').addClass('dslc-icon-spin dslc-icon-spinner');

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
		timeout: 30000
	}).done(function( response ) {

		// On success hide the publish button
		if ( response.status == 'success' ) {
			jQuery('.dslca-save-composer').fadeOut(250);
			jQuery('.dslca-save-draft-composer').fadeOut(250);

			// Create new cache version after it's saved.
			jQuery('body').append( '<iframe class="lbmn-cache-iframe" id="lbmn-cache-iframe-' + postID + '" src="'+ DSLCSiteData.siteurl + '/?p=' + postID +'" ></iframe>' );

			jQuery('.lbmn-cache-iframe').each(function(index, el) {
				jQuery(el).load(function() {
					jQuery(el).remove();
					// Cache built at this point. Remove iframe.
				});
			});

		// On fail show an alert message
		} else {
			alert( 'Something went wrong, please try to save again. Are you sure to make any changes? Error Code: ' + response.status);
		}
	}).fail(function( response ) {

		if ( response.statusText == 'timeout' ) {
			alert( 'The request timed out after 30 seconds. Server do not respond in time. Please try again.' );
		} else {
			alert( 'Something went wrong. Please try again. Error Code: ' + response.statusText  );
		}
	}).always(function( reseponse ) {

		// Replace the loading animation with a check icon
		jQuery('.dslca-save-composer .dslca-icon').removeClass('dslc-icon-spin dslc-icon-spinner').addClass('dslc-icon-ok')

		// Remove the class previously added so we know saving is finished
		jQuery('body').removeClass('dslca-saving-in-progress');
	});
}

/**
 * CODE GENERATION - Save Draft
 */
function dslc_save_draft_composer() {

	if ( dslcDebug ) console.log( 'dslc_save_draft_composer' );

	// Vars
	var composerCode = jQuery('#dslca-code').val(),
	postID = jQuery('.dslca-container').data('post-id');

	// Apply class to body to know saving is in progress
	jQuery('body').addClass('dslca-saving-in-progress');

	// Replace the check in publish button with a loading animation
	jQuery('.dslca-save-draft-composer .dslca-icon').removeClass('dslc-icon-ok').addClass('dslc-icon-spin dslc-icon-spinner');

	// Ajax call to save the new content
	jQuery.post(

		DSLCAjax.ajaxurl,
		{
			action : 'dslc-ajax-save-draft-composer',
			dslc : 'active',
			dslc_post_id : postID,
			dslc_code : composerCode,
		},
		function( response ) {

			// Replace the loading animation with a check icon
			jQuery('.dslca-save-draft-composer .dslca-icon').removeClass('dslc-icon-spin dslc-icon-spinner').addClass('dslc-icon-save')

			// On success hide the publish button
			if ( response.status == 'success' ) {
				jQuery('.dslca-save-draft-composer').fadeOut(250);

			// On fail show an alert message
			} else {

				alert( 'Something went wrong, please try to save again.' );
			}

			// Remove the class previously added so we know saving is finished
			jQuery('body').removeClass('dslca-saving-in-progress');
		}
	);
}

/**
 * CODE GENERATION - Generate LC Data
 * @param section is not required. If no parameter provided function generates
 */
function dslc_generate_code() {
	if ( dslcDebug ) console.log( 'dslc_generate_code' );

	// Vars
	var moduleCode = '',
	module_size,
	composerCode = '',
	pageCodeInJson = '',
	maxPerRow = 12,
	maxPerRowA = 12,
	currPerRow = 0,
	currPerRowA = 0,
	modulesAreaSize,
	modulesArea,
	modulesAreaLastState,
	modulesAreaFirstState,
	modulesSection,
	modulesSectionAtts = '',
	modulesSectionJson;

	/**
	 * Go through module areas (empty or not empty)
	 * TODO: Optimize code to go though the section/area needed only,
	 * not the whole page.
	 */

	jQuery('#dslc-main .dslc-modules-area', LiveComposer.Builder.PreviewAreaDocument).each(function(){

		if ( jQuery('.dslc-module-front', this).length ) {

			jQuery(this).removeClass('dslc-modules-area-empty').addClass('dslc-modules-area-not-empty');
			jQuery('.dslca-no-content', this).hide();

		} else {

			jQuery(this).removeClass('dslc-modules-area-not-empty').addClass('dslc-modules-area-empty');

			jQuery('.dslca-no-content:not(:visible)', this).show().css({
				'-webkit-animation-name' : 'dslcBounceIn',
				'-moz-animation-name' : 'dslcBounceIn',
				'animation-name' : 'dslcBounceIn',
				'animation-duration' : '0.6s',
				'-webkit-animation-duration' : '0.6s',
				padding : 0
			}).animate({ padding : '35px 0' }, 300);
		}
	});

	/**
	 * Go through each row (empty or not empty)
	 */

	jQuery('#dslc-main .dslc-modules-section', LiveComposer.Builder.PreviewAreaDocument).each(function(){

		modulesSection = jQuery(this);

		modulesSectionJson = dslc_generate_section_code( modulesSection );

		// Update JSON in hidden text area with updated code.
		modulesSection.find('.dslca-section-code').val( modulesSectionJson );

		// Add row code into the the whole page code.
		pageCodeInJson = pageCodeInJson + modulesSectionJson + ',';

		// Close row ( section ) shortcode
		// composerCode = composerCode + '[/dslc_modules_section] ';
	});


	// Remove the last comma in the code.
	pageCodeInJson = pageCodeInJson.slice(0, -1);

	// pageCodeInJson = pageCodeInJson;
	pageCodeInJson = '[' + pageCodeInJson + ']';

	// Apply the new code values to the setting containers
	jQuery('#dslca-code').val(pageCodeInJson);

	jQuery('#dslca-export-code').val(pageCodeInJson);
}


/**
 * CODE GENERATION - Generate LC Data for Section
 *
 * @param  {jQuery Object} theModulesSection jQuery element for the section to process
 * @return {String}                   			JSON code for the section
 */
function dslc_generate_section_code( theModulesSection ) {

	if ( dslcDebug ) console.log( 'dslc_generate_section_code' );

	// Vars
	var moduleCode = '',
	module_size,
	composerCode = '',
	pageCodeInJson = '',
	maxPerRow = 12,
	maxPerRowA = 12,
	currPerRow = 0,
	currPerRowA = 0,
	modulesAreaSize,
	modulesArea,
	modulesAreaLastState,
	modulesAreaFirstState,
	modulesSection,
	modulesSectionAtts = '',
	modulesSectionJsonString = '',
	modulesSectionJson;

	modulesSection = theModulesSection;

	// Update dslc-modules-section-(not)empty classes
	if ( jQuery('.dslc-modules-area', modulesSection).length ) {

		modulesSection.removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');
	} else {

		modulesSection.removeClass('dslc-modules-section-not-empty').addClass('dslc-modules-section-empty');
	}

	// Remove last and first classes from module areas and modules
	jQuery('.dslc-modules-area.dslc-last-col, .dslc-modules-area.dslc-first-col', this).removeClass('dslc-last-col dslc-first-col');
	jQuery('.dslc-module-front.dslc-last-col, .dslc-module-front.dslc-first-col', this).removeClass('dslc-last-col dslc-first-col');

	// Vars
	currPerRowA = 0;

	// Get current JSON.
	modulesSectionJsonString = modulesSection.find('.dslca-section-code').val();
	modulesSectionJson = JSON.parse(modulesSectionJsonString);

	// Generate attributes for the row shortcode
	modulesSectionAtts = '';

	jQuery('.dslca-modules-section-settings input', modulesSection).each(function(){

		var currentInput = jQuery(this);
		var currentAttrKey = currentInput.data('id');
		var currentAttrVal = currentInput.val();

		// Update hidden text fields with row attributes.
		modulesSectionAtts = modulesSectionAtts + currentAttrKey + '="' + currentAttrVal + '" ';

		// Update JSON object.
		modulesSectionJson[currentAttrKey] = currentAttrVal;
	});

	// Delete attribute 'give_new_id'.
	// It supposed to be used only once and by this time it was already applied.
	if (  undefined !== modulesSectionJson['give_new_id'] ) {
		delete modulesSectionJson['give_new_id'];
	}

	// Prepare place for module areas.
	modulesSectionJson['content'] = [];

	// Open the module section ( row ) shortcode
	// composerCode = composerCode + '[dslc_modules_section ' + modulesSectionAtts + '] ';

	/**
	 * Go through each column of current row
	 */
	jQuery('.dslc-modules-area', modulesSection).each(function(){

		// Reset width counter for modules
		currPerRow = 0;

		// Vars
		modulesArea = jQuery(this);
		modulesAreaSize = parseInt( modulesArea.data('size') );
		modulesAreaLastState = 'no';
		modulesAreaFirstState = 'no';

		// Increment area column counter
		currPerRowA += modulesAreaSize;

		jQuery(this).removeClass('dslc-first-col');
		jQuery(this).removeClass('dslc-last-col');

		// If area column counter same as maximum
		if ( currPerRowA == maxPerRowA ) {

			// Apply classes to current and next column
			jQuery(this).addClass('dslc-last-col').next('.dslc-modules-area').addClass('dslc-first-col');

			// Reset area column counter
			currPerRowA = 0;

			// Set shortcode's "last" attribute to "yes"
			modulesAreaLastState = 'yes';

		// If area column counter bigger than maximum
		} else if ( currPerRowA > maxPerRowA ) {

			// Apply classes to current and previous column
			jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');

			// Set area column counter to the size of the current area
			currPerRowA = modulesAreaSize;

			// Set shortcode's "first" attribute to yes
			modulesAreaFirstState = 'yes';
		}

		// If area column counter same as current area size
		if ( currPerRowA == modulesAreaSize ) {

			// Set shortcode's "first" attribute to yes
			modulesAreaFirstState = 'yes';

			// Apply classes to current and previous column
			jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');

		}

		// Open the modules area ( area ) shortcode
		// composerCode = composerCode + '[dslc_modules_area last="' + modulesAreaLastState + '" first="' + modulesAreaFirstState + '" size="' + modulesAreaSize + '"] ';

		var moduleAreaJSON = '{"element_type":"module_area","last":"' + modulesAreaLastState + '","first":"' + modulesAreaFirstState + '","size":"' + modulesAreaSize + '"}';

		// pageCodeInJson = pageCodeInJson +  moduleAreaJSON + ',';

		moduleAreaJSON = JSON.parse( moduleAreaJSON );

		// Delete attribute 'give_new_id'.
		// It supposed to be used only once and by this time it was already applied.
		if (  undefined !== moduleAreaJSON['give_new_id'] ) {
			delete moduleAreaJSON['give_new_id'];
		}

		moduleAreaJSON.content = [];

		/**
		 * Go through each module of current area
		 */

		jQuery('.dslc-module-front', modulesArea).each(function(){

			var dslc_module = jQuery(this);

			// Vars
			module_size = parseInt( dslc_module[0].getAttribute('data-dslc-module-size') );
			var moduleLastState = 'no';
			var moduleFirstState = 'no';

			jQuery(this).removeClass('dslc-first-col');
			jQuery(this).removeClass('dslc-last-col');

			// Increment modules column counter
			currPerRow += module_size;

			// If modules column counter same as maximum
			if ( currPerRow == maxPerRow ) {

				// Add classes to current and next module
				jQuery(this).addClass('dslc-last-col');
				jQuery(this).next('.dslc-module-front').addClass('dslc-first-col');

				// Reset modules column counter
				currPerRow = 0;

				// Set shortcode's "last" state to "yes"
				moduleLastState = 'yes';

				// Set shorcode's "first" state to "yes"
				moduleFirstState = 'yes';


			// If modules column counter bigger than maximum
			} else if ( currPerRow > maxPerRow ) {

				// Add classes to current and previous module
				jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');

				// Set modules column counter to the size of current module
				currPerRow = module_size;

				// Set shortcode's "first" state to "yes"
				moduleFirstState = 'yes';
			}

			// If modules column counter same as current module size
			if ( currPerRow == module_size ) {

				// Set shortcode's "first" attribute to yes
				moduleFirstState = 'yes';

				// Apply classes to current and previous column
				jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');

			}

			try {
				// Get module's LC data
				moduleCode = dslc_module[0].querySelector('.dslca-module-code').value;

			} catch(err) {
				console.info( 'No DSLC code found in module: ' + dslc_module[0].getAttribute('id') );
			}

			if ( '' !== moduleCode ) {
				// Add the module shortcode containing the data
				// composerCode = composerCode + '[dslc_module last="' + moduleLastState + '"]' + moduleCode + '[/dslc_module] ';

				var moduleCodeJSON = JSON.parse(moduleCode);
				// Add idicator for the last module in the row.
				moduleCodeJSON.last = moduleLastState;

				// RAW CODE CLEANUP: Clean the module code from keys with empty values.
				jQuery.each(moduleCodeJSON, function(index, el) {
					if ( false === el || '' === el ) {
						delete moduleCodeJSON[index];
					}

					if ( 'give_new_id' === index ) {
						delete moduleCodeJSON[index];
					}
				});

				// Put optimized code back into the hidden textarea.
				dslc_module[0].querySelector('.dslca-module-code').value = JSON.stringify(moduleCodeJSON);

				// Add the module JSON as array item
				moduleAreaJSON['content'].push( moduleCodeJSON );
			}

			// Fix bug with modules duplication if broken module saved.
			moduleCode = '';

		});

		modulesSectionJson['content'].push(moduleAreaJSON);

		// Close area shortcode
		// composerCode = composerCode + '[/dslc_modules_area] ';
	});

	var generatedCode = JSON.stringify( modulesSectionJson );

	return generatedCode;
}

/**
 * CODE GENERATION - Document Ready
 */
jQuery(document).ready(function($){

	/**
	 * Hook - Save Page
	 */
	$(document).on( 'click', '.dslca-save-composer-hook', function(e){
		e.preventDefault();

		// If some saving action not already in progress
		if ( ! $('body').hasClass('dslca-module-saving-in-progress') && ! $('body').hasClass('dslca-saving-in-progress') ) {
			// Call the function to save
			dslc_save_composer();
		}
	});

	/**
	 * Hook - Save Draft
	 */
	$(document).on( 'click', '.dslca-save-draft-composer-hook', function(e){
		e.preventDefault();

		// If some saving action not already in progress
		if ( ! $('body').hasClass('dslca-module-saving-in-progress') && ! $('body').hasClass('dslca-saving-in-progress') ) {
			// Call the function to save
			dslc_save_draft_composer();
		}
	});
});

/**
* Other - Generate Readable Content For Search
*/

function dslca_gen_content_for_search() {

	if ( dslcDebug ) console.log( 'dslca_gen_content_for_search' );

	// Vars
	var holder = document.getElementById('dslca-content-for-search');

	if (null === holder) {
		return;
	}

	var prevContent = holder.value;
	var content = '';

	// Go through each content element

	var elements = LiveComposer.Builder.PreviewAreaWindow.document.querySelectorAll('#dslc-main .dslc-module-front [data-exportable-content]');

	if ( undefined !== elements ) {
		Array.prototype.forEach.call(elements, function(el, i){
			// el - current DOM element, i – counter
			var extracted_html_code;

			if ( el.getAttribute('data-exportable-content') !== '' ) {

				var wrapper_tag = el.getAttribute('data-exportable-content');
				extracted_html_code = '<' + wrapper_tag + '>' + el.innerHTML + '</' + wrapper_tag + '>';
			} else {

				extracted_html_code = el.innerHTML;
			}

			if ( extracted_html_code !== null ) {

				content += extracted_html_code.replace(/\s+/g, ' ').trim() + '\n';
			}
		});
	}

	// Set the value of the content field
	holder.value = content;

	// Used to show the publish button for pages made before this feature
	if ( prevContent !== content ) {

		dslc_show_publish_button();
	}
}