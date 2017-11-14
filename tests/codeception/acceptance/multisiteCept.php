<?php

/**
 * Basic test to demonstrate that it works on multisite.
 *
 * @package wp-browser-travis-demo
 * @since 1.0.0
 */

if ( ! getenv( 'WP_MULTISITE' ) ) {
	$scenario->skip( 'Multisite must be enabled.' );
}

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Visit WordPress network Dashboard' );
$I->loginAsAdmin();
$I->see( 'Dashboard' );
$I->amOnPage( '/wp-admin/network/' );
$I->see( 'Network Admin' );
$I->see( 'Create a New Site' );

// EOF
