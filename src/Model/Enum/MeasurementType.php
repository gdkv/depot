<?php

namespace App\Model\Enum;

enum MeasurementType: string
{
    use EnumDefaultTrait;

    case Temperature = "temperature";
    case Humidity = "humidity";
    case Lux = "lux";
    case Noise = "decibel";
    case Pressure = "pressure";
    case CO2 = "co2";
}