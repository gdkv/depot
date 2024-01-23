<?php

namespace App\Model\Enum;

enum AccountType: string
{
    use EnumDefaultTrait;

    case Start = "account.type.start";
    case Pro = "account.type.pro";
    case Ultimate = "account.type.ultimate";
}