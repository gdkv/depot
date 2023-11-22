<?php

namespace App\Model\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    public function __construct(
        #[Assert\Email]
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        private readonly string $email,

        #[Assert\Type('string')]
        private readonly string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        private readonly string $password,
    ){}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}