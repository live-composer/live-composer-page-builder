<?php

/**
 * Table of Contents
 *
 * class DSLC_Aq_Resize ( Image resizing class )
 * dslc_aq_resize ( Resize an image using DSLC_Aq_Resize Class )
 * dslc_get_social_count ( Returns amount of social shares a page has )
 * dslc_icons_current_set ( Returns the ID of the currently used set based on icon )
 * dslc_get_attachment_alt ( Returnt he ALT attribute for an attachment )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

if ( ! class_exists( 'DSLC_Aq_Resize' ) ) {

	/**
	 * Image resizing class
	 *
	 * @since 1.0
	 */
	class DSLC_Aq_Resize {

		/**
		 * The singleton instance
		 */
		static private $instance = null;

		/**
		 * No initialization allowed
		 */
		private function __construct() {}

		/**
		 * No cloning allowed
		 */
		private function __clone() {}

		/**
		 * For your custom default usage you may want to initialize an Aq_Resize object by yourself and then have own defaults
		 */
		static public function getInstance() {
			if ( self::$instance == null ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Run, forest.
		 */
		public function process( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = true ) {

			// Validate inputs.
			if ( ! $url || ( ! $width && ! $height ) ) { return false;
			}

			$upscale = true;

			// Caipt'n, ready to hook.
			if ( true === $upscale ) { add_filter( 'image_resize_dimensions', array( $this, 'aq_upscale' ), 10, 6 );
			}

			// Define upload path & dir.
			$upload_info = wp_upload_dir();
			$upload_dir = $upload_info['basedir'];
			$upload_url = $upload_info['baseurl'];

			$http_prefix = 'http://';
			$https_prefix = 'https://';

			/*
			 if the $url scheme differs from $upload_url scheme, make them match
				if the schemes differe, images don't show up. */
			if ( ! strncmp( $url, $https_prefix, strlen( $https_prefix ) ) ) { // if url begins with https:// make $upload_url begin with https:// as well
				$upload_url = str_replace( $http_prefix, $https_prefix, $upload_url );
			} elseif ( ! strncmp( $url, $http_prefix, strlen( $http_prefix ) ) ) { // if url begins with http:// make $upload_url begin with http:// as well
				$upload_url = str_replace( $https_prefix, $http_prefix, $upload_url );
			}

			// Check if $img_url is local.
			if ( false === strpos( $url, $upload_url ) ) { return false;
			}

			// Define path of image.
			$rel_path = str_replace( $upload_url, '', $url );
			$img_path = $upload_dir . $rel_path;

			// Check if img path exists, and is an image indeed.
			if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) ) { return false;
			}

			// Get image info.
			$info = pathinfo( $img_path );
			$ext = $info['extension'];
			list( $orig_w, $orig_h ) = getimagesize( $img_path );

			// Get image size after cropping.
			$dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
			$dst_w = $dims[4];
			$dst_h = $dims[5];

			// Return the original image only if it exactly fits the needed measures.
			if ( ! $dims && ( ( ( null === $height && $orig_w == $width ) xor ( null === $width && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) ) ) {
				$img_url = $url;
				$dst_w = $orig_w;
				$dst_h = $orig_h;
			} else {
				// Use this to check if cropped image already exists, so we can return that instead.
				$suffix = "{$dst_w}x{$dst_h}";
				$dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
				$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

				if ( ! $dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
					// Can't resize, so return false saying that the action to do could not be processed as planned.
					return $url;
				} // End if().
				elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
					$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
				} // Else, we resize the image and return the new resized image url.
				else {

					$editor = wp_get_image_editor( $img_path );

					if ( $editor instanceof WP_Error || is_wp_error( $editor->resize( $width, $height, $crop ) ) ) {
						return $url;
					}

					$resized_file = $editor->save();

					if ( ! is_wp_error( $resized_file ) ) {
						$resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
						$img_url = $upload_url . $resized_rel_path;
					} else {
						return $url;
					}
				}
			}// End if().

			// Okay, leave the ship.
			if ( true === $upscale ) { remove_filter( 'image_resize_dimensions', array( $this, 'aq_upscale' ) );
			}

			// Return the output.
			if ( $single ) {
				// str return.
				$image = $img_url;
			} else {
				// array return.
				$image = array(
					0 => $img_url,
					1 => $dst_w,
					2 => $dst_h,
				);
			}

			return $image;
		}

		/**
		 * Callback to overwrite WP computing of thumbnail measures
		 */
		function aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
			if ( ! $crop ) { return null; // Let the wordpress default function handle this.
			}

			// Here is the point we allow to use larger image size than the original one.
			$aspect_ratio = $orig_w / $orig_h;
			$new_w = $dest_w;
			$new_h = $dest_h;

			if ( ! $new_w ) {
				$new_w = intval( $new_h * $aspect_ratio );
			}

			if ( ! $new_h ) {
				$new_h = intval( $new_w / $aspect_ratio );
			}

			$size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

			$crop_w = round( $new_w / $size_ratio );
			$crop_h = round( $new_h / $size_ratio );

			$s_x = floor( ( $orig_w - $crop_w ) / 2 );
			$s_y = floor( ( $orig_h - $crop_h ) / 2 );

			return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
		}

	}

}// End if().


