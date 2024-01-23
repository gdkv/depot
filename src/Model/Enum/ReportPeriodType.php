<?php

namespace App\Model\Enum;

enum ReportPeriodType: string
{
    use EnumDefaultTrait;

    case Monthly = "report.period.monthly";
    case Biweekly = "report.period.biweekly";
    case Weekly = "report.period.weekly";
}