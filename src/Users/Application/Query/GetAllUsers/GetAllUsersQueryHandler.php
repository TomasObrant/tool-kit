<?php

namespace App\Users\Application\Query\GetAllUsers;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

final readonly class GetAllUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(GetAllUsersQuery $getAllUsersQuery): array
    {
        $users = $this->userRepository->findAll();

        if (!$users) {
            throw new UserNotFoundException('Ни один пользователь не найден.');
        }

        return array_map(function ($user) {
            return $user->getArray();
        }, $users);
    }
}
