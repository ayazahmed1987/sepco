<?php

namespace App\Enums;

enum PageComponentType: int
{
    case DYNAMIC = 1;
    case STATIC = 2;

    public function label(): string
    {
        return match($this) {
            self::DYNAMIC => 'Dynamic Component',
            self::STATIC => 'Static Components',
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
