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
        ?int $position,
        ?bool $active,
        ?User $user
    ){
        $this->update($name, $position, $active, $user);
    }

    public function update(
        string $name,
        ?int $position,
        ?bool $active,
        ?User $user
    ): self
    {
        $this->name = $name;
        $this->position = $position ?? 100;
        $this->active = $active ?? true;
        $this->user = $user ?? null;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}