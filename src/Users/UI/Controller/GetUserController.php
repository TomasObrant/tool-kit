<?php

declare(strict_types=1);

namespace App\Users\UI\Controller;

use App\Auth\Domain\Security\UserFetcherInterface;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetUserController
{
    public function __construct(
        private readonly UserFetcherInterface $userFetcher,
    ) {
    }

    #[Route('/api/user', name: 'user_current', methods: ['GET'])]
    #[OA\Get(
        path: '/api/users/user',
        summary: 'Получить информацию о текущем пользователе',
        tags: ['User'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Успешная операция',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'login', type: 'string'),
                        new OA\Property(property: 'email', type: 'string'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Не авторизован'
            ),
            new OA\Response(
                response: 404,
                description: 'Пользователь не найден'
            ),
        ]
    )]
    public function __invoke(): JsonResponse
    {
        $user = $this->userFetcher->getAuthUser();

        return new JsonResponse([
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'email' => $user->getEmail(),
        ]);
    }
}
