<?php
/**
 * Codeception test suite.
 */
class pluginActivationCest {
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
		$I->wantTo( 'Check Live Composer plugin activation and deactivation.' );
		$I->loginAsAdmin();
		$I->waitForElement( '#footer-thankyou', 10 );

		// go the plugins page
		$I->amOnPluginsPage();
		$I->seePluginActivated( 'live-composer-page-builder' );

		$I->scrollTo( ['css' => '[data-slug=live-composer-page-builder]'], 0, 80 );

		$I->deactivatePlugin( 'live-composer-page-builder' );
		$I->see( 'Selected plugins deactivated.' );

		$I->activatePlugin( 'live-composer-page-builder' );
		// Redirected to the LC Setting page and can see the last Extension
		// in the grid of extensions.
		$I->see( 'Custom Page Content' );
	}
}
