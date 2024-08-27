<?php

namespace App\Applications\Domain\Repository;

use App\Applications\Domain\Entity\ApplicationStatus;

interface ApplicationStatusRepositoryInterface
{
    public function add(ApplicationStatus $applicationStatus): void;
}
