<?php

namespace App\Enum;

trait EnumRenderer
{
    public static function renderValues(): array
    {
        $enums =  self::cases();

        return collect($enums)->map(function ($enum) {
            return $enum->description();
        })->toArray();
    }

    public static function commaSeparated(): string
    {
        return implode(',', self::renderValues());
    }
}
