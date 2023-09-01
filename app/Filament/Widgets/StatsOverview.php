<?php

namespace App\Filament\Widgets;

use App\Models\FinalProject;
use App\Models\Publication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Tugas Akhir', FinalProject::count()),
            Stat::make('Jurnal', Publication::where('type' , '=', 'jurnal')->count()),
            Stat::make('Prosiding', Publication::where('type', '=', 'prosiding')->count()),
            Stat::make('Pengabdian', Publication::where('type', '=', 'pengabdian')->count()),
            Stat::make('Penelitian', Publication::where('type', '=', 'penelitian')->count())
        ];
    }
}
