<?php

namespace App\Users\Application\Query\GetUser;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

final readonly class GetUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(GetUserQuery $getUserQuery): array
    {
        $user = $this->userRepository->find($getUserQuery->id);

        if (!$user) {
            throw new UserNotFoundException('Пользователь по данному id не найден.', 404);
        }

        return $user->getArray();
    }
}
