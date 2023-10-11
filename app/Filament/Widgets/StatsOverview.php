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
            Stat::make((__('Final Project')), FinalProject::count()),
            Stat::make((__('Journal')), Publication::where('type' , '=', 'jurnal')->count()),
            Stat::make((__('Proceeding')), Publication::where('type', '=', 'prosiding')->count()),
            Stat::make((__('Service')), Publication::where('type', '=', 'pengabdian')->count()),
            Stat::make((__('Research')), Publication::where('type', '=', 'penelitian')->count())
        ];
    }
}
