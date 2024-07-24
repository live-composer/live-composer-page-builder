<?php
/**
 * Codeception test suite.
 */
class postYoastOGCest {
	/**
	 * Actions to take before launching the test.
	 *
	 * @param AcceptanceTester $I
	 * @return void
	 */
	public function _before( AcceptanceTester $I ) {
	}

	/**
	 * Test directives.
	 *
	 * @param AcceptanceTester $I
	 * @return void
	 */
	public function tryToTest( AcceptanceTester $I ) {
		$I->wantTo( 'To check YoastSEO Open Graph output in Live Composer.' );

		$I->loginAsAdmin();
		$I->amOnPluginsPage();
		$I->activatePlugin('wordpress-seo');

		// Publish new page.
		$I->amOnPage( '/wp-admin/post-new.php?post_type=page' );
		$I->waitForElement( '.editor-post-title__input', 30 ); // Gutenberg
		$I->fillField( '.editor-post-title__input', 'Post With Yoast Open Graph Data' );

		// Open and fill YOAST meta > Snippet
		$I->click( 'Edit snippet' ); // Click Yoast > "Edit Snipet"
		$I->wait( 1 );
		$I->clearField( '#snippet-editor-field-title' );
		$I->wait( 5 );
		$I->fillField( '#snippet-editor-field-title', 'This is a custom SEO TITLE.' );
		$I->wait( 5 );
		$I->fillField('#snippet-editor-field-description', 'This is a custom SEO META DESCRIPTION.');

		$I->click( 'Focus keyphrase' );
		$I->fillField('#focus-keyword-input', 'Yoast Open Graph Data');
		$I->wait( 1 ); // won't work without delay
		$I->pressKey('body',  WebDriverKeys::PAGE_UP);
		$I->wait( 1 ); // won't work without delay
		// Open and fill YOAST meta > Social
		// $I->scrollTo( ['css' => '.edit-post-visual-editor'], 0, -200 );  // Not Working so use Page Up.
		// $I->pressKey('body',  WebDriverKeys::PAGE_UP);
		// $I->wait( 1 );
		$I->clickWithLeftButton('a[href="#wpseo-meta-section-social"]');
		// $I->click( 'a[href="#wpseo-meta-section-social"]' ); // Click Yoast > "Social" icon-tab.
		$I->fillField( '#yoast_wpseo_opengraph-title', 'This is a custom FACEBOOK TITLE.' );
		$I->fillField( '#yoast_wpseo_opengraph-description', 'This is a custom FACEBOOK DESCRIPTION.' );
		// $I->fillField( '#yoast_wpseo_opengraph-image', 'http://www.seowptheme.com/wp-content/uploads/project-thumb-1-1.png' );


		// Publish changes.
		$I->see( 'Publish' ); $I->click( 'Publish' );
		$I->waitForText('Are you ready to publish?', 30); $I->click( 'Publish' );
		$I->waitForText('View Page', 30); $I->click( 'View Page' );

		// Open the front-end and fill with custom LC content to test YOAST.
		$I->wait( 3 );
		$I->waitForElement( '.dslca-activate-composer-hook', 30 ); $I->click( 'Edit in Live Composer' );
		# switch to editing frame.
		$I->switchToIframe( 'page-builder-frame' );
		$I->see( 'Add Modules Row' );
		// Insert custom section:
		// Scroll to the button before clicking on it.
		$I->scrollTo( ['css' => '.dslca-import-modules-section-hook'], 0, 80 );
		// Click import row button.
		$I->click( '.dslca-import-modules-section-hook' );
		# switch to parent iframe (we have code modal in the parent).
		$I->switchToIFrame();
		$lc_section = '[{"element_type":"row","columns_spacing":"spacing","custom_class":"","show_on":"desktop tablet phone","section_instance_id":"4e943449072","content":[{"element_type":"module_area","last":"yes","first":"no","size":"12","content":[{"image_url":"https://ps.w.org/wordpress-seo/assets/banner-1343.jpg","image_alt":"Yoast Open Graph Data","image_title":"Yoast Open Graph Data","module_instance_id":"14e013415d3","post_id":"25","dslc_m_size":"12","module_id":"DSLC_Image","element_type":"module","last":"yes"},{"content":"<div><h2>Heading With Yoast Open Graph Data</h2></div>","module_instance_id":"370c3e2bbe3","post_id":"27","dslc_m_size":"12","module_id":"DSLC_Text_Simple","element_type":"module","last":"yes","dslc_m_size_last":"yes","module_render_nonajax":"1"},{"css_show_on":"desktop tablet phone","css_custom":"enabled","content":"<p>This is testing content for the Post With <strong>Yoast Open Graph Data</strong>.</p><p>Key phrase is Yoast Open Graph Data.</p>","module_instance_id":"e6d905086c9","post_id":"27","dslc_m_size":"12","module_id":"DSLC_Text_Simple","element_type":"module","last":"yes","dslc_m_size_last":"yes","module_render_nonajax":"1"}]}],"dslca-img-url":""}]';
		$I->fillField( ['css' => '.dslca-prompt-modal-active .dslca-prompt-modal-descr textarea'], $lc_section );
		$I->click( '.dslca-prompt-modal-active .dslca-prompt-modal-confirm-hook' );
		$I->wait( 3 );
		$I->click( 'Publish Changes' );
		$I->waitForElementNotVisible( '.dslca-save-composer', 10 ); // secs
		$I->click( '.dslca-close-composer-hook' ); // DISABLE EDITOR
		// Check default interface elements on the LC editing screen.
		$I->waitForElement( 'body', 30 ); // secs
		$I->seeInSource( '<title>Post With Yoast Open Graph Data - My Great Blog This is a custom SEO TITLE.</title>' );
		$I->seeInSource( '<meta name="description" content="This is a custom SEO META DESCRIPTION.">' );
		$I->seeInSource( '<meta property="og:title" content="This is a custom FACEBOOK TITLE.">' );
		$I->seeInSource( '<meta property="og:description" content="This is a custom FACEBOOK DESCRIPTION.">' );
		// $I->seeInSource( '<meta property="og:image" content="http://www.seowptheme.com/wp-content/uploads/project-thumb-1-1.png">' );
		$I->seeInSource( '<meta name="twitter:description" content="This is a custom SEO META DESCRIPTION.">' );
		$I->seeInSource( '<meta name="twitter:title" content="Post With Yoast Open Graph Data - My Great Blog This is a custom SEO TITLE.">' );
		// $I->seeInSource( '<meta name="twitter:image" content="http://www.seowptheme.com/wp-content/uploads/project-thumb-1-1.png">' );

		$I->click( 'Edit Page' );

		// Check Yoast analysis report to include our LC custom content.
		$I->pressKey('body',  WebDriverKeys::PAGE_DOWN); // Won't scroll in Gutenberg using scrollTo.
		// $I->scrollTo( ['css' => '#yoast-seo-analysis-collapsible-metabox'], 0, 80 );
		$I->click( '#yoast-seo-analysis-collapsible-metabox' );
		$I->wait( 1 );
		$I->pressKey('body',  WebDriverKeys::PAGE_DOWN); // Won't scroll in Gutenberg using scrollTo.
		$I->wait( 1 );
		$I->pressKey('body',  WebDriverKeys::PAGE_DOWN);
		$I->wait( 1 );
		$I->pressKey('body',  WebDriverKeys::PAGE_DOWN);
		// $I->scrollTo( ['css' => '#yoast-additional-keyphrase-collapsible-metabox'], 0, 80 );
		$I->see( 'Your higher-level subheading reflects the topic of your copy. Good job!' );
		$I->see( 'Image alt attributes: Good job!' );
		$I->see( 'The meta description is too short (under 120 characters). Up to 156 characters are available.' );
		$I->see( 'The exact match of the keyphrase appears in the SEO title, but not at the beginning.' );
		$I->see( 'The text contains 25 words. This is far below the recommended minimum of 300 words.' );
	}
}
