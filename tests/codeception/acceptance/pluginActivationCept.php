<?php

/**
 * Basic acception tests for Live Composer.
 *
 * @since 1.0.0
 */

// $lcPluginSlug = 'live-composer-page-builder';


$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Check Live Composer plugin activation and deactivation.' );
$I->loginAsAdmin();
$I->waitForElement( '#footer-thankyou', 10 );

// go the plugins page
$I->amOnPluginsPage();
$I->seePluginActivated( 'live-composer-page-builder' );

$I->deactivatePlugin( 'live-composer-page-builder' );
$I->see( 'Plugin deactivated.' );

$I->activatePlugin( 'live-composer-page-builder' );
// Redirected to the LC Setting page and can see the last Extension
// in the grid of extensions.
$I->see( 'Custom Page Content' );


// $I->deactivatePlugin( 'live-composer-page-builder' );
// $I->see( 'Plugin deactivated.');	




// check that a plugin is installed and activated from the plugin page
// $I->seePluginActivated('live-composer-page-builder');

// $I->see( 'Live Composer' );

// EOF
