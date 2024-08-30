<?php

declare(strict_types=1);

namespace App\Users\UI\Controller;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Domain\Validator\RequestValidatorInterface;
use App\Users\Application\Command\CreateUser\CreateUserCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly RequestValidatorInterface $requestValidator,
    ) {
    }

    #[Route('/api/user', name: 'user_create', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $command = new CreateUserCommand(
            $data['login'] ?? null,
            $data['email'] ?? null,
            $data['password'] ?? null,
        );

        $validationErrors = $this->requestValidator->validate($command);
        if (!empty($validationErrors)) {
            return new JsonResponse(
                ['errors' => $validationErrors],
                Response::HTTP_BAD_REQUEST
            );
        }

        $userData = $this->commandBus->execute($command);

        return new JsonResponse($userData);
    }
}
