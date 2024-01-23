<?php

namespace App\Model\Enum;

enum AccessLevelType: string
{
    use EnumDefaultTrait;

    case Private = "sensor.access.private";
    case Guest = "sensor.access.guest";
    case Link = "sensor.access.link";
    case Public = "sensor.access.public";
}