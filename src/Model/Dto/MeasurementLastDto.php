<?php

namespace App\Model\Dto;

use App\Entity\Sensor\Sensor;
use Symfony\Component\Validator\Constraints as Assert;

readonly class MeasurementLastDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type(Sensor::class)]
        private ?Sensor $sensor
    ){}

    public function getSensor(): ?Sensor
    {
        return $this->sensor;
    }


}