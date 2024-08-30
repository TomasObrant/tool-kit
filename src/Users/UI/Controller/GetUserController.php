<?php

declare(strict_types=1);

namespace App\Users\UI\Controller;

use App\Shared\Application\Query\QueryBusInterface;
use App\Users\Application\Query\GetUser\GetUserQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetUserController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    #[Route('/api/user/{id}', name: 'user_get', methods: ['GET'])]
    public function __invoke(int $id): JsonResponse
    {
        $query = new GetUserQuery($id);

        $userData = $this->queryBus->ask($query);

        return new JsonResponse($userData);
    }
}
