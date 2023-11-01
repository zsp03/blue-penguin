<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PublicationType: string implements HasLabel, HasColor
{
    case JOURNAL = 'jurnal';
    case PROCEEDING = 'prosiding';
    case RESEARCH = 'penelitian';
    case SERVICE = 'pengabdian';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::JOURNAL => __('Journal'),
            self::PROCEEDING => __('Proceeding'),
            self::RESEARCH => __('Research'),
            self::SERVICE => __('Service')
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::JOURNAL => 'success',
            self::PROCEEDING => 'gray',
            self::RESEARCH => 'info',
            self::SERVICE => 'violet'
        };
    }
}
