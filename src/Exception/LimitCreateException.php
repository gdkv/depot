<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class LimitCreateException extends AppException
{
    protected const ERROR_KEY = 'limit_create_exception';
    protected const ERROR_CODE = 5;
}