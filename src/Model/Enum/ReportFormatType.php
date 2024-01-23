<?php

namespace App\Model\Enum;

enum ReportFormatType: string
{
    use EnumDefaultTrait;

    case Pdf = "report.format.pdf";
    case Csv = "report.format.csv";
    case Xml = "report.format.xml";
    case Yml = "report.format.yml";
}