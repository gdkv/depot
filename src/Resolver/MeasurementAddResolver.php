<?php

namespace App\Resolver;

use App\Model\Dto\MeasurementAddDto;
use App\Model\Dto\MeasurementListDto;
use App\Repository\Sensor\SensorRepository;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class MeasurementAddResolver implements ValueResolverInterface
{
    public function __construct(
        public SensorRepository $sensorRepository,
    ){}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (empty($argumentType) || $argument->getType() !== MeasurementAddDto::class) {
            return [];
        }

        $request->request = new InputBag($request->toArray());

        $sensor = $this->sensorRepository->findOneBy([
            'active' => true,
            'macAddress' => $request->request->get('sensor'),
        ]);

        yield new MeasurementAddDto(
            $sensor,
            $request->request->get('temperature'),
            $request->request->get('humidity'),
            $request->request->get('pressure'),
            $request->request->get('lux'),
            $request->request->get('decibel'),
            $request->request->get('co2'),
        );
    }
}