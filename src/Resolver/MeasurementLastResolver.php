<?php

namespace App\Resolver;

use App\Entity\Sensor\Sensor;
use App\Model\Dto\MeasurementAddDto;
use App\Model\Dto\MeasurementLastDto;
use App\Model\Dto\MeasurementListDto;
use App\Repository\Sensor\SensorRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class MeasurementLastResolver implements ValueResolverInterface
{
    public function __construct(
        public SensorRepository $sensorRepository,
    ){}


    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (empty($argumentType) || $argument->getType() !== MeasurementLastDto::class) {
            return [];
        }

        $sensor = $request->attributes->get('sensor');

        if (!$sensor instanceof Sensor) {
            $mac = trim((string) $request->query->get('sensor', ''));
            $sensor = $this->sensorRepository->findOneBy([
                'macAddress' => $mac,
                'active' => true,
            ]);
        }

        yield new MeasurementLastDto(
            $sensor
        );
    }
}