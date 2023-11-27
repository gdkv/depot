<?php

namespace App\Entity\Sensor;

use App\Entity\Traits\EntityCreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\Sensor\InfoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: InfoRepository::class)]
class Info
{
    use EntityIdTrait;
    use EntityCreatedAtTrait;

    #[ORM\Column(type: Types::FLOAT)]
    #[OA\Property(description: 'Влажность')]
    private float $humidity;

    #[ORM\Column(type: Types::FLOAT)]
    #[OA\Property(description: 'Давление')]
    private float $pressure;

    #[ORM\Column(type: Types::FLOAT)]
    #[OA\Property(description: 'Уровень CO2')]
    private float $co2;

    #[ORM\Column(type: Types::FLOAT)]
    #[OA\Property(description: 'Температура')]
    private float $temperature;

    #[ORM\Column(type: Types::FLOAT)]
    #[OA\Property(description: 'Освещеность')]
    private float $lux;

    #[ORM\Column(type: Types::FLOAT)]
    #[OA\Property(description: 'Шум')]
    private float $decibel;
}