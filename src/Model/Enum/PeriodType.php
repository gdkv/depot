<?php

namespace App\Model\Enum;

enum PeriodType: string
{
    use EnumDefaultTrait;

    case Hour = "hour";
    case Day = "day";
    case Week = "week";
    case Month = "month";
    case Quarter = "quarter";
    case Year = "year";
}