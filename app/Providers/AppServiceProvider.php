<?php

namespace App\Providers;

use App\Filament\Auth\CustomLogout;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
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

        $this->app->bind(LogoutResponseContract::class, CustomLogout::class);

        FilamentColor::register([
            'violet' => Color::hex('#6B33AF'),
            'teal' => Color::Teal,
            'sky' => Color::Sky
        ]);

        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->modalWidth('lg')
                ->slideOver()
                ->labels([
                    'publication' => __('Publication'),
                    'finalProject' => __('Final Project'),
                ])
                ->icons([
                    'admin' => 'heroicon-m-users',
                    'publication' => 'heroicon-m-document-text',
                    'finalProject' =>'phosphor-article-fill',
                ])
                ->excludes(fn () => (auth()->user()->role !== '0') ? ['admin'] : []);
        });

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->visible(outsidePanels: true)
                ->flags([
                    'en' => asset('assets/images/us.svg'),
                    'id' => asset('assets/images/id.svg'),
                ])
                ->locales(['en', 'id']); // also accepts a closure
        });
    }
}
