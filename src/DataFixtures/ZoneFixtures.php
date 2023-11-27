<?php

namespace App\DataFixtures;

use App\Entity\Sensor\Zone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Generator;

class ZoneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $i = 0;
        foreach ($this->entities() as $entity) {
            $i++;
            $this->setReference("info-{$i}", $entity);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    private function entities(): Generator
    {
        yield new Zone('Corridor', null, 1, true);
        yield new Zone('Kitchen', null, 2, true);
        yield new Zone('Bath', null, 3, true);
        yield new Zone('Toilet', null, 4, true);
        yield new Zone('Room 1', null, 5, true);
        yield new Zone('Balcony', null, 6, true);
        yield new Zone('Room 2', null, 7, true);
        yield new Zone('Hall', null, 8, true);
        yield new Zone('Room 3', null, 8, true);
    }


}
