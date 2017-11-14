<?php
/**
 * Class SampleTest
 *
 * @package Live_Composer_Page_Builder
 */

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

	/**
	 * Test some important constants
	 */
	public function test_constants() {
 
		// $stats = new EDD_Payment_Stats;
		// $sales = $stats->get_sales( 0, 'this_month' );

		// $this->assertEquals( 1, $sales );
		// $this->assertGreaterThan( 0, $sales );
		// $this->assertLessThan( 10, $sales );

		// Extract version number from the plugin meta comment block.
		$path_to_current_folder = __DIR__;
		$abspath = str_replace( '/tests', '', $path_to_current_folder );
		$version = get_file_data( $abspath . '/ds-live-composer.php', array( 'Version' ), 'plugin' );
		$version = $version[0];
		// Compare DS_LIVE_COMPOSER_VER with extracted above version.
		$this->assertEquals( DS_LIVE_COMPOSER_VER, $version );
		$this->assertFalse( DS_LIVE_COMPOSER_DEV_MODE );
		$this->assertFalse( DS_LIVE_COMPOSER_ACTIVE );
		$this->assertEquals( DS_LIVE_COMPOSER_SHORTNAME, 'Live Composer' );
		// $this->assertEquals( DS_LIVE_COMPOSER_BASENAME, 'live-composer-page-builder' );
	
	}
}
