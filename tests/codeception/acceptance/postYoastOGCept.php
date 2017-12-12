<?php

/**
 * Test YoastSEO Meta and Open Graph output in Live Composer.
 *
 * @since 1.3.10
 */

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check YoastSEO Open Graph output in Live Composer.' );

$I->loginAsAdmin();
$I->waitForElement( '#footer-thankyou', 10 );

// Publish new page.
$I->amOnPage('/wp-admin/post-new.php');
$I->waitForElement('[name="post_title"]', 30); // secs
$I->fillField(['name' => 'post_title'], 'Post With Yoast Open Graph Data');

// Open and fill YOAST meta > Snippet
$I->click( '#wpseo_meta .snippet-editor__edit-button' ); // Click Yoast > "Edit Snipet"
$I->fillField('#snippet-editor-title', 'This is a custom SEO TITLE.');
$I->fillField('#snippet-editor-meta-description', 'This is a custom SEO META DESCRIPTION.');

// Open and fill YOAST meta > Social
$I->click( 'a[href="#wpseo-meta-section-social"]' ); // Click Yoast > "Social" icon-tab.
$I->fillField('#yoast_wpseo_opengraph-title', 'This is a custom FACEBOOK TITLE.');
$I->fillField('#yoast_wpseo_opengraph-description', 'This is a custom FACEBOOK DESCRIPTION.');
$I->fillField('#yoast_wpseo_opengraph-image', 'http://www.seowptheme.com/wp-content/uploads/project-thumb-1-1.png');

$I->see( 'Publish' ); $I->click( 'Publish' );

// Check default interface elements on the LC editing screen.
$I->click( 'View post' );

$I->seeInSource('<title>This is a custom SEO TITLE.</title>');
$I->seeInSource('<meta name="description" content="This is a custom SEO META DESCRIPTION."/>');

$I->seeInSource('<meta property="og:title" content="This is a custom FACEBOOK TITLE." />');
$I->seeInSource('<meta property="og:description" content="This is a custom FACEBOOK DESCRIPTION." />');
$I->seeInSource('<meta property="og:image" content="http://www.seowptheme.com/wp-content/uploads/project-thumb-1-1.png" />');

$I->seeInSource('<meta name="twitter:description" content="This is a custom SEO META DESCRIPTION." />');
$I->seeInSource('<meta name="twitter:title" content="This is a custom SEO TITLE." />');
$I->seeInSource('<meta name="twitter:image" content="http://www.seowptheme.com/wp-content/uploads/project-thumb-1-1.png" />');


// EOF
