<?php namespace App\Tests\Domain\User;

use App\Auth\Domain\User\User;
use App\Auth\Domain\User\UserId;
use App\Auth\Domain\User\ValueObject\Auth\Credentials;
use App\Auth\Domain\User\ValueObject\Auth\HashedPassword;
use App\Auth\Domain\User\ValueObject\Email;
use App\Auth\Domain\User\ValueObject\UniqueEmail;
use Ramsey\Uuid\Uuid;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testShouldCreateUser()
    {
        $user = User::create(
            UserId::fromString($uuid = Uuid::uuid4()->__toString()),
            $credentials = new Credentials(
                UniqueEmail::fromEmail(Email::fromString("a@a.a")),
                HashedPassword::encode("aaaaaa")
            )
        );

        $this->assertSame($uuid, $user->id()->__toString());
        $this->assertSame($credentials, $user->credentials());
    }
}
