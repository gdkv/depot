<?php

namespace App\Service\Zone;

use App\Entity\Sensor\Sensor;
use App\Entity\Sensor\Zone;
use App\Exception\SensorCreateException;
use App\Exception\ZoneCreateException;
use App\Model\Dto\SensorDto;
use App\Model\Enum\SensorType;
use App\Repository\Sensor\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ZoneDeleteService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) { }

    public function __invoke(Zone $zone): bool
    {
        $zone->deactivate();

        $this->entityManager->flush();

        return true;
    }
}