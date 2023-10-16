<?php

namespace App\Filament\Publication\Resources\PublicationResource\Widgets;

use App\Models\Publication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PublicationStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make((__('Journal')), Publication::where('type' , '=', 'jurnal')->count()),
            Stat::make((__('Proceeding')), Publication::where('type', '=', 'prosiding')->count()),
            Stat::make((__('Service')), Publication::where('type', '=', 'pengabdian')->count()),
            Stat::make((__('Research')), Publication::where('type', '=', 'penelitian')->count())
        ];
    }
}
