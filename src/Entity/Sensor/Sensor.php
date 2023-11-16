<?php

namespace App\Entity\Sensor;

use App\Entity\EntityDefaultTrait;
use App\Entity\EntityIdTrait;
use App\Entity\EntityNameTrait;
use App\Repository\Sensor\SensorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
class Sensor
{
    use EntityIdTrait;
    use EntityDefaultTrait;
    use EntityNameTrait;
}
