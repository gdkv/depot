<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityDefaultTrait {

    #[ORM\Column(type: Types::INTEGER)]
    #[OA\Property(description: 'Сортировка')]
    #[Assert\PositiveOrZero]
    private int $position=100;

    #[ORM\Column(type: Types::BOOLEAN)]
    #[OA\Property(description: 'Активен')]
    private bool $active=true;

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}