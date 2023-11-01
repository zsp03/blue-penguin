<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PublicationScale: string implements HasLabel, HasColor, HasIcon
{
    case NATIONAL = 'nasional';
    case INTERNATIONAL = 'internasional';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NATIONAL => __('National'),
            self::INTERNATIONAL => __('International')
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::NATIONAL => Color::Teal,
            self::INTERNATIONAL => Color::Sky
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::NATIONAL => 'heroicon-m-flag',
            self::INTERNATIONAL => 'heroicon-s-globe-americas'
        };
    }
}
