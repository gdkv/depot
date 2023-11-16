<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityNameTrait {

    #[ORM\Column(type: 'string', length: 255)]
    #[OA\Property(description: 'Имя')]
    #[Assert\NotBlank]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[OA\Property(description: 'Ключевое слово')]
    #[Assert\NotBlank]
    private ?string $slug;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}