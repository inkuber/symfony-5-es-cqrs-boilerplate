<?php
namespace App\Tests\Page\Acceptance;

class SignIn
{
    // include url of current page
    public static $URL = '/sign-in';

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

    public function signIn(string $username, string $password)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::$URL);

        $I->fillField('username', $username);
        $I->fillField('password', $password);
        $I->click('#sign-in');
    }
}
