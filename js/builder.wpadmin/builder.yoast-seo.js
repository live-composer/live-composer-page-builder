jQuery(document).ready(function(){

	/**
	 * Main Function
	 */
	dslcYoastFilter = function() {

		YoastSEO.app.registerPlugin( 'dslcYoastFilter', {status: 'ready'} );
		YoastSEO.app.registerModification( 'content', this.modifyContent, 'dslcYoastFilter', 5 );

	}

	/**
	 * Add LC content
	 */
	dslcYoastFilter.prototype.modifyContent = function(data) {

		// Get LC Content
		var lcContent = jQuery('input[value="dslc_content_for_search"]').closest('tr').find('textarea').val();

		// If there is LC content append
		if ( lcContent !== 'undefined' ) {
			data = data + ' ' + lcContent;
		}

		// Pass it back to Yoast
		return data;

	};

	/**
	 * Initiate
	 */
	setTimeout( function(){

		// Make sure YoastSEO is a thing
		if (typeof YoastSEO !== 'undefined') {
			new dslcYoastFilter();
		}

	}, 0);

});