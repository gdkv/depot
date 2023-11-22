<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface AppExceptionInterface
{
    public function getResponseCode(): int;

    public function getErrorCode(): int;

    public function getErrorKey(): string;

    public function getErrorData(): array;

    public function getErrorMessage(): string;
}