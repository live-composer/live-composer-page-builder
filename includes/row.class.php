<?php
/**
 * Row class, extends DSLC_Container
 */

/**
 * DSLC_Row
 */
class DSLC_Row extends DSLC_Container{

	/**
	 * Renders row content
	 * @return string
	 */
	public function render_container() {

		global $dslc_active;

		$atts = self::$options;
		$section_style = dslc_row_get_style( $atts );
		$section_class = '';
		$overlay_style = '';

		// Columns spacing
		if ( ! isset( $atts['columns_spacing'] ) )
			$atts['columns_spacing'] = 'spacing';

		// Custom Class
		if ( ! isset( $atts['custom_class'] ) )
			$atts['custom_class'] = '';

		// Show On
		if ( ! isset( $atts['show_on'] ) )
			$atts['show_on'] = 'desktop tablet phone';

		// Custom ID
		if ( ! isset( $atts['custom_id'] ) )
			$atts['custom_id'] = '';

		// Full/Wrapped
		if ( isset( $atts['type'] ) && ! empty( $atts['type'] ) && $atts['type'] == 'full' )
			$section_class .= 'dslc-full ';

		// Parallax
		$parallax_class = '';
		if ( isset( $atts['bg_image_attachment'] ) && ! empty( $atts['bg_image_attachment'] ) && $atts['bg_image_attachment'] == 'parallax' )
			$parallax_class = ' dslc-init-parallax ';

		// Overlay Color
		if ( isset( $atts['bg_video_overlay_color'] ) && ! empty( $atts['bg_video_overlay_color'] ) )
			$overlay_style .= 'background-color:' . $atts['bg_video_overlay_color'] . '; ';

		// Overlay Opacity
		if ( isset( $atts['bg_video_overlay_opacity'] ) && ! empty( $atts['bg_video_overlay_opacity'] ) )
			$overlay_style .= 'opacity:' . $atts['bg_video_overlay_opacity'] . '; ';

		/**
		 * BG Video
		 */

		// Overlay
		$bg_video = '<div class="dslc-bg-video dslc-force-show"><div class="dslc-bg-video-inner"></div><div class="dslc-bg-video-overlay" style="' . $overlay_style . '"></div></div>';

		// BG Video
		if ( isset( $atts['bg_video'] ) && $atts['bg_video'] !== '' && $atts['bg_video'] !== 'disabled' ) {

			// If it's numeric ( in the media library )
			if ( is_numeric( $atts['bg_video'] ) )
				$atts['bg_video'] = wp_get_attachment_url( $atts['bg_video'] );

			// Remove the file type extension
			$atts['bg_video'] = str_replace( '.mp4', '', $atts['bg_video'] );
			$atts['bg_video'] = str_replace( '.webm', '', $atts['bg_video'] );

			// The HTML
			$bg_video = '
			<div class="dslc-bg-video">
				<div class="dslc-bg-video-inner">
					<video>
						<source type="video/mp4" src="' . $atts['bg_video'] . '.mp4" />
						<source type="video/webm" src="' . $atts['bg_video'] . '.webm" />
					</video>
				</div>
				<div class="dslc-bg-video-overlay" style="'. $overlay_style . '"></div>
			</div>';

		}

		// No video HTML if builder innactive or no video
		if ( ! $dslc_active && $atts['bg_video'] == '' && $atts['bg_image'] == '' && isset( $atts['bg_image_thumb'] ) && $atts['bg_image_thumb'] == 'disabled' ) {
			$bg_video = '';
		}

		/**
		 * Admin Classes
		 */

		$a_container_class = '';
		$a_prepend = '';
		$a_append = '';

		if ( $dslc_active ) {
			$a_container_class .= 'dslc-modules-section-empty ';
			$a_prepend = '<div class="dslc-modules-section-inner dslc-clearfix">';
			$a_append = '</div>';
		}

		// Columns spacing
		if ( $atts['columns_spacing'] == 'nospacing' )
			$section_class .= 'dslc-no-columns-spacing ';

		// Custom Class.
		if ( $atts['custom_class'] != '' ) {

			// Process all class definitions.
	  		$custom_class = preg_replace( '/,/', ' ', $atts['custom_class'] );
	  		$custom_class = preg_replace( '/\b\.\b/', ' ', $custom_class );
	  		$custom_class = preg_replace( '/\./', '', $custom_class );
	  		$custom_class = preg_replace( '/\s{2,}/', ' ', $custom_class );
	  		$custom_class = trim( $custom_class );

			$section_class .= $custom_class . ' ';
		}

		// Show on Class.
		// if ( '' !== $atts['show_on']  ) {
		$show_on = explode( ' ', trim( $atts['show_on'] ) );

		if ( ! in_array( 'desktop', $show_on, true ) ) {
			$section_class .= 'dslc-hide-on-desktop ';
		}

		if ( ! in_array( 'tablet', $show_on, true ) ) {
			$section_class .= 'dslc-hide-on-tablet ';
		}

		if ( ! in_array( 'phone', $show_on, true ) ) {
			$section_class .= 'dslc-hide-on-phone ';
		}
		// }
		// Allow other developers to add classes.
		$filter_classes = array();
		$filter_classes = apply_filters( 'dslc_row_class', $filter_classes, $atts );
		$extra_classes = '';
		if ( count( $filter_classes ) > 0 ) {
			foreach ( $filter_classes as $filter_class ) {
				$extra_classes .= $filter_class . ' ';
			}
		}

		// Custom ID.
		$section_id = false;
		if ( $atts['custom_id'] != '' )
			$section_id = $atts['custom_id'];

		// Custom ID - Output
		$section_id_output = '';
		if ( $section_id )
			$section_id_output = 'id="' . $section_id . '"';

		$output = '
			<div ' . $section_id_output . ' class="dslc-modules-section ' . $a_container_class . $parallax_class . $section_class . $extra_classes . '" style="' . dslc_row_get_style( $atts ) . '">

					'.$bg_video . '

					<div class="dslc-modules-section-wrapper dslc-clearfix">'

						. $a_prepend . do_shortcode( self::$content ) . $a_append

						. '</div>';

			if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

				// Management
				$output .= '
					<div class="dslca-modules-section-manage">
						<div class="dslca-modules-section-manage-inner">
							<span class="dslca-manage-action dslca-edit-modules-section-hook" title="Edit options" ><span class="dslca-icon dslc-icon-cog"></span></span>
							<span class="dslca-manage-action dslca-copy-modules-section-hook" title="Duplicate" ><span class="dslca-icon dslc-icon-copy"></span></span>
							<span class="dslca-manage-action dslca-move-modules-section-hook" title="Drag to move" ><span class="dslca-icon dslc-icon-move"></span></span>
							<span class="dslca-manage-action dslca-export-modules-section-hook" title="Export section code" ><span class="dslca-icon dslc-icon-upload-alt"></span></span>
							<span class="dslca-manage-action dslca-delete-modules-section-hook" title="Delete" ><span class="dslca-icon dslc-icon-remove"></span></span>
						</div>
					</div>
					<div class="dslca-modules-section-settings">' . dslc_row_get_options_fields( $atts ) . '</div>';

				// Loading
				$output .= '<div class="dslca-module-loading dslca-modules-area-loading"><div class="dslca-module-loading-inner"></div></div>';

			}

		$output .= '</div>';

		// Return the output
		return $output;
	}
}