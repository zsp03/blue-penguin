<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AccountOverviewCustom extends Widget
{
    protected static ?int $sort = -3;

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::widgets.account-widget';
}
