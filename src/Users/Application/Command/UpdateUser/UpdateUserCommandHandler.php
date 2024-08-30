<?php

namespace App\Users\Application\Command\UpdateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

final readonly class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdateUserCommand $updateUserCommand): array
    {
        try {
            $user = $this->userRepository->find($updateUserCommand->id);
            if (!$user) {
                throw new UserNotFoundException('Пользователь по данному id не найден.', 404);
            }

            $user->setLogin($updateUserCommand->login ?? $user->getLogin());
            $user->setEmail($updateUserCommand->email ?? $user->getEmail());
            $user->setRoles(null !== $updateUserCommand->role ? [$updateUserCommand->role] : $user->getRoles());

            $this->entityManager->flush();

            return $user->getArray();
        } catch (\Exception $exception) {
            $this->logger->error('Не удалось обновить пользователя', [
                'class' => __CLASS__,
                'exceptionMessage' => $exception->getMessage(),
                'exceptionType' => get_class($exception),
            ]);
            throw $exception;
        }
    }
}
