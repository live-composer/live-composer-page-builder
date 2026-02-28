<?php

/**
 * Codeception test suite.
 */
class pageEditingCest {
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
		$I->wantTo( 'Check page creation and editing.' );

		$I->loginAsAdmin();
		$I->waitForElement( '#footer-thankyou', 10 );

		// Publish new page.
		$I->amOnPage( '/wp-admin/post-new.php?post_type=page' );

		// $I->waitForElement( '[name="post_title"]', 30 ); // Classic editor
		$I->waitForElement( '.editor-post-title__input', 30 ); // Gutenberg
		// $I->fillField( [ 'name' => 'post_title' ], 'Codeception Automatic Testing' ); // Classic editor
		$I->fillField( '.editor-post-title__input', 'Codeception Automatic Testing' );
		$I->see( 'Publish' ); $I->click( 'Publish' );
		$I->waitForText('Are you ready to publish?', 30); $I->click( 'Publish' );
		$I->waitForText('View Page', 30); $I->click( 'View Page' );
		// Check default interface elements on the LC editing screen.
		$I->wait( 3 );
		$I->waitForElement( '.dslca-activate-composer-hook', 30 ); $I->click( 'Edit in Live Composer' );
		$I->see( 'Elements' );
		$I->see( 'Info Box' );
		$I->waitForElement( '.dslca-save-composer-helptext', 10 ); // secs
		$I->see( 'Close' );

		# switch to editing frame.
		$I->switchToIframe( 'page-builder-frame' );
		$I->see( 'Add Modules Row' );

		// Test BUTTON module import:
		// Scroll to the button before clicking on it.
		$I->scrollTo( ['css' => '.dslca-import-modules-section-hook'], 0, 80 );
		// Click import row button.
		$I->click( '.dslca-import-modules-section-hook' );

		# switch to parent iframe (we have code modal in the parent).
		$I->switchToIFrame();
		$lc_element_button = '[{"element_type":"row","columns_spacing":"spacing","custom_class":"","show_on":"desktop tablet phone","section_instance_id":"e44f6713d7a","content":[{"element_type":"module_area","last":"yes","first":"no","size":"12","content":[{"css_show_on":"desktop tablet phone","button_text":"TEST BUTTON","button_url":"#","module_instance_id":"b2396c744a5","post_id":"23","dslc_m_size":"12","module_id":"DSLC_Button","element_type":"module","last":"yes"}]}]}]';
		$I->fillField( '.dslca-prompt-modal-active .dslca-prompt-modal-descr textarea', $lc_element_button );
		$I->click( '.dslca-prompt-modal-active .dslca-prompt-modal-confirm-hook' );

		# switch to editing frame.
		$I->switchToIframe( 'page-builder-frame' );
		$I->waitForElement( '.dslc-module-DSLC_Button', 10 ); // LC code import takes some time.
		$I->see( 'TEST BUTTON' );

		# switch to parent iframe.
		$I->switchToIFrame();
		$I->click( 'Publish Changes' );
		$I->waitForElementNotVisible( '.dslca-save-composer', 10 ); // secs
		$I->click( '.dslca-close-composer-hook' ); // DISABLE EDITOR
		// Click 'Confirm'
		// If Publish Changes clicked before saving > users will see no confirmation popup.
		// $I->click('.dslca-prompt-modal-active .dslca-prompt-modal-confirm-hook');

		// Check button rendered on Front-End
		$I->waitForElement( '.dslc-module-DSLC_Button', 10 ); // LC code import takes some time.
		$I->see( 'TEST BUTTON' );


		// if ($scenario->running()) {
			// Logger::log('test');
		// }

		// $this->loginAs($this->config['adminUsername'], $this->config['adminPassword']);
		// codecept_debug($I);
		// codecept_debug($scenario);
	}
}
