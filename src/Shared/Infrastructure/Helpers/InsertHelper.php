<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Helpers;

class InsertHelper
{
    public static function insertUserStart(): string
    {
        $login = 'dima';
        $email = 'user@user.ru';
        $password = '$2y$13$2kSlEOG8POghyHtQ2SuRXeMOcT3OK2F4R5QmXty3ZuGZFmAK4ptPG'; // ghbdtn
        $roles = json_encode(['ROLE_ADMIN']);
        $createdAt = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        return <<<EOF
            INSERT INTO "user" (id, login, email, roles, password, created_at) 
            VALUES (2, '$login', '$email', '$roles', '$password', '$createdAt');
            EOF;
    }

    public static function insertApplicationStatus(): string
    {
        return <<<EOF
        INSERT INTO "application_status" (id, name) VALUES
        (1, 'Новая'),
        (2, 'В работе'),
        (3, 'Решено');
        EOF;
    }
}
