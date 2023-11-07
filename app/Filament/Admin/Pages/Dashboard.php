<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Widgets;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    public function getColumns(): int|string|array
    {
        return 2;
    }

    public function getWidgets(): array
    {
        return [
            Widgets\AccountOverviewCustom::class,
            Widgets\StatsOverview::class,
            Widgets\FinalProjectChart::class,
            Widgets\PublicationChart::class,
            Widgets\PublicationLineChart::class,
            Widgets\HakiChart::class
        ];
    }
}
