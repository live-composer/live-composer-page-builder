<?php
/**
 * Basic acception tests for Live Composer.
 *
 * @since 1.0.0
 */


$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Check LC Extensions & LC Woo plugins.' );
$I->loginAsAdmin();
$I->waitForElement('#footer-thankyou');

// Live Composer.
$I->amOnPluginsPage();
$I->seePluginActivated( 'live-composer-page-builder' );

// Live Composer - Premium Extensions.
$I->seePluginInstalled( 'live-composer-premium-extensions' );
$I->activatePlugin( 'live-composer-premium-extensions' );
// Redirected to the LC Setting page and can see the last Extension
// in the grid of extensions.
$I->see( 'Custom Page Content' );

// WooCommerce.
$I->amOnPluginsPage();
$I->seePluginInstalled( 'woocommerce' );
$I->activatePlugin( 'woocommerce' );
$I->amOnPluginsPage();
$I->seePluginActivated( 'woocommerce' );

// Live Composer - WooCommerce Integration
$I->seePluginInstalled( 'live-composer-woocommerce-integration' );
$I->activatePlugin( 'live-composer-woocommerce-integration' );
// Redirected to the LC Setting page and can see the last Extension
// in the grid of extensions.
$I->see( 'Custom Page Content' );
