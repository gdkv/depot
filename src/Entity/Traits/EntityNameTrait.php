<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityNameTrait {

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[OA\Property(description: 'Имя')]
    #[Assert\NotBlank]
    private ?string $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[OA\Property(description: 'Ключевое слово')]
    private ?string $slug;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->slug = (new AsciiSlugger())
            ->slug($this->name)
            ->lower();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->slug = (new AsciiSlugger())
            ->slug($this->name)
            ->lower();
    }
}