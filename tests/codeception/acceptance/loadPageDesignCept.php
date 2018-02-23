<?php
/**
 * Test Load Page Design in Live Composer.
 *
 * @since 1.0.0
 */


$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Load Page Design.' );
$I->loginAsAdmin();
$I->waitForElement('#footer-thankyou');

// Publish new page.
$I->amOnPage( '/wp-admin/post-new.php?post_type=page' );
$I->waitForElement( '[name="post_title"]', 30 );
$I->fillField( [ 'name' => 'post_title' ], 'Codeception Automatic Testing (Load Page Design)' );
$I->see( 'Publish' ); $I->click( 'Publish' );

// Load Page Design.
$I->click( 'View page' );
$I->click( 'Edit in Live Composer' );
$I->see('HTML');
$I->click( '.dslca-go-to-section-templates' );
$I->see('Load Page Design');
$I->click('Load Page Design');
$I->see('Blog Variation 1');
$I->click('Blog Variation 1');
$I->switchToIframe( 'page-builder-frame' );
$I->waitForElement( '.dslc-module-DSLC_Blog', 10 );
$I->see('CONTINUE READING');
$I->switchToIFrame();
$I->click( 'Publish Changes' );
$I->waitForElementNotVisible( '.dslca-save-composer', 10 );
$I->click( '.dslca-close-composer-hook' ); // DISABLE EDITOR

// Check module Blog rendered on Front-End.
$I->waitForElement( '.dslc-module-DSLC_Blog', 10 );
$I->see('CONTINUE READING');
