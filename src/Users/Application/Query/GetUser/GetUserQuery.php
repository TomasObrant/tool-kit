<?php

namespace App\Users\Application\Query\GetUser;

use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetUserQuery implements QueryInterface
{
    #[Assert\NotBlank(message: 'ID не должен быть пустым')]
    public int $id;

    public function __construct(
        int $id,
    ) {
        $this->id = $id;
    }
}
