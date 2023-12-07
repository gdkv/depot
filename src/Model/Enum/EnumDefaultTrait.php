<?php

namespace App\Model\Enum;

trait EnumDefaultTrait
{
    public static function toArray(): array
    {
        $values = [];

        foreach (self::cases() as $props) {
            $values[] = $props->value;
        }

        return $values;
    }
}