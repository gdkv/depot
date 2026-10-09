<?php

namespace App\Resolver;

use App\Model\Dto\SensorDto;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class SensorResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (empty($argumentType) || $argument->getType() !== SensorDto::class) {
            return [];
        }

        $request->request = new InputBag($request->toArray());

        yield new SensorDto(
            $request->request->get('name'),
            $request->request->get('macAddress'),
            $request->request->get('comment', ''),
            $request->request->get('zoneUuid'),
            $request->request->get('sensorType', 'sensor.type.default'),
            $request->request->get('position', 100),
        );
    }
}