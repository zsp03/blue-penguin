<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum HakiStatus: string implements HasLabel, HasColor
{
    case REGISTERED = 'registered';
    case GRANTED = 'granted';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::REGISTERED => __('Registered'),
            self::GRANTED => __('Granted')
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::REGISTERED => Color::Gray,
            self::GRANTED => Color::Emerald
        };
    }
}
