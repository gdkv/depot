<?php

namespace App\Entity\Sensor;

use App\Entity\Security\User;
use App\Entity\Traits\EntityDefaultTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityNameTrait;
use App\Model\Enum\SensorStatus;
use App\Model\Enum\SensorType;
use App\Repository\Sensor\SensorRepository;
use App\Validator\ConstraintsMacAddress;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
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

    #[ORM\ManyToOne(targetEntity: Zone::class)]
    private Zone $zone;

    #[ORM\Column(type: Types::STRING, enumType: SensorType::class)]
    #[Assert\NotBlank]
    #[OA\Property(
        description: 'Тип сенсора',
        enum: SensorType::class,
        example: SensorType::Default
    )]
    private SensorType $type;

    #[ORM\OneToMany(mappedBy: 'sensor', targetEntity: Measurement::class)]
    #[ORM\OrderBy(['createdAt' => Criteria::ASC])]
    #[OA\Property(
        description: 'Измерения',
        type: 'array',
        items: new OA\Items(ref: Measurement::class)
    )]
    private PersistentCollection $measurement;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user;

    public function __construct(
        string $name,
        string $macAddress,
        ?User $user,
        ?Zone $zone,
        ?SensorType $type,
        ?int $position,
        ?bool $active,
    )
    {
        $this->update($name, $macAddress, $user, $zone, $type, $position, $active);
    }

    public function update(
        string $name,
        string $macAddress,
        ?User $user,
        ?Zone $zone,
        ?SensorType $type,
        ?int $position,
        ?bool $active,
    ): self
    {
        $this->name = $name;
        $this->macAddress = $macAddress;
        $this->user = $user ?? null;
        $this->zone = $zone ?? null;
        $this->type = $type ?? SensorType::Default;
        $this->position = $position ?? 100;
        $this->active = $active ?? true;

        return $this;
    }

    public function getMacAddress(): string
    {
        return $this->macAddress;
    }

    public function getZone(): Zone
    {
        return $this->zone;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getType(): SensorType
    {
        return $this->type;
    }

    public function getMeasurement(): PersistentCollection
    {
        return $this->measurement;
    }

    public function getStatus(): SensorStatus
    {
        /**
         * @todo брать последнюю запись данных и проверять ее дату, если старее 5 минут то сенсор оффлайн
         */

        return SensorStatus::Online;
    }
}
