<?php

namespace App\Tests\Service\Measurement;

use App\Entity\Sensor\Measurement;
use App\Entity\Sensor\Sensor;
use App\Exception\MeasurementCreateException;
use App\Model\Dto\MeasurementAddDto;
use App\Service\Measurement\MeasurementCreateService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MeasurementCreateServiceTest extends TestCase
{
    public function testCreateMeasurement(): void
    {
        $sensor = $this->createMock(Sensor::class);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->exactly(2))
            ->method('validate')
            ->willReturn($this->emptyViolations());

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Measurement::class));
        $entityManager->expects($this->once())->method('flush');

        $measurement = $this->createService($entityManager, $validator)(
            $this->createDto($sensor)
        );

        self::assertInstanceOf(Measurement::class, $measurement);
        self::assertSame(45.5, $measurement->getHumidity());
        self::assertSame(760.0, $measurement->getPressure());
        self::assertSame(400.0, $measurement->getCo2());
        self::assertSame(22.3, $measurement->getTemperature());
        self::assertSame(300.0, $measurement->getLux());
        self::assertSame(30.0, $measurement->getDecibel());
    }

    public function testCreateMeasurementFromNumericStrings(): void
    {
        $sensor = $this->createMock(Sensor::class);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->exactly(2))
            ->method('validate')
            ->willReturn($this->emptyViolations());

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())->method('persist');
        $entityManager->expects($this->once())->method('flush');

        $dto = new MeasurementAddDto(
            $sensor,
            '22.3',
            '45.5',
            '760',
            '300',
            '30',
            '400',
        );

        $measurement = $this->createService($entityManager, $validator)($dto);

        self::assertSame(22.3, $measurement->getTemperature());
        self::assertSame(45.5, $measurement->getHumidity());
        self::assertSame(760.0, $measurement->getPressure());
        self::assertSame(300.0, $measurement->getLux());
        self::assertSame(30.0, $measurement->getDecibel());
        self::assertSame(400.0, $measurement->getCo2());
    }

    public function testThrowsExceptionWhenMeasurementIsInvalid(): void
    {
        $sensor = $this->createMock(Sensor::class);

        $measurementViolations = $this->violationsFor('pressure');
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->exactly(2))
            ->method('validate')
            ->willReturnCallback(
                static function ($value) use ($measurementViolations): ConstraintViolationListInterface {
                    if ($value instanceof MeasurementAddDto) {
                        return new ConstraintViolationList();
                    }

                    return $measurementViolations;
                }
            );

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->never())->method('flush');

        try {
            $this->createService($entityManager, $validator)($this->createDto($sensor));
            self::fail('Ожидалось исключение MeasurementCreateException');
        } catch (MeasurementCreateException $exception) {
            self::assertSame(6, $exception->getErrorCode());
            self::assertSame('invalid value', $exception->getErrorData()['message']);
            self::assertSame('pressure', $exception->getErrorData()['propertyPath']);
        }
    }

    public function testThrowsExceptionWhenSensorIsMissing(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->never())->method('flush');

        $dto = new MeasurementAddDto(
            null,
            22.3,
            45.5,
            760.0,
            300.0,
            30.0,
            400.0,
        );

        try {
            $this->createService($entityManager, $this->createRealValidator())($dto);
            self::fail('Ожидалось исключение MeasurementCreateException');
        } catch (MeasurementCreateException $exception) {
            self::assertSame(6, $exception->getErrorCode());
            self::assertSame('sensor', $exception->getErrorData()['propertyPath']);
            self::assertStringContainsString('blank', $exception->getErrorData()['message']);
        }
    }

    public function testCreateMeasurementWhenDecibelAndCo2AreMissing(): void
    {
        $sensor = $this->createMock(Sensor::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())->method('persist');
        $entityManager->expects($this->once())->method('flush');

        $dto = new MeasurementAddDto(
            $sensor,
            22.3,
            45.5,
            760.0,
            300.0,
            null,
            null,
        );

        $measurement = $this->createService($entityManager, $this->createRealValidator())($dto);

        self::assertSame(22.3, $measurement->getTemperature());
        self::assertSame(45.5, $measurement->getHumidity());
        self::assertSame(760.0, $measurement->getPressure());
        self::assertSame(300.0, $measurement->getLux());
        self::assertNull($measurement->getDecibel());
        self::assertNull($measurement->getCo2());
    }

    public function testCreateMeasurementWhenAllSensorValuesAreMissing(): void
    {
        $sensor = $this->createMock(Sensor::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())->method('persist');
        $entityManager->expects($this->once())->method('flush');

        $dto = new MeasurementAddDto($sensor, null, null, null, null, null, null);

        $measurement = $this->createService($entityManager, $this->createRealValidator())($dto);

        self::assertNull($measurement->getTemperature());
        self::assertNull($measurement->getHumidity());
        self::assertNull($measurement->getPressure());
        self::assertNull($measurement->getLux());
        self::assertNull($measurement->getDecibel());
        self::assertNull($measurement->getCo2());
    }

    private function createService(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ): MeasurementCreateService {
        return new MeasurementCreateService(
            $entityManager,
            $validator,
            $this->createMock(Security::class),
        );
    }

    private function createDto(Sensor $sensor): MeasurementAddDto
    {
        return new MeasurementAddDto(
            $sensor,
            22.3,
            45.5,
            760.0,
            300.0,
            30.0,
            400.0,
        );
    }

    private function createRealValidator(): ValidatorInterface
    {
        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }

    private function emptyViolations(): ConstraintViolationListInterface
    {
        return new ConstraintViolationList();
    }

    private function violationsFor(string $propertyPath): ConstraintViolationListInterface
    {
        return new ConstraintViolationList([
            new ConstraintViolation(
                'invalid value',
                null,
                [],
                null,
                $propertyPath,
                null,
            ),
        ]);
    }
}
