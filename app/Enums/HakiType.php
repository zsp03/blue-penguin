<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HakiType: string implements HasLabel
{
    case PATEN = 'paten';
    case MEREK = 'merek';
    case DESAIN_INDUSTRI = 'desain_industri';
    case HAK_CIPTA = 'hak_cipta';
    case INDIKASI_GEOGRAFIS = 'indikasi_geografis';
    case RAHASIA_DAGANG = 'rahasia_dagang';
    case DESAIN_TATA_LETAK_SIRKUIT_TERPADU = 'desain_tata_letak_sirkuit_terpadu';
    case UNCATEGORIZED = 'Uncategorized';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PATEN => __('Paten'),
            self::MEREK => __('Merek'),
            self::DESAIN_INDUSTRI => __('Desain Industri'),
            self::HAK_CIPTA => __('Hak Cipta'),
            self::INDIKASI_GEOGRAFIS => __('Indikasi Geografis'),
            self::RAHASIA_DAGANG => __('Rahasia Dagang'),
            self::DESAIN_TATA_LETAK_SIRKUIT_TERPADU => __('Desain Tata Letak Sirkuit Terpadu'),
            self::UNCATEGORIZED => __('Uncategorized')
        };
    }
}
