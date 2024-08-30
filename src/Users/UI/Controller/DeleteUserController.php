<?php

declare(strict_types=1);

namespace App\Users\UI\Controller;

use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\DeleteUser\DeleteUserCommand;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final readonly class DeleteUserController
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/api/user/{id}', name: 'user_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/user/{id}',
        description: 'Deletes a user by their ID',
        summary: 'Delete a user',
        security: ['Bearer' => []],
        tags: ['User'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the user to be deleted',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User successfully deleted',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'ok'
                        ),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 401,
                description: 'JWT Token not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'code',
                            type: 'integer',
                            example: 401
                        ),
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'JWT Token not found'
                        ),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Пользователь по данному id не найден.'
            ),
        ]
    )]
    public function __invoke(int $id): JsonResponse
    {
        $command = new DeleteUserCommand($id);

        $data = $this->commandBus->execute($command);

        return new JsonResponse($data);
    }
}
