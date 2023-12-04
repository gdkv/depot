<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class AppException extends HttpException implements AppExceptionInterface
{
    protected const RESPONSE_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;
    protected const ERROR_KEY = 'errors.internal_error';
    protected const ERROR_CODE = 0;

    protected ?ConstraintViolationListInterface $errorData;

    public function __construct(?ConstraintViolationListInterface $errorData)
    {
        $this->errorData = $errorData;

        parent::__construct(
            $this->getResponseCode(),
            $this->getErrorMessage(),
            null,
            [],
            $this->getErrorCode()
        );

    }

    public function getResponseCode(): int
    {
        return static::RESPONSE_CODE;
    }

    public function getErrorCode(): int
    {
        return static::ERROR_CODE;
    }

    public function getErrorKey(): string
    {
        return static::ERROR_KEY;
    }

    public function getErrorData(): array
    {
        $errorArray = [];
        /* @var ConstraintViolation $errorData */
        foreach($this->errorData as $errorData) {
            $errorArray = [
                'message' => $errorData->getMessage(),
                'propertyPath' => $errorData->getPropertyPath(),
                'invalidValue' => $errorData->getInvalidValue(),
            ];
        }
        return $errorArray;
    }

    public function getErrorMessage(): string
    {
        // $tr = new TranslatableMessage(static::ERROR_KEY, [], 'messages');
        return static::ERROR_KEY;
    }
}