<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class MeasurementsNotFoundException extends AppException
{
    protected const ERROR_KEY = 'no_measurements';
    protected const ERROR_CODE = 8;
    protected const ERROR_MESSAGE = 'Sensor has no measurements yet';
}