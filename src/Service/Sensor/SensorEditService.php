<?php

namespace App\Service\Sensor;

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

class SensorEditService
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private ConstraintViolationListInterface $errors;
    private ?Sensor $sensor;
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

    public function __invoke(Sensor $sensor, SensorDto $sensorDto): ?Sensor
    {
        $this->sensor = $sensor;

        $this->errors = $this->validator->validate($sensorDto);
        if (count($this->errors) > 0) {
            throw new SensorCreateException($this->errors);
        }

        $zone = $this->zoneRepository->find($sensorDto->getZoneUuid());
        if ($zone === null) {
            $this->errors = $this->getZoneNotFoundConstraint($sensorDto->getZoneUuid());
            throw new SensorCreateException($this->errors);
        }

        $this->sensor->update(
            $sensorDto->getName(),
            $sensorDto->getMacAddress(),
            $this->security->getUser(),
            $zone,
            SensorType::tryFrom($sensorDto->getSensorType()),
            $sensorDto->getPosition(),
            true
        );

        $this->errors = $this->validator->validate($this->sensor);
        if (count($this->errors) > 0) {
            throw new SensorCreateException($this->errors);
        }

        $this->entityManager->persist($this->sensor);
        $this->entityManager->flush();

        return $this->sensor;
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