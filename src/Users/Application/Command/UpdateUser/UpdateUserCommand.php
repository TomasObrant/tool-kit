<?php

namespace App\Users\Application\Command\UpdateUser;

use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateUserCommand implements CommandInterface
{
    #[Assert\NotBlank(message: 'ID не должен быть пустым')]
    public int $id;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5, minMessage: 'Логин должен содержать не менее {{ limit }} символов')]
    public string $login;

    #[Assert\NotBlank]
    #[Assert\Email(message: 'Некорректный email адрес')]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, minMessage: 'Пароль должен содержать не менее {{ limit }} символов')] // Минимальная длина пароля
    #[Assert\Regex(
        pattern: '/[A-Z]/',
        message: 'Пароль должен содержать хотя бы одну заглавную букву'
    )]
    #[Assert\Regex(
        pattern: '/[a-z]/',
        message: 'Пароль должен содержать хотя бы одну строчную букву'
    )]
    #[Assert\Regex(
        pattern: '/\d/',
        message: 'Пароль должен содержать хотя бы одну цифру'
    )]
    #[Assert\Regex(
        pattern: '/[\W_]/',
        message: 'Пароль должен содержать хотя бы один специальный символ'
    )]
    public string $password;

    #[Assert\NotBlank]
    #[Assert\Choice(
        choices: ['ROLE_ADMIN', 'ROLE_USER'],
        message: 'Роль должна быть пустой или одной из следующих: ROLE_ADMIN, ROLE_USER'
    )]
    public string $role;

    public function __construct(
        int $id,
        string $login,
        string $email,
        string $password,
        string $role
    ) {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
}