if ( ! function_exists( 'dslc_aq_resize' ) ) {

	/**
	 * Resize an image using DSLC_Aq_Resize Class
	 *
	 * @since 1.0
	 *
	 * @param string $url     The URL of the image
	 * @param int    $width   The new width of the image
	 * @param int    $height  The new height of the image
	 * @param bool   $crop    To crop or not to crop, the question is now
	 * @param bool   $single  If true only returns the URL, if false returns array
	 * @param bool   $upscale If image not big enough for new size should it upscale
	 * @return mixed If $single is true return new image URL, if it is false return array
	 *               Array contains 0 = URL, 1 = width, 2 = height
	 */
	function dslc_aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {

		if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {

			$args = array(
			  'resize' => "$width,$height",
			);
			if ( $single == true ) {
				return jetpack_photon_url( $url, $args );
			} else {
				$image = array(
					0 => $img_url,
					1 => $width,
					2 => $height,
				);
				return jetpack_photon_url( $url, $args );
			}
		} else {

			$aq_resize = DSLC_Aq_Resize::getInstance();
			return $aq_resize->process( $url, $width, $height, $crop, $single, $upscale );

		}

	}
}// End if().

/**
 * Returns amount of social shares a page has
 *
 * @since 1.0.4
 *
 * @param int $post_ID ID of the post/page. Default false, uses get_the_ID()
 * @param int $refresh_in Amount of seconds for cached info to be stored. Default 3600.
 * @return array  Array containing amount of shares. Keys are fb, twitter and pinterest.
 */
function dslc_get_social_count( $post_ID = false, $refresh_in = 3600 ) {

	// If ID nt supplied use current
	if ( $post_ID == false ) {
		$post_ID = get_the_ID();
	}

	// Transient
	$transient_id = 'dslc_social_shares_count_' . $post_ID;

	if ( false === ( $share_info = get_transient( $transient_id ) ) ) {

		$the_url = get_permalink( $post_ID );

		// Defaults
		$share_info = array(
			'fb' => 0,
			'twitter' => 0,
			'pinterest' => 0,
		);

		// Facebook
		$fb_get = wp_remote_get( 'http://graph.facebook.com/?id=' . $the_url );
		$fb_count = 0;
		if ( is_array( $fb_get ) ) {
			$fb_get_body = json_decode( $fb_get['body'] );
			if ( isset( $fb_get_body->shares ) ) {
				$fb_count = $fb_get_body->shares;
			} else {
				$fb_count = 0;
			}
			$share_info['fb'] = $fb_count;
		}

		// Twitter
		$twitter_get = wp_remote_get( 'http://cdn.api.twitter.com/1/urls/count.json?url=' . $the_url );
		$twitter_count = 0;
		if ( is_array( $twitter_get ) ) {
			$twitter_get_body = json_decode( $twitter_get['body'] );
			if ( isset( $twitter_get_body->count ) ) {
				$twitter_count = $twitter_get_body->count;
			} else {
				$twitter_count = 0;
			}
			$share_info['twitter'] = $twitter_count;
		}

		// Pinterest
		$pinterest_get = wp_remote_get( 'http://api.pinterest.com/v1/urls/count.json?url=' . $the_url );
		$pinterest_count = 0;
		if ( is_array( $pinterest_get ) ) {
			$pinterest_get_body = json_decode( preg_replace( '/^receiveCount\((.*)\)$/', "\\1", $pinterest_get['body'] ) );
			if ( isset( $pinterest_get_body->count ) ) {
				$pinterest_count = $pinterest_get_body->count;
			} else {
				$pinterest_count = 0;
			}
			$share_info['pinterest'] = $pinterest_count;
		}

		// Check if there is data
		if ( isset( $share_info ) ) {
			set_transient( $transient_id, $share_info, $refresh_in );
		} else {
			$share_info = false;
		}
	}// End if().

	// Pass the data back
	return $share_info;

}

function dslc_get_default_icon_set() {
	// Get array with available icons
	global $dslc_var_icons;

	$default_set = 'fontawesome';
	$default_set = apply_filters( 'dslc_default_icon_set', $default_set );

	if ( isset( $dslc_var_icons[ $default_set ] ) ) {
		// Try to return the default icon set ("fontawesome").
		return $default_set;
	} else {
		// If no default set found, return the first set in $dslc_var_icons.
		reset( $dslc_var_icons );
		return key( $dslc_var_icons );
	}
}

/**
 * Returns the ID of the currently used set based on icon
 *
 * @since 1.0.4
 *
 * @param string $icon The icon name
 * @return string  Current ID of the icon set
 */
