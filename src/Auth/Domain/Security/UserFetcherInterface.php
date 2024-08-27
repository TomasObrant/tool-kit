<?php

namespace App\Auth\Domain\Security;

interface UserFetcherInterface
{
    public function getAuthUser(): AuthUserInterface;
}
