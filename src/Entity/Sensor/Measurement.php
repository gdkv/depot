<?php

namespace App\Entity\Sensor;

use App\Entity\Traits\EntityCreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\Sensor\MeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement
{
    use EntityIdTrait;
    use EntityCreatedAtTrait;

    public function __construct(
        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Влажность')]
        public readonly float $humidity,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Давление')]
        public readonly float $pressure,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Уровень CO2')]
        public readonly float $co2,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Температура')]
        public readonly float $temperature,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Освещеность')]
        public readonly float $lux,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Шум')]
        public readonly float $decibel,

        #[Ignore]
        #[ORM\ManyToOne(targetEntity: Sensor::class, inversedBy: 'measurement')]
        private readonly Sensor $sensor
    ){}

    public function getHumidity(): float
    {
        return $this->humidity;
    }

    public function getPressure(): float
    {
        return $this->pressure;
    }

    public function getCo2(): float
    {
        return $this->co2;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getLux(): float
    {
        return $this->lux;
    }

    public function getDecibel(): float
    {
        return $this->decibel;
    }
}