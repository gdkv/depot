<?php

namespace App\Resolver;

use App\Model\Dto\MeasurementDto;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class MeasurementResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (empty($argumentType) || $argument->getType() !== MeasurementDto::class) {
            return [];
        }

        $request->request = new InputBag($request->toArray());

        yield new MeasurementDto(
            $request->request->get('sensor'),
            $request->request->get('type'),
            $request->request->get('period'),
        );
    }
}