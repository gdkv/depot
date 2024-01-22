<?php

namespace App\Service\Limit;

use App\Entity\Sensor\Limit;
use App\Exception\LimitCreaqteqException;
use App\Exception\LimitCreateException;
use App\Exception\SensorCreateException;
use App\Model\Dto\LimitDto;
use App\Model\Dto\LimitsDto;
use App\Model\Enum\MeasurementType;
use App\Repository\Sensor\SensorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LimitCreateService
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private ConstraintViolationListInterface $errors;
    private ?Limit $limit;
    private SensorRepository $sensorRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        SensorRepository $sensorRepository,
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->sensorRepository = $sensorRepository;
        $this->limit = null;
    }

    public function __invoke(LimitsDto $limitsDto): bool
    {
        if($limitsDto->getLimits()->count()) {
            /* @var LimitDto $limitDto */
            foreach ($limitsDto->getLimits() as $limitDto) {
                $this->errors = $this->validator->validate($limitDto);

                if (count($this->errors) > 0) {
                    throw new LimitCreateException($this->errors);
                }

                $sensor = null;

                if ($limitDto->getSensorMacAddress()) {
                    $sensor = $this->sensorRepository->findOneBy(['macAddress' => $limitDto->getSensorMacAddress()]);
                    if ($sensor === null) {
                        $this->errors = $this->getLimitNotFoundConstraint($limitDto->getSensorMacAddress());
                        throw new LimitCreateException($this->errors);
                    }
                }

                $this->limit = new Limit(
                    MeasurementType::tryFrom($limitDto->getMeasurementType()),
                    $limitDto->getMin(),
                    $limitDto->getMax(),
                    $sensor
                );

                $this->errors = $this->validator->validate($this->limit);
                if (count($this->errors) > 0) {
                    throw new LimitCreateException($this->errors);
                }

                $this->entityManager->persist($this->limit);
            }

            $this->entityManager->flush();
        } else {
            $this->errors = $this->getLimitEmptyArrayConstraint();
            throw new LimitCreateException($this->errors);
        }

        return true;
    }

    private function getLimitNotFoundConstraint(string $sensorUuid): ConstraintViolationListInterface
    {
        return new ConstraintViolationList([
            new ConstraintViolation(
                'sensor not found',
                null,
                [],
                $sensorUuid,
                'sensorUuid',
                $sensorUuid,
                null,
                'sensor.not.found',
                null,
                null
            ),
        ]);
    }

    private function getLimitEmptyArrayConstraint(): ConstraintViolationListInterface
    {
        return new ConstraintViolationList([
            new ConstraintViolation(
                'limits array collection is empty',
                null,
                [],
                'LimitsDto',
                'limits',
                '[]',
                null,
                'limits.is.empty',
                null,
                null
            ),
        ]);
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}