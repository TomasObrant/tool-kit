<?php

declare(strict_types=1);

namespace App\Command;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

#[AsCommand(
    name: 'test',
    description: 'команда для тестов методов|сервисов|репозиториев',
)]
class TestCommand extends Command
{
    public function __construct(
        public EntityManagerInterface $em,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserFactory $userFactory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $validator = Validation::createValidator();

        $login = $this->askValidLogin($io, $validator);
        $email = $this->askValidEmail($io, $validator);
        $password = $this->askValidPassword($io, $validator);

        // Создаем нового пользователя через фабрику
        $user = $this->userFactory->create($login, $email, $password);

        // Сохраняем пользователя в базе данных
        $this->em->persist($user);
        $this->em->flush();

        $io->success('Пользователь успешно создан!');

        return Command::SUCCESS;
    }

    private function askValidLogin(SymfonyStyle $io, $validator): string
    {
        while (true) {
            $login = $io->ask('Введите логин');
            $errors = $validator->validate($login, [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 3, 'max' => 100]),
            ]);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $io->error($error->getMessage());
                }
                continue;
            }

            if ($this->userRepository->findOneBy(['login' => $login])) {
                $io->error('Этот логин уже используется.');
                continue;
            }

            return $login;
        }
    }

    private function askValidEmail(SymfonyStyle $io, $validator): string
    {
        while (true) {
            $email = $io->ask('Введите email');
            $errors = $validator->validate($email, [
                new Assert\NotBlank(),
                new Assert\Email(),
            ]);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $io->error($error->getMessage());
                }
                continue;
            }

            if ($this->userRepository->findByEmail($email)) {
                $io->error('Этот email уже используется.');
                continue;
            }

            return $email;
        }
    }

    private function askValidPassword(SymfonyStyle $io, $validator): string
    {
        while (true) {
            $password = $io->askHidden('Введите пароль');
            $errors = $validator->validate($password, [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 6]),
            ]);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $io->error($error->getMessage());
                }
                continue;
            }

            return $password;
        }
    }

}
