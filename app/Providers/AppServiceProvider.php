<?php

namespace App\Providers;

use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        FilamentColor::register([
            'violet' => Color::hex('#6B33AF')
        ]);

        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->modalWidth('lg')
                ->slideOver()
                ->labels([
                    'publication' => 'Publikasi',
                    'finalProject' => 'Tugas Akhir',
                ])
                ->icons([
                    'admin' => 'heroicon-m-users',
                    'publication' => 'heroicon-m-document-text',
                    'finalProject' =>'phosphor-article-fill',
                ]);
        });
    }
}
