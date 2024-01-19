<?php

namespace App\Entity\Sensor;

use App\Entity\Traits\EntityCreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Model\Enum\MeasurementType;
use App\Repository\Sensor\LimitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: LimitRepository::class)]
class Limit
{
    use EntityIdTrait;
    use EntityCreatedAtTrait;

    #[ORM\Column(type: Types::STRING, enumType: MeasurementType::class)]
    #[OA\Property(
        description: 'Тип измерения',
        enum: MeasurementType::class,
        example: MeasurementType::Temperature
    )]
    private MeasurementType $type;

    #[ORM\Column(type: Types::FLOAT)]
    #[OA\Property(description: 'Минимальная величина')]
    public float $min;

    #[ORM\Column(type: Types::FLOAT)]
    #[OA\Property(description: 'Максимальная величина')]
    public float $max;

    #[Ignore]
    #[ORM\ManyToOne(targetEntity: Sensor::class, inversedBy: 'limit')]
    private Sensor $sensor;


    public function __construct(

    ){

    }
}