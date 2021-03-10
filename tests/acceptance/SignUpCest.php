<?php namespace App\Tests;

use App\Tests\AcceptanceTester;
use App\Tests\Page\Acceptance\SignUp;

class SignUpCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function shouldSignUp(AcceptanceTester $I, SignUp $signUp)
    {
        $email = uniqid() . '@a.a';
        $signUp->signUp($email, 'aaaaaa');
        $I->see("Hello $email");
    }

    public function shouldNotSignUpIfEmailExists(AcceptanceTester $I, SignUp $signUp)
    {
        $email = uniqid() . '@a.a';
        $signUp->signUp($email, 'aaaaaa');
        $signUp->signUp($email, 'aaaaaa');
        $I->see('Email already exists');
    }
}
