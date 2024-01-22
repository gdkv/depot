<?php

namespace App\Resolver;

use App\Model\Dto\LimitDto;
use App\Model\Dto\LimitsDto;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class LimitResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (empty($argumentType) || $argument->getType() !== LimitsDto::class) {
            return [];
        }

        $limitsArray = new ArrayCollection();
        $request->request = new InputBag($request->toArray());
        foreach ($request->request->all('limits') as $limit) {
            $limitsArray->add(new LimitDto(
                $limit['min'],
                $limit['max'],
                $limit['sensorMacAddress'],
                $limit['measurementType'],
            ));
        }

        yield new LimitsDto($limitsArray);
    }
}