<?php

declare(strict_types=1);

namespace App\Users\UI\Controller;

use App\Auth\Domain\Security\UserFetcherInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\CreateUser\CreateUserCommand;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/api/user', name: 'user_create', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $command = new CreateUserCommand(
            $data['login'],
            $data['email'],
            $data['password'],
        );

        $userLogin = $this->commandBus->execute($command);

        return new JsonResponse([
            'login' => $userLogin
        ]);
    }
}
