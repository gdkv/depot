<?php

namespace App\Entity\Sensor;

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
}