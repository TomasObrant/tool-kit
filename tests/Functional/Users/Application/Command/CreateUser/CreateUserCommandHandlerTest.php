<?php

namespace App\Tests\Functional\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\CreateUser\CreateUserCommand;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateUserCommandHandlerTest extends WebTestCase
{
    private \Faker\Generator $faker;
    private ?CommandBusInterface $commandBus;
    private ?UserRepositoryInterface $userRepository;
    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->userRepository = static::getContainer()->get(UserRepositoryInterface::class);
    }

    public function test_user_created_successfully(): void
    {
        // arrange
        $command = new CreateUserCommand($this->faker->userName(), $this->faker->email(), $this->faker->password());

        // act
        $userLogin = $this->commandBus->execute($command);

        // assert
        $user = $this->userRepository->findOneBy(['login' => $userLogin]);
        $this->assertInstanceOf(User::class, $user);
    }
}