<?php

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger,
        private UserFactory $userFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateUserCommand $createUserCommand): array
    {
        try {
            $existingUserByLogin = $this->userRepository->findOneBy(['login' => $createUserCommand->login]);
            if ($existingUserByLogin) {
                throw new \DomainException('Пользователь с таким логином уже существует');
            }

            $existingUserByEmail = $this->userRepository->findOneBy(['email' => $createUserCommand->email]);
            if ($existingUserByEmail) {
                throw new \DomainException('Пользователь с таким email уже существует');
            }

            $user = $this->userFactory->create(
                $createUserCommand->login,
                $createUserCommand->email,
                $createUserCommand->password,
            );

            $this->userRepository->add($user);

            return $user->getArray();
        } catch (\Exception $exception) {
            $this->logger->error('Не удалось сохранить пользователя', [
                'class' => __CLASS__,
                'exceptionMessage' => $exception->getMessage(),
                'exceptionType' => get_class($exception),
            ]);
            throw $exception;
        }
    }
}
