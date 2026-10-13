<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class SensorNotFoundException extends AppException
{
    protected const ERROR_KEY = 'sensor_not_found_or_unactive';
    protected const ERROR_CODE = 7;
    protected const ERROR_MESSAGE = 'Sensor with mac address not found or it is not active';
}