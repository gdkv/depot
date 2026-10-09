<?php

namespace App\DataFixtures;

use App\Entity\Sensor\Measurement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Generator;
use Random\RandomException;

class MeasurementFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $i = 0;
        foreach ($this->entities() as $entity) {
            $this->setReference("measurement-{$i}", $entity);
            $manager->persist($entity);
            $entity->setCreatedAtToPast($i*5);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SensorFixtures::class,
        ];
    }

    private function entities(): Generator
    {
        for ($i = 0; $i < 100; $i++) {
            yield new Measurement(
                $this->generateHumidity(), $this->generatePressure(),
                $this->generateCO2(), $this->generateTemperature(),
                $this->generateLux(), $this->generateDecibel(),
                $this->getReference('sensor-1')
            );
        }

        for ($i = 0; $i < 100; $i++) {
            yield new Measurement(
                $this->generateHumidity(), $this->generatePressure(),
                $this->generateCO2(), $this->generateTemperature(),
                $this->generateLux(), $this->generateDecibel(),
                $this->getReference('sensor-2')
            );
        }

        for ($i = 0; $i < 100; $i++) {
            yield new Measurement(
                $this->generateHumidity(), $this->generatePressure(),
                $this->generateCO2(), $this->generateTemperature(),
                $this->generateLux(), $this->generateDecibel(),
                $this->getReference('sensor-3')
            );
        }

    }

    /**
     * @throws RandomException
     */
    private function generateHumidity(): float
    {
        // 0% — воздух абсолютно сухой.
        // 100% — воздух насыщен влагой, при дальнейшем повышении влажности начнётся конденсация (роса, туман, запотевание поверхностей).

        return $this->getRandomFloat(20, 60);
    }

    /**
     * @throws RandomException
     */
    private function generatePressure(): float
    {
        // 600 мм рт. ст - Нижняя граница (низкое давление). Во время сильных циклонов или ураганов показатели могут опускаться примерно до 600 мм рт. ст. и ниже. Например, во время урагана в Тихом океане в 1988 году зафиксировали 645 мм рт. ст.. На больших высотах давление тоже заметно меньше: на вершине Эвереста в среднем около 265 мм рт. ст..
        // 740–760 мм рт. ст. - Часто в быту за эталон берут 760 мм рт. ст., но это справедливо только для уровня моря при температуре 0 °C. На деле норма зависит от высоты: с подъёмом над уровнем моря давление падает. Поэтому для Москвы (которая стоит на холмах) «нормальными» обычно считают значения в районе 740–750 мм рт. ст., а, скажем, на высоте 500 метров
        // 800 мм рт. ст - Верхняя граница (высокое давление). При прохождении мощных антициклонов давление может подниматься выше 800 мм рт. ст. и достигать, например, 812,4 мм рт. ст..

        return $this->getRandomFloat(740, 760);
    }

    private function generateCO2(): int
    {
        // Диапазон значений
        // На улице: 350–400 ppm.
        // В помещении (оптимально): 400–800 ppm.
        // 1000–1400 ppm — это повышенная, но допустимая концентрация.
        // В помещении (допустимо, но с оговорками): 800–1400 ppm.
        // Опасно: выше 1400 ppm.

        return 0;
    }

    /**
     * @throws RandomException
     */
    private function generateTemperature(): float
    {
        // Диапазон значений
        // −273,15 °C (абсолютный нуль)
        // +180 °C
        return $this->getRandomFloat(15, 30);
    }

    /**
     * @throws RandomException
     */
    private function generateLux(): float
    {
        // Диапазон значений
        // Около 0 лx — абсолютная темнота (теоретически достижимо лишь на практике значение, близкое к нулю).
        // 0–5 лx — очень тёмные помещения
        // 1–5 лx — начало сумерек.
        // 5–10 лx — затруднено чтение.
        // 10–50 лx — сад.
        // 50–100 лx — магистральное освещение
        // 10 000–25 000 лx — утренний солнечный свет.
        // 50 000–100 000 лx — яркий солнечный день.
        // 90 000–120 000 лx — прямой солнечный свет в ясный день.

        return $this->getRandomFloat(0, 100);

    }

    /**
     * @throws RandomException
     */
    private function generateDecibel(): float
    {
        // Диапазон значений
        // 20 дБ — это шёпот.
        // 40–50 дБ — тихая комната.
        // 60–70 дБ — обычный разговор.
        // 80 дБ — будильник, шум улицы.
        // 100 дБ и выше — очень громкий звук (например, концерт, мотоцикл).
        // 120–140 дБ — болевой порог (звук, способный повредить слух).

        return $this->getRandomFloat(10, 80);
    }


    /**
     * @throws RandomException
     */
    private function getRandomFloat(int $min, int $max): float
    {
        return $min + random_int(0, 100) / (100 / ($max - $min));
    }
}
