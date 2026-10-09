<?php

namespace App\Model\Dto;

use App\Entity\Sensor\Sensor;
use Symfony\Component\Validator\Constraints as Assert;

readonly class MeasurementAddDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type(Sensor::class)]
        private ?Sensor $sensor,
        #[Assert\Type('float')]
        #[Assert\Range(min: -273, max: 180)]
        private null|string|float  $temperature,
        #[Assert\Type('float')]
        #[Assert\PositiveOrZero]
        private null|string|float  $humidity,
        #[Assert\Positive]
        #[Assert\Type('float')]
        #[Assert\Range(min: 600, max: 800)]
        private null|string|float  $pressure,
        #[Assert\PositiveOrZero]
        #[Assert\Type('float')]
        #[Assert\Range(min: 0, max: 200000)]
        private null|string|float  $lux,
        #[Assert\PositiveOrZero]
        #[Assert\Type('float')]
        #[Assert\Range(min: 0, max: 200)]
        private null|string|float  $decibel,
        #[Assert\PositiveOrZero]
        #[Assert\Type('float')]
        #[Assert\Range(min: 0, max: 1500)]
        private null|string|float $co2,
    ){}

    public function getTemperature(): null|string|float
    {
        return $this->temperature;
    }

    public function getSensor(): null|Sensor
    {
        return $this->sensor;
    }

    public function getHumidity(): null|string|float
    {
        return $this->humidity;
    }

    public function getPressure(): null|string|float
    {
        return $this->pressure;
    }

    public function getLux(): null|string|float
    {
        return $this->lux;
    }

    public function getDecibel(): null|string|float
    {
        return $this->decibel;
    }

    public function getCo2(): null|string|float
    {
        return $this->co2;
    }
}
