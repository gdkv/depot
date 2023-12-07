<?php

namespace App\DataFixtures;

use App\Entity\Sensor\Zone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Generator;

class ZoneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $i = 0;
        foreach ($this->entities() as $entity) {
            $i++;
            $this->setReference("zone-{$i}", $entity);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }

    private function entities(): Generator
    {
        yield new Zone('Corridor', null, 1, true, $this->getReference('user-1'));
        yield new Zone('Kitchen', null, 2, true, $this->getReference('user-1'));
        yield new Zone('Bath', null, 3, true, $this->getReference('user-1'));
        yield new Zone('Toilet', null, 4, true, $this->getReference('user-1'));
        yield new Zone('Room 1', null, 5, true, $this->getReference('user-1'));
        yield new Zone('Balcony', null, 6, true, $this->getReference('user-1'));
        yield new Zone('Room 2', null, 7, true, $this->getReference('user-1'));
        yield new Zone('Hall', null, 8, true, $this->getReference('user-1'));
        yield new Zone('Room 3', null, 8, true, $this->getReference('user-1'));
    }

}
