<?php 

include '_bootstrap.php';

$I = new AcceptanceTester($scenario);

$I->am('admin'); // actor's role
$I->wantTo('Check if plugin is active');
$I->lookForwardTo('See Plugin Acrive'); // result to achieve

$I->assertNotEmpty( $slug, 'slug not empty' );


// Login to wp-admin
$I->loginAsAdmin();
$I->amOnPluginsPage();
$I->seePluginActivated( $slug );


$I->click( '.toplevel_page_dslc_plugin_options' );
$I->see('Live Composer updated');

