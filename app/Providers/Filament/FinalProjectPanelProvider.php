<?php

namespace App\Providers\Filament;

use App\Filament\Auth\CustomLogin;
use App\Filament\FinalProject\Pages\Auth\CustomProfile;
use App\Filament\FinalProject\Resources\FinalProjectResource\Widgets\FinalProjectStudentChart;
use App\Filament\Widgets\AccountOverviewCustom;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class FinalProjectPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->brandLogo(asset('assets/images/logo.png'))
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('favicon.ico'))
            ->id('finalProject')
            ->path('tugas-akhir')
            ->login(CustomLogin::class)
            ->profile(CustomProfile::class)
            ->colors([
                'primary' => Color::Violet,
            ])
            ->discoverResources(in: app_path('Filament/FinalProject/Resources'), for: 'App\\Filament\\FinalProject\\Resources')
            ->discoverPages(in: app_path('Filament/FinalProject/Pages'), for: 'App\\Filament\\FinalProject\\Pages')
            ->discoverWidgets(in: app_path('Filament/FinalProject/Widgets'), for: 'App\\Filament\\FinalProject\\Widgets')
            ->widgets([
                AccountOverviewCustom::class,
                FinalProjectStudentChart::class,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->plugins([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                // \App\Http\Middleware\Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
