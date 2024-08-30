<?php

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use App\Tests\Tools\FixtureTools;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    use FixtureTools;
    private \Faker\Generator $faker;
    private ?UserRepositoryInterface $userRepository;
    private ?UserFactory $userFactory;
    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->userRepository = static::getContainer()->get(UserRepositoryInterface::class);
        $this->userFactory = static::getContainer()->get(UserFactory::class);
    }

    public function test_user_added_successfully(): void
    {
        // arrange
        $login = $this->faker->userName();
        $email = $this->faker->email();
        $password = $this->faker->password();
        $user = $this->userFactory->create($login, $email, $password);

        // act
        $this->userRepository->add($user);

        // assert
        $existingUser = $this->userRepository->find($user->getId());
        $this->assertEquals($user->getLogin(), $existingUser->getLogin());
    }
}