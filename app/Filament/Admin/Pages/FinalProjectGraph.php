<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Widgets;
use Filament\Pages\Page;

class FinalProjectGraph extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static string $view = 'filament.admin.pages.final-project-graph';
    protected static ?string $title = '';
    public static function getNavigationLabel(): string
    {
        return __('Final Project Graph');
    }

    protected static ?string $navigationGroup = 'Statistics';
    public static function getNavigationGroup(): ?string
    {
        return __('Statistics');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\FinalProjectStudentApexChart::class,
        ];
    }
}
