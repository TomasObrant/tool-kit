<?php

declare(strict_types=1);

namespace App\Applications\Domain\Entity;

use App\Applications\Infrastructure\Repository\ApplicationStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Статус заявки
#[ORM\Entity(repositoryClass: ApplicationStatusRepository::class)]
#[ORM\Table(name: '`application_status`')]
class ApplicationStatus
{
    const NEW = 1;         // Новый
    const IN_WORK = 2;     // В работе
    const DECIDED = 3;     // Решено

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'status')]
    private Collection $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setStatus($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            if ($application->getStatus() === $this) {
                $application->setStatus(null);
            }
        }

        return $this;
    }
}
