<?php

namespace App\Model\Enum;

enum SensorStatus: string
{
    use EnumDefaultTrait;

    case Online = "sensor.status.online";
    case Offline = "sensor.status.offline";
}