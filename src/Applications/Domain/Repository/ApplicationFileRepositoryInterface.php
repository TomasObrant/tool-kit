<?php

namespace App\Applications\Domain\Repository;

use App\Applications\Domain\Entity\ApplicationFile;

interface ApplicationFileRepositoryInterface
{
    public function add(ApplicationFile $applicationFile): void;
}
