<?php

namespace App\Auth\Infrastructure\Security;

use App\Auth\Domain\Security\AuthUserInterface;
use App\Auth\Domain\Security\UserFetcherInterface;
use Symfony\Bundle\SecurityBundle\Security;

class UserFetcher implements UserFetcherInterface
{
    public function __construct(
        private readonly Security $security
    ) {
    }

    public function getAuthUser(): AuthUserInterface
    {
        $user = $this->security->getUser();

        if (!$user instanceof AuthUserInterface) {
            throw new \RuntimeException('The authenticated user does not implement AuthUserInterface.');
        }

        return $user;
    }
}
