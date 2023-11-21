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
            self::PATEN => __('Patent'),
            self::MEREK => __('Brand'),
            self::DESAIN_INDUSTRI => __('Industrial Design'),
            self::HAK_CIPTA => __('Copyright'),
            self::INDIKASI_GEOGRAFIS => __('Geographical Indication'),
            self::RAHASIA_DAGANG => __('Trade Secret'),
            self::DESAIN_TATA_LETAK_SIRKUIT_TERPADU => __('Layout Design'),
            self::UNCATEGORIZED => __('Uncategorized')
        };
    }
}
