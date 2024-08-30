<?php

declare(strict_types=1);

namespace App\Users\UI\Controller;

use App\Shared\Application\Query\QueryBusInterface;
use App\Users\Application\Query\GetAllUsers\GetAllUsersQuery;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final readonly class GetAllUsersController
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    #[Route('/api/user', name: 'user_get_all', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $query = new GetAllUsersQuery();

        $usersData = $this->queryBus->ask($query);

        return new JsonResponse($usersData);
    }
}
