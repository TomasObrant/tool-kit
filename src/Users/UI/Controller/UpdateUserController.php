<?php

declare(strict_types=1);

namespace App\Users\UI\Controller;

use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\UpdateUser\UpdateUserCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateUserController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly ValidatorInterface $validator,
    ) {
    }

    #[Route('/api/user/{id}', name: 'user_update', methods: ['PUT'])]
    public function __invoke(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $command = new UpdateUserCommand(
            $id,
            $data['login'],
            $data['email'],
            $data['password'] ?? null,
            $data['role'],
        );

        $errors = $this->validator->validate($command);
        if (count($errors) > 0) {
            return new JsonResponse(
                ['errors' => (string) $errors],
                Response::HTTP_BAD_REQUEST
            );
        }

        $userData = $this->commandBus->execute($command);

        return new JsonResponse($userData);
    }
}
