<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\Auth\GetToken;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Auth\Domain\User\Repository\GetUserCredentialsByEmailInterface;
use App\Auth\Infrastructure\User\Auth\AuthenticationProvider;

final class GetTokenHandler implements QueryHandlerInterface
{
    private GetUserCredentialsByEmailInterface $userCredentialsByEmail;

    private AuthenticationProvider $authenticationProvider;

    public function __construct(
        GetUserCredentialsByEmailInterface $userCredentialsByEmail,
        AuthenticationProvider $authenticationProvider
    ) {
        $this->authenticationProvider = $authenticationProvider;
        $this->userCredentialsByEmail = $userCredentialsByEmail;
    }

    public function __invoke(GetTokenQuery $query): string
    {
        [$id, $email, $hashedPassword] = $this->userCredentialsByEmail->getCredentialsByEmail(
            $query->email
        );

        return $this->authenticationProvider->generateToken($id, $email, $hashedPassword);
    }
}
