<?php

namespace App\Filament\Auth;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as BaseLogout;
use Illuminate\Http\RedirectResponse;

class CustomLogout implements BaseLogout
{

    public function toResponse($request): RedirectResponse
    {
        return redirect()->to(route('starting-menu'));
    }
}
