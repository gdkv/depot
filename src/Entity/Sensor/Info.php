<?php

namespace App\Entity\Sensor;

use App\Entity\Traits\EntityCreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\Sensor\InfoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: InfoRepository::class)]
class Info
{
    use EntityIdTrait;
    use EntityCreatedAtTrait;

    public function __construct(
        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Влажность')]
        private readonly float $humidity,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Давление')]
        private readonly float $pressure,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Уровень CO2')]
        private readonly float $co2,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Температура')]
        private readonly float $temperature,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Освещеность')]
        private readonly float $lux,

        #[ORM\Column(type: Types::FLOAT)]
        #[OA\Property(description: 'Шум')]
        private readonly float $decibel,
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