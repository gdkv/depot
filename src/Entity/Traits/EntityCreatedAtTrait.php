<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

trait EntityCreatedAtTrait {

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[OA\Property(description: 'Дата создания')]
    private DateTimeInterface $createdAt;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    // for InfoFixtures only
    public function setCreatedAtToPast($minusMinutes): self
    {
        $this->createdAt = $this->createdAt
            ->sub(new \DateInterval("PT{$minusMinutes}M"));
        return $this;
    }
}