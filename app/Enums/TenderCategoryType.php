<?php

namespace App\Enums;

enum TenderCategoryType : int
{
    case GOODS = 1;
    case SERVICES = 2;
    case GOODSANDSERVICES = 3;

    public function label(): string
    {
        return match($this) {
            self::GOODS => 'Goods',
            self::SERVICES => 'Services',
            self::GOODSANDSERVICES => 'Goods & Services',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }
}
