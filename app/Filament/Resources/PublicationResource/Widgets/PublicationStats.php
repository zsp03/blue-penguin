<?php

namespace App\Filament\Resources\PublicationResource\Widgets;

use App\Models\Publication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PublicationStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jurnal', Publication::where('type' , '=', 'jurnal')->count()),
            Stat::make('Prosiding', Publication::where('type', '=', 'prosiding')->count()),
            Stat::make('Pengabdian', Publication::where('type', '=', 'pengabdian')->count()),
            Stat::make('Penelitian', Publication::where('type', '=', 'penelitian')->count())
        ];
    }
}
