<?php

namespace App\Tests\Service\Sensor;

use App\Entity\Security\User;
use App\Entity\Sensor\Sensor;
use App\Entity\Sensor\Zone;
use App\Exception\SensorCreateException;
use App\Model\Dto\SensorDto;
use App\Model\Enum\SensorType;
use App\Repository\Sensor\ZoneRepository;
use App\Service\Sensor\SensorCreateService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SensorCreateServiceTest extends TestCase
{
    private const VALID_MAC = 'BC-DD-88-ED-4D-FF';

    public function testCreateSensorWithoutZone(): void
    {
        $user = $this->createMock(User::class);

        $security = $this->createMock(Security::class);
        $security->method('getUser')->willReturn($user);

        $zoneRepository = $this->createMock(ZoneRepository::class);
        $zoneRepository->expects($this->never())->method('find');

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('validate')->willReturn($this->emptyViolations());

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Sensor::class));
        $entityManager->expects($this->once())->method('flush');

        $sensor = $this->createService($entityManager, $validator, $security, $zoneRepository)(
            $this->createDto()
        );

        self::assertInstanceOf(Sensor::class, $sensor);
        self::assertSame('Sensor name', $sensor->getName());
        self::assertSame(self::VALID_MAC, $sensor->getMacAddress());
        self::assertSame('some comment', $sensor->getComment());
        self::assertSame($user, $sensor->getUser());
        self::assertNull($sensor->getZone());
        self::assertSame(SensorType::Default, $sensor->getType());
        self::assertSame(100, $sensor->getPosition());
        self::assertTrue($sensor->getActive());
    }

    public function testCreateSensorWithExistingZone(): void
    {
        $user = $this->createMock(User::class);
        $zoneUuid = Uuid::v4()->toRfc4122();
        $zone = new Zone('Zone name', 1, true, $user);

        $security = $this->createMock(Security::class);
        $security->method('getUser')->willReturn($user);

        $zoneRepository = $this->createMock(ZoneRepository::class);
        $zoneRepository->expects($this->once())
            ->method('find')
            ->with($zoneUuid)
            ->willReturn($zone);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('validate')->willReturn($this->emptyViolations());

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())->method('persist');
        $entityManager->expects($this->once())->method('flush');

        $sensor = $this->createService($entityManager, $validator, $security, $zoneRepository)(
            $this->createDto($zoneUuid)
        );

        self::assertSame($zone, $sensor->getZone());
    }

    public function testThrowsExceptionWhenZoneNotFound(): void
    {
        $user = $this->createMock(User::class);
        $zoneUuid = Uuid::v4()->toRfc4122();

        $security = $this->createMock(Security::class);
        $security->method('getUser')->willReturn($user);

        $zoneRepository = $this->createMock(ZoneRepository::class);
        $zoneRepository->expects($this->once())
            ->method('find')
            ->with($zoneUuid)
            ->willReturn(null);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('validate')->willReturn($this->emptyViolations());

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->never())->method('flush');

        try {
            $this->createService($entityManager, $validator, $security, $zoneRepository)(
                $this->createDto($zoneUuid)
            );
            self::fail('Ожидалось исключение SensorCreateException');
        } catch (SensorCreateException $exception) {
            self::assertSame(2, $exception->getErrorCode());
            self::assertSame('zone not found', $exception->getErrorData()['message']);
            self::assertSame('zoneUuid', $exception->getErrorData()['propertyPath']);
        }
    }

    public function testThrowsExceptionWhenDtoIsInvalid(): void
    {
        $security = $this->createMock(Security::class);
        $security->expects($this->never())->method('getUser');

        $zoneRepository = $this->createMock(ZoneRepository::class);
        $zoneRepository->expects($this->never())->method('find');

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->willReturn($this->violationsFor('macAddress'));

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->never())->method('flush');

        $this->expectException(SensorCreateException::class);

        $this->createService($entityManager, $validator, $security, $zoneRepository)(
            $this->createDto()
        );
    }

    public function testThrowsExceptionWhenSensorIsInvalid(): void
    {
        $user = $this->createMock(User::class);

        $security = $this->createMock(Security::class);
        $security->method('getUser')->willReturn($user);

        $zoneRepository = $this->createMock(ZoneRepository::class);
        $zoneRepository->expects($this->never())->method('find');

        $sensorViolations = $this->violationsFor('macAddress');
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->exactly(2))
            ->method('validate')
            ->willReturnCallback(
                static function ($value) use ($sensorViolations): ConstraintViolationListInterface {
                    if ($value instanceof SensorDto) {
                        return new ConstraintViolationList();
                    }

                    return $sensorViolations;
                }
            );

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->never())->method('flush');

        $this->expectException(SensorCreateException::class);

        $this->createService($entityManager, $validator, $security, $zoneRepository)(
            $this->createDto()
        );
    }

    /**
     * @dataProvider provideInvalidMacAddresses
     */
    public function testThrowsExceptionWhenMacAddressIsInvalid(string $macAddress): void
    {
        $security = $this->createMock(Security::class);
        $security->expects($this->never())->method('getUser');

        $zoneRepository = $this->createMock(ZoneRepository::class);
        $zoneRepository->expects($this->never())->method('find');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->never())->method('flush');

        $dto = new SensorDto(
            'Sensor name',
            $macAddress,
            'some comment',
            null,
            SensorType::Default->value,
            100,
        );

        try {
            $this->createService(
                $entityManager,
                $this->createRealValidator(),
                $security,
                $zoneRepository
            )($dto);
            self::fail('Ожидалось исключение SensorCreateException');
        } catch (SensorCreateException $exception) {
            self::assertSame(2, $exception->getErrorCode());
            self::assertSame('macAddress', $exception->getErrorData()['propertyPath']);
            self::assertStringContainsString('not a valid mac address', $exception->getErrorData()['message']);
        }
    }

    public function provideInvalidMacAddresses(): array
    {
        return [
            'буквы' => ['invalid-mac'],
            'пропущен октет' => ['00:11:22:33:44'],
            'недопустимые символы' => ['zz:zz:zz:zz:zz:zz'],
            'слишком много символов' => ['00:11:22:33:44:55:66'],
            'без разделителей' => ['00112233445566'],
        ];
    }

    private function createService(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Security $security,
        ZoneRepository $zoneRepository,
    ): SensorCreateService {
        return new SensorCreateService($entityManager, $validator, $security, $zoneRepository);
    }

    private function createDto(?string $zoneUuid = null): SensorDto
    {
        return new SensorDto(
            'Sensor name',
            self::VALID_MAC,
            'some comment',
            $zoneUuid,
            SensorType::Default->value,
            100,
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
