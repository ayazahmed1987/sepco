<?php

namespace App\Enums;

enum MenuRedirectionType: int
{
    case PAGE = 1;
    case ROUTE = 2;
    case EXTERNAL = 3;

    public function label(): string
    {
        return match($this) {
            self::PAGE => 'Redirect to Page',
            self::ROUTE => 'Redirect to Route',
            self::EXTERNAL => 'Redirect to External Link',
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
