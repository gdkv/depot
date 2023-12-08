<?php

namespace App\Service\Zone;

use App\Entity\Sensor\Sensor;
use App\Entity\Sensor\Zone;
use App\Exception\SensorCreateException;
use App\Exception\ZoneCreateException;
use App\Model\Dto\SensorDto;
use App\Model\Dto\ZoneDto;
use App\Model\Enum\SensorType;
use App\Repository\Sensor\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ZoneEditService
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private ConstraintViolationListInterface $errors;
    private ?Zone $zone;
    private Security $security;
    private ZoneRepository $zoneRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Security $security,
        ZoneRepository $zoneRepository,
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->security = $security;
        $this->zoneRepository = $zoneRepository;
    }

    public function __invoke(Zone $zone, ZoneDto $zoneDto): ?Zone
    {
        $this->zone = $zone;

        $this->errors = $this->validator->validate($zoneDto);
        if (count($this->errors) > 0) {
            throw new ZoneCreateException($this->errors);
        }

        $this->zone->update(
            $zoneDto->getName(),
            $zoneDto->getPosition(),
            true,
            $this->security->getUser(),
        );

        $this->errors = $this->validator->validate($this->zone);
        if (count($this->errors) > 0) {
            throw new ZoneCreateException($this->errors);
        }

        $this->entityManager->persist($this->zone);
        $this->entityManager->flush();

        return $this->zone;
    }

    private function getZoneNotFoundConstraint(string $zoneUuid): ConstraintViolationListInterface
    {
        return new ConstraintViolationList([
            new ConstraintViolation(
                'zone not found',
                null,
                [],
                $zoneUuid,
                'zoneUuid',
                $zoneUuid,
                null,
                'zone.not.found',
                null,
                null
            ),
        ]);
    }
}