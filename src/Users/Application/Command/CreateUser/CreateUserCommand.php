<?php

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateUserCommand implements CommandInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, minMessage: 'Логин должен содержать не менее {{ limit }} символов')]
    public string $login;

    #[Assert\NotBlank]
    #[Assert\Email(message: 'Некорректный email адрес')]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, minMessage: 'Пароль должен содержать не менее {{ limit }} символов')]
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

    public function __construct(
        string $login,
        string $email,
        string $password,
    ) {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
    }
}
