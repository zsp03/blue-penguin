<?php

namespace App\Filament\Publication\Resources\PublicationResource\Pages;

use App\Filament\Publication\Resources\PublicationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreatePublication extends CreateRecord
{
    protected static string $resource = PublicationResource::class;
    public function getTitle(): string|Htmlable
    {
        return (__('Make Publication'));
    }
}
