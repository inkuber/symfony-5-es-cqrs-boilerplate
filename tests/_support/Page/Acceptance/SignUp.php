<?php
namespace App\Tests\Page\Acceptance;

class SignUp
{
    // include url of current page
    public static $URL = '/sign-up';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * @var \App\Tests\AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\App\Tests\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function signUp(string $username, string $password)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::$URL);

        $I->fillField('email', $username);
        $I->fillField('password', $password);
        $I->click('Send');
    }
}
