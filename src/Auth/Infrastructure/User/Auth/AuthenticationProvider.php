<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\User\Auth;

use App\Auth\Domain\User\UserId;
use App\Auth\Domain\User\ValueObject\Auth\HashedPassword;
use App\Auth\Domain\User\ValueObject\Email;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Auth\Infrastructure\User\Auth\Auth;

final class AuthenticationProvider
{
    private JWTTokenManagerInterface $JWTManager;

    public function __construct(JWTTokenManagerInterface $JWTManager)
    {
        $this->JWTManager = $JWTManager;
    }

    public function generateToken(UserId $id, Email $email, HashedPassword $hashedPassword): string
    {
        $auth = Auth::create($id, $email, $hashedPassword);

        return $this->JWTManager->create($auth);
    }
}
