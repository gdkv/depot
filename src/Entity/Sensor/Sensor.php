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
use Symfony\Component\Serializer\Annotation\Ignore;
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
    private ?Zone $zone;

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
    #[Ignore]
    private PersistentCollection $measurement;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user;

    #[ORM\Column(type: Types::TEXT)]
    #[OA\Property(description: 'Комментарий')]
    private ?string $comment;

    // #[ORM\Column(type: Types::STRING, enumType: AccessLevelType::class)]
    // #[Assert\NotBlank]
    // #[OA\Property(
    //     description: 'Уровень видимости сенсора',
    //     enum: AccessLevelType::class,
    //     example: AccessLevelType::Private
    // )]
    //private AccessLevelType $accessLevel;

    // #[ORM\Column(type: Types::BOOLEAN)]
    // #[OA\Property(title: 'Получать отчет для данного сенсора', type: 'bool')]
    // private bool $isReported;

    // #[ORM\Column(type: Types::BOOLEAN)]
    // #[OA\Property(title: 'Получать оповещения если значения выходят за заданые лимиты', type: 'bool')]
    // private bool $isAlerted;

    public function __construct(
        string $name,
        string $macAddress,
        ?string $comment,
        ?User $user,
        ?Zone $zone,
        ?SensorType $type,
        ?int $position,
        ?bool $active,
    )
    {
        $this->update($name, $macAddress, $comment, $user, $zone, $type, $position, $active);
    }

    public function update(
        string $name,
        string $macAddress,
        string $comment,
        ?User $user,
        ?Zone $zone,
        ?SensorType $type,
        ?int $position,
        ?bool $active,
    ): self
    {
        $this->name = $name;
        $this->macAddress = $macAddress;
        $this->comment = $comment;
        $this->user = $user ?? null;
        $this->zone = $zone ?? null;
        $this->type = $type ?? SensorType::Default;
        $this->position = $position ?? 100;
        $this->active = $active ?? true;

        return $this;
    }

    public function __toArray(): array
    {
        return [
            'name' => $this->getName(),
            'macAddress' => $this->getMacAddress(),
            'comment' => $this->getComment(),
            'zone' => $this->getZone(),
            'type' => $this->getType(),
            'position' => $this->getPosition(),
            'active' => $this->getActive(),
            'measurement' => $this->getMeasurement(),
            'offsetMeasurement' => $this->getOffsetMeasurement(),
            'lastMeasurement' => $this->getLastMeasurement(),
            'status' => $this->getStatus(),
            'slug' => $this->getSlug(),
        ];
    }

    public function getMacAddress(): string
    {
        return $this->macAddress;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getZone(): ?Zone
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

    #[OA\Property(
        description: 'Массив последних двадцати измерений (измерения за последний час)',
        type: 'array',
        items: new OA\Items(
            properties: [
                new OA\Property(property: 'temperature', type: 'array', items: new OA\Items(type: 'number')),
                new OA\Property(property: 'humidity', type: 'array', items: new OA\Items(type: 'number')),
                new OA\Property(property: 'pressure', type: 'array', items: new OA\Items(type: 'number')),
                new OA\Property(property: 'decibel', type: 'array', items: new OA\Items(type: 'number')),
                new OA\Property(property: 'lux', type: 'array', items: new OA\Items(type: 'number')),
            ]
        )
    )]
    public function getOffsetMeasurement(): array
    {
        $offsetData = $this->measurement->slice(-20, 20);
        return [
            'temperature' => array_column($offsetData, 'temperature'),
            'humidity' => array_column($offsetData, 'humidity'),
            'pressure' => array_column($offsetData, 'pressure'),
            'decibel' => array_column($offsetData, 'decibel'),
            'lux' => array_column($offsetData, 'lux'),
        ];
    }

    public function getLastMeasurement(): bool|Measurement
    {
        return $this->measurement->last();
    }

    #[OA\Property(
        description: 'Статус сенсора (онлайн/офлайн)',
        type: 'array',
        items: new OA\Items(
            properties: [
                new OA\Property(property: 'value', type: 'bool'),
                new OA\Property(property: 'text', type: 'string'),
            ]
        )
    )]
    public function getStatus(): array
    {
        if (
            $this->getLastMeasurement() &&
            $this->getLastMeasurement()->getCreatedAt() >
            (new \DateTime())->sub(new \DateInterval("PT5M"))
        ) {
            return [
              'value' => true,
              'text' => SensorStatus::Online,
            ];
        }

        return [
            'value' => false,
            'text' => SensorStatus::Offline,
        ];
    }

    public function getDetailUrl(): string
    {
        return "";
    }
}
