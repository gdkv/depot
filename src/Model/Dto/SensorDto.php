<?php

namespace App\Model\Dto;

use App\Model\Enum\SensorType;
use App\Validator\ConstraintsMacAddress;
use Symfony\Component\Validator\Constraints as Assert;

readonly class SensorDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        private ?string $name,

        #[Assert\NotBlank]
        #[ConstraintsMacAddress]
        private ?string $macAddress,

        #[Assert\Type('string')]
        private ?string $comment,

        #[Assert\Uuid]
        private ?string $zoneUuid,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Choice(callback: [SensorType::class, 'toArray'])]
        private ?string $sensorType,

        #[Assert\NotBlank]
        #[Assert\Type('int')]
        #[Assert\Positive()]
        private ?int $position,
    ){}

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getMacAddress(): ?string
    {
        return $this->macAddress;
    }

    public function getZoneUuid(): ?string
    {
        return $this->zoneUuid;
    }

    public function getSensorType(): ?string
    {
        return $this->sensorType;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }
}