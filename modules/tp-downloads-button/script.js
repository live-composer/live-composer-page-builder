/**
 * Download Button production JS
 */

'use strict'

;(function(){

	jQuery(document).ready(function($)
	{
		jQuery(document).on('click', '.dslc-download-count-hook', function(e){

			dslc_download_count_increment($(this).find('.download-button-data-post-id').html().trim());

		});
	});

	/**
	 * Increment download count
	 */

	function dslc_download_count_increment(post_id){

		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-download-count-increment',
				dslc_post_id : post_id
			},
			function(response){ }

		);

	}

}());