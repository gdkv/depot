<?php

namespace App\Model\Dto;

use App\Model\Enum\MeasurementType;
use App\Model\Enum\PeriodType;
use App\Validator\ConstraintsMacAddress;
use Symfony\Component\Validator\Constraints as Assert;

readonly class MeasurementDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[ConstraintsMacAddress]
        private ?string $sensorMacAddress,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Choice(callback: [MeasurementType::class, 'toArray'])]
        private ?string $type,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Choice(callback: [PeriodType::class, 'toArray'])]
        private ?string $period,
    ){}

    public function getSensorMacAddress(): ?string
    {
        return $this->sensorMacAddress;
    }

    public function getMeasurementType(): ?string
    {
        return $this->type;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }
}