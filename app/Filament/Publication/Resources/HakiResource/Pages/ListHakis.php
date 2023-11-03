<?php

namespace App\Filament\Publication\Resources\HakiResource\Pages;

use App\Filament\Publication\Resources\HakiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHakis extends ListRecords
{
    protected static string $resource = HakiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
