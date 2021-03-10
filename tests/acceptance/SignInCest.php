<?php namespace App\Tests;

use App\Tests\AcceptanceTester;
use App\Tests\Page\Acceptance\SignIn;
use App\Tests\Page\Acceptance\SignUp;

class SignInCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function shouldSignIn(AcceptanceTester $I, SignUp $signUp, SignIn $signIn)
    {
        $email = uniqid() . '@a.a';
        $signUp->signUp($email, 'aaaaaa');
        $signIn->signIn($email, 'aaaaaa');
        $I->see('Hello!');
    }

    public function shouldNotSignInIfWrongPasswordPassed(AcceptanceTester $I, SignUp $signUp, SignIn $signIn)
    {
        $email = uniqid() . '@a.a';
        $signUp->signUp($email, 'aaaaaa');
        $signIn->signIn($email, 'bbbbbb');
        $I->see('Wrong username or password');
    }
}
