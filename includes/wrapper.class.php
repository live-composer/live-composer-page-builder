<?php
/**
 * Wrapper class, extends DSLC_Container
 */

/**
 * DSLC_Wrapper class
 */
class DSLC_Wrapper extends DSLC_Container{

	public function render_container() {

		?>
		<div class="dslc-container-wrapper">
			<?php echo do_shortcode( self::$content); ?>
		</div>
		<?php
	}
}