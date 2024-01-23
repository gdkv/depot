<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityDefaultTrait {

    #[ORM\Column(type: Types::INTEGER)]
    #[OA\Property(description: 'Сортировка')]
    #[Assert\PositiveOrZero]
    private int $position;

    #[ORM\Column(type: Types::BOOLEAN)]
    #[OA\Property(description: 'Активен')]
    private bool $active;

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function activate(): self
    {
        $this->active = true;

        return $this;
    }

    public function deactivate(): self
    {
        $this->active = false;

        return $this;
    }
}