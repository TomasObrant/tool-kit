<?php

declare(strict_types=1);

namespace App\Applications\Domain\Factory;

use App\Applications\Domain\Entity\Application;
use App\Applications\Domain\Entity\ApplicationStatus;
use App\Applications\Infrastructure\Repository\ApplicationStatusRepository;
use Symfony\Bundle\SecurityBundle\Security;

class ApplicationFactory
{
    public function __construct(
        private Security $security,
        private ApplicationStatusRepository $applicationStatusRepository
    ) {
    }

    public function create(
        string $topic,
        string $message,
        string $comment,
    ): Application {
        $application = new Application();
        $application->setTopic($topic);
        $application->setMessage($message);
        $application->setComment($comment);

        $user = $this->security->getUser();
        if ($user) {
            $application->setCreator($user);
        }

        $defaultStatus = $this->applicationStatusRepository->find(ApplicationStatus::NEW);
        $application->setStatus($defaultStatus);

        return $application;
    }
}
