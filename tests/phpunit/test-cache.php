<?php
/**
 * Class Cache
 *
 * @package Live_Composer_Page_Builder
 */

/**
 * Test Cache.
 */
class Cache extends WP_UnitTestCase {

	/**
	 * Test: Cache Enabled/Disabled
	 */
	public function test_cache_enabled_or_disabled() {

		/**
		 * Cache is enabled
		 */

		$lc_cache     = new DSLC_Cache();
		$ref_object   = new ReflectionObject( $lc_cache );
		$ref_property = $ref_object->getProperty( 'enabled' ); // private static $enabled.
		$ref_property->setAccessible( true );
		$ref_property->setValue( null, true ); // cache is enabled

		$cache_enabled = $lc_cache->enabled();
		$lc_cache->set_cache( 'lc_custom_cache', '5', 'html' );
		$transient_lc_cache = $lc_cache->get_cache( '5', 'html' );

		// Check if cache is enabled.
		$this->assertTrue( $cache_enabled );

		// Check if have a transient cache in the DB.
		$this->assertEquals( 'lc_custom_cache', $transient_lc_cache );

		/**
		 * Cache is disabled
		 */

		$ref_property->setValue( null, false ); // cache is disabled
		$cache_disabled = $lc_cache->enabled();
		$lc_cache->delete_cache();
		$transient_lc_cache = $lc_cache->get_cache( '5', 'html' );

		// Check if cache is disabled.
		$this->assertFalse( $cache_disabled );

		// Check if does not have a transient cache in the DB.
		$this->assertEmpty( $transient_lc_cache );

		// fwrite( STDERR, print_r( $transient_lc_cache, true ) );
	}

	/**
	 * Test: To clear a cache when a page update via WP Admin
	 */
	public function test_cache_update_page() {

		// Cache is enabled.
		$lc_cache     = new DSLC_Cache();
		$ref_object   = new ReflectionObject( $lc_cache );
		$ref_property = $ref_object->getProperty( 'enabled' ); // private static $enabled.
		$ref_property->setAccessible( true );
		$ref_property->setValue( null, true ); // cache is enabled

		$cache_enabled = $lc_cache->enabled();

		// Check if cache is enabled.
		$this->assertTrue( $cache_enabled );

		$page_id = $this->factory->post->create(
			array(
				'post_type'    => 'page',
				'post_title'   => 'Page Test Cache',
				'post_content' => 'Test Cache',
			)
		);

		// Check if page was added.
		$page = get_post( $page_id );
		$this->assertEquals( 'Page Test Cache', $page->post_title );

		$lc_cache->set_cache( 'lc_html', $page_id, 'html' );
		$lc_cache->set_cache( 'lc_css', $page_id, 'css' );
		$lc_cache->set_cache( 'lc_fonts', $page_id, 'fonts' );

		// Check if a page is a cached.
		$this->assertTrue( $lc_cache->cached( $page_id ) );

		// Update Page.
		$update_page                 = array();
		$update_page['ID']           = $page_id;
		$update_page['post_content'] = 'New Content';

		wp_update_post( wp_slash( $update_page ) );

		// Check if a page was updaded.
		$page = get_post( $page_id );
		$this->assertEquals( 'New Content', $page->post_content );

		// Check if a page is not cached.
		$this->assertFalse( $lc_cache->cached( $page_id ) );

		//fwrite( STDERR, print_r( $lc_cache->cached( $page_id ), true ) );
	}

	/**
	 * Test: To clear a cache when a page update via LC interface
	 */
	public function test_cache_update_lc_interface() {

		// Cache is enabled.
		$lc_cache     = new DSLC_Cache();
		$ref_object   = new ReflectionObject( $lc_cache );
		$ref_property = $ref_object->getProperty( 'enabled' ); // private static $enabled.
		$ref_property->setAccessible( true );
		$ref_property->setValue( null, true ); // cache is enabled

		$cache_enabled = $lc_cache->enabled();

		// Check if cache is enabled.
		$this->assertTrue( $cache_enabled );

		$page_id = $this->factory->post->create(
			array(
				'post_type'    => 'page',
				'post_title'   => 'LC Interface Cache',
				'post_content' => 'LC Interface',
			)
		);

		// Check if page was added.
		$page = get_post( $page_id );
		$this->assertEquals( 'LC Interface Cache', $page->post_title );

		$lc_cache->set_cache( 'lc_html 2', $page_id, 'html' );
		$lc_cache->set_cache( 'lc_css 2', $page_id, 'css' );
		$lc_cache->set_cache( 'lc_fonts 2', $page_id, 'fonts' );

		// Check if a page is a cached.
		$this->assertTrue( $lc_cache->cached( $page_id ) );

		/**
		 * Add custom field ( dslc_code ). We are using the hook of add_post_meta
		 * because in the class DSLC_Cache use the action of added_post_meta in the __construct.
		 */
		add_post_meta( $page_id, 'dslc_code', 'custom_dslc_code' );
		$dslc_code = get_post_meta( $page_id, 'dslc_code', true );

		// Check if custom field ( dslc_code ) was added.
		$this->assertEquals( 'custom_dslc_code', $dslc_code );

		// Check if a page is not cached.
		$this->assertFalse( $lc_cache->cached( $page_id ) );

		// fwrite( STDERR, print_r( get_transient( 'lc_cache' ), true ) );
	}

	/**
	 * Test: Disable a cache when popular plugins ( W3 Total Cache or WP Super cache ) are enabled.
	 */
/* 	public function test_cache_active_popular_plugins() {

		// Cache is enabled.
		$lc_cache     = new DSLC_Cache();
		$ref_object   = new ReflectionObject( $lc_cache );
		$ref_property = $ref_object->getProperty( 'enabled' ); // private static $enabled.
		$ref_property->setAccessible( true );
		$ref_property->setValue( null, true ); // cache is enabled

		$cache_enabled = $lc_cache->enabled();

		// Check if cache is enabled.
		$this->assertTrue( $cache_enabled );

		$disable_cache = $lc_cache->should_disable_cache();

		// Check if cache is disable.
		$this->assertTrue( $disable_cache);

		// fwrite( STDERR, print_r( $disable_cache, true ) );
	} */
}
