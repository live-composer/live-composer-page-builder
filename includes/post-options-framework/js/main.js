jQuery(document).ready(function(){

	jQuery('.dslca-post-options-field-datepicker').datepicker();

	function dslc_po_generate_images_code( container ) {

		var image,
		imagesCode = '',
		images = jQuery('.dslca-post-option-image', container);

		images.each(function(){
			image = jQuery(this);
			imageID = image.data('id');
			imagesCode += imageID + ' ';

		});

		jQuery( '.dslca-post-options-field-file', container ).val( imagesCode );

	}

	function dslc_po_remove_image( image ) {
		var container = image.closest( '.dslca-post-option' )
		image.remove();
		dslc_po_generate_images_code( container );
	}

	jQuery(document).on( 'click', '.dslca-post-option-image-remove', function(){
		dslc_po_remove_image( jQuery(this).closest('.dslca-post-option-image') );
	});

	if ( jQuery('.dslca-post-option-field-files .dslca-post-options-images').length ) {

		jQuery('.dslca-post-option-field-files .dslca-post-options-images').sortable({
			update: function (e, ui) {
				dslc_po_generate_images_code( jQuery(this).closest('.dslca-post-option') );
			}
		});
		jQuery('.dslca-post-options-images').disableSelection();

	}

	// Uploading files
	var file_frame;

	jQuery('.dslca-post-option-add-file-hook').click( function(){

		var hook = jQuery(this);
		var option = jQuery(this).closest('.dslca-post-option');
		var field = jQuery('.dslca-post-options-field-file', option);
		var image = jQuery('.dslca-post-option-image', option);

		// Whether or not multiple files are allowed
		var multiple = false;
		if ( hook.data('multiple') ) {
			multiple = true;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Choose File',
			button: {
				text: 'Send to option',
			},
			multiple: multiple
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {

			if ( multiple ) {

				attachments = file_frame.state().get('selection').toJSON();
				attachmentVal = '';

				for (var i = 0; i < attachments.length; i++) {

					attachment = attachments[i];
					attachmentVal += attachment.id + ' ';
					option.find('.dslca-post-options-images').append('<div class="dslca-post-option-image" data-id="' + attachment.id + '"><div class="dslca-post-option-image-inner"><img src="' + attachment.url + '" /><span class="dslca-post-option-image-remove">x</span></div></div>');

				}

				field.val( field.val() + attachmentVal );

			} else {
				attachment = file_frame.state().get('selection').first().toJSON();

				if ( attachment.type == 'image' ) {

					if ( image.length ) {
						image.find('img').attr( 'src', attachment.url );
			  		} else {
			  			option.find('.dslca-post-options-images').html('<div class="dslca-post-option-image" data-id="' + attachment.id + '"><div class="dslca-post-option-image-inner"><img src="' + attachment.url + '" /></div><span class="dslca-post-option-image-remove">x</span></div>');
			  		}

			  	} else {

			  		if ( image.length ) {
						image.find('strong').text( attachment.filename );
			  		} else {
			  			option.find('.dslca-post-options-images').html('<div class="dslca-post-option-image" data-id="' + attachment.id + '"><div class="dslca-post-option-image-inner"><strong>' + attachment.filename + '</strong></div></div>');
			  		}

			  	}

		  		field.val( attachment.id );


			}

		});

		// Finally, open the modal
		file_frame.open();

	});

	/**
	 * Add new tab called Page Builder
	 * next to Visual and Text in WP Edtior
	 */

	if ( typeof tabData !== 'undefined' ) {
		var $bar = jQuery('<div></div>');
		$bar.addClass('quicktags-toolbar-lc');
		$wrap = jQuery('#lc_content_wrap');
		$wrap.prepend($bar);

		jQuery('#wp-content-editor-tools #content-html').after(
		  '<button type="button" id="content-lc" class="wp-switch-editor switch-lc">' + tabData.tabTitle + '</button>'
		);
	}

	// Overlay WP editor with LC Page Builder tab if there is LC content AND there is no content in standard editor
	if ( jQuery('#postcustom input[value="dslc_code"]').val() == 'dslc_code' && jQuery('.wp-editor-area').text().length == 0 ) {
		jQuery('#wp-content-wrap').removeClass('html-active tmce-active');
		jQuery('#postdivrich').addClass('lc-active');
	}

	jQuery(document).on('click', '#content-lc', function(e) {
	  e.preventDefault();
	  jQuery('.wp-editor-expand').addClass('lc-active');
	});

	jQuery(document).on('click', '#content-tmce, #content-html', function(e) {
	  e.preventDefault();
	  jQuery('.wp-editor-expand').removeClass('lc-active');
	});

	/**
	 * Hide Template Base
	 */

	jQuery(document).on('click', '#dslca_single_post_templates input[type="checkbox"], #dslca_archive_index_templates input[type="checkbox"], #dslca_special_page_templates input[type="checkbox"]', function(e) {

		var singleTemplate, archiveTemplate, specialPage;

		singleTemplate = jQuery( '#dslca_single_post_templates input[type="checkbox"]:checked' ).length;
		archiveTemplate = jQuery( '#dslca_archive_index_templates input[type="checkbox"]:checked' ).length;
		specialPage = jQuery( '#dslca_special_page_templates input[type="checkbox"]:checked' ).length;

		if ( singleTemplate && archiveTemplate == 0 && specialPage == 0 ) {
	        jQuery("#post-option-dslc_template_base").show();
	    } else {
	        jQuery("#post-option-dslc_template_base").hide();
	    }
	});

	if ( jQuery('#dslca_single_post_templates input[type="checkbox"]').is(':checked') ) {
		jQuery('#post-option-dslc_template_base').show();
	} else {
		jQuery('#post-option-dslc_template_base').hide();
	}

	/**
	 * Header - Show/Hide extra padding
	 */

	var headerFor = jQuery("select#dslc_hf_for").val();

	if ( headerFor == 'footer' ) {
		jQuery("#post-option-dslc_extra_padding").hide();
		jQuery('#post-option-dslc_extra_padding input[type="checkbox"]').val('');
	}

	jQuery(document).on('change', 'select#dslc_hf_for', function(e) {

		var option = jQuery(this).val();

	    if ( option == 'footer' ) {
			jQuery("#post-option-dslc_extra_padding").hide();
			jQuery('#post-option-dslc_extra_padding input[type="checkbox"]').val('');
		} else {
			jQuery('#post-option-dslc_hf_position input[type="radio"]#dslc_hf_position0').prop('checked', true);
			jQuery('#post-option-dslc_extra_padding input[type="checkbox"]').val('');
			jQuery('#post-option-dslc_extra_padding input[type="checkbox"]').prop('checked', false);
		}

		headerFor = jQuery("select#dslc_hf_for").val();
	});

	jQuery(document).on('change', '#post-option-dslc_hf_position input[type="radio"]', function(e) {

		if ( headerFor == 'header' ) {

			var inputValue = jQuery(this).val();

			if ( inputValue == 'relative' ) {
				jQuery("#post-option-dslc_extra_padding").hide();
				jQuery('#post-option-dslc_extra_padding input[type="checkbox"]').val('');
				jQuery('#post-option-dslc_extra_padding input[type="checkbox"]').prop('checked', false);
			} else {
				jQuery("#post-option-dslc_extra_padding").show();
			}

		}
	});

	if ( jQuery('#post-option-dslc_hf_position input[type="radio"]#dslc_hf_position0').is(':checked') ) {
		jQuery('#post-option-dslc_extra_padding').hide();
	}

}); // jQuery(document).ready
