<?php
/**
 * Codeception test suite.
 */
class firstLoginCest {
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
		$I->wantTo( 'Login into WordPress before running other scripts.' );
		$I->loginAsAdmin();

		// Go the plugins page.
		$I->amOnPluginsPage();
	}
}
