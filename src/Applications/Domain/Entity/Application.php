<?php

declare(strict_types=1);

namespace App\Applications\Domain\Entity;

use App\Applications\Infrastructure\Repository\ApplicationRepository;
use App\Shared\Domain\Entity\AbstractEntity;
use App\Users\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

// Заявка
#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[ORM\Table(name: '`application`')]
#[ORM\HasLifecycleCallbacks]
class Application extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $topic = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?User $creator = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?ApplicationStatus $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\OneToOne(mappedBy: 'application', cascade: ['persist', 'remove'])]
    private ?ApplicationFile $applicationFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(?string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?UserInterface $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatus(): ?ApplicationStatus
    {
        return $this->status;
    }

    public function setStatus(?ApplicationStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getApplicationFile(): ?ApplicationFile
    {
        return $this->applicationFile;
    }

    public function setApplicationFile(?ApplicationFile $applicationFile): self
    {
        if (null === $applicationFile && null !== $this->applicationFile) {
            $this->applicationFile->setApplication(null);
        }

        if (null !== $applicationFile && $applicationFile->getApplication() !== $this) {
            $applicationFile->setApplication($this);
        }

        $this->applicationFile = $applicationFile;

        return $this;
    }
}
