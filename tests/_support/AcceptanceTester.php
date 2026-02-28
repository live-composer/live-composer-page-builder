<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

   /**
    * Define custom actions here
    */
	/**
	 * Check if text exists on page to be used in a conditional.
	 * @docs: https://deliciousbrains.com/automated-testing-woocommerce/
	 *
	 * @param string $text
	 *
	 * @return bool
	 */
	public function seeOnPage( $text ) {
		try {
			$this->see( $text );
		} catch ( \PHPUnit\Framework\ExpectationFailedException $f ) {
			return false;
		}

		return true;
	}

	public function type( $text ) {
		$I = $this;
		$I->executeInSelenium( function( RemoteWebDriver $webDriver )use( $text ) {
			$webDriver->getKeyboard()->sendKeys($text);
		});
	}
}
