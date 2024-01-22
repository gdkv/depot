<?php

namespace App\Model\Dto;

use App\Model\Enum\MeasurementType;
use Symfony\Component\Validator\Constraints as Assert;

readonly class LimitDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('float')]
        private ?float $min,

        #[Assert\NotBlank]
        #[Assert\Type('float')]
        private ?float $max,

        #[Assert\Uuid]
        private ?string $sensorMacAddress,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Choice(callback: [MeasurementType::class, 'toArray'])]
        private ?string $measurementType,
    ){}

    public function getMin(): ?float
    {
        return $this->min;
    }

    public function getMax(): ?float
    {
        return $this->max;
    }

    public function getSensorMacAddress(): ?string
    {
        return $this->sensorMacAddress;
    }

    public function getMeasurementType(): ?string
    {
        return $this->measurementType;
    }


}