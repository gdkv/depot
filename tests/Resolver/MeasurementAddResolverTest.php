<?php

namespace App\Tests\Resolver;

use App\Entity\Sensor\Sensor;
use App\Model\Dto\MeasurementAddDto;
use App\Repository\Sensor\SensorRepository;
use App\Resolver\MeasurementAddResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class MeasurementAddResolverTest extends TestCase
{
    private const MAC_ADDRESS = '00:11:22:33:44:55';

    public function testIgnoresUnknownSensorFields(): void
    {
        $sensor = $this->createMock(Sensor::class);

        $sensorRepository = $this->createMock(SensorRepository::class);
        $sensorRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['active' => true, 'macAddress' => self::MAC_ADDRESS])
            ->willReturn($sensor);

        $request = new Request([], [], [], [], [], [], json_encode([
            'sensor' => self::MAC_ADDRESS,
            'temperature' => 22.3,
            'humidity' => 45.5,
            'pressure' => 760,
            'lux' => 300,
            'decibel' => 30,
            'co2' => 400,
            'motion' => true,
            'gas_resistance_kohm' => 12.5,
        ]));

        $resolver = new MeasurementAddResolver($sensorRepository);

        $result = iterator_to_array($resolver->resolve($request, $this->measurementArgument()));

        self::assertCount(1, $result);
        /** @var MeasurementAddDto $dto */
        $dto = $result[0];
        self::assertInstanceOf(MeasurementAddDto::class, $dto);
        self::assertSame($sensor, $dto->getSensor());
        self::assertSame(22.3, $dto->getTemperature());
        self::assertSame(45.5, $dto->getHumidity());
        self::assertSame(760.0, $dto->getPressure());
        self::assertSame(300.0, $dto->getLux());
        self::assertSame(30.0, $dto->getDecibel());
        self::assertSame(400.0, $dto->getCo2());
    }

    public function testBuildsDtoWhenOptionalSensorFieldsAreMissing(): void
    {
        $sensor = $this->createMock(Sensor::class);

        $sensorRepository = $this->createMock(SensorRepository::class);
        $sensorRepository->expects($this->once())
            ->method('findOneBy')
            ->willReturn($sensor);

        $request = new Request([], [], [], [], [], [], json_encode([
            'sensor' => self::MAC_ADDRESS,
            'temperature' => 22.3,
            'humidity' => 45.5,
            'pressure' => 760,
            'motion' => true,
            'gas_resistance_kohm' => 12.5,
        ]));

        $resolver = new MeasurementAddResolver($sensorRepository);

        $result = iterator_to_array($resolver->resolve($request, $this->measurementArgument()));

        self::assertCount(1, $result);
        /** @var MeasurementAddDto $dto */
        $dto = $result[0];
        self::assertSame($sensor, $dto->getSensor());
        self::assertSame(22.3, $dto->getTemperature());
        self::assertNull($dto->getLux());
        self::assertNull($dto->getDecibel());
        self::assertNull($dto->getCo2());
    }

    private function measurementArgument(): ArgumentMetadata
    {
        return new ArgumentMetadata(
            'measurementDto',
            MeasurementAddDto::class,
            false,
            false,
            null,
        );
    }
}
