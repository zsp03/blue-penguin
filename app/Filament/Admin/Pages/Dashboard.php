<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    public function getColumns(): int|string|array
    {
        return 2;
    }
}
