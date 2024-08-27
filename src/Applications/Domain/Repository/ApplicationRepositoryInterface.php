<?php

namespace App\Applications\Domain\Repository;

use App\Applications\Domain\Entity\Application;

interface ApplicationRepositoryInterface
{
    public function add(Application $application): void;
}
