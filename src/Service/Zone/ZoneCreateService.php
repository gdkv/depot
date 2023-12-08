<?php

namespace App\Service\Zone;

use App\Entity\Security\User;
use App\Entity\Sensor\Zone;
use App\Exception\UserCreateException;
use App\Exception\ZoneCreateException;
use App\Model\Dto\ZoneDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ZoneCreateService
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private ConstraintViolationListInterface $errors;
    private Security $security;
    private ?Zone $zone;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Security $security,
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->security = $security;
    }

    public function __invoke(ZoneDto $zoneDto): ?Zone
    {
        $this->errors = $this->validator->validate($zoneDto);
        if (count($this->errors) > 0) {
            throw new ZoneCreateException($this->errors);
        }

        $this->zone = new Zone(
            $zoneDto->getName(),
            null,
            true,
            $this->security->getUser(),
        );

        $this->errors = $this->validator->validate($this->zone);
        if (count($this->errors) > 0) {
            throw new ZoneCreateException($this->errors);
        }

        $this->entityManager->persist($this->zone);
        $this->entityManager->flush();

        return $this->zone;
    }

    public function getErrors(): ?ConstraintViolationListInterface
    {
        return $this->errors;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }
}