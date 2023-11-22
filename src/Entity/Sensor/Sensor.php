<?php

namespace App\Entity\Sensor;

use App\Entity\Traits\EntityDefaultTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityNameTrait;
use App\Repository\Sensor\SensorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
class Sensor
{
    use EntityIdTrait;
    use EntityDefaultTrait;
    use EntityNameTrait;
}
