<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\Auth\GetAuthUserByEmail;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Auth\Domain\User\Repository\GetUserCredentialsByEmailInterface;
use App\Auth\Infrastructure\User\Auth\Auth;

final class GetAuthUserByEmailHandler implements QueryHandlerInterface
{
    private GetUserCredentialsByEmailInterface $userCredentialsByEmail;

    public function __construct(
        GetUserCredentialsByEmailInterface $userCredentialsByEmail
    ) {
        $this->userCredentialsByEmail = $userCredentialsByEmail;
    }

    public function __invoke(GetAuthUserByEmailQuery $query): Auth
    {
        [$id, $email, $hashedPassword] = $this->userCredentialsByEmail->getCredentialsByEmail(
            $query->email
        );

        return Auth::create($id, $email, $hashedPassword);
    }
}
