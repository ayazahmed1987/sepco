<?php

namespace App\Enums;

enum TenderAttachmentType : int
{
    case AdvertisementFile = 1;
    case CorrigendumFile = 2;

    public function label(): string
    {
        return match($this) {
            self::AdvertisementFile => 'Advertisement File',
            self::CorrigendumFile => 'Corrigendum File',
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
