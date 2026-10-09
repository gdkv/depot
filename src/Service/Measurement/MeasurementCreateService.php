<?php

namespace App\Service\Measurement;

use App\Entity\Sensor\Measurement;
use App\Entity\Sensor\Sensor;
use App\Exception\MeasurementCreateException;
use App\Exception\SensorCreateException;
use App\Model\Dto\MeasurementAddDto;
use App\Model\Dto\SensorDto;
use App\Model\Enum\SensorType;
use App\Repository\Sensor\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MeasurementCreateService
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private ConstraintViolationListInterface $errors;
    private ?Measurement $measurement;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Security $security,
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    // @todo нужно завести таблицу лицензированных сенсоров, с которой будет происходить сверка мак адресов
    // @todo так же в ней будет указан тип сенсора который и будет присваиваться
    public function __invoke(MeasurementAddDto $measurementDto): Measurement
    {
        $this->measurement = new Measurement(
            $measurementDto->getHumidity(),
            $measurementDto->getPressure(),
            $measurementDto->getCo2(),
            $measurementDto->getTemperature(),
            $measurementDto->getLux(),
            $measurementDto->getDecibel(),
            $measurementDto->getSensor(),
        );

        $this->errors = $this->validator->validate($this->measurement);
        if (count($this->errors) > 0) {
            throw new MeasurementCreateException($this->errors);
        }

        $this->entityManager->persist($this->measurement);
        $this->entityManager->flush();

        return $this->measurement;
    }
}