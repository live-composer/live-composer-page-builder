<?php

/**
 * Basic acception tests for Live Composer.
 *
 * @since 1.0.0
 */

// $lcPluginSlug = 'live-composer-page-builder';


$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Login into WordPress before running other scripts.' );
$I->loginAsAdmin();

// go the plugins page
$I->amOnPluginsPage();

// EOF
