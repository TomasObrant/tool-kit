<?php

namespace App\Users\Application\Command\DeleteUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

final readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(DeleteUserCommand $createUserCommand): array
    {
        try {
            $user = $this->userRepository->find($createUserCommand->id);

            if (!$user) {
                throw new UserNotFoundException("Пользователь по данному id не найден.", 404);
            }

            $this->userRepository->delete($user);

            return ['message' => 'Пользователь успешно удален.'];
        } catch (\Exception $exception) {
            $this->logger->error('Не удалось удалить пользователя', [
                'class' => __CLASS__,
                'exceptionMessage' => $exception->getMessage(),
                'exceptionType' => get_class($exception),
            ]);
            throw $exception;
        }
    }
}
