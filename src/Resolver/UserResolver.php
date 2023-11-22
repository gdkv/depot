<?php

namespace App\Resolver;

use App\Model\Dto\UserDto;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class UserResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (empty($argumentType) || $argument->getType() !== UserDto::class) {
            return [];
        }

        $request->request = new InputBag($request->toArray());

        yield new UserDto(
            $request->request->get('email'),
            $request->request->get('name'),
            $request->request->get('password'),
        );
    }
}