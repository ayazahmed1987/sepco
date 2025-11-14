<?php

namespace App\Enums;

enum ComponentModelList: string
{
    case Team = 'Models\Team';

    public function label(): string
    {
        return match($this) {
            self::Team => 'Teams Section',
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
