<?php

declare(strict_types=1);

namespace App\Applications\Domain\Entity;

use App\Applications\Infrastructure\Repository\ApplicationFileRepository;
use App\Shared\Domain\Entity\AbstractFile;
use Doctrine\ORM\Mapping as ORM;

// Файл заявки
#[ORM\Entity(repositoryClass: ApplicationFileRepository::class)]
#[ORM\Table(name: '`application_file`')]
class ApplicationFile extends AbstractFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'applicationFile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'application_id', referencedColumnName: 'id')]
    private ?Application $application = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): self
    {
        $this->application = $application;

        return $this;
    }
}
