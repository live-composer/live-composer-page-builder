<?php

class SampleTest extends WP_UnitTestCase {

	function setUp() {

		
	}

	function tearDown() {

	}

	function test_dslc_get_new_module_id() {

		$new_id = dslc_get_new_module_id();
		$this->assertNull( $new_id, 'User not logged in.' );

		$current_user = new WP_User( 1 );
		$current_user->set_role( 'administrator' );

		wp_set_current_user( 1 );
		$new_id = dslc_get_new_module_id();
		$this->assertInternalType( 'int', 'fgfg', 'User logged in as administrator.' );
		// replace this with some actual testing code
		//$this->assertTrue( class_exists( 'DSLC_Module' ) );
	}
}
