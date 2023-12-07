<?php

namespace App\Resolver;

use App\Model\Dto\SensorDto;
use App\Model\Dto\ZoneDto;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ZoneResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (empty($argumentType) || $argument->getType() !== ZoneDto::class) {
            return [];
        }

        $request->request = new InputBag($request->toArray());

        yield new ZoneDto(
            $request->request->get('name'),
        );
    }
}