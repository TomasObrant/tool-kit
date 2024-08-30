<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractFile
{
    #[ORM\Column(length: 255)]
    protected string $name = '';

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $mime = null;

    #[ORM\Column(nullable: true)]
    protected ?int $size = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return $this
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }

    /**
     * @return $this
     */
    public function setMime(?string $mime): self
    {
        $this->mime = $mime;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * @return $this
     */
    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }
}
