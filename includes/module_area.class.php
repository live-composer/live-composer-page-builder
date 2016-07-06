<?php
/**
 * Module area class, extends DSLC_Container
 */

/**
 * DSLC_Module_Area class
 */
class DSLC_Module_Area extends DSLC_Container {

	/**
	 * Renders module area contents
	 *
	 * @return string
	 */
	public function render_container() {

		$atts = self::$options;
		global $dslc_active;

		$pos_class = '';
		$module_area_size = $atts['size'];

		if ( $atts['last'] == 'yes' ) {
					$pos_class = 'dslc-last-col';
		}

		if ( isset( $atts['first'] ) && $atts['first'] == 'yes' ) {
					$pos_class = 'dslc-first-col';
		}

		$output = '<div class="dslc-modules-area dslc-col dslc-' . $atts['size'] . '-col ' . $pos_class . '" data-size="' . $atts['size'] . '">';

			if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

				// Management
				$output .= '<div class="dslca-modules-area-manage">
					<span class="dslca-modules-area-manage-line"></span>
					<div class="dslca-modules-area-manage-inner">
						<span class="dslca-manage-action dslca-copy-modules-area-hook" title="Duplicate" ><span class="dslca-icon dslc-icon-copy"></span></span>
						<span class="dslca-manage-action dslca-move-modules-area-hook" title="Drag to move" ><span class="dslca-icon dslc-icon-move"></span></span>
						<span class="dslca-manage-action dslca-change-width-modules-area-hook" title="Change width" >
							<span class="dslca-icon dslc-icon-columns"></span>
							<div class="dslca-change-width-modules-area-options">';
					$output .= '<span>' . __( 'Container Width', 'live-composer-page-builder' ) . '</span>';
					$output .= '<span data-size="1">1/12</span><span data-size="2">2/12</span>
								<span data-size="3">3/12</span><span data-size="4">4/12</span>
								<span data-size="5">5/12</span><span data-size="6">6/12</span>
								<span data-size="7">7/12</span><span data-size="8">8/12</span>
								<span data-size="9">9/12</span><span data-size="10">10/12</span>
								<span data-size="11">11/12</span><span data-size="12">12/12</span>
							</div>
						</span>
						<span class="dslca-manage-action dslca-delete-modules-area-hook" title="Delete" ><span class="dslca-icon dslc-icon-remove"></span></span>
					</div>
				</div>';

				// Loading
				$output .= '<div class="dslca-module-loading"><div class="dslca-module-loading-inner"></div></div>';

			}

			// Modules output
			if ( empty( self::$content ) || self::$content == ' ' ) {
							$output .= '&nbsp;';
			} else {
							$output .= do_shortcode( self::$content );
			}

		$output .= '</div>';

		// Return the output
		return $output;
	}
}
