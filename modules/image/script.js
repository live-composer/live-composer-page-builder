/**
 * Image js extender
 */

'use strict';

;(function(){

	jQuery( document ).on( 'DSLC_extend_modules', function(){

		/**
		 * Instant image addition
		 */
		jQuery( document ).on( 'click', '.dslc-module-image-add-image-inner-hook', function()
		{
			var addImageButton = this;
			var fieldParent = jQuery( ".dslca-module-edit-field.dslca-module-edit-field-image[data-id='image']" ).closest( '.dslca-module-edit-option' );
			var hook = fieldParent.find( '.dslca-module-edit-field-image-add-hook' );

			if ( hook.hasClass( 'dslca-module-edit-field-image-add-hook' ) ) {

				var field = hook.siblings( '.dslca-module-edit-field-image' );
				var removeHook = hook.siblings( '.dslca-module-edit-field-image-remove-hook' );
			} else {

				var field = hook.siblings( '.dslca-modules-section-edit-field-upload' );
				var removeHook = hook.siblings( '.dslca-modules-section-edit-field-image-remove-hook' );
			}

			// Create the media frame.
			var file_frame = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button:{
					text: 'Confirm',
				},
				multiple: false
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function(){

				var attachment = file_frame.state().get( 'selection' ).first().toJSON();
				var module = jQuery( addImageButton ).closest( ".dslc-module-front" ).data( 'module-instance' );

				module.setOption( "image",
				    {
						url: attachment.url,
						id: attachment.id
					}
				);

				var filename = attachment.filename.length <= 13 ? attachment.filename : attachment.filename.slice( 0, 13 ) + "...";
				fieldParent.find( '.dslca-image-filename' ).html( filename );

				if ( hook && removeHook ) {

					hook.hide();
					removeHook.show();
				}

				module
					.reloadModuleBody()
					.saveEdits();

				dslc_generate_code();
				dslc_show_publish_button();
			});

			file_frame.open();
		});

		DSLC.ModulesManager.AvailModules.DSLC_Image.prototype.filterBeforeOptionSet = function( optionId, optionValue )
		{
			if ( optionId == 'resize_width' || optionId == 'resize_height' ) return false;

			return {optionValue: optionValue};
		}

		DSLC.ModulesManager.AvailModules.DSLC_Image.prototype.changeOptionsBeforeRender = function( options )
		{
			var anchor_class = '';
			var anchor_target = '_self';
			var anchor_href = '#';

			if ( options.link_type.value == 'url_new' ) {

				anchor_target = '_blank';
			}

			if(options.link_url.value && options.link_url.value != '' ) {

				anchor_href = options.link_url.value;
			}

			if ( options.link_type.value == 'lightbox' ) {

				anchor_class += 'dslc-lightbox-image ';

				if( options.link_lb_image.value && options.link_lb_image.value != '' ) {

					anchor_href = options.link_lb_image.value.url;
				}
			}

			options.anchor_href = anchor_href;
			options.anchor_target = anchor_target;
			options.anchor_class = anchor_class;

			options.dslc_is_admin = true;

			return options;
		}
	});
}());