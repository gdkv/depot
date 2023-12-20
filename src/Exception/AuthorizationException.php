<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class AuthorizationException extends AppException
{
    protected const ERROR_KEY = 'authorization_exception';
    protected const ERROR_CODE = 4;
    protected const RESPONSE_CODE = Response::HTTP_UNAUTHORIZED;
}