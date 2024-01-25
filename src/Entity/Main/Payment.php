<?php

namespace App\Entity\Main;

use App\Entity\Security\User;
use App\Entity\Traits\EntityCreatedAtTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Model\Enum\AccountType;
use App\Repository\Main\PaymentRepository;
use DateTimeInterface;
use OpenApi\Attributes as OA;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[OA\Schema(title: 'Платежи')]
class Payment
{
    use EntityIdTrait;
    use EntityCreatedAtTrait;

    #[ORM\Column(type: Types::STRING, enumType: AccountType::class)]
    #[Assert\NotBlank]
    #[OA\Property(
        description: 'Выбранный тип аккаунта',
        enum: AccountType::class,
        example: AccountType::Start
    )]
    private AccountType $accountType;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user;

    #[ORM\Column(type: Types::BOOLEAN)]
    #[OA\Property(title: 'Оплачен', type: 'bool')]
    private bool $isPaid;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[OA\Property(description: 'Дата окончания')]
    private DateTimeInterface $dateExpire;
}