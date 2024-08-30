<?php

namespace App\Users\Application\Command\DeleteUser;

use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class DeleteUserCommand implements CommandInterface
{
    #[Assert\NotBlank(message: 'ID не должен быть пустым')]
    public int $id;
    public function __construct(
        int $id,
    ) {
        $this->id = $id;
    }
}
