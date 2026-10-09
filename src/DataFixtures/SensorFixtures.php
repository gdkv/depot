<?php

namespace App\DataFixtures;

use App\Entity\Sensor\Sensor;
use App\Model\Enum\SensorType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Generator;

class SensorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $i = 0;
        foreach ($this->entities() as $entity) {
            $i++;
            $this->setReference("sensor-{$i}", $entity);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ZoneFixtures::class,
            UserFixtures::class
        ];
    }

    private function entities(): Generator
    {
        yield new Sensor(
            'Sensor 1',
            'a0-20-a6-11-b9-f3',
            'test comment 1',
            $this->getReference('user-1'),
            $this->getReference('zone-1'),
            SensorType::Default,
            null,
            null
        );

        yield new Sensor(
            'Sensor 2',
            'bc-dd-88-ed-4d-ff',
            'test comment 2',
            $this->getReference('user-1'),
            $this->getReference('zone-1'),
            SensorType::Default,
            null,
            null
        );

        yield new Sensor(
            'Sensor 3',
            'dd-a3-cd-ff-56-9a',
            'test comment 3',
            $this->getReference('user-2'),
            $this->getReference('zone-1'),
            SensorType::Default,
            null,
            null
        );
    }
}
