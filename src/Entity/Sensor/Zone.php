<?php

namespace App\Entity\Sensor;

use App\Entity\Security\User;
use App\Entity\Traits\EntityDefaultTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityNameTrait;
use App\Repository\Sensor\ZoneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    use EntityIdTrait;
    use EntityDefaultTrait;
    use EntityNameTrait;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user;

    public function __construct(
        string $name,
        ?string $slug,
        ?int $position,
        ?bool $active,
        ?User $user
    ){
        $this->name = $name;
        $this->slug = $slug ?? '';
        $this->position = $position ?? 100;
        $this->active = $active ?? true;
        $this->user = $user ?? null;
    }
}