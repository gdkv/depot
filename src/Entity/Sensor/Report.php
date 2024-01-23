<?php

namespace App\Entity\Sensor;

use App\Entity\Security\User;
use App\Entity\Traits\EntityDefaultTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Model\Enum\ReportFormatType;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use OpenApi\Attributes as OA;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

class Report
{
    use EntityIdTrait;
    use EntityDefaultTrait;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user;

    #[ORM\Column(type: Types::STRING, enumType: ReportFormatType::class)]
    #[OA\Property(
        description: 'Формат отчета',
        enum: ReportFormatType::class,
        example: ReportFormatType::Csv
    )]
    private ReportFormatType $type;
}