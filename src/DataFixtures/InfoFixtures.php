<?php

namespace App\DataFixtures;

use App\Entity\Sensor\Info;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Generator;

class InfoFixtures extends Fixture
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
        for ($i = 0; $i < 100; $i++) {
            yield new Info($this->generateHumidity(), $this->generatePressure(), $this->generateCO2(),
                $this->generateTemperature(), $this->generateLux(), $this->generateDecibel());
        }

    }

    private function generateHumidity(): float
    {
        return $this->getRandomFloat(20, 60);
    }

    private function generatePressure(): float
    {
        return $this->getRandomFloat(740, 760);
    }

    private function generateCO2(): float
    {
        return 0.0;
    }

    private function generateTemperature(): float
    {
        return $this->getRandomFloat(15, 30);
    }

    private function generateLux(): float
    {
        return $this->getRandomFloat(0, 100);

    }

    private function generateDecibel(): float
    {
        return $this->getRandomFloat(-100, 80);
    }


    private function getRandomFloat(int $min, int $max): float
    {
        return $min + rand(0, 100) / (100 / ($max - $min));
    }
}
