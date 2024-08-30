<?php

namespace App\Users\Infrastucture\Service;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as BaseUserPasswordHasherInterface;

final readonly class UserPasswordHasher implements UserPasswordHasherInterface
{
    public function __construct(
        private BaseUserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function hash(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }
}
