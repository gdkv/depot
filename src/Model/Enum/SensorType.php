<?php

namespace App\Model\Enum;

enum SensorType: string
{
    use EnumDefaultTrait;

    case Default = "sensor.type.default";
    case Electric = "sensor.type.electric";
    case Aqua = "sensor.type.aqua";
    case Motion = "sensor.type.motion";
    case C02 = "sensor.type.co2";
}