function dslc_icons_current_set( $icon = false ) {

	// Get array with available icons.
	global $dslc_var_icons;

	// If no icon set return to the default "fontawesome"
	// If empty icon return default
	// If there is no "-" in icon, there is no set, return default
	if ( false === $icon || 0 === strlen( $icon ) || false === strpos( $icon, '-' ) ) {
		return dslc_get_default_icon_set();
	}

	// Get the first part of the icon ( representing the set ).
	$icon_parts = explode( '-', $icon );
	$icon_set = $icon_parts[0];

	if ( isset( $dslc_var_icons[ $icon_set ] ) ) {
		// If there is an icon set by that name return it.
		return $icon_set;
	} else {
		// Otherwise return the default.
		return dslc_get_default_icon_set();
	}
}

/**
 * Returns the ALT attribute for an attachment
 *
 * @since 1.0.7
 *
 * @param string $attachment_ID The ID of the attachment
 * @return string  The ALT attribute text
 */
function dslc_get_attachment_alt( $attachment_ID ) {

	// Get ALT.
	$thumb_alt = trim( strip_tags( get_post_meta( $attachment_ID, '_wp_attachment_image_alt', true ) ) );

	// No ALT supplied get attachment info.
	if ( empty( $thumb_alt ) ) {
		$attachment = get_post( $attachment_ID );
	}

	// Use caption if no ALT supplied
	if ( empty( $thumb_alt ) ) {
		$thumb_alt = trim( strip_tags( $attachment->post_excerpt ) );
	}

	// Use title if no caption supplied either
	if ( empty( $thumb_alt ) ) {
		$thumb_alt = trim( strip_tags( $attachment->post_title ) );
	}

	// Return ALT
	return esc_attr( $thumb_alt );

}

/**
 * Dismissable notices
 *
 * @since 1.0.8
 */
function dslc_dismiss_notice() {
	// Verify nonce
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'dslc_' . $_REQUEST['notice_id'] . '_nonce' ) ) {
		wp_die( 'No naughty business please' );
	}

	// Check access permissions
	if ( ! current_user_can( 'install_themes' ) ) {
		wp_die( 'You do not have rights to do this' );
	}

	if ( $_REQUEST['notice_id'] ) {
		$stored_notices = get_option( 'dslc_notices' );
		$stored_notices[ get_current_user_id() ][ $_REQUEST['notice_id'] . '_notice_dismissed' ] = 1;
		update_option( 'dslc_notices', $stored_notices );
	}

	wp_die();
}
add_action( 'wp_ajax_dslc_dismiss_notice', 'dslc_dismiss_notice' );

/**
 * Inline JS to attach click action for disisable notices
 *
 * @since 1.0.7.2
 *
 * Call Ajax action to dismiss a particular admin notice
 */

function dslc_adminjs_dismiss_notice() {
	?>
	<script type="text/javascript">
		jQuery(document).on( 'click', '.dslc-notice .notice-dismiss', function(event) {
				var notice_id = event.target.parentNode.id;
				var nonce = event.target.parentNode.getAttribute("data-nonce");

				jQuery.ajax({
					url: ajaxurl,
					data: {
						action: 'dslc_dismiss_notice',
						nonce: nonce,
						notice_id: notice_id,
					}
				})
			})
	</script>
<?php }
add_action( 'admin_footer', 'dslc_adminjs_dismiss_notice' );

/**
 * Checks if notice dismissed
 *
 * @since 1.0.8
 *
 * @param string $notice_id Unique id of the notice
 * @return boolean  true if notice is being dismissed
 */
function dslc_notice_dismissed( $notice_id ) {
	$stored_notices = get_option( 'dslc_notices' );
	$notice_dismissed = 0;
	$usr_id = get_current_user_id();

	if ( isset( $stored_notices[ $usr_id ][ $notice_id . '_notice_dismissed' ] ) && $stored_notices[ $usr_id ][ $notice_id . '_notice_dismissed' ] = 1 ) {
		$notice_dismissed = 1;
	}

	return $notice_dismissed;
}

/**
 * Generate nonce for the notice
 *
 * @since 1.0.8
 *
 * @param string $notice_id Unique id of the notice
 * @return string  nonce
 */
function dslc_generate_notice_nonce( $notice_id ) {
	$notice_nonce = wp_create_nonce( 'dslc_' . $notice_id . '_nonce' );
	return $notice_nonce;
}

/**
 * Filter returns admin interface turned on value
 *
 * @return bool
 */
function dslc_admin_int_on() {

	return true;
}

add_filter( 'dslc_admin_interface_on', 'dslc_admin_int_on', 1 );


/**
 * Filter textarea
 *
 * @param string $content Get textarea.
 */
function dslc_filter_textarea( $content ) {

	$content = str_replace( '<lctextarea', '<textarea', $content );
	$content = str_replace( '</lctextarea', '</textarea', $content );

	return $content;
}

add_filter( 'dslc_text_block_render', 'dslc_filter_textarea' );
