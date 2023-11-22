<?php

namespace App\Service\Security\User;

use App\Entity\Security\User;
use App\Exception\UserCreateException;
use App\Model\Dto\UserDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserCreateService
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private ConstraintViolationListInterface $errors;
    private ?User $user;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function __invoke(UserDto $userDto): bool
    {
        $this->errors = $this->validator->validate($userDto);
        if (count($this->errors) > 0) {
            throw new UserCreateException($this->errors);
        }

        $this->user = new User(
            $userDto->getEmail(),
            $userDto->getName(),
            $userDto->getPassword(),
            ['ROLE_USER']
        );
        $this->errors = $this->validator->validate($this->user);
        if (count($this->errors) > 0) {
            throw new UserCreateException($this->errors);
        }
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
        return true;
    }

    public function getErrors(): ?ConstraintViolationListInterface
    {
        return $this->errors;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}