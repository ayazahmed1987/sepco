<?php

namespace App\Enums;

enum ProductTabType : int
{
    case GENERIC = 1;
    case SPECIALIZED = 2;

    public function label(): string
    {
        return match($this) {
            self::GENERIC => 'Generic',
            self::SPECIALIZED => 'Specialized',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['id' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
