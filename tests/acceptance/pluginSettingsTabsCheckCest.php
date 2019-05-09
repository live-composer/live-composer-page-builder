<?php
/**
 * Codeception test suite.
 */
class pluginSettingsTabsCheckCest {
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
		$I->wantTo( 'Check tabs on Live Composer Settings page.' );
		$I->loginAsAdmin();
		$I->waitForElement( '#footer-thankyou', 10 );

		// go to the Live Composer settings screen.
		$I->click( 'Live Composer' );
		// The last element on the default 'Extensions' tab.
		$I->see( 'Custom Page Content' );

		// Check WooCommerce tab.
		$I->click( 'WooCommerce', '#dslc-tabs' );
		$I->see( 'WooCommerce Integration' );

		// Check Docs & Support tab.
		$I->click( 'Docs & Support', '#dslc-tabs' );
		$I->see( 'Documentation & Support' );

		// Check Settings tab.
		$I->click( 'Settings', '#dslc-tabs' );
		$I->see( 'General Options' );
	}
}
