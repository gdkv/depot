<?php

namespace App\Entity\Sensor;

use App\Entity\Traits\EntityDefaultTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityNameTrait;
use App\Model\Enum\SensorType;
use App\Repository\Sensor\SensorRepository;
use App\Validator\ConstraintsMacAddress;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SensorRepository::class)]
#[UniqueEntity(fields: 'macAddress')]
#[OA\Schema(title: 'Сенсор')]
class Sensor
{
    use EntityIdTrait;
    use EntityDefaultTrait;
    use EntityNameTrait;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[ConstraintsMacAddress]
    #[OA\Property(title: 'MAC адрес', description: 'MAC адрес устройства', type: 'string')]
    private string $macAddress;

    #[ORM\OneToOne(targetEntity: Zone::class)]
    private Zone $zone;

    #[ORM\Column(type: Types::STRING, enumType: SensorType::class)]
    #[Assert\NotBlank]
    #[OA\Property(
        description: 'Тип сенсора',
        enum: SensorType::class,
        example: SensorType::Default
    )]
    private SensorType $type;

    #[ORM\OneToMany(mappedBy: 'sensor', targetEntity: Info::class)]
    #[ORM\OrderBy(['createdAt' => 'ASC'])]
    private ?Collection $info;

    public function __construct(
        string $name,
        string $macAddress,
        ?string $slug,
        ?Zone $zone,
        ?SensorType $type,
        ?Collection $info,
        ?int $position,
        ?bool $active,
    )
    {
        $this->name = $name;
        $this->macAddress = $macAddress;
        $this->zone = $zone ?? null;
        $this->slug = $slug ?? '';
        $this->type = $type ?? SensorType::Default;
        $this->info = $info ?? [];
        $this->position = $position ?? 100;
        $this->active = $active ?? true;
    }

    public function getMacAddress(): string
    {
        return $this->macAddress;
    }

    public function getZone(): Zone
    {
        return $this->zone;
    }

    public function getType(): SensorType
    {
        return $this->type;
    }

    public function getInfo(): ?Collection
    {
        return $this->info;
    }
}
