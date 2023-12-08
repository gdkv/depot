<?php

namespace App\Model\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ZoneDto
{

    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        private ?string $name,

        #[Assert\NotBlank]
        #[Assert\Type('int')]
        #[Assert\Positive()]
        private ?int $position,
    ){}

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }
}