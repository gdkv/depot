<?php

namespace App\DataFixtures;

use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $entity = new User('test@test.com', 'test', ['ROLE_USER',]);
        $entity->setPassword($this->passwordHasher->hashPassword($entity, '1111'));
        $this->setReference("user-1", $entity);
        $manager->persist($entity);
        $manager->flush();

        $entity = new User('admin@test.com', 'admin', ['ROLE_USER',]);
        $entity->setPassword($this->passwordHasher->hashPassword($entity, '1234'));
        $this->setReference("user-2", $entity);
        $manager->persist($entity);
        $manager->flush();

        $entity = new User('manager@test.com', 'manager', ['ROLE_USER',]);
        $entity->setPassword($this->passwordHasher->hashPassword($entity, '4321'));
        $this->setReference("user-3", $entity);
        $manager->persist($entity);
        $manager->flush();

        $entity = new User('dima@test.com', 'dima', ['ROLE_USER',]);
        $entity->setPassword($this->passwordHasher->hashPassword($entity, '1111'));
        $this->setReference("user-4", $entity);
        $manager->persist($entity);
        $manager->flush();
    }
}