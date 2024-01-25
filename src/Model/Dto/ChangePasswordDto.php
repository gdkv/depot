<?php

namespace App\Model\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ChangePasswordDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        private string $newPassword,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        private string $confirmPassword,
    ){}

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

}