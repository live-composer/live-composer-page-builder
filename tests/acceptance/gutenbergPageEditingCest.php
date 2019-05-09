<?php
/**
 * Codeception test suite.
 */
class gutenbergPageEditingCest {
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
		$I->wantTo( 'Check Live Composer UI elements in the Gutenberg editor.' );

		$I->loginAsAdmin();
		$I->waitForElement( '#footer-thankyou', 10 );

		// Publish new page.
		$I->amOnPage( '/wp-admin/post-new.php?post_type=page' );
		$I->wait( 1 );
		// Close Gutenberg Tutorial Popup.
		if ( $I->seeOnPage( 'Welcome to the wonderful world of blocks!' ) ) {
			$I->click('button.nux-dot-tip__disable');
		}
		/* if ( $I->tryToSeeElement( 'Welcome to the wonderful world of blocks!' ) ) {
			$I->click('button.nux-dot-tip__disable');
		} */
		// $I->canSee( 'Welcome to the wonderful world of blocks!' );
		// $I->click('button.nux-dot-tip__disable');
		$I->waitForText('Edit this page in the front-end page builder', 10);
		$I->waitForElement( '#lc-open-live-composer-button', 10 ); // Open In Live Composer
		$I->click( 'Open in Live Composer' );
		// $I->wait( 3 );

		$I->waitForText( 'Elements', 10 );
		$I->see( 'Info Box' );
		$I->waitForElement( '.dslca-save-composer-helptext', 10 ); // secs
		$I->see( 'Close' );
	}
}
